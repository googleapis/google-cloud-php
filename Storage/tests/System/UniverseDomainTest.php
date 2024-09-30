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

use Google\Cloud\Core\Testing\System\SystemTestCase;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\StorageClient;

class UniverseDomainTest extends SystemTestCase
{
    private static $bucket;
    private static $client;

    /**
     * @beforeClass
     */
    public static function setUpTestFixtures(): void
    {
        if (!$keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_UNIVERSE_DOMAIN_KEY_PATH')) {
            self::markTestSkipped('Set GOOGLE_CLOUD_PHP_TESTS_UNIVERSE_DOMAIN_KEY_PATH to run system tests');
        }

        $credentials = json_decode(file_get_contents($keyFilePath), true);
        if (!isset($credentials['universe_domain'])) {
            throw new \Exception('The provided key file does not contain universe domain credentials');
        }

        self::$client = new StorageClient([
            'keyFilePath' => $keyFilePath,
            'projectId' => $credentials['project_id'] ?? null,
            'universeDomain' => $credentials['universe_domain'] ?? null
        ]);
    }

    /**
     * Test creating a bucket with universe domain credentials
     */
    public function testCreateBucketWithUniverseDomain()
    {
        if (!$location = getenv('GOOGLE_CLOUD_PHP_TESTS_UNIVERSE_DOMAIN_LOCATION')) {
            $this->markTestSkipped('Set GOOGLE_CLOUD_PHP_TESTS_UNIVERSE_DOMAIN_LOCATION to run system tests');
        }
        $bucketName = uniqid(StorageTestCase::TESTING_PREFIX);
        self::$bucket = self::createBucket(
            self::$client,
            $bucketName,
            ['location' => $location]
        );
        $this->assertEquals($bucketName, self::$bucket->info()['name']);
    }

    /**
     * Test uploading and retrieving objects to a bucket using universe domain credentials.
     *
     * @depends testCreateBucketWithUniverseDomain
     */
    public function testListsObjectsWithUniverseDomain()
    {
        $foundObjects = [];
        $objectsToCreate = [
            uniqid(StorageTestCase::TESTING_PREFIX),
            uniqid(StorageTestCase::TESTING_PREFIX)
        ];

        foreach ($objectsToCreate as $objectToCreate) {
            self::$bucket->upload('data', ['name' => $objectToCreate]);
        }

        $objects = self::$bucket->objects(['prefix' => StorageTestCase::TESTING_PREFIX]);

        $foundObjects = array_filter(
            iterator_to_array($objects),
            fn ($object) => in_array($object->name(), $objectsToCreate)
        );

        $this->assertCount(2, $foundObjects);
    }
    /**
     * Test uploading and retrieving objects to a bucket using universe domain credentials.
     *
     * @depends testCreateBucketWithUniverseDomain
     */
    public function testDeleteBucketWithUniverseDomain()
    {
        foreach (self::$bucket->objects() as $object) {
            $object->delete();
        }
        self::$bucket->delete();
        $this->assertFalse(self::$bucket->exists());
        $buckets = self::$client->buckets(['prefix' => self::$bucket->name()]);
        $this->assertCount(0, iterator_to_array($buckets));
    }
}
