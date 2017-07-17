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
use Psr\Cache\CacheItemPoolInterface;

/**
 * This session pool implementation accepts a PSR-6 compatible cache
 * implementation and utilizes it to store sessions between requests.
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
 * instantiation of the pool. After peak usage hours, you may find that more
 * sessions are available than your demand may require. It is important to make
 * sure the number of active sessions managed by the Spanner backend is kept
 * as minimal as possible. In order to help maintain this balance, please use
 * the {@see Google\Cloud\Spanner\Session\CacheSessionPool::downsize()} method
 * on an interval that matches when you expect to see a decrease in traffic.
 * This will help ensure you never run into issues where the Spanner backend is
 * locked up after having met the maximum number of sessions assigned per node.
 * For reference, the current maximum sessions per database per node is 10k. For
 * more information on limits please see
 * [here](https://cloud.google.com/spanner/docs/limits).
 *
 * Additionally, when expecting a long period of inactivity (such as a
 * maintenance window), please make sure to call
 * {@see Google\Cloud\Spanner\Session\CacheSessionPool::clear()} in order to
 * delete any active sessions.
 *
 * Please note: While required for the session pool, a PSR-6 implementation is
 * not included in this library. It will be neccesary to include a separate
 * dependency to fulfill this requirement. The below example makes use of
 * [Symfony's Cache Component](https://github.com/symfony/cache). For more
 * implementations please see the
 * [Packagist PHP Package Repository](https://packagist.org/providers/psr/cache-implementation).
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
 */
class CacheSessionPool implements SessionPoolInterface
{
    use SysvTrait;

    const CACHE_KEY_TEMPLATE = 'cache-session-pool.%s.%s.%s';

    const DURATION_TWENTY_MINUTES = 1200;
    const DURATION_ONE_MINUTE = 60;

    /**
     * @var array
     */
    private static $defaultConfig = [
        'maxSessions' => 500,
        'minSessions' => 1,
        'shouldWaitForSession' => true,
        'maxCyclesToWaitForSession' => 30,
        'sleepIntervalSeconds' => .5
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
                $this->cacheItemPool->save($item->set($data));
            }

            return [$session, $toCreate];
        });

        // Create a session if needed.
        if ($toCreate) {
            $createdSessions = [];
            $exception = null;

            try {
                $createdSessions = $this->createSessions(count($toCreate));
            } catch (\Exception $exception) {
            }

            $session = $this->config['lock']->synchronize(function () use (
                $toCreate,
                $createdSessions,
                $exception
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

                if (!$exception) {
                    $session = array_shift($data['queue']);

                    $data['inUse'][$session['name']] = $session + [
                        'lastActive' => $this->time()
                    ];
                }

                $this->cacheItemPool->save($item->set($data));

                return $session;
            });

            if ($exception) {
                throw $exception;
            }
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

        return $this->database->session($session['name']);
    }

    /**
     * Release a session back to the pool.
     *
     * @param Session $session The session.
     */
    public function release(Session $session)
    {
        $this->config['lock']->synchronize(function () use ($session) {
            $item = $this->cacheItemPool->getItem($this->cacheKey);
            $data = $item->get();

            unset($data['inUse'][$session->name()]);
            array_push($data['queue'], [
                'name' => $session->name(),
                'expiration' => $session->expiration()
                    ?: $this->time() + SessionPoolInterface::SESSION_EXPIRATION_SECONDS
            ]);
            $this->cacheItemPool->save($item->set($data));
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
     */
    public function keepAlive(Session $session)
    {
        $this->config['lock']->synchronize(function () use ($session) {
            $item = $this->cacheItemPool->getItem($this->cacheKey);
            $data = $item->get();
            $data['inUse'][$session->name()]['lastActive'] = $this->time();

            $this->cacheItemPool->save($item->set($data));
        });
    }

    /**
     * Downsizes the queue of available sessions by the given percentage. This is
     * relative to the minimum sessions value. For example: Assuming a full
     * queue, with maximum sessions of 10 and a minimum of 2, downsizing by 50%
     * would leave 6 sessions in the queue. The count of items to be deleted will
     * be rounded up in the case of a fraction.
     *
     * A session may be removed from the cache, but still tracked as active by
     * the Spanner backend if a delete operation failed. To ensure you do not
     * exceed the maximum number of sessions available per node, please be sure
     * to check the return value of this method to be certain all sessions have
     * been deleted.
     *
     * Please note this method will attempt to synchronously delete sessions and
     * will block until complete.
     *
     * @param int $percent The percentage to downsize the pool by. Must be
     *        between 1 and 100.
     * @return array An associative array containing a key `deleted` which holds
     *         an integer value representing the number of queued sessions
     *         deleted on the backend and a key `failed` which holds a list of
     *         queued {@see Google\Cloud\Spanner\Session\Session} objects which
     *         failed to delete.
     * @throws \InvaldArgumentException
     */
    public function downsize($percent)
    {
        if ($percent < 1 || 100 < $percent) {
            throw new \InvalidArgumentException('The provided percent must be between 1 and 100.');
        }

        $failed = [];
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

            $this->cacheItemPool->save($item->set($data));
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

                $failed[] = $session;
            }
        }

        return [
            'deleted' => count($toDelete) - count($failed),
            'failed' => $failed
        ];
    }

    /**
     * Create enough sessions to meet the minimum session constraint.
     *
     * @return int The number of sessions created and added to the queue.
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
                $this->cacheItemPool->save($item->set($data));
            }

            return $toCreate;
        });

        if (!$toCreate) {
            return 0;
        }

        $createdSessions = [];
        $exception = null;

        try {
            $createdSessions = $this->createSessions(count($toCreate));
        } catch (\Exception $exception) {
        }

        $this->config['lock']->synchronize(function () use ($toCreate, $createdSessions) {
            $item = $this->cacheItemPool->getItem($this->cacheKey);
            $data = $item->get();
            $data['queue'] = array_merge($data['queue'], $createdSessions);

            // Now that we've created the sessions, we can remove them from
            // the list of intent.
            foreach ($toCreate as $id => $time) {
                unset($data['toCreate'][$id]);
            }

            $this->cacheItemPool->save($item->set($data));
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
     *
     * Please note this method will attempt to synchronously delete sessions and
     * will block until complete.
     *
     * @return array An array containing a list of
     *         {@see Google\Cloud\Spanner\Session\Session} objects which failed
     *         to delete.
     */
    public function clear()
    {
        $failed = [];
        $sessions = $this->config['lock']->synchronize(function () {
            $sessions = [];
            $item = $this->cacheItemPool->getItem($this->cacheKey);
            $data = (array) $item->get() ?: $this->initialize();

            foreach ($data['queue'] as $session) {
                $sessions[] = $session['name'];
            }

            foreach ($data['inUse'] as $session) {
                $sessions[] = $session['name'];
            }

            $this->cacheItemPool->clear();

            return $sessions;
        });

        foreach ($sessions as $sessionName) {
            $session = $this->database->session($sessionName);

            try {
                $session->delete();
            } catch (\Exception $ex) {
                if ($ex instanceof NotFoundException) {
                    continue;
                }

                $failed[] = $session;
            }
        }

        return $failed;
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
            'toCreate' => []
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
        $count = 0;

        foreach ($data as $sessionType) {
            $count += count($sessionType);
        }

        return $count;
    }

    /**
     * Gets the next session in the queue, clearing out which are expired.
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
        }

        return $session;
    }

    /**
     * Creates sessions up to the count provided.
     *
     * @param int $count
     * @return array
     */
    private function createSessions($count)
    {
        $sessions = [];

        for ($i = 0; $i < $count; $i++) {
            $sessions[] = [
                'name' => $this->database->createSession()->name(),
                'expiration' => $this->time() + SessionPoolInterface::SESSION_EXPIRATION_SECONDS
            ];
        }

        return $sessions;
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
            $this->cacheItemPool->save($item->set($data));
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
                    $this->cacheItemPool->save($item->set($data));
                    return $session;
                }

                if ($this->config['maxCyclesToWaitForSession'] <= $elapsedCycles) {
                    $this->cacheItemPool->save($item->set($data));

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
     * @param array $config
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
}
