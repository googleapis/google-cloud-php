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
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * @group storage
 * @group storage-requester-pays
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

    public function testBucketSettings()
    {
        $bucketName = uniqid(self::TESTING_PREFIX);
        $objectName = uniqid(self::TESTING_PREFIX);
        $content = uniqid(self::TESTING_PREFIX);

        // run an http request to call the object's public link and see what we get.
        $getBody = function($bucket, $object) {
            $guzzle = new Client;

            try {
                $uri = 'https://storage.googleapis.com/%s/%s';
                $res = $guzzle->request('GET', sprintf($uri, $bucket, $object));
                return (string) $res->getBody();
            } catch (ClientException $e) {
                return null;
            }
        };

        $client = self::$client;
        $bucket = $client->createBucket($bucketName);
        $object = $bucket->upload($content, [
            'name' => $objectName,
            'predefinedAcl' => 'publicRead',
            'metadata' => [
                'cacheControl' => 'private'
            ]
        ]);
        $object = $bucket->object($objectName);

        self::$deletionQueue[] = $object;
        self::$deletionQueue[] = $bucket;

        $this->assertEquals($content, $getBody($bucketName, $objectName));

        $bucket->update(['billing' => ['requesterPays' => true]]);
        $this->assertNull($getBody($bucketName, $objectName));

        $bucket->update(['billing' => ['requesterPays' => false]]);
        $this->assertEquals($content, $getBody($bucketName, $objectName));
    }

    /**
     * @dataProvider requesterPaysMethods
     * @expectedException Google\Cloud\Core\Exception\BadRequestException
     */
    public function testRequesterPaysMethodsWithoutUserProject(callable $call)
    {
        $bucket = $this->requesterPaysClient->bucket(self::$bucketName);
        $object = $bucket->object(self::$object1->name());

        $call($bucket, $object);
    }

    public function requesterPaysMethods()
    {
        return [
            [
                function (Bucket $bucket) {
                    $bucket->exists();
                },
            ], [
                function (Bucket $bucket) {
                    $bucket->upload(
                        fopen(self::$path, 'r')
                    );
                },
            ], [
                function (Bucket $bucket) {
                    $bucket->getResumableUploader(
                        fopen(self::$path, 'r')
                    )->upload();
                },
            ], [
                function (Bucket $bucket) {
                    $bucket->getStreamableUploader(
                        fopen(self::$path, 'r')
                    )->upload();
                },
            ], [
                function (Bucket $bucket) {
                    iterator_to_array($bucket->objects());
                },
            ], [
                function (Bucket $bucket) {
                    $bucket->update([]);
                },
            ], [
                function (Bucket $bucket) {
                    $bucket->compose([self::$object1, self::$object2], uniqid(self::TESTING_PREFIX), [
                        'metadata' => ['contentType' => 'text/plain']
                    ]);
                },
            ], [
                function (Bucket $bucket) {
                    $bucket->reload();
                }
            ], [
                function (Bucket $bucket, StorageObject $object) {
                    $object->exists();
                }
            ], [
                function (Bucket $bucket, StorageObject $object) {
                    $object->update([]);
                }
            ], [
                function (Bucket $bucket, StorageObject $object) {
                    $object->copy($bucket);
                }
            ], [
                function (Bucket $bucket, StorageObject $object) {
                    $object->rewrite($bucket);
                }
            ], [
                function (Bucket $bucket, StorageObject $object) {
                    $object->downloadAsString();
                }
            ], [
                function (Bucket $bucket, StorageObject $object) {
                    $object->downloadToFile('php://temp');
                }
            ], [
                function (Bucket $bucket, StorageObject $object) {
                    $object->downloadAsStream();
                }
            ], [
                function (Bucket $bucket, StorageObject $object) {
                    $object->reload();
                }
            ], [
                function (Bucket $bucket, StorageObject $object) {
                    $bucket->iam()->policy();
                }
            ], [
                function (Bucket $bucket, StorageObject $object) {
                    $bucket->iam()->setPolicy([]);
                }
            ], [
                function (Bucket $bucket, StorageObject $object) {
                    $bucket->iam()->testPermissions(['foo']);
                }
            ], [
                function (Bucket $bucket, StorageObject $object) {
                    $bucket->iam()->reload();
                }
            ]
        ];
    }
}
