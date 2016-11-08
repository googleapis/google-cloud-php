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

namespace Google\Cloud\Tests\System\Storage;

use Psr\Http\Message\StreamInterface;

class ManageObjectsTest extends StorageTestCase
{
    public function testListsObjects()
    {
        $foundObjects = [];
        $objectsToCreate = [
            uniqid(self::TESTING_PREFIX),
            uniqid(self::TESTING_PREFIX)
        ];

        foreach ($objectsToCreate as $objectToCreate) {
            self::$deletionQueue[] = self::$bucket->upload('somedata', ['name' => $objectToCreate]);
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

    public function testObjectExists()
    {
        $object = self::$bucket->upload('somedata', ['name' => uniqid(self::TESTING_PREFIX)]);
        $this->assertTrue($object->exists());
        $object->delete();
        $this->assertFalse($object->exists());
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
        self::$deletionQueue[] = $object;
        $expectedContent = $object->downloadAsString();
        $expectedContent .= self::$object->downloadAsString();
        $name = uniqid(self::TESTING_PREFIX) . '.txt';
        $composedObject = self::$bucket->compose(
            [$object, self::$object],
            $name
        );
        self::$deletionQueue[] = $composedObject;

        $this->assertEquals($name, $composedObject->name());
        $this->assertEquals($expectedContent, $composedObject->downloadAsString());
    }

    public function testRotatesCustomerSuppliedEncrpytion()
    {
        $data = 'somedata';
        $key = openssl_random_pseudo_bytes(32);
        $sha = hash('SHA256', $key, true);
        $options = [
            'name' => uniqid(self::TESTING_PREFIX),
            'encryptionKey' => $key,
            'encryptionKeySHA256' => $sha
        ];
        $object = self::$bucket->upload($data, $options);
        self::$deletionQueue[] = $object;

        $dkey = openssl_random_pseudo_bytes(32);
        $dsha = hash('SHA256', $dkey, true);
        $rewriteOptions = [
            'name' => uniqid(self::TESTING_PREFIX),
            'encryptionKey' => $key,
            'encryptionKeySHA256' => $sha,
            'destinationEncryptionKey' => $dkey,
            'destinationEncryptionKeySHA256' => $dsha
        ];

        $rewrittenObject = $object->rewrite(self::$bucket, $rewriteOptions);

        $this->assertEquals(base64_encode($dsha), $rewrittenObject->info()['customerEncryption']['keySha256']);
        $rewrittenObject->delete();
    }

    public function testDownloadsAsString()
    {
        $content = self::$object->downloadAsString();

        $this->assertTrue(is_string($content));
    }

    public function testDownloadsAsStream()
    {
        $content = self::$object->downloadAsStream();

        $this->assertInstanceOf(StreamInterface::class, $content);
    }

    public function testDownloadsToFile()
    {
        $contents = self::$object->downloadAsString();
        $stream = self::$object->downloadToFile('php://temp');

        $this->assertEquals($contents, (string) $stream);
    }

    public function testReloadObject()
    {
        $this->assertEquals('storage#object', self::$object->reload()['kind']);
    }
}
