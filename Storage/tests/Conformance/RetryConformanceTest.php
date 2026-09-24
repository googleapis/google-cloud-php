<?php
/**
 * Copyright 2022 Google Inc.
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

namespace Google\Cloud\Storage\Tests\Conformance;

use Google\Cloud\Storage\StorageClient;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\SkippedTestError;
use Google\Auth\Credentials\InsecureCredentials;

/**
 * @group storage
 * @group storage-retry-conformance
 */
class RetryConformanceTest extends TestCase
{
    // Http client to interact with the test bench emulator
    private static $httpClient;

    private static $projectId = 'test';

    // The Cloud storage client
    private static $storageClient;

    private static $bucketPrefix = 'bucket-';

    private static $hmacKeyName = 'key-test';

    private static $objectPrefix = 'file-';

    private static $notificationPrefix = 'notif-';

    private static $cases = [];

    // Storage test bench URL. To be populated by an env variable.
    private static $emulatorUrl = 'http://localhost:9000';

    public static function set_up_before_class()
    {
        static $setup = false;
        if ($setup) {
            return;
        }

        $setup = true;
        if (getenv('STORAGE_EMULATOR_HOST')) {
            self::$emulatorUrl = getenv('STORAGE_EMULATOR_HOST');
        }

        self::$httpClient = new Client([
            'base_uri' => self::$emulatorUrl
        ]);
        self::$storageClient = new StorageClient([
            'apiEndpoint' => self::$emulatorUrl,
            'projectId' => self::$projectId,
            'credentialsFetcher' => new InsecureCredentials()
        ]);

        $data = json_decode(file_get_contents(__DIR__ . '/data/retry_tests.json'), true);
        $scenarios = $data['retryTests'];
        $methodInvocations = self::getMethodInvocationMapping();

        // create the permutations to be used for tests
        foreach ($scenarios as $scenario) {
            $scenarioId = $scenario['id'];
            $errorCases = $scenario['cases'];
            $methods = $scenario['methods'];
            $expectedSuccess = $scenario['expectSuccess'];
            $preconditionProvided = $scenario['preconditionProvided'];

            if (!isset(self::$cases[$scenarioId])) {
                self::$cases[$scenarioId] = [];
            }

            foreach ($errorCases as $row) {
                $instructions = $row['instructions'];
                foreach ($methods as $method) {
                    $methodName = $method['name'];
                    $methodGroup = isset($method['group']) ? $method['group'] : null;
                    $resources = $method['resources'];

                    if (array_key_exists($methodName, $methodInvocations)) {
                        foreach ($methodInvocations[$methodName] as $invocationIndex => $callable) {
                            self::$cases[$scenarioId][] = compact(
                                'methodName',
                                'methodGroup',
                                'instructions',
                                'resources',
                                'expectedSuccess',
                                'preconditionProvided',
                                'invocationIndex'
                            );
                        }
                    }
                }
            }
        }
    }

    public function casesProvider()
    {
        self::set_up_before_class();
        // These scenario IDs will be run.
        // Omit certain IDs for debugging or testing only
        // certain cases.
        $scenarios = [1, 2, 3, 4, 5, 6, 7, 8];

        $cases = [];

        foreach ($scenarios as $scenarioId) {
            $cases = array_merge($cases, self::$cases[$scenarioId]);
        }

        return $cases;
    }

    /**
     * This tests that when we supply a header range with a start byte
     * set, then the resulting stream is of the expected size.
     * The same is tested when the download is interrupted and resumed.
     */
    public function testDownloadAsStreamForStartBytesGiven()
    {
        $bucketName = uniqid(self::$bucketPrefix);
        $objectName = uniqid(self::$objectPrefix);
        $content = random_bytes(512 * 1024);
        $bucket = self::$storageClient->createBucket($bucketName);
        $object = $bucket->upload($content, ['name' => $objectName]);

        $options = [
            'restOptions' => [
                'headers' => [
                    'Range' => sprintf('bytes=%s-', 200 * 1024)
                ]
            ]
        ];

        $stream = $object->downloadAsStream($options);
        // since the object is 512K, and our Range header
        // requests start from 200K
        $this->assertEquals(312 * 1024, $stream->getSize());

        // Now lets test the same when the download is interrupted
        $caseId = $this->createRetryTestResource("storage.objects.get", ["return-broken-stream-after-256K"]);
        $options = [
            'restOptions' => [
                'headers' => [
                    'Range' => sprintf('bytes=%s-', 200 * 1024),
                    'x-retry-test-id' => $caseId
                ]
            ]
        ];
        $stream = $object->downloadAsStream($options);
        $this->assertEquals(312 * 1024, $stream->getSize());

        // Make sure the test case was used
        $this->assertTrue($this->checkCaseCompletion($caseId));

        // cleanup
        $object->delete();
        $bucket->delete();
    }

    /**
     * When the download is interrupted for a transcoded object,
     * the retry sends the whole object and the bytes header is not respected.
     * @see: https://cloud.google.com/storage/docs/transcoding
     */
    public function testDownloadAsStreamForTranscodedObj()
    {
        $bucketName = uniqid(self::$bucketPrefix);
        $objectName = uniqid(self::$objectPrefix).".txt.gz";
        $content = gzencode((string)random_bytes(512 * 1024));
        $bucket = self::$storageClient->createBucket($bucketName);
        $object = $bucket->upload($content, [
            'name' => $objectName,
            'metadata' => ['contentType' => 'text/plain','contentEncoding' => 'gzip']
        ]);

        $options = [
            'restOptions' => [
                'headers' => [
                    'Range' => sprintf('bytes=%s-', 200 * 1024)
                ]
            ]
        ];

        $stream = $object->downloadAsStream($options);
        // Even though our Range header specifies the starting
        // byte of 200K, but because the object is transcoded
        // the full object is returned
        $this->assertEquals(512 * 1024, $stream->getSize());

        // Now we test the same for an interrupted download
        $caseId = $this->createRetryTestResource("storage.objects.get", ["return-broken-stream-after-256K"]);
        $options = [
            'restOptions' => [
                'headers' => [
                    'Range' => sprintf('bytes=%s-', 200 * 1024),
                    'x-retry-test-id' => $caseId
                ]
            ]
        ];
        $stream = $object->downloadAsStream($options);
        $this->assertEquals(512 * 1024, $stream->getSize());

        // cleanup
        $object->delete();
        $bucket->delete();
    }


    /**
     * @dataProvider casesProvider
     * All the retry conformance cases are tested here.
     */
    public function testOps(
        $methodName,
        $methodGroup,
        $instructions,
        $resources,
        $expectedSuccess,
        $precondtionProvided,
        $invocationIndex
    ) {
        $caseId = $this->createRetryTestResource($methodName, $instructions, null);

        $methodInvocations = self::getMethodInvocationMapping();
        $callable = $methodInvocations[$methodName][$invocationIndex];

        if (!$expectedSuccess) {
            $this->expectException('Exception');
        }

        $options = [
            'restOptions' => [
                'headers' => [
                    'x-retry-test-id' => $caseId
                ]
            ]
        ];

        // create the resources needed for test to run
        $resourceIds = self::createResources(array_flip($resources), $methodGroup);

        // call the implementation
        try {
            call_user_func($callable, $resourceIds, $options, $precondtionProvided, $methodGroup);
            // if an exception was thrown, then this block would never reach
            if ($expectedSuccess) {
                $this->assertTrue(true);
            }
        } catch (SkippedTestError $e) {
            // Don't treat a skipped test as an exception.
            // For example we skip tests when the only precondition is Etags.
            $this->markTestSkipped($e->getMessage());
        }

        self::disposeResources($resourceIds);

        if (!$this->checkCaseCompletion($caseId)) {
            $this->fail(sprintf(
                'The test case didn\'t complete for %s(invocation: %d).',
                $methodName,
                $invocationIndex
            ));
        }
    }

    /**
     * Create a Retry Test Resource by sending a request to the testbench emulator.
     * @return string
     */
    private function createRetryTestResource(string $method, array $instruction)
    {
        $data = [
            'json' => ["instructions" => [
                $method => $instruction
            ]]
        ];
        $response = self::$httpClient->request('POST', 'retry_test', $data);

        $responseObj = json_decode($response->getBody()->getContents());
        return $responseObj->id;
    }

    /**
     * Helper method that checks if a test case resource has been completed or not.
     *
     * @param string $caseId The test case resource ID
     * @return boolean
     */
    private function checkCaseCompletion(string $caseId)
    {
        $response = self::$httpClient->request('GET', sprintf('retry_test/%s', $caseId));
        $obj = json_decode($response->getBody()->getContents());

        return $obj->completed;
    }

    /**
     * Lists the different ways of invocing an API.
     */
    private static function getMethodInvocationMapping()
    {
        return [
            'storage.bucket_acl.get' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $acl = $bucket->acl();

                    // this makes the storage.bucket_acl.get call
                    $options['entity'] = 'allUsers';
                    $acl->get($options);
                },
            ],
            'storage.bucket_acl.list' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $acl = $bucket->acl();

                    // this makes the storage.bucket_acl.list call
                    $acl->get($options);
                },
            ],
            'storage.buckets.delete' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $bucket->delete($options);
                },
            ],
            'storage.buckets.get' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $bucket->reload($options);
                },
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $exists = $bucket->exists($options);
                },
            ],
            'storage.buckets.getIamPolicy' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $iam = $bucket->iam();
                    $iam->reload($options);
                }
            ],
            'storage.buckets.insert' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = uniqid(self::$bucketPrefix);
                    $bucket = self::$storageClient->createBucket($bucketName, $options);
                    $name = $bucket->name();

                    $bucket->delete();
                },
            ],
            'storage.buckets.list' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];

                    $buckets = self::$storageClient->buckets($options);

                    // added this to trigger the API call
                    foreach ($buckets as $bucket) {
                    }
                },
            ],
            'storage.buckets.lockRetentionPolicy' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];
                    $bucket = self::$storageClient->bucket($bucketName);

                    $metageneration = $bucket->info()['metageneration'];
                    $options['IfMetagenerationMatch'] = $metageneration;
                    $bucket->lockRetentionPolicy($options);
                }
            ],
            'storage.buckets.testIamPermissions' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $iam = $bucket->iam();
                    $iam->testPermissions([], $options);
                }
            ],
            'storage.default_object_acl.get' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $acl = $bucket->defaultAcl();

                    $options['entity'] = 'allUsers';
                    $acl->get($options);
                }
            ],
            'storage.default_object_acl.list' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $acl = $bucket->defaultAcl();

                    $acl->get($options);
                }
            ],
            'storage.hmacKey.delete' => [
                function ($resourceIds, $options, $precondition = false) {
                    $accessId = $resourceIds['hmacKeyId'];

                    $key = self::$storageClient->hmacKey($accessId);
                    $key->update('INACTIVE');
                    $key->delete($options);
                }
            ],
            'storage.hmacKey.get' => [
                function ($resourceIds, $options, $precondition = false) {
                    $accessId = $resourceIds['hmacKeyId'];

                    $key = self::$storageClient->hmacKey($accessId);
                    $key->reload($options);
                }
            ],
            'storage.hmacKey.list' => [
                function ($resourceIds, $options, $precondition = false) {
                    $keys = self::$storageClient->hmacKeys($options);

                    // Added this to trigger the API call
                    foreach ($keys as $key) {
                    }
                }
            ],
            'storage.notifications.delete' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];
                    $notificationId = $resourceIds['notificationId'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $notification = $bucket->notification($notificationId);
                    $notification->delete($options);
                }
            ],
            'storage.notifications.get' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];
                    $notificationId = $resourceIds['notificationId'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $notification = $bucket->notification($notificationId);
                    $notification->reload($options);
                },
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];
                    $notificationId = $resourceIds['notificationId'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $notification = $bucket->notification($notificationId);
                    $notification->exists($options);
                }
            ],
            'storage.notifications.list' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];
                    $notificationId = $resourceIds['notificationId'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $notifs = $bucket->notifications($options);
                    // Added this to trigger the API call
                    foreach ($notifs as $notif) {
                    }
                }
            ],
            'storage.object_acl.get' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];
                    $objectName = $resourceIds['objectName'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $object = $bucket->object($objectName);
                    $acl = $object->acl();
                    $options['entity'] = 'allUsers';
                    if ($precondition) {
                        $options['ifGenerationMatch'] = $object->info()['generation'];
                    }
                    $acl->get($options);
                }
            ],
            'storage.object_acl.list' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];
                    $objectName = $resourceIds['objectName'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $object = $bucket->object($objectName);
                    $acl = $object->acl();
                    if ($precondition) {
                        $options['ifGenerationMatch'] = $object->info()['generation'];
                    }
                    $acl->get($options);
                }
            ],
            'storage.objects.get' => [
                function ($resourceIds, $options, $precondition = false, $methodGroup = null) {
                    if (!is_null($methodGroup)) {
                        self::markTestSkipped("Test only needs to run for resumable downloads");
                    }
                    $bucketName = $resourceIds['bucketName'];
                    $objectName = $resourceIds['objectName'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $object = $bucket->object($objectName);
                    $object->reload($options);
                },
                function ($resourceIds, $options, $precondition = false, $methodGroup = null) {
                    if (!is_null($methodGroup)) {
                        self::markTestSkipped("Test only needs to run for resumable downloads");
                    }
                    $bucketName = $resourceIds['bucketName'];
                    $objectName = $resourceIds['objectName'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $object = $bucket->object($objectName);
                    $object->exists($options);
                },
                function ($resourceIds, $options, $precondition = false, $methodGroup = null) {
                    if ($methodGroup !== 'storage.objects.download') {
                        self::markTestSkipped("Test only needs to run for getObject");
                    }
                    $bucketName = $resourceIds['bucketName'];
                    $objectName = $resourceIds['objectName'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $object = $bucket->object($objectName);
                    $object->downloadAsStream($options);
                },
                function ($resourceIds, $options, $precondition = false, $methodGroup = null) {
                    if ($methodGroup !== 'storage.objects.download') {
                        self::markTestSkipped("Test only needs to run for getObject");
                    }
                    $bucketName = $resourceIds['bucketName'];
                    $objectName = $resourceIds['objectName'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $object = $bucket->object($objectName);
                    $object->downloadAsString($options);
                },
                function ($resourceIds, $options, $precondition = false, $methodGroup = null) {
                    if ($methodGroup !== 'storage.objects.download') {
                        self::markTestSkipped("Test only needs to run for getObject");
                    }
                    $bucketName = $resourceIds['bucketName'];
                    $objectName = $resourceIds['objectName'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $object = $bucket->object($objectName);
                    $object->downloadToFile('php://temp', $options);
                }
            ],
            'storage.objects.list' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $objects = $bucket->objects($options);
                    // Added this to trigger the API call
                    foreach ($objects as $obj) {
                    }
                }
            ],
            'storage.serviceaccount.get' => [
                function ($resourceIds, $options, $precondition = false) {
                    self::$storageClient->getServiceAccount($options);
                }
            ],
            'storage.buckets.patch' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];

                    $options['labels'] = ['key' => 'value'];
                    $bucket = self::$storageClient->bucket($bucketName);

                    if ($precondition) {
                        $options['ifMetagenerationMatch'] = $bucket->info()['metageneration'];
                    }

                    $bucket->update($options);
                }
            ],
            'storage.buckets.setIamPolicy' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $iam = $bucket->iam();
                    $policy = $iam->policy();

                    $policy['bindings'][0]['members'] = ['user:test@test.com'];
                    $iam->setPolicy($policy, $options);

                    if ($precondition) {
                        self::markTestSkipped('Etag is currently not supported.');
                    }

                    $bucket->update($options);
                }
            ],
            'storage.buckets.update' => [
                // This isn't used in the library
            ],
            'storage.hmacKey.update' => [
                function ($resourceIds, $options, $precondition) {
                    $accessId = $resourceIds['hmacKeyId'];

                    $key = self::$storageClient->hmacKey($accessId);
                    if ($precondition) {
                        self::markTestSkipped('Etag is currently not supported.');
                    }
                    $key->update('INACTIVE', $options);
                }
            ],
            'storage.objects.compose' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];
                    $ob1Name = $resourceIds['objectName'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $obj1 = $bucket->object($ob1Name);
                    $obj2 = $bucket->upload("line2", ["name" => "file2.txt"]);
                    $obj3 = $bucket->upload("test", ["name" => "combined.txt"]);

                    $sourceObjects = [$ob1Name, 'file2.txt'];
                    if ($precondition) {
                        $options['ifGenerationMatch'] = $obj3->info()['generation'];
                    }
                    $bucket->compose($sourceObjects, 'combined.txt', $options);

                    $obj2->delete();
                    // We can't use $obj3 as it has changed,
                    // so we need to request the file again
                    $bucket->object('combined.txt')->delete();
                }
            ],
            'storage.objects.copy' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];
                    $objectName = $resourceIds['objectName'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $object = $bucket->object($objectName);
                    $copy = $bucket->upload("copy", ["name" => "copy.txt"]);
                    $options['name'] = 'copy.txt';
                    if ($precondition) {
                        $options['ifGenerationMatch'] = $copy->info()['generation'];
                    }
                    $object->copy($bucketName, $options);

                    // We can't use $copy as it has been copied over,
                    // so we need to request the file again
                    $bucket->object('copy.txt')->delete();
                }
            ],
            'storage.objects.delete' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];
                    $objectName = $resourceIds['objectName'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $object = $bucket->object($objectName);

                    if ($precondition) {
                        $options['ifGenerationMatch'] = $object->info()['generation'];
                    }

                    $object->delete($options);
                }
            ],
            'storage.objects.insert' => [
                function ($resourceIds, $options, $precondition = false, $methodGroup = null) {
                    if (!is_null($methodGroup)) {
                        self::markTestSkipped("Test only needs to run for resumable uploads");
                    }
                    $bucketName = $resourceIds['bucketName'];
                    $bucket = self::$storageClient->bucket($bucketName);

                    if ($precondition) {
                        // 0 generation for a new file
                        $options['ifGenerationMatch'] = 0;
                    }

                    $options['name'] = 'file.txt';
                    $object = $bucket->upload('text', $options);

                    $object->delete();
                },
                function ($resourceIds, $options, $precondition = false, $methodGroup = null) {
                    if (!is_null($methodGroup)) {
                        self::markTestSkipped("Test only needs to run for resumable uploads");
                    }
                    $bucketName = $resourceIds['bucketName'];
                    $bucket = self::$storageClient->bucket($bucketName);

                    if ($precondition) {
                        // 0 generation for a new file
                        $options['ifGenerationMatch'] = 0;
                    }

                    $options['name'] = 'file.txt';
                    $promise = $bucket->uploadAsync('text', $options);
                    $object = $promise->wait();

                    $object->delete();
                },
                function ($resourceIds, $options, $precondition = false, $methodGroup = null) {
                    if ($methodGroup !== "storage.resumable.upload") {
                        self::markTestSkipped("Test only needs to run for normal uploads");
                    }
                    $bucketName = $resourceIds['bucketName'];
                    $bucket = self::$storageClient->bucket($bucketName);

                    $options['name'] = 'file.txt';
                    $options['resumable'] = true;
                    $options['chunkSize'] = 512 * 1024;
                    if ($precondition) {
                        $options['ifGenerationMatch'] = 0;
                    }
                    $bucket->upload(random_bytes(16 * 1024 * 1024), $options);

                    $bucket->object('file.txt')->delete();
                }
            ],
            'storage.objects.patch' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];
                    $objectName = $resourceIds['objectName'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $object = $bucket->object($objectName);
                    if ($precondition) {
                        $options['ifMetagenerationMatch'] = $object->info()['metageneration'];
                    }

                    $object->update(['name' => 'updated.txt'], $options);
                    $object->delete();
                }
            ],
            'storage.objects.rewrite' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];
                    $objectName = $resourceIds['objectName'];

                    $bucket = self::$storageClient->bucket($bucketName);
                    $object = $bucket->object($objectName);
                    if ($precondition) {
                        $options['ifGenerationMatch'] = 0;
                    }

                    $options['name'] = 'updated-file.txt';
                    $object->rewrite($bucket, $options);

                    $bucket->object('updated-file.txt')->delete();
                }
            ],
            'storage.objects.update' => [
                // This isn't used in the library
            ],
            'storage.bucket_acl.delete' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];
                    $bucket = self::$storageClient->bucket($bucketName);

                    $acl = $bucket->acl();
                    $list = $acl->get();
                    $entity = $list[0]['entity'];
                    $acl->delete($entity, $options);
                }
            ],
            'storage.bucket_acl.insert' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];
                    $bucket = self::$storageClient->bucket($bucketName);

                    $acl = $bucket->acl();
                    $aclList = $acl->get();
                    $entity = $aclList[0]['entity'];
                    $acl->add($entity, 'WRITER', $options);
                }
            ],
            'storage.bucket_acl.patch' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];
                    $bucket = self::$storageClient->bucket($bucketName);

                    $acl = $bucket->acl();
                    $aclList = $acl->get();
                    $entity = $aclList[0]['entity'];
                    $acl->update($entity, 'READER', $options);
                }
            ],
            'storage.bucket_acl.update' => [
                // This isn't used in the library
            ],
            'storage.default_object_acl.delete' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];
                    $bucket = self::$storageClient->bucket($bucketName);

                    $acl = $bucket->defaultAcl();
                    $aclList = $acl->get();
                    $entity = $aclList[0]['entity'];
                    $acl->delete($entity, $options);
                }
            ],
            'storage.default_object_acl.insert' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];
                    $bucket = self::$storageClient->bucket($bucketName);

                    $acl = $bucket->defaultAcl();
                    $acl->add('allAuthenticatedUsers', 'OWNER', $options);
                }
            ],
            'storage.default_object_acl.patch' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];
                    $bucket = self::$storageClient->bucket($bucketName);

                    $acl = $bucket->defaultAcl();
                    $aclList = $acl->get();
                    $entity = $aclList[0]['entity'];
                    $acl->update($entity, 'READER', $options);
                }
            ],
            'storage.default_object_acl.update' => [
                // This isn't used in the library
            ],
            'storage.hmacKey.create' => [
                function ($resourceIds, $options, $precondition = false) {
                    $options['projectId'] = 'test';
                    self::$storageClient->createHmacKey('temp@test.iam.gserviceaccount.com', $options);
                }
            ],
            'storage.notifications.insert' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];
                    $bucket = self::$storageClient->bucket($bucketName);

                    $notification = $bucket->createNotification('testNotif', $options);

                    $notification->delete();
                }
            ],
            'storage.object_acl.delete' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];
                    $objectName = $resourceIds['objectName'];
                    $bucket = self::$storageClient->bucket($bucketName);
                    $object = $bucket->object($objectName);

                    $acl = $object->acl();
                    $aclList = $acl->get();
                    $entity = $aclList[0]['entity'];
                    $role = $aclList[0]['role'];
                    $acl->delete($entity, $options);
                }
            ],
            'storage.object_acl.insert' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];
                    $objectName = $resourceIds['objectName'];
                    $bucket = self::$storageClient->bucket($bucketName);
                    $object = $bucket->object($objectName);

                    $acl = $object->acl();
                    $aclList = $acl->get();
                    $entity = $aclList[0]['entity'];
                    $acl->add($entity, 'READER', $options);
                }
            ],
            'storage.object_acl.patch' => [
                function ($resourceIds, $options, $precondition = false) {
                    $bucketName = $resourceIds['bucketName'];
                    $objectName = $resourceIds['objectName'];
                    $bucket = self::$storageClient->bucket($bucketName);
                    $object = $bucket->object($objectName);

                    $acl = $object->acl();
                    $aclList = $acl->get();
                    $entity = $aclList[0]['entity'];
                    $role = $aclList[0]['role'];
                    $acl->update($entity, 'READER', $options);
                }
            ],
            'storage.object_acl.update' => [
                // This isn't used in the library
            ]
        ];
    }

    /**
     * Helper function to create the resources needed by a test.
     *
     * @param $resources array List of resources to create.
     * @param $methodGroup string|null The group that the current
     *        testing operation belongs to. This can be null
     *
     * @return array The ids of resources created(where applicable).
     */
    private function createResources(array $resources, $methodGroup)
    {
        $ids = [];

        // add a bucket if needed
        if (isset($resources['BUCKET'])) {
            $bucketName = uniqid(self::$bucketPrefix);
            $bucket = self::$storageClient->createBucket($bucketName);
            $ids['bucketName'] = $bucketName;

            // add the ACL roles
            $acl = $bucket->acl();
            $acl->add('allUsers', 'READER');
            $acl->add('allAuthenticatedUsers', 'READER');

            // Add the default ACL roles
            $acl = $bucket->defaultAcl();
            $acl->add('allUsers', 'READER');
            $acl->add('allAuthenticatedUsers', 'READER');

            // Create a notification for the bucket
            $notifName = uniqid(self::$notificationPrefix);
            $notification = $bucket->createNotification($notifName);
            $ids['notificationId'] = $notification->id();

            // Create an object if needed
            if (isset($resources['OBJECT'])) {
                $objectName = uniqid(self::$objectPrefix);
                $content = ($methodGroup === 'storage.objects.download') ? random_bytes(10 * 1024 * 1024) : 'file text';
                $object = $bucket->upload($content, ['name' => $objectName]);
                $ids['objectName'] = $objectName;

                // Create object ACL
                $acl = $object->acl();
                $acl->add('allUsers', 'READER');
                $acl->add('allAuthenticatedUsers', 'READER');
            }
        }

        // Create an HMAC KEY if needed.
        if (isset($resources['HMAC_KEY'])) {
            $keyEmail = sprintf('%s@%s.iam.gserviceaccount.com', self::$hmacKeyName, self::$projectId);
            $response = self::$storageClient->createHmacKey($keyEmail);
            $key = $response->hmacKey();
            $ids['hmacKeyId'] = $key->accessId();
        }

        return $ids;
    }

    /**
     * Helper function to dispose off the resources after a test has been performed.
     *
     * @param $list array The ids of the resources to destroy.
     */
    private static function disposeResources(array $ids)
    {
        if (isset($ids['bucketName'])) {
            $bucket = self::$storageClient->bucket($ids['bucketName']);
            if ($bucket->exists()) {
                // delete the notifications if we created any
                if (isset($ids['notificationId'])) {
                    $notification = $bucket->notification($ids['notificationId']);
                    if ($notification->exists()) {
                        $notification->delete();
                    }
                }

                if (isset($ids['objectName'])) {
                    $object = $bucket->object($ids['objectName']);

                    if ($object->exists()) {
                        // delete the object
                        $object->delete();
                    }
                }

                // finally delete the bucket
                $bucket->delete();
            }
        }

        // Dispose the hmac key if requested
        if (isset($ids['hmacKeyId'])) {
            $key = self::$storageClient->hmacKey($ids['hmacKeyId']);
            try {
                $key->update('INACTIVE');
                $key->delete();
            } catch (\Exception $e) {
                // This might be thrown for a deleted key,
                // for example in storage.hmacKey.delete.
                // We don't have an exists method on the HmackKey class.
            }
        }
    }
}
