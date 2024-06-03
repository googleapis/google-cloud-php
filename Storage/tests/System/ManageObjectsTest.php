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

    public function testObjectExists()
    {
        $object = self::$bucket->upload(self::DATA, ['name' => uniqid(self::TESTING_PREFIX)]);
        $this->assertTrue($object->exists());
        $object->delete();
        $this->assertFalse($object->exists());
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
                'softDeletePolicy' => ['retentionDurationSeconds' => 8*24*60*60]
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

    public function testRotatesCustomerSuppliedEncrpytion()
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
