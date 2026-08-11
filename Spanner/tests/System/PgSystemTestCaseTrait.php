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

            register_shutdown_function(function () {
                self::getDatabaseInstance(self::$dbName)->drop();
            });
        }
        
        if ($token = getenv('TEST_TOKEN')) {
            self::$dbName .= '-' . $token;
        }
        
        self::$database = self::getDatabaseInstance(self::$dbName);

        if (!self::$database->exists()) {
            $op = self::$instance->createDatabase(self::$dbName, [
                'databaseDialect' => DatabaseDialect::POSTGRESQL
            ]);
            $op->pollUntilComplete();
        }

        self::$database->updateDdlBatch(
            [
                'CREATE TABLE IF NOT EXISTS PgBatchTest (
                    id INTEGER PRIMARY KEY,
                    decade INTEGER NOT NULL
                )',
                'CREATE TABLE IF NOT EXISTS Singers (
                    SingerId   BIGINT NOT NULL,
                    FirstName  CHARACTER VARYING(1024),
                    LastName   CHARACTER VARYING(1024),
                    PRIMARY KEY(SingerId)
                )',
                'CREATE TABLE IF NOT EXISTS Albums (
                    SingerId     BIGINT NOT NULL,
                    AlbumId      BIGINT NOT NULL,
                    AlbumTitle   CHARACTER VARYING(1024),
                    PRIMARY KEY(SingerId, AlbumId)
                ) INTERLEAVE IN PARENT Singers ON DELETE CASCADE',
                'CREATE TABLE IF NOT EXISTS PgReadTable (
                    id bigint NOT NULL,
                    val character varying NOT NULL,
                    PRIMARY KEY (id)
                )',
                'CREATE UNIQUE INDEX IF NOT EXISTS PgReadTable_Idx1 ON PgReadTable (id)',
                'CREATE UNIQUE INDEX IF NOT EXISTS PgReadTable_Idx2 ON PgReadTable (id, val)',
                'CREATE TABLE IF NOT EXISTS PgRangeTable (
                    id bigint NOT NULL,
                    val character varying NOT NULL,
                    PRIMARY KEY (id)
                )',
                'CREATE UNIQUE INDEX IF NOT EXISTS PgRangeTable_Idx1 ON PgRangeTable (id)',
                'CREATE UNIQUE INDEX IF NOT EXISTS PgRangeTable_Idx2 ON PgRangeTable (id, val)',
                'CREATE TABLE IF NOT EXISTS PgTransactionTest (
                    id bigint NOT NULL,
                    name character varying NOT NULL,
                    birthday date,
                    PRIMARY KEY (id)
                )',
                'CREATE TABLE IF NOT EXISTS Writes (
                    id bigint NOT NULL,
                    arrayField bigint[],
                    arrayBoolField boolean[],
                    arrayFloatField double precision[],
                    arrayfloat4field real[],
                    arrayStringField character varying[],
                    arrayBytesField bytea[],
                    arrayTimestampField timestamp with time zone[],
                    arrayDateField date[],
                    arraypgnumericfield numeric[],
                    arraypgjsonbfield jsonb[],
                    boolField boolean,
                    bytesField bytea,
                    dateField date,
                    floatField double precision,
                    float4field real,
                    intField bigint,
                    stringField character varying,
                    timestampField timestamp with time zone,
                    pgnumericfield numeric,
                    pgjsonbfield jsonb,
                    uuidField character varying(36),
                    arrayUuidField character varying(36)[],
                    PRIMARY KEY (id)
                )',
                'CREATE TABLE IF NOT EXISTS CommitTimestamps (
                    id bigint NOT NULL,
                    commitTimestamp spanner.commit_timestamp NOT NULL,
                    PRIMARY KEY(id)
                )',
                'CREATE TABLE IF NOT EXISTS partitionedDml (
                    id bigint NOT NULL,
                    stringField varchar(1024),
                    boolField BOOL,
                    PRIMARY KEY (id)
                )',
                'CREATE TABLE IF NOT EXISTS PgQueryTest_2 (
                    id bigint NOT NULL,
                    name varchar(1024),
                    registered bool,
                    age numeric,
                    rating float,
                    bytes_col bytea,
                    created_at timestamptz,
                    dt date,
                    data jsonb,
                    weight float4,
                    PRIMARY KEY (id)
                )',
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
            self::$database->updateDdlBatch([
                'CREATE ROLE ' . self::DATABASE_ROLE,
                'CREATE ROLE ' . self::RESTRICTIVE_DATABASE_ROLE
            ])->pollUntilComplete();
            self::$database->updateDdlBatch([
                'GRANT SELECT ON TABLE ' . self::TEST_TABLE_NAME .
                ' TO ' . self::DATABASE_ROLE,
                'GRANT SELECT(id, name), INSERT(id, name), UPDATE(id, name) ON TABLE '
                . self::TEST_TABLE_NAME . ' TO ' . self::RESTRICTIVE_DATABASE_ROLE,
                'GRANT SELECT(id) ON TABLE PgBatchTest TO ' . self::RESTRICTIVE_DATABASE_ROLE,
                'GRANT SELECT ON TABLE PgBatchTest TO ' . self::DATABASE_ROLE,
            ])->pollUntilComplete();
        }

        TestDatabaseManager::$pgHasSetUp = true;
        TestDatabaseManager::$client = self::$client;
        TestDatabaseManager::$instance = self::$instance;
        TestDatabaseManager::$pgDatabase = self::$database;
        TestDatabaseManager::$pgDbName = self::$dbName;
        self::$hasSetUp = true;
    }
}
