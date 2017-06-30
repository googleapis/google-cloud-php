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

namespace Google\Cloud\Tests\Snippets\Storage;

use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\Upload\SignedUrlUploader;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\Connection\Rest;
use Google\Cloud\Storage\StorageClient;
use Prophecy\Argument;

/**
 * @group storage
 */
class StorageClientTest extends SnippetTestCase
{
    const BUCKET = 'my-bucket';

    private $connection;
    private $client;

    public function setUp()
    {
        $this->connection = $this->prophesize(Rest::class);
        $this->client = \Google\Cloud\Dev\stub(StorageClient::class);
        $this->client->___setProperty('connection', $this->connection->reveal());
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(StorageClient::class);
        $res = $snippet->invoke('storage');
        $this->assertInstanceOf(StorageClient::class, $res->returnVal());
    }

    public function testBucket()
    {
        $snippet = $this->snippetFromMethod(StorageClient::class, 'bucket');
        $snippet->addLocal('storage', $this->client);

        $res = $snippet->invoke('bucket');
        $this->assertInstanceOf(Bucket::class, $res->returnVal());
    }

    public function testBuckets()
    {
        $snippet = $this->snippetFromMethod(StorageClient::class, 'buckets');
        $snippet->addLocal('storage', $this->client);

        $this->connection->listBuckets(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'items' => [
                    ['name' => 'album 1'],
                    ['name' => 'album 2'],
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('buckets');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());

        $buckets = iterator_to_array($res->returnVal());
        $this->assertEquals('album 1', $buckets[0]->name());
        $this->assertEquals('album 2', $buckets[1]->name());
    }

    public function testBucketsWithPrefix()
    {
        $snippet = $this->snippetFromMethod(StorageClient::class, 'buckets', 1);
        $snippet->addLocal('storage', $this->client);

        $this->connection->listBuckets(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'items' => [
                    ['name' => 'album 1'],
                    ['name' => 'album 2'],
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('buckets');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertEquals('album 1', explode("\n", $res->output())[0]);
        $this->assertEquals('album 2', explode("\n", $res->output())[1]);
    }

    public function testCreateBucket()
    {
        $snippet = $this->snippetFromMethod(StorageClient::class, 'createBucket');
        $snippet->addLocal('storage', $this->client);

        $this->connection->insertBucket(Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('bucket');
        $this->assertInstanceOf(Bucket::class, $res->returnVal());
    }

    public function testCreateBucketWithLogging()
    {
        $snippet = $this->snippetFromMethod(StorageClient::class, 'createBucket', 1);
        $snippet->addLocal('storage', $this->client);

        $this->connection->insertBucket(Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('bucket');
        $this->assertInstanceOf(Bucket::class, $res->returnVal());
    }

    public function testSignedUrlUploader()
    {
        $rw = $this->prophesize(RequestWrapper::class);
        $this->connection->requestWrapper()->willReturn($rw->reveal());

        $snippet = $this->snippetFromMethod(StorageClient::class, 'signedUrlUploader');
        $snippet->addLocal('storage', $this->client);
        $snippet->addLocal('uri', 'test');
        $snippet->replace('/path/to/myfile.doc', 'php://temp');

        $res = $snippet->invoke('uploader');
        $this->assertInstanceOf(SignedUrlUploader::class, $res->returnVal());
    }

    public function testTimestamp()
    {
        $snippet = $this->snippetFromMethod(StorageClient::class, 'timestamp');
        $snippet->addLocal('storage', $this->client);

        $res = $snippet->invoke('timestamp');
        $this->assertInstanceOf(Timestamp::class, $res->returnVal());
    }
}
