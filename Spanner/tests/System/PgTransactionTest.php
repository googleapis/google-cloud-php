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

use Google\Cloud\Spanner\Date;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Timestamp;

/**
 * @group spanner
 * @group spanner-transaction
 * @group spanner-postgres
 */
class PgTransactionTest extends SpannerPgTestCase
{
    private static $row = [];

    private static $tableName;
    private static $table2;

    public static function set_up_before_class()
    {
        parent::set_up_before_class();

        self::$tableName = "transactions_test";
        self::$table2 = "transactions_users";

        self::$database->updateDdlBatch([
            'CREATE TABLE ' . self::$tableName . ' (
                id bigint NOT NULL,
                number bigint NOT NULL,
                PRIMARY KEY (id)
            )',
            'CREATE TABLE ' . self::$table2 . ' (
                id bigint NOT NULL,
                name varchar(1024) NOT NULL,
                birthday date,
                PRIMARY KEY (id)
            )'
        ])->pollUntilComplete();

        self::$row = [
            'id' => rand(1000, 9999),
            'name' => uniqid(self::TESTING_PREFIX),
            'birthday' => new Date(new \DateTime('2000-01-01'))
        ];

        self::$database->insert(self::$table2, self::$row);
    }

    public function testRunTransaction()
    {
        $db = self::$database;

        $db->runTransaction(function ($t) {
            $id = rand(1, 346464);
            $t->insert(self::$table2, [
                'id' => $id,
                'name' => uniqid(self::TESTING_PREFIX),
                'birthday' => new Date(new \DateTime('2000-01-01'))
            ]);

            $t->commit();
        });

        $db->runTransaction(function ($t) {
            $t->rollback();
        });
    }

    public function testTransactionNoCommit()
    {
        $db = self::$database;

        $ex = false;
        try {
            $db->runTransaction(function ($t) {
                $t->execute('SELECT * FROM ' . self::$tableName);
            });
        } catch (\RuntimeException $e) {
            $this->assertEquals('Transactions must be rolled back or committed.', $e->getMessage());
            $ex = true;
        }

        $this->assertTrue($ex);
    }

    public function testStrongRead()
    {
        $db = self::$database;

        $snapshot = $db->snapshot([
            'strong' => true,
            'returnReadTimestamp' => true
        ]);

        list($keySet, $cols) = $this->readArgs();
        $res = $snapshot->read(self::$table2, $keySet, $cols);

        $row = $res->rows()->current();

        $this->assertEquals(self::$row, $row);
        $this->assertInstanceOf(Timestamp::class, $snapshot->readTimestamp());
    }

    private function readArgs()
    {
        return [
            new KeySet([
                'keys' => [self::$row['id']]
            ]),
            array_keys(self::$row)
        ];
    }
}
