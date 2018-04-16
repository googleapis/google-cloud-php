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

use Google\Cloud\Core\Exception\ConflictException;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Storage\StorageObject;
use GuzzleHttp\Psr7\Request;

/**
 * @group storage
 * @group storage-kms
 */
class KmsTest extends StorageTestCase
{
    const DATA = 'data';
    const KEY_RING_ID = 'kms-kr';
    const KEY_NAME_1 = 'key1';
    const KEY_NAME_2 = 'key2';

    private static $keyName1;
    private static $keyName2;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        list(self::$keyName1, self::$keyName2) = self::getKeyNames(
            self::KEY_RING_ID,
            self::KEY_NAME_1,
            self::KEY_NAME_2
        );
    }

    public function testUpload()
    {
        $object = $this->upload();

        $this->assertContains(self::$keyName1, $object->info()['kmsKeyName']);
        $this->assertEquals(self::DATA, $object->downloadAsString());
    }

    public function testUploadWithDefaultNameOnBucket()
    {
        self::$bucket->update([
            'encryption' => [
                'defaultKmsKeyName' => self::$keyName1
            ]
        ]);

        $object = $this->upload(['metadata' => null]);

        $this->assertContains(self::$keyName1, $object->info()['kmsKeyName']);
        $this->assertEquals(self::DATA, $object->downloadAsString());

        // Reset default to none
        self::$bucket->update([
            'encryption' => null
        ]);
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

        $this->assertContains(self::$keyName2, $object->info()['kmsKeyName']);
        $this->assertEquals(self::DATA, $object->downloadAsString());

        // Reset default to none
        self::$bucket->update([
            'encryption' => null
        ]);
    }

    public function testRotatesKmsKeys()
    {
        $object = $this->upload();
        $rewriteOptions = [
            'name' => uniqid(self::TESTING_PREFIX),
            'destinationKmsKeyName' => self::$keyName2
        ];
        $rewrittenObject = $object->rewrite(self::$bucket, $rewriteOptions);

        $this->assertContains(self::$keyName2, $rewrittenObject->info()['kmsKeyName']);
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

        $this->assertContains(self::$keyName1, $rewrittenObject->info()['kmsKeyName']);
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

    /**
     * A helper to get KMS keys and set correct permissions.
     *
     * @param string $keyRingId
     * @param string $cryptoKeyId1
     * @param string $cryptoKeyId2
     * @return array
     */
    private static function getKeyNames($keyRingId, $cryptoKeyId1, $cryptoKeyId2)
    {
        $keyNames = [];
        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
        $wrapper = new RequestWrapper([
            'keyFile' => json_decode(file_get_contents($keyFilePath), true),
            'scopes' => ['https://www.googleapis.com/auth/cloud-platform']
        ]);
        $projectId = self::getProjectId($keyFilePath);

        self::buildKeyRing($wrapper, $projectId, $keyRingId);
        $keyNames[] = self::getCryptoKeyName($wrapper, $projectId, $keyRingId, $cryptoKeyId1);
        $keyNames[] = self::getCryptoKeyName($wrapper, $projectId, $keyRingId, $cryptoKeyId2);

        return $keyNames;
    }

    /**
     * @param RequestWrapper $wrapper
     * @param string $projectId
     * @param string $keyRingId
     */
    private static function buildKeyRing(
        RequestWrapper $wrapper,
        $projectId,
        $keyRingId
    ) {
        try {
            $wrapper->send(
                new Request(
                    'POST',
                    sprintf(
                        'https://cloudkms.googleapis.com/v1/projects/%s/locations/global/keyRings?keyRingId=%s',
                        $projectId,
                        $keyRingId
                    )
                )
            );
        } catch (ConflictException $ex) {
            // If it already exists, great!
        }
    }

    /**
     * @param RequestWrapper $wrapper
     * @param string $projectId
     * @param string $keyRingId
     * @param string $cryptoKeyId
     * @return string
     */
    private static function getCryptoKeyName(
        RequestWrapper $wrapper,
        $projectId,
        $keyRingId,
        $cryptoKeyId
    ) {
        $name = null;

        try {
            $response = $wrapper->send(
                new Request(
                    'POST',
                    sprintf(
                        'https://cloudkms.googleapis.com/v1/projects/%s/locations/global/keyRings/%s/cryptoKeys?cryptoKeyId=%s',
                        $projectId,
                        $keyRingId,
                        $cryptoKeyId
                    ),
                    [],
                    json_encode(['purpose' => 'ENCRYPT_DECRYPT'])
                )
            );

            $name = json_decode((string) $response->getBody(), true)['name'];
        } catch (ConflictException $ex) {
            $name = sprintf(
                'projects/%s/locations/global/keyRings/%s/cryptoKeys/%s',
                $projectId,
                $keyRingId,
                $cryptoKeyId
            );
        }

        $policy = [
            'policy' => [
                'bindings' => [
                    [
                        'role' => 'roles/cloudkms.cryptoKeyEncrypterDecrypter',
                        'members' => [
                            "serviceAccount:$projectId@gs-project-accounts.iam.gserviceaccount.com"
                        ]
                    ]
                ]
            ]
        ];
        $wrapper->send(
            new Request(
                'POST',
                sprintf(
                    'https://cloudkms.googleapis.com/v1/projects/%s/locations/global/keyRings/%s/cryptoKeys/%s:setIamPolicy',
                    $projectId,
                    $keyRingId,
                    $cryptoKeyId
                ),
                [],
                json_encode($policy)
            )
        );

        return $name;
    }
}
