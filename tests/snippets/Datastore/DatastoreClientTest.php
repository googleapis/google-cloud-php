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

namespace Google\Cloud\Tests\Snippets\Datastore;

use Google\Cloud\Datastore\Blob;
use Google\Cloud\Datastore\Connection\ConnectionInterface;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Entity;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\GeoPoint;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Operation;
use Google\Cloud\Datastore\Query\GqlQuery;
use Google\Cloud\Datastore\Query\Query;
use Google\Cloud\Datastore\Query\QueryInterface;
use Google\Cloud\Datastore\Transaction;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Core\Int64;
use Prophecy\Argument;

/**
 * @group datastore
 */
class DatastoreClientTest extends SnippetTestCase
{
    private $connection;
    private $operation;
    private $client;
    private $key;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->operation = $this->prophesize(Operation::class);

        $this->client = new DatastoreClientStub();
        $this->client->setConnection($this->connection->reveal());

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
        $opProp->setAccessible(true);

        $op = $opProp->getValue($ds);

        $opRef = new \ReflectionClass($op);
        $nsProp = $opRef->getProperty('namespaceId');
        $nsProp->setAccessible(true);

        $this->assertEquals('my-application-namespace', $nsProp->getValue($op));
    }

    public function testEmulator()
    {
        $snippet = $this->snippetFromClass(DatastoreClient::class, 2);
        $res = $snippet->invoke('datastore');

        $this->assertInstanceOf(DatastoreClient::class, $res->returnVal());

        $this->assertEquals('http://localhost:8900', getenv('DATASTORE_EMULATOR_HOST'));
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
        $this->assertTrue(is_array($res->returnVal()));
        $this->assertEquals(10, count($res->returnVal()));
        $this->assertInstanceOf(Key::class, $res->returnVal()[0]);
        $this->assertEquals('Person', $res->returnVal()[0]->keyObject()['path'][0]['kind']);
    }

    public function testKeysWithAncestors()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'keys', 1);
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke('keys');

        $this->assertTrue(is_array($res->returnVal()));
        $this->assertEquals(3, count($res->returnVal()));
        $this->assertInstanceOf(Key::class, $res->returnVal()[0]);

        $this->assertEquals(['kind' => 'Person'], $res->returnVal()[0]->keyObject()['path'][2]);
        $this->assertEquals(['kind' => 'Person', 'name' => 'Dad Mike'], $res->returnVal()[0]->keyObject()['path'][1]);
        $this->assertEquals(['kind' => 'Person', 'name' => 'Grandpa Joe'], $res->returnVal()[0]->keyObject()['path'][0]);
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

    public function testCreateEntityCustomClass()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'entity', 'custom_class');
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke();
        $this->assertEquals('Person', $res->output());
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

        $this->allocateIdsConnectionMock();
        $this->client->setConnection($this->allocateIdsConnectionMock());

        $res = $snippet->invoke('keyWithAllocatedId');

        $this->assertInstanceOf(Key::class, $res->returnVal());

        $this->assertEquals(Key::STATE_NAMED, $res->returnVal()->state());
    }

    public function testAllocateIdsBatch()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'allocateIds');
        $snippet->addLocal('datastore', $this->client);

        $this->allocateIdsConnectionMock();
        $this->client->setConnection($this->allocateIdsConnectionMock());

        $res = $snippet->invoke('keysWithAllocatedIds');

        $this->assertInstanceOf(Key::class, $res->returnVal()[0]);
        $this->assertInstanceOf(Key::class, $res->returnVal()[1]);

        $this->assertEquals(Key::STATE_NAMED, $res->returnVal()[0]->state());
    }

    public function testTransaction()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'transaction');
        $snippet->addLocal('datastore', $this->client);

        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'transaction' => 'foo'
            ]);

        $this->client->setConnection($this->connection->reveal());

        $res = $snippet->invoke('transaction');
        $this->assertInstanceOf(Transaction::class, $res->returnVal());
    }

    public function testInsert()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'insert');
        $snippet->addLocal('datastore', $this->client);

        $this->connection->commit(Argument::that(function ($args) {
            if (array_keys($args['mutations'][0])[0] !== 'insert') return false;
            return true;
        }))
            ->shouldBeCalled()
            ->willReturn([
                'mutationResults' => [
                    ['version' => 1]
                ]
            ]);

        $this->client->setConnection($this->connection->reveal());

        $res = $snippet->invoke('entity');

        $this->assertEquals(Key::STATE_NAMED, $res->returnVal()->key()->state());
    }

    public function testInsertBatch()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'insertBatch');
        $snippet->addLocal('datastore', $this->client);

        $this->connection->commit(Argument::that(function ($args) {
            if (array_keys($args['mutations'][0])[0] !== 'insert') return false;
            return true;
        }))
            ->shouldBeCalled();

        $this->allocateIdsConnectionMock();

        $this->client->setConnection($this->connection->reveal());

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

        $this->connection->commit(Argument::that(function ($args) {
            if (array_keys($args['mutations'][0])[0] !== 'update') return false;
            return true;
        }))
            ->shouldBeCalled()
            ->willReturn([
                'mutationResults' => [
                    ['version' => 1]
                ]
            ]);

        $this->client->setConnection($this->connection->reveal());

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

        $this->connection->commit(Argument::that(function ($args) {
            if (array_keys($args['mutations'][0])[0] !== 'update') return false;
            return true;
        }))
            ->shouldBeCalled();

        $res = $snippet->invoke();
    }

    public function testUpsert()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'upsert');
        $snippet->addLocal('datastore', $this->client);

        $this->connection->commit(Argument::that(function ($args) {
            if (array_keys($args['mutations'][0])[0] !== 'upsert') return false;
            return true;
        }))
            ->shouldBeCalled()
            ->willReturn([
                'mutationResults' => [
                    ['version' => 1]
                ]
            ]);

        $this->client->setConnection($this->connection->reveal());

        $res = $snippet->invoke();
    }

    public function testUpsertBatch()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'upsertBatch');
        $snippet->addLocal('datastore', $this->client);

        $this->connection->commit(Argument::that(function ($args) {
            if (array_keys($args['mutations'][0])[0] !== 'upsert') return false;
            return true;
        }))
            ->shouldBeCalled();

        $res = $snippet->invoke();
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'delete');
        $snippet->addLocal('datastore', $this->client);

        $this->connection->commit(Argument::that(function ($args) {
            if (array_keys($args['mutations'][0])[0] !== 'delete') return false;
            return true;
        }))
            ->shouldBeCalled()
            ->willReturn([
                'mutationResults' => [
                    ['version' => 1]
                ]
            ]);

        $this->client->setConnection($this->connection->reveal());

        $res = $snippet->invoke();
    }

    public function testDeleteBatch()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'deleteBatch');
        $snippet->addLocal('datastore', $this->client);

        $this->connection->commit(Argument::that(function ($args) {
            if (array_keys($args['mutations'][0])[0] !== 'delete') return false;
            return true;
        }))
            ->shouldBeCalled();

        $res = $snippet->invoke();
    }

    public function testLookup()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'lookup');
        $snippet->addLocal('datastore', $this->client);

        $this->connection->lookup(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
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
            ]);

        $this->client->setConnection($this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Bob', $res->output());
    }

    public function testLookupBatch()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'lookupBatch');
        $snippet->addLocal('datastore', $this->client);

        $this->connection->lookup(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
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
            ]);

        $this->client->setConnection($this->connection->reveal());

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

    public function testGqlQuery()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'gqlQuery');
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke('query');
        $this->assertInstanceOf(GqlQuery::class, $res->returnVal());
    }

    public function testGqlQueryBindings()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'gqlQuery', 'bindings');
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke('query');
        $this->assertInstanceOf(GqlQuery::class, $res->returnVal());
    }

    public function testGqlQueryPositionalBindings()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'gqlQuery', 'pos_bindings');
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke('query');
        $this->assertInstanceOf(GqlQuery::class, $res->returnVal());
    }

    public function testGqlQueryLiterals()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'gqlQuery', 'literals');
        $snippet->addLocal('datastore', $this->client);

        $res = $snippet->invoke('query');
        $this->assertInstanceOf(GqlQuery::class, $res->returnVal());
    }

    public function testRunQuery()
    {
        $snippet = $this->snippetFromMethod(DatastoreClient::class, 'runQuery');
        $snippet->addLocal('datastore', $this->client);
        $snippet->addLocal('query', $this->prophesize(QueryInterface::class)->reveal());

        $this->connection->runQuery(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
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
            ]);

        $this->client->setConnection($this->connection->reveal());

        $res = $snippet->invoke('result');
        $this->assertEquals('Bob', $res->output());
    }

    // ******** HELPERS

    private function allocateIdsConnectionMock()
    {
        $this->connection->allocateIds(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
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

        return $this->connection->reveal();
    }
}

class DatastoreClientStub extends DatastoreClient
{
    public function setConnection($connection)
    {
        $this->connection = $connection;
        $this->operation = new Operation(
            $this->connection,
            'my-awesome-project',
            '',
            new EntityMapper('my-awesome-project', true, false)
        );
    }
}
