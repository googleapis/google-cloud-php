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

namespace Google\Cloud\Spanner\Tests\System;

use Google\Cloud\Core\Testing\System\SystemTestCase;
use Google\Cloud\Spanner;
use Google\Cloud\Spanner\SpannerClient;

/**
 * @group spanner
 */
class SpannerTestCase extends SystemTestCase
{
    const TESTING_PREFIX = 'gcloud_testing_';
    const INSTANCE_NAME = 'google-cloud-php-system-tests';

    const TEST_TABLE_NAME = 'Users';
    const TEST_INDEX_NAME = 'uniqueIndex';

    protected static $client;
    protected static $instance;
    protected static $database;
    protected static $database2;
    protected static $dbName;

    private static $hasSetUp = false;

    public static function setUpBeforeClass()
    {
        if (self::$hasSetUp) {
            return;
        }

        self::getClient();

        self::$instance = self::$client->instance(self::INSTANCE_NAME);

        self::$dbName = uniqid(self::TESTING_PREFIX);
        $op = self::$instance->createDatabase(self::$dbName);
        $op->pollUntilComplete();

        $db = self::getDatabaseInstance(self::$dbName);

        self::$deletionQueue->add(function () use ($db) {
            $db->drop();
        });

        $db->updateDdl(
            'CREATE TABLE ' . self::TEST_TABLE_NAME . ' (
                id INT64 NOT NULL,
                name STRING(MAX) NOT NULL,
                birthday DATE NOT NULL
            ) PRIMARY KEY (id)'
        )->pollUntilComplete();

        $db->updateDdl(
            'CREATE UNIQUE INDEX ' . self::TEST_INDEX_NAME . '
            ON ' . self::TEST_TABLE_NAME . ' (name)'
        )->pollUntilComplete();

        self::$database = $db;
        self::$database2 = self::getDatabaseInstance(self::$dbName);

        self::$hasSetUp = true;
    }

    private static function getClient()
    {
        if (self::$client) {
            return self::$client;
        }

        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');

        $clientConfig = [
            'keyFilePath' => $keyFilePath
        ];

        $serviceAddress = getenv('SPANNER_SERVICE_ADDRESS');
        if ($serviceAddress) {
            $gapicConfig = [
                'serviceAddress' => $serviceAddress
            ];

            $clientConfig['gapicSpannerClient'] = new Spanner\V1\SpannerClient($gapicConfig);
            $clientConfig['gapicSpannerDatabaseAdminClient'] =
                new Spanner\Admin\Database\V1\DatabaseAdminClient($gapicConfig);
            $clientConfig['gapicSpannerInstanceAdminClient'] =
                new Spanner\Admin\Instance\V1\InstanceAdminClient($gapicConfig);

            echo "Using Service Address: ". $serviceAddress . PHP_EOL;
        }

        self::$client = new SpannerClient($clientConfig);

        return self::$client;
    }

    public static function getDatabaseInstance($dbName)
    {
        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');

        return self::$client->connect(self::INSTANCE_NAME, $dbName);
    }

    public static function skipEmulatorTests()
    {
        if ((bool) getenv("SPANNER_EMULATOR_HOST")) {
            self::markTestSkipped('This test is not supported by the emulator.');
        }
    }
}
