<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Tests\System\Storage;

use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Storage\StorageObject;

/**
 * @group storage
 * @group requester-pays
 */
class RequesterPaysTest extends StorageTestCase
{
    private $keyFilePath;
    private $requesterPaysClient;

    private static $bucketName;
    private static $ownerBucketInstance;
    private static $object1;
    private static $object2;

    private static $path = __DIR__ . '/../data/CloudPlatform_128px_Retina.png';

    public static function setupBeforeClass()
    {
        parent::setupBeforeClass();

        $client = self::$client;

        self::$bucketName = uniqid(self::TESTING_PREFIX);
        self::$ownerBucketInstance = $client->createBucket(self::$bucketName, [
            'billing' => ['requesterPays' => true]
        ]);

        self::$object1 = self::$ownerBucketInstance->upload(
            fopen(self::$path, 'r')
        );

        self::$object2 = self::$ownerBucketInstance->upload(
            fopen(self::$path, 'r')
        );

        self::$deletionQueue[] = self::$object1;
        self::$deletionQueue[] = self::$object2;
        self::$deletionQueue[] = self::$ownerBucketInstance;
    }

    public function setUp()
    {
        if (!defined('GOOGLE_CLOUD_WHITELIST_KEY_PATH')) {
            $this->markTestSkipped('Missing whitelist keyfile path for whitelist system tests.');
        }

        $this->keyFilePath = GOOGLE_CLOUD_WHITELIST_KEY_PATH;
        $this->requesterPaysClient = new StorageClient([
            'keyFilePath' => $this->keyFilePath
        ]);
    }

    /**
     * @dataProvider requesterPaysMethods
     * @expectedException Google\Cloud\Core\Exception\BadRequestException
     */
    public function testRequesterPaysMethodsWithoutUserProject($name, callable $call)
    {
        $bucket = $this->requesterPaysClient->bucket(self::$bucketName);
        $object = $bucket->object(self::$object1->name());

        $call($bucket, $object);
    }

    public function requesterPaysMethods()
    {
        return [
            [
                'Bucket -> Exists',
                function (Bucket $bucket) {
                    $bucket->exists();
                },
            ], [
                'Bucket -> Upload',
                function (Bucket $bucket) {
                    $bucket->upload(
                        fopen(self::$path, 'r')
                    );
                },
            ], [
                'Bucket -> GetResumableUploader',
                function (Bucket $bucket) {
                    $bucket->getResumableUploader(
                        fopen(self::$path, 'r')
                    )->upload();
                },
            ], [
                'Bucket -> GetStreamableUploader',
                function (Bucket $bucket) {
                    $bucket->getStreamableUploader(
                        fopen(self::$path, 'r')
                    )->upload();
                },
            ], [
                'Bucket -> Objects',
                function (Bucket $bucket) {
                    iterator_to_array($bucket->objects());
                },
            ], [
                'Update',
                function (Bucket $bucket) {
                    $bucket->update([]);
                },
            ], [
                'Bucket -> Compose',
                function (Bucket $bucket) {
                    $bucket->compose([self::$object1, self::$object2], uniqid(self::TESTING_PREFIX), [
                        'metadata' => ['contentType' => 'text/plain']
                    ]);
                },
            ], [
                'Bucket -> Reload',
                function (Bucket $bucket) {
                    $bucket->reload();
                }
            ], [
                'Object -> Exists',
                function (Bucket $bucket, StorageObject $object) {
                    $object->exists();
                }
            ], [
                'Object -> Update',
                function (Bucket $bucket, StorageObject $object) {
                    $object->update([]);
                }
            ], [
                'Object -> Copy',
                function (Bucket $bucket, StorageObject $object) {
                    $object->copy($bucket);
                }
            ], [
                'Object -> Rewrite',
                function (Bucket $bucket, StorageObject $object) {
                    $object->rewrite($bucket);
                }
            ], [
                'Object -> DownloadAsString',
                function (Bucket $bucket, StorageObject $object) {
                    $object->downloadAsString();
                }
            ], [
                'Object -> DownloadToFile',
                function (Bucket $bucket, StorageObject $object) {
                    $object->downloadToFile('/dev/null');
                }
            ], [
                'Object -> DownloadAsStream',
                function (Bucket $bucket, StorageObject $object) {
                    $object->downloadAsStream();
                }
            ], [
                'Object -> Reload',
                function (Bucket $bucket, StorageObject $object) {
                    $object->reload();
                }
            ], [
                'IAM -> Policy',
                function (Bucket $bucket, StorageObject $object) {
                    $bucket->iam()->policy();
                }
            ], [
                'IAM -> SetPolicy',
                function (Bucket $bucket, StorageObject $object) {
                    $bucket->iam()->setPolicy([]);
                }
            ], [
                'IAM -> TestPermissions',
                function (Bucket $bucket, StorageObject $object) {
                    $bucket->iam()->testPermissions(['foo']);
                }
            ], [
                'IAM -> Reload',
                function (Bucket $bucket, StorageObject $object) {
                    $bucket->iam()->reload();
                }
            ]
        ];
    }
}
