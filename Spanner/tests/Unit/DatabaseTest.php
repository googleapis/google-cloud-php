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

use Google\ApiCore\OperationResponse;
use Google\Cloud\Core\Exception\AbortedException;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Exception\ServerException;
use Google\Cloud\Core\Iam\IamManager;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\LongRunning\LongRunningOperationManager;
use Google\Cloud\Core\Testing\Snippet\Fixtures;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Database\V1\Database as GapicDatabase;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseDialect;
use Google\Cloud\Spanner\Admin\Database\V1\GetDatabaseRequest;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
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
use Google\Cloud\Spanner\Tests\RequestHandlingTestTrait;
use Google\Cloud\Spanner\Tests\ResultGeneratorTrait;
use Google\Cloud\Spanner\Tests\StubCreationTrait;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\CommitRequest;
use Google\Cloud\Spanner\V1\DirectedReadOptions\ReplicaSelection\Type;
use Google\Cloud\Spanner\V1\ExecuteBatchDmlRequest;
use Google\Cloud\Spanner\V1\ExecuteSqlRequest;
use Google\Cloud\Spanner\V1\ReadRequest;
use Google\Cloud\Spanner\V1\TransactionSelector;
use Google\Rpc\Code;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Google\Cloud\Core\Exception\ServiceException;
use Google\LongRunning\Client\OperationsClient;

/**
 * @group spanner
 * @group spanner-database
 */
class DatabaseTest extends TestCase
{
    use GrpcTestTrait;
    use OperationRefreshTrait;
    use ProphecyTrait;
    use RequestHandlingTestTrait;
    use ResultGeneratorTrait;
    use StubCreationTrait;

    const PROJECT = 'my-awesome-project';
    const DATABASE = 'my-database';
    const INSTANCE = 'my-instance';
    const SESSION = 'my-session';
    const TRANSACTION = 'my-transaction';
    const BACKUP = 'my-backup';
    const TRANSACTION_TAG = 'my-transaction-tag';
    const TEST_TABLE_NAME = 'Users';
    const TIMESTAMP = '2017-01-09T18:05:22.534799Z';
    const BEGIN_RW_OPTIONS = ['begin' => ['readWrite' => []]];

    private $connection;
    private $requestHandler;
    private $serializer;
    private $instance;
    private $sessionPool;
    private $lro;
    private $lroCallables;
    private $database;
    private $session;
    private $databaseWithDatabaseRole;
    private $directedReadOptionsIncludeReplicas;
    private $directedReadOptionsExcludeReplicas;


    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->requestHandler = $this->getRequestHandlerStub();
        $this->serializer = $this->getSerializer();
        $this->sessionPool = $this->prophesize(SessionPoolInterface::class);
        $this->lro = $this->prophesize(LongRunningConnectionInterface::class);
        $this->lroCallables = [];
        $this->session = TestHelpers::stub(Session::class, [
            $this->requestHandler->reveal(),
            $this->serializer,
            self::PROJECT,
            self::INSTANCE,
            self::DATABASE,
            self::SESSION
        ], [
            'requestHandler',
            'serializer'
        ]);
        $this->directedReadOptionsIncludeReplicas = [
            'includeReplicas' => [
                'replicaSelections' => [[
                    'location' => 'us-central1',
                    'type' => Type::READ_WRITE,
                ]], 'autoFailoverDisabled' => false
            ]
        ];
        $this->directedReadOptionsExcludeReplicas = [
            'excludeReplicas' => [
                'replicaSelections' => [[
                    'location' => 'us-central1',
                    'type' => Type::READ_WRITE
                ]]
            ]
        ];

        $this->instance = TestHelpers::stub(Instance::class, [
            $this->connection->reveal(),
            $this->lro->reveal(),
            $this->requestHandler->reveal(),
            $this->serializer,
            $this->lroCallables,
            self::PROJECT,
            self::INSTANCE,
            false,
            [],
            ['directedReadOptions' => $this->directedReadOptionsIncludeReplicas]
        ], [
            'info',
            'connection',
            'requestHandler',
            'serializer'
        ]);

        $this->sessionPool->acquire(Argument::type('string'))
            ->willReturn($this->session);
        $this->sessionPool->setDatabase(Argument::type(Database::class))
            ->willReturn(null);
        $this->sessionPool->release(Argument::type(Session::class))
            ->willReturn(null);

        $args = [
            $this->requestHandler->reveal(),
            $this->serializer,
            $this->instance,
            $this->lroCallables,
            self::PROJECT,
            self::DATABASE,
            $this->sessionPool->reveal(),
            false,
            [],
            'Reader'
        ];

        $props = [
            'connection', 'requestHandler', 'serializer', 'operation', 'session', 'sessionPool', 'instance'
        ];

        $this->database = TestHelpers::stub(Database::class, $args, $props);
        $args[6] = null;
        $this->databaseWithDatabaseRole = TestHelpers::stub(Database::class, $args, $props);
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

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'getDatabase',
            function ($args) {
                Argument::type(GetDatabaseRequest::class);
                return $args->getName() === $this->database->name();
            },
            $res
        );

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

        $this->assertEquals($res, $this->database->info());

        // Make sure the request only is sent once.
        $this->database->info();
    }

    public function testState()
    {
        $res = [
            'state' => Database::STATE_READY
        ];
        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'getDatabase',
            function ($args) {
                Argument::type(GetDatabaseRequest::class);
                return $args->getName() === $this->database->name();
            },
            $res
        );

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

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

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'getDatabase',
            function ($args) {
                Argument::type(GetDatabaseRequest::class);
                return $args->getName() === $this->database->name();
            },
            $res,
            2
        );

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

        $this->assertEquals($res, $this->database->reload());

        // Make sure the request is sent each time the method is called.
        $this->database->reload();
    }

    /**
     * @group spanner-admin
     */
    public function testExists()
    {
        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'getDatabase',
            function ($args) {
                Argument::type(GetDatabaseRequest::class);
                return $args->getName() === $this->database->name();
            },
            []
        );

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

        $this->assertTrue($this->database->exists());
    }

    /**
     * @group spanner-admin
     */
    public function testExistsNotFound()
    {
        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'getDatabase',
            function ($args) {
                Argument::type(GetDatabaseRequest::class);
                return $args->getName() === $this->database->name();
            },
            new NotFoundException('', 404)
        );

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

        $this->assertFalse($this->database->exists());
    }

    /**
     * @group spanner-admin
     */
    public function testCreate()
    {
        $operationResponse = $this->getOperationResponseMock();

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'createDatabase',
            function ($args) {
                $createStatement = $args->getCreateStatement();
                $extraStatements = $args->getExtraStatements();
                $this->assertStringContainsString('my-database', $createStatement);
                $this->assertEquals(['CREATE TABLE bar'], iterator_to_array($extraStatements));
                return true;
            },
            $operationResponse->reveal()
        );
        new OperationResponse('my-operation', new DatabaseAdminClient([
            'credentials' => Fixtures::KEYFILE_STUB_FIXTURE()
        ]), [
            'lastProtoResponse' => $this->serializer->decodeMessage(
                new GapicDatabase(),
                ['name' => 'my-database']
            )
            ]);

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

        $op = $this->database->create([
            'statements' => [
                'CREATE TABLE bar'
            ]
        ]);

        $this->assertInstanceOf(LongRunningOperationManager::class, $op);
    }

    /**
     * @group spanner-admin
     */
    public function testUpdateDatabase()
    {
        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'updateDatabase',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['database']['name'],
                    DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
                );
                $this->assertEquals($message['updateMask'], ['paths' => ['enable_drop_protection']]);
                return $message['database']['enableDropProtection'];
            },
            ['enableDropProtection' => true]
        );

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

        $res = $this->database->updateDatabase(['enableDropProtection' => true]);
        $this->assertTrue($res['enableDropProtection']);
    }

    /**
     * @group spanner-admin
     */
    public function testCreatePostgresDialect()
    {
        $createStatement = sprintf('CREATE DATABASE "%s"', self::DATABASE);

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'createDatabase',
            function ($args) use ($createStatement) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['createStatement'], $createStatement);
                $this->assertEmpty($message['extraStatements']);
                return true;
            },
            $this->getOperationResponseMock()
        );

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

        $op = $this->database->create([
            'databaseDialect'=> DatabaseDialect::POSTGRESQL
        ]);

        $this->assertInstanceOf(LongRunningOperationManager::class, $op);
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
        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'updateDatabaseDdl',
            function ($args) use ($statement) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['database'],
                    DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
                );
                $this->assertEquals($message['statements'], [$statement]);
                return true;
            },
            $this->getOperationResponseMock()
        );

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

        $res = $this->database->updateDdl($statement);

        $this->assertInstanceOf(LongRunningOperationManager::class, $res);
    }
    /**
     * @group spanner-admin
     */
    public function testUpdateDdlBatch()
    {
        $statements = ['foo', 'bar'];

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'updateDatabaseDdl',
            function ($args) use ($statements) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['database'],
                    DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
                );
                $this->assertEquals($message['statements'], $statements);
                return true;
            },
            $this->getOperationResponseMock()
        );

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

        $this->database->updateDdlBatch($statements);
    }

    /**
     * @group spanner-admin
     */
    public function testUpdateWithSingleStatement()
    {
        $statement = 'foo';

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'updateDatabaseDdl',
            function ($args) use ($statement) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['database'],
                    DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
                );
                $this->assertEquals($message['statements'], [$statement]);
                return true;
            },
            $this->getOperationResponseMock()
        );

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

        $res = $this->database->updateDdl($statement);
        $this->assertInstanceOf(LongRunningOperationManager::class, $res);
    }

    /**
     * @group spanner-admin
     */
    public function testDrop()
    {
        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'dropDatabase',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['database'],
                    DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
                );
                return true;
            },
            null
        );

        $this->sessionPool->clear()->shouldBeCalled()->willReturn(null);

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

        $this->database->drop();
    }

    /**
     * @group spanner-admin
     */
    public function testDropDeleteSession()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'createSession',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return $message['database'] == $this->database->name();
            },
            ['name' => $this->session->name()]
        );
        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return $message['session'] == $this->session->name();
            },
            ['id' => self::TRANSACTION]
        );
        $this->mockSendRequest(
            SpannerClient::class,
            'deleteSession',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return $message['name'] == $this->session->name();
            },
            null
        );
        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'dropDatabase',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['database'],
                    DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
                );
                return true;
            },
            null
        );

        $database = TestHelpers::stub(Database::class, [
            $this->requestHandler->reveal(),
            $this->serializer,
            $this->instance,
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
        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'getDatabaseDdl',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['database'],
                    DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
                );
                return true;
            },
            ['statements' => $ddl]
        );

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

        $this->assertEquals($ddl, $this->database->ddl());
    }

    /**
     * @group spanner-admin
     */
    public function testDdlNoResult()
    {
        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'getDatabaseDdl',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['database'],
                    DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
                );
                return true;
            },
            []
        );

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

        $this->assertEquals([], $this->database->ddl());
    }

    /**
     * @group spanner-admin
     */
    public function testIam()
    {
        $this->assertInstanceOf(IamManager::class, $this->database->iam());
    }

    public function testSnapshot()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return $message['session'] == $this->session->name();
            },
            ['id' => self::TRANSACTION]
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $res = $this->database->snapshot();
        $this->assertInstanceOf(Snapshot::class, $res);
    }

    public function testSnapshotMinReadTimestamp()
    {
        $this->expectException(\BadMethodCallException::class);

        $this->database->snapshot(['minReadTimestamp' => 'foo']);
    }

    public function testSnapshotMaxStaleness()
    {
        $this->expectException(\BadMethodCallException::class);

        $this->database->snapshot(['maxStaleness' => 'foo']);
    }

    public function testSnapshotNestedTransaction()
    {
        $this->expectException(\BadMethodCallException::class);

        // Begin transaction RPC is skipped when begin is inlined
        // and invoked only if `begin` fails or if commit is the
        // sole operation in the transaction.
        $this->mockSendRequest(SpannerClient::class, 'beginTransaction', null, null, 0);

        $this->mockSendRequest(SpannerClient::class, 'rollback', null, null, 0);

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $this->database->runTransaction(function ($t) {
            $this->database->snapshot();
        });
    }

    public function testRunTransaction()
    {
        $this->stubCommit(false);

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $hasTransaction = false;

        $this->database->runTransaction(function (Transaction $t) use (&$hasTransaction) {
            $hasTransaction = true;

            $t->commit();
        }, ['tag' => self::TRANSACTION_TAG]);

        $this->assertTrue($hasTransaction);
    }

    public function testRunTransactionNoCommit()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->mockSendRequest(SpannerClient::class, 'beginTransaction', null, null, 0);

        $this->mockSendRequest(SpannerClient::class, 'rollback', null, null, 0);

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $this->database->runTransaction($this->noop());
    }

    public function testRunTransactionNestedTransaction()
    {
        $this->expectException(\BadMethodCallException::class);

        $this->mockSendRequest(SpannerClient::class, 'beginTransaction', null, null, 0);

        $this->mockSendRequest(SpannerClient::class, 'rollback', null, null, 0);

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $this->database->runTransaction(function ($t) {
            $this->database->runTransaction($this->noop());
        });
    }

    public function testRunTransactionShouldRetryOnRstStreamErrors()
    {
        $this->expectException(ServerException::class);
        $this->expectExceptionMessage('RST_STREAM');
        $err = new ServerException('RST_STREAM', Code::INTERNAL);

        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return $message['session'] == $this->session->name();
            },
            $err,
            3
        );

        $this->database->runTransaction(function ($t) {
            $t->commit();
        }, ['retrySettings' => ['maxRetries' => 2]]);
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

        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return $message['session'] == $this->session->name();
            },
            ['id' => self::TRANSACTION],
            3
        );

        $it = 0;
        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return $message['session'] == $this->session->name();
            },
            function () use (&$it, $abort) {
                $it++;
                if ($it <= 2) {
                    throw $abort;
                }

                return ['commitTimestamp' => TransactionTest::TIMESTAMP];
            },
            3
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $this->database->runTransaction(function ($t) use (&$it) {
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
        $this->expectException(AbortedException::class);

        $abort = new AbortedException('foo', 409, null, [
            [
                'retryDelay' => [
                    'seconds' => 0,
                    'nanos' => 500
                ]
            ]
        ]);

        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return $message['session'] == $this->session->name();
            },
            ['id' => self::TRANSACTION],
            Database::MAX_RETRIES + 1
        );

        $it = 0;
        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return $message['session'] == $this->session->name();
            },
            function () use (&$it, $abort) {
                $it++;
                if ($it <= Database::MAX_RETRIES + 1) {
                    throw $abort;
                }
                return ['commitTimestamp' => TransactionTest::TIMESTAMP];
            },
            Database::MAX_RETRIES + 1
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $this->database->runTransaction(function ($t) {
            $t->commit();
        });
    }

    public function testTransaction()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['requestOptions']['transactionTag' ],
                    self::TRANSACTION_TAG,
                );
                return $message['session'] == $this->session->name();
            },
            ['id' => self::TRANSACTION]
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $t = $this->database->transaction(['tag' => self::TRANSACTION_TAG]);
        $this->assertInstanceOf(Transaction::class, $t);
    }

    public function testTransactionNestedTransaction()
    {
        $this->expectException(\BadMethodCallException::class);

        $this->mockSendRequest(SpannerClient::class, 'beginTransaction', null, null, 0);

        $this->mockSendRequest(SpannerClient::class, 'rollback', null, null, 0);

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $this->database->runTransaction(function ($t) {
            $this->database->transaction();
        });
    }

    public function testInsert()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function ($arg) use ($table, $row) {
                $arg = $this->serializer->encodeMessage($arg);

                if ($arg['mutations'][0][OPERATION::OP_INSERT]['table'] !== $table) {
                    return false;
                }
    
                if ($arg['mutations'][0][OPERATION::OP_INSERT]['columns'][0] !== array_keys($row)[0]) {
                    return false;
                }
    
                if ($arg['mutations'][0][OPERATION::OP_INSERT]['values'][0][0] !== current($row)) {
                    return false;
                }
    
                return true;
            },
            $this->commitResponse()
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $res = $this->database->insert($table, $row);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testInsertBatch()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function ($arg) use ($table, $row) {
                $arg = $this->serializer->encodeMessage($arg);

                if ($arg['mutations'][0][OPERATION::OP_INSERT]['table'] !== $table) {
                    return false;
                }
    
                if ($arg['mutations'][0][OPERATION::OP_INSERT]['columns'][0] !== array_keys($row)[0]) {
                    return false;
                }
    
                if ($arg['mutations'][0][OPERATION::OP_INSERT]['values'][0][0] !== current($row)) {
                    return false;
                }
    
                return true;
            },
            $this->commitResponse()
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $res = $this->database->insertBatch($table, [$row]);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testUpdate()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function ($arg) use ($table, $row) {
                $arg = $this->serializer->encodeMessage($arg);

                if ($arg['mutations'][0][OPERATION::OP_UPDATE]['table'] !== $table) {
                    return false;
                }
    
                if ($arg['mutations'][0][OPERATION::OP_UPDATE]['columns'][0] !== array_keys($row)[0]) {
                    return false;
                }
    
                if ($arg['mutations'][0][OPERATION::OP_UPDATE]['values'][0][0] !== current($row)) {
                    return false;
                }
    
                return true;
            },
            $this->commitResponse()
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $res = $this->database->update($table, $row);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testUpdateBatch()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function ($arg) use ($table, $row) {
                $arg = $this->serializer->encodeMessage($arg);

                if ($arg['mutations'][0][OPERATION::OP_UPDATE]['table'] !== $table) {
                    return false;
                }
    
                if ($arg['mutations'][0][OPERATION::OP_UPDATE]['columns'][0] !== array_keys($row)[0]) {
                    return false;
                }
    
                if ($arg['mutations'][0][OPERATION::OP_UPDATE]['values'][0][0] !== current($row)) {
                    return false;
                }
    
                return true;
            },
            $this->commitResponse()
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $res = $this->database->updateBatch($table, [$row]);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testInsertOrUpdate()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function ($arg) use ($table, $row) {
                $arg = $this->serializer->encodeMessage($arg);

                if ($arg['mutations'][0][OPERATION::OP_INSERT_OR_UPDATE]['table'] !== $table) {
                    return false;
                }
    
                if ($arg['mutations'][0][OPERATION::OP_INSERT_OR_UPDATE]['columns'][0] !== array_keys($row)[0]) {
                    return false;
                }
    
                if ($arg['mutations'][0][OPERATION::OP_INSERT_OR_UPDATE]['values'][0][0] !== current($row)) {
                    return false;
                }
    
                return true;
            },
            $this->commitResponse()
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $res = $this->database->insertOrUpdate($table, $row);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testInsertOrUpdateBatch()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function ($arg) use ($table, $row) {
                $arg = $this->serializer->encodeMessage($arg);

                if ($arg['mutations'][0][OPERATION::OP_INSERT_OR_UPDATE]['table'] !== $table) {
                    return false;
                }
    
                if ($arg['mutations'][0][OPERATION::OP_INSERT_OR_UPDATE]['columns'][0] !== array_keys($row)[0]) {
                    return false;
                }
    
                if ($arg['mutations'][0][OPERATION::OP_INSERT_OR_UPDATE]['values'][0][0] !== current($row)) {
                    return false;
                }
    
                return true;
            },
            $this->commitResponse()
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $res = $this->database->insertOrUpdateBatch($table, [$row]);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testReplace()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function ($arg) use ($table, $row) {
                $arg = $this->serializer->encodeMessage($arg);

                if ($arg['mutations'][0][OPERATION::OP_REPLACE]['table'] !== $table) {
                    return false;
                }
    
                if ($arg['mutations'][0][OPERATION::OP_REPLACE]['columns'][0] !== array_keys($row)[0]) {
                    return false;
                }
    
                if ($arg['mutations'][0][OPERATION::OP_REPLACE]['values'][0][0] !== current($row)) {
                    return false;
                }
    
                return true;
            },
            $this->commitResponse()
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $res = $this->database->replace($table, $row);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testReplaceBatch()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function ($arg) use ($table, $row) {
                $arg = $this->serializer->encodeMessage($arg);

                if ($arg['mutations'][0][OPERATION::OP_REPLACE]['table'] !== $table) {
                    return false;
                }
    
                if ($arg['mutations'][0][OPERATION::OP_REPLACE]['columns'][0] !== array_keys($row)[0]) {
                    return false;
                }
    
                if ($arg['mutations'][0][OPERATION::OP_REPLACE]['values'][0][0] !== current($row)) {
                    return false;
                }
    
                return true;
            },
            $this->commitResponse()
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $res = $this->database->replaceBatch($table, [$row]);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testDelete()
    {
        $table = 'foo';
        $keys = [10, 'bar'];

        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function ($arg) use ($table, $keys) {
                $arg = $this->serializer->encodeMessage($arg);

                if ($arg['mutations'][0][Operation::OP_DELETE]['table'] !== $table) {
                    return false;
                }
    
                if ($arg['mutations'][0][Operation::OP_DELETE]['keySet']['keys'][0][0] !== (string) $keys[0]) {
                    return false;
                }
    
                if ($arg['mutations'][0][Operation::OP_DELETE]['keySet']['keys'][1][0] !== $keys[1]) {
                    return false;
                }
    
                return true;
            },
            $this->commitResponse()
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $res = $this->database->delete($table, new KeySet(['keys' => $keys]));
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testExecute()
    {
        $sql = 'SELECT * FROM Table';

        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function ($args) use ($sql) {
                return $args->getSql() == $sql;
            },
            $this->resultGenerator(true, self::TRANSACTION),
            1,
            function ($args) {
                Argument::withEntry('headers', ['x-goog-spanner-route-to-leader' => ['true']]);
                return true;
            }
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $res = $this->database->execute($sql, [
            'transactionType' => SessionPoolInterface::CONTEXT_READWRITE
        ]);
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
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function ($args) use ($sessName) {
                return $args->getSession() == $sessName;
            },
            $this->resultGenerator()
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $res = $this->database->execute($sql);
        $rows = iterator_to_array($res->rows());
    }

    public function testExecuteSingleUseMaxStaleness()
    {
        $this->database->___setProperty('sessionPool', null);
        $this->database->___setProperty('session', $this->session);
        $sql = 'SELECT * FROM Table';

        $sessName = SpannerClient::sessionName(self::PROJECT, self::INSTANCE, self::DATABASE, self::SESSION);
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function ($args) use ($sessName) {
                return $args->getSession() == $sessName;
            },
            $this->resultGenerator()
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $res = $this->database->execute($sql, [
            'maxStaleness' => new Duration(10, 0)
        ]);
        $rows = iterator_to_array($res->rows());
    }

    public function testExecuteBeginMaxStalenessFails()
    {
        $this->expectException(\BadMethodCallException::class);

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
        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['options']['partitionedDml' ],
                    []
                );
                return true;
            },
            ['id' => self::TRANSACTION]
        );
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function ($args) use ($sql) {
                Argument::type(ExecuteSqlRequest::class);
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['sql'], $sql);
                $this->assertEquals($message['transaction'], ['id' => self::TRANSACTION]);
                return true;
            },
            $this->resultGenerator(true),
            1,
            function ($args) {
                Argument::withEntry('headers', ['x-goog-spanner-route-to-leader' => ['true']]);
                return true;
            }
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);
        $res = $this->database->executePartitionedUpdate($sql);

        $this->assertEquals(1, $res);
    }

    public function testRead()
    {
        $table = 'Table';
        $opts = ['foo' => 'bar'];

        $this->mockSendRequest(
            SpannerClient::class,
            'streamingRead',
            function ($args) use ($table) {
                Argument::type(ReadRequest::class);
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($args->getTable(), $table);
                $this->assertEquals(
                    $message['keySet'],
                    ['all' => true, 'keys' => [], 'ranges' => []]
                );
                $this->assertEquals($message['columns'], ['ID']);
                return true;
            },
            $this->resultGenerator()
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $res = $this->database->read(
            $table,
            new KeySet(['all' => true]),
            ['ID'],
            ['transactionType' => SessionPoolInterface::CONTEXT_READWRITE]
        );
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
        $this->mockSendRequest(
            SpannerClient::class,
            'deleteSession',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return $message['name'] == $this->session->name();
            },
            []
        );

        $this->session->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);
        $this->database->___setProperty('sessionPool', null);
        $this->database->___setProperty('session', $this->session);

        $this->database->close();
    }

    public function testCreateSession()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'createSession',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return $message['database'] == $this->database->name();
            },
            ['name' => $this->session->name()]
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $sess = $this->database->createSession();

        $this->assertInstanceOf(Session::class, $sess);
        $this->assertEquals($this->session->name(), $sess->name());
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

    public function testDBDatabaseRole()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'createSession',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['session']['creatorRole'], 'Reader');
                return $message['database'] == $this->database->name();
            },
            ['name' => $this->session->name()]
        );
        $sql = $this->createStreamingAPIArgs()['sql'];
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function ($args) use ($sql) {
                Argument::type(ExecuteSqlRequest::class);
                $this->assertEquals($args->getSql(), $sql);
                return true;
            },
            $this->resultGenerator()
        );

        $this->databaseWithDatabaseRole->execute($sql);
    }

    public function testExecuteWithDirectedRead()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['directedReadOptions'],
                    $this->directedReadOptionsIncludeReplicas
                );
                return true;
            },
            $this->resultGenerator()
        );

        $sql = 'SELECT * FROM Table';
        $res = $this->database->execute($sql);
        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertCount(1, $rows);
    }

    public function testPrioritizeExecuteDirectedReadOptions()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['directedReadOptions'],
                    $this->directedReadOptionsExcludeReplicas
                );
                return true;
            },
            $this->resultGenerator()
        );

        $sql = 'SELECT * FROM Table';
        $res = $this->database->execute(
            $sql,
            ['directedReadOptions' => $this->directedReadOptionsExcludeReplicas]
        );
        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertCount(1, $rows);
    }

    public function testReadWithDirectedRead()
    {
        $table = 'foo';
        $keys = [10, 'bar'];
        $columns = ['id', 'name'];
        $this->mockSendRequest(
            SpannerClient::class,
            'streamingRead',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['directedReadOptions'],
                    $this->directedReadOptionsIncludeReplicas
                );
                return true;
            },
            $this->resultGenerator()
        );

        $res = $this->database->read(
            $table,
            new KeySet(['keys' => $keys]),
            $columns
        );
        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertCount(1, $rows);
    }

    public function testPrioritizeReadDirectedReadOptions()
    {
        $table = 'foo';
        $keys = [10, 'bar'];
        $columns = ['id', 'name'];
        $this->mockSendRequest(
            SpannerClient::class,
            'streamingRead',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['directedReadOptions'],
                    $this->directedReadOptionsExcludeReplicas
                );
                return true;
            },
            $this->resultGenerator()
        );

        $res = $this->database->read(
            $table,
            new KeySet(['keys' => $keys]),
            $columns,
            ['directedReadOptions' => $this->directedReadOptionsExcludeReplicas]
        );
        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertCount(1, $rows);
    }

    public function testRunTransactionWithUpdate()
    {
        $sql = $this->createStreamingAPIArgs()['sql'];

        $this->stubCommit();
        $this->stubExecuteStreamingSql();
        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $this->database->runTransaction(function (Transaction $t) use ($sql) {
            $t->executeUpdate($sql);
            $timeStamp = $t->commit();
            $this->assertEquals($timeStamp->formatAsString(), self::TIMESTAMP);
        }, ['tag' => self::TRANSACTION_TAG]);
    }

    public function testRunTransactionWithQuery()
    {
        $sql = $this->createStreamingAPIArgs()['sql'];

        $this->stubCommit();
        $this->stubExecuteStreamingSql();
        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $this->database->runTransaction(function (Transaction $t) use ($sql) {
            $t->execute($sql)->rows()->current();
            $timeStamp = $t->commit();
            $this->assertEquals($timeStamp->formatAsString(), self::TIMESTAMP);
        }, ['tag' => self::TRANSACTION_TAG]);
    }

    public function testRunTransactionWithRead()
    {
        $keySet = $this->createStreamingAPIArgs()['keySet'];
        $cols = $this->createStreamingAPIArgs()['cols'];

        $this->stubCommit();
        $this->stubStreamingRead();
        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $this->database->runTransaction(function (Transaction $t) use ($keySet, $cols) {
            $t->read(self::TEST_TABLE_NAME, $keySet, $cols)->rows()->current();
            $timeStamp = $t->commit();
            $this->assertEquals($timeStamp->formatAsString(), self::TIMESTAMP);
        }, ['tag' => self::TRANSACTION_TAG]);
    }

    public function testRunTransactionWithUpdateBatch()
    {
        $sql = $this->createStreamingAPIArgs()['sql'];

        $this->stubCommit();
        $this->stubExecuteBatchDml();
        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $this->database->runTransaction(function (Transaction $t) use ($sql) {
            $t->executeUpdateBatch([['sql' => $sql]]);
            $timeStamp = $t->commit();
            $this->assertEquals($timeStamp->formatAsString(), self::TIMESTAMP);
        }, ['tag' => self::TRANSACTION_TAG]);
    }

    public function testRunTransactionWithReadFirst()
    {
        $sql = $this->createStreamingAPIArgs()['sql'];
        $keySet = $this->createStreamingAPIArgs()['keySet'];
        $cols = $this->createStreamingAPIArgs()['cols'];

        $this->stubCommit();
        $this->stubStreamingRead();
        $this->stubExecuteStreamingSql(['id' => self::TRANSACTION]);
        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $this->database->runTransaction(function (Transaction $t) use ($keySet, $cols, $sql) {
            $t->read(self::TEST_TABLE_NAME, $keySet, $cols)->rows()->current();
            $t->execute($sql)->rows()->current();
            $timeStamp = $t->commit();
            $this->assertEquals($timeStamp->formatAsString(), self::TIMESTAMP);
        }, ['tag' => self::TRANSACTION_TAG]);
    }

    public function testRunTransactionWithExecuteFirst()
    {
        $sql = $this->createStreamingAPIArgs()['sql'];
        $keySet = $this->createStreamingAPIArgs()['keySet'];
        $cols = $this->createStreamingAPIArgs()['cols'];

        $this->stubCommit();
        $this->stubStreamingRead(['id' => self::TRANSACTION]);
        $this->stubExecuteStreamingSql();
        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $this->database->runTransaction(function (Transaction $t) use ($keySet, $cols, $sql) {
            $t->execute($sql)->rows()->current();
            $t->read(self::TEST_TABLE_NAME, $keySet, $cols)->rows()->current();
            $timeStamp = $t->commit();
            $this->assertEquals($timeStamp->formatAsString(), self::TIMESTAMP);
        }, ['tag' => self::TRANSACTION_TAG]);
    }

    public function testRunTransactionWithUpdateBatchFirst()
    {
        $sql = $this->createStreamingAPIArgs()['sql'];
        $keySet = $this->createStreamingAPIArgs()['keySet'];
        $cols = $this->createStreamingAPIArgs()['cols'];

        $this->stubCommit();
        $this->stubExecuteBatchDml();
        $this->stubStreamingRead(['id' => self::TRANSACTION]);
        $this->stubExecuteStreamingSql(['id' => self::TRANSACTION]);
        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $this->database->runTransaction(function (Transaction $t) use ($keySet, $cols, $sql) {
            $t->executeUpdateBatch([['sql' => $sql]]);
            $t->execute($sql)->rows()->current();
            $t->read(self::TEST_TABLE_NAME, $keySet, $cols)->rows()->current();
            $timeStamp = $t->commit();
            $this->assertEquals($timeStamp->formatAsString(), self::TIMESTAMP);
        }, ['tag' => self::TRANSACTION_TAG]);
    }

    public function testRunTransactionWithUpdateBatchError()
    {
        $sql = $this->createStreamingAPIArgs()['sql'];
        $keySet = $this->createStreamingAPIArgs()['keySet'];
        $cols = $this->createStreamingAPIArgs()['cols'];

        $this->stubCommit();
        $this->stubStreamingRead(['id' => self::TRANSACTION]);
        $this->stubExecuteStreamingSql(['id' => self::TRANSACTION]);
        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);
        $this->mockSendRequest(
            SpannerClient::class,
            'executeBatchDml',
            function ($args) {
                Argument::type(ExecuteBatchDmlRequest::class);
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['requestOptions']['transactionTag'],
                    self::TRANSACTION_TAG
                );
                $this->assertEquals(
                    $message['transaction'],
                    ['begin' => ['readWrite' => ['readLockMode' => 0], 'excludeTxnFromChangeStreams' => false]]
                );
                return true;
            },
            [
                'status' => ['code' => Code::INVALID_ARGUMENT],
                'resultSets' => [['metadata' => ['transaction' => ['id' => self::TRANSACTION]]]]
            ]
        );

        $this->database->runTransaction(function (Transaction $t) use ($keySet, $cols, $sql) {
            $result = $t->executeUpdateBatch([['sql' => $sql], ['sql' => $sql]]);
            $this->assertEquals($result->error()['status']['code'], Code::INVALID_ARGUMENT);
            $t->execute($sql)->rows()->current();
            $t->read(self::TEST_TABLE_NAME, $keySet, $cols)->rows()->current();
            $timeStamp = $t->commit();
            $this->assertEquals($timeStamp->formatAsString(), self::TIMESTAMP);
        }, ['tag' => self::TRANSACTION_TAG]);
    }

    public function testRunTransactionWithFirstFailedStatement()
    {
        $sql = $this->createStreamingAPIArgs()['sql'];
        $error = new ServerException('RST_STREAM', Code::INTERNAL);

        // First call with ILB fails
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function ($args) use ($sql) {
                Argument::type(ExecuteBatchDmlRequest::class);
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($sql, $message['sql']);
                $this->assertEquals(
                    $message['requestOptions']['transactionTag'],
                    self::TRANSACTION_TAG
                );
                return $message['transaction'] == ['begin' =>
                    ['readWrite' => ['readLockMode' => 0], 'excludeTxnFromChangeStreams' => false]
                ];
            },
            $error
        );
        // Second call with non ILB return result
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function ($args) use ($sql) {
                Argument::type(ExecuteBatchDmlRequest::class);
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($sql, $message['sql']);
                $this->assertEquals(
                    $message['requestOptions']['transactionTag'],
                    self::TRANSACTION_TAG
                );
                return $message['transaction'] == ['id' => self::TRANSACTION];
            },
            $this->resultGenerator(true, self::TRANSACTION)
        );
        $this->stubCommit(false);
        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $this->database->runTransaction(function ($t) use ($sql) {
            $t->execute($sql);
            $t->commit();
        }, ['tag' => self::TRANSACTION_TAG]);
    }

    public function testRunTransactionWithCommitAborted()
    {
        $sql = $this->createStreamingAPIArgs()['sql'];
        $numOfRetries = 2;

        $abort = new AbortedException('foo', 409, null, [
            [
                'retryDelay' => [
                    'seconds' => 0,
                    'nanos' => 500
                ]
            ]
        ]);

        // First call with ILB
        $this->stubExecuteStreamingSql();
        // Second onwards non ILB
        $this->stubExecuteStreamingSql(['id' => self::TRANSACTION]);
        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return $message['session'] == $this->session->name();
            },
            ['id' => self::TRANSACTION],
            $numOfRetries
        );

        $it = 0;
        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return $message['session'] == $this->session->name();
            },
            function () use (&$it, $abort, $numOfRetries) {
                $it++;
                if ($it <= $numOfRetries) {
                    throw $abort;
                }
                return ['commitTimestamp' => TransactionTest::TIMESTAMP];
            },
            $numOfRetries + 1
        );
        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $this->database->runTransaction(function ($t) use ($sql) {
            $t->execute($sql);
            $t->commit();
        }, ['tag' => self::TRANSACTION_TAG]);
    }

    public function testRunTransactionWithBeginTransactionFailure()
    {
        $this->expectException(ServerException::class);
        $error = new ServerException('RST_STREAM', Code::INTERNAL);
        $sql = $this->createStreamingAPIArgs()['sql'];

        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function ($args) use ($sql) {
                Argument::type(ExecuteBatchDmlRequest::class);
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($sql, $message['sql']);
                $this->assertEquals(
                    $message['requestOptions']['transactionTag'],
                    self::TRANSACTION_TAG
                );
                return $message['transaction'] == ['begin' =>
                    ['readWrite' => ['readLockMode' => 0], 'excludeTxnFromChangeStreams' => false]
                ];
            },
            $error
        );
        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            function ($args) use ($sql) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['session'], $this->session->name());
                return true;
            },
            $error,
            Database::MAX_RETRIES
        );
        $this->mockSendRequest(SpannerClient::class, 'commit', null, null, 0);
        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $this->database->runTransaction(function ($t) use ($sql) {
            $t->execute($sql);
            $t->commit();
        }, ['tag' => self::TRANSACTION_TAG]);
    }

    public function testRunTransactionWithBlindCommit()
    {
        $this->stubCommit(false);
        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $this->database->runTransaction(function ($t) {
            $t->insert('Posts', [
                'ID' => 10,
                'title' => 'My New Post',
                'content' => 'Hello World'
            ]);
            $t->commit();
        }, ['tag' => self::TRANSACTION_TAG]);
    }

    public function testRunTransactionWithUnavailableErrorRetry()
    {
        $sql = $this->createStreamingAPIArgs()['sql'];
        $numOfRetries = 2;
        $unavailable = new ServiceException('Unavailable', 14);
        $result = $this->resultGenerator(true, self::TRANSACTION);

        $it = 0;
        // First call with ILB results in unavailable error.
        // Second call also made with ILB, returns ResultSet.
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function ($args) use ($sql) {
                Argument::type(ExecuteSqlRequest::class);
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['sql'], $sql);
                $this->assertEquals(
                    $message['transaction'],
                    ['begin' => ['readWrite' => ['readLockMode' => 0], 'excludeTxnFromChangeStreams' => false]]
                );
                return $message['requestOptions']['transactionTag'] == self::TRANSACTION_TAG;
            },
            function () use (&$it, $unavailable, $numOfRetries, $result) {
                $it++;
                if ($it < $numOfRetries) {
                    throw $unavailable;
                }
                return $result;
            },
            $numOfRetries
        );
        $this->stubCommit();
        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $this->database->runTransaction(function ($t) use ($sql) {
            $t->execute($sql);
            $t->commit();
        }, ['tag' => self::TRANSACTION_TAG]);
    }

    public function testRunTransactionWithFirstUnavailableErrorRetry()
    {
        $sql = $this->createStreamingAPIArgs()['sql'];
        $unavailable = new ServiceException('Unavailable', 14);

        // First call with ILB results in a transaction.
        // Then the stream fails, Second call needs to use the
        // transaction created by the first call.
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function ($args) use ($sql) {
                Argument::type(ExecuteSqlRequest::class);
                $this->assertEquals($args->getSql(), $sql);
                return $this->serializer->decodeMessage(
                    new TransactionSelector(),
                    self::BEGIN_RW_OPTIONS
                ) == $args->getTransaction()
                    && $args->getRequestOptions()->getTransactionTag() == self::TRANSACTION_TAG;
            },
            $this->resultGeneratorWithError()
        );
        $this->stubExecuteStreamingSql(['id' => self::TRANSACTION]);
        $this->stubCommit();
        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $this->database->runTransaction(function ($t) use ($sql) {
            $result = $t->execute($sql);
            // Need to fetch all the rows from iterator to see the retryable errors.
            iterator_to_array($result);
            $t->commit();
        }, ['tag' => self::TRANSACTION_TAG]);
    }

    public function testRunTransactionWithUnavailableAndAbortErrorRetry()
    {
        $keySet = $this->createStreamingAPIArgs()['keySet'];
        $cols = $this->createStreamingAPIArgs()['cols'];
        $numOfRetries = 2;
        $unavailable = new ServiceException('Unavailable', 14);
        $abort = new AbortedException('foo', 409, null, [
            [
                'retryDelay' => [
                    'seconds' => 0,
                    'nanos' => 500
                ]
            ]
        ]);

        $it = 0;
        // First call with ILB results in unavailable error.
        // Second call also made with ILB, gets aborted.
        $this->mockSendRequest(
            SpannerClient::class,
            'streamingRead',
            function ($args) use ($cols) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['table'], self::TEST_TABLE_NAME);
                $this->assertEquals($message['columns'], $cols);
                return $message['transaction']
                        == ['begin' => ['readWrite' => ['readLockMode' => 0], 'excludeTxnFromChangeStreams' => false]]
                    && $message['requestOptions']['transactionTag'] == self::TRANSACTION_TAG;
            },
            function () use (&$it, $unavailable, $numOfRetries, $abort) {
                $it++;
                if ($it < $numOfRetries) {
                    throw $unavailable;
                } else {
                    throw $abort;
                }
            },
            $numOfRetries
        );
        // Should retry with beginTransaction RPC.
        $this->stubStreamingRead(['id' => self::TRANSACTION]);

        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            null,
            ['id' => self::TRANSACTION]
        );

        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function ($args) {
                Argument::type(CommitRequest::class);
                $this->assertEquals($args->getSession(), $this->session->name());
                $this->assertEquals($args->getTransactionId(), self::TRANSACTION);
                $this->assertEquals($args->getRequestOptions()->getTransactionTag(), self::TRANSACTION_TAG);
                $this->assertEquals($this->serializer->encodeMessage($args)['mutations'], [['insert' => [
                    'table' => self::TEST_TABLE_NAME,
                    'columns' => ['ID', 'title', 'content'],
                    'values' => [['10', 'My New Post', 'Hello World']]
                ]]]);
                return true;
            },
            ['commitTimestamp' => self::TIMESTAMP]
        );
        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $this->database->runTransaction(function ($t) use ($keySet, $cols) {
            $t->insert(self::TEST_TABLE_NAME, [
                'ID' => 10,
                'title' => 'My New Post',
                'content' => 'Hello World'
            ]);
            $t->read(self::TEST_TABLE_NAME, $keySet, $cols);
            $t->commit();
        }, ['tag' => self::TRANSACTION_TAG]);
    }

    public function testRunTransactionWithRollback()
    {
        $sql = $this->createStreamingAPIArgs()['sql'];

        $this->stubExecuteStreamingSql();
        $this->mockSendRequest(
            SpannerClient::class,
            'rollback',
            function ($args) use ($sql) {
                return $args->getTransactionId() == self::TRANSACTION;
            },
            null
        );
        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $this->database->runTransaction(function (Transaction $t) use ($sql) {
            $t->execute($sql);
            $t->rollback();
        }, ['tag' => self::TRANSACTION_TAG]);
    }

    private function createStreamingAPIArgs()
    {
        $row = ['id' => 1];
        return [
            'keySet' => new KeySet([
                'keys' => [$row['id']]
            ]),
            'cols' => array_keys($row),
            'sql' => 'SELECT * FROM foo WHERE id = 1'
        ];
    }

    private function resultGeneratorWithError()
    {
        $fields = [
            'name' => 'ID',
            'value' => ['code' => Database::TYPE_INT64]
        ];
        $values = [10];
        $result = [
            'metadata' => [
                'rowType' => [
                    'fields' => $fields
                ]
            ],
            'values' => $values
        ];
        $result['metadata']['transaction'] = [
            'id' => self::TRANSACTION
        ];

        yield $result;
        throw new ServiceException('Unavailable', 14);
    }

    private function stubCommit($withTransaction = true)
    {
        if ($withTransaction) {
            $this->mockSendRequest(SpannerClient::class, 'beginTransaction', null, null, 0);
        } else {
            $this->mockSendRequest(
                SpannerClient::class,
                'beginTransaction',
                null,
                ['id' => self::TRANSACTION]
            );
        }

        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function ($args) {
                Argument::type(CommitRequest::class);
                $this->assertEquals($args->getSession(), $this->session->name());
                $this->assertEquals($args->getTransactionId(), self::TRANSACTION);
                $this->assertEquals($args->getRequestOptions()->getTransactionTag(), self::TRANSACTION_TAG);
                return true;
            },
            ['commitTimestamp' => self::TIMESTAMP]
        );
    }

    private function stubStreamingRead($transactionOptions = self::BEGIN_RW_OPTIONS)
    {
        $cols = $this->createStreamingAPIArgs()['cols'];
        $this->mockSendRequest(
            SpannerClient::class,
            'streamingRead',
            function ($args) use ($transactionOptions, $cols) {
                Argument::type(ReadRequest::class);
                return $args->getTransaction() == $this->serializer->decodeMessage(
                    new TransactionSelector(),
                    $transactionOptions
                )
                    && $args->getTable() == self::TEST_TABLE_NAME
                    && iterator_to_array($args->getColumns()) == $cols
                    && $args->getRequestOptions()->getTransactionTag() == self::TRANSACTION_TAG;
            },
            $this->resultGenerator(true, self::TRANSACTION)
        );
    }

    private function stubExecuteStreamingSql($transactionOptions = self::BEGIN_RW_OPTIONS)
    {
        $sql = $this->createStreamingAPIArgs()['sql'];
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function ($args) use ($sql, $transactionOptions) {
                Argument::type(ExecuteSqlRequest::class);
                return $args->getSql() == $sql
                    && $args->getTransaction() == $this->serializer->decodeMessage(
                        new TransactionSelector,
                        $transactionOptions
                    )
                    && $args->getRequestOptions()->getTransactionTag() == self::TRANSACTION_TAG;
            },
            $this->resultGenerator(true, self::TRANSACTION),
            -1
        );
    }

    private function stubExecuteBatchDml($transactionOptions = self::BEGIN_RW_OPTIONS)
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'executeBatchDml',
            function ($args) use ($transactionOptions) {
                Argument::type(ExecuteBatchDmlRequest::class);
                $this->assertEquals(
                    $args->getTransaction(),
                    $this->serializer->decodeMessage(new TransactionSelector, $transactionOptions)
                );
                $this->assertEquals(
                    $args->getRequestOptions()->getTransactionTag(),
                    self::TRANSACTION_TAG
                );
                return true;
            },
            [
                'resultSets' => [['metadata' => ['transaction' => ['id' => self::TRANSACTION]]]]
            ]
        );
    }

    private function getOperationResponseMock()
    {
        $operation = $this->serializer->decodeMessage(
            new \Google\LongRunning\Operation(),
            ['metadata' => [
                'typeUrl' => 'type.googleapis.com/google.spanner.admin.database.v1.CreateDatabaseMetadata'
            ]]
        );
        $operationResponse = $this->prophesize(OperationResponse::class);
        $operationResponse->getLastProtoResponse()->willReturn($operation);
        $operationResponse->isDone()->willReturn(false);
        $operationResponse->getError()->willReturn(null);
        return $operationResponse;
    }
}
