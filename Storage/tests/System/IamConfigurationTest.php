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

    public function testBucketPolicyOnly()
    {
        $bucket = self::createBucket(self::$client, uniqid(self::TESTING_PREFIX));

        $bucket->update($this->bucketConfig());

        $info = $bucket->reload();

        $this->assertTrue($info['iamConfiguration']['bucketPolicyOnly']['enabled']);

        $bucket->update($this->bucketConfig(false));

        $info = $bucket->reload();

        $this->assertFalse($info['iamConfiguration']['bucketPolicyOnly']['enabled']);
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\BadRequestException
     */
    public function testBucketPolicyOnlyAclFails()
    {
        $bucket = self::createBucket(self::$client, uniqid(self::TESTING_PREFIX));

        $bucket->update($this->bucketConfig());

        $bucket->acl()->get();
    }

    public function testCreateBucketWithBucketPolicyOnlyAndInsertObject()
    {
        $bucket = self::createBucket(self::$client, uniqid(self::TESTING_PREFIX), $this->bucketConfig());

        $object = $bucket->upload('foobar', [
            'name' => 'test.txt'
        ]);

        $this->assertInstanceOf(StorageObject::class, $object);
        $object->reload();
    }

    public function testBucketObjectAccessibilityAndAcl()
    {
        $uniqid = uniqid(self::TESTING_PREFIX);
        $uri = sprintf('https://storage.googleapis.com/%s/%s', $uniqid, $uniqid);

        $bucket = self::createBucket(self::$client, $uniqid);
        $object = $bucket->upload($uniqid, [
            'name' => $uniqid,
            'predefinedAcl' => 'publicRead',
        ]);

        $res = $this->guzzle->request('GET', $uri);
        $this->assertEquals($uniqid, (string) $res->getBody());

        $beforeAcl = $object->acl()->get();

        $bucket->update($this->bucketConfig());

        $this->assertTrue($bucket->reload()['iamConfiguration']['bucketPolicyOnly']['enabled']);

        // take a nap until the cache expires.
        sleep(90);
        $res = $this->guzzle->request('GET', $uri);
        $this->assertEquals(403, $res->getStatusCode(), (string) $res->getBody());

        $bucket->update($this->bucketConfig());

        $afterAcl = $object->acl()->get();

        $this->assertEquals($beforeAcl, $afterAcl);
    }

    private function bucketConfig($enabled = true)
    {
        return [
            'iamConfiguration' => [
                'bucketPolicyOnly' => [
                    'enabled' => $enabled
                ]
            ]
        ];
    }
}
