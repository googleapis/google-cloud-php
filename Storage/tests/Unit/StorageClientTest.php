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

namespace Google\Cloud\Storage\Tests\Unit;

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\Upload\SignedUrlUploader;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\Connection\Rest;
use Google\Cloud\Storage\CreatedHmacKey;
use Google\Cloud\Storage\HmacKey;
use Google\Cloud\Storage\Lifecycle;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Storage\StreamWrapper;
use GuzzleHttp\Psr7\Utils;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;
use Prophecy\Argument;

/**
 * @group storage
 * @group storage-client
 */
class StorageClientTest extends TestCase
{
    use ExpectException;

    const PROJECT = 'my-project';
    public $connection;

    public function set_up()
    {
        $this->connection = $this->prophesize(Rest::class);
        $this->client = TestHelpers::stub(StorageClient::class, [['projectId' => self::PROJECT]]);
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
        $this->connection->projectId()
            ->willReturn(self::PROJECT);

        $this->client->___setProperty('connection', $this->connection->reveal());
        $buckets = iterator_to_array($this->client->buckets());

        $this->assertEquals('bucket1', $buckets[0]->name());
    }

    public function testGetsBucketsWithToken()
    {
        $this->connection->listBuckets(Argument::any())
            ->willReturn([
                'nextPageToken' => 'token',
                'items' => [
                    ['name' => 'bucket1']
                ]
            ], [
                'items' => [
                    ['name' => 'bucket2']
                ]
            ]);

        $this->connection->projectId()
            ->willReturn(self::PROJECT);

        $this->client->___setProperty('connection', $this->connection->reveal());
        $bucket = iterator_to_array($this->client->buckets());

        $this->assertEquals('bucket2', $bucket[1]->name());
    }

    public function testCreatesBucket()
    {
        $this->connection->insertBucket(Argument::any())->willReturn(['name' => 'bucket']);
        $this->connection->projectId()
            ->willReturn(self::PROJECT);
        $this->client->___setProperty('connection', $this->connection->reveal());

        $this->assertInstanceOf(Bucket::class, $this->client->createBucket('bucket'));
    }

    public function testCreatesBucketWithLifecycleBuilder()
    {
        $bucket = 'bucket';
        $lifecycleArr = ['test' => 'test'];
        $lifecycle = $this->prophesize(Lifecycle::class);
        $lifecycle->toArray()
            ->willReturn($lifecycleArr);
        $this->connection->projectId()
            ->willReturn(self::PROJECT);
        $this->connection
            ->insertBucket([
                'project' => self::PROJECT,
                'lifecycle' => $lifecycleArr,
                'name' => $bucket
            ])
            ->willReturn(['name' => $bucket]);
        $this->client->___setProperty('connection', $this->connection->reveal());

        $this->assertInstanceOf(
            Bucket::class,
            $this->client->createBucket(
                $bucket,
                ['lifecycle' => $lifecycle->reveal()]
            )
        );
    }

    public function testRegisteringStreamWrapper()
    {
        $this->assertTrue($this->client->registerStreamWrapper());
        $this->assertEquals($this->client, StreamWrapper::getClient());
        $this->assertContains('gs', stream_get_wrappers());
        $this->client->unregisterStreamWrapper();
    }

    public function testSignedUrlUploader()
    {
        $uri = 'http://example.com';
        $data = Utils::streamFor('hello world');

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

    public function testGetServiceAccount()
    {
        $expectedServiceAccount = self::PROJECT . '@gs-project-accounts.iam.gserviceaccount.com';
        $this->connection->getServiceAccount([
            'projectId' => self::PROJECT,
            'userProject' => self::PROJECT
        ])->willReturn([
            'kind' => 'storage#serviceAccount',
            'email_address' => $expectedServiceAccount
        ])->shouldBeCalledTimes(1);
        $this->client->___setProperty('connection', $this->connection->reveal());

        $this->assertEquals(
            $this->client->getServiceAccount(['userProject' => self::PROJECT]),
            $expectedServiceAccount
        );
    }

    public function testHmacKeys()
    {
        $accessId = 'foo';
        $email = 'foo@bar.com';

        $this->connection->listHmacKeys([
            'projectId' => self::PROJECT,
            'serviceAccountEmail' => $email
        ])->shouldBeCalled()->willReturn([
            'items' => [
                [
                    'accessId' => $accessId
                ]
            ]
        ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $key = iterator_to_array($this->client->hmacKeys([
            'serviceAccountEmail' => $email
        ]))[0];

        $this->assertEquals($accessId, $key->accessId());
        $this->assertEquals(['accessId' => $accessId], $key->info());
    }

    public function testHmacKey()
    {
        $res = $this->client->hmacKey('foo');
        $this->assertInstanceOf(HmacKey::class, $res);
        $this->assertEquals('foo', $res->accessId());
    }

    public function testCreateHmacKey()
    {
        $email = 'foo@bar.com';
        $secret = 'foo';
        $accessId = 'bar';
        $this->connection->createHmacKey([
            'projectId' => self::PROJECT,
            'serviceAccountEmail' => $email
        ])->shouldBeCalled()->willReturn([
            'secret' => $secret,
            'metadata' => [
                'accessId' => $accessId
            ]
        ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $this->client->createHmacKey($email);
        $this->assertInstanceOf(CreatedHmacKey::class, $res);
        $this->assertEquals($secret, $res->secret());
        $this->assertEquals($accessId, $res->hmacKey()->accessId());
        $this->assertEquals(['accessId' => $accessId], $res->hmacKey()->info());
    }

    /**
     * @dataProvider requiresProjectIdMethods
     */
    public function testMethodsFailWithoutProjectId($method, array $args = [])
    {
        $this->expectException('Google\Cloud\Core\Exception\GoogleException');

        $client = TestHelpers::stub(StorageClientStub::class, [], ['projectId']);
        $client->___setProperty('projectId', null);

        call_user_func_array([$client, $method], $args);
    }

    public function requiresProjectIdMethods()
    {
        return [
            ['buckets'],
            ['createBucket', ['foo']],
            ['hmacKeys'],
            ['hmacKey', ['foo']],
            ['createHmacKey', ['foo']]
        ];
    }
}

//@codingStandardsIgnoreStart
class StorageClientStub extends StorageClient
{
    protected function onGce($httpHandler)
    {
        return false;
    }
}
//@codingStandardsIgnoreEnd
