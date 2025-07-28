<?php
/**
 * Copyright 2017 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Spanner\Session;

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Lock\FlockLock;
use Google\Cloud\Core\Lock\LockInterface;
use Google\Cloud\Core\Lock\SemaphoreLock;
use Google\Cloud\Core\SysvTrait;
use Google\Cloud\Spanner\Database;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\RejectionException;
use GuzzleHttp\Promise\Utils;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * This session pool implementation accepts a PSR-6 compatible cache
 * implementation and utilizes it to store sessions between requests.
 *
 * We provide `Google\Auth\Cache\SysVCacheItemPool`, which is a fast PSR-6
 * implementation in `google/auth` library. If your PHP has `sysvshm`
 * extension enabled (most binary distributions have it compiled in), consider
 * using it. Please note the SysVCacheItemPool implementation defaults to a
 * memory allotment that may not meet your requirements. We recommend setting
 * the memsize setting to 250000 (250kb) as it should safely contain the default
 * 500 maximum sessions the pool can handle. Please modify this value
 * accordingly depending on the number of maximum sessions you would like
 * for the pool to handle.
 *
 * Please note that when
 * {@see \Google\Cloud\Spanner\Session\CacheSessionPool::acquire()} is called at
 * most only a single session is created. Due to this, it is possible to sit
 * under the minimum session value declared when constructing this instance. In
 * order to have the pool match the minimum session value please use the
 * {@see \Google\Cloud\Spanner\Session\CacheSessionPool::warmup()} method. This
 * will create as many sessions as needed to match the minimum value, and is the
 * recommended way to bootstrap the session pool.
 *
 * Sessions are created on demand up to the maximum session value set during
 * instantiation of the pool. To help ensure the minimum number of sessions
 * required are managed by the pool, attempts will be made to automatically
 * downsize after every 10 minute window. This feature is configurable and one
 * may also downsize at their own choosing via
 * {@see \Google\Cloud\Spanner\Session\CacheSessionPool::downsize()}. Downsizing
 * will help ensure you never run into issues where the Spanner backend is
 * locked up after having met the maximum number of sessions assigned per node.
 * For reference, the current maximum sessions per database per node is 10k. For
 * more information on limits please see
 * [here](https://cloud.google.com/spanner/docs/limits).
 *
 * When expecting a long period of inactivity (such as a
 * maintenance window), please make sure to call
 * {@see \Google\Cloud\Spanner\Session\CacheSessionPool::clear()} in order to
 * delete any active sessions.
 *
 * If you're on Windows, or your PHP doesn't have `sysvshm` extension,
 * unfortunately you can not use `Google\Auth\Cache\SysVCacheItemPool`. In such
 * cases, it will be necessary to include a separate dependency to fulfill
 * this requirement. The below example makes use of
 * [Symfony's Cache Component](https://github.com/symfony/cache). For more
 * implementations please see the [Packagist PHP Package
 * Repository](https://packagist.org/providers/psr/cache-implementation).
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 * use Google\Cloud\Spanner\Session\CacheSessionPool;
 * use Symfony\Component\Cache\Adapter\FilesystemAdapter;
 *
 * $spanner = new SpannerClient(['projectId' => 'my-project']);
 * $cache = new FilesystemAdapter();
 * $sessionPool = new CacheSessionPool($cache);
 *
 * $database = $spanner->connect('my-instance', 'my-database', [
 *     'sessionPool' => $sessionPool
 * ]);
 * ```
 *
 * ```
 * // Labels configured on the pool will be applied to each session created by the pool.
 * use Google\Cloud\Spanner\Session\CacheSessionPool;
 * use Symfony\Component\Cache\Adapter\FilesystemAdapter;
 *
 * $cache = new FilesystemAdapter();
 * $sessionPool = new CacheSessionPool($cache, [
 *     'labels' => [
 *         'environment' => getenv('APPLICATION_ENV')
 *     ]
 * ]);
 * ```
 *
 * Database role configured on the pool will be applied to each session created by the pool.
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 * use Google\Cloud\Spanner\Session\CacheSessionPool;
 * use Symfony\Component\Cache\Adapter\FilesystemAdapter;
 *
 * $spanner = new SpannerClient(['projectId' => 'my-project']);
 * $cache = new FilesystemAdapter();
 * $sessionPool = new CacheSessionPool($cache, [
 *     'databaseRole' => 'Reader'
 * ]);
 *
 * $database = $spanner->connect('my-instance', 'my-database', [
 *     'sessionPool' => $sessionPool
 * ]);
 * ```
 */
class CacheSessionPool implements SessionPoolInterface
{
    use SysvTrait;

    public const CACHE_KEY_TEMPLATE = 'cache-session-pool.%s.%s.%s';
    private const DURATION_SESSION_LIFETIME = 28 * 24 * 3600; // 28 days

    /**
     * @var CacheItemPoolInterface
     */
    private $cacheItemPool;

    /**
     * @var string|null
     */
    private $cacheKey;

    private LockInterface $lock;

    /**
     * @var Database|null
     */
    private $database;

    /**
     * @var PromiseInterface[]
     */
    private $deleteCalls = [];

    /**
     * @var array
     */
    private $deleteQueue = [];

    private string $databaseRole;

    /**
     * @param CacheItemPoolInterface $cacheItemPool A PSR-6 compatible cache
     *        implementation used to store the session data.
     * @param array $config [optional] {
     *     Configuration Options.
     *
     *     @type LockInterface $lock A lock implementation capable of blocking.
     *           **Defaults to** a semaphore based implementation if the
     *           required extensions are installed, otherwise an flock based
     *           implementation.
     *     @type string $databaseRole The user created database role which creates the session.
     * }
     * @throws \InvalidArgumentException
     */
    public function __construct(
        CacheItemPoolInterface $cacheItemPool,
        array $config = []
    ) {
        $this->cacheItemPool = $cacheItemPool;
        if (isset($config['lock']) && !$config['lock'] instanceof LockInterface) {
            throw new \InvalidArgumentException('The lock must implement ' . LockInterface::class);
        }

        $this->lock = $config['lock'] ?? $this->getDefaultLock();
        $this->databaseRole = $config['databaseRole'] ?? '';
    }

    /**
     * Acquire a session from the pool.
     *
     * @param string $context The type of session to fetch. May be either `r`
     *        (READ) or `rw` (READ/WRITE). **Defaults to** `r`.
     * @return Session
     * @throws \RuntimeException
     */
    public function acquire(Database $database): Session
    {
        $identity = $database->identity();
        $cacheKey = sprintf(
            self::CACHE_KEY_TEMPLATE,
            $identity['projectId'],
            $identity['instance'],
            $identity['database']
        );

        // Try to get a session, run maintenance on the pool, and calculate if
        // we need to create any new sessions.
        return $this->lock->synchronize(function () use ($cacheKey, $database) {
            $item = $this->cacheItemPool->getItem($cacheKey);
            if (!$session = $item->get()) {
                $session = $database->createSession();
                $expiresAt = $session->getCreateTime()->getSeconds() + self::SESSION_EXPIRATION_SECONDS;
                $item->set($session);
                $item->expiresAt($expiresAt);
                $this->save($item);
            }

            return $session;
        });
    }

    /**
     * Release a session back to the pool.
     *
     * @param Session $session The session.
     * @throws \RuntimeException
     */
    public function release(Session $session)
    {
        // Multiplexed sessions do not need to be released
        // @TODO: Remove this method
    }

    /**
     * Keeps a checked out session alive.
     *
     * In use sessions that have not had their `lastActive` time updated
     * in the last 20 minutes will be considered eligible to be moved back into
     * the queue if the max sessions value has been met. In order to work around
     * this when performing a large streaming execute or read call please make
     * sure to call this method roughly every 15 minutes between reading rows
     * to keep your session active.
     *
     * @param Session $session The session to keep alive.
     * @throws \RuntimeException
     */
    public function keepAlive(Session $session)
    {
        // Multiplexed sessions do not need to be kept alive
        // @TODO: Remove this method
    }

    /**
     * Downsizes the queue of available sessions by the given percentage. This is
     * relative to the minimum sessions value. For example: Assuming a full
     * queue, with maximum sessions of 10 and a minimum of 2, downsizing by 50%
     * would leave 6 sessions in the queue. The count of items to be deleted will
     * be rounded up in the case of a fraction.
     *
     * Please note this method will attempt to synchronously delete sessions and
     * will block until complete.
     *
     * @param int $percent The percentage to downsize the pool by. Must be
     *        between 1 and 100.
     * @return int The number of sessions removed from the pool.
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function downsize($percent)
    {
        // Multiplexed sessions do not need to be downsized
        // @TODO: Remove this method
        return 0;
    }

    /**
     * Create enough sessions to meet the minimum session constraint.
     *
     * @return int The number of sessions created and added to the queue.
     * @throws \RuntimeException
     */
    public function warmup()
    {
        // Multiplexed sessions do not need warmup
        // @TODO: Remove this method
        return 0;
    }

    /**
     * Clear the cache and attempt to delete all sessions in the pool.
     *
     * A session may be removed from the cache, but still tracked as active by
     * the Spanner backend if a delete operation failed. To ensure you do not
     * exceed the maximum number of sessions available per node, please be sure
     * to check the return value of this method to be certain all sessions have
     * been deleted.
     * @return bool Returns false if some delete operations failed to delete.
     *        True if $waitForPromises flag is false or all delete are successful.
     */
    public function clear()
    {
        // Multiplexed sessions do not need to be cleared
        // @TODO: Remove this method
        return true;
    }

    /**
     * Set the database used to make calls to manage sessions.
     *
     * @param Database $database The database.
     */
    public function setDatabase(Database $database)
    {

    }

    /**
     * Get the underlying cache implementation.
     *
     * @return CacheItemPoolInterface
     */
    public function cacheItemPool()
    {
        return $this->cacheItemPool;
    }

    /**
     * Get the current unix timestamp.
     *
     * @return int
     */
    protected function time()
    {
        return time();
    }

    /**
     * Get the default lock.
     *
     * @return LockInterface
     */
    private function getDefaultLock()
    {
        if ($this->isSysvIPCLoaded()) {
            return new SemaphoreLock(
                $this->getSysvKey(crc32($this->cacheKey))
            );
        }

        return new FlockLock($this->cacheKey);
    }

    /**
     * Maintain queued sessions for selected database and keep them alive.
     *
     * This method drops expired sessions and refreshes "old" ones (expiring in next 10 minutes).
     * It can also refresh some non-"old" sessions to distribute refresh calls more or less
     * evenly between maintenance calls.
     * Only up to `minSessions` sessions are maintained, all excess ones are left to expire.
     */
    public function maintain()
    {
        // Multiplexed sessions do not need to be maintained. However, we can use this method to
        // ensure the current multiplexed session is valid and refresh it if not. Potentially we can
        // rename this method to something more descriptive.
        // @TODO: Rewrite or remove this method
    }

    /**
     * @param CacheItemInterface $item
     * @throws \RuntimeException
     */
    private function save(CacheItemInterface $item)
    {
        $status = $this->cacheItemPool->save($item);

        if (!$status) {
            throw new \RuntimeException(
                'Failed to save session pool data. This can often be related to ' .
                'your chosen cache implementation running out of memory. ' .
                'If so, please attempt to configure a greater memory alottment ' .
                'and try again. When using the Google\Auth\Cache\SysVCacheItemPool ' .
                'implementation we recommend setting the memory allottment to ' .
                '250000 (250kb) in order to safely handle the default maximum ' .
                'of 500 sessions handled by the pool. If you require more ' .
                'maximum sessions please plan accordingly and increase the memory ' .
                'allocation.'
            );
        }
    }
}
