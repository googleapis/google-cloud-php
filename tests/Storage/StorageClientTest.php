<?php

namespace Google\Cloud\Tests\Storage;

use Google\Cloud\Storage\StorageClient;
use Prophecy\Argument;

class StorageClientTest extends \PHPUnit_Framework_TestCase
{
    public $connection;

    public function setUp()
    {
        $this->connection = $this->prophesize('Google\Cloud\Storage\Connection\ConnectionInterface');
    }

    public function testGetBucket()
    {
        $client = new StorageClient($this->connection->reveal(), 'projectId');

        $this->assertInstanceOf('Google\Cloud\Storage\Bucket', $client->bucket('myBucket'));
    }

    public function testGetsBucketsWithoutToken()
    {
        $this->connection->listBuckets(Argument::any())->willReturn([
            'items' => [
                ['name' => 'bucket1']
            ]
        ]);

        $client = new StorageClient($this->connection->reveal(), 'projectId');
        $buckets = iterator_to_array($client->buckets());

        $this->assertEquals('bucket1', $buckets[0]->getName());
    }

    public function testGetsBucketsWithToken()
    {
        $this->connection->listBuckets(Argument::any())->willReturn(
            [
                'nextPageToken' => 'token',
                'items' => [
                    ['name' => 'bucket1']
                ]
            ],
                [
                'items' => [
                    ['name' => 'bucket2']
                ]
            ]
        );

        $client = new StorageClient($this->connection->reveal(), 'projectId');
        $bucket = iterator_to_array($client->buckets());

        $this->assertEquals('bucket2', $bucket[1]->getName());
    }

    public function testCreatesBucket()
    {
        $this->connection->createBucket(Argument::any())->willReturn(['name' => 'bucket']);
        $client = new StorageClient($this->connection->reveal(), 'projectId');

        $this->assertInstanceOf('Google\Cloud\Storage\Bucket', $client->createBucket('bucket'));
    }
}
