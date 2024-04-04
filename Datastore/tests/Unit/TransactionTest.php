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

namespace Google\Cloud\Datastore\Tests\Unit;

use Google\ApiCore\Serializer;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\DatastoreOperationRefreshTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Datastore\Entity;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Operation;
use Google\Cloud\Datastore\Query\Aggregation;
use Google\Cloud\Datastore\Query\AggregationQuery;
use Google\Cloud\Datastore\Query\AggregationQueryResult;
use Google\Cloud\Datastore\Query\QueryInterface;
use Google\Cloud\Datastore\ReadOnlyTransaction;
use Google\Cloud\Datastore\Transaction;
use Google\Cloud\Datastore\V1\CommitRequest\Mode;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * This test case includes a data provider to run tests on both rw and ro transactions.
 *
 * @group datastore
 * @group datastore-transaction
 */
class TransactionTest extends TestCase
{
    use DatastoreOperationRefreshTrait;
    use ProphecyTrait;
    use ApiHelperTrait;

    const PROJECT = 'example-project';
    const TRANSACTION = 'transaction-id';

    private $transaction;
    private $readOnly;
    private $key;
    private $entity;
    private $serializer;
    private $requestHandler;

    public function setUp(): void
    {
        $this->requestHandler = $this->prophesize(RequestHandler::class);

        $this->serializer = new Serializer([], [
            'google.protobuf.Value' => function ($v) {
                return $this->flattenValue($v);
            },
            'google.protobuf.Timestamp' => function ($v) {
                return $this->formatTimestampFromApi($v);
            }
        ], [], [
            'google.protobuf.Timestamp' => function ($v) {
                if (is_string($v)) {
                    $dt = new \DateTime($v);
                    return ['seconds' => $dt->format('U')];
                }
                return $v;
            }
        ]);

        $op = new Operation(
            $this->requestHandler->reveal(),
            $this->serializer,
            self::PROJECT,
            null,
            new EntityMapper(self::PROJECT, false, false)
        );

        $this->transaction = TestHelpers::stub(Transaction::class, [
            $op, self::PROJECT, self::TRANSACTION
        ], ['operation']);

        $this->readOnly = TestHelpers::stub(ReadOnlyTransaction::class, [
            $op, self::PROJECT, self::TRANSACTION
        ], ['operation']);

        $this->key = $op->key('Person', 12345);
        $this->entity = $op->entity($this->key, ['name' => 'John']);
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testLookup(callable $transaction)
    {
        $this->mockSendRequest(
            'lookup',
            [
                'readOptions' => ['transaction' => self::TRANSACTION],
                'keys' => [$this->key->keyObject()],
            ],
            [
                'found' => [
                    [
                        'entity' => $this->entityArray($this->key)
                    ]
                ]
            ],
            0
        );

        $transaction = $transaction();
        $this->refreshOperation($transaction,$this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $res = $transaction->lookup($this->key);
        $this->assertInstanceOf(Entity::class, $res);
        $this->assertEquals($this->key->keyObject(), $res->key()->keyObject());
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testLookupMissing(callable $transaction)
    {
        $this->mockSendRequest(
            'lookup',
            ['keys' => [$this->key->keyObject()]],
            [
                'missing' => [
                    [
                        'entity' => $this->entityArray($this->key)
                    ]
                ]
            ],
            0
        );

        $transaction = $transaction();
        $this->refreshOperation($transaction,$this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $res = $transaction->lookup($this->key);
        $this->assertNull($res);
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testLookupBatch(callable $transaction)
    {
        $this->mockSendRequest(
            'lookup',
            ['keys' => [$this->key->keyObject()]],
            [
                'found' => [
                    [
                        'entity' => $this->entityArray($this->key)
                    ]
                ],
                'missing' => [
                    [
                        'entity' => $this->entityArray($this->key)
                    ]
                ],
                'deferred' => [
                    $this->key->keyObject()
                ]
            ],
            0
        );

        $transaction = $transaction();
        $this->refreshOperation($transaction,$this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $res = $transaction->lookupBatch([$this->key]);
        $this->assertInstanceOf(Entity::class, $res['found'][0]);
        $this->assertInstanceOf(Key::class, $res['missing'][0]);
        $this->assertInstanceOf(Key::class, $res['deferred'][0]);
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testLookupBatchWithReadTime(callable $transaction)
    {
        $time = new Timestamp(new \DateTime());
        $this->mockSendRequest(
            'lookup',
            ['readOptions' => ['readTime' => $time]],
            [
                'found' => [
                    [
                        'entity' => $this->entityArray($this->key)
                    ]
                ]
            ],
            0
        );

        $transaction = $transaction();
        $this->refreshOperation($transaction,$this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $res = $transaction->lookupBatch([$this->key], ['readTime' => $time]);
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testRunQuery(callable $transaction)
    {
        $this->mockSendRequest(
            'runQuery',
            [
                'partitionId' => ['projectId' => self::PROJECT],
                'gqlQuery' => ['queryString' => 'SELECT 1=1']
            ],
            [
                'batch' => [
                    'entityResults' => [
                        [
                            'entity' => $this->entityArray($this->key)
                        ]
                    ]
                ]
            ],
            0
        );

        $transaction = $transaction();
        $this->refreshOperation($transaction,$this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $query = $this->prophesize(QueryInterface::class);
        $query->queryKey()->willReturn('gqlQuery');
        $query->queryObject()->willReturn(['queryString' => 'SELECT 1=1']);

        $res = iterator_to_array($transaction->runQuery($query->reveal()));
        $this->assertContainsOnlyInstancesOf(Entity::class, $res);
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testRunAggregationQuery(callable $transaction)
    {
        $this->mockSendRequest(
            'runAggregationQuery',
            [
                'partitionId' => ['projectId' => self::PROJECT],
                'gqlQuery' => ['queryString' => 'AGGREGATE (COUNT(*)) over (SELECT 1=1)'],
            ],
            [
                'batch' => [
                    'aggregationResults' => [
                        [
                            'aggregateProperties' => ['property_1' => 1]
                        ]
                    ],
                    'readTime' => (new \DateTime())->format('Y-m-d\TH:i:s') .'.000001Z'
                ]
            ],
            0
        );

        $transaction = $transaction();
        $this->refreshOperation($transaction,$this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $query = $this->prophesize(AggregationQuery::class);
        $query->queryObject()->willReturn([
            'gqlQuery' => [
                'queryString' => 'AGGREGATE (COUNT(*)) over (SELECT 1=1)'
            ]
        ]);

        $res = $transaction->runAggregationQuery($query->reveal());
        $this->assertInstanceOf(AggregationQueryResult::class, $res);
    }

    public function testRunQueryWithReadTime()
    {
        $time = new Timestamp(new \DateTime());

        $this->mockSendRequest(
            'runQuery',
            [
                'partitionId' => ['projectId' => self::PROJECT],
                'gqlQuery' => ['queryString' => 'SELECT 1=1'],
                'readOptions' => ['readTime' => $time]
            ],
            [
                'batch' => [
                    'entityResults' => [
                        [
                            'entity' => $this->entityArray($this->key)
                        ]
                    ]
                ]
            ],
            0
        );

        $transaction = $this->readOnly;
        $this->refreshOperation($transaction,$this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $query = $this->prophesize(QueryInterface::class);
        $query->queryKey()->willReturn('gqlQuery');
        $query->queryObject()->willReturn(['queryString' => 'SELECT 1=1']);

        $res = iterator_to_array($transaction->runQuery($query->reveal(), ['readTime' => $time]));
        $this->assertContainsOnlyInstancesOf(Entity::class, $res);
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testRollback(callable $transaction)
    {
        $this->mockSendRequest('rollback', ['transaction' => self::TRANSACTION], [], 0);

        $transaction = $transaction();
        $this->refreshOperation($transaction,$this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $transaction->rollback();
    }

    /**
     * @dataProvider mutationsProvider
     */
    public function testEntityMutations($method, $mutation, $key)
    {
        $this->mockSendRequest(
            'commit',
            [
                'transaction' => self::TRANSACTION,
                'mode' => Mode::TRANSACTIONAL,
                'mutations' => [[$method => $mutation]]
            ],
            $this->commitResponse(),
            0
        );

        $this->refreshOperation($this->transaction,$this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $this->transaction->$method($this->entity, ['allowOverwrite' => true]);
        $res = $this->transaction->commit();

        $this->assertEquals($this->commitResponse(), $res);
    }

    /**
     * @dataProvider mutationsProvider
     */
    public function testEntityMutationsBatch($method, $mutation, $key)
    {
        $this->mockSendRequest(
            'commit',
            [
                'transaction' => self::TRANSACTION,
                'mode' => Mode::TRANSACTIONAL,
                'mutations' => [[$method => $mutation]]
            ],
            $this->commitResponse(),
            0
        );

        $this->refreshOperation($this->transaction,$this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $method .= 'Batch';

        $this->transaction->$method([$this->entity], ['allowOverwrite' => true]);
        $res = $this->transaction->commit();

        $this->assertEquals($this->commitResponse(), $res);
    }

    public function mutationsProvider()
    {
        return $this->mutationsProviderProvider(12345);
    }

    /**
     * @dataProvider partialKeyMutationsProvider
     */
    public function testMutationsWithPartialKey($method, $mutation, $key, $id)
    {
        $this->mockSendRequest(
            'commit',
            [
                'transaction' => self::TRANSACTION,
                'mode' => Mode::TRANSACTIONAL,
                'mutations' => [[$method => $mutation]]
            ],
            $this->commitResponse(),
            0
        );

        $keyWithId = clone $key;
        $keyWithId->setLastElementIdentifier($id);
        $this->mockSendRequest(
            'allocateIds',
            ['keys' => [$key->keyObject()]],
            ['keys' => [$keyWithId->keyObject()]]
        );

        $this->refreshOperation($this->transaction,$this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $entity = new Entity($key, ['name' => 'John']);
        $this->transaction->$method($entity);
        $res = $this->transaction->commit();

        $this->assertEquals($this->commitResponse(), $res);
    }

    /**
     * @dataProvider partialKeyMutationsProvider
     */
    public function testBatchMutationsWithPartialKey($method, $mutation, $key, $id)
    {
        $this->mockSendRequest(
            'commit',
            [
                'transaction' => self::TRANSACTION,
                'mode' => Mode::TRANSACTIONAL,
                'mutations' => [[$method => $mutation]]
            ],
            $this->commitResponse(),
            0
        );

        $keyWithId = clone $key;
        $keyWithId->setLastElementIdentifier($id);
        $this->mockSendRequest(
            'allocateIds',
            ['keys' => [$key->keyObject()]],
            ['keys' => [$keyWithId->keyObject()]]
        );

        $this->refreshOperation($this->transaction,$this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $method .= 'Batch';
        $entity = new Entity($key, ['name' => 'John']);
        $this->transaction->$method([$entity]);
        $res = $this->transaction->commit();

        $this->assertEquals($this->commitResponse(), $res);
    }

    public function partialKeyMutationsProvider()
    {
        $res = $this->mutationsProviderProvider(12345, true);
        return array_filter($res, function ($case) {
            return $case[0] !== 'update';
        });
    }

    public function testDelete()
    {
        $this->mockSendRequest(
            'commit',
            [
                'transaction' => self::TRANSACTION,
                'mode' => Mode::TRANSACTIONAL,
                'mutations' => [['delete' => $this->key->keyObject()]]
            ],
            $this->commitResponse(),
            0
        );

        $this->refreshOperation($this->transaction,$this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $this->transaction->delete($this->key);
        $res = $this->transaction->commit();

        $this->assertEquals($this->commitResponse(), $res);
    }

    public function testDeleteBatch()
    {

        $this->mockSendRequest(
            'commit',
            [
                'transaction' => self::TRANSACTION,
                'mode' => Mode::TRANSACTIONAL,
                'mutations' => [['delete' => $this->key->keyObject()]]
            ],
            $this->commitResponse(),
            0
        );

        $this->refreshOperation($this->transaction,$this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $this->transaction->deleteBatch([$this->key]);
        $res = $this->transaction->commit();

        $this->assertEquals($this->commitResponse(), $res);
    }

    private function entityArray(Key $key)
    {
        return [
            'key' => $key->keyObject(),
            'properties' => [
                'name' => [
                    'stringValue' => 'John'
                ]
            ]
        ];
    }

    private function mutationsProviderProvider($id, $partialKey = false)
    {
        $key = new Key(self::PROJECT);
        $key->pathElement('Person', !$partialKey ? $id : null);
        $mutation = $this->entityArray($key);

        if ($partialKey) {
            $mutation['key']['path'][0]['id'] = $id;
        }

        return [
            ['insert', $mutation, clone $key, $id],
            ['update', $mutation, clone $key, $id],
            ['upsert', $mutation, clone $key, $id],
        ];
    }

    private function commitResponse()
    {
        return [
            'mutationResults' => [
                [
                    'version' => 1
                ]
            ]
        ];
    }

    public function transactionProvider()
    {
        // init so the callbacks have a reference to hold until invoked.
        $this->setUp();

        return [
            // return callables to get around phpunit's annoying habit of running data providers way too early.
            [
                function () {
                    return $this->transaction;
                }
            ], [
                function () {
                    return $this->readOnly;
                }
            ]
        ];
    }
}
