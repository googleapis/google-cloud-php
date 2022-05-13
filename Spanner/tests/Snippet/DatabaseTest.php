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

namespace Google\Cloud\Spanner\Tests\Snippet;

use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Backup;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\Snapshot;
use Google\Cloud\Spanner\Tests\OperationRefreshTrait;
use Google\Cloud\Spanner\Tests\ResultGeneratorTrait;
use Google\Cloud\Spanner\Tests\StubCreationTrait;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use Prophecy\Argument;

/**
 * @group spanner
 * @group spanner-database
 */
class DatabaseTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use OperationRefreshTrait;
    use ResultGeneratorTrait;
    use StubCreationTrait;

    const PROJECT = 'my-awesome-project';
    const DATABASE = 'my-database';
    const INSTANCE = 'my-instance';
    const TRANSACTION = 'my-transaction';
    const BACKUP = 'my-backup';

    private $connection;
    private $database;
    private $instance;

    public function set_up()
    {
        $this->checkAndSkipGrpcTests();

        $session = $this->prophesize(Session::class);
        $session->info()
            ->willReturn([
                'databaseName' => 'database'
            ]);
        $session->name()
            ->willReturn('database');
        $session->setExpiration(Argument::any())
            ->willReturn(100);

        $sessionPool = $this->prophesize(SessionPoolInterface::class);
        $sessionPool->acquire(Argument::any())
            ->willReturn($session->reveal());
        $sessionPool->setDatabase(Argument::any())
            ->willReturn(null);
        $sessionPool->clear()->willReturn(null);

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->instance = TestHelpers::stub(Instance::class, [
            $this->connection->reveal(),
            $this->prophesize(LongRunningConnectionInterface::class)->reveal(),
            [],
            self::PROJECT,
            self::INSTANCE
        ], ['connection', 'lroConnection']);

        $this->database = TestHelpers::stub(Database::class, [
            $this->connection->reveal(),
            $this->instance,
            $this->prophesize(LongRunningConnectionInterface::class)->reveal(),
            [],
            self::PROJECT,
            self::DATABASE,
            $sessionPool->reveal()
        ], ['connection', 'operation', 'lroConnection']);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Database::class);
        $res = $snippet->invoke('database');
        $this->assertInstanceOf(Database::class, $res->returnVal());
        $this->assertEquals(self::DATABASE, DatabaseAdminClient::parseName($res->returnVal()->name())['database']);
    }

    public function testClassViaInstance()
    {
        if (!extension_loaded('grpc')) {
            $this->markTestSkipped('Must have the grpc extension installed to run this test.');
        }

        $snippet = $this->snippetFromClass(Database::class, 1);
        $res = $snippet->invoke('database');
        $this->assertInstanceOf(Database::class, $res->returnVal());
        $this->assertEquals(self::DATABASE, DatabaseAdminClient::parseName($res->returnVal()->name())['database']);
    }

    /**
     * @group spanner-admin
     */
    public function testState()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'state');
        $snippet->addLocal('database', $this->database);
        $snippet->addUse(Database::class);

        $this->connection->getDatabase(Argument::any())
            ->shouldBeCalledTimes(1)
            ->WillReturn(['state' => Database::STATE_READY]);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Database is ready!', $res->output());
    }

    /**
     * @group spanner-admin
     */
    public function testBackups()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'backups');
        $snippet->addLocal('database', $this->database);

        $this->connection->listBackups(Argument::any())
            ->shouldBeCalled()
            ->WillReturn([
                'backups' => [
                    [
                        'name' => DatabaseAdminClient::backupName(self::PROJECT, self::INSTANCE, self::BACKUP)
                    ]
                ]
            ]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('backups');

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertContainsOnlyInstancesOf(Backup::class, $res->returnVal());
    }

    /**
     * @group spanner-admin
     */
    public function testCreateBackup()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'createBackup');
        $snippet->addLocal('database', $this->database);

        $this->connection->createBackup(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(['name' => 'my-operations']);

        $this->database->___setProperty('connection', $this->connection->reveal());
        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'name');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke('name');
        $this->assertEquals(self::DATABASE, DatabaseAdminClient::parseName($res->returnVal())['database']);
    }

    /**
     * @group spanner-admin
     */
    public function testExists()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'exists');
        $snippet->addLocal('database', $this->database);

        $this->connection->getDatabase(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['statements' => []]);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Database exists!', $res->output());
    }

    /**
     * @group spanner-admin
     */
    public function testInfo()
    {
        $db = ['name' => 'foo'];

        $snippet = $this->snippetFromMethod(Database::class, 'info');
        $snippet->addLocal('database', $this->database);

        $this->connection->getDatabase(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn($db);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('info');
        $this->assertEquals($db, $res->returnVal());
        $snippet->invoke();
    }

    /**
     * @group spanner-admin
     */
    public function testReload()
    {
        $db = ['name' => 'foo'];

        $snippet = $this->snippetFromMethod(Database::class, 'reload');
        $snippet->addLocal('database', $this->database);

        $this->connection->getDatabase(Argument::any())
            ->shouldBeCalledTimes(2)
            ->willReturn($db);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('info');
        $this->assertEquals($db, $res->returnVal());
        $snippet->invoke();
    }

    /**
     * @group spanner-admin
     */
    public function testCreate()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'create');
        $snippet->addLocal('database', $this->database);

        $this->connection->createDatabase(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'my-operation'
            ]);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal());
    }

    /**
     * @group spanner-admin
     */
    public function testRestore()
    {
        $backup = DatabaseAdminClient::backupName(self::PROJECT, self::INSTANCE, self::BACKUP);
        $snippet = $this->snippetFromMethod(Database::class, 'restore');
        $snippet->addLocal('database', $this->database);
        $snippet->addLocal('backup', $backup);

        $this->connection->restoreDatabase(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'my-operation'
            ]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal());
    }

    /**
     * @group spanner-admin
     */
    public function testUpdateDdl()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'updateDdl');
        $snippet->addLocal('database', $this->database);

        $this->connection->updateDatabaseDdl(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'my-operation'
            ]);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    /**
     * @group spanner-admin
     */
    public function testUpdateDdlBatch()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'updateDdlBatch');
        $snippet->addLocal('database', $this->database);

        $this->connection->updateDatabaseDdl(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'my-operation'
            ]);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    /**
     * @group spanner-admin
     */
    public function testDrop()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'drop');
        $snippet->addLocal('database', $this->database);

        $this->connection->dropDatabase(Argument::any())
            ->shouldBeCalled();

        $this->database->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    /**
     * @group spanner-admin
     */
    public function testDdl()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'ddl');
        $snippet->addLocal('database', $this->database);

        $stmts = [
            'CREATE TABLE TestSuites',
            'CREATE TABLE TestCases'
        ];

        $this->connection->getDatabaseDDL(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'statements' => $stmts
            ]);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('statements');
        $this->assertEquals($stmts, $res->returnVal());
    }

    public function testSnapshot()
    {
        $this->connection->beginTransaction(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'id' => self::TRANSACTION
            ]);

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'snapshot');
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('snapshot');
        $this->assertInstanceOf(Snapshot::class, $res->returnVal());
    }

    public function testSnapshotReadTimestamp()
    {
        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'id' => self::TRANSACTION,
                'readTimestamp' => (new Timestamp(new \DateTime))->formatAsString()
            ]);

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'snapshot', 1);
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('timestamp');
        $this->assertInstanceOf(Timestamp::class, $res->returnVal());
    }

    public function testRunTransaction()
    {
        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'id' => self::TRANSACTION
            ]);

        $this->connection->commit(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'commitTimestamp' => (new Timestamp(new \DateTime))->formatAsString()
            ]);

        $this->connection->rollback(Argument::any())
            ->shouldNotBeCalled();

        $this->connection->executeStreamingSql(Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->yieldRows([
                [
                    'name' => 'loginCount',
                    'type' => Database::TYPE_INT64,
                    'value' => 0
                ]
            ]));

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'runTransaction');
        $snippet->addUse(Transaction::class);
        $snippet->addLocal('database', $this->database);
        $snippet->addLocal('username', 'foo');
        $snippet->addLocal('password', 'bar');

        $snippet->invoke();
    }

    public function testRunTransactionRollback()
    {
        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'id' => self::TRANSACTION
            ]);

        $this->connection->commit(Argument::any())
            ->shouldNotBeCalled();

        $this->connection->rollback(Argument::any())
            ->shouldBeCalled();

        $this->connection->executeStreamingSql(Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->resultGeneratorData([]));

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'runTransaction');
        $snippet->addUse(Transaction::class);
        $snippet->addLocal('database', $this->database);
        $snippet->addLocal('username', 'foo');
        $snippet->addLocal('password', 'bar');

        $snippet->invoke();
    }

    public function testTransaction()
    {
        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'id' => self::TRANSACTION
            ]);

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'transaction');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke('transaction');
        $this->assertInstanceOf(Transaction::class, $res->returnVal());
    }

    public function testInsert()
    {
        $this->connection->commit(Argument::that(function ($args) {
            return isset($args['mutations'][0]['insert']);
        }))->shouldBeCalled()->willReturn([
            'commitTimestamp' => (new Timestamp(new \DateTime))->formatAsString()
        ]);

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'insert');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }


    public function testInsertBatch()
    {
        $this->connection->commit(Argument::that(function ($args) {
            if (!isset($args['mutations'][0]['insert'])) {
                return false;
            }

            if (!isset($args['mutations'][1]['insert'])) {
                return false;
            }

            return true;
        }))->shouldBeCalled()->willReturn([
            'commitTimestamp' => (new Timestamp(new \DateTime))->formatAsString()
        ]);

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'insertBatch');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }

    public function testUpdate()
    {
        $this->connection->commit(Argument::that(function ($args) {
            return isset($args['mutations'][0]['update']);
        }))->shouldBeCalled()->willReturn([
            'commitTimestamp' => (new Timestamp(new \DateTime))->formatAsString()
        ]);

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'update');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }


    public function testUpdateBatch()
    {
        $this->connection->commit(Argument::that(function ($args) {
            if (!isset($args['mutations'][0]['update'])) {
                return false;
            }

            if (!isset($args['mutations'][1]['update'])) {
                return false;
            }

            return true;
        }))->shouldBeCalled()->willReturn([
            'commitTimestamp' => (new Timestamp(new \DateTime))->formatAsString()
        ]);

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'updateBatch');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }

    public function testInsertOrUpdate()
    {
        $this->connection->commit(Argument::that(function ($args) {
            return isset($args['mutations'][0]['insertOrUpdate']);
        }))->shouldBeCalled()->willReturn([
            'commitTimestamp' => (new Timestamp(new \DateTime))->formatAsString()
        ]);

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'insertOrUpdate');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }


    public function testInsertOrUpdateBatch()
    {
        $this->connection->commit(Argument::that(function ($args) {
            if (!isset($args['mutations'][0]['insertOrUpdate'])) {
                return false;
            }

            if (!isset($args['mutations'][1]['insertOrUpdate'])) {
                return false;
            }

            return true;
        }))->shouldBeCalled()->willReturn([
            'commitTimestamp' => (new Timestamp(new \DateTime))->formatAsString()
        ]);

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'insertOrUpdateBatch');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }

    public function testReplace()
    {
        $this->connection->commit(Argument::that(function ($args) {
            return isset($args['mutations'][0]['replace']);
        }))->shouldBeCalled()->willReturn([
            'commitTimestamp' => (new Timestamp(new \DateTime))->formatAsString()
        ]);

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'replace');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }


    public function testReplaceBatch()
    {
        $this->connection->commit(Argument::that(function ($args) {
            if (!isset($args['mutations'][0]['replace'])) {
                return false;
            }

            if (!isset($args['mutations'][1]['replace'])) {
                return false;
            }

            return true;
        }))->shouldBeCalled()->willReturn([
            'commitTimestamp' => (new Timestamp(new \DateTime))->formatAsString()
        ]);

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'replaceBatch');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }

    public function testDelete()
    {
        $this->connection->commit(Argument::that(function ($args) {
            return isset($args['mutations'][0]['delete']);
        }))->shouldBeCalled()->willReturn([
            'commitTimestamp' => (new Timestamp(new \DateTime))->formatAsString()
        ]);

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'delete');
        $snippet->addUse(KeySet::class);
        $snippet->addLocal('database', $this->database);
        $snippet->invoke();
    }

    public function testExecute()
    {
        $this->connection->executeStreamingSql(Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->resultGenerator());

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'execute');
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
    }

    public function testExecuteWithParameterType()
    {
        $this->connection->executeStreamingSql(Argument::that(function ($arg) {
            if (!isset($arg['params'])) {
                return false;
            }

            if (!isset($arg['paramTypes'])) {
                return false;
            }

            if ($arg['paramTypes']['timestamp']['code'] !== Database::TYPE_TIMESTAMP) {
                return false;
            }

            return true;
        }))->shouldBeCalled()->willReturn($this->resultGeneratorData([
            'metadata' => [
                'rowType' => [
                    'fields' => [
                        [
                            'name' => 'timestamp',
                            'type' => [
                                'code' => Database::TYPE_TIMESTAMP
                            ]
                        ]
                    ]
                ]
            ],
            'values' => [null]
        ]));

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'execute', 1);
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('timestamp');
        $this->assertNull($res->returnVal());
    }

    public function testExecuteWithEmptyArray()
    {
        $this->connection->executeStreamingSql(Argument::that(function ($arg) {
            if (!isset($arg['params'])) {
                return false;
            }

            if (!isset($arg['paramTypes'])) {
                return false;
            }

            if ($arg['paramTypes']['emptyArrayOfIntegers']['code'] !== Database::TYPE_ARRAY) {
                return false;
            }

            if ($arg['paramTypes']['emptyArrayOfIntegers']['arrayElementType']['code'] !== Database::TYPE_INT64) {
                return false;
            }

            return true;
        }))->shouldBeCalled()->willReturn($this->resultGeneratorData([
            'metadata' => [
                'rowType' => [
                    'fields' => [
                        [
                            'name' => 'numbers',
                            'type' => [
                                'code' => Database::TYPE_ARRAY,
                                'arrayElementType' => [
                                    'code' => Database::TYPE_INT64
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'values' => [[]]
        ]));

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'execute', 2);
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('emptyArray');
        $this->assertEmpty($res->returnVal());
    }

    public function testExecuteBeginSnapshot()
    {
        $this->connection->executeStreamingSql(Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->resultGenerator(false, self::TRANSACTION));

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'execute', 5);
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
        $this->assertInstanceOf(Snapshot::class, $res->returnVal()->snapshot());
    }

    public function testExecuteBeginTransaction()
    {
        $this->connection->executeStreamingSql(Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->resultGenerator(false, self::TRANSACTION));

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'execute', 6);
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
        $this->assertInstanceOf(Transaction::class, $res->returnVal()->transaction());
    }

    public function testExecutePartitionedUpdate()
    {
        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'id' => self::TRANSACTION
            ]);

        $this->connection->executeStreamingSql(Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->resultGenerator(true));

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'executePartitionedUpdate');
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('deactivatedUserCount');
        $this->assertEquals(1, $res->returnVal());
    }

    public function testRead()
    {
        $this->connection->streamingRead(Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->resultGenerator());

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'read');
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
    }

    public function testReadWithSnapshot()
    {
        $this->connection->streamingRead(Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->resultGenerator(false, self::TRANSACTION));

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'read', 1);
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
        $this->assertInstanceOf(Snapshot::class, $res->returnVal()->snapshot());
    }

    public function testReadWithTransaction()
    {
        $this->connection->streamingRead(Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->resultGenerator(false, self::TRANSACTION));

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'read', 2);
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
        $this->assertInstanceOf(Transaction::class, $res->returnVal()->transaction());
    }

    public function testSessionPool()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'sessionPool');
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('pool');
        $this->assertInstanceOf(SessionPoolInterface::class, $res->returnVal());
    }

    public function testClose()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'close');
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke();
    }

    public function testIam()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'iam');
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('iam');
        $this->assertInstanceOf(Iam::class, $res->returnVal());
    }

    public function testResumeOperation()
    {
        $snippet = $this->snippetFromMagicMethod(Database::class, 'resumeOperation');
        $snippet->addLocal('database', $this->database);
        $snippet->addLocal('operationName', 'foo');

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal());
        $this->assertEquals('foo', $res->returnVal()->name());
    }

    public function testLongRunningOperations()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'longRunningOperations');
        $snippet->addLocal('database', $this->database);

        $lroConnection = $this->prophesize(LongRunningConnectionInterface::class);
        $lroConnection->operations(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'operations' => [
                    [
                        'name' => 'foo'
                    ]
                ]
            ]);

        $this->database->___setProperty('lroConnection', $lroConnection->reveal());

        $res = $snippet->invoke('operations');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertContainsOnlyInstancesOf(LongRunningOperation::class, $res->returnVal());
    }
}
