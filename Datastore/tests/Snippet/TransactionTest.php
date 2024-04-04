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

use Google\ApiCore\Serializer;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\DatastoreOperationRefreshTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Operation;
use Google\Cloud\Datastore\Query\AggregationQuery;
use Google\Cloud\Datastore\Query\QueryInterface;
use Google\Cloud\Datastore\Transaction;
use Google\Cloud\Datastore\V1\Client\DatastoreClient as V1DatastoreClient;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group datastore
 */
class TransactionTest extends SnippetTestCase
{
    use DatastoreOperationRefreshTrait;
    use ProphecyTrait;
    use ApiHelperTrait;

    const PROJECT = 'my-awesome-project';
    const TRANSACTION = 'transaction-id';

    private $operation;
    private $transaction;
    private $client;
    private $key;
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

        $operation = new Operation(
            $this->requestHandler->reveal(),
            $this->serializer,
            self::PROJECT,
            '',
            new EntityMapper(self::PROJECT, false, false)
        );

        $this->transaction = TestHelpers::stub(Transaction::class, [
            $operation,
            self::PROJECT,
            self::TRANSACTION
        ], ['operation']);

        $this->client = TestHelpers::stub(DatastoreClient::class, [], ['operation']);

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
        $this->mockSendRequest(
            'beginTransaction',
            [],
            ['transaction' => 'foo'],
            0
        );

        $this->refreshOperation($this->client, $this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

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

        $this->mockSendRequestForCommit('insert', [
            'mutationResults' => [
                ['version' => 1]
            ]
        ]);

        $this->refreshOperation($this->transaction, $this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $res = $snippet->invoke();
    }

    public function testInsertBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'insertBatch');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('transaction', $this->transaction);

        $this->mockSendRequestForCommit('insert', [
            'mutationResults' => [
                ['version' => 1]
            ]
        ]);

        $this->allocateIdsRequestHandlerMock();

        $this->refreshOperation($this->transaction, $this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

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

        $this->mockSendRequestForCommit('update', [
            'mutationResults' => [
                ['version' => 1]
            ]
        ]);

        $this->refreshOperation($this->transaction, $this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

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

        $this->mockSendRequestForCommit('update', []);

        $snippet->invoke();
    }

    public function testUpsert()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'upsert');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('transaction', $this->transaction);
        $snippet->addLocal('entity', $this->client->entity($this->key, [], [
            'populatedByService' => true
        ]));

        $this->mockSendRequestForCommit('upsert', [
            'mutationResults' => [
                ['version' => 1]
            ]
        ]);

        $this->refreshOperation($this->transaction, $this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

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

        $this->mockSendRequestForCommit('upsert', []);

        $snippet->invoke();
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'delete');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('transaction', $this->transaction);

        $this->mockSendRequestForCommit('delete', [
            'mutationResults' => [
                ['version' => 1]
            ]
        ]);

        $this->refreshOperation($this->transaction, $this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $res = $snippet->invoke();
    }

    public function testDeleteBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'deleteBatch');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('transaction', $this->transaction);

        $this->mockSendRequestForCommit('delete', []);

        $res = $snippet->invoke();
    }

    public function testLookup()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'lookup');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('transaction', $this->transaction);

        $this->mockSendRequest(
            'lookup',
            ['readOptions' => ['transaction' => self::TRANSACTION]],
            [
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
            ]
        );

        $this->refreshOperation($this->transaction, $this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $res = $snippet->invoke();
        $this->assertEquals('Bob', $res->output());
    }

    public function testLookupBatch()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'lookupBatch');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('transaction', $this->transaction);

        $this->mockSendRequest(
            'lookup',
            ['readOptions' => ['transaction' => self::TRANSACTION]],
            [
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
            ]
        );

        $this->refreshOperation($this->transaction, $this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

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
        $snippet->addLocal('query', $query->reveal());

        $this->mockSendRequest(
            'runQuery',
            ['readOptions' => ['transaction' => self::TRANSACTION]],
            [
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
            ],
            0
        );

        $this->refreshOperation($this->transaction, $this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

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

        $this->mockSendRequest(
            'runAggregationQuery',
            ['readOptions' => ['transaction' => self::TRANSACTION]],
            [
                'batch' => [
                    'aggregationResults' => [
                        [
                            'aggregateProperties' => [
                                'total' => 1,
                            ]
                        ]
                    ],
                    'readTime' => (new \DateTime)->format('Y-m-d\TH:i:s') .'.000001Z'
                ]
            ],
            0
        );

        $this->refreshOperation($this->transaction, $this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $res = $snippet->invoke();
        $this->assertEquals('1', $res->output());
    }

    public function testCommit()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'commit');
        $snippet->addLocal('transaction', $this->transaction);

        $this->mockSendRequest('commit', [], [], 0);

        $this->refreshOperation($this->transaction, $this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $snippet->invoke();
    }

    public function testRollback()
    {
        $snippet = $this->snippetFromMethod(Transaction::class, 'rollback');
        $snippet->addLocal('transaction', $this->transaction);

        $this->mockSendRequest('rollback', [], [], 0);

        $this->refreshOperation($this->transaction, $this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);

        $snippet->invoke();
    }

    // ******** HELPERS

    private function allocateIdsRequestHandlerMock()
    {
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'allocateIds',
            Argument::cetera()
        )->shouldBeCalled()->willReturn([
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
        ]);

        return $this->requestHandler->reveal();
    }

    private function mockSendRequestForCommit($mutationType, $returnValue)
    {
        $hazzer = 'has' . ucfirst($mutationType);
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'commit',
            Argument::that(
                fn ($arg) => $arg->getTransaction() == self::TRANSACTION && $arg->getMutations()[0]->$hazzer()
            ),
            Argument::any()
        )->shouldBeCalled()->willReturn($returnValue);
    }
}
