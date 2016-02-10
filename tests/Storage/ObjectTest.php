<?php

namespace Google\Cloud\Tests\Storage;

use Google\Cloud\Storage\Object;
use Prophecy\Argument;

class ObjectTest extends \PHPUnit_Framework_TestCase
{
    public $connection;

    public function setUp()
    {
        $this->connection = $this->prophesize('Google\Cloud\Storage\Connection\ConnectionInterface');
    }

    public function testGetAcl()
    {
        $object = new Object($this->connection->reveal(), 'object.txt', 'bucket');

        $this->assertInstanceOf('Google\Cloud\Storage\Acl', $object->acl());
    }

    public function testDoesExistTrue()
    {
        $this->connection->getObject(Argument::any())->willReturn(['name' => 'object.txt']);
        $object = new Object($this->connection->reveal(), 'object.txt', 'bucket');

        $this->assertTrue($object->exists());
    }

    public function testDoesExistFalse()
    {
        $this->connection->getObject(Argument::any())->willThrow(new \Exception());
        $object = new Object($this->connection->reveal(), 'object.txt', 'bucket');

        $this->assertFalse($object->exists());
    }

    public function testDelete()
    {
        $object = new Object($this->connection->reveal(), 'object.txt', 'bucket');

        $this->assertNull($object->delete());
    }

    public function testUpdatesData()
    {
        $data = ['contentType' => 'image/jpg'];
        $this->connection->patchObject(Argument::any())->willReturn(['name' => 'object.txt'] + $data);
        $object = new Object($this->connection->reveal(), 'object.txt', 'bucket', null, ['contentType' => 'image/png']);

        $object->update($data);

        $this->assertEquals($data['contentType'], $object->getInfo()['contentType']);
    }

    public function testDownloadsAsString()
    {
        $stream = $this->prophesize('Psr\Http\Message\StreamInterface');
        $stream->__toString()->willReturn($string = 'abcdefg');

        $this->connection->downloadObject(Argument::any())->willReturn($stream->reveal());

        $object = new Object($this->connection->reveal(), 'object.txt', 'bucket');

        $this->assertEquals($string, $object->downloadAsString());
    }

    public function testGetsInfo()
    {
        $objectInfo = [
            'name' => 'object.txt',
            'bucket' => 'bucket',
            'etag' => 'ABC',
            'kind' => 'storage#object'
        ];
        $object = new Object($this->connection->reveal(), 'object.txt', 'bucket', null, $objectInfo);

        $this->assertEquals($objectInfo, $object->getInfo());
    }

    public function testGetsInfoWithForce()
    {
        $objectInfo = [
            'name' => 'object.txt',
            'bucket' => 'bucket',
            'etag' => 'ABC',
            'kind' => 'storage#object'
        ];
        $this->connection->getObject(Argument::any())->willReturn($objectInfo);
        $object = new Object($this->connection->reveal(), 'object.txt', 'bucket', null, $objectInfo);

        $this->assertEquals($objectInfo, $object->getInfo(['force' => true]));
    }

    public function testGetsName()
    {
        $object = new Object($this->connection->reveal(), $name = 'object.txt', 'bucket');

        $this->assertEquals($name, $object->getName());
    }
}
