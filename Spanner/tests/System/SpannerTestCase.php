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
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseDialect;

/**
 * @group spanner
 */
abstract class SpannerTestCase extends SystemTestCase
{
    use SystemTestCaseTrait;

    protected static function setUpTestDatabase(): void
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

        self::$database2 = self::getDatabaseInstance(self::$dbName);
        self::$hasSetUp = true;
    }
}
