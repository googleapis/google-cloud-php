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

namespace Google\Cloud\Tests\System\Spanner;

use Google\Cloud\Core\ExponentialBackoff;
use Google\Cloud\Spanner\SpannerClient;

/**
 * @group spanner
 */
class SpannerTestCase extends \PHPUnit_Framework_TestCase
{
    const TESTING_PREFIX = 'gcloud_testing_';
    const INSTANCE_NAME = 'google-cloud-php-system-tests';

    const TEST_TABLE_NAME = 'Users';
    const TEST_INDEX_NAME = 'uniqueIndex';

    protected static $client;
    protected static $instance;
    protected static $database;
    protected static $database2;
    protected static $deletionQueue = [];

    private static $hasSetUp = false;

    public static function setUpBeforeClass()
    {
        if (self::$hasSetUp) {
            return;
        }

        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');

        self::$client = new SpannerClient([
            'keyFilePath' => $keyFilePath
        ]);

        self::$instance = self::$client->instance(self::INSTANCE_NAME);

        $dbName = uniqid(self::TESTING_PREFIX);
        $op = self::$instance->createDatabase($dbName);
        $op->pollUntilComplete();
        $db = self::$client->connect(self::INSTANCE_NAME, $dbName);

        self::$deletionQueue[] = function() use ($db) { $db->drop(); };

        $db->updateDdl(
            'CREATE TABLE '. self::TEST_TABLE_NAME .' (
                id INT64 NOT NULL,
                name STRING(MAX) NOT NULL,
                birthday DATE NOT NULL
            ) PRIMARY KEY (id)'
        )->pollUntilComplete();

        $db->updateDdl(
            'CREATE UNIQUE INDEX '. self::TEST_INDEX_NAME .'
            ON '. self::TEST_TABLE_NAME .' (name)'
        )->pollUntilComplete();

        self::$database = $db;
        self::$database2 = self::$client->connect(self::INSTANCE_NAME, $dbName);
    }

    public static function tearDownFixtures()
    {
        $backoff = new ExponentialBackoff(8);

        foreach (self::$deletionQueue as $item) {
            $backoff->execute($item);
        }
    }

    public static function randId()
    {
        return rand(1,9999999);
    }
}
