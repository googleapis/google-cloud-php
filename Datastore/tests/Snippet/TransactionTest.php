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

namespace Google\Cloud\Datastore\Tests\Snippet;

use Google\Cloud\Core\Testing\DatastoreOperationRefreshTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Operation;
use Google\Cloud\Datastore\Query\AggregationQuery;
use Google\Cloud\Datastore\Query\QueryInterface;
use Google\Cloud\Datastore\Tests\Unit\ProtoEncodeTrait;
use Google\Cloud\Datastore\Transaction;
use Google\Cloud\Datastore\V1\AllocateIdsResponse;
use Google\Cloud\Datastore\V1\BeginTransactionRequest;
use Google\Cloud\Datastore\V1\BeginTransactionResponse;
use Google\Cloud\Datastore\V1\Client\DatastoreClient as GapicDatastoreClient;
use Google\Cloud\Datastore\V1\CommitRequest;
use Google\Cloud\Datastore\V1\CommitResponse;
use Google\Cloud\Datastore\V1\LookupRequest;
use Google\Cloud\Datastore\V1\LookupResponse;
use Google\Cloud\Datastore\V1\RollbackResponse;
use Google\Cloud\Datastore\V1\RunAggregationQueryRequest;
use Google\Cloud\Datastore\V1\RunAggregationQueryResponse;
use Google\Cloud\Datastore\V1\RunQueryRequest;
use Google\Cloud\Datastore\V1\RunQueryResponse;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group datastore
 */
class TransactionTest extends SnippetTestCase
{
    use DatastoreOperationRefreshTrait;
    use ProphecyTrait;
    use ProtoEncodeTrait;

    const PROJECT = 'my-awesome-project';
    const TRANSACTION = 'transaction-id';

    private $gapicClient;
    private $operation;
    private $transaction;
    private $client;
    private $key;

    public function setUp(): void
    {
        $this->gapicClient = $this->prophesize(GapicDatastoreClient::class);

        $this->gapicClient->beginTransaction(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(BeginTransactionResponse::class, [
                'transaction' => base64_encode(self::TRANSACTION)
            ]));

        $this->client = new DatastoreClient([
            'datastoreClient' => $this->gapicClient->reveal()
        ]);
        $this->transaction = $this->client->transaction();

        $this->key = new Key('my-awesome-project', [
            [
                'path' => [
                    ['kind' => 'Person', 'name' => 'Bob']
                ]
            ]
        ]);
    }

    public function testClass()
    {
        $this->gapicClient->beginTransaction(Argument::type(BeginTransactionRequest::class), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(BeginTransactionResponse::class, [
                'transaction' => 'foo'
            ]));

        $snippet = $this->snippetFromClass(Transaction::class);
        $snippet->setLine(2, '');
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke('transaction');
        $this->assertInstanceOf(Transaction::class, $res->returnVal());
    }

    public function testInsert()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'insert');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('transaction', $this->transaction);

        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) {
                $this->assertEquals(self::TRANSACTION, $request->getTransaction());
                $this->assertEquals('insert', $request->getMutations()[0]->getOperation());

                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn(self::generateProto(CommitResponse::class, [
            'mutationResults' => [
                ['version' => 1]
            ]
        ]));

        $res = $snippet->invoke();
    }

    public function testInsertBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'insertBatch');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('transaction', $this->transaction);

        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) {
                $this->assertEquals(self::TRANSACTION, $request->getTransaction());
                $this->assertEquals('insert', $request->getMutations()[0]->getOperation());
                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn(self::generateProto(CommitResponse::class, [
            'mutationResults' => [
                ['version' => 1]
            ]
        ]));

        $this->allocateIdsConnectionMock();

        $res = $snippet->invoke();
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'update');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('transaction', $this->transaction);
        $snippet->addLocal('entity', $this->client->entity($this->key, [], [
            'populatedByService' => true
        ]));

        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) {
                $this->assertEquals(self::TRANSACTION, $request->getTransaction());
                $this->assertEquals('update', $request->getMutations()[0]->getOperation());
                return true;
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn(self::generateProto(CommitResponse::class, [
            'mutationResults' => [
                ['version' => 1]
            ]
        ]));

        $res = $snippet->invoke();
    }

    public function testUpdateBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'updateBatch');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('transaction', $this->transaction);
        $snippet->addLocal('entities', [
            $this->client->entity($this->client->key('Person', 'Bob'), [], ['populatedByService' => true]),
            $this->client->entity($this->client->key('Person', 'John'), [], ['populatedByService' => true])
        ]);

        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) {
                $this->assertEquals(self::TRANSACTION, $request->getTransaction());
                $this->assertEquals('update', $request->getMutations()[0]->getOperation());
                return true;
            }),
            Argument::any()
        )->shouldBeCalled()
            ->willReturn(self::generateProto(CommitResponse::class, [
            'mutationResults' => [
                ['version' => 1]
            ]
        ]));

        $res = $snippet->invoke();
    }

    public function testUpsert()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'upsert');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('transaction', $this->transaction);
        $snippet->addLocal('entity', $this->client->entity($this->key, [], [
            'populatedByService' => true
        ]));

        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) {
                    $this->assertEquals(self::TRANSACTION, $request->getTransaction());
                    $this->assertEquals('upsert', $request->getMutations()[0]->getOperation());
                    return true;
            }),
            Argument::any()
        )
            ->shouldBeCalled()
            ->willReturn(self::generateProto(CommitResponse::class, [
                'mutationResults' => [
                    ['version' => 1]
                ]
            ]));

        $res = $snippet->invoke();
    }

    public function testUpsertBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'upsertBatch');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('transaction', $this->transaction);
        $snippet->addLocal('entities', [
            $this->client->entity($this->client->key('Person', 'Bob'), [], ['populatedByService' => true]),
            $this->client->entity($this->client->key('Person', 'John'), [], ['populatedByService' => true])
        ]);

        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) {
                    $this->assertEquals(self::TRANSACTION, $request->getTransaction());
                    $this->assertEquals('upsert', $request->getMutations()[0]->getOperation());
                    return true;
            }),
            Argument::any()
        )
            ->shouldBeCalled()
            ->willReturn(self::generateProto(CommitResponse::class, [
                'mutationResults' => [
                    ['version' => 1]
                ]
            ]));

        $res = $snippet->invoke();
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'delete');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('transaction', $this->transaction);

        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) {
                    $this->assertEquals(self::TRANSACTION, $request->getTransaction());
                    $this->assertEquals('delete', $request->getMutations()[0]->getOperation());
                    return true;
            }),
            Argument::any()
        )
            ->shouldBeCalled()
            ->willReturn(self::generateProto(CommitResponse::class, [
                'mutationResults' => [
                    ['version' => 1]
                ]
            ]));

        $res = $snippet->invoke();
    }

    public function testDeleteBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'deleteBatch');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('transaction', $this->transaction);

        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) {
                    $this->assertEquals(self::TRANSACTION, $request->getTransaction());
                    $this->assertEquals('delete', $request->getMutations()[0]->getOperation());
                    return true;
            }),
            Argument::any()
        )
            ->shouldBeCalled()
            ->willReturn(self::generateProto(CommitResponse::class, [
                'mutationResults' => [
                    ['version' => 1]
                ]
            ]));


        $res = $snippet->invoke();
    }

    public function testLookup()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'lookup');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('transaction', $this->transaction);

        $this->gapicClient->lookup(
            Argument::that(function (LookupRequest $request) {
                    $this->assertEquals(self::TRANSACTION, $request->getReadOptions()->getTransaction());
                    return true;
            }),
            Argument::any()
        )
            ->shouldBeCalled()
            ->willReturn(self::generateProto(LookupResponse::class, [
                'found' => [
                    [
                        'entity' => [
                            'key' => [
                                'path' => [
                                    ['kind' => 'Person', 'name' => 'Bob']
                                ]
                            ],
                            'properties' => [
                                'firstName' => [
                                    'stringValue' => 'Bob'
                                ]
                            ]
                        ]
                    ]
                ]
            ]));

        $res = $snippet->invoke();
        $this->assertEquals('Bob', $res->output());
    }

    public function testLookupBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'lookupBatch');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('transaction', $this->transaction);

        $this->gapicClient->lookup(
            Argument::that(function (LookupRequest $request) {
                    $this->assertEquals(self::TRANSACTION, $request->getReadOptions()->getTransaction());
                    return true;
            }),
            Argument::any()
        )
            ->shouldBeCalled()
            ->willReturn(self::generateProto(LookupResponse::class, [
                'found' => [
                    [
                        'entity' => [
                            'key' => [
                                'path' => [
                                    ['kind' => 'Person', 'name' => 'Bob']
                                ]
                            ],
                            'properties' => [
                                'firstName' => [
                                    'stringValue' => 'Bob'
                                ]
                            ]
                        ]
                    ],
                    [
                        'entity' => [
                            'key' => [
                                'path' => [
                                    ['kind' => 'Person', 'name' => 'John']
                                ]
                            ],
                            'properties' => [
                                'firstName' => [
                                    'stringValue' => 'John'
                                ]
                            ]
                        ]
                    ]
                ]
            ]));

        $res = $snippet->invoke();
        $this->assertEquals("Bob", explode("\n", $res->output())[0]);
        $this->assertEquals("John", explode("\n", $res->output())[1]);
    }

    public function testRunQuery()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'runQuery');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('transaction', $this->transaction);

        $query = $this->prophesize(QueryInterface::class);
        $query->queryObject()->willReturn([]);
        $query->queryKey()->willReturn('query');
        $query->canPaginate()->willReturn(false);
        $snippet->addLocal('query', $query->reveal());

        $this->gapicClient->runQuery(
            Argument::that(function (RunQueryRequest $request) {
                    $this->assertEquals(self::TRANSACTION, $request->getReadOptions()->getTransaction());
                    return true;
            }),
            Argument::any()
        )
            ->shouldBeCalled()
            ->willReturn(self::generateProto(RunQueryResponse::class, [
                'batch' => [
                    'entityResults' => [
                        [
                            'entity' => [
                                'key' => [
                                    'path' => [
                                        ['kind' => 'Person', 'name' => 'Bob']
                                    ]
                                ],
                                'properties' => [
                                    'firstName' => [
                                        'stringValue' => 'Bob'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]));

        $res = $snippet->invoke('result');
        $this->assertEquals('Bob', $res->output());
    }

    public function testRunAggregationQuery()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'runAggregationQuery');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('transaction', $this->transaction);

        $query = $this->prophesize(AggregationQuery::class);
        $query->queryObject()->willReturn([]);
        $snippet->addLocal('query', $query->reveal());

        $this->gapicClient->runAggregationQuery(
            Argument::that(function (RunAggregationQueryRequest $request) {
                    $this->assertEquals(self::TRANSACTION, $request->getReadOptions()->getTransaction());
                    return true;
            }),
            Argument::any()
        )
            ->shouldBeCalled()
            ->willReturn(self::generateProto(RunAggregationQueryResponse::class, [
                'batch' => [
                    'aggregationResults' => [
                        [
                            'aggregateProperties' => [
                                'total' => [
                                    'integerValue' => 1
                                ],
                            ]
                        ]
                    ],
                    'readTime' => [
                        'seconds' => 1,
                        'nanos' => 2
                    ]
                ]
            ]));

        $res = $snippet->invoke();
        $this->assertEquals('1', $res->output());
    }

    public function testCommit()
    {
         $keys = [
            $this->client->key('Person', 'Bob'),
            $this->client->key('Person', 'John')
         ];

         $this->transaction->deleteBatch($keys);

         $snippet = $this->snippetFromMethod(Transaction::class, 'commit');
         $snippet->addLocal('transaction', $this->transaction);

         $this->gapicClient->commit(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(CommitResponse::class, []));

         $snippet->invoke();
    }

    public function testRollback()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'rollback');
        $snippet->addLocal('transaction', $this->transaction);

        $this->gapicClient->rollback(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(RollbackResponse::class, []));

        $snippet->invoke();
    }

    // ******** HELPERS

    private function allocateIdsConnectionMock(): void
    {
        $this->gapicClient->allocateIds(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(AllocateIdsResponse::class, [
                'keys' => [
                    [
                        'path' => [
                            [
                                'kind' => 'Person',
                                'id' => '4682475895'
                            ]
                        ]
                    ],
                    [
                        'path' => [
                            [
                                'kind' => 'Person',
                                'id' => '4682475896'
                            ]
                        ]
                    ]
                ]
            ]));
    }
}
