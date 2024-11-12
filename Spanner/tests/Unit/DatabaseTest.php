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
use Google\ApiCore\Page;
use Google\ApiCore\PagedListResponse;
use Google\ApiCore\Serializer;
use Google\ApiCore\ServerStream;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\Exception\AbortedException;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Exception\ServerException;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Core\Iam\IamManager;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\Fixtures;
use Google\Cloud\Spanner\Admin\Database\V1\Backup;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Database\V1\Database as DatabaseProto;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseDialect;
use Google\Cloud\Spanner\Admin\Database\V1\GetDatabaseDdlResponse;
use Google\Cloud\Spanner\Admin\Database\V1\GetDatabaseRequest;
use Google\Cloud\Spanner\Admin\Database\V1\ListBackupsResponse;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\Snapshot;
use Google\Cloud\Spanner\Tests\ResultGeneratorTrait;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\V1\BatchWriteRequest;
use Google\Cloud\Spanner\V1\BatchWriteRequest\MutationGroup;
use Google\Cloud\Spanner\V1\BeginTransactionRequest;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\CommitRequest;
use Google\Cloud\Spanner\V1\CommitResponse;
use Google\Cloud\Spanner\V1\DeleteSessionRequest;
use Google\Cloud\Spanner\V1\DirectedReadOptions\ReplicaSelection\Type as ReplicaType;
use Google\Cloud\Spanner\V1\ExecuteBatchDmlRequest;
use Google\Cloud\Spanner\V1\ExecuteBatchDmlResponse;
use Google\Cloud\Spanner\V1\ExecuteSqlRequest;
use Google\Cloud\Spanner\V1\Mutation;
use Google\Cloud\Spanner\V1\PartialResultSet;
use Google\Cloud\Spanner\V1\ReadRequest;
use Google\Cloud\Spanner\V1\ResultSet;
use Google\Cloud\Spanner\V1\ResultSetMetadata;
use Google\Cloud\Spanner\V1\ResultSetStats;
use Google\Cloud\Spanner\V1\Session as SessionProto;
use Google\Cloud\Spanner\V1\StructType;
use Google\Cloud\Spanner\V1\StructType\Field;
use Google\Cloud\Spanner\V1\Transaction as TransactionProto;
use Google\Cloud\Spanner\V1\TransactionSelector;
use Google\Cloud\Spanner\V1\Type as TypeProto;
use Google\Protobuf\Duration;
use Google\Protobuf\ListValue;
use Google\Protobuf\Timestamp as TimestampProto;
use Google\Protobuf\Value;
use Google\Rpc\Code;
use Google\Rpc\Status;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner
 * @group spanner-database
 */
class DatabaseTest extends TestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;
    use ResultGeneratorTrait;
    use ApiHelperTrait;

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

    private const DIRECTED_READ_OPTIONS_INCLUDE_REPLICAS = [
        'includeReplicas' => [
            'autoFailoverDisabled' => false,
            'replicaSelections' => [
                [
                    'location' => 'us-central1',
                    'type' => ReplicaType::READ_WRITE,
                ]
            ]
        ]
    ];

    private const DIRECTED_READ_OPTIONS_EXCLUDE_REPLICAS = [
        'excludeReplicas' => [
            'replicaSelections' => [
                [
                    'location' => 'us-central1',
                    'type' => ReplicaType::READ_WRITE,
                ]
            ]
        ]
    ];

    private $spannerClient;
    private $instanceAdminClient;
    private $databaseAdminClient;
    private $serializer;
    private $instance;
    private $sessionPool;
    private $database;
    private $session;
    private $operationResponse;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->serializer = new Serializer([], [
            'google.protobuf.Value' => function ($v) {
                return $this->flattenValue($v);
            },
            'google.protobuf.ListValue' => function ($v) {
                return $this->flattenListValue($v);
            },
            'google.protobuf.Struct' => function ($v) {
                return $this->flattenStruct($v);
            },
            'google.protobuf.Timestamp' => function ($v) {
                return $this->formatTimestampFromApi($v);
            }
        ]);

        $this->sessionPool = $this->prophesize(SessionPoolInterface::class);
        $this->spannerClient = $this->prophesize(SpannerClient::class);
        $this->instanceAdminClient = $this->prophesize(InstanceAdminClient::class);
        $this->databaseAdminClient = $this->prophesize(DatabaseAdminClient::class);

        $this->session = new Session(
            $this->spannerClient->reveal(),
            $this->serializer,
            self::PROJECT,
            self::INSTANCE,
            self::DATABASE,
            self::SESSION
        );

        $this->instance = new Instance(
            $this->spannerClient->reveal(),
            $this->instanceAdminClient->reveal(),
            $this->databaseAdminClient->reveal(),
            $this->serializer,
            self::PROJECT,
            self::INSTANCE,
            false,
            [],
            ['directedReadOptions' => self::DIRECTED_READ_OPTIONS_INCLUDE_REPLICAS]
        );

        $this->sessionPool->acquire(Argument::type('string'))
            ->willReturn($this->session);
        $this->sessionPool->setDatabase(Argument::type(Database::class))
            ->willReturn(null);
        $this->sessionPool->release(Argument::type(Session::class))
            ->willReturn(null);

        $this->database = new Database(
            $this->spannerClient->reveal(),
            $this->databaseAdminClient->reveal(),
            $this->serializer,
            $this->instance,
            self::PROJECT,
            self::DATABASE,
            $this->sessionPool->reveal(),
            false,
            [],
            'Reader'
        );

        $this->operationResponse = $this->prophesize(OperationResponse::class);
        $this->operationResponse->withResultFunction(Argument::type('callable'))
            ->willReturn($this->operationResponse->reveal());
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
        $this->databaseAdminClient->getDatabase(
            Argument::that(function (GetDatabaseRequest $request) {
                return $request->getName() === $this->database->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new DatabaseProto(['name' => $this->database->name()]));

        $this->assertArrayHasKey('name', $this->database->info());
        $this->assertEquals($this->database->info()['name'], $this->database->name());

        // Make sure the request only is sent once.
        $this->database->info();
    }

    public function testState()
    {
        $res = [
            'state' => Database::STATE_READY
        ];
        $this->databaseAdminClient->getDatabase(
            Argument::that(function (GetDatabaseRequest $request) {
                return $request->getName() === $this->database->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new DatabaseProto($res));

        $this->assertEquals(Database::STATE_READY, $this->database->state());

        // Make sure the request only is sent once.
        $this->database->state();
    }

    public function testCreateBackup()
    {
        $expireTime = new \DateTime();

        $this->databaseAdminClient->createBackup(
            Argument::that(function ($request) use ($expireTime) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['parent'],
                    $this->instance->name()
                );
                $this->assertEquals($message['backupId'], self::BACKUP);
                return $message['backup']['expireTime'] == $expireTime->format('Y-m-d\TH:i:s.u\Z')
                    && $message['backup']['database'] == $this->database->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        $op = $this->database->createBackup(self::BACKUP, $expireTime);

        $this->assertInstanceOf(OperationResponse::class, $op);
    }

    public function testBackups()
    {
        $backups = [
            new Backup(['name' => DatabaseAdminClient::backupName(self::PROJECT, self::INSTANCE, 'backup1')]),
            new Backup(['name' => DatabaseAdminClient::backupName(self::PROJECT, self::INSTANCE, 'backup2')])
        ];

        $page = $this->prophesize(Page::class);
        $page->getResponseObject()
            ->willReturn(new ListBackupsResponse(['backups' => $backups]));
        $pagedListResponse = $this->prophesize(PagedListResponse::class);
        $pagedListResponse->getPage()
            ->willReturn($page->reveal());

        $expectedFilter = 'database:' . $this->database->name();
        $this->databaseAdminClient->listBackups(
            Argument::that(function ($request) use ($expectedFilter) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['filter'],
                    $expectedFilter
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($pagedListResponse->reveal());

        $bkps = $this->database->backups();
        $this->assertInstanceOf(ItemIterator::class, $bkps);

        $bkps = iterator_to_array($bkps);
        $this->assertCount(2, $bkps);
        $this->assertEquals('backup1', DatabaseAdminClient::parseName($bkps[0]->name())['backup']);
        $this->assertEquals('backup2', DatabaseAdminClient::parseName($bkps[1]->name())['backup']);
    }

    public function testBackupsWithCustomFilter()
    {
        $backup1 = DatabaseAdminClient::backupName(self::PROJECT, self::INSTANCE, 'backup1');
        $backup2 = DatabaseAdminClient::backupName(self::PROJECT, self::INSTANCE, 'backup2');
        $backups = [new Backup(['name' => $backup1]), new Backup(['name' => $backup2])];

        $page = $this->prophesize(Page::class);
        $page->getResponseObject()
            ->willReturn(new ListBackupsResponse(['backups' => $backups]));
        $pagedListResponse = $this->prophesize(PagedListResponse::class);
        $pagedListResponse->getPage()
            ->willReturn($page->reveal());

        $defaultFilter = 'database:' . $this->database->name();
        $customFilter = 'customFilter';
        $expectedFilter = sprintf('(%1$s) AND (%2$s)', $defaultFilter, $customFilter);

        $this->databaseAdminClient->listBackups(
            Argument::that(function ($request) use ($expectedFilter) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['filter'],
                    $expectedFilter
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($pagedListResponse->reveal());

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

        $this->databaseAdminClient->getDatabase(
            Argument::that(function (GetDatabaseRequest $request) {
                return $request->getName() === $this->database->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledTimes(2)
            ->willReturn(new DatabaseProto($res));

        $info = $this->database->reload();
        $this->assertArrayHasKey('name', $info);
        $this->assertEquals($info['name'], $this->database->name());

        // Make sure the request is sent each time the method is called.
        $this->database->reload();
    }

    /**
     * @group spanner-admin
     */
    public function testExists()
    {
        $this->databaseAdminClient->getDatabase(
            Argument::that(function (GetDatabaseRequest $request) {
                return $request->getName() === $this->database->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new DatabaseProto());

        $this->assertTrue($this->database->exists());
    }

    /**
     * @group spanner-admin
     */
    public function testExistsNotFound()
    {
        $this->databaseAdminClient->getDatabase(
            Argument::that(function (GetDatabaseRequest $request) {
                return $request->getName() === $this->database->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willThrow(new NotFoundException('', 404));

        $this->assertFalse($this->database->exists());
    }

    /**
     * @group spanner-admin
     */
    public function testCreate()
    {
        $this->databaseAdminClient->createDatabase(
            Argument::that(function ($request) {
                $createStatement = $request->getCreateStatement();
                $extraStatements = $request->getExtraStatements();
                $this->assertStringContainsString('my-database', $createStatement);
                $this->assertEquals(['CREATE TABLE bar'], iterator_to_array($extraStatements));
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        new OperationResponse('my-operation', new DatabaseAdminClient([
            'credentials' => Fixtures::KEYFILE_STUB_FIXTURE()
        ]), [
            'lastProtoResponse' => $this->serializer->decodeMessage(
                new DatabaseProto(),
                ['name' => 'my-database']
            )
            ]);

        $op = $this->database->create([
            'statements' => [
                'CREATE TABLE bar'
            ]
        ]);

        $this->assertInstanceOf(OperationResponse::class, $op);
    }

    /**
     * @group spanner-admin
     */
    public function testUpdateDatabase()
    {
        $this->databaseAdminClient->updateDatabase(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['database']['name'],
                    DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
                );
                $this->assertEquals($message['updateMask'], ['paths' => ['enable_drop_protection']]);
                return $message['database']['enableDropProtection'];
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        $op = $this->database->updateDatabase(['enableDropProtection' => true]);
        $this->assertInstanceOf(OperationResponse::class, $op);
    }

    /**
     * @group spanner-admin
     */
    public function testCreatePostgresDialect()
    {
        $createStatement = sprintf('CREATE DATABASE "%s"', self::DATABASE);

        $this->databaseAdminClient->createDatabase(
            Argument::that(function ($request) use ($createStatement) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals($message['createStatement'], $createStatement);
                $this->assertEmpty($message['extraStatements']);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        $op = $this->database->create([
            'databaseDialect' => DatabaseDialect::POSTGRESQL
        ]);

        $this->assertInstanceOf(OperationResponse::class, $op);
    }

    /**
     * @group spanner-admin
     */
    public function testRestoreFromBackupName()
    {
        $backupName = DatabaseAdminClient::backupName(self::PROJECT, self::INSTANCE, self::BACKUP);

        $this->databaseAdminClient->restoreDatabase(
            Argument::that(function ($request) use ($backupName) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['parent'],
                    $this->instance->name()
                );
                $this->assertEquals($message['databaseId'], self::DATABASE);
                $this->assertEquals($message['backup'], $backupName);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        $op = $this->database->restore($backupName);
        $this->assertInstanceOf(OperationResponse::class, $op);
    }

    /**
     * @group spanner-admin
     */
    public function testRestoreFromBackupObject()
    {
        $backupObj = $this->instance->backup(self::BACKUP);

        $this->databaseAdminClient->restoreDatabase(
            Argument::that(function ($request) use ($backupObj) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['parent'],
                    $this->instance->name()
                );
                $this->assertEquals($message['databaseId'], self::DATABASE);
                $this->assertEquals($message['backup'], $backupObj->name());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        $op = $this->database->restore($backupObj);
        $this->assertInstanceOf(OperationResponse::class, $op);
    }

    /**
     * @group spanner-admin
     */
    public function testUpdateDdl()
    {
        $statement = 'foo';
        $this->databaseAdminClient->updateDatabaseDdl(
            Argument::that(function ($request) use ($statement) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['database'],
                    DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
                );
                $this->assertEquals($message['statements'], [$statement]);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        $res = $this->database->updateDdl($statement);

        $this->assertInstanceOf(OperationResponse::class, $res);
    }
    /**
     * @group spanner-admin
     */
    public function testUpdateDdlBatch()
    {
        $statements = ['foo', 'bar'];

        $this->databaseAdminClient->updateDatabaseDdl(
            Argument::that(function ($request) use ($statements) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['database'],
                    DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
                );
                $this->assertEquals($message['statements'], $statements);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        $this->database->updateDdlBatch($statements);
    }

    /**
     * @group spanner-admin
     */
    public function testUpdateWithSingleStatement()
    {
        $statement = 'foo';

        $this->databaseAdminClient->updateDatabaseDdl(
            Argument::that(function ($request) use ($statement) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['database'],
                    DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
                );
                $this->assertEquals($message['statements'], [$statement]);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        $res = $this->database->updateDdl($statement);
        $this->assertInstanceOf(OperationResponse::class, $res);
    }

    /**
     * @group spanner-admin
     */
    public function testDrop()
    {
        $this->databaseAdminClient->dropDatabase(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['database'],
                    DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce();

        $this->sessionPool->clear()->shouldBeCalled()->willReturn(null);

        $this->database->drop();
    }

    /**
     * @group spanner-admin
     */
    public function testDropDeleteSession()
    {
        $this->spannerClient->createSession(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return $message['database'] == $this->database->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new SessionProto(['name' => $this->session->name()]));

        $this->spannerClient->beginTransaction(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return $message['session'] == $this->session->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $this->spannerClient->deleteSession(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return $message['name'] == $this->session->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce();

        $this->databaseAdminClient->dropDatabase(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['database'],
                    DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce();

        $database = new Database(
            $this->spannerClient->reveal(),
            $this->databaseAdminClient->reveal(),
            $this->serializer,
            $this->instance,
            self::PROJECT,
            self::DATABASE
        );

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
        $this->databaseAdminClient->getDatabaseDdl(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['database'],
                    DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new GetDatabaseDdlResponse(['statements' => $ddl]));

        $this->assertEquals($ddl, $this->database->ddl());
    }

    /**
     * @group spanner-admin
     */
    public function testDdlNoResult()
    {
        $this->databaseAdminClient->getDatabaseDdl(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['database'],
                    DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new GetDatabaseDdlResponse());

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
        $this->spannerClient->beginTransaction(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return $message['session'] == $this->session->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

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
        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();

        $this->spannerClient->rollback(Argument::cetera())->shouldNotBeCalled();

        $this->database->runTransaction(function ($t) {
            $this->database->snapshot();
        });
    }

    public function testBatchWrite()
    {
        $expectedMutationGroup = new MutationGroup(['mutations' => [
            new Mutation(['insert_or_update' => new Mutation\Write([
                'table' => 'foo',
                'columns' => ['bar1', 'bar2'],
                'values' => [new ListValue(['values' => [
                    new Value(['string_value' => '1']),
                    new Value(['string_value' => '2']),
                ]])]
            ])])
        ]]);

        $this->spannerClient->batchWrite(
            Argument::that(function ($request) use ($expectedMutationGroup) {
                return $request->getSession() === $this->session->name()
                    && $request->getMutationGroups()[0] == $expectedMutationGroup;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream());

        $mutationGroups = [
            ($this->database->mutationGroup(false))
                ->insertOrUpdate(
                    'foo',
                    ['bar1' => 1, 'bar2' => 2]
                )
        ];

        $result = $this->database->batchWrite($mutationGroups);
        $this->assertEquals('10', iterator_to_array($result)[0]['values'][0]);
    }

    public function testRunTransaction()
    {
        $this->stubCommit(false);

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

        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();

        $this->spannerClient->rollback(Argument::cetera())->shouldNotBeCalled();

        $this->database->runTransaction($this->noop());
    }

    public function testRunTransactionNestedTransaction()
    {
        $this->expectException(\BadMethodCallException::class);

        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();

        $this->spannerClient->rollback(Argument::cetera())->shouldNotBeCalled();

        $this->database->runTransaction(function ($t) {
            $this->database->runTransaction($this->noop());
        });
    }

    public function testRunTransactionShouldRetryOnRstStreamErrors()
    {
        $this->expectException(ServerException::class);
        $this->expectExceptionMessage('RST_STREAM');
        $err = new ServerException('RST_STREAM', Code::INTERNAL);

        $this->spannerClient->beginTransaction(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return $message['session'] == $this->session->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledTimes(3)
            ->willThrow($err);

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

        $this->spannerClient->beginTransaction(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return $message['session'] == $this->session->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledTimes(3)
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $it = 0;
        $commitResponse = $this->commitResponse();
        $this->spannerClient->commit(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return $message['session'] == $this->session->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledTimes(3)
            ->will(function () use (&$it, $abort, $commitResponse) {
                $it++;
                if ($it <= 2) {
                    throw $abort;
                }

                return $commitResponse;
            });

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

        $this->spannerClient->beginTransaction(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return $message['session'] == $this->session->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledTimes(Database::MAX_RETRIES + 1)
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $it = 0;
        $this->spannerClient->commit(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return $message['session'] == $this->session->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledTimes(Database::MAX_RETRIES + 1)
            ->will(function () use (&$it, $abort) {
                $it++;
                if ($it <= Database::MAX_RETRIES + 1) {
                    throw $abort;
                }
                return ['commitTimestamp' => TransactionTest::TIMESTAMP];
            });

        $this->database->runTransaction(function ($t) {
            $t->commit();
        });
    }

    public function testTransaction()
    {
        $this->spannerClient->beginTransaction(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['requestOptions']['transactionTag' ],
                    self::TRANSACTION_TAG,
                );
                return $message['session'] == $this->session->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $t = $this->database->transaction(['tag' => self::TRANSACTION_TAG]);
        $this->assertInstanceOf(Transaction::class, $t);
    }

    public function testTransactionNestedTransaction()
    {
        $this->expectException(\BadMethodCallException::class);

        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();

        $this->spannerClient->rollback(Argument::cetera())->shouldNotBeCalled();

        $this->database->runTransaction(function ($t) {
            $this->database->transaction();
        });
    }

    public function testInsert()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->spannerClient->commit(
            Argument::that(function ($request) use ($table, $row) {
                $request = $this->serializer->encodeMessage($request);

                if ($request['mutations'][0][OPERATION::OP_INSERT]['table'] !== $table) {
                    return false;
                }

                if ($request['mutations'][0][OPERATION::OP_INSERT]['columns'][0] !== array_keys($row)[0]) {
                    return false;
                }

                if ($request['mutations'][0][OPERATION::OP_INSERT]['values'][0][0] !== current($row)) {
                    return false;
                }

                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->commitResponse());

        $res = $this->database->insert($table, $row);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testInsertBatch()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->spannerClient->commit(
            Argument::that(function ($request) use ($table, $row) {
                $request = $this->serializer->encodeMessage($request);

                if ($request['mutations'][0][OPERATION::OP_INSERT]['table'] !== $table) {
                    return false;
                }

                if ($request['mutations'][0][OPERATION::OP_INSERT]['columns'][0] !== array_keys($row)[0]) {
                    return false;
                }

                if ($request['mutations'][0][OPERATION::OP_INSERT]['values'][0][0] !== current($row)) {
                    return false;
                }

                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->commitResponse());

        $res = $this->database->insertBatch($table, [$row]);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testUpdate()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->spannerClient->commit(
            Argument::that(function ($request) use ($table, $row) {
                $request = $this->serializer->encodeMessage($request);

                if ($request['mutations'][0][OPERATION::OP_UPDATE]['table'] !== $table) {
                    return false;
                }

                if ($request['mutations'][0][OPERATION::OP_UPDATE]['columns'][0] !== array_keys($row)[0]) {
                    return false;
                }

                if ($request['mutations'][0][OPERATION::OP_UPDATE]['values'][0][0] !== current($row)) {
                    return false;
                }

                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->commitResponse());

        $res = $this->database->update($table, $row);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testUpdateBatch()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->spannerClient->commit(
            Argument::that(function ($request) use ($table, $row) {
                $request = $this->serializer->encodeMessage($request);

                if ($request['mutations'][0][OPERATION::OP_UPDATE]['table'] !== $table) {
                    return false;
                }

                if ($request['mutations'][0][OPERATION::OP_UPDATE]['columns'][0] !== array_keys($row)[0]) {
                    return false;
                }

                if ($request['mutations'][0][OPERATION::OP_UPDATE]['values'][0][0] !== current($row)) {
                    return false;
                }

                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->commitResponse());

        $res = $this->database->updateBatch($table, [$row]);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testInsertOrUpdate()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->spannerClient->commit(
            Argument::that(function ($request) use ($table, $row) {
                $request = $this->serializer->encodeMessage($request);

                if ($request['mutations'][0][OPERATION::OP_INSERT_OR_UPDATE]['table'] !== $table) {
                    return false;
                }

                if ($request['mutations'][0][OPERATION::OP_INSERT_OR_UPDATE]['columns'][0] !== array_keys($row)[0]) {
                    return false;
                }

                if ($request['mutations'][0][OPERATION::OP_INSERT_OR_UPDATE]['values'][0][0] !== current($row)) {
                    return false;
                }

                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->commitResponse());

        $res = $this->database->insertOrUpdate($table, $row);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testInsertOrUpdateBatch()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->spannerClient->commit(
            Argument::that(function ($request) use ($table, $row) {
                $request = $this->serializer->encodeMessage($request);

                if ($request['mutations'][0][OPERATION::OP_INSERT_OR_UPDATE]['table'] !== $table) {
                    return false;
                }

                if ($request['mutations'][0][OPERATION::OP_INSERT_OR_UPDATE]['columns'][0] !== array_keys($row)[0]) {
                    return false;
                }

                if ($request['mutations'][0][OPERATION::OP_INSERT_OR_UPDATE]['values'][0][0] !== current($row)) {
                    return false;
                }

                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->commitResponse());

        $res = $this->database->insertOrUpdateBatch($table, [$row]);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testReplace()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->spannerClient->commit(
            Argument::that(function ($request) use ($table, $row) {
                $request = $this->serializer->encodeMessage($request);

                if ($request['mutations'][0][OPERATION::OP_REPLACE]['table'] !== $table) {
                    return false;
                }

                if ($request['mutations'][0][OPERATION::OP_REPLACE]['columns'][0] !== array_keys($row)[0]) {
                    return false;
                }

                if ($request['mutations'][0][OPERATION::OP_REPLACE]['values'][0][0] !== current($row)) {
                    return false;
                }

                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->commitResponse());

        $res = $this->database->replace($table, $row);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testReplaceBatch()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->spannerClient->commit(
            Argument::that(function ($request) use ($table, $row) {
                $request = $this->serializer->encodeMessage($request);

                if ($request['mutations'][0][OPERATION::OP_REPLACE]['table'] !== $table) {
                    return false;
                }

                if ($request['mutations'][0][OPERATION::OP_REPLACE]['columns'][0] !== array_keys($row)[0]) {
                    return false;
                }

                if ($request['mutations'][0][OPERATION::OP_REPLACE]['values'][0][0] !== current($row)) {
                    return false;
                }

                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->commitResponse());

        $res = $this->database->replaceBatch($table, [$row]);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testDelete()
    {
        $table = 'foo';
        $keys = [10, 'bar'];

        $this->spannerClient->commit(
            Argument::that(function ($request) use ($table, $keys) {
                $request = $this->serializer->encodeMessage($request);

                if ($request['mutations'][0][Operation::OP_DELETE]['table'] !== $table) {
                    return false;
                }

                if ($request['mutations'][0][Operation::OP_DELETE]['keySet']['keys'][0][0] !== (string) $keys[0]) {
                    return false;
                }

                if ($request['mutations'][0][Operation::OP_DELETE]['keySet']['keys'][1][0] !== $keys[1]) {
                    return false;
                }

                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->commitResponse());

        $res = $this->database->delete($table, new KeySet(['keys' => $keys]));
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testExecute()
    {
        $sql = 'SELECT * FROM Table';

        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) use ($sql) {
                return $request->getSql() == $sql;
            }),
            Argument::that(function ($callOptions) {
                $this->assertArrayHasKey('headers', $callOptions);
                $this->assertArrayHasKey('x-goog-spanner-route-to-leader', $callOptions['headers']);
                $this->assertEquals(['true'], $callOptions['headers']['x-goog-spanner-route-to-leader']);
                return true;
            })
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream(
                null,
                new ResultSetStats(['row_count_lower_bound' => 1]),
                self::TRANSACTION
            ));

        $res = $this->database->execute($sql, [
            'transactionType' => SessionPoolInterface::CONTEXT_READWRITE
        ]);
        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertEquals(10, $rows[0]['ID']);
    }

    public function testExecuteWithSingleSession()
    {
        $sql = 'SELECT * FROM Table';

        $sessName = SpannerClient::sessionName(self::PROJECT, self::INSTANCE, self::DATABASE, self::SESSION);
        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) use ($sessName) {
                return $request->getSession() == $sessName;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream());

        $res = $this->database->execute($sql);
        $rows = iterator_to_array($res->rows());
    }

    public function testExecuteSingleUseMaxStaleness()
    {
        $sql = 'SELECT * FROM Table';

        $sessName = SpannerClient::sessionName(self::PROJECT, self::INSTANCE, self::DATABASE, self::SESSION);
        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) use ($sessName) {
                return $request->getSession() == $sessName;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream());

        $res = $this->database->execute($sql, [
            'maxStaleness' => new Duration(['seconds' => 10, 'nanos' => 0])
        ]);
        $rows = iterator_to_array($res->rows());
    }

    public function testExecuteBeginMaxStalenessFails()
    {
        $this->expectException(\BadMethodCallException::class);

        $sql = 'SELECT * FROM Table';

        $this->database->execute($sql, [
            'begin' => true,
            'maxStaleness' => new Duration(['seconds' => 10, 'nanos' => 0])
        ]);
    }

    public function testExecutePartitionedUpdate()
    {
        $sql = 'UPDATE foo SET bar = @bar';
        $this->spannerClient->beginTransaction(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['options']['partitionedDml' ],
                    []
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $this->spannerClient->executeStreamingSql(
            Argument::that(function (ExecuteSqlRequest $request) use ($sql) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals($message['sql'], $sql);
                $this->assertEquals($message['transaction'], ['id' => self::TRANSACTION]);
                return true;
            }),
            Argument::that(function ($callOptions) {
                $this->assertArrayHasKey('headers', $callOptions);
                $this->assertArrayHasKey('x-goog-spanner-route-to-leader', $callOptions['headers']);
                $this->assertEquals(['true'], $callOptions['headers']['x-goog-spanner-route-to-leader']);
                return true;
            })
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream(
                null,
                new ResultSetStats(['row_count_lower_bound' => 1]),
                true
            ));

        $res = $this->database->executePartitionedUpdate($sql);

        $this->assertEquals(1, $res);
    }

    public function testRead()
    {
        $table = 'Table';
        $opts = ['foo' => 'bar'];

        $this->spannerClient->streamingRead(
            Argument::that(function (ReadRequest $request) use ($table) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals($request->getTable(), $table);
                $this->assertEquals(
                    $message['keySet'],
                    ['all' => true, 'keys' => [], 'ranges' => []]
                );
                $this->assertEquals($message['columns'], ['ID']);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream());

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
        $this->spannerClient->beginTransaction(
            Argument::type(BeginTransactionRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $this->sessionPool->release(Argument::type(Session::class))
            ->shouldBeCalled()
            ->willReturn(null);

        // start a transaction to create a session
        $this->database->transaction();

        $this->database->close();
    }

    public function testCloseNoPool()
    {
        $database = new Database(
            $this->spannerClient->reveal(),
            $this->databaseAdminClient->reveal(),
            $this->serializer,
            $this->instance,
            self::PROJECT,
            self::DATABASE
        );

        $this->spannerClient->createSession(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return $message['database'] == $this->database->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new SessionProto(['name' => $this->session->name()]));

        $this->spannerClient->deleteSession(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return $message['name'] == $this->session->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce();

        $this->spannerClient->beginTransaction(
            Argument::type(BeginTransactionRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        // start a transaction to create a session
        $database->transaction();

        $this->database->close();
    }

    public function testCreateSession()
    {
        $this->spannerClient->createSession(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return $message['database'] == $this->database->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new SessionProto(['name' => $this->session->name()]));

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
        return new CommitResponse([
            'commit_timestamp' => new TimestampProto([
                'seconds' => (new \DateTime(self::TIMESTAMP))->format('U'),
                'nanos' => 534799000
            ])
        ]);
    }

    private function assertTimestampIsCorrect($res)
    {
        $ts = new \DateTimeImmutable(self::TIMESTAMP);

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
        $this->spannerClient->createSession(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals($message['session']['creatorRole'], 'Reader');
                return $message['database'] == $this->database->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new SessionProto(['name' => $this->session->name()]));

        $sql = $this->createStreamingAPIArgs()['sql'];
        $this->spannerClient->executeStreamingSql(
            Argument::that(function (ExecuteSqlRequest $request) use ($sql) {
                $this->assertEquals($request->getSql(), $sql);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream());

        $this->spannerClient->deleteSession(
            Argument::type(DeleteSessionRequest::class),
            Argument::type('array')
        )->shouldBeCalledOnce();

        $databaseWithDatabaseRole = new Database(
            $this->spannerClient->reveal(),
            $this->databaseAdminClient->reveal(),
            $this->serializer,
            $this->instance,
            self::PROJECT,
            self::DATABASE,
            null,
            false,
            [],
            'Reader'
        );
        $databaseWithDatabaseRole->execute($sql);
    }

    public function testExecuteWithDirectedRead()
    {
        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['directedReadOptions'],
                    self::DIRECTED_READ_OPTIONS_INCLUDE_REPLICAS
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream());

        $sql = 'SELECT * FROM Table';
        $res = $this->database->execute($sql);
        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertCount(1, $rows);
    }

    public function testPrioritizeExecuteDirectedReadOptions()
    {
        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['directedReadOptions'],
                    self::DIRECTED_READ_OPTIONS_EXCLUDE_REPLICAS
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream());

        $sql = 'SELECT * FROM Table';
        $res = $this->database->execute(
            $sql,
            ['directedReadOptions' => self::DIRECTED_READ_OPTIONS_EXCLUDE_REPLICAS]
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
        $this->spannerClient->streamingRead(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['directedReadOptions'],
                    self::DIRECTED_READ_OPTIONS_INCLUDE_REPLICAS
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream());

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
        $this->spannerClient->streamingRead(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['directedReadOptions'],
                    self::DIRECTED_READ_OPTIONS_EXCLUDE_REPLICAS
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream());

        $res = $this->database->read(
            $table,
            new KeySet(['keys' => $keys]),
            $columns,
            ['directedReadOptions' => self::DIRECTED_READ_OPTIONS_EXCLUDE_REPLICAS]
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
        $this->spannerClient->executeBatchDml(
            Argument::that(function (ExecuteBatchDmlRequest $request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['requestOptions']['transactionTag'],
                    self::TRANSACTION_TAG
                );
                $this->assertEquals([
                    'begin' => [
                        'readWrite' => [
                            'readLockMode' => 0,
                            'multiplexedSessionPreviousTransactionId' => '',
                        ],
                        'excludeTxnFromChangeStreams' => false
                    ]
                ], $message['transaction']);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new ExecuteBatchDmlResponse([
                'status' => new Status(['code' => Code::INVALID_ARGUMENT]),
                'result_sets' => [
                    new ResultSet([
                        'metadata' => new ResultSetMetadata([
                            'transaction' => new TransactionProto(['id' => self::TRANSACTION])
                        ])
                    ])
                ]
            ]));

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
        $this->spannerClient->executeStreamingSql(
            Argument::that(function (ExecuteSqlRequest $request) use ($sql) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals($sql, $message['sql']);
                $this->assertEquals(
                    $message['requestOptions']['transactionTag'],
                    self::TRANSACTION_TAG
                );
                return $message['transaction'] == [
                    'begin' => [
                        'readWrite' => [
                            'readLockMode' => 0,
                            'multiplexedSessionPreviousTransactionId' => '',
                        ],
                        'excludeTxnFromChangeStreams' => false,
                    ]
                ];
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willThrow($error);

        // Second call with non ILB return result
        $this->spannerClient->executeStreamingSql(
            Argument::that(function (ExecuteSqlRequest $request) use ($sql) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals($sql, $message['sql']);
                $this->assertEquals(
                    $message['requestOptions']['transactionTag'],
                    self::TRANSACTION_TAG
                );
                return $message['transaction'] == ['id' => self::TRANSACTION];
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream(
                null,
                new ResultSetStats(['row_count_exact' => 1]),
                self::TRANSACTION
            ));

        $this->stubCommit(false);

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
        $this->spannerClient->beginTransaction(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return $message['session'] == $this->session->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledTimes($numOfRetries)
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $it = 0;
        $commitResponse = $this->commitResponse();
        $this->spannerClient->commit(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return $message['session'] == $this->session->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledTimes($numOfRetries + 1)
            ->will(function () use (&$it, $abort, $numOfRetries, $commitResponse) {
                $it++;
                if ($it <= $numOfRetries) {
                    throw $abort;
                }
                return $commitResponse;
            });

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

        $this->spannerClient->executeStreamingSql(
            Argument::that(function (ExecuteSqlRequest $request) use ($sql) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals($sql, $message['sql']);
                $this->assertEquals(
                    $message['requestOptions']['transactionTag'],
                    self::TRANSACTION_TAG
                );
                return $message['transaction'] == [
                    'begin' => [
                        'readWrite' => [
                            'readLockMode' => 0,
                            'multiplexedSessionPreviousTransactionId' => ''
                        ],
                        'excludeTxnFromChangeStreams' => false
                    ]
                ];
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willThrow($error);

        $this->spannerClient->beginTransaction(
            Argument::that(function ($request) use ($sql) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals($message['session'], $this->session->name());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledTimes(Database::MAX_RETRIES)
            ->willThrow($error);

        $this->spannerClient->commit(Argument::cetera())->shouldNotBeCalled();

        $this->database->runTransaction(function ($t) use ($sql) {
            $t->execute($sql);
            $t->commit();
        }, ['tag' => self::TRANSACTION_TAG]);
    }

    public function testRunTransactionWithBlindCommit()
    {
        $this->stubCommit(false);

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
        $result = $this->resultGeneratorStream(
            null,
            new ResultSetStats(['row_count_lower_bound' => 1]),
            self::TRANSACTION
        );

        $it = 0;
        // First call with ILB results in unavailable error.
        // Second call also made with ILB, returns ResultSet.
        $this->spannerClient->executeStreamingSql(
            Argument::that(function (ExecuteSqlRequest $request) use ($sql) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals($message['sql'], $sql);
                $this->assertEquals(
                    $message['transaction'],
                    [
                        'begin' => [
                            'readWrite' => [
                                'readLockMode' => 0,
                                'multiplexedSessionPreviousTransactionId' => ''
                            ],
                            'excludeTxnFromChangeStreams' => false
                        ]
                    ]
                );
                return $message['requestOptions']['transactionTag'] == self::TRANSACTION_TAG;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledTimes($numOfRetries)
            ->will(function () use (&$it, $numOfRetries, $result) {
                $it++;
                if ($it < $numOfRetries) {
                    throw new ServiceException('Unavailable', 14);
                }
                return $result;
            });

        $this->stubCommit();

        $this->database->runTransaction(function ($t) use ($sql) {
            $t->execute($sql);
            $t->commit();
        }, ['tag' => self::TRANSACTION_TAG]);
    }

    public function testRunTransactionWithFirstUnavailableErrorRetry()
    {
        $sql = $this->createStreamingAPIArgs()['sql'];
        $unavailable = new ServiceException('Unavailable', 14);
        $stream = $this->prophesize(ServerStream::class);
        $stream->readAll()
            ->willReturn($this->resultGeneratorWithError());

        // First call with ILB results in a transaction.
        // Then the stream fails, Second call needs to use the
        // transaction created by the first call.
        $this->spannerClient->executeStreamingSql(
            Argument::that(function (ExecuteSqlRequest $request) use ($sql) {
                $this->assertEquals($request->getSql(), $sql);
                return $this->serializer->decodeMessage(
                    new TransactionSelector(),
                    self::BEGIN_RW_OPTIONS
                ) == $request->getTransaction()
                    && $request->getRequestOptions()->getTransactionTag() == self::TRANSACTION_TAG;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($stream->reveal());

        $this->stubExecuteStreamingSql(['id' => self::TRANSACTION]);
        $this->stubCommit();

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
        $this->spannerClient->streamingRead(
            Argument::that(function ($request) use ($cols) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals($message['table'], self::TEST_TABLE_NAME);
                $this->assertEquals($message['columns'], $cols);
                return $message['transaction']
                        == [
                            'begin' => [
                                'readWrite' => [
                                    'readLockMode' => 0,
                                    'multiplexedSessionPreviousTransactionId' => ''
                                ],
                                'excludeTxnFromChangeStreams' => false
                            ]
                        ]
                    && $message['requestOptions']['transactionTag'] == self::TRANSACTION_TAG;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledTimes($numOfRetries)
            ->will(function () use (&$it, $unavailable, $numOfRetries, $abort) {
                $it++;
                if ($it < $numOfRetries) {
                    throw $unavailable;
                } else {
                    throw $abort;
                }
            });

        // Should retry with beginTransaction RPC.
        $this->stubStreamingRead(['id' => self::TRANSACTION]);

        $this->spannerClient->beginTransaction(
            Argument::type(BeginTransactionRequest::class),
            Argument::type('array')
        )
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $this->spannerClient->commit(
            Argument::that(function (CommitRequest $request) {
                $this->assertEquals($request->getSession(), $this->session->name());
                $this->assertEquals($request->getTransactionId(), self::TRANSACTION);
                $this->assertEquals($request->getRequestOptions()->getTransactionTag(), self::TRANSACTION_TAG);
                $this->assertEquals($this->serializer->encodeMessage($request)['mutations'], [['insert' => [
                    'table' => self::TEST_TABLE_NAME,
                    'columns' => ['ID', 'title', 'content'],
                    'values' => [['10', 'My New Post', 'Hello World']]
                ]]]);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->commitResponse());

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
        $this->spannerClient->rollback(
            Argument::that(function ($request) use ($sql) {
                return $request->getTransactionId() == self::TRANSACTION;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce();

        $this->database->runTransaction(function (Transaction $t) use ($sql) {
            $t->execute($sql);
            $t->rollback();
        }, ['tag' => self::TRANSACTION_TAG]);
    }

    public function testRunTransactionWithExcludeTxnFromChangeStreams()
    {
        $sql = 'SELECT example FROM sql_query';
        $stream = $this->prophesize(ServerStream::class);
        $stream->readAll()
            ->shouldBeCalledOnce()
            ->willReturn([
                new ResultSet(['stats' => new ResultSetStats(['row_count_exact' => 0])])
            ]);

        $this->spannerClient->executeStreamingSql(
            Argument::that(function (ExecuteSqlRequest $request) {
                $this->assertNotNull($transactionOptions = $request->getTransaction()->getBegin());
                $this->assertTrue($transactionOptions->getExcludeTxnFromChangeStreams());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($stream->reveal());

        $this->database->runTransaction(
            function (Transaction $t) use ($sql) {
                // Run a fake query
                $t->executeUpdate($sql);

                // Simulate calling Transaction::commmit()
                $prop = new \ReflectionProperty($t, 'state');
                $prop->setAccessible(true);
                $prop->setValue($t, Transaction::STATE_COMMITTED);
            },
            ['transactionOptions' => ['excludeTxnFromChangeStreams' => true]]
        );
    }

    public function testExecutePartitionedUpdateWithExcludeTxnFromChangeStreams()
    {
        $sql = 'SELECT example FROM sql_query';

        $stream = $this->prophesize(ServerStream::class);
        $stream->readAll()
            ->shouldBeCalledOnce()
            ->willReturn([
                new ResultSet(['stats' => new ResultSetStats(['row_count_lower_bound' => 0])])
            ]);

        $this->spannerClient->executeStreamingSql(
            Argument::type(ExecuteSqlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($stream->reveal());

        $this->spannerClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) {
                $this->assertTrue($request->getOptions()->getExcludeTxnFromChangeStreams());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new TransactionProto(['id' => 'foo']));

        $this->database->executePartitionedUpdate(
            $sql,
            ['transactionOptions' => ['excludeTxnFromChangeStreams' => true]]
        );
    }

    public function testBatchWriteWithExcludeTxnFromChangeStreams()
    {
        $this->spannerClient->batchWrite(
            Argument::that(function (BatchWriteRequest $request) {
                $this->assertTrue($request->getExcludeTxnFromChangeStreams());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream());

        $this->database->batchWrite([], [
            'excludeTxnFromChangeStreams' => true
        ]);
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
        $fields = new Field([
            'name' => 'ID',
            'type' => new TypeProto(['code' => Database::TYPE_INT64])
        ]);
        $values = [new Value(['number_value' => 10])];
        $result = new PartialResultSet([
            'metadata' => new ResultSetMetadata([
                'row_type' => new StructType([
                    'fields' => [$fields]
                ]),
                'transaction' => new TransactionProto(['id' => self::TRANSACTION])
            ]),
            'values' => $values
        ]);

        yield $result;
        throw new ServiceException('Unavailable', 14);
    }

    private function stubCommit($withTransaction = true)
    {
        if ($withTransaction) {
            $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();
        } else {
            $this->spannerClient->beginTransaction(
                Argument::type(BeginTransactionRequest::class),
                Argument::type('array')
            )
                ->shouldBeCalledOnce()
                ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));
        }

        $this->spannerClient->commit(
            Argument::that(function (CommitRequest $request) {
                $this->assertEquals($request->getSession(), $this->session->name());
                $this->assertEquals($request->getTransactionId(), self::TRANSACTION);
                $this->assertEquals($request->getRequestOptions()->getTransactionTag(), self::TRANSACTION_TAG);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->commitResponse());
    }

    private function stubStreamingRead($transactionOptions = self::BEGIN_RW_OPTIONS)
    {
        $cols = $this->createStreamingAPIArgs()['cols'];
        $this->spannerClient->streamingRead(
            Argument::that(function (ReadRequest $request) use ($transactionOptions, $cols) {
                return $request->getTransaction() == $this->serializer->decodeMessage(
                    new TransactionSelector(),
                    $transactionOptions
                )
                    && $request->getTable() == self::TEST_TABLE_NAME
                    && iterator_to_array($request->getColumns()) == $cols
                    && $request->getRequestOptions()->getTransactionTag() == self::TRANSACTION_TAG;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream(
                null,
                new ResultSetStats(['row_count_exact' => 1]),
                self::TRANSACTION
            ));
    }

    private function stubExecuteStreamingSql($transactionOptions = self::BEGIN_RW_OPTIONS)
    {
        $sql = $this->createStreamingAPIArgs()['sql'];
        $this->spannerClient->executeStreamingSql(
            Argument::that(function (ExecuteSqlRequest $request) use ($sql, $transactionOptions) {
                return $request->getSql() == $sql
                    && $request->getTransaction() == $this->serializer->decodeMessage(
                        new TransactionSelector(),
                        $transactionOptions
                    )
                    && $request->getRequestOptions()->getTransactionTag() == self::TRANSACTION_TAG;
            }),
            Argument::type('array')
        )
            ->shouldBeCalled()
            ->willReturn($this->resultGeneratorStream(
                null,
                new ResultSetStats(['row_count_exact' => 1]),
                self::TRANSACTION
            ));
    }

    private function stubExecuteBatchDml($transactionOptions = self::BEGIN_RW_OPTIONS)
    {
        $this->spannerClient->executeBatchDml(
            Argument::that(function (ExecuteBatchDmlRequest $request) use ($transactionOptions) {
                $this->assertEquals(
                    $request->getTransaction(),
                    $this->serializer->decodeMessage(new TransactionSelector(), $transactionOptions)
                );
                $this->assertEquals(
                    $request->getRequestOptions()->getTransactionTag(),
                    self::TRANSACTION_TAG
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new ExecuteBatchDmlResponse([
                'result_sets' => [
                    new ResultSet(['metadata' => new ResultSetMetadata([
                        'transaction' => new TransactionProto(['id' => self::TRANSACTION])
                    ])])
                ]
            ]));
    }
}
