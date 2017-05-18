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

use Google\Cloud\Spanner\Date;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Timestamp;

/**
 * @group spanner
 * @group spanner-transactions
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
     */
    public function testConcurrentTransactionsIncrementValueWithRead()
    {
        $db = self::$database;
        $db2 = self::$database2;

        $id = $this->randId();
        $db->insert(self::$tableName, [
            'id' => $id,
            'number' => 0
        ]);

        $keyset = new KeySet(['keys' => [$id]]);
        $columns = ['id','number'];

        $iteration = 0;
        $db->runTransaction(function ($transaction) use ($db2, &$iteration, $keyset, $columns) {
            $row = $transaction->read(self::$tableName, $keyset, $columns)->rows()->current();

            if ($iteration === 0) {
                $db2->runTransaction(function ($t2) use ($keyset, $columns) {
                    $row = $t2->read(self::$tableName, $keyset, $columns)->rows()->current();

                    $row['number'] = $row['number']+1;

                    $t2->update(self::$tableName, $row);
                    $t2->commit();
                });
            }

            $row['number'] = $row['number']+1;
            $iteration++;

            $transaction->update(self::$tableName, $row);
            $transaction->commit();
        });

        $row = $db->execute('SELECT * FROM '. self::$tableName .' WHERE id = @id', [
            'parameters' => [
                'id' => $id
            ]
        ])->rows()->current();

        $this->assertEquals(2, $row['number']);
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
     */
    public function testAbortedErrorCausesRetry()
    {
        $db = self::$database;
        $db2 = self::$database2;

        $args = [
            'id' => $this->randId(),
            'it' => 0,
            'pre' => null,
            'edit' => null,
            'post' => null
        ];

        $db->insert(self::$tableName, [
            'id' => $args['id'],
            'number' => 0
        ]);

        $db->runTransaction(function ($t) use ($db2, &$args) {
            if ($args['it'] === 0) {
                $row = $t->execute('SELECT * FROM '. self::$tableName .' WHERE id = @id', [
                    'parameters' => ['id' => $args['id']]
                ])->rows()->current();

                $args['pre'] = $row['number'];

                $db2->runTransaction(function ($t2) use (&$args) {
                    $row = $t2->execute('SELECT * FROM '. self::$tableName .' WHERE id = @id', [
                        'parameters' => ['id' => $args['id']]
                    ])->rows()->current();

                    $args['edit'] = $row['number']+1;
                    $row['number'] = $args['edit'];
                    $t2->replace(self::$tableName, $row);
                    $t2->commit();
                });
            }

            $args['it']++;

            $row = $t->execute('SELECT * FROM '. self::$tableName .' WHERE id = @id', [
                'parameters' => ['id' => $args['id']]
            ])->rows()->current();

            $args['post'] = $row['number'];
            $this->assertEquals($row['number'], $args['post']);
            $this->assertEquals($args['pre']+1, $row['number']);

            $t->rollback();
        });
    }

    /**
     * covers 74
     */
    public function testConcurrentTransactionsIncrementValueWithExecute()
    {
        $db = self::$database;
        $db2 = self::$database2;

        $id = $this->randId();
        $db->insert(self::$tableName, [
            'id' => $id,
            'number' => 0
        ]);

        $iteration = 0;
        $db->runTransaction(function ($transaction) use ($db2, $id, &$iteration) {
            $row = $transaction->execute('SELECT * FROM '. self::$tableName .' WHERE id = @id', [
                'parameters' => [
                    'id' => $id
                ]
            ])->rows()->current();

            if ($iteration === 0) {
                $db2->runTransaction(function ($t2) use ($id) {
                    $row = $t2->execute('SELECT * FROM '. self::$tableName .' WHERE id = @id', [
                        'parameters' => [
                            'id' => $id
                        ]
                    ])->rows()->current();

                    $row['number'] = $row['number']+1;

                    $t2->update(self::$tableName, $row);
                    $t2->commit();
                });
            }

            $row['number'] = $row['number']+1;
            $iteration++;

            $transaction->update(self::$tableName, $row);
            $transaction->commit();
        });

        $row = $db->execute('SELECT * FROM '. self::$tableName .' WHERE id = @id', [
            'parameters' => [
                'id' => $id
            ]
        ])->rows()->current();

        $this->assertEquals(2, $row['number']);
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
