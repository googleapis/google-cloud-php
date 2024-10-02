<?php
/**
 * Copyright 2024 Google Inc.
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

use Google\Cloud\Storage\Bucket;

class UniverseDomainTest extends StorageTestCase
{
    private static $universeDomainBucket;
    private static $bucketName;
    /**
     *  Test creating a bucket with universe domain credentials
     */
    public function testCreateBucketWithUniverseDomain()
    {
        self::$bucketName = uniqid(self::TESTING_PREFIX);
        self::$universeDomainBucket = self::createBucket(
            self::$universeDomainClient,
            self::$bucketName,
            [
                'location' => getenv('TEST_UNIVERSE_LOCATION')
            ]
        );
        $this->assertEquals(self::$bucketName, self::$universeDomainBucket->info()['name']);
    }

    /**
     *  Test uploading and retrieving objects to a bucket using universe domain credentials.
     */
    public function testListsObjectsWithUniverseDomain()
    {
        $foundObjects = [];
        $objectsToCreate = [
            uniqid(self::TESTING_PREFIX),
            uniqid(self::TESTING_PREFIX)
        ];

        foreach ($objectsToCreate as $objectToCreate) {
            self::$universeDomainBucket->upload('data', ['name' => $objectToCreate]);
        }

        $objects = self::$universeDomainBucket->objects(['prefix' => self::TESTING_PREFIX]);

        foreach ($objects as $object) {
            foreach ($objectsToCreate as $key => $objectToCreate) {
                if ($object->name() === $objectToCreate) {
                    $foundObjects[$key] = $object->name();
                }
            }
        }
        $this->assertEquals($objectsToCreate, $foundObjects);
    }
}
