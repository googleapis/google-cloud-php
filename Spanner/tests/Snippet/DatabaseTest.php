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

use Google\ApiCore\OperationResponse;
use Google\ApiCore\Page;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Core\Iam\IamManager;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Spanner\Admin\Database\V1\Backup as BackupProto;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Database\V1\CreateBackupRequest;
use Google\Cloud\Spanner\Admin\Database\V1\CreateDatabaseRequest;
use Google\Cloud\Spanner\Admin\Database\V1\Database as DatabaseProto;
use Google\Cloud\Spanner\Admin\Database\V1\DropDatabaseRequest;
use Google\Cloud\Spanner\Admin\Database\V1\GetDatabaseDdlRequest;
use Google\Cloud\Spanner\Admin\Database\V1\GetDatabaseDdlResponse;
use Google\Cloud\Spanner\Admin\Database\V1\GetDatabaseRequest;
use Google\Cloud\Spanner\Admin\Database\V1\ListBackupsRequest;
use Google\Cloud\Spanner\Admin\Database\V1\ListBackupsResponse;
use Google\Cloud\Spanner\Admin\Database\V1\RestoreDatabaseRequest;
use Google\Cloud\Spanner\Admin\Database\V1\UpdateDatabaseDdlRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Backup;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Serializer;
use Google\Cloud\Spanner\Session\SessionCache;
use Google\Cloud\Spanner\Snapshot;
use Google\Cloud\Spanner\Tests\ResultGeneratorTrait;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\V1\BeginTransactionRequest;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\CommitRequest;
use Google\Cloud\Spanner\V1\CommitResponse;
use Google\Cloud\Spanner\V1\ExecuteSqlRequest;
use Google\Cloud\Spanner\V1\PartialResultSet;
use Google\Cloud\Spanner\V1\ReadRequest;
use Google\Cloud\Spanner\V1\ResultSetStats;
use Google\Cloud\Spanner\V1\RollbackRequest;
use Google\Cloud\Spanner\V1\Transaction as TransactionProto;
use Google\LongRunning\Client\OperationsClient;
use Google\LongRunning\ListOperationsResponse;
use Google\LongRunning\Operation;
use Google\Protobuf\Timestamp as TimestampProto;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner
 * @group spanner-database
 */
class DatabaseTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;
    use ResultGeneratorTrait;

    const PROJECT = 'my-awesome-project';
    const DATABASE = 'my-database';
    const INSTANCE = 'my-instance';
    const TRANSACTION = 'my-transaction';
    const BACKUP = 'my-backup';
    const SESSION = 'projects/my-awesome-project/instances/my-instance/databases/my-database/sessions/session-id';

    private $spannerClient;
    private $databaseAdminClient;
    private $instanceAdminClient;
    private $operationResponse;
    private $serializer;
    private $database;
    private $instance;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->spannerClient = $this->prophesize(SpannerClient::class);
        $this->databaseAdminClient = $this->prophesize(DatabaseAdminClient::class);
        $this->instanceAdminClient = $this->prophesize(InstanceAdminClient::class);
        $this->operationResponse = $this->prophesize(OperationResponse::class);
        $this->serializer = new Serializer();

        $session = $this->prophesize(SessionCache::class);
        $session->name()->willReturn(self::SESSION);

        $this->instance = new Instance(
            $this->spannerClient->reveal(),
            $this->instanceAdminClient->reveal(),
            $this->databaseAdminClient->reveal(),
            $this->serializer,
            self::PROJECT,
            self::INSTANCE
        );

        $this->database = new Database(
            $this->spannerClient->reveal(),
            $this->databaseAdminClient->reveal(),
            $this->serializer,
            $this->instance,
            self::PROJECT,
            self::DATABASE,
            $session->reveal(),
        );
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

        $this->databaseAdminClient->getDatabase(
            Argument::type(GetDatabaseRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new DatabaseProto(['state' => Database::STATE_READY]));

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

        $backup = new BackupProto([
            'name' => DatabaseAdminClient::backupName(self::PROJECT, self::INSTANCE, self::BACKUP)
        ]);

        $page = $this->prophesize(Page::class);
        $page->getResponseObject()
            ->willReturn(new ListBackupsResponse(['backups' => [$backup]]));
        $page->getNextPageToken()
            ->willReturn(null);
        $pagedListResponse = $this->prophesize(PagedListResponse::class);
        $pagedListResponse->getPage()
            ->willReturn($page->reveal());

        $this->databaseAdminClient->listBackups(
            Argument::type(ListBackupsRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($pagedListResponse->reveal());

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

        $this->databaseAdminClient->createBackup(
            Argument::type(CreateBackupRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

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

        $this->databaseAdminClient->getDatabase(
            Argument::type(GetDatabaseRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new DatabaseProto(['name' => 'foo']));

        $res = $snippet->invoke();
        $this->assertEquals('Database exists!', $res->output());
    }

    /**
     * @group spanner-admin
     */
    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'info');
        $snippet->addLocal('database', $this->database);

        $this->databaseAdminClient->getDatabase(
            Argument::type(GetDatabaseRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new DatabaseProto(['name' => 'foo']));

        $res = $snippet->invoke('info');
        $this->assertEquals('foo', $res->returnVal()['name']);
        $snippet->invoke();
    }

    /**
     * @group spanner-admin
     */
    public function testReload()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'reload');
        $snippet->addLocal('database', $this->database);

        $this->databaseAdminClient->getDatabase(
            Argument::type(GetDatabaseRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledTimes(2)
            ->willReturn(new DatabaseProto(['name' => 'foo']));

        $res = $snippet->invoke('info');
        $this->assertEquals('foo', $res->returnVal()['name']);
        $snippet->invoke();
    }

    /**
     * @group spanner-admin
     */
    public function testCreate()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'create');
        $snippet->addLocal('database', $this->database);

        $this->databaseAdminClient->createDatabase(
            Argument::type(CreateDatabaseRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

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

        $this->databaseAdminClient->restoreDatabase(
            Argument::type(RestoreDatabaseRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

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

        $this->databaseAdminClient->updateDatabaseDdl(
            Argument::type(UpdateDatabaseDdlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        $snippet->invoke();
    }

    /**
     * @group spanner-admin
     */
    public function testUpdateDdlBatch()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'updateDdlBatch');
        $snippet->addLocal('database', $this->database);

        $this->databaseAdminClient->updateDatabaseDdl(
            Argument::type(UpdateDatabaseDdlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        $snippet->invoke();
    }

    /**
     * @group spanner-admin
     */
    public function testDrop()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'drop');
        $snippet->addLocal('database', $this->database);

        $this->databaseAdminClient->dropDatabase(
            Argument::type(DropDatabaseRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce();

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

        $this->databaseAdminClient->getDatabaseDdl(
            Argument::type(GetDatabaseDdlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new GetDatabaseDdlResponse(['statements' => $stmts]));

        $res = $snippet->invoke('statements');
        $this->assertEquals($stmts, $res->returnVal());
    }

    public function testSnapshot()
    {
        $this->spannerClient->beginTransaction(
            Argument::type(BeginTransactionRequest::class),
            Argument::type('array')
        )
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $snippet = $this->snippetFromMethod(Database::class, 'snapshot');
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('snapshot');
        $this->assertInstanceOf(Snapshot::class, $res->returnVal());
    }

    public function testSnapshotReadTimestamp()
    {
        $this->spannerClient->beginTransaction(
            Argument::type(BeginTransactionRequest::class),
            Argument::type('array')
        )
            ->willReturn(new TransactionProto([
                'id' => self::TRANSACTION,
                'read_timestamp' => new TimestampProto(['seconds' => time()])
            ]));

        $snippet = $this->snippetFromMethod(Database::class, 'snapshot', 1);
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('timestamp');
        $this->assertInstanceOf(Timestamp::class, $res->returnVal());
    }

    public function testRunTransaction()
    {
        $this->spannerClient->beginTransaction(
            Argument::type(BeginTransactionRequest::class),
            Argument::type('array')
        )
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $this->spannerClient->commit(
            Argument::type(CommitRequest::class),
            Argument::type('array')
        )->willReturn(new CommitResponse());

        $this->spannerClient->executeStreamingSql(
            Argument::type(ExecuteSqlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream([
                [
                    'name' => 'loginCount',
                    'type' => Database::TYPE_INT64,
                    'value' => 0
                ]
            ]));

        $this->spannerClient->rollback(Argument::cetera())->shouldNotBeCalled();

        $snippet = $this->snippetFromMethod(Database::class, 'runTransaction');
        $snippet->addUse(Transaction::class);
        $snippet->addLocal('database', $this->database);
        $snippet->addLocal('username', 'foo');
        $snippet->addLocal('password', 'bar');

        $snippet->invoke();
    }

    public function testRunTransactionRollback()
    {
        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();

        $this->spannerClient->commit(Argument::cetera())->shouldNotBeCalled();

        $this->spannerClient->rollback(
            Argument::type(RollbackRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce();

        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) {
                $this->assertEquals(
                    $this->serializer->encodeMessage($request)['transaction']['begin']['readWrite'],
                    ['readLockMode' => 0, 'multiplexedSessionPreviousTransactionId' => '']
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream([$this->serializer->decodeMessage(
                new PartialResultSet(),
                [
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
                        ],
                        'transaction' => [
                            'id' => self::TRANSACTION
                        ]
                    ]
                ]
            )]));

        $snippet = $this->snippetFromMethod(Database::class, 'runTransaction');
        $snippet->addUse(Transaction::class);
        $snippet->addLocal('database', $this->database);
        $snippet->addLocal('username', 'foo');
        $snippet->addLocal('password', 'bar');

        $snippet->invoke();
    }

    public function testTransaction()
    {
        $this->spannerClient->beginTransaction(
            Argument::type(BeginTransactionRequest::class),
            Argument::type('array')
        )
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $snippet = $this->snippetFromMethod(Database::class, 'transaction');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke('transaction');
        $this->assertInstanceOf(Transaction::class, $res->returnVal());
    }

    public function testInsert()
    {
        $this->spannerClient->commit(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return isset($message['mutations'][0]['insert']);
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new CommitResponse());

        $snippet = $this->snippetFromMethod(Database::class, 'insert');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }

    public function testInsertBatch()
    {
        $this->spannerClient->commit(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return isset($message['mutations'][0]['insert'])
                    && isset($message['mutations'][1]['insert']);
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new CommitResponse());

        $snippet = $this->snippetFromMethod(Database::class, 'insertBatch');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }

    public function testUpdate()
    {
        $this->spannerClient->commit(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return isset($message['mutations'][0]['update']);
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new CommitResponse());

        $snippet = $this->snippetFromMethod(Database::class, 'update');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }

    public function testUpdateBatch()
    {
        $this->spannerClient->commit(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return isset($message['mutations'][0]['update'])
                    && isset($message['mutations'][1]['update']);
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new CommitResponse());

        $snippet = $this->snippetFromMethod(Database::class, 'updateBatch');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }

    public function testInsertOrUpdate()
    {
        $this->spannerClient->commit(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return isset($message['mutations'][0]['insertOrUpdate']);
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new CommitResponse());

        $snippet = $this->snippetFromMethod(Database::class, 'insertOrUpdate');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }

    public function testInsertOrUpdateBatch()
    {
        $this->spannerClient->commit(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return isset($message['mutations'][0]['insertOrUpdate'])
                    && isset($message['mutations'][1]['insertOrUpdate']);
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new CommitResponse());

        $snippet = $this->snippetFromMethod(Database::class, 'insertOrUpdateBatch');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }

    public function testReplace()
    {
        $this->spannerClient->commit(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return isset($message['mutations'][0]['replace']);
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new CommitResponse());

        $snippet = $this->snippetFromMethod(Database::class, 'replace');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }

    public function testReplaceBatch()
    {
        $this->spannerClient->commit(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return isset($message['mutations'][0]['replace'])
                    && isset($message['mutations'][1]['replace']);
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new CommitResponse());

        $snippet = $this->snippetFromMethod(Database::class, 'replaceBatch');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }

    public function testDelete()
    {
        $this->spannerClient->commit(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return isset($message['mutations'][0]['delete']);
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new CommitResponse());

        $snippet = $this->snippetFromMethod(Database::class, 'delete');
        $snippet->addUse(KeySet::class);
        $snippet->addLocal('database', $this->database);
        $snippet->invoke();
    }

    public function testExecute()
    {
        $this->spannerClient->executeStreamingSql(
            Argument::type(ExecuteSqlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream());

        $snippet = $this->snippetFromMethod(Database::class, 'execute');
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
    }

    public function testExecuteWithParameterType()
    {
        $message = $this->serializer->decodeMessage(
            new PartialResultSet(),
            [
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
                'values' => [
                    ['nullValue' => 0]
                ]
            ]
        );

        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return isset($message['params'])
                    && isset($message['paramTypes'])
                    && $message['paramTypes']['timestamp']['code'] === Database::TYPE_TIMESTAMP;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream([$this->serializer->decodeMessage(
                new PartialResultSet(),
                [
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
                    'values' => [
                        ['nullValue' => 0]
                    ]
                ]
            )]));

        $snippet = $this->snippetFromMethod(Database::class, 'execute', 1);
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('timestamp');
        $this->assertNull($res->returnVal());
    }

    public function testExecuteWithEmptyArray()
    {
        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return isset($message['params'])
                    && isset($message['paramTypes'])
                    && $message['paramTypes']['emptyArrayOfIntegers']['code'] === Database::TYPE_ARRAY
                    && $message['paramTypes']['emptyArrayOfIntegers']['arrayElementType']['code']
                        === Database::TYPE_INT64;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream([$this->serializer->decodeMessage(
                new PartialResultSet(),
                [
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
                    'values' => [
                        ['listValue' => []]
                    ]
                ]
            )]));

        $snippet = $this->snippetFromMethod(Database::class, 'execute', 2);
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('emptyArray');
        $this->assertEmpty($res->returnVal());
    }

    public function testExecuteBeginSnapshot()
    {
        $this->spannerClient->executeStreamingSql(
            Argument::type(ExecuteSqlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream([], null, self::TRANSACTION));

        $snippet = $this->snippetFromMethod(Database::class, 'execute', 5);
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
        $this->assertInstanceOf(Snapshot::class, $res->returnVal()->snapshot());
    }

    public function testExecuteBeginTransaction()
    {
        $this->spannerClient->executeStreamingSql(
            Argument::type(ExecuteSqlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream([], null, self::TRANSACTION));

        $snippet = $this->snippetFromMethod(Database::class, 'execute', 6);
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
        $this->assertInstanceOf(Transaction::class, $res->returnVal()->transaction());
    }

    public function testExecutePartitionedUpdate()
    {
        $this->spannerClient->beginTransaction(
            Argument::type(BeginTransactionRequest::class),
            Argument::type('array')
        )
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $stats = new ResultSetStats(['row_count_lower_bound' => 1]);
        $this->spannerClient->executeStreamingSql(
            Argument::type(ExecuteSqlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream([], $stats));

        $snippet = $this->snippetFromMethod(Database::class, 'executePartitionedUpdate');
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('deactivatedUserCount');
        $this->assertEquals(1, $res->returnVal());
    }

    public function testRead()
    {
        $this->spannerClient->streamingRead(
            Argument::type(ReadRequest::class),
            Argument::type('array')
        )->willReturn($this->resultGeneratorStream());

        $snippet = $this->snippetFromMethod(Database::class, 'read');
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
    }

    public function testReadWithSnapshot()
    {
        $this->spannerClient->streamingRead(
            Argument::type(ReadRequest::class),
            Argument::type('array')
        )->willReturn($this->resultGeneratorStream([], null, self::TRANSACTION));

        $snippet = $this->snippetFromMethod(Database::class, 'read', 1);
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
        $this->assertInstanceOf(Snapshot::class, $res->returnVal()->snapshot());
    }

    public function testReadWithTransaction()
    {
        $this->spannerClient->streamingRead(
            Argument::type(ReadRequest::class),
            Argument::type('array')
        )->willReturn($this->resultGeneratorStream([], null, self::TRANSACTION));

        $snippet = $this->snippetFromMethod(Database::class, 'read', 2);
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
        $this->assertInstanceOf(Transaction::class, $res->returnVal()->transaction());
    }

    public function testIam()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'iam');
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('iam');
        $this->assertInstanceOf(IamManager::class, $res->returnVal());
    }

    public function testResumeOperation()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'resumeOperation');
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

        $operation = new Operation();
        $page = $this->prophesize(Page::class);
        $page->getResponseObject()
            ->willReturn(new ListOperationsResponse(['operations' => [$operation]]));
        $page->getNextPageToken()
            ->willReturn(null);
        $pagedListResponse = $this->prophesize(PagedListResponse::class);
        $pagedListResponse->getPage()
            ->willReturn($page->reveal());

        $operationsClient = $this->prophesize(OperationsClient::class);
        $operationsClient->listOperations(Argument::cetera())
            ->willReturn($pagedListResponse->reveal());

        $this->databaseAdminClient->getOperationsClient()
            ->shouldBeCalledOnce()
            ->willReturn($operationsClient->reveal());

        $res = $snippet->invoke('operations');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertContainsOnlyInstancesOf(LongRunningOperation::class, $res->returnVal());
    }
}
