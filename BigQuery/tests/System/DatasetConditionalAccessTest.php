<?php
/**
 * Copyright 2025 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\BigQuery\Tests\System;

/**
 * @group bigquery
 * @group bigquery-dataset
 */
class DatasetConditionalAccessTest extends BigQueryTestCase
{
    private $userEmail;
    private $groupEmail = 'php-cloud-eng@google.com';
    private $domain = 'google.com';
    private $iamMember;
    private $testDataset;

    public function setUp(): void
    {
        $this->testDataset = self::createDataset(
            self::$client,
            uniqid(self::TESTING_PREFIX),
            ['accessPolicyVersion' => 3]
        );
        $projectId = $this->testDataset->identity()['projectId'];
        $this->userEmail = $projectId . '@appspot.gserviceaccount.com';
        $this->iamMember = 'serviceAccount:' . $this->userEmail;
    }

    public function tearDown(): void
    {
        $this->testDataset->delete();
    }

    public function testConditionalAccessUserReader()
    {
        $this->runConditionalAccessTest('userByEmail', $this->userEmail, 'READER');
    }

    public function testConditionalAccessUserWriter()
    {
        $this->runConditionalAccessTest('userByEmail', $this->userEmail, 'WRITER');
    }

    public function testConditionalAccessUserOwner()
    {
        $this->runConditionalAccessTest('userByEmail', $this->userEmail, 'OWNER');
    }

    public function testConditionalAccessGroupReader()
    {
        $this->runConditionalAccessTest('groupByEmail', $this->groupEmail, 'READER');
    }

    public function testConditionalAccessGroupWriter()
    {
        $this->runConditionalAccessTest('groupByEmail', $this->groupEmail, 'WRITER');
    }

    public function testConditionalAccessGroupOwner()
    {
        $this->runConditionalAccessTest('groupByEmail', $this->groupEmail, 'OWNER');
    }

    public function testConditionalAccessDomainReader()
    {
        $this->runConditionalAccessTest('domain', $this->domain, 'READER');
    }

    public function testConditionalAccessDomainWriter()
    {
        $this->runConditionalAccessTest('domain', $this->domain, 'WRITER');
    }

    public function testConditionalAccessDomainOwner()
    {
        $this->runConditionalAccessTest('domain', $this->domain, 'OWNER');
    }

    public function testConditionalAccessIamMemberReader()
    {
        $this->runConditionalAccessTest('iamMember', $this->iamMember, 'READER');
    }

    public function testConditionalAccessIamMemberWriter()
    {
        $this->runConditionalAccessTest('iamMember', $this->iamMember, 'WRITER');
    }

    public function testConditionalAccessIamMemberOwner()
    {
        $this->runConditionalAccessTest('iamMember', $this->iamMember, 'OWNER');
    }

    private function runConditionalAccessTest($scopeType, $scopeValue, $role)
    {
        // Define a condition for the access entry
        $condition = [
            'expression' => 'true',
            'title' => 'example title',
            'description' => 'example description',
            'location' => 'path/to/example/location'
        ];

        // Get the dataset
        $info = $this->testDataset->info();

        // Append the new access entry to the access array
        $access = $info['access'];

        $access[] = [
            'role' => $role,
            $scopeType => $scopeValue,
            'condition' => $condition
        ];

        // Update the dataset with the new access entry
        $info = $this->testDataset->update(['access' => $access], ['accessPolicyVersion' => 3]);

        // Handle iamMember special case for assertion
        if ($scopeType === 'iamMember' && strpos($scopeValue, 'serviceAccount:') === 0) {
            $scopeType = 'userByEmail';
            $scopeValue = explode(':', $scopeValue)[1];
        }

        // Verify the access entry was added
        $this->assertCount(1, array_filter($info['access'], function ($acl) use ($scopeType, $scopeValue, $condition) {
            return isset($acl[$scopeType])
                && $acl[$scopeType] === $scopeValue
                && isset($acl['condition']) && $acl['condition'] === $condition;
        }));

        // Get the dataset again and remove the access entry
        $info = $this->testDataset->info();
        $access = array_filter($info['access'], function ($acl) use ($scopeType, $scopeValue, $condition) {
            return !(isset($acl[$scopeType])
                && $acl[$scopeType] === $scopeValue
                && isset($acl['condition']) && $acl['condition'] === $condition);
        });

        // Update the dataset to remove the access entry
        $this->testDataset->update(['access' => $access], ['accessPolicyVersion' => 3]);

        // Verify the access entry was removed
        $info = $this->testDataset->reload();
        $this->assertCount(0, array_filter($info['access'], function ($acl) use ($scopeType, $scopeValue, $condition) {
            return isset($acl[$scopeType])
                && $acl[$scopeType] === $scopeValue
                && isset($acl['condition']) && $acl['condition'] === $condition;
        }));
    }
}
