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

namespace Google\Cloud\Storage\Tests\System;

use GuzzleHttp\Client;
use Google\Cloud\Storage\Acl;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Storage\StorageObject;
use GuzzleHttp\Exception\ClientException;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group storage
 * @group storage-requesterpays
 */
class RequesterPaysTest extends StorageTestCase
{
    use ExpectException;

    private static $requesterKeyFile;
    private static $requesterProject;
    private static $requesterEmail;
    private static $ownerKeyFile;
    private static $ownerEmail;
    private static $ownerProject;

    private static $requesterClient;
    private static $bucketName;
    private static $ownerBucketInstance;
    private static $object1;
    private static $object2;
    private static $content;
    private static $topic;
    private static $notificationId;

    public static function set_up_before_class()
    {
        parent::set_up_before_class();

        $requesterKeyFilePath = getenv('GOOGLE_CLOUD_PHP_WHITELIST_TESTS_KEY_PATH');
        $ownerKeyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
        self::$requesterKeyFile = json_decode(file_get_contents($requesterKeyFilePath), true);
        self::$requesterEmail = self::$requesterKeyFile['client_email'];
        self::$requesterProject = self::$requesterKeyFile['project_id'];
        self::$ownerKeyFile = json_decode(file_get_contents($ownerKeyFilePath), true);
        self::$ownerEmail = self::$ownerKeyFile['client_email'];
        self::$bucketName = uniqid(self::TESTING_PREFIX);
        $client = self::$client;

        // Owner bucket instance is a bucket class with requester pays turned on
        // and authenticated with the credentials of the user owning the bucket.
        self::$ownerBucketInstance = self::createBucket($client, self::$bucketName, [
            'billing' => ['requesterPays' => true]
        ]);

        self::$requesterClient = new StorageClient([
            'keyFile' => self::$requesterKeyFile
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

        // set bucket policy
        $p = self::$ownerBucketInstance->iam()->policy();
        $p['bindings'][] = [
            'role' => 'roles/storage.admin',
            'members' => [
                'serviceAccount:' . self::$requesterEmail,
                'serviceAccount:'. self::$ownerEmail
            ]
        ];
        $p['bindings'][] = [
            'role' => 'roles/storage.objectAdmin',
            'members' => [
                'serviceAccount:' . self::$requesterEmail,
                'serviceAccount:'. self::$ownerEmail
            ]
        ];
        self::$ownerBucketInstance->iam()->setPolicy($p);

        // set topic policy
        $p = self::$topic->iam()->policy();
        $p['bindings'][] = [
            'role' => 'roles/pubsub.publisher',
            'members' => [
                'serviceAccount:' . $client->getServiceAccount()
            ]
        ];
        self::$topic->iam()->setPolicy($p);
    }

    public function testBucketSettings()
    {
        // run an http request to call the object's public link and see what we get.
        $getBody = function ($bucket, $object) {
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
     */
    public function testRequesterPaysMethodsWithoutUserProject(callable $call)
    {
        $this->expectException('Google\Cloud\Core\Exception\BadRequestException');

        $bucket = self::$requesterClient->bucket(self::$bucketName);
        $object = $bucket->object(self::$object1->name());

        $call($bucket, $object);
    }

    /**
     * @dataProvider requesterPaysMethods
     */
    public function testRequesterPaysMethodsWithUserProject(callable $call)
    {
        $bucket = self::$requesterClient->bucket(self::$bucketName, true);
        $object = $bucket->object(self::$object1->name());

        $this->assertEquals(self::$requesterProject, $object->identity()['userProject']);

        $call($bucket, $object);
    }

    public function requesterPaysMethods()
    {
        $this->setup();

        return [
            'add-acl' => [
                function (Bucket $bucket) {
                    $acl = $bucket->acl();
                    $acl->add('user-'. self::$requesterEmail, Acl::ROLE_READER);
                }
            ],
            'get-acl' => [
                function (Bucket $bucket) {
                    $acl = $bucket->acl();
                    $item = $acl->get(['entity' => 'user-'. self::$requesterEmail]);
                }
            ],
            'update-acl' => [
                function (Bucket $bucket) {
                    $acl = $bucket->acl();
                    $acl->update('user-'. self::$requesterEmail, Acl::ROLE_OWNER);
                }
            ],
            'delete-acl' => [
                function (Bucket $bucket) {
                    $acl = $bucket->acl();
                    $acl->delete('user-'. self::$requesterEmail);
                }
            ],
            'add-default-acl' => [
                function (Bucket $bucket) {
                    $acl = $bucket->defaultAcl();
                    $acl->add('user-'. self::$requesterEmail, Acl::ROLE_READER);
                }
            ],
            'get-default-acl' => [
                function (Bucket $bucket) {
                    $acl = $bucket->defaultAcl();
                    $item = $acl->get(['entity' => 'user-'. self::$requesterEmail]);
                }
            ],
            'update-default-acl' => [
                function (Bucket $bucket) {
                    $acl = $bucket->defaultAcl();
                    $acl->update('user-'. self::$requesterEmail, Acl::ROLE_OWNER);
                }
            ],
            'delete-default-acl' => [
                function (Bucket $bucket) {
                    $acl = $bucket->defaultAcl();
                    $acl->delete('user-'. self::$requesterEmail);
                }
            ],
            'bucket-exists' => [
                function (Bucket $bucket) {
                    $bucket->exists();
                },
            ],
            'bucket-upload' => [
                function (Bucket $bucket) {
                    $bucket->upload(self::$content, [
                        'name' => uniqid(self::TESTING_PREFIX)
                    ]);
                },
            ],
            'bucket-objects' => [
                function (Bucket $bucket) {
                    iterator_to_array($bucket->objects());
                },
            ],
            'bucket-update' => [
                function (Bucket $bucket) {
                    $bucket->update([]);
                },
            ],
            'bucket-compose' => [
                function (Bucket $bucket) {
                    $bucket->compose([self::$object1, self::$object2], uniqid(self::TESTING_PREFIX), [
                        'metadata' => ['contentType' => 'text/plain']
                    ]);
                },
            ],
            'bucket-reload' => [
                function (Bucket $bucket) {
                    $bucket->reload();
                }
            ],
            'notification-create' => [
                function (Bucket $bucket) {
                    self::$notificationId = $bucket->createNotification(self::$topic)->info()['id'];
                }
            ],
            'notification-get' => [
                function (Bucket $bucket) {
                    $bucket->notifications()->current();
                }
            ],
            'notification-reload' => [
                function (Bucket $bucket) {
                    $bucket->notification(self::$notificationId)->reload();
                }
            ],
            'object-acl-add' => [
                function (Bucket $bucket, StorageObject $object) {
                    $acl = $object->acl();
                    $acl->add('user-'. self::$requesterEmail, Acl::ROLE_READER);
                }
            ],
            'object-acl-get' => [
                function (Bucket $bucket, StorageObject $object) {
                    $acl = $object->acl();
                    $item = $acl->get(['entity' => 'user-'. self::$requesterEmail]);
                }
            ],
            'object-acl-update' => [
                function (Bucket $bucket, StorageObject $object) {
                    $acl = $object->acl();
                    $acl->update('user-'. self::$requesterEmail, Acl::ROLE_OWNER);
                }
            ],
            'object-acl-delete' => [
                function (Bucket $bucket, StorageObject $object) {
                    $acl = $object->acl();
                    $acl->delete('user-'. self::$requesterEmail);
                }
            ],
            'object-exists' => [
                function (Bucket $bucket, StorageObject $object) {
                    $object->exists();
                }
            ],
            'object-update' => [
                function (Bucket $bucket, StorageObject $object) {
                    $object->update([]);
                }
            ],
            'object-copy' => [
                function (Bucket $bucket, StorageObject $object) {
                    $object->copy($bucket);
                }
            ],
            'object-rewrite' => [
                function (Bucket $bucket, StorageObject $object) {
                    $object->rewrite($bucket);
                }
            ],
            'object-download-string' => [
                function (Bucket $bucket, StorageObject $object) {
                    $object->downloadAsString();
                }
            ],
            'object-download-file' => [
                function (Bucket $bucket, StorageObject $object) {
                    $object->downloadToFile('php://temp');
                }
            ],
            'object-download-stream' => [
                function (Bucket $bucket, StorageObject $object) {
                    $object->downloadAsStream();
                }
            ],
            'object-reload' => [
                function (Bucket $bucket, StorageObject $object) {
                    $object->reload();
                }
            ],
            'bucket-iam-get' => [
                function (Bucket $bucket, StorageObject $object) {
                    $bucket->iam()->policy();
                }
            ],
            'bucket-iam-set' => [
                function (Bucket $bucket, StorageObject $object) {
                    $p = $bucket->iam()->policy();
                    $bucket->iam()->setPolicy($p);
                }
            ],
            'bucket-iam-reload' => [
                function (Bucket $bucket, StorageObject $object) {
                    $bucket->iam()->reload();
                }
            ]
        ];
    }

    /**
     * @dataProvider uploadMethods
     */
    public function testUploadMethodsWithoutUserProject(callable $call)
    {
        $this->expectException('Google\Cloud\Core\Exception\GoogleException');

        $bucket = self::$requesterClient->bucket(self::$bucketName);
        $call($bucket);
    }

    /**
     * @dataProvider uploadMethods
     */
    public function testUploadMethodsWithUserProject(callable $call)
    {
        $bucket = self::$requesterClient->bucket(self::$bucketName, true);
        $call($bucket);
    }

    public function uploadMethods()
    {
        return [
            'resumable-upload' => [
                function (Bucket $bucket) {
                    $bucket->getResumableUploader(self::$content, [
                        'name' => uniqid(self::TESTING_PREFIX)
                    ])->upload();
                },
            ],
            'streamable-upload' => [
                function (Bucket $bucket) {
                    $bucket->getStreamableUploader(self::$content, [
                        'name' => uniqid(self::TESTING_PREFIX)
                    ])->upload();
                },
            ],
        ];
    }

    public function testDeleteNotification()
    {
        $bucket = self::$requesterClient->bucket(self::$bucketName, self::$requesterProject);
        $bucket->notification(self::$notificationId)->delete();

        // test that the userProject is right through the object (since no access on bucket).
        $object = $bucket->object(self::$object1->name());
        $this->assertEquals(self::$requesterProject, $object->identity()['userProject']);
    }

    public function testDeleteNotificationFails()
    {
        $this->expectException('Google\Cloud\Core\Exception\BadRequestException');

        $bucket = self::$requesterClient->bucket(self::$bucketName);
        $bucket->notification(self::$notificationId)->delete();
    }
}
