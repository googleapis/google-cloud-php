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

use Google\Auth\SignBlobInterface;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Exception\ServerException;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Upload\ResumableUploader;
use Google\Cloud\Core\Upload\MultipartUploader;
use Google\Cloud\PubSub\Topic;
use Google\Cloud\Storage\Acl;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\Connection\ConnectionInterface;
use Google\Cloud\Storage\Connection\Rest;
use Google\Cloud\Storage\Lifecycle;
use Google\Cloud\Storage\Notification;
use Google\Cloud\Storage\SigningHelper;
use Google\Cloud\Storage\StorageObject;
use GuzzleHttp\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group storage
 */
class BucketTest extends TestCase
{
    use ExpectException;

    const TOPIC_NAME = 'my-topic';
    const BUCKET_NAME = 'my-bucket';
    const PROJECT_ID = 'my-project';
    const NOTIFICATION_ID = '1234';

    private $connection;
    private $resumableUploader;

    public function set_up()
    {
        $this->connection = $this->prophesize(Rest::class);
        $this->resumableUploader = $this->prophesize(ResumableUploader::class);
        $this->multipartUploader = $this->prophesize(MultipartUploader::class);
    }

    private function getBucket(
        array $data = [],
        $shouldExpectProjectIdCall = true,
        $expectedProjectId = self::PROJECT_ID
    ) {
        if ($shouldExpectProjectIdCall) {
            $this->connection->projectId()
                ->willReturn($expectedProjectId);
        }

        return new Bucket(
            $this->connection->reveal(),
            self::BUCKET_NAME,
            $data
        );
    }

    public function testGetsAcl()
    {
        $bucket = $this->getBucket();

        $this->assertInstanceOf(Acl::class, $bucket->acl());
    }

    public function testGetsDefaultAcl()
    {
        $bucket = $this->getBucket();

        $this->assertInstanceOf(Acl::class, $bucket->defaultAcl());
    }

    public function testDoesExistTrue()
    {
        $this->connection->getBucket(Argument::any())->willReturn(['name' => self::BUCKET_NAME]);
        $bucket = $this->getBucket();

        $this->assertTrue($bucket->exists());
    }

    public function testDoesExistFalse()
    {
        $this->connection->getBucket(Argument::any())->willThrow(new NotFoundException(null));
        $bucket = $this->getBucket();

        $this->assertFalse($bucket->exists());
    }

    public function testUploadData()
    {
        $this->resumableUploader->upload()->willReturn([
            'name' => 'data.txt',
            'generation' => 123
        ]);
        $this->connection->insertObject(Argument::any())->willReturn($this->resumableUploader);
        $bucket = $this->getBucket();

        $this->assertInstanceOf(
            StorageObject::class,
            $bucket->upload('some data to upload', ['name' => 'data.txt'])
        );
    }

    public function testUploadAsyncData()
    {
        $name = 'Foo';
        $this->connection->insertObject(Argument::any())->willReturn($this->multipartUploader);
        $this->multipartUploader
            ->uploadAsync()
            ->willReturn(
                Promise\promise_for([
                    'name' => $name,
                    'generation' => 'Bar'
                ])
            );

        $bucket = $this->getBucket();
        $promise = $bucket->uploadAsync('some data to upload', ['name' => $name]);

        $this->assertInstanceOf(
            PromiseInterface::class,
            $promise
        );
        $this->assertInstanceOf(
            StorageObject::class,
            $promise->wait()
        );
    }

    public function testUploadDataAsStringWithNoName()
    {
        $this->expectException('InvalidArgumentException');

        $bucket = $this->getBucket();

        $bucket->upload('some more data');
    }

    public function testGetResumableUploader()
    {
        $this->connection->insertObject(Argument::any())->willReturn($this->resumableUploader->reveal());
        $bucket = $this->getBucket();

        $this->assertInstanceOf(
            ResumableUploader::class,
            $bucket->getResumableUploader('some data to upload', ['name' => 'data.txt'])
        );
    }

    public function testGetResumableUploaderWithStringWithNoName()
    {
        $this->expectException('InvalidArgumentException');

        $bucket = $this->getBucket();

        $bucket->getResumableUploader('some more data');
    }

    public function testGetObject()
    {
        $bucket = $this->getBucket();

        $this->assertInstanceOf(StorageObject::class, $bucket->object('peter-venkman.jpg'));
    }

    public function testInstantiateObjectWithOptions()
    {
        $bucket = $this->getBucket();

        $object = $bucket->object('peter-venkman.jpg', [
            'generation' => '5',
            'encryptionKey' => 'abc',
            'encryptionKeySHA256' => '123'
        ]);

        $this->assertInstanceOf(StorageObject::class, $object);
    }

    public function testGetsObjectsWithoutToken()
    {
        $this->connection->listObjects(Argument::any())->willReturn([
            'items' => [
                [
                    'name' => 'file.txt',
                    'generation' => 'abc'
                ]
            ]
        ]);

        $bucket = $this->getBucket();
        $objects = iterator_to_array($bucket->objects());

        $this->assertEquals('file.txt', $objects[0]->name());
    }

    public function testGetsObjectsWithToken()
    {
        $this->connection->listObjects(Argument::any())
            ->willReturn([
                'nextPageToken' => 'token',
                'items' => [
                    [
                        'name' => 'file.txt',
                        'generation' => 'abc'
                    ]
                ]
            ], [
                'items' => [
                    [
                        'name' => 'file2.txt',
                        'generation' => 'def'
                    ]
                ]
            ]);

        $bucket = $this->getBucket();
        $objects = iterator_to_array($bucket->objects());

        $this->assertEquals('file2.txt', $objects[1]->name());
    }

    public function testDelete()
    {
        $bucket = $this->getBucket([], false);

        $this->assertNull($bucket->delete());
    }

    public function testComposeThrowsExceptionWithLessThanTwoSources()
    {
        $this->expectException('\InvalidArgumentException');

        $bucket = $this->getBucket();

        $bucket->compose(['file1.txt'], 'combined-files.txt');
    }

    public function testComposeThrowsExceptionWithUnknownContentType()
    {
        $this->expectException('\InvalidArgumentException');

        $bucket = $this->getBucket();

        $bucket->compose(['file1.txt', 'file2.txt'], 'combined-files.abc');
    }

    /**
     * @dataProvider composeProvider
     */
    public function testComposesObjects(
        $metadata,
        $objects,
        $expectedSourceObjects
    ) {
        $acl = 'private';
        $destinationObject = 'combined-files.txt';
        $this->connection->composeObject([
                'destinationBucket' => self::BUCKET_NAME,
                'destinationObject' => $destinationObject,
                'destinationPredefinedAcl' => $acl,
                'destination' => $metadata + ['contentType' => 'text/plain'],
                'sourceObjects' => $expectedSourceObjects,
            ])
            ->willReturn([
                'name' => $destinationObject,
                'generation' => 1
            ])
            ->shouldBeCalledTimes(1);
        $bucket = $this->getBucket();

        $object = $bucket->compose($objects, $destinationObject, [
            'predefinedAcl' => $acl,
            'metadata' => $metadata
        ]);

        $this->assertEquals($destinationObject, $object->name());
    }

    public function composeProvider()
    {
        $object1 = $this->prophesize(StorageObject::class);
        $object2 = $this->prophesize(StorageObject::class);
        $name1 = 'file1.txt';
        $name2 = 'file2.txt';
        $object1->name(Argument::any())->willReturn($name1);
        $object1->identity(Argument::any())->willReturn(['generation' => '1']);
        $object2->name(Argument::any())->willReturn($name2);
        $object2->identity(Argument::any())->willReturn(['generation' => '1']);

        return [
            [
                ['test' => true],
                [$name1, $name2],
                [['name' => $name1], ['name' => $name2]]
            ],
            [
                ['contentType' => 'application/json'],
                [$object1->reveal(), $object2->reveal()],
                [
                    ['name' => $name1, 'generation' => '1'],
                    ['name' => $name2, 'generation' => '1']
                ]
            ]
        ];
    }

    public function testUpdatesData()
    {
        $versioningData = [
            'versioning' => [
                'enabled' => true
            ]
        ];
        $this->connection->patchBucket(Argument::any())->willReturn(['name' => 'bucket'] + $versioningData);
        $bucket = $this->getBucket([
            'name' => 'bucket',
            'versioning' => [
                'enabled' => false
            ]
        ]);

        $bucket->update($versioningData);

        $this->assertTrue($bucket->info()['versioning']['enabled']);
    }

    public function testUpdatesDataWithLifecycleBuilder()
    {
        $lifecycleArr = ['test' => 'test'];
        $lifecycle = $this->prophesize(Lifecycle::class);
        $lifecycle->toArray()
            ->willReturn($lifecycleArr);
        $this->connection
            ->patchBucket([
                'userProject' => null,
                'bucket' => self::BUCKET_NAME,
                'lifecycle' => $lifecycleArr
            ])
            ->willReturn([
                'lifecycle' => $lifecycleArr
            ]);
        $bucket = $this->getBucket();

        $this->assertEquals(
            $lifecycleArr,
            $bucket->update(
                ['lifecycle' => $lifecycle->reveal()]
            )['lifecycle']
        );
    }

    public function testGetsInfo()
    {
        $bucketInfo = [
            'name' => 'bucket',
            'etag' => 'ABC',
            'kind' => 'storage#bucket'
        ];
        $bucket = $this->getBucket($bucketInfo);

        $this->assertEquals($bucketInfo, $bucket->info());
    }

    public function testGetsInfoWithForce()
    {
        $bucketInfo = [
            'name' => 'bucket',
            'etag' => 'ABC',
            'kind' => 'storage#bucket'
        ];
        $this->connection->getBucket(Argument::any())
            ->willReturn($bucketInfo)
            ->shouldBeCalledTimes(1);
        $bucket = $this->getBucket();

        $this->assertEquals($bucketInfo, $bucket->info());
    }

    public function testGetsName()
    {
        $bucket = $this->getBucket();

        $this->assertEquals(self::BUCKET_NAME, $bucket->name());
    }

    public function testLifecycle()
    {
        $this->assertInstanceOf(Lifecycle::class, Bucket::lifecycle());
    }

    public function testCurrentLifecycle()
    {
        $this->connection
            ->getBucket(Argument::any())
            ->willReturn(['lifecycle' => ['test' => 'test']]);

        $this->assertInstanceOf(
            Lifecycle::class,
            $this->getBucket()->currentLifecycle()
        );
    }

    public function testCurrentLifecycleWithCachedData()
    {
        $this->connection
            ->getBucket(Argument::any())
            ->shouldNotBeCalled();

        $this->assertInstanceOf(
            Lifecycle::class,
            $this->getBucket([
                'lifecycle' => ['test' => ['test']]
            ])->currentLifecycle()
        );
    }

    public function testIsWritable()
    {
        $this->connection->insertObject(Argument::any())->willReturn($this->resumableUploader);
        $this->resumableUploader->getResumeUri()->willReturn('http://some-uri/');
        $bucket = $this->getBucket();
        $this->assertTrue($bucket->isWritable());
    }

    public function testIsWritableAccessDenied()
    {
        $this->connection->insertObject(Argument::any())->willReturn($this->resumableUploader);
        $this->resumableUploader->getResumeUri()->willThrow(new ServiceException('access denied', 403));
        $bucket = $this->getBucket();
        $this->assertFalse($bucket->isWritable());
    }

    public function testIsWritableServerException()
    {
        $this->expectException('Google\Cloud\Core\Exception\ServerException');

        $this->connection->insertObject(Argument::any())->willReturn($this->resumableUploader);
        $this->resumableUploader->getResumeUri()->willThrow(new ServerException('maintainence'));
        $bucket = $this->getBucket();
        $bucket->isWritable(); // raises exception
    }

    public function testIam()
    {
        $bucketInfo = [
            'name' => 'bucket',
            'etag' => 'ABC',
            'kind' => 'storage#bucket'
        ];
        $bucket = $this->getBucket($bucketInfo);

        $this->assertInstanceOf(Iam::class, $bucket->iam());
    }

    public function testRequesterPays()
    {
        $this->connection->getBucket(Argument::withEntry('userProject', 'foo'))
            ->willReturn([]);

        $bucket = $this->getBucket(['requesterProjectId' => 'foo']);

        $bucket->reload();
    }

    /**
     * @dataProvider topicDataProvider
     */
    public function testCreatesNotification($topic, $expectedTopic)
    {
        $this->connection
            ->insertNotification([
                'userProject' => null,
                'bucket' => self::BUCKET_NAME,
                'topic' => sprintf('//pubsub.googleapis.com/projects/%s/topics/%s', self::PROJECT_ID, $expectedTopic),
                'payload_format' => 'JSON_API_V1'
            ])
            ->willReturn(['id' => self::NOTIFICATION_ID]);
        $bucket = $this->getBucket();
        $notification = $bucket->createNotification($topic);

        $this->assertInstanceOf(Notification::class, $notification);
        $this->assertEquals(self::NOTIFICATION_ID, $notification->id());
    }

    public function testCreatesNotificationThrowsExceptionWithInvalidTopicType()
    {
        $this->expectException('\InvalidArgumentException');
        $this->expectExceptionMessage('$topic may only be a string or instance of Google\Cloud\PubSub\Topic');

        $bucket = $this->getBucket();
        $bucket->createNotification(9124);
    }

    public function testCreatesNotificationThrowsExceptionWithoutProjectId()
    {
        $this->expectException('\Google\Cloud\Core\Exception\GoogleException');

        $bucket = $this->getBucket([], true, null);
        $bucket->createNotification(self::TOPIC_NAME);
    }

    public function topicDataProvider()
    {
        $topicName = self::TOPIC_NAME;
        $fullTopicName = sprintf('projects/%s/topics/%s', self::PROJECT_ID, $topicName);
        $topic = $this->prophesize(Topic::class);
        $topic->name()
            ->willReturn($fullTopicName);

        return [
            [$topicName, $topicName],
            [$fullTopicName, $topicName],
            [$topic->reveal(), $topicName]
        ];
    }

    public function testGetNotification()
    {
        $bucket = $this->getBucket();
        $notification = $bucket->notification(self::NOTIFICATION_ID);

        $this->assertInstanceOf(Notification::class, $notification);
        $this->assertEquals(self::NOTIFICATION_ID, $notification->id());
    }

    public function testGetNotifications()
    {
        $notificationID = '1234';
        $this->connection->listNotifications(Argument::any())->willReturn([
            'items' => [
                ['id' => $notificationID]
            ]
        ]);

        $bucket = $this->getBucket();
        $notifications = iterator_to_array($bucket->notifications());

        $this->assertInstanceOf(Notification::class, $notifications[0]);
        $this->assertEquals($notificationID, $notifications[0]->id());
    }

    public function testLockRetentionPolicyThrowsExceptionWithoutMetageneration()
    {
        $this->expectException('BadMethodCallException');

        $this->getBucket()->lockRetentionPolicy();
    }

    /**
     * @dataProvider metagenerationProvider
     */
    public function testLockRetentionPolicy($metageneration)
    {
        $expectedLockArgs = [
            'ifMetagenerationMatch' => 1,
            'bucket' => self::BUCKET_NAME,
            'userProject' => null
        ];
        $expectedReturn = ['metageneration' => 2];
        $this->connection->getBucket(Argument::any())
            ->willReturn(['metageneration' => 1]);
        $this->connection->lockRetentionPolicy($expectedLockArgs)
            ->shouldBeCalledTimes(1)
            ->willReturn($expectedReturn);
        $bucket = $this->getBucket();
        $bucket->reload();

        $this->assertEquals(
            $expectedReturn,
            $bucket->lockRetentionPolicy([
                'ifMetagenerationMatch' => $metageneration
            ])
        );
    }

    public function metagenerationProvider()
    {
        return [
            [1],
            [null]
        ];
    }

    /**
     * @group storage-signed-url
     * @dataProvider urlVersion
     */
    public function testSignedUrlVersions($version, $method)
    {
        $expectedResource = sprintf('/%s', self::BUCKET_NAME);
        $expectedExpiration = time() + 10;
        $return = 'signedUrl';

        $bucket = $this->getBucketForSigning();

        $signingHelper = $this->prophesize(SigningHelper::class);

        $signingHelper->sign(
            Argument::type(ConnectionInterface::class),
            $expectedExpiration,
            $expectedResource,
            null,
            $version ? Argument::withEntry('version', $version) : Argument::type('array')
        )->shouldBeCalled()->willReturn($return);

        $opts = [
            'helper' => $signingHelper->reveal()
        ];
        if ($version) {
            // test defaults to v2.
            $opts['version'] = $version;
        }

        $res = $bucket->signedUrl($expectedExpiration, $opts);

        $this->assertEquals($return, $res);
    }

    public function urlVersion()
    {
        return [
            [null, SigningHelper::DEFAULT_URL_SIGNING_VERSION . 'Sign'],
            ['v2', 'v2Sign'],
            ['v4', 'v4Sign']
        ];
    }

    private function getBucketForSigning(
        SignBlobInterface $credentials = null,
        $scopes = ''
    ) {
        if ($credentials === null) {
            $credentials = $this->prophesize(SignBlobInterface::class);
            $credentials = $credentials->reveal();
        }

        $rw = $this->prophesize(RequestWrapper::class);
        $rw->scopes()->willReturn(is_array($scopes) ? $scopes : [$scopes]);
        $rw->getCredentialsFetcher()->willReturn($credentials);

        $this->connection->requestWrapper()->willReturn($rw->reveal());
        $this->connection->projectId()->willReturn(self::PROJECT_ID);

        return TestHelpers::stub(Bucket::class, [
            $this->connection->reveal(),
            self::BUCKET_NAME,
        ], ['connection']);
    }
}
