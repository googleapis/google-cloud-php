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
use Google\Cloud\Datastore\Transaction;
use Google\Cloud\Datastore\Operation;
use Prophecy\Argument;

/**
 * @group datastore
 */
class OperationTest extends \PHPUnit_Framework_TestCase
{
    private $connection;
    private $key;
    private $entity;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->key = $this->prophesize(Key::class);
        $this->key->state()->willReturn(Key::STATE_COMPLETE);

        $this->entity = new Entity($this->key->reveal(), ['foo' => 'bar']);

        $this->operation = new OperationStub($this->connection->reveal(), 'foo');
    }

    public function testTransaction()
    {
        $t = $this->prophesize(Transaction::class);
        $operation = new Operation($this->connection->reveal(), 'foo', $t->reveal());

        $this->assertInstanceOf(Transaction::class, $operation->transaction());

        $operation = new Operation($this->connection->reveal(), 'foo');
        $this->assertNull($operation->transaction());
    }

    public function testInsert()
    {
        $this->operation->insert($this->entity);

        $res = $this->operation->operationObject();

        $this->assertEquals(count($res['mutations']), 1);
        $this->assertEquals($res['mutations'][0]['insert'], $this->entity);
    }

    public function testInsertBatch()
    {
        $this->operation->insertBatch([$this->entity, $this->entity]);

        $res = $this->operation->operationObject();

        $this->assertEquals(count($res['mutations']), 2);
        $this->assertEquals($res['mutations'][0]['insert'], $this->entity);
        $this->assertEquals($res['mutations'][1]['insert'], $this->entity);
    }

    public function testUpdate()
    {
        $this->operation->update($this->entity);

        $res = $this->operation->operationObject();

        $this->assertEquals(count($res['mutations']), 1);
        $this->assertEquals($res['mutations'][0]['update'], $this->entity);
    }

    public function testUpdateBatch()
    {
        $this->operation->updateBatch([$this->entity, $this->entity]);

        $res = $this->operation->operationObject();

        $this->assertEquals(count($res['mutations']), 2);
        $this->assertEquals($res['mutations'][0]['update'], $this->entity);
        $this->assertEquals($res['mutations'][1]['update'], $this->entity);
    }

    public function testUpsert()
    {
        $this->operation->upsert($this->entity);

        $res = $this->operation->operationObject();

        $this->assertEquals(count($res['mutations']), 1);
        $this->assertEquals($res['mutations'][0]['upsert'], $this->entity);
    }

    public function testUpsertBatch()
    {
        $this->operation->upsertBatch([$this->entity, $this->entity]);

        $res = $this->operation->operationObject();

        $this->assertEquals(count($res['mutations']), 2);
        $this->assertEquals($res['mutations'][0]['upsert'], $this->entity);
        $this->assertEquals($res['mutations'][1]['upsert'], $this->entity);
    }

    public function testDelete()
    {
        $this->operation->delete($this->key->reveal());

        $res = $this->operation->operationObject();

        $this->assertEquals(count($res['mutations']), 1);
        $this->assertEquals($res['mutations'][0]['delete'], $this->key->reveal());
    }

    public function testDeleteBatch()
    {
        $this->operation->deleteBatch([$this->key->reveal(), $this->key->reveal()]);

        $res = $this->operation->operationObject();

        $this->assertEquals(count($res['mutations']), 2);
        $this->assertEquals($res['mutations'][0]['delete'], $this->key->reveal());
        $this->assertEquals($res['mutations'][1]['delete'], $this->key->reveal());
    }

    public function testCommit()
    {
        $this->connection->commit(Argument::type('array'))->shouldBeCalledTimes(1)->willReturn('foo');
        $this->operation->setConnection($this->connection->reveal());

        $res = $this->operation->commit();

        $this->assertEquals('foo', $res);
    }

    public function testCommitWithTransaction()
    {
        $this->connection->commit(Argument::type('array'))->shouldBeCalledTimes(1)->willReturn('foo');
        $t = $this->prophesize(Transaction::class);
        $operation = new Operation($this->connection->reveal(), 'foo', $t->reveal());

        $res = $operation->commit();

        $this->assertEquals('foo', $res);
    }
}

class OperationStub extends Operation
{
    public function setConnection($conn)
    {
        $this->connection = $conn;
    }
}
