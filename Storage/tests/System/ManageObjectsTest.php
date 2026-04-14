<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Storage\Tests\System;

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Storage\StorageObject;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @group storage
 * @group storage-object
 */
class ManageObjectsTest extends StorageTestCase
{
    const DATA = 'data';
    const CONTEXT_OBJECT_KEY = 'insert-key';
    const CONTEXT_OBJECT_VALUE = 'insert-val';
    const CONTEXT_OBJECT_PREFIX = 'object-contexts-';
    public function testListsObjects()
    {
        $foundObjects = [];
        $objectsToCreate = [
            uniqid(self::TESTING_PREFIX),
            uniqid(self::TESTING_PREFIX)
        ];

        foreach ($objectsToCreate as $objectToCreate) {
            self::$bucket->upload(self::DATA, ['name' => $objectToCreate]);
        }

        $objects = self::$bucket->objects(['prefix' => self::TESTING_PREFIX]);

        foreach ($objects as $object) {
            foreach ($objectsToCreate as $key => $objectToCreate) {
                if ($object->name() === $objectToCreate) {
                    $foundObjects[$key] = $object->name();
                }
            }
        }

        $this->assertEquals($objectsToCreate, $foundObjects);
    }

    public function testListsObjectsWithMatchGlob()
    {
        $bucket = self::createBucket(self::$client, uniqid('matchglob-'));
        $objectsToCreate = ["foo/bar", "foo/baz", "foo/foobar", "foobar"];
        $matchGlobCases = [
            'foo*bar' => ['foobar'],
            'foo**bar' => ['foo/bar', 'foo/foobar', 'foobar'],
            '**/foobar' => ['foo/foobar', 'foobar'],
            '*/ba[rz]' => ['foo/bar', 'foo/baz'],
            '*/ba[!a-y]' => ['foo/baz'],
            '**/{foobar,baz}' => ['foo/baz', 'foo/foobar', 'foobar'],
            'foo/{foo*,*baz}' => ['foo/baz', 'foo/foobar'],
        ];

        foreach ($objectsToCreate as $objectToCreate) {
            $bucket->upload(self::DATA, ['name' => $objectToCreate]);
        }

        foreach ($matchGlobCases as $matchGlob => $expectedObjects) {
            $objects = $bucket->objects(['matchGlob' => $matchGlob]);
            $resultObjects = [];
            foreach ($objects as $object) {
                $resultObjects[] = $object->name();
            }
            $this->assertEquals($expectedObjects, $resultObjects);
        }
    }

    public function testObjectRetentionLockedMode()
    {
        // Bucket with object retention locked mode is not cleaned up immediately
        $bucket = self::$client->createBucket(uniqid('object-retention-locked-'), [
            'enableObjectRetention' => true
        ]);

        // Test create object with object retention enabled
        $objectName = "object-retention-lock";
        $time = (new \DateTime)->add(
            \DateInterval::createFromDateString('+2 hours')
        );
        $object = $bucket->upload(self::DATA, [
            'name' => $objectName,
            'retention' => [
                'mode' => 'Locked',
                'retainUntilTime' => $time->format(\DateTime::RFC3339)
            ]
        ]);
        $this->assertEquals('Locked', $object->info()['retention']['mode']);

        $laterTime = (new \DateTime)->add(
            \DateInterval::createFromDateString('+4 hours')
        );

        // retainUntilTime of a locked mode object can be increased
        $object->update([
            'retention' => [
                'mode' => 'Locked',
                'retainUntilTime' => $laterTime->format(\DateTime::RFC3339)
            ]
        ]);
        $this->assertEqualsWithDelta(
            $laterTime,
            new \DateTime($object->info()['retention']['retainUntilTime']),
            1
        );

        // retainUntilTime of a locked mode object can not be decreased
        $exception = null;
        try {
            $object->update([
                'retention' => [
                    'mode' => 'Locked',
                    'retainUntilTime' => $time->format(\DateTime::RFC3339)
                ]
            ]);
        } catch (ServiceException $e) {
            $exception = $e;
        }
        $this->assertInstanceOf(ServiceException::class, $exception);
        $this->assertStringContainsString(
            'retention period cannot be shortened',
            $exception->getMessage()
        );
        $this->assertEqualsWithDelta(
            $laterTime,
            new \DateTime($object->info()['retention']['retainUntilTime']),
            1
        );

        // Retention mode of a locked mode object can not be changed
        $exception = null;
        try {
            $object->update([
                'retention' => [
                    'mode' => 'Unlocked',
                    'retainUntilTime' => $laterTime->format(\DateTime::RFC3339)
                ],
                'overrideUnlockedRetention' => true
            ]);
        } catch (ServiceException $e) {
            $exception = $e;
        }
        $this->assertInstanceOf(ServiceException::class, $exception);
        $this->assertStringContainsString(
            'retention mode cannot be changed',
            $exception->getMessage()
        );
    }

    public function testObjectRetentionUnlockedMode()
    {
        // Test bucket created with object retention enabled
        $bucket = self::createBucket(self::$client, uniqid('object-retention-'), [
            'enableObjectRetention' => true
        ]);
        $this->assertEquals('Enabled', $bucket->info()['objectRetention']['mode']);

        // Test create object with object retention enabled
        $objectName = "object-retention-lock";
        $expires = (new \DateTime)->add(
            \DateInterval::createFromDateString('+2 hours')
        );
        $uploader = $bucket->getStreamableUploader('initial contents', [
                'name' => $objectName,
                'retention' => [
                    'mode' => 'Unlocked',
                    'retainUntilTime' => $expires->format(\DateTime::RFC3339)
                ]
            ]);
        $uploader->upload();
        $object = $bucket->object($objectName);
        $this->assertEquals('Unlocked', $object->info()['retention']['mode']);

        // Object delete throws when object has a valid retention policy
        $exception = null;
        try {
            $object->delete();
        } catch (ServiceException $e) {
            $exception = $e;
        }
        $this->assertInstanceOf(ServiceException::class, $exception);
        $this->assertStringContainsString(
            'cannot be deleted or overwritten',
            $exception->getMessage()
        );
        $this->assertTrue($object->exists());

        // Disable object retention
        $object->update([
            'retention' => [],
            'overrideUnlockedRetention' => true
        ]);
        $this->assertNotContains('retention', $object->info());

        // Object delete succeeds when object retention is disabled
        $object->delete();
        $this->assertFalse($object->exists());
    }

    private function createObjectWithContexts(array $uploadContexts)
    {
        $bucket = self::$bucket;
        $object = $bucket->upload(self::DATA, [
            'name' => self::CONTEXT_OBJECT_PREFIX . uniqid(),
            'contexts' => $uploadContexts
        ]);
        return $object;
    }

    public function testCreateRetrieveAndUpdateObjectContexts()
    {
        $initialContexts = [
            'custom' => [
                'team-owner' => ['value' => 'storage-team'],
                'priority' => ['value' => 'high'],
            ],
        ];

        $object = $this->createObjectWithContexts($initialContexts);
        $metadata = $object->info();
        $this->assertArrayHasKey('contexts', $metadata);
        $this->assertEquals(
            'storage-team',
            $metadata['contexts']['custom']['team-owner']['value']
        );
        $this->assertArrayHasKey('createTime', $metadata['contexts']['custom']['team-owner']);

        $patchMetadata = [
            'contexts' => [
                'custom' => [
                    'priority' => ['value' => 'critical'],
                    'env' => ['value' => 'prod'],
                    'team-owner' => null,
                ],
            ],
        ];
        $updatedMetadata = $object->update($patchMetadata);
        $finalCustom = $updatedMetadata['contexts']['custom'];
        $this->assertEquals('critical', $finalCustom['priority']['value']);
        $this->assertEquals('prod', $finalCustom['env']['value']);
        $this->assertArrayNotHasKey('team-owner', $finalCustom);
        $this->assertArrayHasKey('updateTime', $finalCustom['priority']);
        $object->delete();
    }

    public function testGetContextAndServerGenratedTimes()
    {
        $initialContexts = [
            'custom' => [
                'temp-key' => ['value' => 'temp'],
                'status' => ['value' => 'to-be-cleared'],
            ],
        ];

        $object = $this->createObjectWithContexts($initialContexts);
        $info = $object->info();
        $this->assertArrayHasKey('contexts', $info, 'Contexts missing from server response.');
    
        $context = $info['contexts']['custom']['status'];
        $this->assertEquals('to-be-cleared', $context['value']);
        $this->assertArrayHasKey(
            'createTime',
            $context,
            'Server failed to generate createTime for context.'
        );
        $this->assertArrayHasKey(
            'updateTime',
            $context,
            'Server failed to generate updateTime for context.'
        );
        $object->delete();
    }

    public function testClearAllExistingContexts()
    {
        $initialContexts = [
            'custom' => [
                'temp-key' => ['value' => 'temp'],
                'status' => ['value' => 'to-be-cleared'],
            ],
        ];

        $object = $this->createObjectWithContexts($initialContexts);
        $object->update([
            'contexts' => null
        ]);
        $info = $object->info();
        $this->assertArrayNotHasKey('contexts', $info);
        $object->delete();
    }

    public function testCopyOrRewriteObjectWithContexts()
    {
        $initialContexts = [
            'custom' => [
                'tag' => ['value' => 'orignal'],
            ],
        ];

        $object = $this->createObjectWithContexts($initialContexts);
        $inherited = $object->rewrite(self::$bucket, ['name' => 'inherit-' . uniqid()]);
        $info = $inherited->info();
        
        $this->assertEquals('orignal', $info['contexts']['custom']['tag']['value']);
        $overrideKey = 'override-key';
        $overrideVal = 'override-val';
        $overridden = $object->rewrite(self::$bucket, [
            'name' => 'override-' . uniqid(),
            'contexts' => ['custom' => [$overrideKey => ['value' => $overrideVal]]]
        ]);
        
        $info = $overridden->info();
        $this->assertEquals($overrideVal, $info['contexts']['custom'][$overrideKey]['value']);
        $this->assertArrayNotHasKey('tag', $info['contexts']['custom']);
        $object->delete();
    }
    
    public function testOverrideContextsDuringCopy()
    {
        $initialContexts = [
            'custom' => [
                'tag' => ['value' => 'original'],
            ],
        ];
        $source = $this->createObjectWithContexts($initialContexts);
        $destName = 'rewrite-dest-' . uniqid() . '.txt';
        $inherited = $source->rewrite(self::$bucket, [
            'name' => $destName
        ]);
        $this->assertEquals($destName, $inherited->name());
        $this->assertEquals(
            'original',
            $inherited->info()['contexts']['custom']['tag']['value']
        );
        $overrideVal = 'new-value';
        $overridden = $source->copy(self::$bucket, [
            'name' => 'overridden-' . uniqid() . '.txt',
            'contexts' => [
                'custom' => [
                    'tag' => ['value' => $overrideVal]
                ]
            ]
        ]);

        $this->assertEquals($overrideVal, $overridden->info()['contexts']['custom']['tag']['value']);
        $source->delete();
    }

    public function testOverrideContextsForComposeObject()
    {
        $initialContexts = [
            'custom' => [
                'tag' => ['value' => 'file1'],
            ],
        ];
        
        $source1 = $this->createObjectWithContexts($initialContexts);
        $bucket = self::$client->bucket($source1->info()['bucket']);
        $s2Key = 's2-key';
        $source2 = $bucket->upload(self::DATA, [
            'name' => self::CONTEXT_OBJECT_PREFIX . 's2-' . uniqid(),
            'contexts' => ['custom' => [$s2Key => ['value' => 'file2']]]
        ]);
        $inherit = $bucket->compose([$source1, $source2], 'c-inh-' . uniqid() . '.txt');
        $custom = $inherit->info()['contexts']['custom'];
        $this->assertEquals('file1', $custom['tag']['value']);

        $oKey = 'c-override';
        $oVal = 'c-val';
        $override = $bucket->compose([$source1, $source2], 'c-ovr-' . uniqid() . '.txt');
        $info = $override->update([
            'contexts' => [
                'custom' => [
                    $oKey => ['value' => $oVal],
                    self::CONTEXT_OBJECT_KEY => null
                ]
            ]
        ]);

        $this->assertEquals($oVal, $info['contexts']['custom'][$oKey]['value']);
        $this->assertArrayNotHasKey(self::CONTEXT_OBJECT_KEY, $info['contexts']['custom']);
        $source1->delete();
    }

    public function testInheritContextsForComposeObject()
    {
        $initialContexts1 = [
            'custom' => [
                'tag' => ['value' => 'file1-original'],
            ],
        ];
        $source1 = $this->createObjectWithContexts($initialContexts1);

        $s2Key = 's2-specific-key';
        $bucket = self::$client->bucket($source1->info()['bucket']);
        $source2 = $bucket->upload('data', [
            'name' => 'source2-' . uniqid() . '.txt',
            'contexts' => [
                'custom' => [
                    $s2Key => ['value' => 'file2-data']
                ]
            ]
        ]);

        $destName = 'c-inh-' . uniqid() . '.txt';
        $inheritedObject = $bucket->compose([$source1, $source2], $destName);
        $info = $inheritedObject->info();
        $this->assertArrayHasKey('contexts', $info);
        $this->assertArrayHasKey('custom', $info['contexts']);
        $custom = $info['contexts']['custom'];
        $this->assertEquals('file1-original', $custom['tag']['value']);
        $this->assertArrayHasKey($s2Key, $custom);
        $this->assertEquals('file2-data', $custom[$s2Key]['value']);
        
        $source1->delete();
        $source2->delete();
    }

    public function testListObjectsWithContextFilters()
    {
        $bucketName = 'test-context-filter-' . time();
        $bucket = self::createBucket(self::$client, $bucketName);
        try {
            $activeFile = $bucket->upload('content', [
                'name' => 'test-active.txt',
                'metadata' => ['contexts' => ['custom' => ['status' => ['value' => 'active']]]]
            ]);

            $inactiveFile = $bucket->upload('content', [
                'name' => 'test-inactive.txt',
                'metadata' => ['contexts' => ['custom' => ['status' => ['value' => 'inactive']]]]
            ]);

            $noneFile = $bucket->upload('content', [
                'name' => 'test-none.txt'
            ]);
            $objects = iterator_to_array($bucket->objects());
            $this->assertCount(3, $objects);

            $objects = iterator_to_array($bucket->objects([
                'filter' => 'contexts."status"="inactive"'
            ]));
            $this->assertCount(1, $objects);
            $this->assertEquals($inactiveFile->name(), $objects[0]->name());

            $objects = iterator_to_array($bucket->objects([
                'filter' => 'contexts."status"="active"'
            ]));
            $this->assertCount(1, $objects);
            $this->assertEquals($activeFile->name(), $objects[0]->name());

            $objects = iterator_to_array($bucket->objects([
                'filter' => '-contexts."status"="active"'
            ]));
            $this->assertCount(2, $objects);

            $objects = iterator_to_array($bucket->objects([
                'filter' => 'contexts."status":*'
            ]));
            $this->assertCount(2, $objects);

            $objects = iterator_to_array($bucket->objects([
                'filter' => '-contexts."status":*'
            ]));
            $this->assertCount(1, $objects);
            $this->assertEquals($noneFile->name(), $objects[0]->name());

            $objects = iterator_to_array($bucket->objects([
                'filter' => 'contexts."status"="ghost"'
            ]));
            $this->assertCount(0, $objects);
        } finally {
            foreach ($bucket->objects() as $object) {
                $object->delete();
            }
            $bucket->delete();
        }
    }

    public function testUploadAsync()
    {
        $name = uniqid(self::TESTING_PREFIX);
        $promise = self::$bucket->uploadAsync(self::DATA, ['name' => $name]);
        $this->assertInstanceOf(PromiseInterface::class, $promise);
        $resp = $promise->wait();
        $this->assertInstanceOf(StorageObject::class, $resp);
    }

    public function testUpdateObject()
    {
        $metadata = [
            'metadata' => [
                'location' => 'test'
            ]
        ];
        $info = self::$object->update($metadata);

        $this->assertEquals($metadata['metadata'], $info['metadata']);
    }

    public function testCopiesObject()
    {
        $name = uniqid(self::TESTING_PREFIX);
        $copiedObject = self::$object->copy(self::$bucket, [
            'name' => $name
        ]);

        $this->assertEquals($name, $copiedObject->name());

        return $copiedObject;
    }

    /**
     * @depends testCopiesObject
     */
    public function testRenamesObject($object)
    {
        $name = uniqid(self::TESTING_PREFIX);
        $newObject = $object->rename($name);
        $this->assertFalse($object->exists());

        $this->assertEquals($name, $newObject->name());
        return $newObject;
    }

    /**
     * @depends testRenamesObject
     */
    public function testComposeObjects($object)
    {
        $expectedContent = $object->downloadAsString();
        $expectedContent .= self::$object->downloadAsString();
        $name = uniqid(self::TESTING_PREFIX) . '.txt';
        $composedObject = self::$bucket->compose(
            [$object, self::$object],
            $name
        );

        $this->assertEquals($name, $composedObject->name());
        $this->assertEquals($expectedContent, $composedObject->downloadAsString());
        return $composedObject;
    }

    public function testSoftDeleteObject()
    {
        $softDeleteBucketName = "soft-delete-bucket-" . uniqid();
        $softDeleteBucket = self::createBucket(
            self::$client,
            $softDeleteBucketName,
            [
                'location' => 'us-west1',
                'softDeletePolicy' => ['retentionDurationSeconds' => 8 * 24 * 60 * 60]
            ]
        );
        $object = $softDeleteBucket->upload(self::DATA, ['name' => uniqid(self::TESTING_PREFIX)]);
        $this->assertStorageObjectExists($softDeleteBucket, $object);
        $generation = $object->info()['generation'];

        $object->delete();

        $this->assertStorageObjectNotExists($softDeleteBucket, $object);
        $this->assertStorageObjectExists($softDeleteBucket, $object, [
            'softDeleted' => true,
            'generation' => $generation
        ]);

        $restoredObject = $softDeleteBucket->restore($object->name(), $generation);
        $this->assertNotEquals($generation, $restoredObject->info()['generation']);

        $this->assertStorageObjectExists($softDeleteBucket, $restoredObject);
    }

    public function testSoftDeleteHNSObject()
    {
        $softDeleteBucketName = "soft-delete-hns-bucket-" . uniqid();
        $softDeleteHNSBucket = self::createBucket(
            self::$client,
            $softDeleteBucketName,
            [
                'location' => 'us-west1',
                'softDeletePolicy' => ['retentionDurationSeconds' => 8 * 24 * 60 * 60],
                'hierarchicalNamespace' => ['enabled' => true,],
                'iamConfiguration' => ['uniformBucketLevelAccess' => ['enabled' => true]]
            ]
        );
        $object = $softDeleteHNSBucket->upload(self::DATA, ['name' => uniqid(self::TESTING_PREFIX)]);
        $this->assertStorageObjectExists($softDeleteHNSBucket, $object);
        $generation = $object->info()['generation'];
        $objectName = $object->info()['name'];
        $options = [
            'softDeleted' => true,
            'generation' => $generation
        ];

        $object->delete();

        $deletedObject = $softDeleteHNSBucket->object($objectName, $options);
        $restoreToken = $deletedObject->info($options)['restoreToken'];

        $this->assertStorageObjectNotExists($softDeleteHNSBucket, $object);
        $this->assertStorageObjectExists($softDeleteHNSBucket, $object, [
            'softDeleted' => true,
            'generation' => $generation
        ]);

        $restoredObject = $softDeleteHNSBucket->restore($object->name(), $generation, [
            'restoreToken' => $restoreToken
        ]);
        $this->assertNotEquals($generation, $restoredObject->info()['generation']);

        $this->assertStorageObjectExists($softDeleteHNSBucket, $restoredObject);
    }

    /**
      * @dataProvider provideMoveObject
      */
    public function testMoveObject(bool $hnEnabled)
    {
        $name = "move-object-bucket-" . uniqid();
        $sourceObjectName = uniqid(self::TESTING_PREFIX);
        $destinationObjectName = uniqid(self::TESTING_PREFIX);
        $sourceBucket = self::createBucket(
            self::$client,
            $name,
            [
                'hierarchicalNamespace' => ['enabled' => $hnEnabled],
                'iamConfiguration' => ['uniformBucketLevelAccess' => ['enabled' => true]]
            ]
        );

        // Assert that the bucket was created correctly.
        $this->assertEquals($name, $sourceBucket->name());

        $object = $sourceBucket->upload(self::DATA, ['name' => $sourceObjectName]);
        $this->assertStorageObjectExists($sourceBucket, $object);

        // Move the object.
        $movedObject = $object->move($destinationObjectName);

        // Assert that check existence of source and destination object.
        $this->assertStorageObjectNotExists($sourceBucket, $object);
        $this->assertStorageObjectExists($sourceBucket, $movedObject);
    }

    public function provideMoveObject()
    {
        return [[true], [false]];
    }

    public function testRotatesCustomerSuppliedEncryption()
    {
        $key = base64_encode(openssl_random_pseudo_bytes(32));
        $options = [
            'name' => uniqid(self::TESTING_PREFIX),
            'encryptionKey' => $key
        ];
        $object = self::$bucket->upload(self::DATA, $options);

        $dkey = base64_encode(openssl_random_pseudo_bytes(32));
        $dsha = base64_encode(hash('SHA256', base64_decode($dkey), true));
        $rewriteOptions = [
            'name' => uniqid(self::TESTING_PREFIX),
            'encryptionKey' => $key,
            'destinationEncryptionKey' => $dkey
        ];

        $rewrittenObject = $object->rewrite(self::$bucket, $rewriteOptions);

        $this->assertEquals($dsha, $rewrittenObject->info()['customerEncryption']['keySha256']);
        $rewrittenObject->delete();
    }

    public function testDownloadsAsString()
    {
        $content = self::$object->downloadAsString();

        $this->assertIsString($content);
    }

    public function testDownloadsAsStream()
    {
        $content = self::$object->downloadAsStream();

        $this->assertInstanceOf(StreamInterface::class, $content);
    }

    public function testDownloadsAsStreamAsync()
    {
        $promise = self::$object->downloadAsStreamAsync();

        $this->assertInstanceOf(PromiseInterface::class, $promise);
        $this->assertInstanceOf(StreamInterface::class, $promise->wait());
    }

    public function testDownloadsToFile()
    {
        $contents = self::$object->downloadAsString();
        $stream = self::$object->downloadToFile('php://temp');

        $this->assertEquals($contents, (string) $stream);
    }

    public function testDownloadsToFileShouldNotCreateFileWhenObjectNotFound()
    {
        $objectName = uniqid(self::TESTING_PREFIX);
        $testObject = self::$bucket->object($objectName);
        $exceptionString = 'No such object';
        $downloadFilePath = __DIR__ . '/' . $objectName;

        $throws = false;
        try {
            $testObject->downloadToFile($downloadFilePath);
        } catch (NotFoundException $e) {
            $this->assertStringContainsString($exceptionString, $e->getMessage());
            $throws = true;
        }

        $this->assertTrue($throws);
        $this->assertFileDoesNotExist($downloadFilePath);
    }

    public function testDownloadsPublicFileWithUnauthenticatedClient()
    {
        $objectName = uniqid(self::TESTING_PREFIX);
        self::$bucket->upload(self::DATA, [
            'name' => $objectName,
            'predefinedAcl' => 'publicRead'
        ]);
        $actualData = self::$unauthenticatedClient
            ->bucket(self::$mainBucketName)
            ->object($objectName)
            ->downloadAsString();

        $this->assertEquals(self::DATA, $actualData);
    }

    public function testThrowsExceptionWhenDownloadsPrivateFileWithUnauthenticatedClient()
    {
        $this->expectException(ServiceException::class);
        $this->expectExceptionCode(401);

        $objectName = uniqid(self::TESTING_PREFIX);
        self::$bucket->upload(self::DATA, [
            'name' => $objectName,
            'predefinedAcl' => 'private'
        ]);
        $actualData = self::$unauthenticatedClient
            ->bucket(self::$mainBucketName)
            ->object($objectName)
            ->downloadAsString();

        $this->assertEquals(self::DATA, $actualData);
    }

    public function testReloadObject()
    {
        $this->assertEquals('storage#object', self::$object->reload()['kind']);
    }

    public function testStringNormalization()
    {
        $this->markTestSkipped('cannot access bucket ' . self::NORMALIZATION_TEST_BUCKET);

        $bucket = self::$client->bucket(self::NORMALIZATION_TEST_BUCKET);

        $cases = [
            ["Caf\xC3\xA9", "Normalization Form C"],
            ["Cafe\xCC\x81", "Normalization Form D"],
        ];

        foreach ($cases as list($name, $expectedContent)) {
            $object = $bucket->object($name);
            $actualContent = $object->downloadAsString();

            $this->assertSame($expectedContent, $actualContent);
        }
    }

    /**
     * Asserts that a provided StorageObject exists.
     *
     * A StorageObject can be created via several methods, including but not limited to:
     * Directly via constructor such as during object creation,
     * Or lazily by providing name to bucket object,
     * Or by listing objects in a bucket.
     */
    private function assertStorageObjectExists($bucket, $object, $options = [], $isPresent = true)
    {
        // validate provided object exists
        $this->assertEquals($isPresent, $object->exists($options));
        // validate object returned from $bucket->object() exists
        $object = $bucket->object($object->name(), $options);
        $this->assertEquals($isPresent, $object->exists($options));
        // validate object exists in $bucket->objects() exists
        $objects = $bucket->objects($options);
        $objects = array_map(function ($o) {
            return $o->name();
        }, iterator_to_array($objects));
        $this->assertEquals($isPresent, in_array($object->name(), $objects));
    }

    private function assertStorageObjectNotExists($bucket, $object, $options = [])
    {
        $this->assertStorageObjectExists($bucket, $object, $options, false);
    }
}
