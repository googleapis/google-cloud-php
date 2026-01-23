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

use Google\Cloud\Core\Int64;
use Google\Cloud\Core\Testing\DatastoreOperationRefreshTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Datastore\Blob;
use Google\Cloud\Datastore\Cursor;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Entity;
use Google\Cloud\Datastore\GeoPoint;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Query\GqlQuery;
use Google\Cloud\Datastore\Query\AggregationQuery;
use Google\Cloud\Datastore\Query\Query;
use Google\Cloud\Datastore\Query\QueryInterface;
use Google\Cloud\Datastore\ReadOnlyTransaction;
use Google\Cloud\Datastore\Tests\Unit\ProtoEncodeTrait;
use Google\Cloud\Datastore\Transaction;
use Google\Cloud\Datastore\V1\AllocateIdsResponse;
use Google\Cloud\Datastore\V1\BeginTransactionRequest;
use Google\Cloud\Datastore\V1\BeginTransactionResponse;
use Google\Cloud\Datastore\V1\Client\DatastoreClient as GapicDatastoreClient;
use Google\Cloud\Datastore\V1\CommitRequest;
use Google\Cloud\Datastore\V1\CommitResponse;
use Google\Cloud\Datastore\V1\LookupResponse;
use Google\Cloud\Datastore\V1\RunAggregationQueryRequest;
use Google\Cloud\Datastore\V1\RunAggregationQueryResponse;
use Google\Cloud\Datastore\V1\RunQueryRequest;
use Google\Cloud\Datastore\V1\RunQueryResponse;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group datastore
 */
class DatastoreClientTest extends SnippetTestCase
{
    use DatastoreOperationRefreshTrait;
    use ProphecyTrait;
    use ProtoEncodeTrait;

    const PROJECT = 'example-project';

    private $gapicClient;
    private $operation;
    private $client;
    private $key;

    public function setUp(): void
    {
        $this->gapicClient = $this->prophesize(GapicDatastoreClient::class);
        $this->client = new DatastoreClient([
            'datastoreClient' => $this->gapicClient->reveal()
        ]);

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
        $snippet = $this->snippetFromClass(DatastoreClient::class);
        $res = $snippet->invoke('datastore');

        $this->assertInstanceOf(DatastoreClient::class, $res->returnVal());
    }

    public function testMultiTenant()
    {
        $snippet = $this->snippetFromClass(DatastoreClient::class, 1);
        $res = $snippet->invoke('datastore');

        $this->assertInstanceOf(DatastoreClient::class, $res->returnVal());

        $ds = $res->returnVal();

        $ref = new \ReflectionClass($ds);
        $opProp = $ref->getProperty('operation');
        $op = $opProp->getValue($ds);

        $opRef = new \ReflectionClass($op);
        $nsProp = $opRef->getProperty('namespaceId');

        $this->assertEquals('my-application-namespace', $nsProp->getValue($op));
    }

    public function testMultipleDatabases()
    {
        $snippet = $this->snippetFromClass(DatastoreClient::class, 3);
        $res = $snippet->invoke('datastore');

        $this->assertInstanceOf(DatastoreClient::class, $res->returnVal());

        $ds = $res->returnVal();

        $ref = new \ReflectionClass($ds);
        $opProp = $ref->getProperty('operation');
        $op = $opProp->getValue($ds);

        $opRef = new \ReflectionClass($op);
        $dsProp = $opRef->getProperty('databaseId');

        $this->assertEquals('my-database', $dsProp->getValue($op));
    }

    public function testEmulator()
    {
        $snippet = $this->snippetFromClass(DatastoreClient::class, 2);
        $res = $snippet->invoke('datastore');

        $this->assertInstanceOf(DatastoreClient::class, $res->returnVal());

        $this->assertEquals('localhost:8900', getenv('DATASTORE_EMULATOR_HOST'));
    }

    public function testKey()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'key');
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke('key');
        $this->assertInstanceOf(Key::class, $res->returnVal());

        $pathElement = $res->returnVal()->keyObject()['path'][0];
        $this->assertEquals(['kind' => 'Person', 'name' => 'Bob'], $pathElement);
    }

    public function testKeyForcedIdentifierType()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'key', 1);
        $snippet->addLocal('datastore', $this->client);
        $snippet->addUse(Key::class);

        $res = $snippet->invoke('key');
        $this->assertInstanceOf(Key::class, $res->returnVal());

        $pathElement = $res->returnVal()->keyObject()['path'][0];
        $this->assertEquals(['kind' => 'Robots', 'name' => '1337'], $pathElement);
    }

    public function testKeys()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'keys');
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke('keys');
        $this->assertIsArray($res->returnVal());
        $this->assertCount(10, $res->returnVal());
        $this->assertInstanceOf(Key::class, $res->returnVal()[0]);
        $this->assertEquals('Person', $res->returnVal()[0]->keyObject()['path'][0]['kind']);
    }

    public function testKeysWithAncestors()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'keys', 1);
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke('keys');

        $this->assertIsArray($res->returnVal());
        $this->assertCount(3, $res->returnVal());
        $this->assertInstanceOf(Key::class, $res->returnVal()[0]);

        $this->assertEquals(['kind' => 'Person'], $res->returnVal()[0]->keyObject()['path'][2]);
        $this->assertEquals(['kind' => 'Person', 'name' => 'Dad Mike'], $res->returnVal()[0]->keyObject()['path'][1]);
        $this->assertEquals(
            ['kind' => 'Person', 'name' => 'Grandpa Joe'],
            $res->returnVal()[0]->keyObject()['path'][0]
        );
    }

    public function testEntity()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'entity');
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke('entity');

        $this->assertInstanceOf(Entity::class, $res->returnVal());
        $this->assertEquals(['kind' => 'Person', 'name' => 'Bob'], $res->returnVal()->key()->keyObject()['path'][0]);
        $this->assertEquals('Testguy', $res->returnVal()['lastName']);
    }

    public function testEntityArrayAccess()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'entity', 'array');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('key', $this->key);

        $res = $snippet->invoke('entity');
        $this->assertEquals('Bob', $res->returnVal()['firstName']);
        $this->assertEquals('Testguy', $res->returnVal()['lastName']);
    }

    public function testEntityObjectAccess()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'entity', 'object_accessor');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('key', $this->key);

        $res = $snippet->invoke('entity');
        $this->assertEquals('Bob', $res->returnVal()['firstName']);
        $this->assertEquals('Testguy', $res->returnVal()['lastName']);
    }

    public function testCreateEntityIncompleteKey()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'entity', 'incomplete');
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke('entity');
        $this->assertEquals(Key::STATE_INCOMPLETE, $res->returnVal()->key()->state());
    }

    /**
     * @dataProvider customClassSnippet
     */
    public function testCreateEntityCustomClass($snippet, $type)
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'entity', $snippet);
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke();
        $this->assertEquals($type, $res->output());
    }

    public function customClassSnippet()
    {
        return [
            ['custom_class_extends', 'OtherPersonEntity'],
            ['custom_class_interface', 'PersonEntity']
        ];
    }

    public function testEntityExcludeIndexes()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'entity', 'exclude_indexes');
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke('entity');
        $this->assertEquals(['dateOfBirth'], $res->returnVal()->excludedProperties());
    }

    public function testGeoPoint()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'geoPoint');
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke('geoPoint');
        $this->assertInstanceOf(GeoPoint::class, $res->returnVal());
    }

    public function testBlob()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'blob');
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke('blob');
        $this->assertInstanceOf(Blob::class, $res->returnVal());
    }

    public function testInt64()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'int64');
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke('int64');
        $this->assertInstanceOf(Int64::class, $res->returnVal());
    }

    public function testCursor()
    {
        $val = 'foobar';

        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'cursor');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('cursorValue', $val);

        $res = $snippet->invoke('cursor');
        $this->assertInstanceOf(Cursor::class, $res->returnVal());
        $this->assertEquals($val, $res->returnVal()->cursor());
    }

    public function testBlobWithFile()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'blob', 1);
        $snippet->addLocal('datastore', $this->client);
        $snippet->replace("file_get_contents(__DIR__ .'/family-photo.jpg')", "''");

        $res = $snippet->invoke('blob');
        $this->assertInstanceOf(Blob::class, $res->returnVal());
    }

    public function testAllocateId()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'allocateId');
        $snippet->addLocal('datastore', $this->client);

        $this->gapicClient->allocateids(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(
                AllocateIdsResponse::class,
                [
                    'keys' => [
                        [
                            'path' => [
                                [
                                    'kind' => 'Person',
                                    'id' => '4682475895'
                                ]
                            ]
                        ]
                    ]
                ]
            ));

        $res = $snippet->invoke('keyWithAllocatedId');

        $this->assertInstanceOf(Key::class, $res->returnVal());

        $this->assertEquals(Key::STATE_NAMED, $res->returnVal()->state());
    }

    public function testAllocateIdsBatch()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'allocateIds');
        $snippet->addLocal('datastore', $this->client);

        $this->allocateIdsConnectionMock();

        $res = $snippet->invoke('keysWithAllocatedIds');

        $this->assertInstanceOf(Key::class, $res->returnVal()[0]);
        $this->assertInstanceOf(Key::class, $res->returnVal()[1]);

        $this->assertEquals(Key::STATE_NAMED, $res->returnVal()[0]->state());
    }

    public function testTransaction()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'transaction');
        $snippet->addLocal('datastore', $this->client);

        $this->gapicClient->beginTransaction(Argument::type(BeginTransactionRequest::class), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(BeginTransactionResponse::class, [
                'transaction' => 'foo'
            ]));

        $res = $snippet->invoke('transaction');
        $this->assertInstanceOf(Transaction::class, $res->returnVal());
    }

    public function testReadOnlyTransaction()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'readOnlyTransaction');
        $snippet->addLocal('datastore', $this->client);
        $this->gapicClient->beginTransaction($this->validateTransactionOptions('readOnly'), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(BeginTransactionResponse::class, [
                'transaction' => 'foo'
            ]));

        $res = $snippet->invoke('transaction');
        $this->assertInstanceOf(ReadOnlyTransaction::class, $res->returnVal());

        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'readOnlyTransaction', 1);
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('time', new Timestamp(new \DateTime()));
        $res = $snippet->invoke('transaction');
        $this->assertInstanceOf(ReadOnlyTransaction::class, $res->returnVal());
    }

    public function testInsert()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'insert');
        $snippet->addLocal('datastore', $this->client);

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            $this->assertEquals('insert', $request->getMutations()[0]->getOperation());
            return true;
        }), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(CommitResponse::class, [
                'mutationResults' => [
                    ['version' => 1]
                ]
            ]));

        $res = $snippet->invoke('entity');

        $this->assertEquals(Key::STATE_NAMED, $res->returnVal()->key()->state());
    }

    public function testInsertBatch()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'insertBatch');
        $snippet->addLocal('datastore', $this->client);

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            $this->assertEquals('insert', $request->getMutations()[0]->getOperation());
            return true;
        }), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(CommitResponse::class, []));

        $this->allocateIdsConnectionMock();

        $res = $snippet->invoke('entities');

        $this->assertEquals(Key::STATE_NAMED, $res->returnVal()[0]->key()->state());
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'update');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('entity', $this->client->entity($this->key, [], [
            'populatedByService' => true
        ]));

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            $this->assertEquals('update', $request->getMutations()[0]->getOperation());
            return true;
        }), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(CommitResponse::class, [
                'mutationResults' => [
                    ['version' => 1]
                ]
            ]));

        $res = $snippet->invoke();
    }

    public function testUpdateBatch()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'updateBatch');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('entities', [
            $this->client->entity($this->client->key('Person', 'Bob'), [], ['populatedByService' => true]),
            $this->client->entity($this->client->key('Person', 'John'), [], ['populatedByService' => true])
        ]);

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            $this->assertEquals('update', $request->getMutations()[0]->getOperation());
            return true;
        }), Argument::any())->shouldBeCalled()
            ->willReturn(self::generateProto(CommitResponse::class, [
                'mutationResults' => [
                    ['version' => 1]
                ]
            ]));

        $res = $snippet->invoke();
    }

    public function testUpsert()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'upsert');
        $snippet->addLocal('datastore', $this->client);

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            $this->assertEquals('upsert', $request->getMutations()[0]->getOperation());
            return true;
        }), Argument::any())
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
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'upsertBatch');
        $snippet->addLocal('datastore', $this->client);

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            $this->assertEquals('upsert', $request->getMutations()[0]->getOperation());
            return true;
        }), Argument::any())->shouldBeCalled()
            ->willReturn(self::generateProto(CommitResponse::class, [
                'mutationResults' => [
                    ['version' => 1]
                ]
            ]));

        $res = $snippet->invoke();
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'delete');
        $snippet->addLocal('datastore', $this->client);

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            $this->assertEquals('delete', $request->getMutations()[0]->getOperation());
            return true;
        }), Argument::any())
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
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'deleteBatch');
        $snippet->addLocal('datastore', $this->client);

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            $this->assertEquals('delete', $request->getMutations()[0]->getOperation());
            return true;
        }), Argument::any())
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
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'lookup');
        $snippet->addLocal('datastore', $this->client);

        $this->gapicClient->lookup(Argument::any(), Argument::any())
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

        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'lookup', 1);
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('time', new Timestamp(new \DateTime()));
        $res = $snippet->invoke();
        $this->assertEquals('Bob', $res->output());
    }

    public function testLookupBatch()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'lookupBatch');
        $snippet->addLocal('datastore', $this->client);

         $this->gapicClient->lookup(Argument::any(), Argument::any())
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

        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'lookupBatch', 1);
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('time', new Timestamp(new \DateTime()));
        $res = $snippet->invoke();
        $this->assertEquals("Bob", explode("\n", $res->output())[0]);
        $this->assertEquals("John", explode("\n", $res->output())[1]);
    }

    public function testQuery()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'query');
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke('query');
        $this->assertInstanceOf(Query::class, $res->returnVal());
    }

    public function testAggregationQuery()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'aggregationQuery');
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke('query');
        $this->assertInstanceOf(AggregationQuery::class, $res->returnVal());
    }

    /**
     * Other GQL snippets are found in {@see Google\Cloud\Datastore\Tests\Snippets\Query\GqlQueryTest}.
     */
    public function testGqlQuery()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'gqlQuery');
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke('query');
        $this->assertInstanceOf(GqlQuery::class, $res->returnVal());
    }

    public function testRunQuery()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'runQuery');
        $snippet->addLocal('datastore', $this->client);

        $query = $this->prophesize(QueryInterface::class);
        $query->queryObject()->willReturn([]);
        $query->queryKey()->willReturn('query');
        $query->canPaginate()->willReturn(false);
        $snippet->addLocal('query', $query->reveal());

        $this->gapicClient->runQuery(Argument::type(RunQueryRequest::class), Argument::any())
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

        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'runQuery', 1);
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('query', $query->reveal());
        $snippet->addLocal('time', new Timestamp(new \DateTime()));
        $res = $snippet->invoke('result');
        $this->assertEquals('Bob', $res->output());
    }

    public function testRunAggregationQuery()
    {
        $time = new Timestamp(new \DateTime());
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'runAggregationQuery');
        $snippet->addLocal('datastore', $this->client);

        $query = $this->prophesize(AggregationQuery::class);
        $query->queryObject()->willReturn([]);
        $snippet->addLocal('query', $query->reveal());

        $this->gapicClient->runAggregationQuery(Argument::type(RunAggregationQueryRequest::class), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(RunAggregationQueryResponse::class, [
                'batch' => [
                    'aggregationResults' => [
                        [
                            'aggregateProperties' => [
                                'property_1' => [
                                    'integerValue' => 1
                                ]
                            ]
                        ]
                    ],
                    'readTime' => $time
                ]
            ]));

        $res = $snippet->invoke();
        $this->assertEquals('1', $res->output());

        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'runAggregationQuery', 1);
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('query', $query->reveal());
        $snippet->addLocal('time', new Timestamp(new \DateTime()));
        $res = $snippet->invoke();
        $this->assertEquals('1', $res->output());
    }

    // ******** HELPERS

    private function allocateIdsConnectionMock()
    {
        $responseArray = [
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
        ];

        $this->gapicClient->allocateIds(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(AllocateIdsResponse::class, $responseArray));
    }

    private function validateTransactionOptions($type, array $options = [])
    {
        return Argument::that(function (BeginTransactionRequest $request) use ($type, $options) {
            if (empty($request->getTransactionOptions())) {
                echo 'missing opts';
                return false;
            }

            if ($type === 'readOnly') {
                if (empty($request->getTransactionOptions()->getReadOnly())) {
                    return false;
                }
            }
            return true;
        });
    }
}
