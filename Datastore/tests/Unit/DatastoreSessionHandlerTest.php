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

use Exception;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\DatastoreSessionHandler;
use Google\Cloud\Datastore\Entity;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Query\Query;
use Google\Cloud\Datastore\Transaction;
use InvalidArgumentException;
use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\Polyfills\AssertIsType;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group datastore
 */
class DatastoreSessionHandlerTest extends TestCase
{
    use AssertIsType;
    use ExpectException;

    const KIND = 'PHPSESSID';
    const NAMESPACE_ID = 'sessions';

    private $datastore;
    private $transaction;

    public function set_up()
    {
        $this->datastore = $this->prophesize(DatastoreClient::class);
        $this->transaction = $this->prophesize(Transaction::class);
    }

    public function testOpen()
    {
        $this->datastore->transaction(['databaseId' => ''])
            ->shouldBeCalledTimes(1)
            ->willReturn($this->transaction->reveal());
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore->reveal()
        );
        $ret = $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $this->assertTrue($ret);
    }

    public function testOpenNotAllowed()
    {
        $this->expectException('InvalidArgumentException');

        $this->datastore->transaction()
            ->shouldNotBeCalled()
            ->willReturn($this->transaction->reveal());
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore->reveal()
        );
        $datastoreSessionHandler->open('/tmp/sessions', self::KIND);
    }

    public function testOpenReserved()
    {
        $this->expectException('InvalidArgumentException');

        $this->datastore->transaction()
            ->shouldNotBeCalled()
            ->willReturn($this->transaction->reveal());
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore->reveal()
        );
        $datastoreSessionHandler->open('__RESERVED__', self::KIND);
    }

    public function testClose()
    {
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore->reveal()
        );
        $ret = $datastoreSessionHandler->close();
        $this->assertTrue($ret);
    }

    public function testReadNothing()
    {
        $this->datastore->transaction(['databaseId' => ''])
            ->shouldBeCalledTimes(1)
            ->willReturn($this->transaction->reveal());
        $key = new Key('projectid');
        $key->pathElement(self::KIND, 'sessionid');
        $this->datastore->key(
            self::KIND,
            'sessionid',
            ['namespaceId' => self::NAMESPACE_ID]
        )
            ->shouldBeCalledTimes(1)
            ->willReturn($key);
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore->reveal()
        );
        $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $ret = $datastoreSessionHandler->read('sessionid');

        $this->assertEquals('', $ret);
    }

    public function testReadWithException()
    {
        $this->expectException('PHPUnit\Framework\Error\Warning');

        $this->datastore->transaction(['databaseId' => ''])
            ->shouldBeCalledTimes(1)
            ->willReturn($this->transaction->reveal());
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore->reveal()
        );
        $this->datastore->key(
            self::KIND,
            'sessionid',
            ['namespaceId' => self::NAMESPACE_ID]
        )
            ->shouldBeCalledTimes(1)
            ->willThrow((new Exception()));

        $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $ret = $datastoreSessionHandler->read('sessionid');

        $this->assertEquals('', $ret);
    }

    public function testReadEntity()
    {
        $key = new Key('projectid');
        $key->pathElement(self::KIND, 'sessionid');
        $entity = new Entity($key, ['data' => 'sessiondata']);
        $this->transaction->lookup($key)
            ->shouldBeCalledTimes(1)
            ->willReturn($entity);
        $this->datastore->transaction(['databaseId' => ''])
            ->shouldBeCalledTimes(1)
            ->willReturn($this->transaction->reveal());
        $this->datastore->key(
            self::KIND,
            'sessionid',
            ['namespaceId' => self::NAMESPACE_ID]
        )
            ->shouldBeCalledTimes(1)
            ->willReturn($key);
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore->reveal()
        );
        $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $ret = $datastoreSessionHandler->read('sessionid');

        $this->assertEquals('sessiondata', $ret);
    }

    public function testWrite()
    {
        $data = 'sessiondata';
        $key = new Key('projectid');
        $key->pathElement(self::KIND, 'sessionid');
        $entity = new Entity($key, ['data' => $data]);
        $this->transaction->upsert($entity)
            ->shouldBeCalledTimes(1);
        $this->transaction->commit()
            ->shouldBeCalledTimes(1);
        $this->datastore->transaction(['databaseId' => ''])
            ->shouldBeCalledTimes(1)
            ->willReturn($this->transaction->reveal());
        $this->datastore->key(
            self::KIND,
            'sessionid',
            ['namespaceId' => self::NAMESPACE_ID]
        )
            ->shouldBeCalledTimes(1)
            ->willReturn($key);
        $that = $this;
        $this->datastore->entity($key, Argument::type('array'), Argument::type('array'))
            ->will(function ($args) use ($that, $key, $entity) {
                $that->assertEquals($key, $args[0]);
                $that->assertEquals('sessiondata', $args[1]['data']);
                $that->assertIsInt($args[1]['t']);
                $that->assertGreaterThanOrEqual($args[1]['t'], time());
                // 2 seconds grace period should be enough
                $that->assertLessThanOrEqual(2, time() - $args[1]['t']);
                $that->assertEquals(['excludeFromIndexes' => ['data']], $args[2]);
                return $entity;
            });
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore->reveal()
        );
        $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $ret = $datastoreSessionHandler->write('sessionid', $data);

        $this->assertTrue($ret);
    }

    public function testWriteWithException()
    {
        $this->expectException('PHPUnit\Framework\Error\Warning');

        $data = 'sessiondata';
        $key = new Key('projectid');
        $key->pathElement(self::KIND, 'sessionid');
        $entity = new Entity($key, ['data' => $data]);
        $this->transaction->upsert($entity)
            ->shouldBeCalledTimes(1);
        $this->transaction->commit()
            ->shouldBeCalledTimes(1)
            ->willThrow(new Exception());
        $this->datastore->transaction(['databaseId' => ''])
            ->shouldBeCalledTimes(1)
            ->willReturn($this->transaction->reveal());
        $this->datastore->key(
            self::KIND,
            'sessionid',
            ['namespaceId' => self::NAMESPACE_ID]
        )
            ->shouldBeCalledTimes(1)
            ->willReturn($key);
        $that = $this;
        $this->datastore->entity($key, Argument::type('array'), Argument::type('array'))
            ->will(function ($args) use ($that, $key, $entity) {
                $that->assertEquals($key, $args[0]);
                $that->assertEquals('sessiondata', $args[1]['data']);
                $that->assertIsInt($args[1]['t']);
                $that->assertGreaterThanOrEqual($args[1]['t'], time());
                // 2 seconds grace period should be enough
                $that->assertLessThanOrEqual(2, time() - $args[1]['t']);
                $that->assertEquals(['excludeFromIndexes' => ['data']], $args[2]);
                return $entity;
            });

        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore->reveal()
        );
        $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $ret = $datastoreSessionHandler->write('sessionid', $data);

        $this->assertFalse($ret);
    }

    public function testWriteWithEntityOptions()
    {
        $data = 'sessiondata';
        $key = new Key('projectid');
        $key->pathElement(self::KIND, 'sessionid');
        $datastoreSessionHandlerOptions = [
            'entityOptions' => ['excludeFromIndexes' => ['data', 'additional']],
        ];
        $entity = new Entity($key, ['data' => $data]);
        $this->transaction->upsert($entity)
            ->shouldBeCalledTimes(1);
        $this->transaction->commit()
            ->shouldBeCalledTimes(1);
        $this->datastore->transaction(['databaseId' => ''])
            ->shouldBeCalledTimes(1)
            ->willReturn($this->transaction->reveal());
        $this->datastore->key(
            self::KIND,
            'sessionid',
            ['namespaceId' => self::NAMESPACE_ID]
        )
            ->shouldBeCalledTimes(1)
            ->willReturn($key);
        $that = $this;
        $this->datastore->entity($key, Argument::type('array'), Argument::type('array'))
            ->will(function ($args) use ($that, $key, $entity) {
                $that->assertEquals($key, $args[0]);
                $that->assertEquals('sessiondata', $args[1]['data']);
                $that->assertIsInt($args[1]['t']);
                $that->assertGreaterThanOrEqual($args[1]['t'], time());
                // 2 seconds grace period should be enough
                $that->assertLessThanOrEqual(2, time() - $args[1]['t']);
                $that->assertEquals(['excludeFromIndexes' => ['data', 'additional']], $args[2]);
                return $entity;
            });
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore->reveal(),
            DatastoreSessionHandler::DEFAULT_GC_LIMIT,
            $datastoreSessionHandlerOptions
        );
        $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $ret = $datastoreSessionHandler->write('sessionid', $data);

        $this->assertTrue($ret);
    }

    public function testWriteWithEmptyEntityOptions()
    {
        $data = 'sessiondata';
        $key = new Key('projectid');
        $key->pathElement(self::KIND, 'sessionid');
        $datastoreSessionHandlerOptions = [
            'entityOptions' => [],
        ];
        $entity = new Entity($key, ['data' => $data]);
        $this->transaction->upsert($entity)
            ->shouldBeCalledTimes(1);
        $this->transaction->commit()
            ->shouldBeCalledTimes(1);
        $this->datastore->transaction(['databaseId' => ''])
            ->shouldBeCalledTimes(1)
            ->willReturn($this->transaction->reveal());
        $this->datastore->key(
            self::KIND,
            'sessionid',
            ['namespaceId' => self::NAMESPACE_ID]
        )
            ->shouldBeCalledTimes(1)
            ->willReturn($key);
        $that = $this;
        $this->datastore->entity($key, Argument::type('array'), Argument::type('array'))
            ->will(function ($args) use ($that, $key, $entity) {
                $that->assertEquals($key, $args[0]);
                $that->assertEquals('sessiondata', $args[1]['data']);
                $that->assertIsInt($args[1]['t']);
                $that->assertGreaterThanOrEqual($args[1]['t'], time());
                // 2 seconds grace period should be enough
                $that->assertLessThanOrEqual(2, time() - $args[1]['t']);
                $that->assertEquals([], $args[2]);
                return $entity;
            });
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore->reveal(),
            DatastoreSessionHandler::DEFAULT_GC_LIMIT,
            $datastoreSessionHandlerOptions
        );
        $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $ret = $datastoreSessionHandler->write('sessionid', $data);

        $this->assertTrue($ret);
    }

    /**
     * @dataProvider invalidEntityOptions
     */
    public function testInvalidEntityOptions($datastoreSessionHandlerOptions)
    {
        $this->expectException('InvalidArgumentException');

        new DatastoreSessionHandler(
            $this->datastore->reveal(),
            DatastoreSessionHandler::DEFAULT_GC_LIMIT,
            $datastoreSessionHandlerOptions
        );
    }

    public function invalidEntityOptions()
    {
        return [
            [
                ['entityOptions' => 1]
            ],
            [
                ['entityOptions' => new \stdClass()]
            ],
        ];
    }

    public function testDestroy()
    {
        $key = new Key('projectid');
        $key->pathElement(self::KIND, 'sessionid');
        $this->transaction->delete($key)
            ->shouldBeCalledTimes(1);
        $this->transaction->commit()
            ->shouldBeCalledTimes(1);
        $this->datastore->transaction(['databaseId' => ''])
            ->shouldBeCalledTimes(1)
            ->willReturn($this->transaction->reveal());
        $this->datastore->key(
            self::KIND,
            'sessionid',
            ['namespaceId' => self::NAMESPACE_ID]
        )
            ->shouldBeCalledTimes(1)
            ->willReturn($key);

        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore->reveal()
        );
        $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $ret = $datastoreSessionHandler->destroy('sessionid');

        $this->assertTrue($ret);
    }

    public function testDestroyWithException()
    {
        $this->expectException('PHPUnit\Framework\Error\Warning');

        $key = new Key('projectid');
        $key->pathElement(self::KIND, 'sessionid');
        $this->transaction->delete($key)
            ->shouldBeCalledTimes(1);
        $this->transaction->commit()
            ->shouldBeCalledTimes(1)
            ->willThrow(new Exception());
        $this->datastore->transaction(['databaseId' => ''])
            ->shouldBeCalledTimes(1)
            ->willReturn($this->transaction->reveal());
        $this->datastore->key(
            self::KIND,
            'sessionid',
            ['namespaceId' => self::NAMESPACE_ID]
        )
            ->shouldBeCalledTimes(1)
            ->willReturn($key);

        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore->reveal()
        );
        $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $ret = $datastoreSessionHandler->destroy('sessionid');

        $this->assertFalse($ret);
    }

    public function testDefaultGcDoesNothing()
    {
        $this->datastore->transaction(['databaseId' => ''])
            ->shouldBeCalledTimes(1)
            ->willReturn($this->transaction->reveal());
        $this->datastore->query()->shouldNotBeCalled();
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore->reveal()
        );
        $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $ret = $datastoreSessionHandler->gc(100);

        $this->assertTrue($ret);
    }

    public function testGc()
    {
        $key1 = new Key('projectid');
        $key1->pathElement(self::KIND, 'sessionid1');
        $key2 = new Key('projectid');
        $key2->pathElement(self::KIND, 'sessionid2');
        $entity1 = new Entity($key1);
        $entity2 = new Entity($key2);
        $query = $this->prophesize(Query::class);
        $query->kind(self::KIND)
            ->shouldBeCalledTimes(1)
            ->willReturn($query->reveal());
        $that = $this;
        $query->filter(
            Argument::type('string'),
            Argument::type('string'),
            Argument::type('int')
        )
            ->shouldBeCalledTimes(1)
            ->will(function ($args) use ($that, $query) {
                $that->assertEquals('t', $args[0]);
                $that->assertEquals('<', $args[1]);
                $that->assertIsInt($args[2]);
                $diff = time() - $args[2];
                // 2 seconds grace period should be enough
                $that->assertLessThanOrEqual(102, $diff);
                $that->assertGreaterThanOrEqual(100, $diff);
                return $query->reveal();
            });

        $query->order('t')
            ->shouldBeCalledTimes(1)
            ->willReturn($query->reveal());
        $query->keysOnly()
            ->shouldBeCalledTimes(1)
            ->willReturn($query->reveal());
        $query->limit(1000)
            ->shouldBeCalledTimes(1)
            ->willReturn($query->reveal());

        $this->datastore->transaction(['databaseId' => ''])
            ->shouldBeCalledTimes(1)
            ->willReturn($this->transaction->reveal());
        $this->datastore->query()
            ->shouldBeCalledTimes(1)
            ->willReturn($query->reveal());
        $this->datastore->runQuery(
            Argument::type(Query::class),
            Argument::type('array')
        )
            ->shouldBeCalledTimes(1)
            ->will(function ($args) use ($that, $query, $entity1, $entity2) {
                $that->assertEquals($query->reveal(), $args[0]);
                $that->assertEquals(
                    ['namespaceId' => self::NAMESPACE_ID],
                    $args[1]
                );
                return [$entity1, $entity2];
            });

        $this->datastore->deleteBatch([$key1, $key2])
            ->shouldBeCalledTimes(1);
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore->reveal(),
            1000
        );

        $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $ret = $datastoreSessionHandler->gc(100);

        $this->assertTrue($ret);
    }

    public function testGcWithException()
    {
        $this->expectException('PHPUnit\Framework\Error\Warning');

        $key1 = new Key('projectid');
        $key1->pathElement(self::KIND, 'sessionid1');
        $key2 = new Key('projectid');
        $key2->pathElement(self::KIND, 'sessionid2');
        $entity1 = new Entity($key1);
        $entity2 = new Entity($key2);
        $query = $this->prophesize(Query::class);
        $query->kind(self::KIND)
            ->shouldBeCalledTimes(1)
            ->willReturn($query->reveal());
        $that = $this;
        $query->filter(
            Argument::type('string'),
            Argument::type('string'),
            Argument::type('int')
        )
            ->shouldBeCalledTimes(1)
            ->will(function ($args) use ($that, $query) {
                $that->assertEquals('t', $args[0]);
                $that->assertEquals('<', $args[1]);
                $that->assertIsInt($args[2]);
                $diff = time() - $args[2];
                // 2 seconds grace period should be enough
                $that->assertLessThanOrEqual(102, $diff);
                $that->assertGreaterThanOrEqual(100, $diff);
                return $query->reveal();
            });

        $query->order('t')
            ->shouldBeCalledTimes(1)
            ->willReturn($query->reveal());
        $query->keysOnly()
            ->shouldBeCalledTimes(1)
            ->willReturn($query->reveal());
        $query->limit(1000)
            ->shouldBeCalledTimes(1)
            ->willReturn($query->reveal());

        $this->datastore->transaction(['databaseId' => ''])
            ->shouldBeCalledTimes(1)
            ->willReturn($this->transaction->reveal());
        $this->datastore->query()
            ->shouldBeCalledTimes(1)
            ->willReturn($query->reveal());
        $this->datastore->runQuery(
            Argument::type(Query::class),
            Argument::type('array')
        )
            ->shouldBeCalledTimes(1)
            ->will(function ($args) use ($that, $query, $entity1, $entity2) {
                $that->assertEquals($query->reveal(), $args[0]);
                $that->assertEquals(
                    ['namespaceId' => self::NAMESPACE_ID],
                    $args[1]
                );
                return [$entity1, $entity2];
            });

        $this->datastore->deleteBatch([$key1, $key2])
            ->shouldBeCalledTimes(1)
            ->willThrow(new Exception());
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore->reveal(),
            1000
        );

        $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $ret = $datastoreSessionHandler->gc(100);

        $this->assertFalse($ret);
    }
}
