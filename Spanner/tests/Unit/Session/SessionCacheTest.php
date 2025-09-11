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

namespace Google\Cloud\Spanner\Tests\Unit\Session;

use Google\Cloud\Spanner\Session\SessionCache;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\Session;
use Google\Protobuf\Timestamp;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @group spanner
 * @group spanner-database
 */
class SessionCacheTest extends TestCase
{
    use ProphecyTrait;

    const PROJECT = 'my-awesome-project';
    const DATABASE = 'my-database';
    const INSTANCE = 'my-instance';
    const SESSION = 'my-session';

    private $spannerClient;
    private string $databaseName;
    private string $sessionName;

    public function setUp(): void
    {
        $this->spannerClient = $this->prophesize(SpannerClient::class);
        $this->databaseName = SpannerClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE);
        $this->sessionName = SpannerClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE, self::SESSION);
    }

    public function testRefreshSessionCacheHit()
    {
        // ensure cache hit
        $cacheItem = $this->prophesize(CacheItemInterface::class);
        $cacheItem->get()->willReturn((new Session([
            'name' => $this->sessionName,
            'multiplexed' => true,
            'create_time' => new Timestamp(['seconds' => time()]),
        ]))->serializeToString());

        $cacheKey = sprintf('cache-session-pool.%s.%s.%s.%s', self::PROJECT, self::INSTANCE, self::DATABASE, '');
        $cacheItemPool = $this->prophesize(CacheItemPoolInterface::class);
        $cacheItemPool->getItem($cacheKey)
            ->willReturn($cacheItem->reveal());

        $session = new SessionCache(
            $cacheItemPool->reveal(),
            $this->spannerClient->reveal(),
            $this->databaseName,
        );
        $name = $session->name();
        $this->assertEquals($this->sessionName, $name);
    }

    public function testRefreshSessionWithCacheMiss()
    {
        $this->spannerClient->createSession(
            Argument::that(function ($request) {
                $this->assertEquals('Reader', $request->getSession()->getCreatorRole());
                $this->assertEquals($this->databaseName, $request->getDatabase());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new Session([
                'name' => $this->sessionName,
                'multiplexed' => true,
                'create_time' => new Timestamp(['seconds' => time()]),
            ]));

        // ensure cache miss
        $cacheItem = $this->prophesize(CacheItemInterface::class);
        $cacheItem->get()->willReturn(null);
        $cacheItem->set(Argument::any())->willReturn($cacheItem->reveal());
        $cacheItem->expiresAt(Argument::any())->willReturn($cacheItem->reveal());

        $cacheItemPool = $this->prophesize(CacheItemPoolInterface::class);
        $cacheItemPool->getItem(Argument::type('string'))
            ->willReturn($cacheItem->reveal());
        $cacheItemPool->save(Argument::type(CacheItemInterface::class))
            ->willReturn(true);

        $sessionCache = new SessionCache(
            $cacheItemPool->reveal(),
            $this->spannerClient->reveal(),
            $this->databaseName,
            [
                'databaseRole' => 'Reader'
            ]
        );
        $sessionProto = $sessionCache->refreshSession();

        $this->assertInstanceOf(Session::class, $sessionProto);
        $this->assertEquals($this->sessionName, $sessionProto->getName());
    }
}