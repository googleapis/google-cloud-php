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

namespace Google\Cloud\Tests\System\Storage;

/**
 * @group storage
 */
class ManageBucketsTest extends StorageTestCase
{
    public function testListsBuckets()
    {
        $foundBuckets = [];
        $bucketsToCreate = [
            uniqid(self::TESTING_PREFIX),
            uniqid(self::TESTING_PREFIX)
        ];

        foreach ($bucketsToCreate as $bucketToCreate) {
            self::$deletionQueue[] = self::$client->createBucket($bucketToCreate);
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

        $bucket = self::$client->createBucket($name, $options);
        self::$deletionQueue[] = $bucket;

        $this->assertTrue(self::$client->bucket($name)->exists());
        $this->assertEquals($name, $bucket->name());
        $this->assertEquals($options['location'], $bucket->info()['location']);
        $this->assertEquals($options['storageClass'], $bucket->info()['storageClass']);
        $this->assertEquals($options['versioning'], $bucket->info()['versioning']);
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

    public function testReloadBucket()
    {
        $this->assertEquals('storage#bucket', self::$bucket->reload()['kind']);
    }
}
