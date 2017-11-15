<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Tests\System\Storage;

use Google\Cloud\Core\AnonymousCredentials;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Tests\System\SystemTestCase;

/**
 * Refer to README.md in this directory for some important information
 * regarding resource management in the storage system test suite.
 */
class StorageTestCase extends SystemTestCase
{
    const TESTING_PREFIX = 'gcloud_testing_';
    const NORMALIZATION_TEST_BUCKET = 'storage-library-test-bucket';

    protected static $bucket;
    protected static $client;
    protected static $unauthenticatedClient;
    protected static $pubsubClient;
    protected static $object;
    protected static $mainBucketName;
    private static $hasSetUp = false;

    public static function setUpBeforeClass()
    {
        if (self::$hasSetUp) {
            return;
        }

        $config = [
            'keyFilePath' => getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH'),
            'transport' => 'rest'
        ];

        self::$client = new StorageClient($config);
        self::$unauthenticatedClient = new StorageClient([
            'credentialsFetcher' => new AnonymousCredentials()
        ]);
        self::$pubsubClient = new PubSubClient($config);

        self::$mainBucketName = getenv('BUCKET') ?: uniqid(self::TESTING_PREFIX);
        self::$bucket = self::createBucket(self::$client, self::$mainBucketName);
        self::$object = self::$bucket->upload('somedata', ['name' => uniqid(self::TESTING_PREFIX)]);

        self::$hasSetUp = true;
    }
}
