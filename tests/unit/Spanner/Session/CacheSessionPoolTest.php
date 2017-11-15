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

namespace Google\Cloud\Tests\Unit\Spanner\Session;

require_once __DIR__ . '../../../Core/Lock/MockGlobals.php';

use Google\Auth\Cache\MemoryCacheItemPool;
use Google\Cloud\Core\Lock\MockValues;
use Google\Cloud\Spanner\Connection\Grpc;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Session\CacheSessionPool;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Tests\GrpcTestTrait;
use Grpc\UnaryCall;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Prophecy\Argument;
use Prophecy\Argument\ArgumentsWildcard;
use PHPUnit\Framework\TestCase;

/**
 * @group spanner
 */
class CacheSessionPoolTest extends TestCase
{
    use GrpcTestTrait;

    const CACHE_KEY_TEMPLATE = 'cache-session-pool.%s.%s.%s';
    const PROJECT_ID = 'project';
    const DATABASE_NAME = 'database';
    const INSTANCE_NAME = 'instance';

    private $time;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();
        putenv('GOOGLE_CLOUD_SYSV_ID=U');
        $this->time = time();
        MockValues::initialize();
    }

    /**
     * @dataProvider badConfigDataProvider
     */
    public function testThrowsExceptionWithInvalidConfig($config)
    {
        $exceptionThrown = false;

        try {
            new CacheSessionPool($this->getCacheItemPool(), $config);
        } catch (\InvalidArgumentException $ex) {
            $exceptionThrown = true;
        }

        $this->assertTrue($exceptionThrown);
    }

    public function badConfigDataProvider()
    {
        return [
            [['maxSessions' => -1]],
            [['minSessions' => -1]],
            [['maxCyclesToWaitForSession' => -1]],
            [['sleepIntervalSeconds' => -1]],
            [['minSessions' => 5, 'maxSessions' => 1]],
            [['lock' => new \stdClass]]
        ];
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testAcquireThrowsExceptionWhenMaxCyclesMet()
    {
        $config = [
            'maxSessions' => 1,
            'maxCyclesToWaitForSession' => 1
        ];
        $cacheData = [
            'queue' => [],
            'inUse' => [
                'alreadyCheckedOut' => [
                    'name' => 'alreadyCheckedOut',
                    'expiration' => $this->time + 3600,
                    'lastActive' => $this->time
                ]
            ],
            'toCreate' => [],
            'windowStart' => $this->time,
            'maxInUseSessions' => 1
        ];
        $pool = new CacheSessionPoolStub($this->getCacheItemPool($cacheData), $config, $this->time);
        $pool->setDatabase($this->getDatabase());
        $pool->acquire();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testAcquireThrowsExceptionWithNoAvailableSessions()
    {
        $config = [
            'maxSessions' => 1,
            'shouldWaitForSession' => false
        ];
        $cacheData = [
            'queue' => [],
            'inUse' => [
                'alreadyCheckedOut' => [
                    'name' => 'alreadyCheckedOut',
                    'expiration' => $this->time + 3600,
                    'lastActive' => $this->time
                ]
            ],
            'toCreate' => [],
            'windowStart' => $this->time,
            'maxInUseSessions' => 1
        ];
        $pool = new CacheSessionPoolStub($this->getCacheItemPool($cacheData), $config, $this->time);
        $pool->setDatabase($this->getDatabase());
        $pool->acquire();
    }

    public function testAcquireRemovesToCreateItemsIfCreateCallFails()
    {
        $exceptionThrown = false;
        $config = ['maxSessions' => 1];
        $pool = new CacheSessionPoolStub($this->getCacheItemPool(), $config, $this->time);
        $pool->setDatabase($this->getDatabase(true));

        try {
            $actualSession = $pool->acquire();
        } catch (\Exception $ex) {
            $exceptionThrown = true;
        }

        $actualItemPool = $pool->cacheItemPool();
        $actualCacheData = $actualItemPool->getItem(
            sprintf(self::CACHE_KEY_TEMPLATE, self::PROJECT_ID, self::INSTANCE_NAME, self::DATABASE_NAME)
        )->get();

        $this->assertEmpty($actualCacheData['toCreate']);
        $this->assertTrue($exceptionThrown);
    }

    public function testRelease()
    {
        $cacheData = [
            'queue' => [],
            'inUse' => [
                'session' => [
                    'name' => 'session',
                    'expiration' => $this->time + 3600,
                    'lastActive' => $this->time
                ]
            ],
            'toCreate' => [],
            'windowStart' => $this->time,
            'maxInUseSessions' => 1
        ];
        $expectedCacheData = [
            'queue' => [
                [
                    'name' => 'session',
                    'expiration' => $this->time + 3600
                ]
            ],
            'inUse' => [],
            'toCreate' => [],
            'windowStart' => $this->time,
            'maxInUseSessions' => 1
        ];
        $session = $this->prophesize(Session::class);
        $session->name()
            ->willReturn('session');
        $session->expiration()
            ->willReturn($this->time + 3600);
        $pool = new CacheSessionPoolStub($this->getCacheItemPool($cacheData), [], $this->time);
        $pool->setDatabase($this->getDatabase());
        $pool->release($session->reveal());
        $actualItemPool = $pool->cacheItemPool();
        $actualCacheData = $actualItemPool->getItem(
            sprintf(self::CACHE_KEY_TEMPLATE, self::PROJECT_ID, self::INSTANCE_NAME, self::DATABASE_NAME)
        )->get();

        $this->assertEquals($expectedCacheData, $actualCacheData);
    }

    public function testKeepAlive()
    {
        $sessionName = 'alreadyCheckedOut';
        $lastActiveOriginal = 1000;
        $session = $this->prophesize(Session::class);
        $session->name()
            ->willReturn($sessionName);
        $pool = new CacheSessionPoolStub($this->getCacheItemPool([
            'queue' => [],
            'inUse' => [
                $sessionName => [
                    'name' => $sessionName,
                    'expiration' => $this->time + 3600,
                    'lastActive' => $lastActiveOriginal
                ]
            ],
            'toCreate' => [],
            'windowStart' => $this->time,
            'maxInUseSessions' => 1
        ]), [], $this->time);
        $pool->setDatabase($this->getDatabase());
        $actualItemPool = $pool->cacheItemPool();
        $actualCacheData = $actualItemPool->getItem(
            sprintf(self::CACHE_KEY_TEMPLATE, self::PROJECT_ID, self::INSTANCE_NAME, self::DATABASE_NAME)
        )->get();

        $this->assertEquals($lastActiveOriginal, $actualCacheData['inUse'][$sessionName]['lastActive']);

        $pool->keepAlive($session->reveal());
        $actualCacheData = $actualItemPool->getItem(
            sprintf(self::CACHE_KEY_TEMPLATE, self::PROJECT_ID, self::INSTANCE_NAME, self::DATABASE_NAME)
        )->get();

        $this->assertEquals($this->time, $actualCacheData['inUse'][$sessionName]['lastActive']);
    }

    /**
     * @dataProvider downsizeDataProvider
     */
    public function testDownsizeDeletes($percent, $expectedDeleteCount)
    {
        $time = time() + 3600;
        $pool = new CacheSessionPoolStub($this->getCacheItemPool([
            'queue' => [
                [
                    'name' => 'session0',
                    'expiration' => $time
                ],
                [
                    'name' => 'session1',
                    'expiration' => $time
                ],
                [
                    'name' => 'session2',
                    'expiration' => $time
                ],
                [
                    'name' => 'session3',
                    'expiration' => $time
                ],
                [
                    'name' => 'session4',
                    'expiration' => $time
                ]
            ],
            'inUse' => [],
            'toCreate' => [],
            'windowStart' => $this->time,
            'maxInUseSessions' => 1
        ]));
        $pool->setDatabase($this->getDatabase(false, true));

        $this->assertEquals(
            $expectedDeleteCount,
            $pool->downsize($percent)
        );
    }

    public function downsizeDataProvider()
    {
        return [
            [50, 2],
            [1, 1],
            [100, 4]
        ];
    }

    /**
     * @dataProvider invalidPercentDownsizeDataProvider
     */
    public function testDownsizeThrowsExceptionWithInvalidPercent($percent)
    {
        $pool = new CacheSessionPoolStub($this->getCacheItemPool());
        $exceptionThrown = false;

        try {
            $pool->downsize($percent);
        } catch (\InvalidArgumentException $ex) {
            $exceptionThrown = true;
        }

        $this->assertTrue($exceptionThrown);
    }

    public function invalidPercentDownsizeDataProvider()
    {
        return [
            [-1],
            [0],
            [101]
        ];
    }

    public function testWarmup()
    {
        $expectedCreationCount = 5;
        $pool = new CacheSessionPoolStub(
            $this->getCacheItemPool(),
            ['minSessions' => $expectedCreationCount]
        );
        $pool->setDatabase($this->getDatabase());
        $response = $pool->warmup();

        $this->assertEquals($expectedCreationCount, $response);
    }

    public function testClearPool()
    {
        $pool = new CacheSessionPoolStub($this->getCacheItemPool());
        $pool->setDatabase($this->getDatabase());
        $pool->clear();
        $actualItemPool = $pool->cacheItemPool();
        $actualCacheData = $actualItemPool->getItem(
            sprintf(self::CACHE_KEY_TEMPLATE, self::PROJECT_ID, self::INSTANCE_NAME, self::DATABASE_NAME)
        )->get();

        $this->assertNull($actualCacheData);
    }

    /**
     * @dataProvider acquireDataProvider
     */
    public function testAcquire($config, $cacheData, $expectedCacheData, $time)
    {
        $pool = new CacheSessionPoolStub($this->getCacheItemPool($cacheData), $config, $time);
        $pool->setDatabase($this->getDatabase());
        $actualSession = $pool->acquire();
        $actualItemPool = $pool->cacheItemPool();
        $actualCacheData = $actualItemPool->getItem(
            sprintf(self::CACHE_KEY_TEMPLATE, self::PROJECT_ID, self::INSTANCE_NAME, self::DATABASE_NAME)
        )->get();

        $this->assertInstanceOf(Session::class, $actualSession);
        $this->assertEquals($expectedCacheData, $actualCacheData);
    }

    public function acquireDataProvider()
    {
        $time = time();

        return [
            // Set #0: Initialize data using default config
            [
                [],
                null,
                [
                    'queue' => [],
                    'inUse' => [
                        'session0' => [
                            'name' => 'session0',
                            'expiration' => $time + 3600,
                            'lastActive' => $time
                        ]
                    ],
                    'toCreate' => [],
                    'windowStart' => $time,
                    'maxInUseSessions' => 1
                ],
                $time
            ],
            // Set #1: Purge expired session from queue and create
            [
                ['minSessions' => 1],
                [
                    'queue' => [
                        [
                            'name' => 'expired',
                            'expiration' => $time - 3000
                        ]
                    ],
                    'inUse' => [],
                    'toCreate' => [],
                    'windowStart' => $time,
                    'maxInUseSessions' => 1
                ],
                [
                    'queue' => [],
                    'inUse' => [
                        'session0' => [
                            'name' => 'session0',
                            'expiration' => $time + 3600,
                            'lastActive' => $time
                        ]
                    ],
                    'toCreate' => [],
                    'windowStart' => $time,
                    'maxInUseSessions' => 1
                ],
                $time
            ],
            // Set #2: Create a new session when all available are checked out
            // and we have not reached the max limit
            [
                [],
                [
                    'queue' => [],
                    'inUse' => [
                        'alreadyCheckedOut' => [
                            'name' => 'alreadyCheckedOut',
                            'expiration' => $time + 3600,
                            'lastActive' => $time
                        ]
                    ],
                    'toCreate' => [],
                    'windowStart' => $time,
                    'maxInUseSessions' => 1
                ],
                [
                    'queue' => [],
                    'inUse' => [
                        'session0' => [
                            'name' => 'session0',
                            'expiration' => $time + 3600,
                            'lastActive' => $time
                        ],
                        'alreadyCheckedOut' => [
                            'name' => 'alreadyCheckedOut',
                            'expiration' => $time + 3600,
                            'lastActive' => $time
                        ]
                    ],
                    'toCreate' => [],
                    'windowStart' => $time,
                    'maxInUseSessions' => 2
                ],
                $time
            ],
            // Set #3: Run clean up on abandoned items and create new
            [
                ['maxSessions' => 3],
                [
                    'queue' => [],
                    'inUse' => [
                        'expiredInUse1' => [
                            'name' => 'expiredInUse1',
                            'expiration' => $time - 5000,
                            'lastActive' => $time - 1201
                        ],
                        'expiredInUse2' => [
                            'name' => 'expiredInUse2',
                            'expiration' => $time - 5000,
                            'lastActive' => $time - 3601
                        ]
                    ],
                    'toCreate' => [
                        'oldguy' => $time - 1201
                    ],
                    'windowStart' => $time,
                    'maxInUseSessions' => 2
                ],
                [
                    'queue' => [],
                    'inUse' => [
                        'session0' => [
                            'name' => 'session0',
                            'expiration' => $time + 3600,
                            'lastActive' => $time
                        ]
                    ],
                    'toCreate' => [],
                    'windowStart' => $time,
                    'maxInUseSessions' => 2
                ],
                $time
            ],
            // Set #4: Basic test, check out session from queue
            [
                [],
                [
                    'queue' => [
                        [
                            'name' => 'session',
                            'expiration' => $time + 3600
                        ]
                    ],
                    'inUse' => [],
                    'toCreate' => [],
                    'windowStart' => $time,
                    'maxInUseSessions' => 1
                ],
                [
                    'queue' => [],
                    'inUse' => [
                        'session' => [
                            'name' => 'session',
                            'expiration' => $time + 3600,
                            'lastActive' => $time
                        ]
                    ],
                    'toCreate' => [],
                    'windowStart' => $time,
                    'maxInUseSessions' => 1
                ],
                $time
            ],
            // Set #5: Session expires in a half hour, check validity against API
            [
                [],
                [
                    'queue' => [
                        [
                            'name' => 'expiresSoon',
                            'expiration' => $time + 1500
                        ],
                        [
                            'name' => 'session',
                            'expiration' => $time + 3600
                        ]
                    ],
                    'inUse' => [],
                    'toCreate' => [],
                    'windowStart' => $time,
                    'maxInUseSessions' => 1
                ],
                [
                    'queue' => [],
                    'inUse' => [
                        'session' => [
                            'name' => 'session',
                            'expiration' => $time + 3600,
                            'lastActive' => $time
                        ]
                    ],
                    'toCreate' => [],
                    'windowStart' => $time,
                    'maxInUseSessions' => 1
                ],
                $time
            ],
            // Set #6: Return inactive in use session back to queue
            [
                ['maxSessions' => 1],
                [
                    'queue' => [],
                    'inUse' => [
                        'inactiveInUse1' => [
                            'name' => 'inactiveInUse1',
                            'expiration' => $time + 3600,
                            'lastActive' => $time - 1201
                        ]
                    ],
                    'toCreate' => [],
                    'windowStart' => $time,
                    'maxInUseSessions' => 1
                ],
                [
                    'queue' => [],
                    'inUse' => [
                        'inactiveInUse1' => [
                            'name' => 'inactiveInUse1',
                            'expiration' => $time + 3600,
                            'lastActive' => $time
                        ]
                    ],
                    'toCreate' => [],
                    'windowStart' => $time,
                    'maxInUseSessions' => 1
                ],
                $time
            ],
            // Set #7: Auto downsize pool
            [
                ['maxSessions' => 5],
                [
                    'queue' => [
                        [
                            'name' => 'session1',
                            'expiration' => $time + 3600
                        ],
                        [
                            'name' => 'session2',
                            'expiration' => $time + 3600
                        ],
                        [
                            'name' => 'session3',
                            'expiration' => $time + 3600
                        ],
                        [
                            'name' => 'session4',
                            'expiration' => $time + 3600
                        ]
                    ],
                    'inUse' => [],
                    'toCreate' => [],
                    'windowStart' => $time - 601,
                    'maxInUseSessions' => 1
                ],
                [
                    'queue' => [],
                    'inUse' => [
                        'session1' => [
                            'name' => 'session1',
                            'expiration' => $time + 3600,
                            'lastActive' => $time
                        ]
                    ],
                    'toCreate' => [],
                    'windowStart' => $time,
                    'maxInUseSessions' => 1
                ],
                $time
            ]
        ];
    }

    private function getDatabase($shouldCreateThrowException = false, $willDeleteSessions = false)
    {
        $database = $this->prophesize(Database::class);
        $createdSession = $this->prophesize(Session::class);
        $session = $this->prophesize(Session::class);
        $connection = $this->prophesize(Grpc::class);
        $unaryCall = $this->prophesize(UnaryCall::class);
        $createdSession->expiration()
            ->willReturn($this->time + 3600);
        $session->expiration()
            ->willReturn($this->time + 3600);
        $session->exists()
            ->willReturn(false);
        $unaryCall->wait()
            ->willReturn(null);
        $connection->deleteSessionAsync(Argument::any())
            ->willReturn($unaryCall->reveal());

        if ($willDeleteSessions) {
            $session->delete()
                ->willReturn(null);
        }
        $database->connection()
            ->willReturn($connection->reveal());
        $database->session(Argument::any())
            ->will(function ($args) use ($session) {
                $session->name()
                    ->willReturn($args[0]);

                return $session->reveal();
            });
        $database->identity()
            ->willReturn([
                'projectId' => self::PROJECT_ID,
                'database' => self::DATABASE_NAME,
                'instance' => self::INSTANCE_NAME
            ]);
        $database->name()
            ->willReturn(self::DATABASE_NAME);

        if ($shouldCreateThrowException) {
            $database->createSession()
                ->willThrow(new \Exception());
        } else {
            $database->createSession()
                ->will(function ($args, $mock, $method) use ($createdSession) {
                    $methodCalls = $mock->findProphecyMethodCalls(
                        $method->getMethodName(),
                        new ArgumentsWildcard($args)
                    );

                    $createdSession->name()
                        ->willReturn('session' . count($methodCalls));

                    return $createdSession;
                });
        }

        return $database->reveal();
    }

    private function getCacheItemPool(array $cacheData = null)
    {
        $cacheItemPool = new MemoryCacheItemPool();
        $cacheItem = $cacheItemPool->getItem(
            sprintf(self::CACHE_KEY_TEMPLATE, self::PROJECT_ID, self::INSTANCE_NAME, self::DATABASE_NAME)
        );
        $cacheItemPool->save($cacheItem->set($cacheData));

        return $cacheItemPool;
    }
}

class CacheSessionPoolStub extends CacheSessionPool
{
    private $time;

    public function __construct(CacheItemPoolInterface $cacheItemPool, array $config = [], $time = null)
    {
        $this->time = $time;
        parent::__construct($cacheItemPool, $config);
    }

    protected function time()
    {
        return $this->time ?: parent::time();
    }
}
