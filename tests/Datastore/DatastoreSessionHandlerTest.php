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

/**
 * @group datastore
 */
class DatastoreSessionHandlerTest extends \PHPUnit_Framework_TestCase
{
    const KIND = 'PHPSESSID';
    private $datastore;

    public function setUp()
    {
        $this->datastore = $this->getMockBuilder(DatastoreClient::class)
            ->setMethods(
                ['key', 'lookup', 'entity', 'upsert', 'query', 'delete',
                 'runQuery', 'deleteBatch']
            )
            ->getMock();

    }

    public function testOpen()
    {
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore
        );
        $datastoreSessionHandler->open('savePath', 'sessionName');
    }

    public function testClose()
    {
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore
        );
        $datastoreSessionHandler->close();
    }

    public function testReadNothing()
    {
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore
        );
        $key = new Key('projectid');
        $key->pathElement(self::KIND, 'sessionid');
        $this->datastore->expects($this->once())
            ->method('key')
            ->with(self::KIND, 'sessionid')
            ->willReturn($key);

        $ret = $datastoreSessionHandler->read('sessionid');

        $this->assertEquals('', $ret);
    }

    public function testReadWithException()
    {
        \PHPUnit_Framework_Error_Notice::$enabled = FALSE;
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore
        );
        $key = new Key('projectid');
        $key->pathElement(self::KIND, 'sessionid');
        $this->datastore->expects($this->once())
            ->method('key')
            ->with(self::KIND, 'sessionid')
            ->will($this->throwException(new \Exception()));

        $ret = $datastoreSessionHandler->read('sessionid');

        $this->assertEquals('', $ret);
    }

    public function testReadEntity()
    {
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore
        );
        $key = new Key('projectid');
        $key->pathElement(self::KIND, 'sessionid');
        $entity = new Entity($key, ['data' => 'sessiondata']);
        $this->datastore->expects($this->once())
            ->method('key')
            ->with(self::KIND, 'sessionid')
            ->willReturn($key);
        $this->datastore->expects($this->once())
            ->method('lookup')
            ->with($key)
            ->willReturn($entity);

        $ret = $datastoreSessionHandler->read('sessionid');

        $this->assertEquals('sessiondata', $ret);
    }

    public function testWrite()
    {
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore
        );
        $data = 'sessiondata';
        $key = new Key('projectid');
        $key->pathElement(self::KIND, 'sessionid');
        $entity = new Entity($key, ['data' => 'sessiondata']);
        $this->datastore->expects($this->once())
            ->method('key')
            ->with(self::KIND, 'sessionid')
            ->willReturn($key);
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
        $this->datastore->expects($this->once())
            ->method('upsert')
            ->with($entity);

        $ret = $datastoreSessionHandler->write('sessionid', $data);

        $this->assertEquals(true, $ret);
    }

    public function testWriteWithException()
    {
        \PHPUnit_Framework_Error_Notice::$enabled = FALSE;
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore
        );
        $data = 'sessiondata';
        $key = new Key('projectid');
        $key->pathElement(self::KIND, 'sessionid');
        $entity = new Entity($key, ['data' => 'sessiondata']);
        $this->datastore->expects($this->once())
            ->method('key')
            ->with(self::KIND, 'sessionid')
            ->willReturn($key);
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
        $this->datastore->expects($this->once())
            ->method('upsert')
            ->with($entity)
            ->will($this->throwException(new \Exception()));

        $ret = $datastoreSessionHandler->write('sessionid', $data);

        $this->assertEquals(false, $ret);
    }

    public function testDestroy()
    {
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore
        );
        $key = new Key('projectid');
        $key->pathElement(self::KIND, 'sessionid');
        $this->datastore->expects($this->once())
            ->method('key')
            ->with(self::KIND, 'sessionid')
            ->willReturn($key);
        $this->datastore->expects($this->once())
            ->method('delete')
            ->with($key);

        $ret = $datastoreSessionHandler->destroy('sessionid');

        $this->assertEquals(true, $ret);
    }

    public function testDestroyWithException()
    {
        \PHPUnit_Framework_Error_Notice::$enabled = FALSE;
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore
        );
        $key = new Key('projectid');
        $key->pathElement(self::KIND, 'sessionid');
        $this->datastore->expects($this->once())
            ->method('key')
            ->with(self::KIND, 'sessionid')
            ->willReturn($key);
        $this->datastore->method('delete')
            ->with($key)
            ->will($this->throwException(new \Exception()));

        $ret = $datastoreSessionHandler->destroy('sessionid');

        $this->assertEquals(false, $ret);
    }

    public function testGc()
    {
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore
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
            ->with($mockedQuery)
            ->willReturn([$entity1, $entity2]);
        $this->datastore->expects($this->once())
            ->method('deleteBatch')
            ->with([$key1, $key2]);

        $ret = $datastoreSessionHandler->gc(100);

        $this->assertEquals(true, $ret);
    }

    public function testGcWithException()
    {
        \PHPUnit_Framework_Error_Notice::$enabled = FALSE;
        $datastoreSessionHandler = new DatastoreSessionHandler(
            $this->datastore
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
            ->with($mockedQuery)
            ->willReturn([$entity1, $entity2]);
        $this->datastore->expects($this->once())
            ->method('deleteBatch')
            ->with([$key1, $key2])
            ->will($this->throwException(new \Exception()));

        $ret = $datastoreSessionHandler->gc(100);

        $this->assertEquals(false, $ret);
    }
}
