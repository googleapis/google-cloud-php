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

namespace Google\Cloud\Spanner\Tests\Unit\Session;

use Google\Auth\Cache\MemoryCacheItemPool;
use Google\Cloud\Core\Testing\Lock\MockValues;
use Google\Cloud\Spanner\Connection\Grpc;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Session\CacheSessionPool;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Cache\CacheItemPoolInterface;
use Prophecy\Argument;
use Prophecy\Argument\ArgumentsWildcard;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group spanner
 * @group spanner-session-cachepool
 */
class CacheSessionPoolTest extends TestCase
{
    use ExpectException;
    use GrpcTestTrait;

    const CACHE_KEY_TEMPLATE = CacheSessionPool::CACHE_KEY_TEMPLATE;
    const PROJECT_ID = 'project';
    const DATABASE_NAME = 'database';
    const INSTANCE_NAME = 'instance';

    private $time;
    private $cacheKey;

    public function set_up()
    {
        $this->checkAndSkipGrpcTests();
        putenv('GOOGLE_CLOUD_SYSV_ID=U');
        $this->time = time();
        MockValues::initialize();
        $this->cacheKey = sprintf(self::CACHE_KEY_TEMPLATE, self::PROJECT_ID, self::INSTANCE_NAME, self::DATABASE_NAME);
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

    public function testAcquireThrowsExceptionWhenMaxCyclesMet()
    {
        $this->expectException('\RuntimeException');

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

    public function testAcquireThrowsExceptionWithNoAvailableSessions()
    {
        $this->expectException('\RuntimeException');

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
        $pool->setDatabase($this->getDatabase(false, false, 5));
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

    public function testReleaseSessionAfterClearingPoolSucceeds()
    {
        $pool = new CacheSessionPoolStub($this->getCacheItemPool());
        $pool->setDatabase($this->getDatabase());
        $session = $pool->acquire();
        $itemPool = $pool->cacheItemPool();
        $pool->clear();
        $cacheData = $itemPool->getItem(
            sprintf(self::CACHE_KEY_TEMPLATE, self::PROJECT_ID, self::INSTANCE_NAME, self::DATABASE_NAME)
        )->get();

        $this->assertNull($cacheData);

        $pool->release($session);
        $cacheData = $itemPool->getItem(
            sprintf(self::CACHE_KEY_TEMPLATE, self::PROJECT_ID, self::INSTANCE_NAME, self::DATABASE_NAME)
        )->get();

        $this->assertNull($cacheData);
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
        $actualCacheData = array_intersect_key($actualCacheData, $expectedCacheData);
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
            ],
            [
                [
                    'labels' => [
                        'env' => 'unit-test'
                    ]
                ],
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
            ]
        ];
    }

    private function getDatabase($shouldCreateFails = false, $willDeleteSessions = false, $expectedCreateCalls = null)
    {
        $database = $this->prophesize(DatabaseStub::class);
        $session = $this->prophesize(SessionStub::class);
        $connection = $this->prophesize(Grpc::class);
        $promise = $this->prophesize(PromiseInterface::class);

        $session->expiration()
            ->willReturn($this->time + 3600);
        $session->exists()
            ->willReturn(false);
        $promise->wait()
            ->willReturn(null);
        $connection->deleteSessionAsync(Argument::any())
            ->willReturn($promise->reveal());

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
        $database->execute(Argument::exact('SELECT 1'), Argument::withKey('session'))
            ->willReturn(new DumbObject);

        $createRes = function ($args, $mock, $method) use ($shouldCreateFails) {
            if ($shouldCreateFails) {
                throw new \Exception("error");
            }

            $methodCalls = $mock->findProphecyMethodCalls(
                $method->getMethodName(),
                new ArgumentsWildcard([Argument::any()])
            );

            return [
                'session' => [
                    [
                        'name' => 'session' . count($methodCalls)
                    ]
                ]
            ];
        };

        if ($expectedCreateCalls) {
            $connection->batchCreateSessions(Argument::any())
                ->shouldBeCalledTimes($expectedCreateCalls)
                ->will($createRes);
        } else {
            $connection->batchCreateSessions(Argument::any())
                ->will($createRes);
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

    private function queueItem($name, $age)
    {
        return [
            'name' => basename($name),
            'expiration' => $this->time + 3600 - $age,
        ];
    }

    private function queue(array $itemMap)
    {
        $result = [];
        foreach ($itemMap as $name => $age) {
            $result[] = $this->queueItem($name, $age);
        }
        return $result;
    }

    private function cacheData(array $itemMap, $maintainInterval = null)
    {
        $cacheData = [
            'queue' => $this->queue($itemMap),
            'inUse' => [],
            'toCreate' => [],
            'windowStart' => $this->time,
            'maxInUseSessions' => 1,
        ];
        if (isset($maintainInterval)) {
            $cacheData['maintainTime'] = $this->time - $maintainInterval;
        }
        return $cacheData;
    }

    public function testMaintainData()
    {
        $initialData = $this->cacheData(['foo' => 3500], 300);
        $initialData['inUse'] = [2, 7, 1];
        $initialData['toCreate'] = [3, 1, 4];
        $config = ['minSessions' => 4];
        $cache = $this->getCacheItemPool($initialData);
        $pool = new CacheSessionPoolStub($cache, $config, $this->time);
        $pool->setDatabase($this->getDatabase());
        $pool->maintain();
        $expectedData = $initialData;
        $expectedData['maintainTime'] = $this->time;
        $expectedData['queue'] = $this->queue(['foo' => 0]);
        $gotData = $pool->cacheItemPool()->getItem($this->cacheKey)->get();
        $this->assertEquals($expectedData, $gotData);
    }

    public function testMaintainEmptyData()
    {
        $cache = $this->getCacheItemPool([]);
        $pool = new CacheSessionPoolStub($cache, [], $this->time);
        $pool->setDatabase($this->getDatabase());
        $pool->maintain();
        $data = $pool->cacheItemPool()->getItem($this->cacheKey)->get();
        $this->assertEmpty($data);
    }

    public function testMaintainException()
    {
        $data = $this->cacheData(['dead' => 3700, 'old' => 3200, 'fresh' => 100, 'other' => 1500], 300);
        $database = $this->prophesize(DatabaseStub::class);
        $database->identity()->willReturn([
            'projectId' => self::PROJECT_ID,
            'database' => self::DATABASE_NAME,
            'instance' => self::INSTANCE_NAME,
        ]);
        $exception = new \RuntimeException('maintenance test');
        $database->session(Argument::any())->willThrow($exception);
        $config = ['minSessions' => 4];

        $cache = $this->getCacheItemPool($data);
        $pool = new CacheSessionPoolStub($cache, $config, $this->time);
        $pool->setDatabase($database->reveal());
        $caught = false;
        try {
            $pool->maintain();
        } catch (\RuntimeException $e) {
            $caught = ($e->getMessage() === $exception->getMessage());
        }

        if (!$caught) {
            $this->fail('no exception caught');
        }

        $gotData = $pool->cacheItemPool()->getItem($this->cacheKey)->get();
        $this->assertEquals($data, $gotData);
    }

    public function testMaintainNoDatabase()
    {
        $this->expectException('\LogicException');

        $cache = $this->getCacheItemPool();
        $pool = new CacheSessionPoolStub($cache, [], $this->time);
        $pool->maintain();
    }

     /**
     * @dataProvider maintainDataProvider
     */
    public function testMaintainQueue($maintainInterval, $initialItems, $expectedItems, $config = [], $data = [])
    {
        $cache = $this->getCacheItemPool($data + $this->cacheData($initialItems, $maintainInterval));
        $config += ['minSessions' => count($initialItems)];
        $pool = new CacheSessionPoolStub($cache, $config, $this->time);
        $pool->setDatabase($this->getDatabase());
        $pool->maintain();
        $data = $pool->cacheItemPool()->getItem($this->cacheKey)->get();
        $expectedQueue = $this->queue($expectedItems);
        $this->assertEquals($expectedQueue, $data['queue']);
    }

    public function maintainDataProvider()
    {
        return [
            //# 0: fresh, other; no maintain
            [
                null,
                ['s1' => 2900, 's2' => 1000, 's3' => 2500, 's4' => 2000],
                ['s1' => 2900, 's3' => 2500, 's4' => 2000, 's2' => 1000],
            ],
            //# 1: old(1), other; no maintain
            [
                null,
                ['s1' => 3100, 's2' => 1000, 's3' => 2500, 's4' => 2000],
                ['s3' => 2500, 's4' => 2000, 's2' => 1000, 's1' => 0],
            ],
            //# 2: old(2), other; no maintain
            [
                null,
                ['s1' => 3100, 's2' => 1600, 's3' => 3200, 's4' => 2000],
                ['s4' => 2000, 's2' => 1600, 's3' => 0, 's1' => 0],
            ],
            //# 3: fresh
            [
                1510,
                ['s1' => 400, 's2' => 100, 's3' => 300, 's4' => 200],
                ['s1' => 400, 's3' => 300, 's4' => 200, 's2' => 100],
            ],
            //# 4: fresh, other; distribute
            [
                1510,
                ['s1' => 2900, 's2' => 1000, 's3' => 2500, 's4' => 2000],
                ['s3' => 2500, 's4' => 2000, 's2' => 1000, 's1' => 0],
            ],
            //# 5: fresh, old, other
            [
                1510,
                ['s1' => 3100, 's2' => 1000, 's3' => 2500, 's4' => 2000],
                ['s3' => 2500, 's4' => 2000, 's2' => 1000, 's1' => 0],
            ],
            //# 6: old, other; distribute
            [
                1510,
                ['s1' => 3100, 's2' => 1600, 's3' => 2500, 's4' => 2000],
                ['s4' => 2000, 's2' => 1600, 's1' => 0, 's3' => 0],
            ],
            //# 7: old, other; excess; distribute
            [
                1510,
                ['s1' => 3100, 's2' => 3200, 's3' => 2500, 's4' => 2000, 's5' => 1900],
                ['s4' => 2000, 's5' => 1900, 's2' => 0, 's3' => 0, 's1' => 3100],
                ['minSessions' => 4],
            ],
        ];
    }

    public function testWarmupAcquireMaintain()
    {
        $cache = $this->getCacheItemPool([
            'queue' => [
                [
                    'name' => 'existing1',
                    'expiration' => $this->time + 3000,
                ],
                [
                    'name' => 'existing2',
                    'expiration' => $this->time + 3000,
                ],
            ],
            'inUse' => [],
            'toCreate' => [],
            'windowStart' => $this->time,
            'maxInUseSessions' => 1,
            'maintainTime' => $this->time - 600,
        ]);
        $config = [
            'minSessions' => 10,
            'maxSessions' => 20,
        ];
        $pool = new CacheSessionPoolStub($cache, $config, $this->time);
        $pool->setDatabase($this->getDatabase(false, false, 8));
        $pool->warmup();
        $pool->acquire();
        $pool->maintain();

        $queue = $cache->getItem($this->cacheKey)->get()['queue'];
        $this->assertCount(9, $queue);
        $this->assertEquals($this->time + 3000, $queue[0]['expiration']);
        $this->assertEquals($this->time + 3600, $queue[1]['expiration']);
    }
}

//@codingStandardsIgnoreStart
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

class DatabaseStub extends Database
{
    // prevent "get_class() expects parameter 1 to be object" warning when debugging
    public function __debugInfo()
    {
        return [];
    }
}

class SessionStub extends Session
{
    // prevent "get_class() expects parameter 1 to be object" warning when debugging
    public function __debugInfo()
    {
        return [];
    }
}

class DumbObject
{
    public function __get($name)
    {
        return $this;
    }

    public function __call($name, $args)
    {
        return $this;
    }
}
//@codingStandardsIgnoreEnd
