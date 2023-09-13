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

use Google\Cloud\Core\Exception\BadRequestException;
use GuzzleHttp\Psr7\Utils;

/**
 * @group storage
 * @group storage-upload
 */
class UploadObjectsTest extends StorageTestCase
{
    public function testUploadsObjectFromStringWithMetadata()
    {
        $data = 'somedata';
        $options = [
            'name' => uniqid(self::TESTING_PREFIX),
            'metadata' => [
                'metadata' => [
                    'location' => 'test'
                ]
            ]
        ];
        $object = self::$bucket->upload($data, $options);

        $this->assertEquals($options['name'], $object->name());
        $this->assertEquals(strlen($data), $object->info()['size']);
        $this->assertEquals($options['metadata']['metadata'], $object->info()['metadata']);
    }

    public function testUploadsObjectFromResource()
    {
        $path = __DIR__ . '/data/CloudPlatform_128px_Retina.png';
        $object = self::$bucket->upload(
            fopen($path, 'r')
        );

        $this->assertEquals('CloudPlatform_128px_Retina.png', $object->name());
        $this->assertEquals(filesize($path), $object->info()['size']);
    }

    public function testUploadsLargeObjectFromResource()
    {
        $path = __DIR__ . '/data/5mb.txt';
        $object = self::$bucket->upload(
            fopen($path, 'r')
        );

        $this->assertEquals('5mb.txt', $object->name());
        $this->assertEquals(filesize($path), $object->info()['size']);
    }

    public function testUploadsObjectFromStream()
    {
        $stream = Utils::streamFor('somedata');
        $options = ['name' => uniqid(self::TESTING_PREFIX)];
        $object = self::$bucket->upload($stream, $options);

        $this->assertEquals($options['name'], $object->name());
        $this->assertEquals($stream->getSize(), $object->info()['size']);
    }

    public function testUploadsObjectWithCustomerSuppliedEncryption()
    {
        $data = 'somedata';
        $key = base64_encode(openssl_random_pseudo_bytes(32));
        $sha = base64_encode(hash('SHA256', base64_decode($key), true));
        $options = [
            'name' => uniqid(self::TESTING_PREFIX),
            'encryptionKey' => $key
        ];

        $object = self::$bucket->upload($data, $options);

        $this->assertEquals($sha, $object->info()['customerEncryption']['keySha256']);
        $this->assertEquals(strlen($data), $object->info()['size']);
    }

    private $testFileSize = 0;
    private $totalStoredBytes = 0;

    public function testUploadsObjectWithProgressTracking()
    {
        $path = __DIR__ . '/data/5mb.txt';

        $this->testFileSize = filesize($path);

        $options = [
            // It's required to be in resumable upload if we want to track the progress with callback method.
            'resumable' => true,
            // 1MB; The upload progress will be done in chunks. The size must be in multiples of 262144 bytes.
            'chunkSize' => 1 * 1024 * 1024,
            'uploadProgressCallback' => array($this, 'onStoredFileChunk')
        ];

        $object = self::$bucket->upload(fopen($path, 'r'), $options);


        $this->assertEquals('5mb.txt', $object->name());
    }

    public function onStoredFileChunk($storedBytes)
    {
        $this->totalStoredBytes += $storedBytes;

        $this->assertGreaterThanOrEqual($this->totalStoredBytes, $this->testFileSize);

        if ($this->testFileSize == $this->totalStoredBytes) {
            $this->assertEquals(filesize(__DIR__ . '/data/5mb.txt'), $this->totalStoredBytes);
        }
    }

    public function testCrc32cChecksumFails()
    {
        $this->expectException(BadRequestException::class);

        $path = __DIR__ . '/data/5mb.txt';

        $crc32c = hash('crc32c', 'foobar', true);
        $badChecksum = base64_encode($crc32c);

        self::$bucket->upload($path, [
            'name' => uniqid(),
            'metadata' => [
                'crc32c' => $badChecksum
            ]
        ]);
    }
}
