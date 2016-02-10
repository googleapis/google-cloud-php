<?php

namespace Google\Cloud\Tests\Storage;

use Google\Cloud\Storage\Bucket;
use Prophecy\Argument;

class BucketTest extends \PHPUnit_Framework_TestCase
{
    public $connection;

    public function setUp()
    {
        $this->connection = $this->prophesize('Google\Cloud\Storage\Connection\ConnectionInterface');
    }

    public function testGetsAcl()
    {
        $bucket = new Bucket($this->connection->reveal(), 'bucket');

        $this->assertInstanceOf('Google\Cloud\Storage\Acl', $bucket->acl());
    }

    public function testGetsDefaultAcl()
    {
        $bucket = new Bucket($this->connection->reveal(), 'bucket');

        $this->assertInstanceOf('Google\Cloud\Storage\Acl', $bucket->defaultAcl());
    }

    public function testDoesExistTrue()
    {
        $this->connection->getBucket(Argument::any())->willReturn(['name' => 'bucket']);
        $bucket = new Bucket($this->connection->reveal(), 'bucket');

        $this->assertTrue($bucket->exists());
    }

    public function testDoesExistFalse()
    {
        $this->connection->getBucket(Argument::any())->willThrow(new \Exception());
        $bucket = new Bucket($this->connection->reveal(), 'bucket');

        $this->assertFalse($bucket->exists());
    }

    public function testGetObject()
    {
        $bucket = new Bucket($this->connection->reveal(), 'bucket');

        $this->assertInstanceOf('Google\Cloud\Storage\Object', $bucket->object('peter-venkman.jpg'));
    }

    public function testInstantiateObjectWithGeneration()
    {
        $bucket = new Bucket($this->connection->reveal(), 'bucket');

        $object = $bucket->object('peter-venkman.jpg', [
            'generation' => '5'
        ]);

        $this->assertInstanceOf('Google\Cloud\Storage\Object', $object);
    }

    public function testGetsObjectsWithoutToken()
    {
        $this->connection->listObjects(Argument::any())->willReturn([
            'items' => [
                ['name' => 'file.txt']
            ]
        ]);

        $bucket = new Bucket($this->connection->reveal(), 'bucket');
        $objects = iterator_to_array($bucket->objects());

        $this->assertEquals('file.txt', $objects[0]->getName());
    }

    public function testGetsObjectsWithToken()
    {
        $this->connection->listObjects(Argument::any())->willReturn(
            [
                'nextPageToken' => 'token',
                'items' => [
                    ['name' => 'file.txt']
                ]
            ],
                [
                'items' => [
                    ['name' => 'file2.txt']
                ]
            ]
        );

        $bucket = new Bucket($this->connection->reveal(), 'bucket');
        $objects = iterator_to_array($bucket->objects());

        $this->assertEquals('file2.txt', $objects[1]->getName());
    }

    public function testDelete()
    {
        $bucket = new Bucket($this->connection->reveal(), 'bucket');

        $this->assertNull($bucket->delete());
    }

    public function testUpdatesData()
    {
        $versioningData = [
            'versioning' => [
                'enabled' => true
            ]
        ];
        $this->connection->patchBucket(Argument::any())->willReturn(['name' => 'bucket'] + $versioningData);
        $bucket = new Bucket($this->connection->reveal(), 'bucket', [
            'name' => 'bucket',
            'versioning' => [
                'enabled' => false
            ]
        ]);

        $bucket->update($versioningData);

        $this->assertTrue($bucket->getInfo()['versioning']['enabled']);
    }

    public function testGetsInfo()
    {
        $bucketInfo = [
            'name' => 'bucket',
            'etag' => 'ABC',
            'kind' => 'storage#bucket'
        ];
        $bucket = new Bucket($this->connection->reveal(), 'bucket', $bucketInfo);

        $this->assertEquals($bucketInfo, $bucket->getInfo());
    }

    public function testGetsInfoWithForce()
    {
        $bucketInfo = [
            'name' => 'bucket',
            'etag' => 'ABC',
            'kind' => 'storage#bucket'
        ];
        $this->connection->getBucket(Argument::any())->willReturn($bucketInfo);
        $bucket = new Bucket($this->connection->reveal(), 'bucket');

        $this->assertEquals($bucketInfo, $bucket->getInfo(['force' => true]));
    }

    public function testGetsName()
    {
        $bucket = new Bucket($this->connection->reveal(), $name = 'bucket');

        $this->assertEquals($name, $bucket->getName());
    }
}
