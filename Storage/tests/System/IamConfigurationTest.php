<?php
/**
 * Copyright 2019 Google LLC
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

use Google\Cloud\Storage\StorageObject;
use GuzzleHttp\Client;

/**
 * @group storage
 * @group storage-iamconfiguration
 */
class IamConfigurationTest extends StorageTestCase
{
    private $guzzle;

    public function setUp()
    {
        $this->guzzle = new Client;
    }

    public function testUniformBucketLevelAccess()
    {
        $bucket = self::createBucket(self::$client, uniqid(self::TESTING_PREFIX));
        $bucket->update($this->bucketConfig());

        $this->assertTrue($bucket->info()['iamConfiguration']['uniformBucketLevelAccess']['enabled']);

        $bucket->update($this->bucketConfig(false));

        $this->assertFalse($bucket->info()['iamConfiguration']['uniformBucketLevelAccess']['enabled']);
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\BadRequestException
     */
    public function testUniformBucketLevelAccessAclFails()
    {
        $bucket = self::createBucket(self::$client, uniqid(self::TESTING_PREFIX));
        $bucket->update($this->bucketConfig());

        $bucket->acl()->get();
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\BadRequestException
     */
    public function testObjectPolicyOnlyAclFails()
    {
        $bucket = self::createBucket(self::$client, uniqid(self::TESTING_PREFIX));

        $keyfile = json_decode(file_get_contents(getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH')), true);
        $client = $keyfile['client_email'];

        // Ensure that the bucket IAM policy grants permission to the current
        // user to get objects.
        $policy = $bucket->iam()->policy();

        $role = 'roles/storage.objects.get';
        $hasBinding = false;
        foreach ($policy['bindings'] as $key => $binding) {
            if ($binding['role'] === $role) {
                $policy['bindings'][$key]['members'][] = $client;
                $hasBinding = true;
                break;
            }
        }

        if (!$hasBinding) {
            $policy['bindings'][] = [
                'role' => $role,
                'members' => [
                    $client
                ]
            ];
        }

        $bucket->iam()->setPolicy($policy);

        $object = $bucket->upload('foobar', [
            'name' => 'test.txt'
        ]);

        $bucket->update($this->bucketConfig());

        $object->acl()->get();
    }

    public function testCreateBucketWithUniformBucketLevelAccessAndInsertObject()
    {
        $bucket = self::createBucket(self::$client, uniqid(self::TESTING_PREFIX), $this->bucketConfig());

        $object = $bucket->upload('foobar', [
            'name' => 'test.txt'
        ]);

        $this->assertInstanceOf(StorageObject::class, $object);
        $object->reload();
    }

    private function bucketConfig($enabled = true)
    {
        return [
            'iamConfiguration' => [
                'uniformBucketLevelAccess' => [
                    'enabled' => $enabled
                ]
            ]
        ];
    }
}
