<?php
/**
 * Copyright 2015 Google Inc.
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

namespace Google\Cloud\Tests\Storage;

use Google\Cloud\Exception\NotFoundException;
use Google\Cloud\Storage\StorageObject;
use GuzzleHttp\Psr7;
use Prophecy\Argument;

/**
 * @group storage
 */
class StorageObjectTest extends \PHPUnit_Framework_TestCase
{
    public $connection;

    public function setUp()
    {
        $this->connection = $this->prophesize('Google\Cloud\Storage\Connection\ConnectionInterface');
    }

    public function testGetAcl()
    {
        $object = new StorageObject($this->connection->reveal(), 'object.txt', 'bucket');

        $this->assertInstanceOf('Google\Cloud\Storage\Acl', $object->acl());
    }

    public function testDoesExistTrue()
    {
        $this->connection->getObject(Argument::any())->willReturn(['name' => 'object.txt']);
        $object = new StorageObject($this->connection->reveal(), 'object.txt', 'bucket');

        $this->assertTrue($object->exists());
    }

    public function testDoesExistFalse()
    {
        $this->connection->getObject(Argument::any())->willThrow(new NotFoundException(null));
        $object = new StorageObject($this->connection->reveal(), 'object.txt', 'bucket');

        $this->assertFalse($object->exists());
    }

    public function testDelete()
    {
        $object = new StorageObject($this->connection->reveal(), 'object.txt', 'bucket');

        $this->assertNull($object->delete());
    }

    public function testUpdatesData()
    {
        $data = ['contentType' => 'image/jpg'];
        $this->connection->patchObject(Argument::any())->willReturn(['name' => 'object.txt'] + $data);
        $object = new StorageObject($this->connection->reveal(), 'object.txt', 'bucket', null, ['contentType' => 'image/png']);

        $object->update($data);

        $this->assertEquals($data['contentType'], $object->info()['contentType']);
    }

    public function testDownloadsAsString()
    {
        $stream = Psr7\stream_for($string = 'abcdefg');
        $this->connection->downloadObject(Argument::any())->willReturn($stream);

        $object = new StorageObject($this->connection->reveal(), 'object.txt', 'bucket');

        $this->assertEquals($string, $object->downloadAsString());
    }

    public function testDownloadsToFile()
    {
        $stream = Psr7\stream_for($string = 'abcdefg');
        $this->connection->downloadObject(Argument::any())->willReturn($stream);

        $object = new StorageObject($this->connection->reveal(), 'object.txt', 'bucket');

        $this->assertEquals($string, $object->downloadToFile('php://temp')->getContents());
    }

    public function testGetsInfo()
    {
        $objectInfo = [
            'name' => 'object.txt',
            'bucket' => 'bucket',
            'etag' => 'ABC',
            'kind' => 'storage#object'
        ];
        $object = new StorageObject($this->connection->reveal(), 'object.txt', 'bucket', null, $objectInfo);

        $this->assertEquals($objectInfo, $object->info());
    }

    public function testGetsInfoWithReload()
    {
        $objectInfo = [
            'name' => 'object.txt',
            'bucket' => 'bucket',
            'etag' => 'ABC',
            'kind' => 'storage#object'
        ];
        $this->connection->getObject(Argument::any())
            ->willReturn($objectInfo)
            ->shouldBeCalledTimes(1);
        $object = new StorageObject($this->connection->reveal(), 'object.txt', 'bucket');

        $this->assertEquals($objectInfo, $object->info());
    }

    public function testGetsName()
    {
        $object = new StorageObject($this->connection->reveal(), $name = 'object.txt', 'bucket');

        $this->assertEquals($name, $object->name());
    }

    public function testGetsIdentity()
    {
        $object = new StorageObject($this->connection->reveal(), $name = 'object.txt', $bucketName = 'bucket');

        $this->assertEquals($name, $object->identity()['object']);
        $this->assertEquals($bucketName, $object->identity()['bucket']);
    }
}
