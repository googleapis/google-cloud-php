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

use Google\LongRunning\Client\OperationsClient;
use Google\Cloud\Core\Iam\IamManager;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Backup;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\Snapshot;
use Google\Cloud\Spanner\Tests\OperationRefreshTrait;
use Google\Cloud\Spanner\Tests\RequestHandlingTestTrait;
use Google\Cloud\Spanner\Tests\ResultGeneratorTrait;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner
 * @group spanner-database
 */
class DatabaseTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use OperationRefreshTrait;
    use ProphecyTrait;
    use RequestHandlingTestTrait;
    use ResultGeneratorTrait;

    const PROJECT = 'my-awesome-project';
    const DATABASE = 'my-database';
    const INSTANCE = 'my-instance';
    const TRANSACTION = 'my-transaction';
    const BACKUP = 'my-backup';

    private $requestHandler;
    private $serializer;
    private $database;
    private $instance;

    public function setUp(): void
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

        $this->requestHandler = $this->getRequestHandlerStub();
        $this->serializer = $this->getSerializer();
        $this->instance = TestHelpers::stub(Instance::class, [
            $this->requestHandler->reveal(),
            $this->serializer,
            self::PROJECT,
            self::INSTANCE
        ], ['requestHandler', 'serializer']);

        $this->database = TestHelpers::stub(Database::class, [
            $this->requestHandler->reveal(),
            $this->serializer,
            $this->instance,
            self::PROJECT,
            self::DATABASE,
            $sessionPool->reveal()
        ], ['requestHandler', 'serializer', 'operation']);
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

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'getDatabase',
            null,
            ['state' => Database::STATE_READY]
        );

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

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

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'listBackups',
            null,
            [
                'backups' => [
                    [
                        'name' => DatabaseAdminClient::backupName(self::PROJECT, self::INSTANCE, self::BACKUP)
                    ]
                ]
            ]
        );

        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->instance->___setProperty('serializer', $this->serializer);

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

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'createBackup',
            null,
            $this->getOperationResponseMock()
        );

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);
        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(OperationResponse::class, $res->returnVal());
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

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'getDatabase',
            null,
            ['statements' => []]
        );

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

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

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'getDatabase',
            null,
            $db
        );

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

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

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'getDatabase',
            null,
            $db,
            2
        );

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

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

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'createDatabase',
            null,
            $this->getOperationResponseMock()
        );

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(OperationResponse::class, $res->returnVal());
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

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'restoreDatabase',
            null,
            $this->getOperationResponseMock()
        );

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(OperationResponse::class, $res->returnVal());
    }

    /**
     * @group spanner-admin
     */
    public function testUpdateDdl()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'updateDdl');
        $snippet->addLocal('database', $this->database);

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'updateDatabaseDdl',
            null,
            $this->getOperationResponseMock()
        );

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

        $snippet->invoke();
    }

    /**
     * @group spanner-admin
     */
    public function testUpdateDdlBatch()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'updateDdlBatch');
        $snippet->addLocal('database', $this->database);

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'updateDatabaseDdl',
            null,
            $this->getOperationResponseMock()
        );

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

        $snippet->invoke();
    }

    /**
     * @group spanner-admin
     */
    public function testDrop()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'drop');
        $snippet->addLocal('database', $this->database);

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'dropDatabase',
            null,
            null
        );

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

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

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'getDatabaseDdl',
            null,
            ['statements' => $stmts]
        );

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke('statements');
        $this->assertEquals($stmts, $res->returnVal());
    }

    public function testSnapshot()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            null,
            ['id' => self::TRANSACTION]
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $snippet = $this->snippetFromMethod(Database::class, 'snapshot');
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('snapshot');
        $this->assertInstanceOf(Snapshot::class, $res->returnVal());
    }

    public function testSnapshotReadTimestamp()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            null,
            [
                'id' => self::TRANSACTION,
                'readTimestamp' => (new Timestamp(new \DateTime))->formatAsString()
            ]
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $snippet = $this->snippetFromMethod(Database::class, 'snapshot', 1);
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('timestamp');
        $this->assertInstanceOf(Timestamp::class, $res->returnVal());
    }

    public function testRunTransaction()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            null,
            ['id' => self::TRANSACTION]
        );

        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            null,
            ['commitTimestamp' => (new Timestamp(new \DateTime))->formatAsString()]
        );

        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            null,
            $this->yieldRows([
                [
                    'name' => 'loginCount',
                    'type' => Database::TYPE_INT64,
                    'value' => 0
                ]
            ])
        );

        $this->mockSendRequest(SpannerClient::class, 'rollback', null, null, 0);

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $snippet = $this->snippetFromMethod(Database::class, 'runTransaction');
        $snippet->addUse(Transaction::class);
        $snippet->addLocal('database', $this->database);
        $snippet->addLocal('username', 'foo');
        $snippet->addLocal('password', 'bar');

        $snippet->invoke();
    }

    public function testRunTransactionRollback()
    {
        $this->mockSendRequest(SpannerClient::class, 'beginTransaction', null, null, 0);

        $this->mockSendRequest(SpannerClient::class, 'commit', null, null, 0);

        $this->mockSendRequest(SpannerClient::class, 'rollback', null, null, 1);

        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function ($args) {
                $this->assertEquals(
                    $this->serializer->encodeMessage($args)['transaction']['begin']['readWrite'],
                    ['readLockMode' => 0]
                );
                return true;
            },
            $this->resultGeneratorData([
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
            ])
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $snippet = $this->snippetFromMethod(Database::class, 'runTransaction');
        $snippet->addUse(Transaction::class);
        $snippet->addLocal('database', $this->database);
        $snippet->addLocal('username', 'foo');
        $snippet->addLocal('password', 'bar');

        $snippet->invoke();
    }

    public function testTransaction()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            null,
            ['id' => self::TRANSACTION]
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $snippet = $this->snippetFromMethod(Database::class, 'transaction');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke('transaction');
        $this->assertInstanceOf(Transaction::class, $res->returnVal());
    }

    public function testInsert()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return isset($message['mutations'][0]['insert']);
            },
            [
                'commitTimestamp' => (new Timestamp(new \DateTime))->formatAsString()
            ]
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $snippet = $this->snippetFromMethod(Database::class, 'insert');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }


    public function testInsertBatch()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return isset($message['mutations'][0]['insert'])
                    && isset($message['mutations'][1]['insert']);
            },
            [
                'commitTimestamp' => (new Timestamp(new \DateTime))->formatAsString()
            ]
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $snippet = $this->snippetFromMethod(Database::class, 'insertBatch');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }

    public function testUpdate()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return isset($message['mutations'][0]['update']);
            },
            [
                'commitTimestamp' => (new Timestamp(new \DateTime))->formatAsString()
            ]
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $snippet = $this->snippetFromMethod(Database::class, 'update');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }


    public function testUpdateBatch()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return isset($message['mutations'][0]['update'])
                    && isset($message['mutations'][1]['update']);
            },
            [
                'commitTimestamp' => (new Timestamp(new \DateTime))->formatAsString()
            ]
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $snippet = $this->snippetFromMethod(Database::class, 'updateBatch');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }

    public function testInsertOrUpdate()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return isset($message['mutations'][0]['insertOrUpdate']);
            },
            [
                'commitTimestamp' => (new Timestamp(new \DateTime))->formatAsString()
            ]
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $snippet = $this->snippetFromMethod(Database::class, 'insertOrUpdate');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }


    public function testInsertOrUpdateBatch()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return isset($message['mutations'][0]['insertOrUpdate'])
                    && isset($message['mutations'][1]['insertOrUpdate']);
            },
            [
                'commitTimestamp' => (new Timestamp(new \DateTime))->formatAsString()
            ]
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $snippet = $this->snippetFromMethod(Database::class, 'insertOrUpdateBatch');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }

    public function testReplace()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return isset($message['mutations'][0]['replace']);
            },
            [
                'commitTimestamp' => (new Timestamp(new \DateTime))->formatAsString()
            ]
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $snippet = $this->snippetFromMethod(Database::class, 'replace');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }


    public function testReplaceBatch()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return isset($message['mutations'][0]['replace'])
                    && isset($message['mutations'][1]['replace']);
            },
            [
                'commitTimestamp' => (new Timestamp(new \DateTime))->formatAsString()
            ]
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $snippet = $this->snippetFromMethod(Database::class, 'replaceBatch');
        $snippet->addLocal('database', $this->database);
        $res = $snippet->invoke();
    }

    public function testDelete()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return isset($message['mutations'][0]['delete']);
            },
            [
                'commitTimestamp' => (new Timestamp(new \DateTime))->formatAsString()
            ]
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $snippet = $this->snippetFromMethod(Database::class, 'delete');
        $snippet->addUse(KeySet::class);
        $snippet->addLocal('database', $this->database);
        $snippet->invoke();
    }

    public function testExecute()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            null,
            $this->resultGenerator()
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $snippet = $this->snippetFromMethod(Database::class, 'execute');
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
    }

    public function testExecuteWithParameterType()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return isset($message['params'])
                    && isset($message['paramTypes'])
                    && $message['paramTypes']['timestamp']['code'] === Database::TYPE_TIMESTAMP;
            },
            $this->resultGeneratorData([
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
            ])
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $snippet = $this->snippetFromMethod(Database::class, 'execute', 1);
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('timestamp');
        $this->assertNull($res->returnVal());
    }

    public function testExecuteWithEmptyArray()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return isset($message['params'])
                    && isset($message['paramTypes'])
                    && $message['paramTypes']['emptyArrayOfIntegers']['code'] === Database::TYPE_ARRAY
                    && $message['paramTypes']['emptyArrayOfIntegers']['arrayElementType']['code']
                        === Database::TYPE_INT64;
            },
            $this->resultGeneratorData([
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
            ])
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $snippet = $this->snippetFromMethod(Database::class, 'execute', 2);
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('emptyArray');
        $this->assertEmpty($res->returnVal());
    }

    public function testExecuteBeginSnapshot()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            null,
            $this->resultGenerator(false, self::TRANSACTION)
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $snippet = $this->snippetFromMethod(Database::class, 'execute', 5);
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
        $this->assertInstanceOf(Snapshot::class, $res->returnVal()->snapshot());
    }

    public function testExecuteBeginTransaction()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            null,
            $this->resultGenerator(false, self::TRANSACTION)
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $snippet = $this->snippetFromMethod(Database::class, 'execute', 6);
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
        $this->assertInstanceOf(Transaction::class, $res->returnVal()->transaction());
    }

    public function testExecutePartitionedUpdate()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            null,
            ['id' => self::TRANSACTION]
        );

        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            null,
            $this->resultGenerator(true)
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $snippet = $this->snippetFromMethod(Database::class, 'executePartitionedUpdate');
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('deactivatedUserCount');
        $this->assertEquals(1, $res->returnVal());
    }

    public function testRead()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'streamingRead',
            null,
            $this->resultGenerator()
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $snippet = $this->snippetFromMethod(Database::class, 'read');
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
    }

    public function testReadWithSnapshot()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'streamingRead',
            null,
            $this->resultGenerator(false, self::TRANSACTION)
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

        $snippet = $this->snippetFromMethod(Database::class, 'read', 1);
        $snippet->addLocal('database', $this->database);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
        $this->assertInstanceOf(Snapshot::class, $res->returnVal()->snapshot());
    }

    public function testReadWithTransaction()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'streamingRead',
            null,
            $this->resultGenerator(false, self::TRANSACTION)
        );

        $this->refreshOperation($this->database, $this->requestHandler->reveal(), $this->serializer);

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
        $this->assertInstanceOf(IamManager::class, $res->returnVal());
    }

    public function testResumeOperation()
    {
        $snippet = $this->snippetFromMagicMethod(Database::class, 'resumeOperation');
        $snippet->addLocal('database', $this->database);
        $snippet->addLocal('operationName', 'foo');

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(OperationResponse::class, $res->returnVal());
        $this->assertEquals('foo', $res->returnVal()->name());
    }

    public function testLongRunningOperations()
    {
        $snippet = $this->snippetFromMethod(Database::class, 'longRunningOperations');
        $snippet->addLocal('database', $this->database);

        $this->requestHandler
            ->getClientObject(Argument::any())
            ->willReturn(new DatabaseAdminClient());
        $this->requestHandler
            ->sendRequest(
                Argument::any(),
                'listOperations',
                Argument::cetera()
            )
            ->willReturn([$this->getOperationResponseMock()]);

        $this->database->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->database->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke('operations');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertContainsOnlyInstancesOf(OperationResponse::class, $res->returnVal());
    }
}
