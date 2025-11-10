<?php
/**
 * Copyright 2016 Google Inc.
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

use DateTimeImmutable;
use Google\Auth\Cache\FileSystemCacheItemPool;
use Google\Auth\Cache\SysVCacheItemPool;
use Google\Cloud\Core\Lock\FlockLock;
use Google\Cloud\Core\Lock\LockInterface;
use Google\Cloud\Core\Lock\SemaphoreLock;
use Google\Cloud\Core\SysvTrait;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\CreateSessionRequest;
use Google\Cloud\Spanner\V1\Session;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use RuntimeException;

/**
 * Represents and manages a Cloud Spanner Multiplexed Session.
 *
 * @internal
 */
class SessionCache
{
    use SysvTrait;

    private const CACHE_KEY_TEMPLATE = 'session_cache.%s.%s.%s.%s';
    private const CACHE_KEY_VALIDATION_REGEX = '/[^a-zA-Z0-9_\.! ]+/';
    /**
     * A multiplex session's actual lifetime is 28 days, but we set the expiration to only 7
     * days to be consistent with the guidance from the Spanner team
     */
    private const SESSION_EXPIRATION_SECONDS = 7 * 24 * 3600; // 7 days;

    private string $cacheKey;
    private LockInterface $lock;
    private ?Session $session = null;
    private string $databaseRole;
    private bool $routeToLeader;
    private CacheItemPoolInterface $cacheItemPool;
    private CacheItemInterface $cacheItem;

    /**
     * @param array $options {
     *     Configuration Options.
     *
     *     @type string $databaseRole
     *     @type LockInterface $lock
     *     @type bool $routeToLeader
     *     @type CacheItemPool $cacheItemPool
     * }
     */
    public function __construct(
        private SpannerClient $spannerClient,
        private string $databaseName,
        array $options = [],
    ) {
        $this->databaseRole = $options['databaseRole'] ?? '';

        $identity = DatabaseAdminClient::parseName($databaseName);
        if (!isset($identity['project'], $identity['instance'], $identity['database'])) {
            throw new RuntimeException('Invalid database name');
        }

        $this->cacheKey = rtrim(preg_replace(
            self::CACHE_KEY_VALIDATION_REGEX,
            '',
            sprintf(
                self::CACHE_KEY_TEMPLATE,
                $identity['project'],
                $identity['instance'],
                $identity['database'],
                $this->databaseRole,
            )
        ), '.');

        $this->routeToLeader = $options['routeToLeader'] ?? false;
        $this->cacheItemPool = $options['cacheItemPool'] ?? (
            extension_loaded('sysvshm') && extension_loaded('sysvsem')
                ? new SysVCacheItemPool()
                : new FileSystemCacheItemPool(sys_get_temp_dir() . '/spanner_cache/')
        );
        $this->lock = $options['lock'] ?? $this->getDefaultLock($this->cacheKey);
    }

    /**
     * The fully qualified session name.
     *
     * @return string
     */
    public function name(): string
    {
        $this->ensureValidSession();

        return $this->session->getName();
    }

    public function refresh(): Session
    {
        $session = $this->createSession();
        $expiresAtSeconds = time() + self::SESSION_EXPIRATION_SECONDS;
        $expiresAtSeconds = ($session->getCreateTime()?->getSeconds() ?? time()) + self::SESSION_EXPIRATION_SECONDS;
        $expiresAt = DateTimeImmutable::createFromFormat('U', (string) $expiresAtSeconds);

        // save the new session to the cache
        $this->cacheItem = $this->cacheItem ?? $this->cacheItemPool->getItem($this->cacheKey);
        $this->cacheItem->set($session->serializeToString());
        $this->cacheItem->expiresAt($expiresAt);
        $this->cacheItemPool->save($this->cacheItem);

        return $this->session = $session;
    }

    private function ensureValidSession(): void
    {
        if (!$this->session || $this->isExpired()) {
            // pull the latest session from the cache
            if ($this->getSessionFromCache()) {
                return;
            }
            // acquire a lock to refresh the cache
            if ($this->lock->acquire()) {
                // see if we now have a cache hit (in the event of a race condition)
                if (!$this->getSessionFromCache()) {
                    // If there's still no cache hit, creata a new multiplex session
                    $this->refresh();
                }
                $this->lock->release();
            }
        }
    }

    private function getSessionFromCache(): bool
    {
        $this->cacheItem = $this->cacheItemPool->getItem($this->cacheKey);
        if ($this->cacheItem->isHit() && $sessionData = $this->cacheItem->get()) {
            $session = new Session();
            $session->mergeFromString($sessionData);
            $this->session = $session;
            return true;
        }
        return false;
    }

    private function createSession(): Session
    {
        $session = new Session();
        $session->setMultiplexed(true)
            ->setCreatorRole($this->databaseRole);

        $createSessionRequest = (new CreateSessionRequest())
            ->setDatabase($this->databaseName)
            ->setSession($session);

        return $this->spannerClient->createSession($createSessionRequest, [
            'resource-prefix' => $this->databaseName,
            'route-to-leader' => $this->routeToLeader
        ]);
    }

    private function isExpired(): bool
    {
        $createdTimeSeconds = $this->session->getCreateTime()->getSeconds();
        return time() >=  ($createdTimeSeconds + self::SESSION_EXPIRATION_SECONDS);
    }

    /**
     * Get the default lock.
     *
     * @return LockInterface
     */
    private function getDefaultLock(string $cacheKey): LockInterface
    {
        if ($this->isSysvIPCLoaded()) {
            return new SemaphoreLock(
                $this->getSysvKey(crc32($cacheKey))
            );
        }

        return new FlockLock($cacheKey);
    }

    /**
     * Represent the class in a more readable and digestable fashion.
     *
     * @access private
     * @codeCoverageIgnore
     */
    public function __debugInfo()
    {
        return [
            'session' => $this->session,
            'cacheKey' => $this->cacheKey,
            'cacheItemPool' => $this->cacheItemPool,
        ];
    }
}
