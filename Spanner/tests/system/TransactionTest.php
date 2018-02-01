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

use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Date;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Timestamp;

/**
 * @group spanner
 * @group spanner-transaction
 */
class TransactionTest extends SpannerTestCase
{
    const TABLE_NAME = 'Transactions';

    private static $row = [];

    private static $tableName;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        self::$tableName = uniqid(self::TABLE_NAME);

        self::$row = [
            'id' => rand(1000,9999),
            'name' => uniqid(self::TESTING_PREFIX),
            'birthday' => new Date(new \DateTime('2000-01-01'))
        ];

        self::$database->insert(self::TEST_TABLE_NAME, self::$row);

        self::$database->updateDdl(
            'CREATE TABLE '. self::$tableName .' (
                id INT64 NOT NULL,
                number INT64 NOT NULL
            ) PRIMARY KEY (id)'
        )->pollUntilComplete();
    }

    public function testRunTransaction()
    {
        $db = self::$database;

        $db->runTransaction(function ($t) {
            $id = rand(1,346464);
            $t->insert(self::TEST_TABLE_NAME, [
                'id' => $id,
                'name' => uniqid(self::TESTING_PREFIX),
                'birthday' => new Date(new \DateTime)
            ]);

            $t->commit();
        });

        $db->runTransaction(function ($t) {
            $t->rollback();
        });
    }

    /**
     * covers 73
     *
     * @requires extension pcntl
     */
    public function testConcurrentTransactionsIncrementValueWithRead()
    {
        $db = self::$database;

        $id = $this->randId();
        $db->insert(self::$tableName, [
            'id' => $id,
            'number' => 0
        ]);


        $iterations = shell_exec(implode(' ', [
            'php',
            __DIR__ . '/pcntl/ConcurrentTransactionsIncrementValueWithRead.php',
            $db->name(),
            self::$tableName,
            $id
        ]));

        $row = $db->execute('SELECT * FROM '. self::$tableName .' WHERE id = @id', [
            'parameters' => [
                'id' => $id
            ]
        ])->rows()->current();

        $this->assertEquals(2, $row['number']);
        $this->assertGreaterThan(2, $iterations);
    }

    /**
     * covers 75
     */
    public function testTransactionNoCommit()
    {
        $db = self::$database;

        $ex = false;
        try {
            $db->runTransaction(function ($t) {
                $t->execute('SELECT * FROM '. self::$tableName);
            });
        } catch (\RuntimeException $e) {
            $this->assertEquals('Transactions must be rolled back or committed.', $e->getMessage());
            $ex = true;
        }

        $this->assertTrue($ex);
    }

    /**
     * covers 76
     *
     * @requires extension pcntl
     */
    public function testAbortedErrorCausesRetry()
    {
        $db = self::$database;
        $db2 = self::$database2;

        $id = $this->randId();
        $db->insert(self::$tableName, [
            'id' => $id,
            'number' => 0
        ]);

        $iterations = shell_exec(implode(' ', [
            'php',
            __DIR__ . '/pcntl/AbortedErrorCausesRetry.php',
            $db->name(),
            self::$tableName,
            $id
        ]));

        $row = $db->execute('SELECT * FROM '. self::$tableName .' WHERE id = @id', [
            'parameters' => [
                'id' => $id
            ]
        ])->rows()->current();

        $this->assertEquals(2, $row['number']);
        $this->assertEquals(2, $iterations);
    }

    /**
     * covers 74
     *
     * @requires extension pcntl
     */
    public function testConcurrentTransactionsIncrementValueWithExecute()
    {
        $db = self::$database;

        $id = $this->randId();
        $db->insert(self::$tableName, [
            'id' => $id,
            'number' => 0
        ]);

        $iterations = shell_exec(implode(' ', [
            'php',
            __DIR__ . '/pcntl/ConcurrentTransactionsIncrementValueWithExecute.php',
            $db->name(),
            self::$tableName,
            $id
        ]));

        $row = $db->execute('SELECT * FROM '. self::$tableName .' WHERE id = @id', [
            'parameters' => [
                'id' => $id
            ]
        ])->rows()->current();

        $this->assertEquals(2, $row['number']);
        $this->assertGreaterThan(2, $iterations);
    }

    public function testStrongRead()
    {
        $db = self::$database;

        $snapshot = $db->snapshot([
            'strong' => true,
            'returnReadTimestamp' => true
        ]);

        list($keySet, $cols) = $this->readArgs();
        $res = $snapshot->read(self::TEST_TABLE_NAME, $keySet, $cols);

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
