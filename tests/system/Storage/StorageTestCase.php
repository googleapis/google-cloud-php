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

use Google\Cloud\ExponentialBackoff;
use Google\Cloud\Storage\StorageClient;

class StorageTestCase extends \PHPUnit_Framework_TestCase
{
    const TESTING_PREFIX = 'gcloud_testing_';

    protected static $bucket;
    protected static $client;
    protected static $deletionQueue = [];
    protected static $object;
    private static $hasSetUp = false;

    public static function setUpBeforeClass()
    {
        if (self::$hasSetUp) {
            return;
        }

        self::$client = new StorageClient([
            'keyFilePath' => getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH')
        ]);
        self::$bucket = self::$client->createBucket(uniqid(self::TESTING_PREFIX));
        self::$object = self::$bucket->upload('somedata', ['name' => uniqid(self::TESTING_PREFIX)]);
        self::$hasSetUp = true;
    }

    public static function tearDownFixtures()
    {
        if (!self::$hasSetUp) {
            return;
        }

        self::$deletionQueue[] = self::$object;
        self::$deletionQueue[] = self::$bucket;

        $backoff = new ExponentialBackoff(8);

        foreach (self::$deletionQueue as $item) {
            $backoff->execute(function () use ($item) {
                $item->delete();
            });
        }
    }
}


