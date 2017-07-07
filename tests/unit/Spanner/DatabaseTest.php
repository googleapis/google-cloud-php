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

namespace Google\Cloud\Tests\Unit\Spanner;

use Google\Cloud\Core\Exception\AbortedException;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\Snapshot;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\ValueMapper;
use Google\Cloud\Tests\GrpcTestTrait;
use Prophecy\Argument;

/**
 * @group spanner
 */
class DatabaseTest extends \PHPUnit_Framework_TestCase
{
    use GrpcTestTrait;

    const PROJECT = 'my-awesome-project';
    const DATABASE = 'my-database';
    const INSTANCE = 'my-instance';
    const SESSION = 'my-session';
    const TRANSACTION = 'my-transaction';

    private $connection;
    private $instance;
    private $sessionPool;
    private $lro;
    private $lroCallables;
    private $database;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->instance = $this->prophesize(Instance::class);
        $this->sessionPool = $this->prophesize(SessionPoolInterface::class);
        $this->lro = $this->prophesize(LongRunningConnectionInterface::class);
        $this->lroCallables = [];

        $this->sessionPool->acquire(Argument::type('string'))
            ->willReturn(new Session(
                $this->connection->reveal(),
                self::PROJECT,
                self::INSTANCE,
                self::DATABASE,
                self::SESSION
            ));
        $this->sessionPool->setDatabase(Argument::type(Database::class))
            ->willReturn(null);
        $this->sessionPool->release(Argument::type(Session::class))
            ->willReturn(null);

        $this->instance->name()->willReturn(InstanceAdminClient::formatInstanceName(self::PROJECT, self::INSTANCE));

        $args = [
            $this->connection->reveal(),
            $this->instance->reveal(),
            $this->lro->reveal(),
            $this->lroCallables,
            self::PROJECT,
            self::DATABASE,
            $this->sessionPool->reveal()
        ];

        $props = [
            'connection', 'operation'
        ];

        $this->database = \Google\Cloud\Dev\stub(Database::class, $args, $props);
    }

    public function testName()
    {
        $this->assertEquals($this->database->name(), DatabaseAdminClient::formatDatabaseName(self::PROJECT, self::INSTANCE, self::DATABASE));
    }

    public function testInfo()
    {
        $res = [
            'name' => $this->database->name()
        ];

        $this->connection->getDatabase(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn($res);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $this->assertEquals($res, $this->database->info());

        // Make sure the request only is sent once.
        $this->database->info();
    }

    public function testReload()
    {
        $res = [
            'name' => $this->database->name()
        ];

        $this->connection->getDatabase(Argument::any())
            ->shouldBeCalledTimes(2)
            ->willReturn($res);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $this->assertEquals($res, $this->database->reload());

        // Make sure the request is sent each time the method is called.
        $this->database->reload();
    }

    /**
     * @group spanneradmin
     */
    public function testExists()
    {
        $this->connection->getDatabase(Argument::withEntry(
            'name', DatabaseAdminClient::formatDatabaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
        ))
            ->shouldBeCalled()
            ->willReturn([]);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $this->assertTrue($this->database->exists());
    }

    /**
     * @group spanneradmin
     */
    public function testExistsNotFound()
    {
        $this->connection->getDatabase(Argument::any())
            ->shouldBeCalled()
            ->willThrow(new NotFoundException('', 404));

        $this->database->___setProperty('connection', $this->connection->reveal());

        $this->assertFalse($this->database->exists());
    }

    /**
     * @group spanneradmin
     */
    public function testUpdateDdl()
    {
        $statement = 'foo';
        $this->connection->updateDatabaseDdl([
            'name' => DatabaseAdminClient::formatDatabaseName(self::PROJECT, self::INSTANCE, self::DATABASE),
            'statements' => [$statement]
        ])->willReturn([
            'name' => 'my-operation'
        ]);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $this->database->updateDdl($statement);
    }

    /**
     * @group spanneradmin
     */
    public function testUpdateDdlBatch()
    {
        $statements = ['foo', 'bar'];
        $this->connection->updateDatabaseDdl([
            'name' => DatabaseAdminClient::formatDatabaseName(self::PROJECT, self::INSTANCE, self::DATABASE),
            'statements' => $statements
        ])->willReturn([
            'name' => 'my-operation'
        ]);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $this->database->updateDdlBatch($statements);
    }

    /**
     * @group spanneradmin
     */
    public function testUpdateWithSingleStatement()
    {
        $statement = 'foo';
        $this->connection->updateDatabaseDdl([
            'name' => DatabaseAdminClient::formatDatabaseName(self::PROJECT, self::INSTANCE, self::DATABASE),
            'statements' => ['foo']
        ])->shouldBeCalled()->willReturn(['name' => 'operations/foo']);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $res = $this->database->updateDdl($statement);
        $this->assertInstanceOf(LongRunningOperation::class, $res);
    }

    /**
     * @group spanneradmin
     */
    public function testDrop()
    {
        $this->connection->dropDatabase([
            'name' => DatabaseAdminClient::formatDatabaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
        ])->shouldBeCalled();

        $this->database->___setProperty('connection', $this->connection->reveal());

        $this->database->drop();
    }

    /**
     * @group spanneradmin
     */
    public function testDdl()
    {
        $ddl = ['create table users', 'create table posts'];
        $this->connection->getDatabaseDDL([
            'name' => DatabaseAdminClient::formatDatabaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
        ])->willReturn(['statements' => $ddl]);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $this->assertEquals($ddl, $this->database->ddl());
    }

    /**
     * @group spanneradmin
     */
    public function testDdlNoResult()
    {
        $this->connection->getDatabaseDDL([
            'name' => DatabaseAdminClient::formatDatabaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
        ])->willReturn([]);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $this->assertEquals([], $this->database->ddl());
    }

    /**
     * @group spanneradmin
     */
    public function testIam()
    {
        $this->assertInstanceOf(Iam::class, $this->database->iam());
    }

    public function testSnapshot()
    {
        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['id' => self::TRANSACTION]);

        $this->refreshOperation();

        $res = $this->database->snapshot();
        $this->assertInstanceOf(Snapshot::class, $res);
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testSnapshotMinReadTimestamp()
    {
        $this->database->snapshot(['minReadTimestamp' => 'foo']);
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testSnapshotMaxStaleness()
    {
        $this->database->snapshot(['maxStaleness' => 'foo']);
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testSnapshotNestedTransaction()
    {
        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['id' => self::TRANSACTION]);

        $this->connection->rollback(Argument::any())
            ->shouldNotBeCalled();

        $this->refreshOperation();

        $this->database->runTransaction(function ($t) {
            $this->database->snapshot();
        });
    }

    public function testRunTransaction()
    {
        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['id' => self::TRANSACTION]);

        $this->connection->commit(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['commitTimestamp' => '2017-01-09T18:05:22.534799Z']);

        $this->refreshOperation();

        $hasTransaction = false;

        $this->database->runTransaction(function (Transaction $t) use (&$hasTransaction) {
            $hasTransaction = true;

            $t->commit();
        });

        $this->assertTrue($hasTransaction);
    }

    /**
     * @expectedException RuntimeException
     */
    public function testRunTransactionNoCommit()
    {
        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['id' => self::TRANSACTION]);

        $this->connection->rollback(Argument::any())
            ->shouldBeCalled();

        $this->refreshOperation();

        $this->database->runTransaction(function (Transaction $t) {});
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testRunTransactionNestedTransaction()
    {
        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['id' => self::TRANSACTION]);

        $this->connection->rollback(Argument::any())
            ->shouldNotBeCalled();

        $this->refreshOperation();

        $this->database->runTransaction(function ($t) {
            $this->database->runTransaction(function ($t) {});
        });
    }

    public function testRunTransactionRetry()
    {
        $abort = new AbortedException('foo', 409, null, [
            [
                'retryDelay' => [
                    'seconds' => 1,
                    'nanos' => 0
                ]
            ]
        ]);

        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalledTimes(3)
            ->willReturn(['id' => self::TRANSACTION]);

        $it = 0;
        $this->connection->commit(Argument::any())
            ->shouldBeCalledTimes(3)
            ->will(function() use (&$it, $abort) {
                $it++;
                if ($it <= 2) {
                    throw $abort;
                }

                return ['commitTimestamp' => TransactionTest::TIMESTAMP];
            });

        $this->refreshOperation();

        $this->database->runTransaction(function($t) use ($it) {
            if ($it > 0) {
                $this->assertTrue($t->isRetry());
            } else {
                $this->assertFalse($t->isRetry());
            }

            $t->commit();
        });
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\AbortedException
     */
    public function testRunTransactionAborted()
    {
        $abort = new AbortedException('foo', 409, null, [
            [
                'retryDelay' => [
                    'seconds' => 0,
                    'nanos' => 500
                ]
            ]
        ]);

        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['id' => self::TRANSACTION]);

        $it = 0;
        $this->connection->commit(Argument::any())
            ->shouldBeCalled()
            ->will(function() use (&$it, $abort) {
                $it++;
                if ($it <= Database::MAX_RETRIES+1) {
                    throw $abort;
                }

                return ['commitTimestamp' => TransactionTest::TIMESTAMP];
            });

        $this->refreshOperation();

        $this->database->runTransaction(function($t){$t->commit();});
    }

    public function testTransaction()
    {
        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['id' => self::TRANSACTION]);

        $this->refreshOperation();

        $t = $this->database->transaction();
        $this->assertInstanceOf(Transaction::class, $t);
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testTransactionNestedTransaction()
    {
        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['id' => self::TRANSACTION]);

        $this->connection->rollback(Argument::any())
            ->shouldNotBeCalled();

        $this->refreshOperation();

        $this->database->runTransaction(function ($t) {
            $this->database->transaction();
        });
    }

    public function testInsert()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][OPERATION::OP_INSERT]['table'] !== $table) return false;
            if ($arg['mutations'][0][OPERATION::OP_INSERT]['columns'][0] !== array_keys($row)[0]) return false;
            if ($arg['mutations'][0][OPERATION::OP_INSERT]['values'][0] !== current($row)) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation();

        $res = $this->database->insert($table, $row);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testInsertBatch()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][OPERATION::OP_INSERT]['table'] !== $table) return false;
            if ($arg['mutations'][0][OPERATION::OP_INSERT]['columns'][0] !== array_keys($row)[0]) return false;
            if ($arg['mutations'][0][OPERATION::OP_INSERT]['values'][0] !== current($row)) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation();

        $res = $this->database->insertBatch($table, [$row]);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testUpdate()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][Operation::OP_UPDATE]['table'] !== $table) return false;
            if ($arg['mutations'][0][Operation::OP_UPDATE]['columns'][0] !== array_keys($row)[0]) return false;
            if ($arg['mutations'][0][Operation::OP_UPDATE]['values'][0] !== current($row)) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation();

        $res = $this->database->update($table, $row);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testUpdateBatch()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][Operation::OP_UPDATE]['table'] !== $table) return false;
            if ($arg['mutations'][0][Operation::OP_UPDATE]['columns'][0] !== array_keys($row)[0]) return false;
            if ($arg['mutations'][0][Operation::OP_UPDATE]['values'][0] !== current($row)) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation();

        $res = $this->database->updateBatch($table, [$row]);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testInsertOrUpdate()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][Operation::OP_INSERT_OR_UPDATE]['table'] !== $table) return false;
            if ($arg['mutations'][0][Operation::OP_INSERT_OR_UPDATE]['columns'][0] !== array_keys($row)[0]) return false;
            if ($arg['mutations'][0][Operation::OP_INSERT_OR_UPDATE]['values'][0] !== current($row)) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation();

        $res = $this->database->insertOrUpdate($table, $row);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testInsertOrUpdateBatch()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][Operation::OP_INSERT_OR_UPDATE]['table'] !== $table) return false;
            if ($arg['mutations'][0][Operation::OP_INSERT_OR_UPDATE]['columns'][0] !== array_keys($row)[0]) return false;
            if ($arg['mutations'][0][Operation::OP_INSERT_OR_UPDATE]['values'][0] !== current($row)) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation();

        $res = $this->database->insertOrUpdateBatch($table, [$row]);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testReplace()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][Operation::OP_REPLACE]['table'] !== $table) return false;
            if ($arg['mutations'][0][Operation::OP_REPLACE]['columns'][0] !== array_keys($row)[0]) return false;
            if ($arg['mutations'][0][Operation::OP_REPLACE]['values'][0] !== current($row)) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation();

        $res = $this->database->replace($table, $row);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testReplaceBatch()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][Operation::OP_REPLACE]['table'] !== $table) return false;
            if ($arg['mutations'][0][Operation::OP_REPLACE]['columns'][0] !== array_keys($row)[0]) return false;
            if ($arg['mutations'][0][Operation::OP_REPLACE]['values'][0] !== current($row)) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation();

        $res = $this->database->replaceBatch($table, [$row]);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testDelete()
    {
        $table = 'foo';
        $keys = [10, 'bar'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $keys) {
            if ($arg['mutations'][0][Operation::OP_DELETE]['table'] !== $table) return false;
            if ($arg['mutations'][0][Operation::OP_DELETE]['keySet']['keys'][0] !== (string) $keys[0]) return false;
            if ($arg['mutations'][0][Operation::OP_DELETE]['keySet']['keys'][1] !== $keys[1]) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation();

        $res = $this->database->delete($table, new KeySet(['keys' => $keys]));
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testExecute()
    {
        $sql = 'SELECT * FROM Table';

        $this->connection->executeStreamingSql(Argument::that(function ($arg) use ($sql) {
            if ($arg['sql'] !== $sql) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->resultGenerator());

        $this->refreshOperation();

        $res = $this->database->execute($sql);
        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertEquals(10, $rows[0]['ID']);
    }

    public function testRead()
    {
        $table = 'Table';
        $opts = ['foo' => 'bar'];

        $this->connection->streamingRead(Argument::that(function ($arg) use ($table, $opts) {
            if ($arg['table'] !== $table) return false;
            if ($arg['keySet']['all'] !== true) return false;
            if ($arg['columns'] !== ['ID']) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->resultGenerator());

        $this->refreshOperation();

        $res = $this->database->read($table, new KeySet(['all' => true]), ['ID']);
        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertEquals(10, $rows[0]['ID']);
    }

    // *******
    // Helpers

    private function resultGenerator()
    {
        yield [
            'metadata' => [
                'rowType' => [
                    'fields' => [
                        [
                            'name' => 'ID',
                            'type' => [
                                'code' => Database::TYPE_INT64
                            ]
                        ]
                    ]
                ]
            ],
            'values' => [
                '10'
            ]
        ];
    }

    private function refreshOperation()
    {
        $operation = new Operation($this->connection->reveal(), false);
        $this->database->___setProperty('operation', $operation);
    }

    private function commitResponse()
    {
        return ['commitTimestamp' => '2017-01-09T18:05:22.534799Z'];
    }

    private function assertTimestampIsCorrect($res)
    {
        $ts = new \DateTimeImmutable($this->commitResponse()['commitTimestamp']);

        $this->assertEquals($ts->format('Y-m-d\TH:i:s\Z'), $res->get()->format('Y-m-d\TH:i:s\Z'));
    }
}
