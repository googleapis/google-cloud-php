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

use Google\Cloud\Core\Lock\LockInterface;
use Google\Cloud\Core\Lock\SymfonyLockAdapter;
use Google\Cloud\Spanner\Database;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Lock\Factory;
use Symfony\Component\Lock\Store\FlockStore;

/**
 * This session pool implementation accepts a PSR-6 compatible cache
 * implementation and utilizies it to store sessions between requests.
 *
 * Please note that if you configure a high minimum session value the first
 * request and any after a period of inactivity greater than an hour (the point
 * at which sessions will expire) will have an increased amount of latency. This
 * is due to the pool attempting to create as many sessions as needed to fill
 * itself to match the minimum value.
 *
 * For this reason, it is highly recommended to configure a script to make an
 * initial request to warm up the pool and manage subsequent requests during
 * off-peak hours to keep the pool active.
 *
 * Please note: While required for the session pool, a PSR-6 implementation is
 * not included in this library. It will be neccesary to include a separate
 * dependency to fulfill this requirement.
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
    const CACHE_KEY_TEMPLATE = 'cache-session-pool.%s.%s';

    /**
     * @var array
     */
    private static $defaultConfig = [
        'maxSessions' => PHP_INT_MAX,
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
     * @var string
     */
    private $cacheKey;

    /**
     * @var array
     */
    private $config;

    /**
     * @var Database
     */
    private $database;

    /**
     * @param CacheItemPoolInterface $cacheItemPool A PSR-6 compatible cache
     *        implementation used to store the session data.
     * @param array $config [optional] {
     *     Configuration Options.
     *
     *     @type int $maxSessions The maximum number of sessions to store in the
     *           pool. **Defaults to** PHP_INT_MAX.
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
     *           **Defaults to** an flock based implementation.
     * }
     * @throws \InvalidArgumentException
     */
    public function __construct(CacheItemPoolInterface $cacheItemPool, array $config = [])
    {
        $this->cacheItemPool = $cacheItemPool;
        $this->config = $config + self::$defaultConfig;

        if (!isset($this->config['lock'])) {
            $this->config['lock'] = $this->getDefaultLock();
        }

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
                $shouldSave = true;
            }

            $toCreate = $this->buildToCreateList($data, is_array($session));
            $data['toCreate'] += $toCreate;

            if ($shouldSave || $toCreate) {
                $this->cacheItemPool->save($item->set($data));
            }

            return [$session, $toCreate];
        });

        // Create sessions if needed.
        if ($toCreate) {
            $createdSessions = [];
            $exception = null;

            try {
                $createdSessions = $this->createSessions(count($toCreate));
            } catch (\Exception $ex) {
                $exception = $ex;
            }

            $session = $this->config['lock']->synchronize(function () use (
                $session,
                $toCreate,
                $createdSessions,
                $exception
            ) {
                $item = $this->cacheItemPool->getItem($this->cacheKey);
                $data = $item->get();
                $data['queue'] = array_merge($data['queue'], $createdSessions);

                // Now that we've created the sessions, we can remove them from
                // the list of intent.
                foreach ($toCreate as $id => $time) {
                    unset($data['toCreate'][$id]);
                }

                if (!$session && !$exception) {
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
     * Clear the session pool.
     */
    public function clear()
    {
        $this->cacheItemPool->clear();
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
        $this->cacheKey = sprintf(self::CACHE_KEY_TEMPLATE, $identity['instance'], $identity['database']);
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
     * @param array $data
     * @param bool $hasSession
     * @return array
     */
    private function buildToCreateList(array $data, $hasSession)
    {
        $number = 0;
        $toCreate = [];
        $time = $this->time();
        $count = $this->getSessionCount($data);

        if ($count < $this->config['minSessions']) {
            $number = $this->config['minSessions'] - $count;
        } elseif (!$hasSession && !$data['queue'] && $count < $this->config['maxSessions']) {
            $number++;
        }

        for ($i = 0; $i < $number; $i++) {
            $toCreate[uniqid($time . '_')] = $time;
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
            if ($timestamp + 1200 < $this->time()) {
                unset($data['toCreate'][$key]);
            }
        }
    }

    /**
     * Purge any in use sessions that have been inactive for 20 minutes or more.
     *
     * @param array $data
     */
    private function purgeOrphanedInUseSessions(array &$data)
    {
        foreach ($data['inUse'] as $key => $session) {
            if ($session['lastActive'] + 1200 < $this->time()) {
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
            if ($session['expiration'] - 60 < $this->time()) {
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
        $store = new FlockStore(sys_get_temp_dir());

        return new SymfonyLockAdapter(
            (new Factory($store))->createLock($this->cacheKey)
        );
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

        if (!$this->config['lock'] instanceof LockInterface) {
            throw new \InvalidArgumentException(
                'The lock must implement Google\Cloud\Core\Lock\LockInterface'
            );
        }
    }
}
