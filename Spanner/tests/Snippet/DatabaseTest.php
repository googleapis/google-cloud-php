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
use Prophecy\Argument;

/**
 * @group spanner
 * @group spanner-database
 */
class DatabaseTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use SpannerOperationRefreshTrait;

    const PROJECT = 'my-awesome-project';
    const DATABASE = 'my-database';
    const INSTANCE = 'my-instance';
    const TRANSACTION = 'my-transaction';

    private $connection;
    private $database;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $instance = $this->prophesize(Instance::class);
        $instance->name()->willReturn(InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE));

        $session = $this->prophesize(Session::class);

        $sessionPool = $this->prophesize(SessionPoolInterface::class);
        $sessionPool->acquire(Argument::any())
            ->willReturn($session->reveal());
        $sessionPool->setDatabase(Argument::any())
            ->willReturn(null);

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->database = TestHelpers::stub(Database::class, [
            $this->connection->reveal(),
            $instance->reveal(),
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
            ->willReturn($this->resultGenerator([
                'metadata' => [
                    'rowType' => [
                        'fields' => [
                            [
                                'name' => 'loginCount',
                                'type' => [
                                    'code' => Database::TYPE_INT64
                                ]
                            ]
                        ]
                    ]
                ],
                'values' => [0]
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
            ->willReturn($this->resultGenerator([
                'metadata' => [
                    'rowType' => [
                        'fields' => []
                    ]
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

    public function testExecuteBeginSnapshot()
    {
        $this->connection->executeStreamingSql(Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->resultGenerator([
                'metadata' => [
                    'rowType' => [
                        'fields' => [
                            [
                                'name' => 'loginCount',
                                'type' => [
                                    'code' => Database::TYPE_INT64
                                ]
                            ]
                        ]
                    ],
                    'transaction' => [
                        'id' => self::TRANSACTION
                    ]
                ],
                'values' => [0]
            ]));

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
            ->willReturn($this->resultGenerator([
                'metadata' => [
                    'rowType' => [
                        'fields' => [
                            [
                                'name' => 'loginCount',
                                'type' => [
                                    'code' => Database::TYPE_INT64
                                ]
                            ]
                        ]
                    ],
                    'transaction' => [
                        'id' => self::TRANSACTION
                    ]
                ],
                'values' => [0]
            ]));

        $this->refreshOperation($this->database, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(Database::class, 'execute', 6);
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
        $this->assertInstanceOf(Transaction::class, $res->returnVal()->transaction());
    }

    public function testReadWithSnapshot()
    {
        $this->connection->streamingRead(Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->resultGenerator([
                'metadata' => [
                    'rowType' => [
                        'fields' => [
                            [
                                'name' => 'loginCount',
                                'type' => [
                                    'code' => Database::TYPE_INT64
                                ]
                            ]
                        ]
                    ],
                    'transaction' => [
                        'id' => self::TRANSACTION
                    ]
                ],
                'values' => [0]
            ]));

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
            ->willReturn($this->resultGenerator([
                'metadata' => [
                    'rowType' => [
                        'fields' => [
                            [
                                'name' => 'loginCount',
                                'type' => [
                                    'code' => Database::TYPE_INT64
                                ]
                            ]
                        ]
                    ],
                    'transaction' => [
                        'id' => self::TRANSACTION
                    ]
                ],
                'values' => [0]
            ]));

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

    private function resultGenerator(array $data)
    {
        yield $data;
    }
}
