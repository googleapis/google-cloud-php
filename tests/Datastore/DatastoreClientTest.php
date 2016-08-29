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

namespace Google\Cloud\Tests\Datastore;

use Google\Cloud\Datastore\Connection\ConnectionInterface;
use Google\Cloud\Datastore\Entity;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Query\GqlQuery;
use Google\Cloud\Datastore\Query\Query;
use Google\Cloud\Datastore\Transaction;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Operation;
use Prophecy\Argument;

/**
 * @group datastore
 */
class DatastoreClientTest extends \PHPUnit_Framework_TestCase
{
    private $connection;
    private $datastore;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->datastore = new DatastoreClientStub(['projectId' => 'foo']);
    }

    public function testKey()
    {
        $key = $this->datastore->key('Foo', 'Bar');

        $this->assertInstanceOf(Key::class, $key);

        $this->assertEquals($key->keyObject()['path'][0]['kind'], 'Foo');
        $this->assertEquals($key->keyObject()['path'][0]['name'], 'Bar');

        $key = $this->datastore->key('Foo', '123');

        $this->assertEquals($key->keyObject()['path'][0]['kind'], 'Foo');
        $this->assertEquals($key->keyObject()['path'][0]['id'], '123');

        $key = $this->datastore->key('Foo', 123);

        $this->assertEquals($key->keyObject()['path'][0]['kind'], 'Foo');
        $this->assertEquals($key->keyObject()['path'][0]['id'], '123');
    }

    public function testKeyForceType()
    {
        $key = $this->datastore->key('Foo', '123');

        $this->assertEquals($key->keyObject()['path'][0]['id'], '123');

        $key = $this->datastore->key('Foo', '123', [
            'identifierType' => Key::TYPE_NAME
        ]);

        $this->assertEquals($key->keyObject()['path'][0]['name'], '123');
    }

    public function testKeyNamespaceId()
    {
        $key = $this->datastore->key('Foo', 'Bar', [
            'namespaceId' => 'MyApp'
        ]);

        $this->assertEquals($key->keyObject()['partitionId'], [
            'projectId' => 'foo',
            'namespaceId' => 'MyApp'
        ]);
    }

    public function testKeys()
    {
        $keys = $this->datastore->keys('Person', [
            'allocateIds' => false
        ]);

        $this->assertTrue(is_array($keys));
        $this->assertInstanceOf(Key::class, $keys[0]);
        $this->assertEquals($keys[0]->keyObject()['path'][0]['kind'], 'Person');
    }

    public function testKeysMultiple()
    {
        $keys = $this->datastore->keys('Person', [
            'allocateIds' => false,
            'number' => 5
        ]);

        $this->assertTrue(is_array($keys));
        $this->assertInstanceOf(Key::class, $keys[0]);
        $this->assertEquals(5, count($keys));
    }

    public function testKeysAncestors()
    {
        $ancestors = [
            ['kind' => 'Parent1', 'id' => '123'],
            ['kind' => 'Parent2', 'id' => '321']
        ];

        $keys = $this->datastore->keys('Person', [
            'allocateIds' => false,
            'ancestors' => $ancestors
        ]);

        $key = $keys[0];

        $keyAncestors = $key->keyObject()['path'];
        array_pop($keyAncestors);

        $this->assertEquals($keyAncestors, $ancestors);
    }

    public function testKeysWithAllocateIds()
    {
        $datastore = new DatastoreClientStubNoService;

        $keys = $datastore->keys('Person');

        $this->assertTrue(is_array($keys));
        $this->assertInstanceOf(Key::class, $keys[0]);

        $this->assertTrue($datastore->didCallAllocateIds);
    }

    public function testEntity()
    {
        $key = $this->datastore->key('Person', 'Foo');

        $entity = $this->datastore->entity($key, [
            'foo' => 'bar'
        ]);

        $this->assertInstanceOf(Entity::class, $entity);
        $this->assertEquals($entity['foo'], 'bar');
    }

    public function testAllocateId()
    {
        $datastore = new DatastoreClientStubNoService;

        $key = $datastore->key('Person');

        $key = $datastore->allocateId($key);

        $this->assertInstanceOf(Key::class, $key);
        $this->assertTrue($datastore->didCallAllocateIds);
    }

    public function testAllocateIds()
    {
        $this->connection->allocateIds(Argument::type('array'))
            ->willReturn([
                'keys' => [
                    [
                        'path' => [
                            ['kind' => 'Person', 'name' => 'John']
                        ],
                        'partitionId' => [
                            'namespaceId' => 'foo', 'projectId' => 'bar'
                        ]
                    ], [
                        'path' => [
                            ['kind' => 'Person', 'name' => 'Dave']
                        ]
                    ]
                ]
            ]);

        $this->datastore->setConnection($this->connection->reveal());

        $keys = [
            $this->datastore->key('Person'),
            $this->datastore->key('Person')
        ];

        $res = $this->datastore->allocateIds($keys);

        $this->assertTrue(is_array($res));
        $this->assertEquals(2, count($res));
        $this->assertInstanceOf(Key::class, $res[0]);
        $this->assertEquals(Key::STATE_COMPLETE, $res[0]->state());
        $this->assertEquals([['kind' => 'Person', 'name' => 'John']], $res[0]->path());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAllocateIdCompleteKey()
    {
        $key = $this->datastore->key('Foo', 'Bar');
        $this->datastore->allocateIds([$key]);
    }

    public function testTransaction()
    {
        $id = 1234;

        $t = $this->datastore->transaction($id);

        $this->assertInstanceOf(Transaction::class, $t);
        $this->assertEquals($id, $t->id());
    }

    public function testBeginTransaction()
    {
        $this->connection->beginTransaction(Argument::any())->willReturn([
            'transaction' => 1234
        ]);

        $this->datastore->setConnection($this->connection->reveal());

        $t = $this->datastore->beginTransaction();

        $this->assertInstanceOf(Transaction::class, $t);
        $this->assertEquals($t->id(), 1234);
    }

    public function testOperation()
    {
        $op = $this->datastore->operation();

        $this->assertInstanceOf(Operation::class, $op);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testOperationWithInvalidTransaction()
    {
        $op = $this->datastore->operation([
            'transaction' => 'foo'
        ]);
    }

    public function testOperationWithTransactionInstance()
    {
        $id = 1234;
        $t = $this->datastore->transaction($id);
        $o = $this->datastore->operation(['transaction' => $t]);

        $this->assertEquals($o->transaction(), $t);
    }

    public function testOperationRunInTransaction()
    {
        $ds = new DatastoreClientStubNoService;

        $o = $ds->operation([
            'runInTransaction' => true
        ]);

        $this->assertInstanceOf(Transaction::class, $o->transaction());
        $this->assertTrue($ds->didCallBeginTransaction);
    }

    public function testInsert()
    {
        $this->mockCommitConnection();

        $e = $this->datastore->entity($this->datastore->key('Kind', 'ID'), [
            'foo' => 'bar'
        ]);

        $this->datastore->insert($e);

        $this->connection->commit(Argument::type('array'))->shouldHaveBeenCalled();
    }

    public function testInsertBatch()
    {
        $this->mockCommitConnection();

        $e = $this->datastore->entity($this->datastore->key('Kind', 'ID'), [
            'foo' => 'bar'
        ]);

        $this->datastore->insertBatch([$e]);

        $this->connection->commit(Argument::type('array'))->shouldHaveBeenCalled();
    }

    public function testUpdate()
    {
        $this->mockCommitConnection();

        $e = $this->datastore->entity($this->datastore->key('Kind', 'ID'), [
            'foo' => 'bar'
        ]);

        $this->datastore->update($e);

        $this->connection->commit(Argument::type('array'))->shouldHaveBeenCalled();
    }

    public function testUpdateBatch()
    {
        $this->mockCommitConnection();

        $e = $this->datastore->entity($this->datastore->key('Kind', 'ID'), [
            'foo' => 'bar'
        ]);

        $this->datastore->updateBatch([$e]);

        $this->connection->commit(Argument::type('array'))->shouldHaveBeenCalled();
    }

    public function testUpsert()
    {
        $this->mockCommitConnection();

        $e = $this->datastore->entity($this->datastore->key('Kind', 'ID'), [
            'foo' => 'bar'
        ]);

        $this->datastore->upsert($e);

        $this->connection->commit(Argument::type('array'))->shouldHaveBeenCalled();
    }

    public function testUpsertBatch()
    {
        $this->mockCommitConnection();

        $e = $this->datastore->entity($this->datastore->key('Kind', 'ID'), [
            'foo' => 'bar'
        ]);

        $this->datastore->upsertBatch([$e]);

        $this->connection->commit(Argument::type('array'))->shouldHaveBeenCalled();
    }

    public function testDelete()
    {
        $this->mockCommitConnection();

        $k = $this->datastore->key('Kind', 'ID');

        $this->datastore->delete($k);

        $this->connection->commit(Argument::type('array'))->shouldHaveBeenCalled();
    }

    public function testDeleteBatch()
    {
        $this->mockCommitConnection();

        $k = $this->datastore->key('Kind', 'ID');

        $this->datastore->deleteBatch([$k]);

        $this->connection->commit(Argument::type('array'))->shouldHaveBeenCalled();
    }

    public function testLookup()
    {
        $ds = new DatastoreClientStubNoService;

        $key = $ds->key('Kind', 'Value');
        $res = $ds->lookup($key);

        $this->assertInstanceOf(Entity::class, $res);
        $this->assertTrue($ds->didCallLookupBatch);
        $this->assertEquals($key, $ds->keys[0]);
    }

    public function testLookupBatch()
    {
        $body = json_decode(file_get_contents(__DIR__ .'/../fixtures/datastore/entity-batch-lookup.json'), true);
        $this->connection->lookup(Argument::any())->willReturn([
            'found' => $body
        ]);

        $this->datastore->setConnection($this->connection->reveal());

        $key = $this->datastore->key('Kind', 'ID');

        $res = $this->datastore->lookupBatch([$key]);

        $this->assertTrue(is_array($res));
        $this->assertTrue(isset($res['found']) && is_array($res['found']));

        $this->assertInstanceOf(Entity::class, $res['found'][0]);
        $this->assertEquals($res['found'][0]['Number'], $body[0]['entity']['properties']['Number']['stringValue']);

        $this->assertInstanceOf(Entity::class, $res['found'][1]);
        $this->assertEquals($res['found'][1]['Number'], $body[1]['entity']['properties']['Number']['stringValue']);
    }

    public function testLookupBatchMissing()
    {
        $body = json_decode(file_get_contents(__DIR__ .'/../fixtures/datastore/entity-batch-lookup.json'), true);
        $this->connection->lookup(Argument::any())->willReturn([
            'missing' => $body
        ]);

        $this->datastore->setConnection($this->connection->reveal());

        $key = $this->datastore->key('Kind', 'ID');

        $res = $this->datastore->lookupBatch([$key]);

        $this->assertTrue(is_array($res));
        $this->assertTrue(isset($res['missing']) && is_array($res['missing']));

        $this->assertInstanceOf(Entity::class, $res['missing'][0]);
        $this->assertInstanceOf(Entity::class, $res['missing'][1]);
    }

    public function testLookupBatchDeferred()
    {
        $body = json_decode(file_get_contents(__DIR__ .'/../fixtures/datastore/entity-batch-lookup.json'), true);
        $this->connection->lookup(Argument::any())->willReturn([
            'deferred' => [ $body[0]['entity']['key'] ]
        ]);

        $this->datastore->setConnection($this->connection->reveal());

        $key = $this->datastore->key('Kind', 'ID');

        $res = $this->datastore->lookupBatch([$key]);

        $this->assertTrue(is_array($res));
        $this->assertTrue(isset($res['deferred']) && is_array($res['deferred']));

        $this->assertInstanceOf(Key::class, $res['deferred'][0]);
    }

    public function testQuery()
    {
        $q = $this->datastore->query();

        $this->assertInstanceOf(Query::class, $q);
    }

    public function testGqlQuery()
    {
        $q = $this->datastore->gqlQuery('foo');
        $this->assertInstanceOf(GqlQuery::class, $q);
    }

    public function testRunQuery()
    {
        $queryResult = json_decode(file_get_contents(__DIR__ .'/../fixtures/datastore/query-results.json'), true);

        $this->connection->runQuery(Argument::type('array'))
            ->willReturn($queryResult['notPaged']);

        $this->datastore->setConnection($this->connection->reveal());

        $q = $this->datastore->query();
        $res = $this->datastore->runQuery($q);

        $this->assertInstanceOf(\Generator::class, $res);

        $arr = iterator_to_array($res);

        $this->assertEquals(count($arr), 2);
        $this->assertInstanceOf(Entity::class, $arr[0]);
    }

    public function testRunQueryPaged()
    {
        $queryResult = json_decode(file_get_contents(__DIR__ .'/../fixtures/datastore/query-results.json'), true);

        $this->connection->runQuery(Argument::type('array'))
            ->will(function($args, $mock) use ($queryResult) {

                // The 2nd call will return the 2nd page of results!
                $mock->runQuery(Argument::type('array'))
                    ->willReturn($queryResult['paged'][1]);

                return $queryResult['paged'][0];
            });

        $this->datastore->setConnection($this->connection->reveal());

        $q = $this->datastore->query();
        $res = $this->datastore->runQuery($q);

        $this->assertInstanceOf(\Generator::class, $res);

        $arr = iterator_to_array($res);

        $this->assertEquals(count($arr), 3);
        $this->assertInstanceOf(Entity::class, $arr[0]);
    }

    public function testRunQueryNoResults()
    {
        $queryResult = json_decode(file_get_contents(__DIR__ .'/../fixtures/datastore/query-results.json'), true);

        $this->connection->runQuery(Argument::type('array'))
            ->willReturn($queryResult['noResults']);

        $this->datastore->setConnection($this->connection->reveal());

        $q = $this->datastore->query();
        $res = $this->datastore->runQuery($q);

        $this->assertInstanceOf(\Generator::class, $res);

        $arr = iterator_to_array($res);

        $this->assertEquals(count($arr), 0);
    }

    private function mockCommitConnection($return = null)
    {
        $this->connection->commit(Argument::any())->willReturn($return);

        $this->datastore->setConnection($this->connection->reveal());
    }
}

class DatastoreClientStub extends DatastoreClient
{
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }
}

class DatastoreClientStubNoService extends DatastoreClientStub
{
    public $didCallAllocateIds = false;

    public function allocateIds(array $keys, array $options = [])
    {
        $this->didCallAllocateIds = true;
        return $keys;
    }

    public $didCallBeginTransaction = false;

    public function beginTransaction(array $options = [])
    {
        $this->didCallBeginTransaction = true;
        return new Transaction($this->connection, '', '');
    }

    public $didCallLookupBatch = false;
    public $keys = [];
    public function lookupBatch(array $keys, array $options = [])
    {
        $this->keys = $keys;
        $this->didCallLookupBatch = true;
        return ['found' => [$this->entity($this->key('Kind', 'Value'), ['foo' => 'bar'])]];
    }
}
