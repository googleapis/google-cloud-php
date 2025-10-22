<?php
/**
 * Copyright 2025 Google Inc.
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
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\SpannerClient;
use Google\Cloud\Spanner\V1\Client\SpannerClient as SpannerGapicClient;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseDialect;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

trait SystemTestCaseTrait
{
    private const TESTING_PREFIX = 'gcloud_testing_';
    private const INSTANCE_NAME = 'google-cloud-php-system-tests';
    private const TEST_TABLE_NAME = 'Users';
    private const TEST_INDEX_NAME = 'uniqueIndex';
    private const DATABASE_ROLE = 'Reader';
    private const RESTRICTIVE_DATABASE_ROLE = 'RestrictiveReader';

    private static $client;
    private static $instance;
    private static $database;
    private static $dbName;
    private static $hasSetUp = false;

    private static function getClient()
    {
        if (self::$client) {
            return self::$client;
        }

        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');

        $clientConfig = [
            'keyFilePath' => $keyFilePath,
            'cacheItemPool' => self::getCacheItemPool(),
        ];

        $serviceAddress = getenv('SPANNER_SERVICE_ADDRESS');
        if ($serviceAddress) {
            $gapicConfig = [
                'serviceAddress' => $serviceAddress
            ];

            $clientConfig['gapicSpannerClient'] = new SpannerGapicClient($gapicConfig);
            $clientConfig['gapicSpannerDatabaseAdminClient'] =
                new DatabaseAdminClient($gapicConfig);
            $clientConfig['gapicSpannerInstanceAdminClient'] =
                new InstanceAdminClient($gapicConfig);

            echo 'Using Service Address: ' . $serviceAddress . PHP_EOL;
        }

        return self::$client = new SpannerClient($clientConfig);
    }

    private static function setUpTestDatabase(): void
    {
        if (self::$hasSetUp) {
            return;
        }

        self::$instance = self::getClient()->instance(self::INSTANCE_NAME);

        if (!self::$dbName = getenv('GOOGLE_CLOUD_SPANNER_TEST_DATABASE')) {
            self::$dbName = uniqid(self::TESTING_PREFIX);
            self::$deletionQueue->add(function () {
                self::getDatabaseInstance(self::$dbName)->drop();
            });
        }
        self::$database = self::getDatabaseInstance(self::$dbName);

        if (!self::$database->exists()) {
            $op = self::$instance->createDatabase(self::$dbName);
            $op->pollUntilComplete();
            $op = self::$database->updateDdlBatch(
                [
                    'CREATE TABLE ' . self::TEST_TABLE_NAME . ' (
                    id INT64 NOT NULL,
                    name STRING(MAX) NOT NULL,
                    birthday DATE
                    ) PRIMARY KEY (id)',
                    'CREATE UNIQUE INDEX ' . self::TEST_INDEX_NAME . '
                    ON ' . self::TEST_TABLE_NAME . ' (name)',
                ]
            );
            $op->pollUntilComplete();

            if (self::$database->info()['databaseDialect'] == DatabaseDialect::GOOGLE_STANDARD_SQL
                && !self::isEmulatorUsed()
            ) {
                self::$database->updateDdlBatch(
                    [
                        'CREATE ROLE ' . self::DATABASE_ROLE,
                        'CREATE ROLE ' . self::RESTRICTIVE_DATABASE_ROLE,
                        'GRANT SELECT ON TABLE ' . self::TEST_TABLE_NAME .
                        ' TO ROLE ' . self::DATABASE_ROLE,
                        'GRANT SELECT(id, name), INSERT(id, name), UPDATE(id, name) ON TABLE '
                        . self::TEST_TABLE_NAME . ' TO ROLE ' . self::RESTRICTIVE_DATABASE_ROLE,
                    ]
                )->pollUntilComplete();
            }
        }

        self::$hasSetUp = true;
    }

    private static function getDatabaseInstance($dbName, $options = [])
    {
        return self::getClient()->connect(self::INSTANCE_NAME, $dbName, $options);
    }

    private static function skipEmulatorTests()
    {
        if (self::isEmulatorUsed()) {
            self::markTestSkipped('This test is not supported by the emulator.');
        }
    }

    public static function emulatorOnly()
    {
        if (!self::isEmulatorUsed()) {
            self::markTestSkipped('This test is only supported by the emulator.');
        }
    }

    public static function isEmulatorUsed(): bool
    {
        return (bool) getenv('SPANNER_EMULATOR_HOST');
    }

    private static function getDbWithReaderRole()
    {
        return self::getDatabaseFromInstance(
            self::INSTANCE_NAME,
            self::$dbName,
            ['databaseRole' => self::DATABASE_ROLE]
        );
    }

    private static function getDbWithRestrictiveRole()
    {
        return self::getDatabaseFromInstance(
            self::INSTANCE_NAME,
            self::$dbName,
            ['databaseRole' => self::RESTRICTIVE_DATABASE_ROLE]
        );
    }

    private static function getDatabaseFromInstance($instance, $dbName, $options = [])
    {
        $instance = self::getClient()->instance($instance);
        return $instance->database($dbName, $options);
    }

    private static function getCacheItemPool()
    {
        return new FilesystemAdapter(
            directory: __DIR__ . '/../../../.cache'
        );
    }
}
