<?php
/**
 * Copyright 2020 Google LLC
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

use Yoast\PHPUnitPolyfills\Polyfills\AssertStringContains;

/**
 * @group storage
 * @group storage-iam
 */
class IamTest extends StorageTestCase
{
    use AssertStringContains;

    private $b;

    public function set_up()
    {
        $this->b = self::createBucket(self::$client, uniqid(self::TESTING_PREFIX));
        $this->b->update($this->bucketConfig());
    }

    public function testGetPolicy()
    {
        $keyfile = json_decode(file_get_contents(getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH')), true);
        $projectId = $keyfile['project_id'];

        $iam = $this->b->iam();
        $policy = $iam->policy();

        $this->assertTrue(isset($policy['etag']));
        $this->assertEquals(
            [
                [
                    'role' => 'roles/storage.legacyBucketOwner',
                    'members' => [
                        'projectEditor:' . $projectId,
                        'projectOwner:' . $projectId
                    ]
                ],
                [
                    'role' => 'roles/storage.legacyBucketReader',
                    'members' => ['projectViewer:' . $projectId]
                ]

            ],
            $policy['bindings']
        );
    }

    public function testSetPolicy()
    {
        $keyfile = json_decode(file_get_contents(getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH')), true);
        $projectId = $keyfile['project_id'];

        $iam = $this->b->iam();
        $policy = $iam->policy();
        $newBinding = [
            'role' => 'roles/storage.legacyBucketReader',
            'members' => ['allUsers']
        ];

        $policy['bindings'][] = $newBinding;

        $iam->setPolicy($policy);
        $policy = $iam->reload();
        $this->assertStringContainsString(
            [
                'role' => 'roles/storage.legacyBucketReader',
                'members' => ['allUsers', 'projectViewer:' . $projectId]
            ],
            $policy['bindings']
        );
    }

    public function testGetModifySetConditionalPolicy()
    {
        $keyfile = json_decode(file_get_contents(getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH')), true);
        $email = $keyfile['client_email'];

        $iam = $this->b->iam();
        $policy = $iam->policy();
        $policy['version'] = 3;

        $conditionalBinding = [
            'role' => 'roles/storage.objectViewer',
            'members' => ['serviceAccount:' . $email],
            'condition' => [
                'title' => 'always-true',
                'description' => 'this condition is always effective',
                'expression' => 'true',
            ]
        ];

        $policy['bindings'][] = $conditionalBinding;
        $iam->setPolicy($policy);
        $policy = $iam->reload(['requestedPolicyVersion' => 3]);
        $this->assertStringContainsString(
            $conditionalBinding,
            $policy['bindings']
        );
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
