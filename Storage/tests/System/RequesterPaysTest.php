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

use GuzzleHttp\Client;
use Google\Cloud\Storage\Acl;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Storage\StorageObject;
use GuzzleHttp\Exception\ClientException;

/**
 * @group storage
 * @group storage-requesterpays
 */
class RequesterPaysTest extends StorageTestCase
{
    private $keyFilePath;
    private $requesterPaysClient;
    private $requesterProject;
    private $user;

    private static $bucketName;
    private static $ownerBucketInstance;
    private static $object1;
    private static $object2;
    private static $content;
    private static $topic;
    private static $notificationId;
    private static $iamsetup = false;

    public static function setupBeforeClass()
    {
        parent::setupBeforeClass();

        $client = self::$client;

        self::$bucketName = uniqid(self::TESTING_PREFIX);
        self::$ownerBucketInstance = self::createBucket($client, self::$bucketName, [
            'billing' => ['requesterPays' => true]
        ]);

        self::$topic = self::$pubsubClient->createTopic(uniqid(self::TESTING_PREFIX));
        self::$deletionQueue->add(self::$topic);

        self::$content = uniqid(self::TESTING_PREFIX);
        self::$object1 = self::$ownerBucketInstance->upload(self::$content, [
            'name' => uniqid(self::TESTING_PREFIX),
        ]);

        self::$object2 = self::$ownerBucketInstance->upload(self::$content, [
            'name' => uniqid(self::TESTING_PREFIX)
        ]);
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

        $parentKeyfile = json_decode(file_get_contents(getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH')), true);
        $keyfile = json_decode(file_get_contents($this->keyFilePath), true);
        $this->requesterProject = $keyfile['project_id'];

        if (!self::$iamsetup) {
            // set bucket policy
            $p = self::$ownerBucketInstance->iam()->policy();
            $p['bindings'][] = [
                'role' => 'roles/storage.admin',
                'members' => [
                    'serviceAccount:' . $keyfile['client_email']
                ]
            ];
            $p['bindings'][] = [
                'role' => 'roles/storage.objectAdmin',
                'members' => [
                    'serviceAccount:' . $keyfile['client_email']
                ]
            ];
            self::$ownerBucketInstance->iam()->setPolicy($p);

            // set topic policy
            $p = self::$topic->iam()->policy();
            $p['bindings'][] = [
                'role' => 'roles/pubsub.publisher',
                'members' => [
                    'serviceAccount:'. $parentKeyfile['project_id'] .'@gs-project-accounts.iam.gserviceaccount.com'
                ]
            ];
            self::$topic->iam()->setPolicy($p);

            self::$iamsetup = true;
        }
    }

    public function testBucketSettings()
    {
        // run an http request to call the object's public link and see what we get.
        $getBody = function($bucket, $object) {
            $guzzle = new Client;

            try {
                $uri = sprintf('https://storage.googleapis.com/%s/%s', $bucket, $object);
                $res = $guzzle->request('GET', $uri);
                return (string) $res->getBody();
            } catch (ClientException $e) {
                return null;
            }
        };

        $bucket = self::createBucket(self::$client, uniqid(self::TESTING_PREFIX));
        $object = $bucket->upload(self::$content, [
            'name' => uniqid(self::TESTING_PREFIX),
            'predefinedAcl' => 'publicRead',
            'metadata' => [
                'cacheControl' => 'private'
            ]
        ]);

        $this->assertEquals(self::$content, $getBody($bucket->name(), $object->name()));

        $bucket->update(['billing' => ['requesterPays' => true]]);
        $this->assertNull($getBody($bucket->name(), $object->name()));

        $bucket->update(['billing' => ['requesterPays' => false]]);
        $this->assertEquals(self::$content, $getBody($bucket->name(), $object->name()));
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

    /**
     * @dataProvider requesterPaysMethods
     */
    public function testRequesterPaysWithUserProject(callable $call)
    {
        $bucket = $this->requesterPaysClient->bucket(self::$bucketName, $this->requesterProject);
        $object = $bucket->object(self::$object1->name());

        $this->assertEquals($this->requesterProject, $object->identity()['userProject']);

        $call($bucket, $object);
    }

    public function requesterPaysMethods()
    {
        $keyfile = json_decode(file_get_contents(GOOGLE_CLOUD_WHITELIST_KEY_PATH), true);
        $user = $keyfile['client_email'];

        return [
            [
                function (Bucket $bucket) use ($user) {
                    $acl = $bucket->acl();
                    $acl->add('user-'. $user, Acl::ROLE_READER);
                }
            ], [
                function (Bucket $bucket) use ($user) {
                    $acl = $bucket->acl();
                    $item = $acl->get(['entity' => 'user-'. $user]);
                }
            ], [
                function (Bucket $bucket) use ($user) {
                    $acl = $bucket->acl();
                    $acl->update('user-'. $user, Acl::ROLE_OWNER);
                }
            ], [
                function (Bucket $bucket) use ($user) {
                    $acl = $bucket->acl();
                    $acl->delete('user-'. $user);
                }
            ], [
                function (Bucket $bucket) use ($user) {
                    $acl = $bucket->defaultAcl();
                    $acl->add('user-'. $user, Acl::ROLE_READER);
                }
            ], [
                function (Bucket $bucket) use ($user) {
                    $acl = $bucket->defaultAcl();
                    $item = $acl->get(['entity' => 'user-'. $user]);
                }
            ], [
                function (Bucket $bucket) use ($user) {
                    $acl = $bucket->defaultAcl();
                    $acl->update('user-'. $user, Acl::ROLE_OWNER);
                }
            ], [
                function (Bucket $bucket) use ($user) {
                    $acl = $bucket->defaultAcl();
                    $acl->delete('user-'. $user);
                }
            ], [
                function (Bucket $bucket) {
                    $bucket->exists();
                },
            ], [
                function (Bucket $bucket) {
                    $bucket->upload(self::$content, [
                        'name' => uniqid(self::TESTING_PREFIX)
                    ]);
                },
            ], [
                function (Bucket $bucket) {
                    $bucket->getResumableUploader(self::$content, [
                        'name' => uniqid(self::TESTING_PREFIX)
                    ])->upload();
                },
            ], [
                function (Bucket $bucket) {
                    $bucket->getStreamableUploader(self::$content, [
                        'name' => uniqid(self::TESTING_PREFIX)
                    ])->upload();
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
                function (Bucket $bucket) {
                    self::$notificationId = $bucket->createNotification(self::$topic)->info()['id'];
                }
            ], [
                function (Bucket $bucket) {
                    $bucket->notifications()->current();
                }
            ], [
                function (Bucket $bucket) {
                    $bucket->notification(self::$notificationId)->reload();
                }
            ], [
                function (Bucket $bucket, StorageObject $object) use ($user) {
                    $acl = $object->acl();
                    $acl->add('user-'. $user, Acl::ROLE_READER);
                }
            ], [
                function (Bucket $bucket, StorageObject $object) use ($user) {
                    $acl = $object->acl();
                    $item = $acl->get(['entity' => 'user-'. $user]);
                }
            ], [
                function (Bucket $bucket, StorageObject $object) use ($user) {
                    $acl = $object->acl();
                    $acl->update('user-'. $user, Acl::ROLE_OWNER);
                }
            ], [
                function (Bucket $bucket, StorageObject $object) use ($user) {
                    $acl = $object->acl();
                    $acl->delete('user-'. $user);
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
                    $p = $bucket->iam()->policy();
                    $bucket->iam()->setPolicy($p);
                }
            ], [
                function (Bucket $bucket, StorageObject $object) {
                    $bucket->iam()->testPermissions(['storage.objects.create', 'storage.objects.delete']);
                }
            ], [
                function (Bucket $bucket, StorageObject $object) {
                    $bucket->iam()->reload();
                }
            ]
        ];
    }

    public function testDeleteNotification()
    {
        $bucket = $this->requesterPaysClient->bucket(self::$bucketName, $this->requesterProject);
        $bucket->notification(self::$notificationId)->delete();

        // test that the userProject is right through the object (since no access on bucket).
        $object = $bucket->object(self::$object1->name());
        $this->assertEquals($this->requesterProject, $object->identity()['userProject']);
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\BadRequestException
     */
    public function testDeleteNotificationFails()
    {
        $bucket = $this->requesterPaysClient->bucket(self::$bucketName);
        $bucket->notification(self::$notificationId)->delete();
    }
}
