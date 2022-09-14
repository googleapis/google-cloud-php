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
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseDialect;
use Google\Cloud\Spanner\Admin\Database\V1\RestoreInfo;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Backup;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Duration;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\Snapshot;
use Google\Cloud\Spanner\Tests\OperationRefreshTrait;
use Google\Cloud\Spanner\Tests\ResultGeneratorTrait;
use Google\Cloud\Spanner\Tests\StubCreationTrait;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\V1\SpannerClient;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group spanner
 * @group spanner-database
 */
class DatabaseTest extends TestCase
{
    use ExpectException;
    use GrpcTestTrait;
    use OperationRefreshTrait;
    use ResultGeneratorTrait;
    use StubCreationTrait;

    const PROJECT = 'my-awesome-project';
    const DATABASE = 'my-database';
    const INSTANCE = 'my-instance';
    const SESSION = 'my-session';
    const TRANSACTION = 'my-transaction';
    const BACKUP = 'my-backup';
    const TRANSACTION_TAG = 'my-transaction-tag';

    private $connection;
    private $instance;
    private $sessionPool;
    private $lro;
    private $lroCallables;
    private $database;
    private $session;


    public function set_up()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);

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

        $this->instance = TestHelpers::stub(Instance::class, [
            $this->connection->reveal(),
            $this->lro->reveal(),
            $this->lroCallables,
            self::PROJECT,
            self::INSTANCE
        ], [
            'info',
            'connection'
        ]);

        $this->sessionPool->acquire(Argument::type('string'))
            ->willReturn($this->session);
        $this->sessionPool->setDatabase(Argument::type(Database::class))
            ->willReturn(null);
        $this->sessionPool->release(Argument::type(Session::class))
            ->willReturn(null);

        $args = [
            $this->connection->reveal(),
            $this->instance,
            $this->lro->reveal(),
            $this->lroCallables,
            self::PROJECT,
            self::DATABASE,
            $this->sessionPool->reveal()
        ];

        $props = [
            'connection', 'operation', 'session', 'sessionPool', 'instance'
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

        $this->connection->getDatabase(Argument::withEntry('name', $this->database->name()))
            ->shouldBeCalledTimes(1)
            ->willReturn($res);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $this->assertEquals($res, $this->database->info());

        // Make sure the request only is sent once.
        $this->database->info();
    }

    public function testState()
    {
        $res = [
            'state' => Database::STATE_READY
        ];
        $this->connection->getDatabase(Argument::withEntry('name', $this->database->name()))
            ->shouldBeCalledTimes(1)
            ->willReturn($res);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $this->assertEquals(Database::STATE_READY, $this->database->state());

        // Make sure the request only is sent once.
        $this->database->state();
    }

    public function testCreateBackup()
    {
        $expireTime = new \DateTime();
        $this->connection->createBackup(Argument::allOf(
            Argument::withEntry('instance', $this->instance->name()),
            Argument::withEntry('backupId', self::BACKUP),
            Argument::withEntry('backup', [
                'database' => $this->database->name(),
                'expireTime' => $expireTime->format('Y-m-d\TH:i:s.u\Z')
            ])
        ))
            ->shouldBeCalled()
            ->willReturn(['name' => 'operations/foo']);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $op = $this->database->createBackup(self::BACKUP, $expireTime);

        $this->assertInstanceOf(LongRunningOperation::class, $op);
    }

    public function testBackups()
    {
        $backups = [
            [
                'name' => DatabaseAdminClient::backupName(self::PROJECT, self::INSTANCE, 'backup1'),
            ],
            [
                'name' => DatabaseAdminClient::backupName(self::PROJECT, self::INSTANCE, 'backup2'),
            ]
        ];

        $expectedFilter = "database:".$this->database->name();
        $this->connection->listBackups(Argument::withEntry('filter', $expectedFilter))
            ->shouldBeCalled()
            ->willReturn(['backups' => $backups]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $bkps = $this->database->backups();

        $this->assertInstanceOf(ItemIterator::class, $bkps);

        $bkps = iterator_to_array($bkps);

        $this->assertCount(2, $bkps);
        $this->assertEquals('backup1', DatabaseAdminClient::parseName($bkps[0]->name())['backup']);
        $this->assertEquals('backup2', DatabaseAdminClient::parseName($bkps[1]->name())['backup']);
    }

    public function testBackupsWithCustomFilter()
    {
        $backups = [
            [
                'name' => DatabaseAdminClient::backupName(self::PROJECT, self::INSTANCE, 'backup1'),
            ],
            [
                'name' => DatabaseAdminClient::backupName(self::PROJECT, self::INSTANCE, 'backup2'),
            ]
        ];
        $defaultFilter = "database:" . $this->database->name();
        $customFilter = "customFilter";
        $expectedFilter = sprintf('(%1$s) AND (%2$s)', $defaultFilter, $customFilter);

        $this->connection->listBackups(Argument::withEntry('filter', $expectedFilter))
            ->shouldBeCalled()
            ->willReturn(['backups' => $backups]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $bkps = $this->database->backups(['filter' => $customFilter]);

        $this->assertInstanceOf(ItemIterator::class, $bkps);

        $bkps = iterator_to_array($bkps);

        $this->assertCount(2, $bkps);
        $this->assertEquals('backup1', DatabaseAdminClient::parseName($bkps[0]->name())['backup']);
        $this->assertEquals('backup2', DatabaseAdminClient::parseName($bkps[1]->name())['backup']);
    }

    public function testReload()
    {
        $res = [
            'name' => $this->database->name()
        ];

        $this->connection->getDatabase(Argument::withEntry('name', $this->database->name()))
            ->shouldBeCalledTimes(2)
            ->willReturn($res);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $this->assertEquals($res, $this->database->reload());

        // Make sure the request is sent each time the method is called.
        $this->database->reload();
    }

    /**
     * @group spanner-admin
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
     * @group spanner-admin
     */
    public function testExistsNotFound()
    {
        $this->connection->getDatabase(Argument::withEntry('name', $this->database->name()))
            ->shouldBeCalled()
            ->willThrow(new NotFoundException('', 404));

        $this->database->___setProperty('connection', $this->connection->reveal());

        $this->assertFalse($this->database->exists());
    }

    /**
     * @group spanner-admin
     */
    public function testCreate()
    {
        $this->connection->createDatabase(Argument::allOf(
            Argument::withEntry('createStatement', 'CREATE DATABASE `my-database`'),
            Argument::withEntry('extraStatements', [
                'CREATE TABLE bar'
            ])
        ))->shouldBeCalled()->willReturn([
            'name' => 'my-operation'
        ]);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $op = $this->database->create([
            'statements' => [
                'CREATE TABLE bar'
            ]
        ]);

        $this->assertInstanceOf(LongRunningOperation::class, $op);
    }

    /**
     * @group spanner-admin
     */
    public function testCreatePostgresDialect()
    {
        $createStatement = sprintf('CREATE DATABASE "%s"', self::DATABASE);

        $this->connection->createDatabase(Argument::allOf(
            Argument::withEntry('createStatement', $createStatement),
            Argument::withEntry('extraStatements', [])
        ))->shouldBeCalled()->willReturn([
            'name' => 'my-operation'
        ]);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $op = $this->database->create([
            'databaseDialect'=> DatabaseDialect::POSTGRESQL
        ]);

        $this->assertInstanceOf(LongRunningOperation::class, $op);
    }

    /**
     * @group spanner-admin
     */
    public function testRestoreFromBackupName()
    {
        $backupName = DatabaseAdminClient::backupName(self::PROJECT, self::INSTANCE, self::BACKUP);
        $this->connection->restoreDatabase(Argument::allOf(
            Argument::withEntry('instance', $this->instance->name()),
            Argument::withEntry('databaseId', self::DATABASE),
            Argument::withEntry('backup', $backupName)
        ))
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'my-operation'
            ]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $op = $this->database->restore($backupName);
        $this->assertInstanceOf(LongRunningOperation::class, $op);
    }

    /**
     * @group spanner-admin
     */
    public function testRestoreFromBackupObject()
    {
        $backupObj = $this->instance->backup(self::BACKUP);

        $this->connection->restoreDatabase(Argument::allOf(
            Argument::withEntry('instance', $this->instance->name()),
            Argument::withEntry('databaseId', self::DATABASE),
            Argument::withEntry('backup', $backupObj->name())
        ))
            ->shouldBeCalled()
            ->willReturn([
            'name' => 'my-operation'
            ]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $op = $this->database->restore($backupObj);
        $this->assertInstanceOf(LongRunningOperation::class, $op);
    }

    /**
     * @group spanner-admin
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
     * @group spanner-admin
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
     * @group spanner-admin
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
     * @group spanner-admin
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
     * @group spanner-admin
     */
    public function testDropDeleteSession()
    {
        $this->connection->createSession(Argument::withEntry('database', $this->database->name()))
            ->shouldBeCalled()
            ->willReturn([
                'name' => $this->session->name()
            ]);

        $this->connection->beginTransaction(Argument::allOf(
            Argument::withEntry('session', $this->session->name()),
            Argument::withEntry(
                'database',
                DatabaseAdminClient::databaseName(
                    self::PROJECT,
                    self::INSTANCE,
                    self::DATABASE
                )
            )
        ))
            ->shouldBeCalled()
            ->willReturn([
                'id' => self::TRANSACTION
            ]);

        $this->connection->deleteSession(Argument::allOf(
            Argument::withEntry(
                'database',
                DatabaseAdminClient::databaseName(
                    self::PROJECT,
                    self::INSTANCE,
                    self::DATABASE
                )
            ),
            Argument::withEntry('name', $this->session->name())
        ))
            ->shouldBeCalled();

        $this->connection->dropDatabase([
            'name' => DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
        ])->shouldBeCalled();

        $database = TestHelpers::stub(Database::class, [
            $this->connection->reveal(),
            $this->instance,
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
     * @group spanner-admin
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
     * @group spanner-admin
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
     * @group spanner-admin
     */
    public function testIam()
    {
        $this->assertInstanceOf(Iam::class, $this->database->iam());
    }

    public function testSnapshot()
    {
        $this->connection->beginTransaction(Argument::allOf(
            Argument::withEntry('session', $this->session->name()),
            Argument::withEntry(
                'database',
                DatabaseAdminClient::databaseName(
                    self::PROJECT,
                    self::INSTANCE,
                    self::DATABASE
                )
            )
        ))
            ->shouldBeCalled()
            ->willReturn(['id' => self::TRANSACTION]);

        $this->refreshOperation($this->database, $this->connection->reveal());

        $res = $this->database->snapshot();
        $this->assertInstanceOf(Snapshot::class, $res);
    }

    public function testSnapshotMinReadTimestamp()
    {
        $this->expectException('BadMethodCallException');

        $this->database->snapshot(['minReadTimestamp' => 'foo']);
    }

    public function testSnapshotMaxStaleness()
    {
        $this->expectException('BadMethodCallException');

        $this->database->snapshot(['maxStaleness' => 'foo']);
    }

    public function testSnapshotNestedTransaction()
    {
        $this->expectException('BadMethodCallException');

        $this->connection->beginTransaction(Argument::allOf(
            Argument::withEntry('session', $this->session->name()),
            Argument::withEntry(
                'database',
                DatabaseAdminClient::databaseName(
                    self::PROJECT,
                    self::INSTANCE,
                    self::DATABASE
                )
            )
        ))
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
        $this->connection->beginTransaction(Argument::allOf(
            Argument::withEntry('session', $this->session->name()),
            Argument::withEntry(
                'database',
                DatabaseAdminClient::databaseName(
                    self::PROJECT,
                    self::INSTANCE,
                    self::DATABASE
                )
            ),
            Argument::withEntry('requestOptions', [
                'transactionTag' => self::TRANSACTION_TAG,
            ])
        ))
            ->shouldBeCalled()
            ->willReturn(['id' => self::TRANSACTION]);

        $this->connection->commit(Argument::allOf(
            Argument::withEntry('session', $this->session->name()),
            Argument::withEntry(
                'database',
                DatabaseAdminClient::databaseName(
                    self::PROJECT,
                    self::INSTANCE,
                    self::DATABASE
                )
            ),
            Argument::withEntry('requestOptions', [
                'transactionTag' => self::TRANSACTION_TAG,
            ])
        ))
            ->shouldBeCalled()
            ->willReturn(['commitTimestamp' => '2017-01-09T18:05:22.534799Z']);

        $this->refreshOperation($this->database, $this->connection->reveal());

        $hasTransaction = false;

        $this->database->runTransaction(function (Transaction $t) use (&$hasTransaction) {
            $hasTransaction = true;

            $t->commit();
        }, ['tag' => self::TRANSACTION_TAG]);

        $this->assertTrue($hasTransaction);
    }

    public function testRunTransactionNoCommit()
    {
        $this->expectException('RuntimeException');

        $this->connection->beginTransaction(Argument::allOf(
            Argument::withEntry('session', $this->session->name()),
            Argument::withEntry(
                'database',
                DatabaseAdminClient::databaseName(
                    self::PROJECT,
                    self::INSTANCE,
                    self::DATABASE
                )
            )
        ))
            ->shouldBeCalled()
            ->willReturn(['id' => self::TRANSACTION]);

        $this->connection->rollback(Argument::allOf(
            Argument::withEntry('session', $this->session->name()),
            Argument::withEntry(
                'database',
                DatabaseAdminClient::databaseName(
                    self::PROJECT,
                    self::INSTANCE,
                    self::DATABASE
                )
            )
        ))
            ->shouldBeCalled();

        $this->refreshOperation($this->database, $this->connection->reveal());

        $this->database->runTransaction($this->noop());
    }

    public function testRunTransactionNestedTransaction()
    {
        $this->expectException('BadMethodCallException');

        $this->connection->beginTransaction(Argument::allOf(
            Argument::withEntry('session', $this->session->name()),
            Argument::withEntry(
                'database',
                DatabaseAdminClient::databaseName(
                    self::PROJECT,
                    self::INSTANCE,
                    self::DATABASE
                )
            )
        ))
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

        $this->connection->beginTransaction(Argument::allOf(
            Argument::withEntry('session', $this->session->name()),
            Argument::withEntry(
                'database',
                DatabaseAdminClient::databaseName(
                    self::PROJECT,
                    self::INSTANCE,
                    self::DATABASE
                )
            )
        ))
            ->shouldBeCalledTimes(3)
            ->willReturn(['id' => self::TRANSACTION]);

        $it = 0;
        $this->connection->commit(Argument::allOf(
            Argument::withEntry('session', $this->session->name()),
            Argument::withEntry(
                'database',
                DatabaseAdminClient::databaseName(
                    self::PROJECT,
                    self::INSTANCE,
                    self::DATABASE
                )
            )
        ))
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

    public function testRunTransactionAborted()
    {
        $this->expectException('Google\Cloud\Core\Exception\AbortedException');

        $abort = new AbortedException('foo', 409, null, [
            [
                'retryDelay' => [
                    'seconds' => 0,
                    'nanos' => 500
                ]
            ]
        ]);

        $this->connection->beginTransaction(Argument::allOf(
            Argument::withEntry('session', $this->session->name()),
            Argument::withEntry(
                'database',
                DatabaseAdminClient::databaseName(
                    self::PROJECT,
                    self::INSTANCE,
                    self::DATABASE
                )
            )
        ))
            ->shouldBeCalledTimes(Database::MAX_RETRIES + 1)
            ->willReturn(['id' => self::TRANSACTION]);

        $it = 0;
        $this->connection->commit(Argument::allOf(
            Argument::withEntry('session', $this->session->name()),
            Argument::withEntry(
                'database',
                DatabaseAdminClient::databaseName(
                    self::PROJECT,
                    self::INSTANCE,
                    self::DATABASE
                )
            )
        ))
            ->shouldBeCalledTimes(Database::MAX_RETRIES + 1)
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
        $this->connection->beginTransaction(Argument::allOf(
            Argument::withEntry('session', $this->session->name()),
            Argument::withEntry(
                'database',
                DatabaseAdminClient::databaseName(
                    self::PROJECT,
                    self::INSTANCE,
                    self::DATABASE
                )
            ),
            Argument::withEntry('requestOptions', [
                'transactionTag' => self::TRANSACTION_TAG,
            ])
        ))
            ->shouldBeCalled()
            ->willReturn(['id' => self::TRANSACTION]);

        $this->refreshOperation($this->database, $this->connection->reveal());

        $t = $this->database->transaction(['tag' => self::TRANSACTION_TAG]);
        $this->assertInstanceOf(Transaction::class, $t);
    }

    public function testTransactionNestedTransaction()
    {
        $this->expectException('BadMethodCallException');

        $this->connection->beginTransaction(Argument::allOf(
            Argument::withEntry('session', $this->session->name()),
            Argument::withEntry(
                'database',
                DatabaseAdminClient::databaseName(
                    self::PROJECT,
                    self::INSTANCE,
                    self::DATABASE
                )
            )
        ))
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

        $this->connection->executeStreamingSql(Argument::withEntry('sql', $sql))
            ->shouldBeCalled()->willReturn($this->resultGenerator());

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

    public function testExecuteSingleUseMaxStaleness()
    {
        $this->database->___setProperty('sessionPool', null);
        $this->database->___setProperty('session', $this->session);
        $sql = 'SELECT * FROM Table';

        $sessName = SpannerClient::sessionName(self::PROJECT, self::INSTANCE, self::DATABASE, self::SESSION);
        $this->connection->executeStreamingSql(Argument::withEntry('session', $sessName))
            ->shouldBeCalled()
            ->willReturn($this->resultGenerator());

        $this->refreshOperation($this->database, $this->connection->reveal());

        $res = $this->database->execute($sql, [
            'maxStaleness' => new Duration(10, 0)
        ]);
        $rows = iterator_to_array($res->rows());
    }

    public function testExecuteBeginMaxStalenessFails()
    {
        $this->expectException('BadMethodCallException');

        $this->database->___setProperty('sessionPool', null);
        $this->database->___setProperty('session', $this->session);
        $sql = 'SELECT * FROM Table';

        $this->database->execute($sql, [
            'begin' => true,
            'maxStaleness' => new Duration(10, 0)
        ]);
    }

    public function testExecutePartitionedUpdate()
    {
        $sql = 'UPDATE foo SET bar = @bar';
        $this->connection->beginTransaction(Argument::allOf(
            Argument::withEntry('transactionOptions', [
                'partitionedDml' => []
            ]),
            Argument::withEntry('singleUse', false)
        ))->shouldBeCalled()->willReturn([
            'id' => self::TRANSACTION
        ]);

        $this->connection->executeStreamingSql(Argument::allOf(
            Argument::withEntry('sql', $sql),
            Argument::withEntry('transactionId', self::TRANSACTION)
        ))->shouldBeCalled()->willReturn($this->resultGenerator(true));

        $this->refreshOperation($this->database, $this->connection->reveal());
        $res = $this->database->executePartitionedUpdate($sql);

        $this->assertEquals(1, $res);
    }

    public function testRead()
    {
        $table = 'Table';
        $opts = ['foo' => 'bar'];

        $this->connection->streamingRead(Argument::that(function ($arg) use ($table) {
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
        $this->connection->deleteSession(Argument::allOf(
            Argument::withEntry('name', $this->session->name()),
            Argument::withEntry(
                'database',
                DatabaseAdminClient::databaseName(
                    self::PROJECT,
                    self::INSTANCE,
                    self::DATABASE
                )
            )
        ))
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
