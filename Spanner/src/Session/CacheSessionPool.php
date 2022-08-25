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
use Grpc\UnaryCall;
use GuzzleHttp\Promise;
use GuzzleHttp\Promise\PromiseInterface;
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
 * {@see Google\Cloud\Spanner\Session\CacheSessionPool::acquire()} is called at
 * most only a single session is created. Due to this, it is possible to sit
 * under the minimum session value declared when constructing this instance. In
 * order to have the pool match the minimum session value please use the
 * {@see Google\Cloud\Spanner\Session\CacheSessionPool::warmup()} method. This
 * will create as many sessions as needed to match the minimum value, and is the
 * recommended way to bootstrap the session pool.
 *
 * Sessions are created on demand up to the maximum session value set during
 * instantiation of the pool. To help ensure the minimum number of sessions
 * required are managed by the pool, attempts will be made to automatically
 * downsize after every 10 minute window. This feature is configurable and one
 * may also downsize at their own choosing via
 * {@see Google\Cloud\Spanner\Session\CacheSessionPool::downsize()}. Downsizing
 * will help ensure you never run into issues where the Spanner backend is
 * locked up after having met the maximum number of sessions assigned per node.
 * For reference, the current maximum sessions per database per node is 10k. For
 * more information on limits please see
 * [here](https://cloud.google.com/spanner/docs/limits).
 *
 * When expecting a long period of inactivity (such as a
 * maintenance window), please make sure to call
 * {@see Google\Cloud\Spanner\Session\CacheSessionPool::clear()} in order to
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
 * $spanner = new SpannerClient();
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
 */
class CacheSessionPool implements SessionPoolInterface
{
    use SysvTrait;

    const CACHE_KEY_TEMPLATE = 'cache-session-pool.%s.%s.%s';
    const DURATION_TWENTY_MINUTES = 1200;
    const DURATION_ONE_MINUTE = 60;
    const WINDOW_SIZE = 600;

    /**
     * @var array
     */
    private static $defaultConfig = [
        'maxSessions' => 500,
        'minSessions' => 1,
        'shouldWaitForSession' => true,
        'maxCyclesToWaitForSession' => 30,
        'sleepIntervalSeconds' => .5,
        'shouldAutoDownsize' => true,
        'labels' => [],
    ];

    /**
     * @var CacheItemPoolInterface
     */
    private $cacheItemPool;

    /**
     * @var string|null
     */
    private $cacheKey;

    /**
     * @var array
     */
    private $config;

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

    /**
     * @param CacheItemPoolInterface $cacheItemPool A PSR-6 compatible cache
     *        implementation used to store the session data.
     * @param array $config [optional] {
     *     Configuration Options.
     *
     *     @type int $maxSessions The maximum number of sessions to store in the
     *           pool. **Defaults to** `500`.
     *     @type int $minSessions The minimum number of sessions to store in the
     *           pool. **Defaults to** `1`.
     *     @type bool $shouldWaitForSession If the pool is full, whether to block
     *           until a new session is available. **Defaults to* `true`.
     *     @type int $maxCyclesToWaitForSession The maximum number cycles to
     *           wait for a session before throwing an exception. **Defaults to**
     *           `30`. Ignored when $shouldWaitForSession is `false`.
     *     @type float $sleepIntervalSeconds The sleep interval between cycles.
     *           **Defaults to** `0.5`. Ignored when $shouldWaitForSession is
     *           `false`.
     *     @type LockInterface $lock A lock implementation capable of blocking.
     *           **Defaults to** a semaphore based implementation if the
     *           required extensions are installed, otherwise an flock based
     *           implementation.
     *     @type bool $shouldAutoDownsize Determines whether or not to
     *           automatically attempt to downsize the pool after every 10
     *           minute window. **Defaults to** `true`.
     *     @type array $labels Labels to be applied to each session created in
     *           the pool. Label keys must be between 1 and 63 characters long
     *           and must conform to the following regular expression:
     *           `[a-z]([-a-z0-9]*[a-z0-9])?`. Label values must be between 0
     *           and 63 characters long and must conform to the regular
     *           expression `([a-z]([-a-z0-9]*[a-z0-9])?)?`. No more than 64
     *           labels can be associated with a given session. See
     *           https://goo.gl/xmQnxf for more information on and examples of
     *           labels.
     * }
     * @throws \InvalidArgumentException
     */
    public function __construct(CacheItemPoolInterface $cacheItemPool, array $config = [])
    {
        $this->cacheItemPool = $cacheItemPool;
        $this->config = $config + self::$defaultConfig;
        $this->validateConfig();
    }

    /**
     * Acquire a session from the pool.
     *
     * @param string $context The type of session to fetch. May be either `r`
     *        (READ) or `rw` (READ/WRITE). **Defaults to** `r`.
     * @return Session
     * @throws \RuntimeException
     */
    public function acquire($context = SessionPoolInterface::CONTEXT_READ)
    {
        // Try to get a session, run maintenance on the pool, and calculate if
        // we need to create any new sessions.
        list($session, $toCreate) = $this->config['lock']->synchronize(function () {
            $toCreate = [];
            $session = null;
            $shouldSave = false;
            $item = $this->cacheItemPool->getItem($this->cacheKey);
            $data = (array) $item->get() ?: $this->initialize();

            // If the queue has items in it, let's shift one off, however if the
            // queue is empty and we have maxed out the number of sessions let's
            // attempt to purge any orphaned items from the pool to make room
            // for more.
            if ($data['queue']) {
                $session = $this->getSession($data);
                $shouldSave = true;
            } elseif ($this->config['maxSessions'] <= $this->getSessionCount($data)) {
                $this->purgeOrphanedInUseSessions($data);
                $this->purgeOrphanedToCreateItems($data);
                $session = $this->getSession($data);
                $shouldSave = true;
            }

            if (!$session) {
                $count = $this->getSessionCount($data);

                if ($count < $this->config['maxSessions']) {
                    $toCreate = $this->buildToCreateList(1);
                    $data['toCreate'] += $toCreate;
                    $shouldSave = true;
                }
            }

            if ($shouldSave) {
                $this->save($item->set($data));
            }

            return [$session, $toCreate];
        });

        // Create a session if needed.
        if ($toCreate) {
            $createdSessions = $this->createSessions(count($toCreate))[0];
            $hasCreatedSessions = count($createdSessions) > 0;

            $session = $this->config['lock']->synchronize(function () use (
                $toCreate,
                $createdSessions,
                $hasCreatedSessions
            ) {
                $session = null;
                $item = $this->cacheItemPool->getItem($this->cacheKey);
                $data = $item->get();
                $data['queue'] = array_merge($data['queue'], $createdSessions);

                // Now that we've created the session, we can remove it from
                // the list of intent.
                foreach ($toCreate as $id => $time) {
                    unset($data['toCreate'][$id]);
                }

                if ($hasCreatedSessions) {
                    $session = array_shift($data['queue']);
                    $data['inUse'][$session['name']] = $session + [
                        'lastActive' => $this->time()
                    ];

                    if ($this->config['shouldAutoDownsize']) {
                        $this->manageSessionsToDelete($data);
                    }
                }

                $this->save($item->set($data));

                return $session;
            });
        }

        if ($session) {
            $session = $this->handleSession($session);
        }

        // If we don't have a session, let's wait for one or throw an exception.
        if (!$session) {
            if (!$this->config['shouldWaitForSession']) {
                throw new \RuntimeException('No sessions available.');
            }

            $session = $this->waitForNextAvailableSession();
        }

        if ($this->deleteQueue) {
            $this->deleteSessions($this->deleteQueue);
            $this->deleteQueue = [];
        }

        return $this->database->session($session['name']);
    }

    /**
     * Release a session back to the pool.
     *
     * @param Session $session The session.
     * @throws \RuntimeException
     */
    public function release(Session $session)
    {
        $this->config['lock']->synchronize(function () use ($session) {
            $item = $this->cacheItemPool->getItem($this->cacheKey);
            $data = $item->get();
            $name = $session->name();

            if (isset($data['inUse'][$name])) {
                unset($data['inUse'][$name]);
                array_push($data['queue'], [
                    'name' => $name,
                    'expiration' => $session->expiration()
                        ?: $this->time() + SessionPoolInterface::SESSION_EXPIRATION_SECONDS
                ]);
                $this->save($item->set($data));
            }
        });
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
        $this->config['lock']->synchronize(function () use ($session) {
            $item = $this->cacheItemPool->getItem($this->cacheKey);
            $data = $item->get();
            $data['inUse'][$session->name()]['lastActive'] = $this->time();

            $this->save($item->set($data));
        });
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
     * @throws \InvaldArgumentException
     * @throws \RuntimeException
     */
    public function downsize($percent)
    {
        if ($percent < 1 || 100 < $percent) {
            throw new \InvalidArgumentException('The provided percent must be between 1 and 100.');
        }

        $toDelete = $this->config['lock']->synchronize(function () use ($percent) {
            $item = $this->cacheItemPool->getItem($this->cacheKey);
            $data = (array) $item->get() ?: $this->initialize();
            $toDelete = [];
            $queueCount = count($data['queue']);
            $availableCount = max($queueCount - $this->config['minSessions'], 0);
            $countToDelete = ceil($availableCount * ($percent * 0.01));

            if ($countToDelete) {
                $toDelete = array_splice($data['queue'], (int) -$countToDelete);
            }

            $this->save($item->set($data));
            return $toDelete;
        });

        foreach ($toDelete as $sessionData) {
            $session = $this->database->session($sessionData['name']);

            try {
                $session->delete();
            } catch (\Exception $ex) {
                if ($ex instanceof NotFoundException) {
                    continue;
                }
            }
        }

        return count($toDelete);
    }

    /**
     * Create enough sessions to meet the minimum session constraint.
     *
     * @return int The number of sessions created and added to the queue.
     * @throws \RuntimeException
     */
    public function warmup()
    {
        $toCreate = $this->config['lock']->synchronize(function () {
            $item = $this->cacheItemPool->getItem($this->cacheKey);
            $data = (array) $item->get() ?: $this->initialize();
            $count = $this->getSessionCount($data);
            $toCreate = [];

            if ($count < $this->config['minSessions']) {
                $toCreate = $this->buildToCreateList($this->config['minSessions'] - $count);
                $data['toCreate'] += $toCreate;
                $this->save($item->set($data));
            }

            return $toCreate;
        });

        if (!$toCreate) {
            return 0;
        }

        $exception = null;
        list ($createdSessions, $exception) = $this->createSessions(count($toCreate));

        $this->config['lock']->synchronize(function () use ($toCreate, $createdSessions) {
            $item = $this->cacheItemPool->getItem($this->cacheKey);
            $data = $item->get();
            $data['queue'] = array_merge($data['queue'], $createdSessions);

            // Now that we've created the sessions, we can remove them from
            // the list of intent.
            foreach ($toCreate as $id => $time) {
                unset($data['toCreate'][$id]);
            }

            $this->save($item->set($data));
        });

        if ($exception) {
            throw $exception;
        }

        return count($toCreate);
    }

    /**
     * Clear the cache and attempt to delete all sessions in the pool.
     *
     * A session may be removed from the cache, but still tracked as active by
     * the Spanner backend if a delete operation failed. To ensure you do not
     * exceed the maximum number of sessions available per node, please be sure
     * to check the return value of this method to be certain all sessions have
     * been deleted.
     */
    public function clear()
    {
        $sessions = $this->config['lock']->synchronize(function () {
            $item = $this->cacheItemPool->getItem($this->cacheKey);
            $data = (array) $item->get() ?: $this->initialize();
            $sessions = $data['queue'] + $data['inUse'];
            $this->cacheItemPool->clear();

            return $sessions;
        });

        $this->deleteSessions($sessions);
    }

    /**
     * Set the database used to make calls to manage sessions.
     *
     * @param Database $database The database.
     */
    public function setDatabase(Database $database)
    {
        $this->database = $database;
        $identity = $database->identity();
        $this->cacheKey = sprintf(
            self::CACHE_KEY_TEMPLATE,
            $identity['projectId'],
            $identity['instance'],
            $identity['database']
        );

        if (!isset($this->config['lock'])) {
            $this->config['lock'] = $this->getDefaultLock();
        }
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
     * Builds out a list of timestamps indicating the start time of the intent
     * to create a session.
     *
     * @param int $number
     * @return array
     */
    private function buildToCreateList($number)
    {
        $toCreate = [];
        $time = $this->time();

        for ($i = 0; $i < $number; $i++) {
            $toCreate[uniqid($time . '_', true)] = $time;
        }

        return $toCreate;
    }

    /**
     * Purge any items in the to create queue that have been inactive for 20
     * minutes or more.
     *
     * @param array $data
     */
    private function purgeOrphanedToCreateItems(array &$data)
    {
        foreach ($data['toCreate'] as $key => $timestamp) {
            $time = $this->time();

            if ($timestamp + self::DURATION_TWENTY_MINUTES < $this->time()) {
                unset($data['toCreate'][$key]);
            }
        }
    }

    /**
     * Purges in use sessions. If a session was last active an hour ago, we
     * assume it is expired and remove it from the pool. If last active 20
     * minutes ago, we attempt to return the session back to the queue.
     *
     * @param array $data
     */
    private function purgeOrphanedInUseSessions(array &$data)
    {
        foreach ($data['inUse'] as $key => $session) {
            if ($session['lastActive'] + SessionPoolInterface::SESSION_EXPIRATION_SECONDS < $this->time()) {
                unset($data['inUse'][$key]);
            } elseif ($session['lastActive'] + self::DURATION_TWENTY_MINUTES < $this->time()) {
                unset($session['lastActive']);
                array_push($data['queue'], $session);
                unset($data['inUse'][$key]);
            }
        }
    }

    /**
     * Initialize the session data.
     *
     * @return array
     */
    private function initialize()
    {
        return [
            'queue' => [],
            'inUse' => [],
            'toCreate' => [],
            'windowStart' => $this->time(),
            'maxInUseSessions' => 0,
            'maintainTime' => $this->time(),
        ];
    }

    /**
     * Returns the total count of sessions in queue, use, and in the process of
     * being created.
     *
     * @param array $data
     * @return int
     */
    private function getSessionCount(array $data)
    {
        return count($data['queue'])
            + count($data['inUse'])
            + count($data['toCreate']);
    }

    /**
     * Gets the next session in the queue, clearing out any which are expired.
     *
     * @param array $data
     * @return array|null
     */
    private function getSession(array &$data)
    {
        $session = array_shift($data['queue']);

        if ($session) {
            if ($session['expiration'] - self::DURATION_ONE_MINUTE < $this->time()) {
                return $this->getSession($data);
            }

            $data['inUse'][$session['name']] = $session + [
                'lastActive' => $this->time()
            ];

            if ($this->config['shouldAutoDownsize']) {
                $this->manageSessionsToDelete($data);
            }
        }

        return $session;
    }

    /**
     * Creates sessions up to the count provided.
     *
     * @param int $count
     * @return [ array[] $sessions, \Exception $ex = null ]
     */
    private function createSessions($count)
    {
        $sessions = [];
        $created = 0;
        $exception = null;

        // Loop over RPC in case it returns less than the desired number of sessions.
        // @see https://github.com/googleapis/google-cloud-php/pull/2342#discussion_r327925546
        while ($count > $created) {
            try {
                $res = $this->database->connection()->batchCreateSessions([
                    'database' => $this->database->name(),
                    'sessionTemplate' => [
                        'labels' => isset($this->config['labels']) ? $this->config['labels'] : []
                    ],
                    'sessionCount' => $count - $created
                ]);
            } catch (\Exception $exception) {
                break;
            }

            foreach ($res['session'] as $result) {
                $sessions[] = [
                    'name' => $result['name'],
                    'expiration' => $this->time() + SessionPoolInterface::SESSION_EXPIRATION_SECONDS
                ];

                $created++;
            }
        }

        return [$sessions, $exception];
    }

    /**
     * If necessary, triggers a network request to determine the status of the
     * provided session.
     *
     * @param array $session
     * @return bool
     */
    private function isSessionValid(array $session)
    {
        $halfHourBeforeExpiration = $session['expiration'] - (SessionPoolInterface::SESSION_EXPIRATION_SECONDS / 2);

        if ($this->time() < $halfHourBeforeExpiration) {
            return true;
        } elseif ($halfHourBeforeExpiration < $this->time() && $this->time() < $session['expiration']) {
            return $this->database
                ->session($session['name'])
                ->exists();
        }

        return false;
    }

    /**
     * If the session is valid, return it - otherwise remove from the in use
     * list.
     *
     * @param array $session
     * @return array|null
     */
    private function handleSession(array $session)
    {
        if ($this->isSessionValid($session)) {
            return $session;
        }

        $this->config['lock']->synchronize(function () use ($session) {
            $item = $this->cacheItemPool->getItem($this->cacheKey);
            $data = $item->get();
            unset($data['inUse'][$session['name']]);
            $this->save($item->set($data));
        });
    }

    /**
     * Blocks until a session becomes available.
     *
     * @return array
     * @throws \RuntimeException
     */
    private function waitForNextAvailableSession()
    {
        $elapsedCycles = 0;

        while (true) {
            $session = $this->config['lock']->synchronize(function () use ($elapsedCycles) {
                $item = $this->cacheItemPool->getItem($this->cacheKey);
                $data = $item->get();
                $session = $this->getSession($data);

                if ($session) {
                    $this->save($item->set($data));
                    return $session;
                }

                if ($this->config['maxCyclesToWaitForSession'] <= $elapsedCycles) {
                    $this->save($item->set($data));

                    throw new \RuntimeException(
                        'A session did not become available in the allotted number of attempts.'
                    );
                }
            });

            if ($session && $this->handleSession($session)) {
                return $session;
            }

            $elapsedCycles++;
            usleep($this->config['sleepIntervalSeconds'] * 1000000);
        }
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
     * Validate the config.
     *
     * @throws \InvalidArgumentException
     */
    private function validateConfig()
    {
        $mustBePositiveKeys = ['maxCyclesToWaitForSession', 'maxSessions', 'minSessions', 'sleepIntervalSeconds'];

        foreach ($mustBePositiveKeys as $key) {
            if ($this->config[$key] < 0) {
                throw new \InvalidArgumentException("$key may not be negative");
            }
        }

        if ($this->config['maxSessions'] < $this->config['minSessions']) {
            throw new \InvalidArgumentException('minSessions cannot exceed maxSessions');
        }

        if (isset($this->config['lock']) && !$this->config['lock'] instanceof LockInterface) {
            throw new \InvalidArgumentException(
                'The lock must implement Google\Cloud\Core\Lock\LockInterface'
            );
        }
    }

    /**
     * Delete the provided sessions.
     *
     * @param array $sessions
     */
    private function deleteSessions(array $sessions)
    {
        // gRPC calls appear to cancel when the corresponding UnaryCall object
        // goes out of scope. Keeping the calls in scope allows time for the
        // calls to complete at the expense of a small memory footprint.
        $this->deleteCalls = [];

        foreach ($sessions as $session) {
            $this->deleteCalls[] = $this->database->connection()
                ->deleteSessionAsync([
                    'name' => $session['name'],
                    'database' => $this->database->name()
                ]);
        }
    }

    /**
     * Checks the maximum number of sessions in use over the last window(s) then
     * removes the sessions from the cache and prepares them to be deleted from
     * the Spanner backend.
     *
     * @param array $data
     */
    private function manageSessionsToDelete(array &$data)
    {
        $secondsSinceLastWindow = $this->time() - $data['windowStart'];
        $inUseCount = count($data['inUse']);

        if ($secondsSinceLastWindow < self::WINDOW_SIZE + 1) {
            if ($data['maxInUseSessions'] < $inUseCount) {
                $data['maxInUseSessions'] = $inUseCount;
            }

            return;
        }

        $totalCount = $inUseCount + count($data['queue']) + count($data['toCreate']);
        $windowsPassed = (int) ($secondsSinceLastWindow / self::WINDOW_SIZE);
        $deletionCount = min(
            $totalCount - (int) round($data['maxInUseSessions'] / $windowsPassed),
            $totalCount - $this->config['minSessions']
        );
        $data['maxInUseSessions'] = $inUseCount;
        $data['windowStart'] = $this->time();

        if ($deletionCount) {
            $this->deleteQueue += array_splice(
                $data['queue'],
                (int) -$deletionCount
            );
        }
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
        if (!isset($this->database)) {
            throw new \LogicException('Cannot maintain session pool: database not set.');
        }

        $this->config['lock']->synchronize(function () {
            $cacheItem = $this->cacheItemPool->getItem($this->cacheKey);
            $cachedData = $cacheItem->get();
            if (!$cachedData) {
                return;
            }

            $sessions = $cachedData['queue'];
            // Sort sessions by expiration time, "oldest" first.
            // acquire() method picks sessions from the beginning of the queue,
            // so make sure that "oldest" ones will be picked first.
            usort($sessions, function ($a, $b) {
                return ($a['expiration'] - $b['expiration']);
            });

            $now = $this->time();
            $soonToExpireThreshold = $now + 600;
            $prevMaintainTime = isset($cachedData['maintainTime']) ? $cachedData['maintainTime'] : null;

            $len = count($sessions);
            // Find sessions that already expired.
            for ($expiredPos = 0; $expiredPos < $len; $expiredPos++) {
                if ($sessions[$expiredPos]['expiration'] > $now) {
                    break;
                }
            }
            // Find sessions that will expire in next 10 minutes ("old" sessions).
            for ($soonToExpirePos = $expiredPos; $soonToExpirePos < $len; $soonToExpirePos++) {
                if ($sessions[$soonToExpirePos]['expiration'] > $soonToExpireThreshold) {
                    break;
                }
            }
            // Find sessions that were refreshed after the previous maintenance ("fresh" sessions).
            $freshPos = $len - 1;
            if (isset($prevMaintainTime)) {
                $freshThreshold = $prevMaintainTime + self::SESSION_EXPIRATION_SECONDS;
                for (; $freshPos >= 0; $freshPos--) {
                    if ($sessions[$freshPos]['expiration'] <= $freshThreshold) {
                        break;
                    }
                }
            }
            $freshSessionsCount = $len - 1 - $freshPos;
            $soonToExpireSessions = array_splice($sessions, $expiredPos, ($soonToExpirePos - $expiredPos));
            // Drop expired sessions.
            array_splice($sessions, 0, $expiredPos);
            // Sessions created at peak load and (probably) not needed anymore.
            $extraSessions = [];

            $totalSessionsCount = count($cachedData['inUse']) + count($sessions) + count($soonToExpireSessions);
            $maintainedSessionsCount = $this->config['minSessions'];
            $extraSessionsCount = ($totalSessionsCount - $maintainedSessionsCount);
            if ($extraSessionsCount > 0) {
                // Treat some "old" sessions as extra sessions (do not refresh them).
                $extraSessions = array_splice($soonToExpireSessions, -$extraSessionsCount);
            }

            // Refresh remaining "old" sessions and move them to the end of the queue.
            foreach ($soonToExpireSessions as $item) {
                $session = $this->database->session($item['name']);
                if ($this->refreshSession($session)) {
                    $sessions[] = [
                        'name' => $item['name'],
                        'expiration' => $session->expiration(),
                    ];
                    $freshSessionsCount++;
                } else {
                    $totalSessionsCount--;
                }
            }

            if (isset($prevMaintainTime)) {
                // Try to distribute refresh requests evenly between maintenance calls to smooth request peaks.
                // To be safe each session must be refreshed at least once per 50 minutes, it will be
                // (total sessions * maintenance interval / 50 minutes) sessions refreshed between maintenance calls.
                // No need to be precise here, it's just an optimization.

                $maintainInterval = $now - $prevMaintainTime;
                $maxLifetime = self::SESSION_EXPIRATION_SECONDS - 600;
                $totalSessionsCount = min($totalSessionsCount, $maintainedSessionsCount);
                $meanRefreshCount = (int)($totalSessionsCount * $maintainInterval / $maxLifetime);
                $meanRefreshCount = min($meanRefreshCount, $maintainedSessionsCount);
                // There may be sessions already refreshed since previous maintenance,
                // so we can save some refresh requests.
                $refreshCount = $meanRefreshCount - $freshSessionsCount;
                if ($refreshCount > 0) {
                    // Refresh some "oldest" sessions and move them to the end of the queue.
                    $refreshCount = min($refreshCount, count($sessions));
                    for ($pos = 0; $pos < $refreshCount; $pos++) {
                        $item = $sessions[$pos];
                        $session = $this->database->session($item['name']);
                        if ($this->refreshSession($session)) {
                            $sessions[] = [
                                'name' => $item['name'],
                                'expiration' => $session->expiration(),
                            ];
                        }
                    }
                    array_splice($sessions, 0, $refreshCount);
                }
            }

            $cachedData['maintainTime'] = $this->time();
            // Put extra sessions to the end of the queue, so they won't be acquired until really needed.
            $cachedData['queue'] = array_merge($sessions, $extraSessions);
            $this->save($cacheItem->set($cachedData));
        });
    }

    /**
     * @param Session $session
     * @return bool `true`: session was refreshed, `false`: session does not exist
     */
    private function refreshSession($session)
    {
        try {
            $this->database->execute('SELECT 1', ['session' => $session])->rows()->current();
            return true;
        } catch (NotFoundException $e) {
            return false;
        }
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
