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
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Process\Process;

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

    public function testEnsureValidSessionCacheHit()
    {
        // ensure cache hit
        $cacheItem = $this->prophesize(CacheItemInterface::class);
        $cacheItem->isHit()->shouldBeCalledOnce()->willReturn(true);
        $cacheItem->get()->willReturn((new Session([
            'name' => $this->sessionName,
            'multiplexed' => true,
            'create_time' => new Timestamp(['seconds' => time()]),
        ]))->serializeToString());

        $cacheKey = 'session_cache.myawesomeproject.myinstance.mydatabase.';
        $cacheItemPool = $this->prophesize(CacheItemPoolInterface::class);
        $cacheItemPool->getItem($cacheKey)
            ->shouldBeCalledOnce()
            ->willReturn($cacheItem->reveal());

        $session = new SessionCache(
            $this->spannerClient->reveal(),
            $this->databaseName,
            [
                'cacheItemPool' => $cacheItemPool->reveal(),
            ]
        );
        $name = $session->name();
        $this->assertEquals($this->sessionName, $name);
    }

    public function testEnsureValidSessionCacheMiss()
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
        $cacheItem->isHit()->shouldBeCalledTimes(2)->willReturn(false);
        $cacheItem->get()->shouldNotBeCalled();
        $cacheItem->set(Argument::any())->willReturn($cacheItem->reveal());
        $cacheItem->expiresAt(Argument::any())->willReturn($cacheItem->reveal());

        $cacheItemPool = $this->prophesize(CacheItemPoolInterface::class);
        $cacheItemPool->getItem(Argument::type('string'))
            ->shouldBeCalledTimes(2)
            ->willReturn($cacheItem->reveal());
        $cacheItemPool->save(Argument::type(CacheItemInterface::class))
            ->shouldBeCalledOnce()
            ->willReturn(true);

        $session = new SessionCache(
            $this->spannerClient->reveal(),
            $this->databaseName,
            [
                'databaseRole' => 'Reader',
                'cacheItemPool' => $cacheItemPool->reveal(),
            ]
        );

        $this->assertEquals($this->sessionName, $session->name());
    }

    public function testRefreshSession()
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
        $cacheItem->isHit()->shouldNotBeCalled();
        $cacheItem->get()->shouldNotBeCalled();
        $cacheItem->set(Argument::any())->willReturn($cacheItem->reveal());
        $cacheItem->expiresAt(Argument::any())->willReturn($cacheItem->reveal());

        $cacheItemPool = $this->prophesize(CacheItemPoolInterface::class);
        $cacheItemPool->getItem(Argument::type('string'))
            ->shouldBeCalledOnce()
            ->willReturn($cacheItem->reveal());
        $cacheItemPool->save(Argument::type(CacheItemInterface::class))
            ->shouldBeCalledOnce()
            ->willReturn(true);

        $session = new SessionCache(
            $this->spannerClient->reveal(),
            $this->databaseName,
            [
                'databaseRole' => 'Reader',
                'cacheItemPool' => $cacheItemPool->reveal(),
            ]
        );

        $session->refresh();
        $sessionProto = (new \ReflectionClass($session))->getProperty('session')->getValue($session);
        $this->assertInstanceOf(Session::class, $sessionProto);
        $this->assertEquals($this->sessionName, $sessionProto->getName());
    }

    public function testCacheLocking()
    {
        // Use mt_rand to ensure the cache key is unique for each test run
        $databaseId = mt_rand();
        $databaseName = SpannerClient::databaseName(self::PROJECT, self::INSTANCE, $databaseId);
        $sessionCache = new SessionCache(
            $this->spannerClient->reveal(),
            $databaseName,
            ['cacheItemPool' => new FilesystemAdapter($databaseId)]
        );

        $process = new Process(['php', __DIR__ . '/lock_test_process.php', $databaseName]);
        $process->setTimeout(5);

        // Mock fetching the session from the API
        $phpunit = $this;
        $this->spannerClient->createSession(
            Argument::any(),
            Argument::any()
        )
            ->shouldBeCalledOnce()
            ->will(function () use ($process, $databaseName, $phpunit) {
                // We are currently inside the lock - run the process and ensure it does not complete
                // @see lock_test_process.php
                $process->start();
                // sleep long enough to ensure the process is blocked
                sleep(2);
                // assert process is still running (waiting for this process to complete)
                $phpunit->assertTrue($process->isRunning(), $process->getErrorOutput());
                return (new Session())
                    ->setName($databaseName . '/sessions/session-id-' . uniqid())
                    ->setCreateTime(new Timestamp(['seconds' => time()]));
            });

        $this->assertStringStartsWith($databaseName, $sessionCache->name());

        $process->wait();
        $this->assertEquals(0, $process->getExitCode(), $process->getErrorOutput());
        $this->assertEquals($sessionCache->name(), $process->getOutput());
    }

    public function testCacheExpiration()
    {
        // Use mt_rand to ensure the cache key is unique for each test run
        $databaseName = SpannerClient::databaseName(self::PROJECT, self::INSTANCE, mt_rand());
        $sessionCache = new SessionCache(
            $this->spannerClient->reveal(),
            $databaseName,
        );

        // Mock fetching the session from the API
        $this->spannerClient->createSession(
            Argument::any(),
            Argument::any()
        )
            ->shouldBeCalledTimes(2)
            ->will(function () use ($databaseName) {
                // ensure the cache will be considered expired
                return (new Session())
                    ->setName($databaseName . '/sessions/session-id-' . uniqid())
                    ->setCreateTime(new Timestamp(['seconds' => 0]));
            });

        // Assert calling the cache a second time will request a new session because it's expired
        $this->assertStringStartsWith($databaseName, $sess1 = $sessionCache->name());
        $this->assertStringStartsWith($databaseName, $sess2 = $sessionCache->name());
        $this->assertNotEquals($sess1, $sess2);
    }
}
