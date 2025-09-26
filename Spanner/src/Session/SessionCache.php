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
use Google\Cloud\Core\SysvTrait;
use Google\Cloud\Core\Lock\FlockLock;
use Google\Cloud\Core\Lock\LockInterface;
use Google\Cloud\Core\Lock\SemaphoreLock;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\V1\MultiplexedSessionPrecommitToken;
use Google\Cloud\Spanner\V1\Session as SessionProto;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;


/**
 * Represents and manages a Cloud Spanner Multiplexed Session.
 *
 * @internal
 */
class SessionCache
{
    use SysvTrait;

    private const CACHE_KEY_TEMPLATE = 'cae-session-pool.%s.%s.%s.%s';
    private const SESSION_LIFETIME_SECONDS = 28 * 24 * 3600; // 28 days
    private const SESSION_EXPIRATION_SECONDS = 7 * 24 * 3600; // 7 days;

    private string $cacheKey;
    private LockInterface $lock;
    private MultiplexedSessionPrecommitToken $precommitToken;

    /**
     */
    public function __construct(
        private CacheItemPoolInterface $cacheItemPool,
        private Database $database,
        protected SessionProto|null $session = null,
        LockInterface|null $lock = null,
    ) {
        $identity = $database->identity();
        $this->cacheKey = sprintf(
            self::CACHE_KEY_TEMPLATE,
            $identity['projectId'],
            $identity['instance'],
            $identity['database'],
            $database->role(),
        );
        $this->lock = $lock ?? $this->getDefaultLock($this->cacheKey);
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

    private function ensureValidSession(): void
    {
        if (!$this->session || $this->isExpired()) {
            // Acquire a new multiplex session from the pool
            $this->session = $this->lock->synchronize(function () {
                $item = $this->cacheItemPool->getItem($this->cacheKey);
                if ($sessionData = $item->get()) {
                    $session = new SessionProto();
                    $session->mergeFromString($sessionData);
                } else {
                    $session = $this->database->createSession();
                    $expiresAtSeconds = $session->getCreateTime()->getSeconds() + self::SESSION_EXPIRATION_SECONDS;
                    $expiresAt = DateTimeImmutable::createFromFormat('U', (string) $expiresAtSeconds);
                    $item->set($session->serializeToString());
                    $item->expiresAt($expiresAt);
                    $this->cacheItemPool->save($item);
                }

                return $session;
            });
        }
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
    private function getDefaultLock(string $cacheKey)
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
            'sessionPool' => $this->cacheItemPool,
        ];
    }
}
