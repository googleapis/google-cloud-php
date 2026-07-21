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

use Google\Cloud\Spanner\Admin\Database\V1\DatabaseDialect;

trait PgSystemTestCaseTrait
{
    use SystemTestCaseTrait;

    protected static function setUpTestDatabase(): void
    {
        if (TestDatabaseManager::$pgHasSetUp) {
            self::$client = TestDatabaseManager::$client;
            self::$instance = TestDatabaseManager::$instance;
            self::$database = TestDatabaseManager::$pgDatabase;
            self::$dbName = TestDatabaseManager::$pgDbName;
            self::$hasSetUp = true;
            return;
        }

        self::$instance = self::getClient()->instance(self::INSTANCE_NAME);

        if (!self::$dbName = getenv('GOOGLE_CLOUD_SPANNER_TEST_PG_DATABASE')) {
            self::$dbName = uniqid(self::TESTING_PREFIX);

            self::$deletionQueue->add(function () {
                self::getDatabaseInstance(self::$dbName)->drop();
            });
        }
        
        self::$database = self::getDatabaseInstance(self::$dbName);

        if (!self::$database->exists()) {
            $op = self::$instance->createDatabase(self::$dbName, [
                'databaseDialect' => DatabaseDialect::POSTGRESQL
            ]);
            $op->pollUntilComplete();
            
            self::$database->updateDdlBatch(
                [
                    'CREATE TABLE IF NOT EXISTS ' . self::TEST_TABLE_NAME . ' (
                        id bigint PRIMARY KEY,
                        name varchar(1024) NOT NULL,
                        birthday date
                    )',
                ]
            )->pollUntilComplete();

            // Currently, the emulator doesn't support setting roles for the PG
            // dialect.
            if (!self::isEmulatorUsed()) {
                self::$database->updateDdlBatch(
                    [
                        'CREATE ROLE ' . self::DATABASE_ROLE,
                        'CREATE ROLE ' . self::RESTRICTIVE_DATABASE_ROLE,
                        'GRANT SELECT ON TABLE ' . self::TEST_TABLE_NAME .
                        ' TO ' . self::DATABASE_ROLE,
                        'GRANT SELECT(id, name), INSERT(id, name), UPDATE(id, name) ON TABLE '
                        . self::TEST_TABLE_NAME . ' TO ' . self::RESTRICTIVE_DATABASE_ROLE,
                    ]
                )->pollUntilComplete();
            }
        }

        TestDatabaseManager::$pgHasSetUp = true;
        TestDatabaseManager::$client = self::$client;
        TestDatabaseManager::$instance = self::$instance;
        TestDatabaseManager::$pgDatabase = self::$database;
        TestDatabaseManager::$pgDbName = self::$dbName;
        self::$hasSetUp = true;
    }
}
