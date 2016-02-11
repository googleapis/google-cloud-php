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
