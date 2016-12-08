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

use GuzzleHttp\Psr7;

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
        self::$deletionQueue[] = $object;

        $this->assertEquals($options['name'], $object->name());
        $this->assertEquals(strlen($data), $object->info()['size']);
        $this->assertEquals($options['metadata']['metadata'], $object->info()['metadata']);
    }

    public function testUploadsObjectFromResource()
    {
        $path = __DIR__ . '/../data/CloudPlatform_128px_Retina.png';
        $object = self::$bucket->upload(
            fopen($path, 'r')
        );
        self::$deletionQueue[] = $object;

        $this->assertEquals('CloudPlatform_128px_Retina.png', $object->name());
        $this->assertEquals(filesize($path), $object->info()['size']);
    }

    public function testUploadsLargeObjectFromResource()
    {
        $path = __DIR__ . '/../data/5mb.txt';
        $object = self::$bucket->upload(
            fopen($path, 'r')
        );
        self::$deletionQueue[] = $object;

        $this->assertEquals('5mb.txt', $object->name());
        $this->assertEquals(filesize($path), $object->info()['size']);
    }

    public function testUploadsObjectFromStream()
    {
        $stream = Psr7\stream_for('somedata');
        $options = ['name' => uniqid(self::TESTING_PREFIX)];
        $object = self::$bucket->upload($stream, $options);
        self::$deletionQueue[] = $object;

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
        self::$deletionQueue[] = $object;

        $this->assertEquals($sha, $object->info()['customerEncryption']['keySha256']);
        $this->assertEquals(strlen($data), $object->info()['size']);
    }
}
