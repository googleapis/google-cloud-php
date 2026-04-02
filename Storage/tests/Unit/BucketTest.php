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
use Google\Cloud\Core\Exception\GoogleException;
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
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\PromiseInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group storage
 */
class BucketTest extends TestCase
{
    use ProphecyTrait;

    const TOPIC_NAME = 'my-topic';
    const BUCKET_NAME = 'my-bucket';
    const PROJECT_ID = 'my-project';
    const NOTIFICATION_ID = '1234';
    const FILE_NAME_TEST = 'test.txt';
    private $connection;
    private $resumableUploader;
    private $multipartUploader;

    public function setUp(): void
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
                Create::promiseFor([
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
        $this->expectException(InvalidArgumentException::class);

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
        $this->expectException(InvalidArgumentException::class);

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

    public function testGetsObjectsWithManagedFolders()
    {
        $this->connection->listObjects(Argument::any())
            ->willReturn([
                'kind' => 'storage#objects',
                'prefixes' => ['managedFolders/', 'mf/'],
                'items' => [[
                    'name' => 'mf/file.txt',
                    'generation' => 'abc',
                    'kind' => 'storage#object'
                ]]
            ]);

        $bucket = $this->getBucket();
        $objects = iterator_to_array($bucket->objects([
            'delimiter' => '/',
            'includeFoldersAsPrefixes' => true
        ]));

        $this->assertEquals('mf/file.txt', $objects[0]->name());
    }

    public function testDelete()
    {
        $bucket = $this->getBucket([], false);

        $this->assertNull($bucket->delete());
    }

    public function testRestore()
    {
        $this->connection->restoreObject(Argument::any())
            ->willReturn([
                'name' => 'file.txt',
                'generation' => 'abc'
            ]);

        $bucket = $this->getBucket();
        $restoredObject = $bucket->restore('file.txt', 'abc');

        $this->assertInstanceOf(StorageObject::class, $restoredObject);
        $this->assertEquals('file.txt', $restoredObject->name());
        $this->assertEquals('abc', $restoredObject->info()['generation']);
    }

    public function testRestoreWithRestoreToken()
    {
        $this->connection->restoreObject(Argument::any())
            ->willReturn([
                'name' => 'file.txt',
                'generation' => 'abc'
            ]);

        $bucket = $this->getBucket();
        $restoredObject = $bucket->restore('file.txt', 'abc', ['restoreToken' => 'def']);

        $this->assertInstanceOf(StorageObject::class, $restoredObject);
        $this->assertEquals('file.txt', $restoredObject->name());
        $this->assertEquals('abc', $restoredObject->info()['generation']);
    }

    public function testComposeThrowsExceptionWithLessThanTwoSources()
    {
        $this->expectException(InvalidArgumentException::class);

        $bucket = $this->getBucket();

        $bucket->compose(['file1.txt'], 'combined-files.txt');
    }

    public function testComposeThrowsExceptionWithUnknownContentType()
    {
        $this->expectException(InvalidArgumentException::class);

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

    /**
     * @dataProvider terminalStorageClass
     */
    public function testUpdateAutoclassConfig($terminalStorageClass)
    {
        $autoclassConfig = [
            'autoclass' => [
                'enabled' => true,
                'terminalStorageClass' => $terminalStorageClass
            ],
        ];
        $expectedInfo = array_merge_recursive($autoclassConfig, ['autoclass' => [
            'toggleTime' => '2022-09-18T01:01:01.045123456Z',
            'terminalStorageClassUpdateTime' => '2022-09-18T01:01:01.045123456Z'
        ]]);
        $this->connection->patchBucket(Argument::any())->willReturn(
            ['name' => 'bucket'] +
            $expectedInfo
        );
        $bucket = $this->getBucket([
            'name' => 'bucket',
        ] + $autoclassConfig);

        $bucket->update($autoclassConfig);

        $this->assertArrayHasKey('autoclass', $bucket->info());
        $autoclassInfo = $bucket->info()['autoclass'];
        $this->assertTrue($autoclassInfo['enabled']);
        $this->assertEquals($terminalStorageClass, $autoclassInfo['terminalStorageClass']);
        $this->assertArrayHasKey('toggleTime', $autoclassInfo);
        $this->assertArrayHasKey('terminalStorageClassUpdateTime', $autoclassInfo);
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
        $this->expectException(ServerException::class);

        $this->connection->insertObject(Argument::any())->willReturn($this->resumableUploader);
        $this->resumableUploader->getResumeUri()->willThrow(new ServerException('maintainence'));
        $bucket = $this->getBucket();
        $bucket->isWritable(); // raises exception
    }

    public function testCreateObjectWithContexts()
    {
        $contexts = [
            'custom' => [
                'test-key' => ['value' => 'test-value']
            ]
        ];
        $this->resumableUploader->upload()->willReturn([
            'name' => 'data.txt',
            'generation' => 123,
            'contexts' => $contexts
        ]);

        $this->connection->insertObject(Argument::any())
            ->willReturn($this->resumableUploader->reveal());
        $object = $this->getBucket()->upload('upload', [
            'name' => 'data.txt',
            'contexts' => $contexts
        ]);
        $this->assertInstanceOf(StorageObject::class, $object);
        $this->assertEquals($contexts, $object->info()['contexts']);
    }

    /**
    * @dataProvider invalidContextsProvider
    */
    public function testCreateObjectWithInvalidContexts($invalidContexts, $expectedMessage)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedMessage);

        $this->getBucket()->upload('data', [
            'name' => self::FILE_NAME_TEST,
            'contexts' => $invalidContexts
        ]);
    }

    public function testUpdateReplacesAllMetadataIncludingContexts()
    {
        $objectName = 'replace-test.txt';
        $object = new StorageObject($this->connection->reveal(), $objectName, self::BUCKET_NAME);
        $newContexts = ['custom' => ['new-key' => ['value' => 'new-val']]];

        $this->connection->patchObject(Argument::withEntry('contexts', $newContexts))
            ->shouldBeCalled()
            ->willReturn([
                'name' => $objectName,
                'contexts' => $newContexts,
            ]);

        $result = $object->update(['contexts' => $newContexts]);
        $this->assertEquals('new-val', $result['contexts']['custom']['new-key']['value']);
        $this->assertArrayNotHasKey('contentType', $result);
    }

    /**
    *  @dataProvider objectContextUpdateDataProvider
    */
    public function testUpdateAndRemoveObjectContexts($inputContexts, $expectedInApi)
    {
        $this->connection->patchObject(Argument::that(function ($args) use ($expectedInApi) {
            if ($expectedInApi === null) {
                return !isset($args['contexts']) || $args['contexts'] === null;
            }
            return isset($args['contexts']) && $args['contexts'] === $expectedInApi;
        }))->shouldBeCalled()->willReturn([
            'name' => self::FILE_NAME_TEST,
            'contexts' => $expectedInApi
        ]);

        $object = new StorageObject(
            $this->connection->reveal(),
            self::FILE_NAME_TEST,
            '',
            1,
            ['bucket' => self::BUCKET_NAME]
        );
        $object->update(['contexts' => $inputContexts]);
        $info = $object->info();
        if ($expectedInApi === null) {
            $hasContexts = isset($info['contexts']) && $info['contexts'] !== null;
            $this->assertFalse($hasContexts);
        } else {
            $this->assertArrayHasKey('contexts', $info);
            $this->assertEquals($expectedInApi, $info['contexts']);
        }
    }

    public function objectContextUpdateDataProvider()
    {
        $validContexts = ['contexts' => ['custom' => ['key-1' => ['value' => 'val-1']]]];
        return [
            'Valid Update' => [$validContexts['contexts'], $validContexts['contexts']],
            'Empty Array'  => [[], []],
            'Null Case'      => [null, null]
        ];
    }

    public function testClearAllObjectContexts()
    {
        $objectName = 'clear-test.txt';
        $object = new StorageObject(
            $this->connection->reveal(),
            $objectName,
            self::BUCKET_NAME
        );

        $patchData = ['contexts' => []];
        $this->connection->patchObject(Argument::withEntry('contexts', []))
            ->shouldBeCalled()
            ->willReturn([
                'name' => $objectName,
                'bucket' => self::BUCKET_NAME,
                'contexts' => []
            ]);

        $result = $object->update($patchData);
        $this->assertIsArray($result['contexts']);
        $this->assertEmpty($result['contexts']);
    }

    /**
    * @dataProvider invalidContextsProvider
    */
    public function testRewriteWithInvalidContexts($invalidContexts, $expectedMessage)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedMessage);

        $sourceObject = new StorageObject($this->connection->reveal(), 'source.txt', self::BUCKET_NAME);
        $sourceObject->rewrite('dest-bucket', ['contexts' => $invalidContexts]);
    }

    public function testRewriteWithEmptyContexts()
    {
        $sourceObject = new StorageObject($this->connection->reveal(), 'source.txt', self::BUCKET_NAME);    
        $this->connection->rewriteObject(Argument::withEntry('contexts', []))
            ->shouldBeCalled()
            ->willReturn(['resource' => ['name' => 'dest.txt', 'contexts' => []]]);

        $result = $sourceObject->rewrite('dest-bucket', ['contexts' => []]);
        $this->assertEmpty($result->info()['contexts']);
    }

    public function invalidContextsProvider()
    {
        return [
            'Invalid Leading Unicode' => [
                ['custom' => ['key' => ['value' => '✨-sparkle']]],
                'Object context value must start with an alphanumeric.'
            ],
            'Forbidden Characters (Slash and Quote)' => [
                ['custom' => ['k1' => ['value' => 'invalid/val'], 'k2' => ['value' => 'val"quote']]],
                'Object context value cannot contain forbidden characters.'
            ],
            'Key Not Starting with Alphanumeric' => [
                ['custom' => ['_key' => ['value' => 'val']]],
                'Object context key must start with an alphanumeric.'
            ],
            'Custom Field Not An Array' => [
                ['custom' => 'not-an-array'],
                'Object contexts custom field must be an array.'
            ],
            'Value Property Missing' => [
                ['custom' => ['key' => ['no-value-here' => 'val']]],
                'Context for key "key" must have a \'value\' property.'
            ]
        ];
    }

    public function testRewriteWithContextOverride()
    {
        $sourceObject = new StorageObject(
            $this->connection->reveal(),
            'source.txt',
            self::BUCKET_NAME
        );

        $overriddenContexts = [
            'custom' => ['override-key' => ['value' => 'override-val']]
        ];

        $this->connection->rewriteObject(Argument::withEntry('contexts', $overriddenContexts))
            ->shouldBeCalled()
            ->willReturn([
                'resource' => [
                    'name' => 'dest.txt',
                    'bucket' => 'dest-bucket',
                    'generation' => '1',
                    'contexts' => $overriddenContexts
                ]
            ]);

        $result = $sourceObject->rewrite('dest-bucket', [
            'contexts' => $overriddenContexts
        ]);
        $this->assertInstanceOf(StorageObject::class, $result);
        $this->assertEquals(
            'override-val',
            $result->info()['contexts']['custom']['override-key']['value']
        );
    }

    /**
     * @dataProvider objectContextComposeDataProvider
     */
    public function testComposeObjectWithContexts(array $options, array $expectedContexts)
    {
        $destName = 'composed.txt';
        $sources = ['source1.txt', 'source2.txt'];

        $bucket = new Bucket($this->connection->reveal(), self::BUCKET_NAME);
        $this->connection->composeObject(Argument::that(function ($args) use ($options) {
            if (isset($options['contexts'])) {
                return isset($args['contexts']) && $args['contexts'] === $options['contexts'];
            }
            return !isset($args['contexts']);
        }))->shouldBeCalled()->willReturn([
            'name' => $destName,
            'bucket' => self::BUCKET_NAME,
            'generation' => 12345,
            'contexts' => $expectedContexts
        ]);

        $composedObject = $bucket->compose($sources, $destName, $options);
        $this->assertInstanceOf(StorageObject::class, $composedObject);
        $this->assertEquals($expectedContexts, $composedObject->info()['contexts']);
    }

    public function objectContextComposeDataProvider()
    {
        $sourceContexts = ['custom' => ['s1-key' => ['value' => 's1-val']]];
        $overrideContexts = ['custom' => ['new-key' => ['value' => 'new-val']]];

        return [
            'Inherit from Source' => [[], $sourceContexts],
            'Override with New'   => [['contexts' => $overrideContexts], $overrideContexts]
        ];
    }

    public function testGetMetadataIncludesContexts()
    {
        $objectName = 'metadata-'.self::FILE_NAME_TEST;
        $now = (new \DateTime())->format('Y-m-d\TH:i:s.v\Z');
        $this->connection->projectId()->willReturn(self::PROJECT_ID);
        $metadataResponse = [
            'name' => $objectName,
            'bucket' => self::BUCKET_NAME,
            'generation' => 12345,
            'contexts' => [
                'custom' => [
                    'existing-key' => ['value' => 'existing-val'],
                    'createTime' => $now,
                    'updateTime' => $now
                ]
            ]
        ];

        $this->connection->getObject(Argument::withEntry('object', $objectName))
            ->shouldBeCalled()
            ->willReturn($metadataResponse);

        $bucket = new Bucket($this->connection->reveal(), self::BUCKET_NAME);
        $info = $bucket->object($objectName)->info();
        $this->assertArrayHasKey('contexts', $info);
        $this->assertArrayHasKey(
            'createTime',
            $info['contexts']['custom']
        );
        $this->assertArrayHasKey(
            'updateTime',
            $info['contexts']['custom']
        );
        $this->assertEquals(
            'existing-val',
            $info['contexts']['custom']['existing-key']['value']
        );
    }

     /**
     * @dataProvider objectContextFilterDataProvider
     */
    public function testListObjectsWithContextFilters($filter, $expectedItems)
    {
        $this->connection->projectId()->willReturn(self::PROJECT_ID);
        $this->connection->listObjects(Argument::withEntry('filter', $filter))
            ->shouldBeCalled()
            ->willReturn([
                'items' => $expectedItems
            ]);

        $bucket = new Bucket($this->connection->reveal(), self::BUCKET_NAME);
        $objects = iterator_to_array($bucket->objects(['filter' => $filter]));

        $this->assertCount(count($expectedItems), $objects);
        if (count($objects) > 0 && isset($expectedItems[0]['contexts'])) {
            $this->assertEquals(
                $expectedItems[0]['contexts']['custom'],
                $objects[0]->info()['contexts']['custom']
            );
        }
    }

    public function objectContextFilterDataProvider()
    {
        $unicodeKey = 'key-✨';
        $unicodeVal = 'val-🚀';
        return [
        'Presence of key/value pair' => [
            'contexts.custom.k1.value="v1"',
            [
                ['name' => 'match.txt', 'contexts' => ['custom' => ['k1' => ['value' => 'v1']]]],
            ]
        ],
        'Absence of key/value pair' => [
            '-contexts.custom.k1.value="v1"',
            [
                ['name' => 'f1.txt', 'contexts' => ['custom' => ['k1' => ['value' => 'v2']]]], // Diff value
                ['name' => 'f2.txt'],
            ]
        ],
        'Presence of key regardless of value' => [
            'contexts.custom.k1:*',
            [
                ['name' => 'f1.txt', 'contexts' => ['custom' => ['k1' => ['value' => 'v1']]]],
                ['name' => 'f2.txt', 'contexts' => ['custom' => ['k1' => ['value' => 'any']]]],
            ]
        ],
        'Unicode key/value pair' => [
            sprintf('contexts.custom.%s.value="%s"', $unicodeKey, $unicodeVal),
            [
                ['name' => 'unicode.txt', 'contexts' => ['custom' => [$unicodeKey => ['value' => $unicodeVal]]]],
                ['name' => 'another.txt', 'contexts' => ['custom' => [$unicodeKey => ['value' => $unicodeVal]]]]
            ]
        ]
        ];
    }

    /**
    * @dataProvider objectContextPatchDataProvider
    */
    public function testPatchExistingObjectContext($key, $value)
    {
        $objectName = 'patch-'.self::FILE_NAME_TEST;
        $object = new StorageObject($this->connection->reveal(), $objectName, self::BUCKET_NAME);
       
        $patchData = ['contexts' => ['custom' => [$key => $value]]];
       
        $this->connection->patchObject(Argument::withEntry('contexts', $patchData['contexts']))
        ->shouldBeCalledTimes(1)
        ->willReturn([
            'name' => $objectName,
            'contexts' => $patchData['contexts']
        ]);

        $result = $object->update($patchData);
        $this->assertEquals($value, $result['contexts']['custom'][$key]);
    }

    public function objectContextPatchDataProvider()
    {
        return [
            'Update Key'          => ['new-key', 'brand-new-val'],
            'Delete Key'          => ['key-to-delete', null],
            'Empty Value'         => ['key-with-empty', ''],
            'Special Chars Key'   => ['key123', 'value-456']
        ];
    }

    public function testRewriteObjectWithContexts()
    {
        $contexts = [
            'custom' => [
                'rewrite-key' => ['value' => 'rewrite-val']
            ]
        ];
        $destBucket = 'other-bucket';
        $destName = 'rewritten-data.txt';

        $this->connection->rewriteObject(Argument::that(function ($args) use ($contexts) {
            return isset($args['contexts']) && $args['contexts'] === $contexts;
        }))->willReturn([
            'rewriteToken' => null,
            'resource' => [
                'name' => $destName,
                'bucket' => $destBucket,
                'generation' => 456,
                'contexts' => $contexts
            ]
        ]);

        $sourceBucket = 'source-bucket';
        $sourceObject = new StorageObject(
            $this->connection->reveal(),
            'source-file.txt',
            $sourceBucket,
            123,
            ['bucket' => $sourceBucket]
        );

        $object = $sourceObject->rewrite($destBucket, [
            'contexts' => $contexts
        ]);
        $this->assertInstanceOf(StorageObject::class, $object);
        $this->assertEquals($destName, $object->name());
        $this->assertArrayHasKey('contexts', $object->info());
        $this->assertEquals($contexts, $object->info()['contexts']);
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
            ->willReturn([])
            ->shouldBeCalled();

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
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('$topic may only be a string or instance of Google\Cloud\PubSub\Topic');

        $bucket = $this->getBucket();
        $bucket->createNotification(9124);
    }

    public function testCreatesNotificationThrowsExceptionWithoutProjectId()
    {
        $this->expectException(GoogleException::class);

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
        $this->expectException(\BadMethodCallException::class);

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

    public function terminalStorageClass()
    {
        return [
            ['NEARLINE'],
            ['ARCHIVE']
        ];
    }

    private function getBucketForSigning(
        ?SignBlobInterface $credentials = null,
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
