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
}
