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

use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\Testing\KeyPairGenerateTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Upload\MultipartUploader;
use Google\Cloud\Core\Upload\ResumableUploader;
use Google\Cloud\Core\Upload\StreamableUploader;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Topic;
use Google\Cloud\Storage\Acl;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\Connection\Rest;
use Google\Cloud\Storage\Notification;
use Google\Cloud\Storage\ObjectIterator;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Storage\StorageObject;
use GuzzleHttp\Promise;
use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\Polyfills\AssertStringContains;

/**
 * @group storage
 */
class BucketTest extends SnippetTestCase
{
    use AssertStringContains;
    use KeyPairGenerateTrait;

    const BUCKET = 'my-bucket';
    const PROJECT_ID = 'my-project';
    const NOTIFICATION_ID = '1234';

    private $connection;
    private $bucket;
    private static $expectedLifecycleData = [
        'userProject' => null,
        'bucket' => self::BUCKET,
        'lifecycle' => [
            'rule' => [
                [
                    'action' => [
                        'type' => 'Delete'
                    ],
                    'condition' => [
                        'age' => 50,
                        'isLive' => true
                    ]
                ]
            ]
        ]
    ];

    public function set_up()
    {
        $this->connection = $this->prophesize(Rest::class);
        $this->connection->projectId()
            ->willReturn(self::PROJECT_ID);
        $this->bucket = TestHelpers::stub(Bucket::class, [
            $this->connection->reveal(),
            self::BUCKET,
            []
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Bucket::class);
        $res = $snippet->invoke('bucket');

        $this->assertInstanceOf(Bucket::class, $res->returnVal());
    }

    public function testAcl()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'acl');
        $snippet->addLocal('bucket', $this->bucket);

        $res = $snippet->invoke('acl');

        $this->assertInstanceOf(Acl::class, $res->returnVal());
    }

    public function testDefaultAcl()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'defaultAcl');
        $snippet->addLocal('bucket', $this->bucket);

        $res = $snippet->invoke('acl');

        $this->assertInstanceOf(Acl::class, $res->returnVal());
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'exists');
        $snippet->addLocal('bucket', $this->bucket);

        $this->connection->getBucket(Argument::any())
            ->shouldBeCalled();

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Bucket exists!', $res->output());
    }

    public function testUpload()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'upload');
        $snippet->addLocal('bucket', $this->bucket);
        $snippet->replace("__DIR__ . '/image.jpg'", '"php://temp"');

        $uploader = $this->prophesize(MultipartUploader::class);
        $uploader->upload()
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'Foo',
                'generation' => 'Bar'
            ]);

        $this->connection->insertObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn($uploader->reveal());

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('object');
        $this->assertInstanceOf(StorageObject::class, $res->returnVal());
    }

    /**
     * @todo this needs more attention paid to testing the resume config.
     */
    public function testUploadResumableUploader()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'upload', 1);
        $snippet->addLocal('bucket', $this->bucket);
        $snippet->replace("__DIR__ . '/image.jpg'", '"php://temp"');

        $uploader = $this->prophesize(ResumableUploader::class);
        $uploader->upload()
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'Foo',
                'generation' => 'Bar'
            ]);

        $this->connection->insertObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn($uploader->reveal());

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('object');
        $this->assertInstanceOf(StorageObject::class, $res->returnVal());
    }

    /**
     * @todo this needs more attention paid to testing the encryption config.
     */
    public function testUploadEncryption()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'upload', 2);
        $snippet->addLocal('bucket', $this->bucket);
        $snippet->replace("__DIR__ . '/image.jpg'", '"php://temp"');

        $uploader = $this->prophesize(MultipartUploader::class);
        $uploader->upload()
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'Foo',
                'generation' => 'Bar'
            ]);

        $this->connection->insertObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn($uploader->reveal());

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('object');
        $this->assertInstanceOf(StorageObject::class, $res->returnVal());
    }

    public function testUploadKms()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'upload', 3);
        $snippet->addLocal('bucket', $this->bucket);
        $fh = fopen('php://temp', 'r');
        $snippet->addLocal('fh', $fh);
        $snippet->replace("fopen(__DIR__ . '/image.jpg', 'r')", '$fh');

        $uploader = $this->prophesize(MultipartUploader::class);
        $uploader->upload()
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'Foo',
                'generation' => 'Bar'
            ]);

        $this->connection->insertObject([
                'metadata' => [
                    'kmsKeyName' => 'projects/my-project/locations/kr-location/keyRings/my-kr/cryptoKeys/my-key'
                ],
                'bucket' => self::BUCKET,
                'userProject' => null,
                'data' => $fh
            ])
            ->shouldBeCalled()
            ->willReturn($uploader->reveal());

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('object');
        $this->assertInstanceOf(StorageObject::class, $res->returnVal());
    }

    public function testUploadAsync()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'uploadAsync');
        $snippet->addLocal('bucket', $this->bucket);

        $uploader = $this->prophesize(MultipartUploader::class);
        $uploader->uploadAsync()
            ->shouldBeCalled()
            ->willReturn(Promise\promise_for([
                'name' => 'Foo',
                'generation' => 'Bar'
            ]));

        $this->connection->insertObject([
                'bucket' => self::BUCKET,
                'userProject' => null,
                'data' => 'Lorem Ipsum',
                'name' => 'keyToData',
                'resumable' => false
            ])
            ->shouldBeCalled()
            ->willReturn($uploader->reveal());

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('object');
        $this->assertInstanceOf(StorageObject::class, $res->returnVal());
    }

    public function testUploadAsyncWithMultipleObjects()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'uploadAsync', 1);
        $snippet->addLocal('bucket', $this->bucket);
        $snippet->addUse(StorageObject::class);

        $uploader = $this->prophesize(MultipartUploader::class);
        $uploader->uploadAsync()
            ->shouldBeCalledTimes(3)
            ->willReturn(Promise\promise_for([
                'name' => 'Foo',
                'generation' => 'Bar'
            ]));
        $insertData = [
            'bucket' => self::BUCKET,
            'userProject' => null,
            'resumable' => false
        ];
        $this->connection->insertObject(
            $insertData + ['name' => 'key1', 'data' => 'Lorem']
        )
            ->shouldBeCalled()
            ->willReturn($uploader->reveal());
        $this->connection->insertObject(
            $insertData + ['name' => 'key2', 'data' => 'Ipsum']
        )
            ->shouldBeCalled()
            ->willReturn($uploader->reveal());
        $this->connection->insertObject(
            $insertData + ['name' => 'key3', 'data' => 'Gypsum']
        )
            ->shouldBeCalled()
            ->willReturn($uploader->reveal());

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Foo', explode("\n", $res->output())[0]);
        $this->assertEquals('Foo', explode("\n", $res->output())[1]);
        $this->assertEquals('Foo', explode("\n", $res->output())[2]);
    }

    public function testGetResumableUploader()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'getResumableUploader');
        $snippet->addLocal('bucket', $this->bucket);
        $snippet->addUse(GoogleException::class);
        $snippet->replace("__DIR__ . '/image.jpg'", '"php://temp"');

        $uploader = $this->prophesize(ResumableUploader::class);
        $uploader->upload()
            ->shouldBeCalledTimes(1)
            ->willThrow(new GoogleException('test'));

        $uri = 'http://test.com/path';
        $uploader->resume($uri)
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'Foo',
                'generation' => 'Bar'
            ]);

        $uploader->getResumeUri()
            ->shouldBeCalled()
            ->willReturn($uri);

        $this->connection->insertObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn($uploader->reveal());

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('object');
    }

    public function testGetStreamableUploader()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'getStreamableUploader');
        $snippet->addLocal('bucket', $this->bucket);
        $snippet->addUse(GoogleException::class);
        $snippet->replace("data.txt", 'php://temp');

        $uploader = $this->prophesize(StreamableUploader::class);
        $uploader->upload()
            ->shouldBeCalledTimes(1);

        $this->connection->insertObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn($uploader->reveal());

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
    }

    public function testObject()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'object');
        $snippet->addLocal('bucket', $this->bucket);

        $res = $snippet->invoke('object');
        $this->assertInstanceOf(StorageObject::class, $res->returnVal());
    }

    public function testObjects()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'objects');
        $snippet->addLocal('bucket', $this->bucket);

        $this->connection->listObjects(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'items' => [
                    [
                        'name' => 'object 1',
                        'generation' => 'abc'
                    ],
                    [
                        'name' => 'object 2',
                        'generation' => 'def'
                    ]
                ]
            ]);

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('objects');
        $this->assertInstanceOf(ObjectIterator::class, $res->returnVal());
        $this->assertEquals('object 1', explode("\n", $res->output())[0]);
        $this->assertEquals('object 2', explode("\n", $res->output())[1]);
    }

    public function testCreateNotificationBasicTopic()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'createNotification');
        $snippet->replace('$pubSub = new PubSubClient();', '');
        $serviceAccountEmail = 'abc@gs-project-accounts.iam.gserviceaccount.com';
        $storage = $this->prophesize(StorageClient::class);
        $storage->getServiceAccount()
            ->willReturn($serviceAccountEmail)
            ->shouldBeCalledTimes(1);
        $iam = $this->prophesize(Iam::class);
        $iam->policy()
            ->willReturn([
                'bindings' => [],
                'etag' => 'abc'
            ])
            ->shouldBeCalledTimes(1);
        $iam->setPolicy([
            'bindings' => [
                [
                    'role' => 'roles/pubsub.publisher',
                    'members' => [
                        "serviceAccount:$serviceAccountEmail"
                    ]
                ]
            ],
            'etag' => 'abc'
        ])
            ->shouldBeCalledTimes(1);
        $topic = $this->prophesize(Topic::class);
        $topic->iam()
            ->willReturn($iam->reveal());
        $pubSub = $this->prophesize(PubSubClient::class);
        $pubSub->topic('my-topic')
            ->willReturn($topic->reveal());
        $snippet->addLocal('pubSub', $pubSub->reveal());
        $snippet->addLocal('storage', $storage->reveal());
        $snippet->addLocal('bucket', $this->bucket);

        $this->assertSnippetBuildsNotification($snippet, Argument::any());
    }

    public function testCreateNotificationFullyQualifiedTopic()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'createNotification', 1);
        $snippet->addLocal('bucket', $this->bucket);

        $this->assertSnippetBuildsNotification($snippet, Argument::any());
    }

    public function testCreateNotificationTopicClass()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'createNotification', 2);
        $snippet->replace('$pubSub = new PubSubClient();', '');
        $pubSub = $this->prophesize(PubSubClient::class);
        $pubSub->topic(Argument::any())
            ->willReturn(
                $this->prophesize(Topic::class)->reveal()
            );
        $snippet->addLocal('pubSub', $pubSub->reveal());
        $snippet->addLocal('bucket', $this->bucket);

        $this->assertSnippetBuildsNotification($snippet, Argument::any());
    }

    public function testCreateNotificationWithEventTypes()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'createNotification', 3);
        $snippet->addLocal('bucket', $this->bucket);

        $this->assertSnippetBuildsNotification(
            $snippet,
            Argument::withEntry('event_types', [
                'OBJECT_DELETE',
                'OBJECT_METADATA_UPDATE'
            ])
        );
    }

    public function testNotification()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'notification');
        $snippet->addLocal('bucket', $this->bucket);
        $res = $snippet->invoke('notification');

        $this->assertInstanceOf(Notification::class, $res->returnVal());
    }

    public function testNotifications()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'notifications');
        $snippet->addLocal('bucket', $this->bucket);
        $this->connection->listNotifications(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'items' => [
                    ['id' => '123'],
                    ['id' => '321']
                ]
            ]);
        $this->bucket->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('notifications');

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertEquals('123', explode("\n", $res->output())[0]);
        $this->assertEquals('321', explode("\n", $res->output())[1]);
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'delete');
        $snippet->addLocal('bucket', $this->bucket);

        $this->connection->deleteBucket(Argument::any())
            ->shouldBeCalled();

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'update');
        $snippet->addLocal('bucket', $this->bucket);

        $this->connection->patchBucket(Argument::that(function ($arg) {
            if ($arg['logging']['logBucket'] !== 'myBucket') {
                return false;
            }

            return $arg['logging']['logObjectPrefix'] === 'prefix';
        }))->shouldBeCalled()->willReturn('foo');

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
    }

    public function testCompose()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'compose');
        $snippet->addLocal('bucket', $this->bucket);

        $this->connection->composeObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'combined-logs.txt',
                'generation' => 'foo'
            ]);

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('singleObject');
        $this->assertInstanceOf(StorageObject::class, $res->returnVal());
        $this->assertEquals('combined-logs.txt', $res->returnVal()->name());
    }

    public function testComposeWithObjects()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'compose', 1);
        $snippet->addLocal('bucket', $this->bucket);

        $this->connection->composeObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'combined-logs.txt',
                'generation' => 'foo'
            ]);

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('singleObject');
        $this->assertInstanceOf(StorageObject::class, $res->returnVal());
        $this->assertEquals('combined-logs.txt', $res->returnVal()->name());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'info');
        $snippet->addLocal('bucket', $this->bucket);

        $loc = 'inside your house';
        $this->connection->getBucket(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'location' => $loc
            ]);

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals($loc, $res->output());
    }

    public function testReload()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'reload');
        $snippet->addLocal('bucket', $this->bucket);

        $loc = 'inside your house';
        $this->connection->getBucket(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'location' => $loc
            ]);

        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals($loc, $res->output());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'name');
        $snippet->addLocal('bucket', $this->bucket);

        $res = $snippet->invoke();
        $this->assertEquals(self::BUCKET, $res->output());
    }

    public function testLifecycle()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'lifecycle');
        $snippet->addLocal('bucket', $this->bucket);
        $this->connection->patchBucket(self::$expectedLifecycleData)
            ->shouldBeCalled();
        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
    }

    public function testCurrentLifecycle()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'currentLifecycle');
        $snippet->addLocal('bucket', $this->bucket);
        $this->connection->getBucket(Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);
        $this->connection->patchBucket(self::$expectedLifecycleData)
            ->shouldBeCalled();
        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
    }

    public function testCurrentLifecycleIterate()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'currentLifecycle', 1);
        $snippet->addLocal('bucket', $this->bucket);
        $this->connection->getBucket(Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::$expectedLifecycleData);
        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();

        $this->assertEquals(
            print_r(self::$expectedLifecycleData['lifecycle']['rule'][0], true),
            $res->output()
        );
    }

    public function testIam()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'iam');
        $snippet->addLocal('bucket', $this->bucket);
        $this->connection->getBucketIamPolicy(Argument::withEntry('optionsRequestedPolicyVersion', 3))
            ->shouldBeCalled();

        $this->bucket->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('iam');
        $this->assertInstanceOf(Iam::class, $res->returnVal());
    }

    public function testLockRetentionPolicy()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'lockRetentionPolicy');
        $snippet->addLocal('bucket', $this->bucket);
        $effectiveTime = '2000-00-00T00:00:00.00Z';
        $isLocked = true;
        $patchArgs = [
            'retentionPolicy' => [
                'retentionPeriod' => 604800
            ],
            'bucket' => 'my-bucket',
            'userProject' => null
        ];
        $lockArgs = [
            'ifMetagenerationMatch' => 1,
            'bucket' => 'my-bucket',
            'userProject' => null
        ];
        $this->connection->patchBucket($patchArgs)
            ->shouldBeCalled()
            ->willReturn([
                'metageneration' => 1
            ]);
        $this->connection->lockRetentionPolicy($lockArgs)
            ->shouldBeCalled()
            ->willReturn([
                'retentionPolicy' => [
                    'effectiveTime' => $effectiveTime,
                    'isLocked' => $isLocked
                ],
                'metageneration' => 2
            ]);
        $this->bucket->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals($effectiveTime . PHP_EOL . $isLocked, $res->output());
    }

    public function testSignedUrl()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'signedUrl');
        $snippet->addLocal('bucket', $this->bucket);

        list($pkey, $pub) = $this->getKeyPair();
        $kf = [
            'private_key' => $pkey,
            'client_email' => 'test@example.com'
        ];

        $rw = $this->prophesize(RequestWrapper::class);
        $rw->keyFile()->willReturn($kf);

        $creds = $this->prophesize(ServiceAccountCredentials::class);
        $creds->signBlob(Argument::any(), Argument::any())->willReturn('foo');
        $creds->getClientName()->willReturn($kf['client_email']);
        $rw->getCredentialsFetcher()->willReturn($creds->reveal());

        $conn = $this->prophesize(Rest::class);
        $conn->requestWrapper()->willReturn($rw->reveal());

        $this->bucket->___setProperty('connection', $conn->reveal());

        $res = $snippet->invoke('url');
        $this->assertStringContainsString('https://storage.googleapis.com/my-bucket', $res->returnVal());
        $this->assertStringContainsString('Expires=', $res->returnVal());
        $this->assertStringContainsString('Signature=', $res->returnVal());
    }

    public function testSignedUrlV4()
    {
        $snippet = $this->snippetFromMethod(Bucket::class, 'signedUrl', 1);
        $snippet->addLocal('bucket', $this->bucket);

        list($pkey, $pub) = $this->getKeyPair();
        $kf = [
            'private_key' => $pkey,
            'client_email' => 'test@example.com'
        ];

        $rw = $this->prophesize(RequestWrapper::class);
        $rw->keyFile()->willReturn($kf);

        $creds = $this->prophesize(ServiceAccountCredentials::class);
        $creds->signBlob(Argument::any(), Argument::any())->willReturn('foo');
        $creds->getClientName()->willReturn($kf['client_email']);
        $rw->getCredentialsFetcher()->willReturn($creds->reveal());

        $conn = $this->prophesize(Rest::class);
        $conn->requestWrapper()->willReturn($rw->reveal());

        $this->bucket->___setProperty('connection', $conn->reveal());

        $res = $snippet->invoke('url');
        $this->assertStringContainsString('https://storage.googleapis.com/my-bucket', $res->returnVal());
        $this->assertStringContainsString('X-Goog-Signature=', $res->returnVal());
    }

    public function testGenerateSignedPostPolicyV4()
    {
        $objectName = 'foo.txt';

        $snippet = $this->snippetFromMethod(Bucket::class, 'generateSignedPostPolicyV4');
        $snippet->addLocal('bucket', $this->bucket);
        $snippet->addLocal('objectName', $objectName);

        list($pkey, $pub) = $this->getKeyPair();
        $kf = [
            'private_key' => $pkey,
            'client_email' => 'test@example.com'
        ];

        $rw = $this->prophesize(RequestWrapper::class);
        $rw->keyFile()->willReturn($kf);

        $creds = $this->prophesize(ServiceAccountCredentials::class);
        $creds->signBlob(Argument::any(), Argument::any())->willReturn('foo');
        $creds->getClientName()->willReturn($kf['client_email']);
        $rw->getCredentialsFetcher()->willReturn($creds->reveal());

        $conn = $this->prophesize(Rest::class);
        $conn->requestWrapper()->willReturn($rw->reveal());

        $this->bucket->___setProperty('connection', $conn->reveal());

        $res = $snippet->invoke('policy');

        $this->assertStringContainsString('https://storage.googleapis.com/my-bucket', $res->returnVal()['url']);
        $this->assertEquals($objectName, $res->returnVal()['fields']['key']);
    }

    private function assertSnippetBuildsNotification($snippet, $expectedArgs)
    {
        $this->connection->insertNotification($expectedArgs)
            ->willReturn(['id' => self::NOTIFICATION_ID])
            ->shouldBeCalledTimes(1);
        $this->bucket->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('notification');

        $this->assertInstanceOf(Notification::class, $res->returnVal());
    }
}
