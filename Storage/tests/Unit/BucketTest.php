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

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Exception\ServerException;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\Upload\ResumableUploader;
use Google\Cloud\PubSub\Topic;
use Google\Cloud\Storage\Acl;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\Connection\Rest;
use Google\Cloud\Storage\Notification;
use Google\Cloud\Storage\StorageObject;
use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

/**
 * @group storage
 */
class BucketTest extends TestCase
{
    const TOPIC_NAME = 'my-topic';
    const BUCKET_NAME = 'my-bucket';
    const PROJECT_ID = 'my-project';
    const NOTIFICATION_ID = '1234';

    private $connection;
    private $resumableUploader;

    public function setUp()
    {
        $this->connection = $this->prophesize(Rest::class);
        $this->resumableUploader = $this->prophesize(ResumableUploader::class);
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

    /**
     * @expectedException InvalidArgumentException
     */
    public function testUploadDataAsStringWithNoName()
    {
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

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetResumableUploaderWithStringWithNoName()
    {
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
        $this->connection->listObjects(Argument::any())->willReturn(
            [
                'nextPageToken' => 'token',
                'items' => [
                    [
                        'name' => 'file.txt',
                        'generation' => 'abc'
                    ]
                ]
            ],
                [
                'items' => [
                    [
                        'name' => 'file2.txt',
                        'generation' => 'def'
                    ]
                ]
            ]
        );

        $bucket = $this->getBucket();
        $objects = iterator_to_array($bucket->objects());

        $this->assertEquals('file2.txt', $objects[1]->name());
    }

    public function testDelete()
    {
        $bucket = $this->getBucket([], false);

        $this->assertNull($bucket->delete());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testComposeThrowsExceptionWithLessThanTwoSources()
    {
        $bucket = $this->getBucket();

        $bucket->compose(['file1.txt'], 'combined-files.txt');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testComposeThrowsExceptionWithUnknownContentType()
    {
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

    /**
     * @expectedException Google\Cloud\Core\Exception\ServerException
     */
    public function testIsWritableServerException()
    {
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

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $topic may only be a string or instance of Google\Cloud\PubSub\Topic
     */
    public function testCreatesNotificationThrowsExceptionWithInvalidTopicType()
    {
        $bucket = $this->getBucket();
        $bucket->createNotification(9124);
    }

    /**
     * @expectedException \Google\Cloud\Core\Exception\GoogleException
     */
    public function testCreatesNotificationThrowsExceptionWithoutProjectId()
    {
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
}
