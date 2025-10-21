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

use Google\Cloud\Spanner;
use Google\Cloud\Spanner\SpannerClient;

trait SystemTestCaseTrait
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
    protected static $hasSetUp = false;

    protected static function getClient()
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

            $clientConfig['gapicSpannerClient'] = new Spanner\V1\Client\SpannerClient($gapicConfig);
            $clientConfig['gapicSpannerDatabaseAdminClient'] =
                new Spanner\Admin\Database\V1\Client\DatabaseAdminClient($gapicConfig);
            $clientConfig['gapicSpannerInstanceAdminClient'] =
                new Spanner\Admin\Instance\V1\Client\InstanceAdminClient($gapicConfig);

            echo 'Using Service Address: ' . $serviceAddress . PHP_EOL;
        }

        return self::$client = new SpannerClient($clientConfig);
    }

    public static function getDatabaseInstance($dbName, $options = [])
    {
        return self::getClient()->connect(self::INSTANCE_NAME, $dbName, $options);
    }

    public static function getDatabaseFromInstance($instance, $dbName, $options = [])
    {
        $instance = self::getClient()->instance($instance);
        return $instance->database($dbName, $options);
    }

    public static function skipEmulatorTests()
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
}
