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

use Google\Cloud\Core\Testing\DatastoreOperationRefreshTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Datastore\Connection\ConnectionInterface;
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
use Google\Cloud\Datastore\V1\AllocateIdsRequest;
use Google\Cloud\Datastore\V1\AllocateIdsResponse;
use Google\Cloud\Datastore\V1\Client\DatastoreClient;
use Google\Cloud\Datastore\V1\CommitRequest;
use Google\Cloud\Datastore\V1\CommitRequest\Mode;
use Google\Cloud\Datastore\V1\CommitResponse;
use Google\Cloud\Datastore\V1\LookupRequest;
use Google\Cloud\Datastore\V1\LookupResponse;
use Google\Cloud\Datastore\V1\RollbackRequest;
use Google\Cloud\Datastore\V1\RunAggregationQueryRequest;
use Google\Cloud\Datastore\V1\RunAggregationQueryResponse;
use Google\Cloud\Datastore\V1\RunQueryRequest;
use Google\Cloud\Datastore\V1\RunQueryResponse;
use InvalidArgumentException;
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
    use ProtoEncodeTrait;
    use DatastoreOperationRefreshTrait;
    use ProphecyTrait;

    const PROJECT = 'example-project';
    const TRANSACTION = 'base64EncodedId';

    private $gapicClient;
    private $operation;
    private $transaction;
    private $readOnly;
    private $key;
    private $entity;

    public function setUp(): void
    {
        $this->gapicClient = $this->prophesize(DatastoreClient::class);

        $this->operation = new Operation(
            $this->gapicClient->reveal(),
            self::PROJECT,
            null,
            new EntityMapper(self::PROJECT, false, false)
        );

        $this->transaction = new Transaction(
            $this->operation,
            self::PROJECT,
            self::TRANSACTION
        );

        $this->readOnly = new ReadOnlyTransaction(
            $this->operation,
            self::PROJECT,
            self::TRANSACTION
        );

        $this->key = $this->operation->key('Person', 12345);
        $this->entity = $this->operation->entity($this->key, ['name' => 'John']);
    }

    public function testTesting()
    {
        $this->gapicClient->lookup(
            Argument::type(LookupRequest::class),
            Argument::any()
        )->shouldBeCalled(1)
            ->willReturn(self::generateProto(LookupResponse::class, [
            'found' => [
                [
                    'entity' => $this->entityArray($this->key)
                ]
            ]
        ]));

        $transaction = new Transaction($this->operation, self::PROJECT, self::TRANSACTION);

        $res = $transaction->lookup($this->key);
        $this->assertInstanceOf(Entity::class, $res);
        $this->assertEquals($this->key->keyObject(), $res->key()->keyObject());
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testLookup(string $transactionName)
    {
         $this->gapicClient->lookup(
            Argument::type(LookupRequest::class),
            Argument::any()
        )->shouldBeCalled(1)
            ->willReturn(self::generateProto(LookupResponse::class, [
            'found' => [
                [
                    'entity' => $this->entityArray($this->key)
                ]
            ]
        ]));

        $transaction = $this->$transactionName;

        $res = $transaction->lookup($this->key);
        $this->assertInstanceOf(Entity::class, $res);
        $this->assertEquals($this->key->keyObject(), $res->key()->keyObject());
    }

    public function testLookupWithReadTimeThrowsAnException()
    {
        $this->expectException(InvalidArgumentException::class);
        $time = new Timestamp(new \DateTime());

        $transaction = $this->transaction;

        $res = $transaction->lookup($this->key, ['readTime' => $time]);
        $this->assertInstanceOf(Entity::class, $res);
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testLookupMissing(string $transaction)
    {
        $this->gapicClient->lookup(
            Argument::type(LookupRequest::class),
            Argument::any()
        )->shouldBeCalled(1)->willReturn(self::generateProto(LookupResponse::class, [
            'missing' => [
                [
                    'entity' => $this->entityArray($this->key)
                ]
            ]
        ]));

        $transaction = $this->$transaction;

        $res = $transaction->lookup($this->key);
        $this->assertNull($res);
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testLookupBatch(string $transaction)
    {
        $this->gapicClient->lookup(Argument::that(function (LookupRequest $request) {
                $this->assertEquals(1, count($request->getKeys()));
                return true;
            }), Argument::any())
        ->shouldBeCalled(1)->willReturn(self::generateProto(LookupResponse::class, [
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
        ]));

        $transaction = $this->$transaction;
        $res = $transaction->lookupBatch([$this->key]);
        $this->assertInstanceOf(Entity::class, $res['found'][0]);
        $this->assertInstanceOf(Key::class, $res['missing'][0]);
        $this->assertInstanceOf(Key::class, $res['deferred'][0]);
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testLookupBatchWithReadTimeThrowsAnException(string $transaction)
    {
        $this->expectException(InvalidArgumentException::class);
        $time = new Timestamp(new \DateTime());

        $transaction = $this->$transaction;

        $transaction->lookupBatch([$this->key], ['readTime' => $time]);
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testRunQuery(string $transaction)
    {
        $this->gapicClient->runQuery(Argument::that(function (RunQueryRequest $request) {
            $this->assertEquals(self::PROJECT, $request->getProjectId());
            $this->assertNotNull($request->getGqlQuery());
            $this->assertEquals('SELECT 1=1', $request->getGqlQuery()->getQueryString());
            return true;
        }), Argument::any())->shouldBeCalled(1)->willReturn(self::generateProto(RunQueryResponse::class, [
            'batch' => [
                'entityResults' => [
                    [
                        'entity' => $this->entityArray($this->key)
                    ]
                ]
            ]
        ]));

        $transaction = $this->$transaction;

        $query = $this->prophesize(QueryInterface::class);
        $query->queryKey()->willReturn('gqlQuery');
        $query->queryObject()->willReturn(['queryString' => 'SELECT 1=1']);
        $query->canPaginate()->willReturn(false);

        $res = iterator_to_array($transaction->runQuery($query->reveal()));
        $this->assertContainsOnlyInstancesOf(Entity::class, $res);
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testRunAggregationQuery(string $transaction)
    {
        $expectedQueryString = 'AGGREGATE (COUNT(*)) over (SELECT 1=1)';

        $this->gapicClient->runAggregationQuery(Argument::that(function (RunAggregationQueryRequest $request) use ($expectedQueryString) {
            $this->assertEquals(self::PROJECT, $request->getPartitionId()->getProjectId());
            $this->assertEquals($expectedQueryString, $request->getGqlQuery()->getQueryString());
            return true;
        }), Argument::any())->shouldBeCalled(1)
            ->willReturn(self::generateProto(RunAggregationQueryResponse::class, [
                'batch' => [
                        'aggregationResults' => [
                            [
                                'aggregateProperties' => ['property_1' => ['integerValue' => 1]]
                            ]
                        ],
                        'readTime' => (new \DateTime)->format('Y-m-d\TH:i:s') .'.000001Z'
                    ]
                ]
            ));

        $transaction = $this->$transaction;

        $query = $this->prophesize(AggregationQuery::class);
        $query->queryObject()->willReturn([
            'gqlQuery' => [
                'queryString' => $expectedQueryString
            ]
        ]);

        $res = $transaction->runAggregationQuery($query->reveal());
        $this->assertInstanceOf(AggregationQueryResult::class, $res);
    }

    public function testRunQueryWithReadTimeThrowsAnException()
    {
        $this->expectException(InvalidArgumentException::class);

        $time = new Timestamp(new \DateTime());

        $transaction = $this->readOnly;

        $query = $this->prophesize(QueryInterface::class);
        $query->queryKey()->willReturn('gqlQuery');
        $query->queryObject()->willReturn(['queryString' => 'SELECT 1=1']);

        $res = iterator_to_array($transaction->runQuery($query->reveal(), ['readTime' => $time]));
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testRollback(string $transaction)
    {
        $this->gapicClient->rollback(Argument::that(function (RollbackRequest $request) {
            $this->assertEquals(base64_decode(self::TRANSACTION), $request->getTransaction());
            return true;
        }))->shouldBeCalled(1);

        $transaction = $this->$transaction;

        $transaction->rollback();
    }

    /**
     * @dataProvider mutationsProvider
     */
    public function testEntityMutations($method, $mutation, $key)
    {
        $expectedResult =  [
            'mutationResults' => [
                [
                    'version' => 1,
                    'conflictDetected' => false,
                    'transformResults' => []
                ]
            ],
            'indexUpdates' => 0
        ];

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            $this->assertEquals(base64_decode(self::TRANSACTION), $request->getTransaction());
            $this->assertEquals(Mode::TRANSACTIONAL, $request->getMode());
            $this->assertNotEmpty($request->getMutations());
            return true;
        }), Argument::any())->shouldBeCalled(1)->willReturn(self::generateProto(CommitResponse::class, $expectedResult));

        $this->transaction->$method($this->entity, ['allowOverwrite' => true]);
        $res = $this->transaction->commit();

        $this->assertEquals($expectedResult, $res);
    }

    /**
     * @dataProvider mutationsProvider
     */
    public function testEntityMutationsBatch($method, $mutation, $key)
    {
        $expectedResult = $this->basicCommitResponse();

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            $this->assertEquals(base64_decode(self::TRANSACTION), $request->getTransaction());
            $this->assertEquals(Mode::TRANSACTIONAL, $request->getMode());
            $this->assertNotEmpty($request->getMutations());
            return true;
        }), Argument::any())->shouldBeCalled(1)->willReturn(self::generateProto(CommitResponse::class, $expectedResult));

        $method .= 'Batch';

        $this->transaction->$method([$this->entity], ['allowOverwrite' => true]);
        $res = $this->transaction->commit();

        $this->assertEquals($expectedResult, $res);
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
        $expectedResponse = $this->basicCommitResponse();

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            $this->assertEquals(base64_decode(self::TRANSACTION), $request->getTransaction());
            $this->assertEquals(Mode::TRANSACTIONAL, $request->getMode());
            $this->assertNotEmpty($request->getMutations());
            return true;
        }), Argument::any())->shouldBeCalled(1)->willReturn(self::generateProto(CommitResponse::class, $expectedResponse));

        $keyWithId = clone $key;
        $keyWithId->setLastElementIdentifier($id);
        $this->gapicClient->allocateIds(Argument::that(function (AllocateIdsRequest $request) {
            $this->assertEquals(1, count($request->getKeys()));
            return true;
        }), Argument::any())->shouldBeCalled()->willReturn(self::generateProto(AllocateIdsResponse::class, [
            'keys' => [
                $keyWithId->keyObject()
            ]
        ]));

        $entity = new Entity($key, ['name' => 'John']);
        $this->transaction->$method($entity);
        $res = $this->transaction->commit();

        $this->assertEquals($expectedResponse, $res);
    }

    /**
     * @dataProvider partialKeyMutationsProvider
     */
    public function testBatchMutationsWithPartialKey($method, $mutation, $key, $id)
    {
        $expectedResult = $this->basicCommitResponse();

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            $this->assertEquals(base64_decode(self::TRANSACTION), $request->getTransaction());
            $this->assertEquals(Mode::TRANSACTIONAL, $request->getMode());
            $this->assertNotEmpty($request->getMutations());
            return true;
        }), Argument::any())->shouldBeCalled(1)
            ->willReturn(self::generateProto(CommitResponse::class, $expectedResult));

        $keyWithId = clone $key;
        $keyWithId->setLastElementIdentifier($id);
        $this->gapicClient->allocateIds(Argument::that(function (AllocateIdsRequest $request) {
            $this->assertEquals(1, count($request->getKeys()));
            return true;
        }), Argument::any())->shouldBeCalled(1)->willReturn(self::generateProto(AllocateIdsResponse::class, [
            'keys' => [
                $keyWithId->keyObject()
            ]
        ]));

        $method .= 'Batch';
        $entity = new Entity($key, ['name' => 'John']);
        $this->transaction->$method([$entity]);
        $res = $this->transaction->commit();

        $this->assertEquals($expectedResult, $res);
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
        $expectedResult = $this->basicCommitResponse();

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            $this->assertEquals(base64_decode(self::TRANSACTION), $request->getTransaction());
            $this->assertEquals(Mode::TRANSACTIONAL, $request->getMode());
            $this->assertNotEmpty($request->getMutations());
            return true;
        }), Argument::any())->shouldBeCalled(1)->willReturn(self::generateProto(CommitResponse::class, $expectedResult));

        $this->transaction->delete($this->key);
        $res = $this->transaction->commit();

        $this->assertEquals($expectedResult, $res);
    }

    public function testDeleteBatch()
    {
        $expectedResult = $this->basicCommitResponse();

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            $this->assertEquals(base64_decode(self::TRANSACTION), $request->getTransaction());
            $this->assertEquals(Mode::TRANSACTIONAL, $request->getMode());
            $this->assertNotEmpty($request->getMutations());
            return true;
        }), Argument::any())->shouldBeCalled(1)->willReturn(self::generateProto(CommitResponse::class, $expectedResult));

        $this->transaction->deleteBatch([$this->key]);
        $res = $this->transaction->commit();

        $this->assertEquals($expectedResult, $res);
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

    public function transactionProvider()
    {
        return [
            [
                'transaction'
            ],
            [
                'readOnly'
            ]
        ];
    }

    private function basicCommitResponse(): array
    {
        return [
            'mutationResults' => [
                [
                    'version' => 1,
                    'conflictDetected' => false,
                    'transformResults' => []
                ]
            ],
            'indexUpdates' => 0
        ];
    }
}
