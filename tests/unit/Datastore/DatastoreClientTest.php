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

namespace Google\Cloud\Tests\Unit\Datastore;

use Google\Cloud\Datastore\Blob;
use Google\Cloud\Datastore\Connection\ConnectionInterface;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Entity;
use Google\Cloud\Datastore\GeoPoint;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Operation;
use Google\Cloud\Datastore\Query\GqlQuery;
use Google\Cloud\Datastore\Query\Query;
use Google\Cloud\Datastore\Query\QueryInterface;
use Google\Cloud\Datastore\Transaction;
use Prophecy\Argument;

/**
 * @group datastore
 */
class DatastoreClientTest extends \PHPUnit_Framework_TestCase
{
    private $connection;
    private $operation;
    private $datastore;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->operation = $this->prophesize(Operation::class);
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

    public function testEntity()
    {
        $key = $this->datastore->key('Person', 'Foo');

        $entity = $this->datastore->entity($key, [
            'foo' => 'bar'
        ]);

        $this->assertInstanceOf(Entity::class, $entity);
        $this->assertEquals($entity['foo'], 'bar');
    }

    public function testBlob()
    {
        $blob = $this->datastore->blob('foo');
        $this->assertInstanceOf(Blob::class, $blob);
        $this->assertEquals('foo', (string) $blob);
    }

    public function testGeoPoint()
    {
        $point = $this->datastore->geoPoint(1.1, 0.1);
        $this->assertInstanceOf(GeoPoint::class, $point);
        $this->assertEquals($point->point(), [
            'latitude' => 1.1,
            'longitude' => 0.1
        ]);
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
        $this->operation->allocateIds(Argument::type('array'), Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn([]);

        $this->datastore->setOperation($this->operation->reveal());

        $key = $this->prophesize(Key::class);
        $keys = [
            $key->reveal(),
            $key->reveal()
        ];

        $res = $this->datastore->allocateIds($keys);

        $this->assertTrue(is_array($res));
    }

    public function testTransaction()
    {
        $this->connection->beginTransaction(Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn(['transaction' => '1234']);

        $this->datastore->setConnection($this->connection->reveal());

        $t = $this->datastore->transaction();

        $this->assertInstanceOf(Transaction::class, $t);
    }

    public function testInsert()
    {
        $e = $this->prophesize(Entity::class);

        $this->operation->allocateIdsToEntities(Argument::type('array'))
            ->willReturn([$e->reveal()]);

        $this->operation->mutation(Argument::exact('insert'), Argument::type(Entity::class), Argument::exact(Entity::class), Argument::exact(null))
            ->shouldBeCalled();

        $this->operation->commit(Argument::type('array'), Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn(['mutationResults' => [['version' => '1234']]]);

        $this->datastore->setOperation($this->operation->reveal());

        $res = $this->datastore->insert($e->reveal());

        $this->assertEquals($res, '1234');
    }

    /**
     * @expectedException DomainException
     */
    public function testInsertConflict()
    {
        $e = $this->prophesize(Entity::class);

        $this->operation->allocateIdsToEntities(Argument::type('array'))
            ->willReturn([$e->reveal()]);

        $this->operation->mutation(Argument::exact('insert'), Argument::type(Entity::class), Argument::exact(Entity::class), Argument::exact(null))
            ->shouldBeCalled();

        $this->operation->commit(Argument::type('array'), Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn(['mutationResults' => [['version' => '1234', 'conflictDetected' => true]]]);

        $this->datastore->setOperation($this->operation->reveal());

        $res = $this->datastore->insert($e->reveal());
    }

    public function testInsertBatch()
    {
        $e = $this->prophesize(Entity::class);

        $this->operation->commit(Argument::type('array'), Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn(['mutationResults' => [['version' => '1234']]]);

        $this->operation->mutation(Argument::exact('insert'), Argument::type(Entity::class), Argument::exact(Entity::class), Argument::exact(null))
            ->shouldBeCalled();

        $this->operation->allocateIdsToEntities(Argument::type('array'))
            ->willReturn([$e->reveal()]);

        $this->datastore->setOperation($this->operation->reveal());

        $res = $this->datastore->insertBatch([$e->reveal()]);

        $this->assertEquals($res, ['mutationResults' => [['version' => '1234']]]);
    }

    public function testUpdate()
    {
        $this->operation->commit(Argument::type('array'), Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn(['mutationResults' => [['version' => '1234']]]);

        $this->operation->mutation(Argument::exact('update'), Argument::type(Entity::class), Argument::exact(Entity::class), Argument::exact(null))
            ->shouldBeCalled();

        $this->operation->checkOverwrite(Argument::type('array'), Argument::type('bool'))
            ->shouldBeCalled();

        $this->datastore->setOperation($this->operation->reveal());

        $e = $this->prophesize(Entity::class);

        $res = $this->datastore->update($e->reveal());

        $this->assertEquals($res, '1234');
    }

    public function testUpdateBatch()
    {
        $this->operation->commit(Argument::type('array'), Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn(['mutationResults' => [['version' => '1234']]]);

        $this->operation->mutation(Argument::exact('update'), Argument::type(Entity::class), Argument::exact(Entity::class), Argument::exact(null))
            ->shouldBeCalled();

        $this->operation->checkOverwrite(Argument::type('array'), Argument::type('bool'))
            ->shouldBeCalled();

        $this->datastore->setOperation($this->operation->reveal());

        $e = $this->prophesize(Entity::class);

        $res = $this->datastore->updateBatch([$e->reveal()]);

        $this->assertEquals($res, ['mutationResults' => [['version' => '1234']]]);
    }

    public function testUpsert()
    {
        $this->operation->commit(Argument::type('array'), Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn(['mutationResults' => [['version' => '1234']]]);

        $this->operation->mutation(Argument::exact('upsert'), Argument::type(Entity::class), Argument::exact(Entity::class), Argument::exact(null))
            ->shouldBeCalled();

        $this->datastore->setOperation($this->operation->reveal());

        $e = $this->prophesize(Entity::class);

        $res = $this->datastore->upsert($e->reveal());

        $this->assertEquals($res, '1234');
    }

    public function testUpsertBatch()
    {
        $this->operation->commit(Argument::type('array'), Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn(['mutationResults' => [['version' => '1234']]]);

        $this->operation->mutation(Argument::exact('upsert'), Argument::type(Entity::class), Argument::exact(Entity::class), Argument::exact(null))
            ->shouldBeCalled();

        $this->datastore->setOperation($this->operation->reveal());

        $e = $this->prophesize(Entity::class);

        $res = $this->datastore->upsertBatch([$e->reveal()]);

        $this->assertEquals($res, ['mutationResults' => [['version' => '1234']]]);
    }

    public function testDelete()
    {
        $this->operation->commit(Argument::type('array'), Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn(['mutationResults' => [['version' => '1234']]]);

        $this->operation->mutation(Argument::exact('delete'), Argument::type(Key::class), Argument::exact(Key::class), Argument::exact(null))
            ->shouldBeCalled();

        $this->datastore->setOperation($this->operation->reveal());

        $key = $this->prophesize(Key::class);

        $res = $this->datastore->delete($key->reveal());

        $this->assertEquals($res, '1234');
    }

    public function testDeleteBatch()
    {
        $this->operation->commit(Argument::type('array'), Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn(['mutationResults' => [['version' => '1234']]]);

        $this->operation->mutation(Argument::exact('delete'), Argument::type(Key::class), Argument::exact(Key::class), Argument::exact(null))
            ->shouldBeCalled();

        $this->datastore->setOperation($this->operation->reveal());

        $key = $this->prophesize(Key::class);

        $res = $this->datastore->deleteBatch([$key->reveal()]);

        $this->assertEquals($res, ['mutationResults' => [['version' => '1234']]]);
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
        $this->operation->lookup(Argument::type('array'), Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn(['foo']);

        $this->datastore->setOperation($this->operation->reveal());

        $key = $this->prophesize(Key::class);

        $res = $this->datastore->lookupBatch([$key->reveal()]);

        $this->assertEquals($res, ['foo']);
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

        $this->operation->runQuery(Argument::type(QueryInterface::class), Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn('foo');

        $this->datastore->setOperation($this->operation->reveal());

        $q = $this->datastore->query();
        $res = $this->datastore->runQuery($q);

        $this->assertEquals($res, 'foo');
    }
}

class DatastoreClientStub extends DatastoreClient
{
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    public function setOperation($operation)
    {
        $this->operation = $operation;
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
