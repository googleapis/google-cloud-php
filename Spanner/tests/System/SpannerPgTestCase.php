<?php
/**
 * Copyright 2022 Google Inc.
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
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseDialect;
use Google\Cloud\Spanner\Session\CacheSessionPool;
use Google\Auth\Cache\MemoryCacheItemPool;

/**
 * @group spanner
 * @group spanner-postgres
 */
class SpannerPgTestCase extends SystemTestCase
{
    const TESTING_PREFIX = 'gcloud_testing_';
    const INSTANCE_NAME = 'google-cloud-php-system-tests';

    const TEST_TABLE_NAME = 'Users';
    const TEST_INDEX_NAME = 'uniqueIndex';

    const DATABASE_ROLE = 'Reader';
    const RESTRICTIVE_DATABASE_ROLE = 'RestrictiveReader';

    protected static $client;
    protected static $instance;
    protected static $database;
    protected static $database2;
    protected static $dbName;

    private static $hasSetUp = false;

    public static function setUpBeforeClass(): void
    {
        if (self::$hasSetUp) {
            return;
        }

        self::skipEmulatorTests();
        self::getClient();

        self::$instance = self::$client->instance(self::INSTANCE_NAME);

        self::$dbName = uniqid(self::TESTING_PREFIX);

        // create a PG DB first
        $op = self::$instance->createDatabase(self::$dbName, [
            'databaseDialect' => DatabaseDialect::POSTGRESQL
        ]);
        // wait for the DB to be ready
        $op->pollUntilComplete();

        $db = self::getDatabaseInstance(self::$dbName);

        self::$deletionQueue->add(function () use ($db) {
            $db->drop();
        });

        self::$database = $db;
        self::$database2 = self::getDatabaseInstance(self::$dbName);

        $db->updateDdlBatch(
            [
                'CREATE TABLE ' . self::TEST_TABLE_NAME . ' (
                    id bigint PRIMARY KEY,
                    name varchar(1024) NOT NULL,
                    birthday date
                )',
                'CREATE ROLE ' . self::DATABASE_ROLE,
                'CREATE ROLE ' . self::RESTRICTIVE_DATABASE_ROLE,
                'GRANT SELECT ON TABLE ' . self::TEST_TABLE_NAME .
                ' TO ' . self::DATABASE_ROLE,
                'GRANT SELECT(id, name), INSERT(id, name), UPDATE(id, name) ON TABLE '
                . self::TEST_TABLE_NAME . ' TO ' . self::RESTRICTIVE_DATABASE_ROLE,
            ]
        )->pollUntilComplete();

        self::$hasSetUp = true;
    }

    public static function getDatabaseFromInstance($instance, $dbName, $options = [])
    {
        $instance = self::$client->instance($instance);
        return $instance->database($dbName, $options);
    }

    public static function getDatabaseWithSessionPool($dbName, $options = [])
    {
        $sessionCache = new MemoryCacheItemPool;
        $sessionPool = new CacheSessionPool(
            $sessionCache,
            $options
        );

        return self::$client->connect(
            self::INSTANCE_NAME,
            $dbName,
            [
                'sessionPool' => $sessionPool
            ]
        );
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

    public static function getDbWithReaderRole()
    {
        return self::getDatabaseFromInstance(
            self::INSTANCE_NAME,
            self::$dbName,
            ['databaseRole' => self::DATABASE_ROLE]
        );
    }

    public static function getDbWithRestrictiveRole()
    {
        return self::getDatabaseFromInstance(
            self::INSTANCE_NAME,
            self::$dbName,
            ['databaseRole' => self::RESTRICTIVE_DATABASE_ROLE]
        );
    }

    public static function getDbWithSessionPoolRestrictiveRole()
    {
        return self::getDatabaseWithSessionPool(
            self::$dbName,
            ['minSessions' => 1, 'maxSession' => 2, 'databaseRole' => self::RESTRICTIVE_DATABASE_ROLE]
        );
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
}
