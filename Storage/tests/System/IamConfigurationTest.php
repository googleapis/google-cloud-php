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

use Google\Cloud\Core\Exception\BadRequestException;
use Google\Cloud\Storage\StorageObject;

/**
 * @group storage
 * @group storage-iamconfiguration
 */
class IamConfigurationTest extends StorageTestCase
{
    public function testUniformBucketLevelAccess()
    {
        $bucket = self::createBucket(self::$client, uniqid(self::TESTING_PREFIX));
        $bucket->update($this->ublaConfig());

        $this->assertTrue($bucket->info()['iamConfiguration']['uniformBucketLevelAccess']['enabled']);

        $bucket->update($this->ublaConfig(false));

        $this->assertFalse($bucket->info()['iamConfiguration']['uniformBucketLevelAccess']['enabled']);
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\BadRequestException
     */
    public function testUniformBucketLevelAccessAclFails()
    {
        $bucket = self::createBucket(self::$client, uniqid(self::TESTING_PREFIX));
        $bucket->update($this->ublaConfig());

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

        $bucket->update($this->ublaConfig());

        $object->acl()->get();
    }

    public function testCreateBucketWithUniformBucketLevelAccessAndInsertObject()
    {
        $bucket = self::createBucket(self::$client, uniqid(self::TESTING_PREFIX), $this->ublaConfig());

        $object = $bucket->upload('foobar', [
            'name' => 'test.txt'
        ]);

        $this->assertInstanceOf(StorageObject::class, $object);
        $object->reload();
    }

    /**
     * @dataProvider publicAccessSetting
     */
    public function testTogglePublicAccessPrevention($enableInitially)
    {
        $expected = function ($enabled) {
            return $enabled ? 'enforced' : 'unspecified';
        };

        $bucket = self::createBucket(
            self::$client,
            uniqid(self::TESTING_PREFIX),
            $this->papConfig($enableInitially)
        );

        $this->assertEquals(
            $expected($enableInitially),
            $bucket->info()['iamConfiguration']['publicAccessPrevention']
        );

        $bucket->update($this->papConfig(!$enableInitially));

        $this->assertEquals(
            $expected(!$enableInitially),
            $bucket->info()['iamConfiguration']['publicAccessPrevention']
        );
    }

    public function publicAccessSetting()
    {
        return [
            [true],
            [false]
        ];
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\FailedPreconditionException
     */
    public function testSetBucketAclToPublicAccessFailsWithPublicAccessPrevention()
    {
        $bucket = self::createBucket(self::$client, uniqid(self::TESTING_PREFIX), $this->papConfig());
        $bucket->acl()->add('allUsers', 'READER');
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\FailedPreconditionException
     */
    public function testSetObjectAclToPublicAccessFailsWithPublicAccessPrevention()
    {
        $bucket = self::createBucket(self::$client, uniqid(self::TESTING_PREFIX), $this->papConfig());
        $object = $bucket->upload('hello world', [
            'name' => 'helloworld.txt'
        ]);
        self::$deletionQueue->add($object);

        $object->acl()->add('allUsers', 'READER');
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\BadRequestException
     */
    public function testInvalidPublicAccessPreventionSettingFailsOnCreate()
    {
        $config = $this->papConfig();
        $config['iamConfiguration']['publicAccessPrevention'] = 'well maybe we should? idk what do you think';
        self::createBucket(self::$client, uniqid(self::TESTING_PREFIX), $config + [
            'retries' => 0,
            'sysTestRetries' => 0,
        ]);
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\BadRequestException
     */
    public function testInvalidPublicAccessPreventionSettingFailsOnUpdate()
    {
        try {
            $bucket = self::createBucket(self::$client, uniqid(self::TESTING_PREFIX));
        } catch (BadRequestException $e) {
            // if we fail here something is busted.
            $this->assertTrue(false);
            return;
        }

        $config = $this->papConfig();
        $config['iamConfiguration']['publicAccessPrevention'] = 'well maybe we should? idk what do you think';
        $bucket->update($config);
    }

    /**
     * @dataProvider ublaPapConfigs
     */
    public function testUniformBucketPolicyAndPublicAccessPreventionDontConflict(
        $initialConfig,
        $updateConfig
    ) {
        $bucket = self::createBucket(self::$client, uniqid(self::TESTING_PREFIX), $initialConfig);
        $bucket->update($updateConfig);
        $info = $bucket->info()['iamConfiguration'];

        $this->assertTrue($info['uniformBucketLevelAccess']['enabled']);
        $this->assertArrayHasKey('lockedTime', $info['uniformBucketLevelAccess']);
        $this->assertEquals('enforced', $info['publicAccessPrevention']);
    }

    public function ublaPapConfigs()
    {
        return [
            [
                $this->ublaConfig(),
                $this->papConfig(),
            ], [
                $this->papConfig(),
                $this->ublaConfig(),
            ]
        ];
    }

    private function ublaConfig($enabled = true)
    {
        return [
            'iamConfiguration' => [
                'uniformBucketLevelAccess' => [
                    'enabled' => $enabled
                ]
            ]
        ];
    }

    private function papConfig($enabled = true)
    {
        return [
            'iamConfiguration' => [
                'publicAccessPrevention' => $enabled ?
                    'enforced' :
                    'unspecified'
            ]
        ];
    }
}
