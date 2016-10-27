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

use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\DatastoreSessionHandler;
use Google\Cloud\Datastore\Entity;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Query\Query;
use Google\Cloud\Datastore\Transaction;
use InvalidArgumentException;

/**
 * @group datastore
 */
class DatastoreSessionHandlerTest extends \PHPUnit_Framework_TestCase
{
    const KIND = 'PHPSESSID';
    const NAMESPACE_ID = 'sessions';

    private $datastore;
    private $transaction;

    public function setUp()
    {
        $this->datastore = $this->getMockBuilder(DatastoreClient::class)
            ->setMethods(
                [
                    'key', 'entity', 'query', 'runQuery', 'deleteBatch',
                    'transaction'
                ]
            )
            ->getMock();
        $this->transaction = $this->getMockBuilder(Transaction::class)
            ->disableOriginalConstructor()
            ->setMethods(['lookup', 'upsert', 'delete', 'commit'])
            ->getmock();
    }

    public function testOpen()
    {
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore
        );
        $this->datastore->expects($this->once())
            ->method('transaction')
            ->willReturn($this->transaction);
        $ret = $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $this->assertTrue($ret);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testOpenNotAllowed()
    {
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore
        );
        $this->datastore->expects($this->never())
            ->method('transaction')
            ->willReturn($this->transaction);
        $datastoreSessionHandler->open('/tmp/sessions', self::KIND);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testOpenReserved()
    {
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore
        );
        $this->datastore->expects($this->never())
            ->method('transaction')
            ->willReturn($this->transaction);
        $datastoreSessionHandler->open('__RESERVED__', self::KIND);
    }

    public function testClose()
    {
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore
        );
        $ret = $datastoreSessionHandler->close();
        $this->assertTrue($ret);
    }

    public function testReadNothing()
    {
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore
        );
        $this->datastore->expects($this->once())
            ->method('transaction')
            ->willReturn($this->transaction);
        $key = new Key('projectid');
        $key->pathElement(self::KIND, 'sessionid');
        $this->datastore->expects($this->once())
            ->method('key')
            ->will($this->returnCallback(
                function($kind, $id, $options) use ($key) {
                    $this->assertEquals(self::KIND, $kind);
                    $this->assertEquals('sessionid', $id);
                    $this->assertEquals(
                        ['namespaceId' => self::NAMESPACE_ID],
                        $options
                    );
                    return $key;
                }
            ));
        $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $ret = $datastoreSessionHandler->read('sessionid');

        $this->assertEquals('', $ret);
    }

    public function testReadWithException()
    {
        \PHPUnit_Framework_Error_Warning::$enabled = FALSE;
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore
        );
        $this->datastore->expects($this->once())
            ->method('transaction')
            ->willReturn($this->transaction);
        $key = new Key('projectid');
        $key->pathElement(self::KIND, 'sessionid');
        $this->datastore->expects($this->once())
            ->method('key')
            ->with(self::KIND, 'sessionid')
            ->will($this->throwException(new \Exception()));

        $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $ret = $datastoreSessionHandler->read('sessionid');

        $this->assertEquals('', $ret);
    }

    public function testReadEntity()
    {
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore
        );
        $this->datastore->expects($this->once())
            ->method('transaction')
            ->willReturn($this->transaction);
        $key = new Key('projectid');
        $key->pathElement(self::KIND, 'sessionid');
        $entity = new Entity($key, ['data' => 'sessiondata']);
        $this->datastore->expects($this->once())
            ->method('key')
            ->will($this->returnCallback(
                function($kind, $id, $options) use ($key) {
                    $this->assertEquals(self::KIND, $kind);
                    $this->assertEquals('sessionid', $id);
                    $this->assertEquals(
                        ['namespaceId' => self::NAMESPACE_ID],
                        $options
                    );
                    return $key;
                }
            ));
        $this->transaction->expects($this->once())
            ->method('lookup')
            ->with($key)
            ->willReturn($entity);

        $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $ret = $datastoreSessionHandler->read('sessionid');

        $this->assertEquals('sessiondata', $ret);
    }

    public function testWrite()
    {
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore
        );
        $this->datastore->expects($this->once())
            ->method('transaction')
            ->willReturn($this->transaction);
        $data = 'sessiondata';
        $key = new Key('projectid');
        $key->pathElement(self::KIND, 'sessionid');
        $entity = new Entity($key, ['data' => 'sessiondata']);
        $this->datastore->expects($this->once())
            ->method('key')
            ->will($this->returnCallback(
                function($kind, $id, $options) use ($key) {
                    $this->assertEquals(self::KIND, $kind);
                    $this->assertEquals('sessionid', $id);
                    $this->assertEquals(
                        ['namespaceId' => self::NAMESPACE_ID],
                        $options
                    );
                    return $key;
                }
            ));
        $this->datastore->expects($this->once())
            ->method('entity')
            ->will($this->returnCallback(
                function($k, $e) use ($key, $entity) {
                    $this->assertEquals($key, $k);
                    $this->assertEquals('sessiondata', $e['data']);
                    $this->assertInternalType('int', $e['t']);
                    $this->assertTrue(time() >= $e['t']);
                    // 2 seconds grace period should be enough
                    $this->assertTrue(time() - $e['t'] <= 2);
                    return $entity;
                }));
        $this->transaction->expects($this->once())
            ->method('upsert')
            ->with($entity);
        $this->transaction->expects($this->once())
            ->method('commit');

        $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $ret = $datastoreSessionHandler->write('sessionid', $data);

        $this->assertEquals(true, $ret);
    }

    public function testWriteWithException()
    {
        \PHPUnit_Framework_Error_Warning::$enabled = FALSE;
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore
        );
        $this->datastore->expects($this->once())
            ->method('transaction')
            ->willReturn($this->transaction);
        $data = 'sessiondata';
        $key = new Key('projectid');
        $key->pathElement(self::KIND, 'sessionid');
        $entity = new Entity($key, ['data' => 'sessiondata']);
        $this->datastore->expects($this->once())
            ->method('key')
            ->will($this->returnCallback(
                function($kind, $id, $options) use ($key) {
                    $this->assertEquals(self::KIND, $kind);
                    $this->assertEquals('sessionid', $id);
                    $this->assertEquals(
                        ['namespaceId' => self::NAMESPACE_ID],
                        $options
                    );
                    return $key;
                }
            ));
        $this->datastore->expects($this->once())
            ->method('entity')
            ->will($this->returnCallback(
                function($k, $e) use ($key, $entity) {
                    $this->assertEquals($key, $k);
                    $this->assertEquals('sessiondata', $e['data']);
                    $this->assertInternalType('int', $e['t']);
                    $this->assertTrue(time() >= $e['t']);
                    // 2 seconds grace period should be enough
                    $this->assertTrue(time() - $e['t'] <= 2);
                    return $entity;
                }));
        $this->transaction->expects($this->once())
            ->method('upsert')
            ->with($entity)
            ->will($this->throwException(new \Exception()));

        $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $ret = $datastoreSessionHandler->write('sessionid', $data);

        $this->assertEquals(false, $ret);
    }

    public function testDestroy()
    {
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore
        );
        $this->datastore->expects($this->once())
            ->method('transaction')
            ->willReturn($this->transaction);
        $key = new Key('projectid');
        $key->pathElement(self::KIND, 'sessionid');
        $this->datastore->expects($this->once())
            ->method('key')
            ->will($this->returnCallback(
                function($kind, $id, $options) use ($key) {
                    $this->assertEquals(self::KIND, $kind);
                    $this->assertEquals('sessionid', $id);
                    $this->assertEquals(
                        ['namespaceId' => self::NAMESPACE_ID],
                        $options
                    );
                    return $key;
                }
            ));
        $this->transaction->expects($this->once())
            ->method('delete')
            ->with($key);

        $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $ret = $datastoreSessionHandler->destroy('sessionid');

        $this->assertEquals(true, $ret);
    }

    public function testDestroyWithException()
    {
        \PHPUnit_Framework_Error_Warning::$enabled = FALSE;
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore
        );
        $this->datastore->expects($this->once())
            ->method('transaction')
            ->willReturn($this->transaction);
        $key = new Key('projectid');
        $key->pathElement(self::KIND, 'sessionid');
        $this->datastore->expects($this->once())
            ->method('key')
            ->will($this->returnCallback(
                function($kind, $id, $options) use ($key) {
                    $this->assertEquals(self::KIND, $kind);
                    $this->assertEquals('sessionid', $id);
                    $this->assertEquals(
                        ['namespaceId' => self::NAMESPACE_ID],
                        $options
                    );
                    return $key;
                }
            ));
        $this->transaction->method('delete')
            ->with($key)
            ->will($this->throwException(new \Exception()));

        $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $ret = $datastoreSessionHandler->destroy('sessionid');

        $this->assertEquals(false, $ret);
    }

    public function testDefaultGcDoesNothing()
    {
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore
        );
        $this->datastore->expects($this->never())->method('query');
        $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $ret = $datastoreSessionHandler->gc(100);

        $this->assertEquals(true, $ret);
    }

    public function testGc()
    {
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore,
            1000
        );
        $mockedQuery = $this->getMockBuilder(Query::class)
            ->setMethods(
                ['kind', 'filter', 'order', 'keysOnly', 'limit']
            )
            ->disableOriginalConstructor()
            ->getMock();
        $key1 = new Key('projectid');
        $key1->pathElement(self::KIND, 'sessionid1');
        $key2 = new Key('projectid');
        $key2->pathElement(self::KIND, 'sessionid2');
        $entity1 = new Entity($key1);
        $entity2 = new Entity($key2);
        $this->datastore->expects($this->once())
            ->method('query')
            ->willReturn($mockedQuery);
        $mockedQuery->expects($this->once())
            ->method('kind')
            ->with(self::KIND)
            ->willReturn($mockedQuery);
        $mockedQuery->expects($this->once())
            ->method('filter')
            ->will($this->returnCallback(
                function($prop, $op, $val) use ($mockedQuery) {
                    $this->assertEquals('t', $prop);
                    $this->assertEquals('<', $op);
                    $this->assertInternalType('int', $val);
                    $diff = time() - $val;
                    // 2 seconds grace period should be enough
                    $this->assertTrue($diff <= 102);
                    $this->assertTrue($diff >= 100);
                    return $mockedQuery;
                }));
        $mockedQuery->expects($this->once())
            ->method('order')
            ->with('t')
            ->willReturn($mockedQuery);
        $mockedQuery->expects($this->once())
            ->method('keysOnly')
            ->with()
            ->willReturn($mockedQuery);
        $mockedQuery->expects($this->once())
            ->method('limit')
            ->with(1000)
            ->willReturn($mockedQuery);
        $this->datastore->expects($this->once())
            ->method('runQuery')
            ->will($this->returnCallback(
                function($query, $options)
                use ($mockedQuery, $entity1, $entity2) {
                    $this->assertEquals($mockedQuery, $query);
                    $this->assertEquals(
                        ['namespaceId' => self::NAMESPACE_ID],
                        $options
                    );
                    return [$entity1, $entity2];
                }
            ));
        $this->datastore->expects($this->once())
            ->method('deleteBatch')
            ->with([$key1, $key2]);

        $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $ret = $datastoreSessionHandler->gc(100);

        $this->assertEquals(true, $ret);
    }

    public function testGcWithException()
    {
        \PHPUnit_Framework_Error_Warning::$enabled = FALSE;
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore,
            1000
        );
        $mockedQuery = $this->getMockBuilder(Query::class)
            ->setMethods(
                ['kind', 'filter', 'order', 'keysOnly', 'limit']
            )
            ->disableOriginalConstructor()
            ->getMock();
        $key1 = new Key('projectid');
        $key1->pathElement(self::KIND, 'sessionid1');
        $key2 = new Key('projectid');
        $key2->pathElement(self::KIND, 'sessionid2');
        $entity1 = new Entity($key1);
        $entity2 = new Entity($key2);
        $this->datastore->expects($this->once())
            ->method('query')
            ->willReturn($mockedQuery);
        $mockedQuery->expects($this->once())
            ->method('kind')
            ->with(self::KIND)
            ->willReturn($mockedQuery);
        $mockedQuery->expects($this->once())
            ->method('filter')
            ->will($this->returnCallback(
                function($prop, $op, $val) use ($mockedQuery) {
                    $this->assertEquals('t', $prop);
                    $this->assertEquals('<', $op);
                    $this->assertInternalType('int', $val);
                    $diff = time() - $val;
                    // 2 seconds grace period should be enough
                    $this->assertTrue($diff <= 102);
                    $this->assertTrue($diff >= 100);
                    return $mockedQuery;
                }));
        $mockedQuery->expects($this->once())
            ->method('order')
            ->with('t')
            ->willReturn($mockedQuery);
        $mockedQuery->expects($this->once())
            ->method('keysOnly')
            ->with()
            ->willReturn($mockedQuery);
        $mockedQuery->expects($this->once())
            ->method('limit')
            ->with(1000)
            ->willReturn($mockedQuery);
        $this->datastore->expects($this->once())
            ->method('runQuery')
            ->will($this->returnCallback(
                function($query, $options)
                use ($mockedQuery, $entity1, $entity2) {
                    $this->assertEquals($mockedQuery, $query);
                    $this->assertEquals(
                        ['namespaceId' => self::NAMESPACE_ID],
                        $options
                    );
                    return [$entity1, $entity2];
                }
            ));
        $this->datastore->expects($this->once())
            ->method('deleteBatch')
            ->with([$key1, $key2])
            ->will($this->throwException(new \Exception()));

        $datastoreSessionHandler->open(self::NAMESPACE_ID, self::KIND);
        $ret = $datastoreSessionHandler->gc(100);

        $this->assertEquals(false, $ret);
    }
}
