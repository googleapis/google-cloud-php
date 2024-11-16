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

use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Spanner\Date;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\V1\DirectedReadOptions\ReplicaSelection\Type as ReplicaType;

/**
 * @group spanner
 * @group spanner-transaction
 */
class TransactionTest extends SpannerTestCase
{
    use DatabaseRoleTrait;

    const TABLE_NAME = 'Transactions';

    private static $row = [];

    private static $tableName;
    private static $id1;
    private static $isSetup = false;

    /**
     * @beforeClass
     */
    public static function setUpTestFixtures(): void
    {
        if (self::$isSetup) {
            return;
        }
        parent::setUpTestFixtures();

        self::$tableName = uniqid(self::TABLE_NAME);
        self::$id1 = rand(1000, 9999);

        self::$row = [
            'id' => self::$id1,
            'name' => uniqid(self::TESTING_PREFIX),
            'birthday' => new Date(new \DateTime('2000-01-01'))
        ];

        self::$database->insert(self::TEST_TABLE_NAME, self::$row);

        self::$database->updateDdl(
            'CREATE TABLE ' . self::$tableName . ' (
                    id INT64 NOT NULL,
                    number INT64 NOT NULL
                ) PRIMARY KEY (id)'
        )->pollUntilComplete();
        self::$isSetup = true;
    }

    public function testRunTransaction()
    {
        $db = self::$database;
        $id = rand(1, 346464);
        $keySet = new KeySet([
            'keys' => [$id]
        ]);
        $row = [
            'id' => $id,
            'name' => uniqid(self::TESTING_PREFIX),
            'birthday' => new Date(new \DateTime())
        ];
        $cols = array_keys($row);

        $db->runTransaction(function ($t) use ($row) {
            $t->insert(self::TEST_TABLE_NAME, $row);
            $t->commit();
        });

        $snapshot = $db->snapshot();
        $res = $snapshot->read(self::TEST_TABLE_NAME, $keySet, $cols);
        $resRow = $res->rows()->current();
        $this->assertEquals($resRow['id'], $row['id']);
        $this->assertEquals($resRow['name'], $row['name']);
        $this->assertEquals(
            $resRow['birthday']->formatAsString(),
            $row['birthday']->formatAsString()
        );
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

        $row = $db->execute('SELECT * FROM ' . self::$tableName . ' WHERE id = @id', [
            'parameters' => [
                'id' => $id
            ]
        ])->rows()->current();

        $this->assertEquals(2, $row['number']);
        // Emulator aborts a parallel transaction therefore
        // iterations might be greater than 2
        $this->assertGreaterThanOrEqual(2, $iterations);
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
                $t->execute('SELECT * FROM ' . self::$tableName);
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

        $row = $db->execute('SELECT * FROM ' . self::$tableName . ' WHERE id = @id', [
            'parameters' => [
                'id' => $id
            ]
        ])->rows()->current();

        $this->assertEquals(2, $row['number']);
        // Emulator aborts a parallel transaction therefore
        // iterations might be greater than 2
        $this->assertGreaterThanOrEqual(2, $iterations);
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

        $row = $db->execute('SELECT * FROM ' . self::$tableName . ' WHERE id = @id', [
            'parameters' => [
                'id' => $id
            ]
        ])->rows()->current();

        $this->assertEquals(2, $row['number']);
        // Emulator aborts a parallel transaction therefore
        // iterations might be greater than 2
        $this->assertGreaterThanOrEqual(2, $iterations);
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

    /**
     * @dataProvider insertDbProvider
     */
    public function testRunTransactionWithDbRole($db, $values, $expected)
    {
        // Emulator does not support FGAC
        $this->skipEmulatorTests();

        $error = null;
        $row = $this->getRow();
        $row['name'] = 'Doug';

        $db->runTransaction(function ($t) use ($row) {
            $t->update(self::TEST_TABLE_NAME, $row);
            $t->commit();
        });
        $row = $this->getRow();
        $this->assertEquals('Doug', $row['name']);

        try {
            $db->runTransaction(function ($t) use ($values) {
                $id = rand(1, 346464);
                $t->insert(self::TEST_TABLE_NAME, $values);

                $t->commit();
            });
        } catch (ServiceException $e) {
            $error = $e;
        }

        if ($expected === null) {
            $this->assertEquals($error, $expected);
        } else {
            $this->assertEquals($error->getServiceException()->getStatus(), $expected);
        }
    }

    /**
     * @dataProvider getDirectedReadOptions
     */
    public function testTransactionExecuteWithDirectedRead($directedReadOptions)
    {
        // Emulator does not support DirectedRead
        $this->skipEmulatorTests();

        $db = self::$database;
        $id = $this->randId();

        $db->insert(self::$tableName, [
            'id' => $id,
            'number' => 0
        ]);

        $snapshot = $db->snapshot();
        $rows = $snapshot->execute(
            'SELECT * FROM ' . self::$tableName . ' WHERE id = ' . $id,
            $directedReadOptions
        )->rows()->current();
        $this->assertEquals(0, $rows['number']);

        $rows = $db->execute(
            'SELECT * FROM ' . self::$tableName . ' WHERE id = ' . $id,
            ['transactionId' => $snapshot->id()] + $directedReadOptions
        )->rows()->current();
        $this->assertEquals(0, $rows['number']);
    }

    /**
     * @dataProvider getDirectedReadOptions
     */
    public function testRWTransactionExecuteFailsWithDirectedRead($directedReadOptions)
    {
        // Emulator does not support DirectedRead
        $this->skipEmulatorTests();

        $db = self::$database;
        $transaction = $db->transaction();
        $expected = 'Directed reads can only be performed in a read-only transaction.';
        $exception = null;

        try {
            $rows = $db->execute(
                'SELECT * FROM ' . self::$tableName,
                ['transactionId' => $transaction->id()] + $directedReadOptions
            )->rows()->current();
        } catch (ServiceException $e) {
            $exception = $e;
        }
        $this->assertEquals($exception->getServiceException()->getBasicMessage(), $expected);

        $exception = null;
        try {
            $row = $transaction->execute(
                'SELECT * FROM ' . self::$tableName,
                $directedReadOptions
            )->rows()->current();
        } catch (ServiceException $e) {
            $exception = $e;
        }
        $this->assertEquals($exception->getServiceException()->getBasicMessage(), $expected);
    }

    /**
     * @dataProvider getDirectedReadOptions
     */
    public function testRWTransactionReadFailsWithDirectedRead($directedReadOptions)
    {
        // Emulator does not support DirectedRead
        $this->skipEmulatorTests();

        $db = self::$database;
        $transaction = $db->transaction();
        $expected = 'Directed reads can only be performed in a read-only transaction.';
        $exception = null;

        list($keySet, $cols) = $this->readArgs();
        try {
            $res = $db->read(
                self::TEST_TABLE_NAME,
                $keySet,
                $cols,
                ['transactionId' => $transaction->id()] + $directedReadOptions
            )->rows()->current();
        } catch (ServiceException $e) {
            $exception = $e;
        }
        $this->assertEquals($exception->getServiceException()->getBasicMessage(), $expected);
        $exception = null;

        try {
            $res = $transaction->read(
                self::TEST_TABLE_NAME,
                $keySet,
                $cols,
                $directedReadOptions
            )->rows()->current();
        } catch (ServiceException $e) {
            $exception = $e;
        }
        $this->assertEquals($exception->getServiceException()->getBasicMessage(), $expected);
    }

    public function testRunTransactionILBWithMultipleOperations()
    {
        $db = self::$database;

        $res = $db->runTransaction(function ($t) {
            $id = rand(1, 346464);
            $row = [
                'id' => $id,
                'name' => uniqid(self::TESTING_PREFIX),
                'birthday' => new Date(new \DateTime())
            ];
            // Representative of all mutations
            $t->insert(self::TEST_TABLE_NAME, $row);
            $this->assertNull($t->id());

            $id = rand(1, 346464);
            $t->executeUpdate(
                'INSERT INTO ' . self::TEST_TABLE_NAME . ' (id, name, birthday) VALUES (@id, @name, @birthday)',
                [
                    'parameters' => [
                        'id' => $id,
                        'name' => uniqid(self::TESTING_PREFIX),
                        'birthday' => new Date(new \DateTime())
                    ]
                ]
            );
            $transactionId = $t->id();
            $this->assertNotEmpty($t->id());

            $res = $t->execute('SELECT * FROM ' . self::TEST_TABLE_NAME . ' WHERE id = @id', [
                'parameters' => [
                    'id' => $id
                ]
            ]);
            $this->assertEquals($res->rows()->current()['id'], $id);
            // No new transaction created.
            $this->assertNull($res->transaction());
            $this->assertEquals($t->id(), $transactionId);

            $keyset = new KeySet(['keys' => [$id]]);
            $res = $t->read(self::TEST_TABLE_NAME, $keyset, ['id']);
            $this->assertEquals($res->rows()->current()['id'], $id);
            $this->assertNull($res->transaction());
            $this->assertEquals($t->id(), $transactionId);

            $res = $t->executeUpdateBatch([
                [
                    'sql' => 'UPDATE ' . self::TEST_TABLE_NAME . ' SET name = @name WHERE id = @id',
                    'parameters' => [
                        'id' => $id,
                        'name' => uniqid(self::TESTING_PREFIX)
                    ]
                ]
            ]);
            $this->assertEquals($t->id(), $transactionId);

            $t->commit();

            return $res;
        });

        $this->assertEquals([1], $res->rowCounts());
    }

    public function getDirectedReadOptions()
    {
        return
        [
            [[
                'directedReadOptions' => [
                    'includeReplicas' => [
                        'replicaSelections' => [
                            [
                                'location' => 'asia-northeast1',
                                'type' => ReplicaType::READ_WRITE
                            ]
                        ],
                        'autoFailoverDisabled' => false
                    ]
                ]
            ]],
            [[
                'directedReadOptions' => [
                    'excludeReplicas' => [
                        'replicaSelections' => [
                            [
                                'location' => 'asia-northeast1',
                                'type' => ReplicaType::READ_WRITE
                            ]
                        ]
                    ]
                ]
            ]]
        ];
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

    private function getRow()
    {
        $db = self::$database;
        $res = $db->execute('SELECT id, name FROM ' . self::TEST_TABLE_NAME . ' WHERE id=@id', [
            'parameters' => [
                'id' => self::$id1
            ]
        ]);

        return $res->rows()->current();
    }
}
