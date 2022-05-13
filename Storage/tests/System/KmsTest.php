<?php
/**
 * Copyright 2018 Google Inc. All Rights Reserved.
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

use Google\Cloud\Core\Testing\System\KeyManager;
use Google\Cloud\Storage\StorageObject;
use Yoast\PHPUnitPolyfills\Polyfills\AssertStringContains;

/**
 * @group storage
 * @group storage-kms
 */
class KmsTest extends StorageTestCase
{
    use AssertStringContains;

    const DATA = 'data';
    const KEY_RING_ID = 'kms-kr';
    const CRYPTO_KEY_ID_1 = 'key1';
    const CRYPTO_KEY_ID_2 = 'key2';

    private static $keyName1;
    private static $keyName2;

    public static function set_up_before_class()
    {
        parent::set_up_before_class();

        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
        $encryption = new KeyManager(
            json_decode(file_get_contents($keyFilePath), true),
            self::$client->getServiceAccount(),
            self::getProjectId($keyFilePath)
        );

        list(self::$keyName1, self::$keyName2) = $encryption->getKeyNames(
            self::KEY_RING_ID,
            [self::CRYPTO_KEY_ID_1, self::CRYPTO_KEY_ID_2]
        );
    }

    public function testUpload()
    {
        $object = $this->upload();

        $this->assertStringContainsString(self::$keyName1, $object->info()['kmsKeyName']);
        $this->assertEquals(self::DATA, $object->downloadAsString());
    }

    public function testUploadWithDefaultKmsKeyNameOnBucket()
    {
        self::$bucket->update([
            'encryption' => [
                'defaultKmsKeyName' => self::$keyName1
            ]
        ]);

        $object = $this->upload(['metadata' => null]);

        $this->assertStringContainsString(self::$keyName1, $object->info()['kmsKeyName']);
        $this->assertEquals(self::DATA, $object->downloadAsString());

        // Reset default to none
        self::$bucket->update([
            'encryption' => null
        ]);

        $this->assertArrayNotHasKey('encryption', self::$bucket->info());
    }

    public function testUploadExplicitKmsKeyOverridesDefaultOnBucket()
    {
        self::$bucket->update([
            'encryption' => [
                'defaultKmsKeyName' => self::$keyName1
            ]
        ]);

        $object = $this->upload([
            'metadata' => [
                'kmsKeyName' => self::$keyName2
            ]
        ]);

        $this->assertStringContainsString(self::$keyName2, $object->info()['kmsKeyName']);
        $this->assertEquals(self::DATA, $object->downloadAsString());

        // Reset default to none
        self::$bucket->update([
            'encryption' => null
        ]);

        $this->assertArrayNotHasKey('encryption', self::$bucket->info());
    }

    public function testRotatesKmsKeys()
    {
        $object = $this->upload();
        $rewriteOptions = [
            'name' => uniqid(self::TESTING_PREFIX),
            'destinationKmsKeyName' => self::$keyName2
        ];
        $rewrittenObject = $object->rewrite(self::$bucket, $rewriteOptions);

        $this->assertStringContainsString(self::$keyName2, $rewrittenObject->info()['kmsKeyName']);
        $this->assertEquals(self::DATA, $rewrittenObject->downloadAsString());
    }

    public function testRotatesCustomerSuppliedEncrpytionToKms()
    {
        $key = base64_encode(openssl_random_pseudo_bytes(32));
        $object = $this->upload(['encryptionKey' => $key, 'metadata' => null]);
        $rewriteOptions = [
            'name' => uniqid(self::TESTING_PREFIX),
            'encryptionKey' => $key,
            'destinationKmsKeyName' => self::$keyName1
        ];
        $rewrittenObject = $object->rewrite(self::$bucket, $rewriteOptions);

        $this->assertStringContainsString(self::$keyName1, $rewrittenObject->info()['kmsKeyName']);
        $this->assertEquals(self::DATA, $rewrittenObject->downloadAsString());
    }

    public function testRotatesKmsToCustomerSuppliedEncrpytion()
    {
        $key = base64_encode(openssl_random_pseudo_bytes(32));
        $sha = base64_encode(hash('SHA256', base64_decode($key), true));
        $object = $this->upload([
            'metadata' => [
                'kmsKeyName' => self::$keyName1
            ]
        ]);
        $rewriteOptions = [
            'name' => uniqid(self::TESTING_PREFIX),
            'destinationEncryptionKey' => $key
        ];
        $rewrittenObject = $object->rewrite(self::$bucket, $rewriteOptions);

        $this->assertEquals($sha, $rewrittenObject->info()['customerEncryption']['keySha256']);
        $this->assertEquals(self::DATA, $rewrittenObject->downloadAsString());
    }

    /**
     * @param array $options
     * @return StorageObject
     */
    private function upload(array $options = [])
    {
        return self::$bucket->upload(self::DATA, $options + [
            'name' => uniqid(self::TESTING_PREFIX),
            'metadata' => [
                'kmsKeyName' => self::$keyName1
            ]
        ]);
    }
}
