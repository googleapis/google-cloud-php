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

namespace Google\Cloud\Tests\Unit\Storage;

use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\Upload\SignedUrlUploader;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\Connection\ConnectionInterface;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Storage\StreamWrapper;
use GuzzleHttp\Psr7;
use Prophecy\Argument;

/**
 * @group storage
 */
class StorageClientTest extends \PHPUnit_Framework_TestCase
{
    const PROJECT = 'my-project';
    public $connection;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = \Google\Cloud\Dev\stub(StorageClient::class, [['projectId' => self::PROJECT]]);
    }

    public function testGetBucket()
    {
        $this->client->___setProperty('connection', $this->connection->reveal());
        $this->assertInstanceOf(Bucket::class, $this->client->bucket('myBucket'));
    }

    public function testGetBucketRequesterPaysDefaultProjectId()
    {
        $this->connection->getBucket(Argument::withEntry('userProject', self::PROJECT));
        $this->client->___setProperty('connection', $this->connection->reveal());
        $bucket = $this->client->bucket('myBucket', true);

        $bucket->reload();
    }

    public function testGetsBucketsWithoutToken()
    {
        $this->connection->listBuckets(Argument::any())->willReturn([
            'items' => [
                ['name' => 'bucket1']
            ]
        ]);

        $this->client->___setProperty('connection', $this->connection->reveal());
        $buckets = iterator_to_array($this->client->buckets());

        $this->assertEquals('bucket1', $buckets[0]->name());
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

        $this->client->___setProperty('connection', $this->connection->reveal());
        $bucket = iterator_to_array($this->client->buckets());

        $this->assertEquals('bucket2', $bucket[1]->name());
    }

    public function testCreatesBucket()
    {
        $this->connection->insertBucket(Argument::any())->willReturn(['name' => 'bucket']);
        $this->client->___setProperty('connection', $this->connection->reveal());

        $this->assertInstanceOf(Bucket::class, $this->client->createBucket('bucket'));
    }

    public function testRegisteringStreamWrapper()
    {
        $this->assertTrue($this->client->registerStreamWrapper());
        $this->assertEquals($this->client, StreamWrapper::getClient());
        $this->assertTrue(in_array('gs', stream_get_wrappers()));
        $this->client->unregisterStreamWrapper();
    }

    public function testSignedUrlUploader()
    {
        $uri = 'http://example.com';
        $data = Psr7\stream_for('hello world');

        $uploader = $this->client->signedUrlUploader($uri, $data);
        $this->assertInstanceOf(SignedUrlUploader::class, $uploader);
    }

    public function testTimestamp()
    {
        $dt = new \DateTime;
        $ts = $this->client->timestamp($dt);
        $this->assertInstanceOf(Timestamp::class, $ts);
        $this->assertEquals($ts->get(), $dt);
    }
}
