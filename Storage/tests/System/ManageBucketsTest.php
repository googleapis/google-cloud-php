<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Storage\Tests\System;

use Google\Cloud\Core\Exception\BadRequestException;
use Google\Cloud\Storage\Bucket;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group storage
 * @group storage-bucket
 */
class ManageBucketsTest extends StorageTestCase
{
    use ExpectException;

    public function testListsBuckets()
    {
        $foundBuckets = [];
        $bucketsToCreate = [
            uniqid(self::TESTING_PREFIX),
            uniqid(self::TESTING_PREFIX)
        ];

        foreach ($bucketsToCreate as $bucketToCreate) {
            self::createBucket(self::$client, $bucketToCreate);
        }

        $buckets = self::$client->buckets(['prefix' => self::TESTING_PREFIX]);

        foreach ($buckets as $bucket) {
            foreach ($bucketsToCreate as $key => $bucketToCreate) {
                if ($bucket->name() === $bucketToCreate) {
                    $foundBuckets[$key] = $bucket->name();
                }
            }
        }

        $this->assertEquals($bucketsToCreate, $foundBuckets);
    }

    public function testCreatesBucket()
    {
        $name = uniqid(self::TESTING_PREFIX);
        $options = [
            'location' => 'ASIA',
            'storageClass' => 'NEARLINE',
            'versioning' => [
                'enabled' => true
            ]
        ];
        $this->assertFalse(self::$client->bucket($name)->exists());

        $bucket = self::createBucket(self::$client, $name, $options);

        $this->assertTrue(self::$client->bucket($name)->exists());
        $this->assertEquals($name, $bucket->name());
        $this->assertEquals($options['location'], $bucket->info()['location']);
        $this->assertEquals($options['storageClass'], $bucket->info()['storageClass']);
        $this->assertEquals($options['versioning'], $bucket->info()['versioning']);
        $this->assertEquals('multi-region', $bucket->info()['locationType']);
    }

    public function testUpdateBucket()
    {
        $options = [
            'website' => [
                'mainPageSuffix' => 'index.html',
                'notFoundPage' => '404.html'
            ]
        ];
        $info = self::$bucket->update($options);

        $this->assertEquals($options['website'], $info['website']);
    }

    /**
     * @group storage-bucket-lifecycle
     * @dataProvider lifecycleRules
     */
    public function testCreateBucketWithLifecycleDeleteRule(array $rule, $isError = false)
    {
        if ($isError) {
            $this->expectException(BadRequestException::class);
        }

        $lifecycle = Bucket::lifecycle();
        $lifecycle->addDeleteRule($rule);

        $bucket = self::createBucket(self::$client, uniqid(self::TESTING_PREFIX), [
            'lifecycle' => $lifecycle
        ]);

        $this->assertEquals($lifecycle->toArray(), $bucket->info()['lifecycle']);
    }

    /**
     * @group storage-bucket-lifecycle
     * @dataProvider lifecycleRules
     */
    public function testUpdateBucketWithLifecycleDeleteRule(array $rule, $isError = false)
    {
        if ($isError) {
            $this->expectException(BadRequestException::class);
        }

        $lifecycle = Bucket::lifecycle();
        $lifecycle->addDeleteRule($rule);

        $bucket = self::createBucket(self::$client, uniqid(self::TESTING_PREFIX));
        $this->assertArrayNotHasKey('lifecycle', $bucket->info());

        $bucket->update([
            'lifecycle' => $lifecycle
        ]);

        $this->assertEquals($lifecycle->toArray(), $bucket->info()['lifecycle']);
    }

    public function lifecycleRules()
    {
        return [
            [['age' => 1000]],
            [['daysSinceNoncurrentTime' => 25]],
            [['daysSinceNoncurrentTime' => -5], true], // error case
            [['daysSinceNoncurrentTime' => -5], true], // error case

            [['noncurrentTimeBefore' => (new \DateTime)->format("Y-m-d")]],
            [['noncurrentTimeBefore' => new \DateTime]],
            [['noncurrentTimeBefore' => 'this is not a timestamp'], true], // error case

            [['customTimeBefore' => (new \DateTime)->format("Y-m-d")]],
            [['customTimeBefore' => new \DateTime]],
            [['customTimeBefore' => 'this is not a timestamp'], true], // error case
        ];
    }

    /**
     * @group storage-bucket-lifecycle
     */
    public function testUpdateAndClearLifecycle()
    {
        $lifecycle = self::$bucket->currentLifecycle()
            ->addDeleteRule([
                'age' => 500
            ]);
        $info = self::$bucket->update(['lifecycle' => $lifecycle]);

        $this->assertEquals($lifecycle->toArray(), $info['lifecycle']);

        $lifecycle = self::$bucket->currentLifecycle()
            ->clearRules('Delete');
        $info = self::$bucket->update(['lifecycle' => $lifecycle]);

        $this->assertEmpty($lifecycle->toArray());
        $this->assertArrayNotHasKey('lifecycle', $info);
    }

    public function testReloadBucket()
    {
        $this->assertEquals('storage#bucket', self::$bucket->reload()['kind']);
    }

    /**
     * @group storageiam
     */
    public function testIam()
    {
        $iam = self::$bucket->iam();
        $policy = $iam->policy();

        // pop the version off the resourceId to make the assertion below more robust.
        $resourceId = explode('#', $policy['resourceId'])[0];

        $bucketName = self::$bucket->name();
        $this->assertEquals($resourceId, sprintf('projects/_/buckets/%s', $bucketName));

        $role = 'roles/storage.admin';

        $policy['bindings'][] = [
            'role' => $role,
            'members' => ['projectOwner:gcloud-php-integration-tests']
        ];

        $iam->setPolicy($policy);

        $policy = $iam->reload();

        $newBinding = array_filter($policy['bindings'], function ($binding) use ($role) {
            return ($binding['role'] === $role);
        });

        $this->assertCount(1, $newBinding);

        $permissions = ['storage.buckets.get'];
        $test = $iam->testPermissions($permissions);
        $this->assertEquals($permissions, $test);
    }

    public function testLabels()
    {
        $bucket = self::$bucket;

        $bucket->update([
            'labels' => [
                'foo' => 'bar'
            ]
        ]);

        $bucket->reload();

        $this->assertEquals($bucket->info()['labels']['foo'], 'bar');

        $bucket->update([
            'labels' => [
                'foo' => 'bat'
            ]
        ]);

        $bucket->reload();

        $this->assertEquals($bucket->info()['labels']['foo'], 'bat');

        $bucket->update([
            'labels' => [
                'foo' => null
            ]
        ]);

        $bucket->reload();

        $this->assertFalse(isset($bucket->info()['labels']['foo']));
    }

    /**
     * @group storage-bucket-location
     * @dataProvider locationTypes
     */
    public function testBucketLocationType($storageClass, $location, $expectedLocationType, $updateStorageClass)
    {
        $bucketName = uniqid(self::TESTING_PREFIX);
        $bucket = self::createBucket(self::$client, $bucketName, [
            'storageClass' => $storageClass,
            'location' => $location,
            'retentionPolicy' => [
                'retentionPeriod' => 1
            ]
        ]);

        // Test create bucket response
        $this->assertEquals($expectedLocationType, $bucket->info()['locationType']);

        // Test get bucket response
        $this->assertEquals($expectedLocationType, $bucket->reload()['locationType']);

        // Test update bucket.
        $bucket->update(['storageClass' => $updateStorageClass]);
        $bucket->update(['storageClass' => $storageClass]);
        $this->assertEquals($expectedLocationType, $bucket->info()['locationType']);

        // Test list bucket response
        $buckets = iterator_to_array(self::$client->buckets());
        $listBucketBucket = current(array_filter($buckets, function ($bucket) use ($bucketName) {
            return $bucket->name() === $bucketName;
        }));
        $this->assertEquals($expectedLocationType, $listBucketBucket->info()['locationType']);

        // Test lock retention policy response
        $bucket->lockRetentionPolicy();
        $this->assertEquals($expectedLocationType, $bucket->info()['locationType']);
    }

    public function locationTypes()
    {
        return [
            [
                'STANDARD',
                'us',
                'multi-region',
                'NEARLINE'
            ], [
                'STANDARD',
                'us-central1',
                'region',
                'NEARLINE'
            ], [
                'COLDLINE',
                'nam4',
                'dual-region',
                'STANDARD'
            ], [
                'ARCHIVE',
                'nam4',
                'dual-region',
                'STANDARD'
            ]
        ];
    }
}
