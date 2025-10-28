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
        if (self::$hasSetUp) {
            return;
        }

        self::$instance = self::getClient()->instance(self::INSTANCE_NAME);

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

        $db->updateDdlBatch(
            [
                'CREATE TABLE ' . self::TEST_TABLE_NAME . ' (
                    id bigint PRIMARY KEY,
                    name varchar(1024) NOT NULL,
                    birthday date
                )',
            ]
        )->pollUntilComplete();

        // Currently, the emulator doesn't support setting roles for the PG
        // dialect.
        if (!self::isEmulatorUsed()) {
            $db->updateDdlBatch(
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

        self::$hasSetUp = true;
    }
}
