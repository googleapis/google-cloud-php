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

namespace Google\Cloud\Spanner\Tests\Unit;

use Google\Cloud\Core\Exception\AbortedException;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\SpannerOperationRefreshTrait;
use Google\Cloud\Core\Testing\TestHelpers;
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
use Google\Cloud\Spanner\V1\SpannerClient;
use Google\Cloud\Spanner\ValueMapper;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group spanner
 * @group spanner-database
 */
class DatabaseTest extends TestCase
{
    use GrpcTestTrait;
    use SpannerOperationRefreshTrait;

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
    private $session;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->instance = $this->prophesize(Instance::class);
        $this->sessionPool = $this->prophesize(SessionPoolInterface::class);
        $this->lro = $this->prophesize(LongRunningConnectionInterface::class);
        $this->lroCallables = [];
        $this->session = TestHelpers::stub(Session::class, [
            $this->connection->reveal(),
            self::PROJECT,
            self::INSTANCE,
            self::DATABASE,
            self::SESSION
        ]);

        $this->sessionPool->acquire(Argument::type('string'))
            ->willReturn($this->session);
        $this->sessionPool->setDatabase(Argument::type(Database::class))
            ->willReturn(null);
        $this->sessionPool->release(Argument::type(Session::class))
            ->willReturn(null);

        $this->instance->name()->willReturn(InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE));

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
            'connection', 'operation', 'session', 'sessionPool'
        ];

        $this->database = TestHelpers::stub(Database::class, $args, $props);
    }

    public function testName()
    {
        $this->assertEquals(
            DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE),
            $this->database->name()
        );
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
            'name',
            DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
        ))->shouldBeCalled()->willReturn([]);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $this->assertTrue($this->database->exists());
    }

    /**
     * @group spanneradmin
     */
    public function testCreate()
    {
        $statement = 'foo';
        $this->connection->createDatabase([
            'instance' => $this->instance->reveal()->name(),
            'createStatement' => sprintf('CREATE DATABASE `%s`', self::DATABASE),
            'extraStatements' => [$statement]
        ])->willReturn([
            'name' => 'my-operation'
        ]);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $res = $this->database->create([
            'statements' => [$statement]
        ]);

        $this->assertInstanceOf(LongRunningOperation::class, $res);
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
            'name' => DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE),
            'statements' => [$statement]
        ])->willReturn([
            'name' => 'my-operation'
        ]);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $res = $this->database->updateDdl($statement);

        $this->assertInstanceOf(LongRunningOperation::class, $res);
    }

    /**
     * @group spanneradmin
     */
    public function testUpdateDdlBatch()
    {
        $statements = ['foo', 'bar'];
        $this->connection->updateDatabaseDdl([
            'name' => DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE),
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
            'name' => DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE),
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
            'name' => DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
        ])->shouldBeCalled();

        $this->sessionPool->clear()->shouldBeCalled()->willReturn(null);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $this->database->drop();
    }

    /**
     * @group spanneradmin
     */
    public function testDropDeleteSession()
    {
        $this->connection->createSession(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => SpannerClient::sessionName(self::PROJECT, self::INSTANCE, self::DATABASE, self::SESSION)
            ]);

        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'id' => self::TRANSACTION
            ]);

        $this->connection->deleteSession(Argument::any())
            ->shouldBeCalled();

        $this->connection->dropDatabase([
            'name' => DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
        ])->shouldBeCalled();

        $database = TestHelpers::stub(Database::class, [
            $this->connection->reveal(),
            $this->instance->reveal(),
            $this->lro->reveal(),
            $this->lroCallables,
            self::PROJECT,
            self::DATABASE
        ]);

        // This will set a session on the Database class.
        $database->transaction();

        $database->drop();
    }

    /**
     * @group spanneradmin
     */
    public function testDdl()
    {
        $ddl = ['create table users', 'create table posts'];
        $this->connection->getDatabaseDDL([
            'name' => DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
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
            'name' => DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
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

        $this->refreshOperation($this->database, $this->connection->reveal());

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

        $this->refreshOperation($this->database, $this->connection->reveal());

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

        $this->refreshOperation($this->database, $this->connection->reveal());

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

        $this->refreshOperation($this->database, $this->connection->reveal());

        $this->database->runTransaction($this->noop());
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

        $this->refreshOperation($this->database, $this->connection->reveal());

        $this->database->runTransaction(function ($t) {
            $this->database->runTransaction($this->noop());
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
            ->will(function () use (&$it, $abort) {
                $it++;
                if ($it <= 2) {
                    throw $abort;
                }

                return ['commitTimestamp' => TransactionTest::TIMESTAMP];
            });

        $this->refreshOperation($this->database, $this->connection->reveal());

        $this->database->runTransaction(function ($t) use ($it) {
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
            ->will(function () use (&$it, $abort) {
                $it++;

                if ($it <= Database::MAX_RETRIES+1) {
                    throw $abort;
                }

                return ['commitTimestamp' => TransactionTest::TIMESTAMP];
            });

        $this->refreshOperation($this->database, $this->connection->reveal());

        $this->database->runTransaction(function ($t) {
            $t->commit();
        });
    }

    public function testTransaction()
    {
        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['id' => self::TRANSACTION]);

        $this->refreshOperation($this->database, $this->connection->reveal());

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

        $this->refreshOperation($this->database, $this->connection->reveal());

        $this->database->runTransaction(function ($t) {
            $this->database->transaction();
        });
    }

    public function testInsert()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][OPERATION::OP_INSERT]['table'] !== $table) {
                return false;
            }

            if ($arg['mutations'][0][OPERATION::OP_INSERT]['columns'][0] !== array_keys($row)[0]) {
                return false;
            }

            if ($arg['mutations'][0][OPERATION::OP_INSERT]['values'][0] !== current($row)) {
                return false;
            }

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation($this->database, $this->connection->reveal());

        $res = $this->database->insert($table, $row);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testInsertBatch()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][OPERATION::OP_INSERT]['table'] !== $table) {
                return false;
            }

            if ($arg['mutations'][0][OPERATION::OP_INSERT]['columns'][0] !== array_keys($row)[0]) {
                return false;
            }

            if ($arg['mutations'][0][OPERATION::OP_INSERT]['values'][0] !== current($row)) {
                return false;
            }

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation($this->database, $this->connection->reveal());

        $res = $this->database->insertBatch($table, [$row]);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testUpdate()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][Operation::OP_UPDATE]['table'] !== $table) {
                return false;
            }

            if ($arg['mutations'][0][Operation::OP_UPDATE]['columns'][0] !== array_keys($row)[0]) {
                return false;
            }

            if ($arg['mutations'][0][Operation::OP_UPDATE]['values'][0] !== current($row)) {
                return false;
            }

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation($this->database, $this->connection->reveal());

        $res = $this->database->update($table, $row);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testUpdateBatch()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][Operation::OP_UPDATE]['table'] !== $table) {
                return false;
            }

            if ($arg['mutations'][0][Operation::OP_UPDATE]['columns'][0] !== array_keys($row)[0]) {
                return false;
            }

            if ($arg['mutations'][0][Operation::OP_UPDATE]['values'][0] !== current($row)) {
                return false;
            }

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation($this->database, $this->connection->reveal());

        $res = $this->database->updateBatch($table, [$row]);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testInsertOrUpdate()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][Operation::OP_INSERT_OR_UPDATE]['table'] !== $table) {
                return false;
            }

            if ($arg['mutations'][0][Operation::OP_INSERT_OR_UPDATE]['columns'][0] !== array_keys($row)[0]) {
                return false;
            }

            if ($arg['mutations'][0][Operation::OP_INSERT_OR_UPDATE]['values'][0] !== current($row)) {
                return false;
            }

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation($this->database, $this->connection->reveal());

        $res = $this->database->insertOrUpdate($table, $row);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testInsertOrUpdateBatch()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][Operation::OP_INSERT_OR_UPDATE]['table'] !== $table) {
                return false;
            }

            if ($arg['mutations'][0][Operation::OP_INSERT_OR_UPDATE]['columns'][0] !== array_keys($row)[0]) {
                return false;
            }

            if ($arg['mutations'][0][Operation::OP_INSERT_OR_UPDATE]['values'][0] !== current($row)) {
                return false;
            }

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation($this->database, $this->connection->reveal());

        $res = $this->database->insertOrUpdateBatch($table, [$row]);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testReplace()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][Operation::OP_REPLACE]['table'] !== $table) {
                return false;
            }

            if ($arg['mutations'][0][Operation::OP_REPLACE]['columns'][0] !== array_keys($row)[0]) {
                return false;
            }

            if ($arg['mutations'][0][Operation::OP_REPLACE]['values'][0] !== current($row)) {
                return false;
            }

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation($this->database, $this->connection->reveal());

        $res = $this->database->replace($table, $row);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testReplaceBatch()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][Operation::OP_REPLACE]['table'] !== $table) {
                return false;
            }

            if ($arg['mutations'][0][Operation::OP_REPLACE]['columns'][0] !== array_keys($row)[0]) {
                return false;
            }

            if ($arg['mutations'][0][Operation::OP_REPLACE]['values'][0] !== current($row)) {
                return false;
            }

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation($this->database, $this->connection->reveal());

        $res = $this->database->replaceBatch($table, [$row]);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testDelete()
    {
        $table = 'foo';
        $keys = [10, 'bar'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $keys) {
            if ($arg['mutations'][0][Operation::OP_DELETE]['table'] !== $table) {
                return false;
            }

            if ($arg['mutations'][0][Operation::OP_DELETE]['keySet']['keys'][0] !== (string) $keys[0]) {
                return false;
            }

            if ($arg['mutations'][0][Operation::OP_DELETE]['keySet']['keys'][1] !== $keys[1]) {
                return false;
            }

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation($this->database, $this->connection->reveal());

        $res = $this->database->delete($table, new KeySet(['keys' => $keys]));
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testExecute()
    {
        $sql = 'SELECT * FROM Table';

        $this->connection->executeStreamingSql(Argument::that(function ($arg) use ($sql) {
            return $arg['sql'] === $sql;
        }))->shouldBeCalled()->willReturn($this->resultGenerator());

        $this->refreshOperation($this->database, $this->connection->reveal());

        $res = $this->database->execute($sql);
        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertEquals(10, $rows[0]['ID']);
    }

    public function testExecuteWithSingleSession()
    {
        $this->database->___setProperty('sessionPool', null);
        $this->database->___setProperty('session', $this->session);
        $sql = 'SELECT * FROM Table';

        $sessName = SpannerClient::sessionName(self::PROJECT, self::INSTANCE, self::DATABASE, self::SESSION);
        $this->connection->executeStreamingSql(Argument::withEntry('session', $sessName))
            ->shouldBeCalled()
            ->willReturn($this->resultGenerator());

        $this->refreshOperation($this->database, $this->connection->reveal());

        $res = $this->database->execute($sql);
        $rows = iterator_to_array($res->rows());
    }

    public function testRead()
    {
        $table = 'Table';
        $opts = ['foo' => 'bar'];

        $this->connection->streamingRead(Argument::that(function ($arg) use ($table, $opts) {
            if ($arg['table'] !== $table) {
                return false;
            }

            if ($arg['keySet']['all'] !== true) {
                return false;
            }

            if ($arg['columns'] !== ['ID']) {
                return false;
            }

            return true;
        }))->shouldBeCalled()->willReturn($this->resultGenerator());

        $this->refreshOperation($this->database, $this->connection->reveal());

        $res = $this->database->read($table, new KeySet(['all' => true]), ['ID']);
        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertEquals(10, $rows[0]['ID']);
    }

    public function testSessionPool()
    {
        $this->assertInstanceOf(SessionPoolInterface::class, $this->database->sessionPool());
    }

    public function testClose()
    {
        $this->sessionPool->release(Argument::type(Session::class))
            ->shouldBeCalled()
            ->willReturn(null);

        $this->database->___setProperty('sessionPool', $this->sessionPool->reveal());
        $this->database->___setProperty('session', $this->session);

        $this->database->close();

        $this->assertNull($this->database->___getProperty('session'));
    }

    public function testCloseNoPool()
    {
        $this->connection->deleteSession(Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);

        $this->session->___setProperty('connection', $this->connection->reveal());
        $this->database->___setProperty('sessionPool', null);
        $this->database->___setProperty('session', $this->session);

        $this->database->close();
    }

    public function testCreateSession()
    {
        $db = SpannerClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE);
        $sessName = SpannerClient::sessionName(self::PROJECT, self::INSTANCE, self::DATABASE, self::SESSION);
        $this->connection->createSession(Argument::withEntry('database', $db))
            ->shouldBeCalled()
            ->willReturn([
                'name' => $sessName
            ]);

        $this->refreshOperation($this->database, $this->connection->reveal());

        $sess = $this->database->createSession();

        $this->assertInstanceOf(Session::class, $sess);
        $this->assertEquals($sessName, $sess->name());
    }

    public function testSession()
    {
        $sess = $this->database->session(
            SpannerClient::sessionName(self::PROJECT, self::INSTANCE, self::DATABASE, self::SESSION)
        );

        $this->assertInstanceOf(Session::class, $sess);
        $this->assertEquals(
            SpannerClient::sessionName(self::PROJECT, self::INSTANCE, self::DATABASE, self::SESSION),
            $sess->name()
        );
    }

    public function testIdentity()
    {
        $this->assertEquals([
            'projectId' => self::PROJECT,
            'database' => self::DATABASE,
            'instance' => self::INSTANCE
        ], $this->database->identity());
    }

    public function testConnection()
    {
        $this->assertInstanceOf(ConnectionInterface::class, $this->database->connection());
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

    private function commitResponse()
    {
        return ['commitTimestamp' => '2017-01-09T18:05:22.534799Z'];
    }

    private function assertTimestampIsCorrect($res)
    {
        $ts = new \DateTimeImmutable($this->commitResponse()['commitTimestamp']);

        $this->assertEquals($ts->format('Y-m-d\TH:i:s\Z'), $res->get()->format('Y-m-d\TH:i:s\Z'));
    }

    private function noop()
    {
        return function () {
            return;
        };
    }
}
