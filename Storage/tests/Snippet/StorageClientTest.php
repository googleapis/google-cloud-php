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

namespace Google\Cloud\Storage\Tests\Snippet;

use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\Upload\SignedUrlUploader;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\Connection\Rest;
use Google\Cloud\Storage\HmacKey;
use Google\Cloud\Storage\StorageClient;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group storage
 */
class StorageClientTest extends SnippetTestCase
{
    use ProphecyTrait;

    const BUCKET = 'my-bucket';
    const PROJECT_ID = 'my-project';

    private $connection;
    private $client;

    public function setUp(): void
    {
        $this->connection = $this->prophesize(Rest::class);
        $this->connection->projectId()
            ->willReturn(self::PROJECT_ID);
        $this->client = TestHelpers::stub(StorageClient::class, [
            ['projectId' => self::PROJECT_ID]
        ]);
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

    public function testGetServiceAccount()
    {
        $snippet = $this->snippetFromMethod(StorageClient::class, 'getServiceAccount');
        $snippet->addLocal('storage', $this->client);
        $expectedServiceAccount = self::PROJECT_ID . '@gs-project-accounts.iam.gserviceaccount.com';
        $this->connection->getServiceAccount([
            'projectId' => self::PROJECT_ID,
        ])->willReturn([
            'kind' => 'storage#serviceAccount',
            'email_address' => $expectedServiceAccount
        ])->shouldBeCalledTimes(1);

        $res = $snippet->invoke('serviceAccount');
        $this->assertEquals($expectedServiceAccount, $res->returnVal());
    }

    public function testHmacKeys()
    {
        $accessId = 'foo';

        $this->connection->listHmacKeys(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'items' => [
                    [
                        'accessId' => $accessId
                    ]
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(StorageClient::class, 'hmacKeys');
        $snippet->addLocal('storage', $this->client);

        $res = $snippet->invoke('hmacKeys');
        $this->assertEquals($accessId, $res->returnVal()->current()->accessId());
    }

    public function testHmacKeysWithServiceAccountEmail()
    {
        $accessId = 'foo';
        $email = 'account@myProject.iam.gserviceaccount.com';

        $this->connection->listHmacKeys(Argument::withEntry('serviceAccountEmail', $email))
            ->shouldBeCalled()
            ->willReturn([
                'items' => [
                    [
                        'accessId' => $accessId
                    ]
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(StorageClient::class, 'hmacKeys', 1);
        $snippet->addLocal('storage', $this->client);
        $snippet->addLocal('serviceAccountEmail', $email);

        $res = $snippet->invoke('hmacKeys');
        $this->assertEquals($accessId, $res->returnVal()->current()->accessId());
    }

    public function testHmacKey()
    {
        $accessId = 'foo';

        $snippet = $this->snippetFromMethod(StorageClient::class, 'hmacKey');
        $snippet->addLocal('storage', $this->client);
        $snippet->addLocal('accessId', $accessId);

        $res = $snippet->invoke('hmacKey');
        $this->assertInstanceOf(HmacKey::class, $res->returnVal());
        $this->assertEquals($accessId, $res->returnVal()->accessId());
    }

    public function testCreateHmacKey()
    {
        $secret = 'secret';

        $this->connection->createHmacKey(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'secret' => $secret,
                'metadata' => [
                    'accessId' => 'foo'
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(StorageClient::class, 'createHmacKey');
        $snippet->addLocal('storage', $this->client);

        $res = $snippet->invoke('secret');
        $this->assertEquals($secret, $res->returnVal());
    }
}
