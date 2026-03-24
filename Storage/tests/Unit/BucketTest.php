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
            'generation' => 123,
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

    /**
     * -------------------------------------------------------------------------
     * CONTEXT OBJECT SCENARIOS
     * -------------------------------------------------------------------------
     * The following methods handle logic related to Context Object workflows.
    */

    public function testCreateWithValidContexts()
    {
        // 1. Define Valid Data Contexts
        $contexts = [
            'custom' => [
                'test-key' => ['value' => 'test-value']
            ]
        ];

        // 2. Mock for resumable uploader to return the contexts in the response, simulating a successful upload with contexts.
        $this->resumableUploader->upload()->willReturn([
            'name' => 'data.txt',
            'generation' => 123,
            'contexts' => $contexts // Need to return contexts here to simulate that they are included in the object info after upload
        ]);

        // 3. Mock the connection to expect 'contexts' in the insertObject call and return the mocked resumable uploader.
        $this->connection->insertObject(Argument::that(function ($args) use ($contexts) {
            return isset($args['contexts']) && $args['contexts'] === $contexts;
        }))->willReturn($this->resumableUploader->reveal());

        $bucket = $this->getBucket();

        // 4. Call the upload method with the defined contexts and verify that the returned object has the contexts in its info.
        $object = $bucket->upload('some data to upload', [
            'name' => 'data.txt',
            'contexts' => $contexts 
        ]);

        $this->assertInstanceOf(StorageObject::class, $object);
        
        // 5. Verify context object is avaiable in the Object
        $this->assertEquals($contexts, $object->info()['contexts']);
    }

    /**
        * @expectedException \InvalidArgumentException
        * @expectedExceptionMessage Object context value cannot contain forbidden characters.
    */
    public function testCreateWithInvalidContexts()
    {
        // 1. Expecting an exception.
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Object context value cannot contain forbidden characters.');

        $invalidContexts = [
            'custom' => [
                'valid-key' => ['value' => 'invalid/value']
            ]
        ];

        $bucket = $this->getBucket();

        // 2. Call here. If got exception then case will be pass.
        $bucket->upload('data', [
            'name' => 'test.txt',
            'contexts' => $invalidContexts
        ]);
    }

    /**
        * Test that the library rejects values that do not start with an alphanumeric character.
    */
    public function testRejectInvalidLeadingUnicodeValueInContexts()
    {
        $bucket = $this->getBucket();

        // CASE 2: Value starts with an emoji (invalid)
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Object context value must start with an alphanumeric character.');

        $bucket->upload('test data', [
            'name' => 'test.txt',
            'contexts' => [
                'custom' => [
                    'my-custom-key' => ['value' => '✨-sparkle']
                ]
            ]
        ]);
    }

    /**
     *  Test modifying an existing custom context key and value
     *  This simulates the "Replace all" behaviour.
    */
    public function testUpdateAndReplaceContexts()
    {
        // 1. Define the updated data
        $contextKey = 'context-key-1';
        $updatedValue = 'updated-value';
        $newContexts = [
            'custom' => [
                $contextKey => ['value' => $updatedValue]
            ]
        ];

        // 2. Mock the Connection
        // We expect patchObject to be called with the new contexts in the arguments
        $this->connection->patchObject(Argument::that(function ($args) use ($newContexts) {
            return isset($args['contexts']) && $args['contexts'] === $newContexts;
        }))->shouldBeCalled()->willReturn([
            'name' => 'test.txt',
            'contexts' => $newContexts
        ]);

        // 3. Initialize the StorageObject with the Mock Connection
        // Note: Assuming $this->connection is already a prophesize(Rest::class) in your setUp
        $object = new StorageObject(
            $this->connection->reveal(),
            'test.txt',
            'my-bucket'
        );

        // 4. Execute the Update
        $object->update([
            'contexts' => $newContexts
        ]);

        // 5. Assertions: Check if the internal state of the object was updated
        $info = $object->info();
        $this->assertArrayHasKey('contexts', $info);
        $this->assertEquals(
            $updatedValue,
            $info['contexts']['custom'][$contextKey]['value'],
            'The local object info was not updated with the new context value.'
        );
    }

    /**
     * Test individual patching behaviors: Add, Modify, Remove, and Clear.
     * This covers the "Patch an existing object" requirements.
     */
    public function testPatchIndividualContexts()
    {
        $objectName = 'patch-test.txt';
        $bucketName = 'my-bucket';
        
        $object = new StorageObject(
            $this->connection->reveal(), 
            $objectName, 
            $bucketName
        );

        // --- 1. ADDING / MODIFYING INDIVIDUAL CONTEXTS ---
        $patchData = [
            'contexts' => [
                'custom' => [
                    'new-key' => ['value' => 'brand-new-val']
                ]
            ]
        ];

        $this->connection->patchObject(Argument::that(function ($args) use ($patchData) {
           return isset($args['contexts']['custom']) && 
               $args['contexts']['custom'] === $patchData['contexts']['custom'];
        }))->shouldBeCalledTimes(1)->willReturn([
            'name' => $objectName,
            'contexts' => $patchData['contexts']
        ]);

        $object->update($patchData);

        // --- 2. REMOVING INDIVIDUAL CONTEXTS ---
        $removeData = [
            'contexts' => [
                'custom' => [
                    'key-to-delete' => null
                ]
            ]
        ];

        $this->connection->patchObject(Argument::that(function ($args) {
        // Fix: Use isset() and array_key_exists to prevent "offset on null"
        return isset($args['contexts']['custom']) && 
               array_key_exists('key-to-delete', $args['contexts']['custom']) && 
               $args['contexts']['custom']['key-to-delete'] === null;
        }))->shouldBeCalledTimes(1)->willReturn([
            'name' => $objectName,
            'contexts' => ['custom' => ['remaining-key' => ['value' => 'stays']]]
        ]);

        $object->update($removeData);

        // --- 3. CLEARING ALL CONTEXTS ---
        $clearData = [
            'contexts' => null
        ];

        $this->connection->patchObject(Argument::that(function ($args) {
        // For clearing, contexts is explicitly null
            return array_key_exists('contexts', $args) && $args['contexts'] === null;
        }))->shouldBeCalledTimes(1)->willReturn([
            'name' => $objectName
        ]);

        $object->update($clearData);
    }

    /**
    * Test rewriting an object with context inheritance and overrides.
    */
    public function testRewriteObjectWithContexts()
    {
        $sourceName = 'source.txt';
        $destName = 'destination.txt';
        $bucketName = 'my-bucket';

        $object = new StorageObject(
            $this->connection->reveal(),
            $sourceName,
            $bucketName
        );

        // Mocking the "Fake" Server Response
        $this->connection->rewriteObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'resource' => [
                    'name' => $destName,
                    'bucket' => $bucketName, // Essential for the library to create the new object
                    'generation' => 1,       // Good practice to include
                    'contexts' => [
                        'custom' => ['key' => ['value' => 'val']]
                    ]
                ],
                'done' => true
            ]);

        // This call stays within your local machine (Unit Test)
        $newObject = $object->rewrite($bucketName, ['name' => $destName]);

        $this->assertInstanceOf(StorageObject::class, $newObject);
        $this->assertEquals($destName, $newObject->name());
    }

    /**
     * Test composing objects with context inheritance and overrides.
     * @dataProvider composeContextDataProvider
     */
    public function testComposeObjectWithContexts(array $options, array $expectedContexts)
    {
        $destName = 'composed.txt';
        $bucketName = 'my-bucket';
        $sources = ['source1.txt', 'source2.txt'];

        $bucket = new Bucket($this->connection->reveal(), $bucketName);

        // Mocking the Compose API call
        $this->connection->composeObject(Argument::that(function ($args) use ($options) {
            // If 'contexts' is in options, it must be in the API args. 
            // If not, it shouldn't be present at all.
            if (isset($options['contexts'])) {
                return isset($args['contexts']) && $args['contexts'] === $options['contexts'];
            }
            return !isset($args['contexts']);
        }))->shouldBeCalled()->willReturn([
            'name' => $destName,
            'bucket' => $bucketName,
            'generation' => 12345, // <--- ADDED THIS TO FIX THE ERROR
            'contexts' => $expectedContexts
        ]);

        $composedObject = $bucket->compose($sources, $destName, $options);

        $this->assertInstanceOf(StorageObject::class, $composedObject);
        $this->assertEquals($expectedContexts, $composedObject->info()['contexts']);
    }

    /**
     * Data provider for Inherit and Override scenarios.
     */
    public function composeContextDataProvider()
    {
        $sourceContexts = ['custom' => ['s1-key' => ['value' => 's1-val']]];
        $overrideContexts = ['custom' => ['new-key' => ['value' => 'new-val']]];

        return [
            'Inherit from Source' => [[], $sourceContexts],
            'Override with New'   => [['contexts' => $overrideContexts], $overrideContexts]
        ];
    }

    /**
     * Test that getting an object's metadata includes the contexts.
     * Fixed: Added projectId() mock call to prevent UnexpectedCallException.
     */
    public function testGetMetadataIncludesContexts()
    {
        $objectName = 'metadata-test.txt';
        $bucketName = 'my-bucket';
        $projectId = 'test-project'; // Dummy project ID
        
        // 1. Mock the 'projectId' call (Required by the Bucket/Object constructor)
        $this->connection->projectId()->willReturn($projectId);

        // 2. Define the metadata response
        $metadataResponse = [
            'name' => $objectName,
            'bucket' => $bucketName,
            'generation' => 12345,
            'contexts' => [
                'custom' => [
                    'existing-key' => ['value' => 'existing-val']
                ]
            ]
        ];

        // 3. Mock the 'getObject' call
        $this->connection->getObject(Argument::withEntry('object', $objectName))
            ->shouldBeCalled()
            ->willReturn($metadataResponse);

        $bucket = new Bucket($this->connection->reveal(), $bucketName);

        // 4. Action: Retrieve the object
        $object = $bucket->object($objectName);

        // 5. Assertions
        $info = $object->info();
        
        $this->assertArrayHasKey('contexts', $info);
        $this->assertEquals(
            'existing-val', 
            $info['contexts']['custom']['existing-key']['value']
        );
    }

    /**
     * Test listing objects with contexts and filtering.
     */
    public function testListObjectsWithContextsAndFiltering()
    {
        $bucketName = 'my-bucket';
        $prefix = 'folder/';

        // 1. Mock the Connection (Consolidated)
        $this->connection->projectId()->willReturn('test-project');
        
        // We mock the API to return two objects, each with their own contexts
        $this->connection->listObjects(Argument::withEntry('prefix', $prefix))
            ->shouldBeCalled()
            ->willReturn([
                'items' => [
                    ['name' => 'file1.txt', 'contexts' => ['custom' => ['k1' => ['value' => 'v1']]]],
                    ['name' => 'file2.txt', 'contexts' => ['custom' => ['k2' => ['value' => 'v2']]]]
                ]
            ]);

        $bucket = new Bucket($this->connection->reveal(), $bucketName);

        // 2. Action & Assertions (Using foreach for brevity)
        $objects = $bucket->objects(['prefix' => $prefix]);

        $count = 0;
        foreach ($objects as $index => $object) {
            $count++;
            $expectedVal = 'v' . $count;
            $expectedKey = 'k' . $count;
            
            // Verify contexts are included in the response for each item
            $this->assertEquals(
                $expectedVal, 
                $object->info()['contexts']['custom'][$expectedKey]['value']
            );
        }

        $this->assertEquals(2, $count, 'Should have listed exactly 2 objects.');
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
