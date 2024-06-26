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
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iam\IamManager;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\LongRunning\Client\OperationsClient;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\Tests\RequestHandlingTestTrait;
use Google\Cloud\Spanner\V1\Client\SpannerClient as GapicSpannerClient;
use Google\Cloud\Spanner\V1\DirectedReadOptions\ReplicaSelection\Type;
use Google\Cloud\Spanner\Backup;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Tests\ResultGeneratorTrait;

/**
 * @group spanner
 * @group spanner-admin
 */
class InstanceTest extends TestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;
    use ResultGeneratorTrait;
    use RequestHandlingTestTrait;
    use ResultGeneratorTrait;

    const PROJECT_ID = 'test-project';
    const NAME = 'instance-name';
    const DATABASE = 'database-name';
    const BACKUP = 'my-backup';
    const SESSION = 'projects/test-project/instances/instance-name/databases/database-name/sessions/session';

    private $directedReadOptionsIncludeReplicas;
    private $instance;
    private $requestHandler;
    private $serializer;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->requestHandler = $this->getRequestHandlerStub();
        $this->serializer = $this->getSerializer();
        $this->directedReadOptionsIncludeReplicas = [
            'includeReplicas' => [
                'replicaSelections' => [[
                    'location' => 'us-central1',
                    'type' => Type::READ_WRITE,
                ]], 'autoFailoverDisabled' => false
            ]
        ];
        $this->instance = TestHelpers::stub(Instance::class, [
            $this->requestHandler->reveal(),
            $this->serializer,
            self::PROJECT_ID,
            self::NAME,
            false,
            [],
            ['directedReadOptions' => $this->directedReadOptionsIncludeReplicas]
        ], [
            'info',
            'requestHandler',
            'serializer'
        ]);
    }

    public function testName()
    {
        $this->assertEquals(self::NAME, InstanceAdminClient::parseName($this->instance->name())['instance']);
    }

    public function testInfo()
    {
        $this->mockSendRequest(GapicSpannerClient::class, 'getInstance', null, null, 0);

        $this->instance->___setProperty('info', ['foo' => 'bar']);
        $this->assertEquals('bar', $this->instance->info()['foo']);
    }

    public function testInfoWithReload()
    {
        $instance = $this->getDefaultInstance();

        $this->mockSendRequest(
            InstanceAdminClient::class,
            'getInstance',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return $message['name'] == $this->instance->name();
            },
            $instance
        );

        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->instance->___setProperty('serializer', $this->serializer);

        $info = $this->instance->info();
        $this->assertEquals('Instance Name', $info['displayName']);

        $this->assertEquals($info, $this->instance->info());
    }

    public function testInfoWithReloadAndFieldMask()
    {
        $instance = [
            'name' => $this->instance->name(),
            'node_count' => 1
        ];
        $requestedFieldNames = ["name", 'node_count'];

        $this->mockSendRequest(
            InstanceAdminClient::class,
            'getInstance',
            function ($args) use ($requestedFieldNames) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(['paths' => $requestedFieldNames], $message['fieldMask']);
                return $message['name'] == $this->instance->name();
            },
            $instance
        );

        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->instance->___setProperty('serializer', $this->serializer);

        $info = $this->instance->info(['fieldMask' => $requestedFieldNames]);

        $this->assertEquals($info, $this->instance->info());
    }

    public function testExists()
    {
        $this->mockSendRequest(
            InstanceAdminClient::class,
            'getInstance',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['name'], $this->instance->name());
                return isset($message['fieldMask']) && ['paths' => ['name']] == $message['fieldMask'];
            },
            []
        );
        $this->mockSendRequest(
            InstanceAdminClient::class,
            'getInstance',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['name'], $this->instance->name());
                return !isset($message['fieldMask']);
            },
            [
                'name' => $this->instance->name(),
                'nodeCount' => 1,
            ],
            2
        );

        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->instance->___setProperty('serializer', $this->serializer);

        $this->assertTrue($this->instance->exists());

        $info = $this->instance->reload();
        $this->assertTrue($this->instance->exists());
        $this->assertEquals($info, $this->instance->info());
    }

    public function testExistsNotFound()
    {
        $this->mockSendRequest(
            InstanceAdminClient::class,
            'getInstance',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['name'], $this->instance->name());
                return true;
            },
            new NotFoundException('foo', 404)
        );

        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->instance->___setProperty('serializer', $this->serializer);

        $this->assertFalse($this->instance->exists());
    }

    public function testReload()
    {
        $instance = $this->getDefaultInstance();

        $this->mockSendRequest(
            InstanceAdminClient::class,
            'getInstance',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['name'], $this->instance->name());
                return true;
            },
            $instance
        );

        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->instance->___setProperty('serializer', $this->serializer);

        $info = $this->instance->reload();

        $this->assertEquals('Instance Name', $info['displayName']);
    }

    public function testReloadWithFieldMask()
    {
        $instance = [
            'name' => $this->instance->name(),
            'node_count' => 1
        ];
        $requestedFieldNames = ["name", 'node_count'];

        $this->mockSendRequest(
            InstanceAdminClient::class,
            'getInstance',
            function ($args) use ($requestedFieldNames) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['name'], $this->instance->name());
                return $message['fieldMask'] == ['paths' => $requestedFieldNames];
            },
            $instance
        );

        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->instance->___setProperty('serializer', $this->serializer);

        $info = $this->instance->reload(['fieldMask' => $requestedFieldNames]);

        $this->assertEquals($info, $this->instance->info());
    }

    public function testState()
    {
        $instance = $this->getDefaultInstance();

        $this->mockSendRequest(
            InstanceAdminClient::class,
            'getInstance',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['name'], $this->instance->name());
                return true;
            },
            $instance
        );

        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->instance->___setProperty('serializer', $this->serializer);

        $this->assertEquals(Instance::STATE_READY, $this->instance->state());
    }

    public function testStateIsNull()
    {
        $this->mockSendRequest(
            InstanceAdminClient::class,
            'getInstance',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['name'], $this->instance->name());
                return true;
            },
            []
        );

        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->instance->___setProperty('serializer', $this->serializer);

        $this->assertNull($this->instance->state());
    }

    public function testUpdate()
    {
        $instance = $this->getDefaultInstance();

        $this->mockSendRequest(
            InstanceAdminClient::class,
            'updateInstance',
            function ($args) use ($instance) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['instance']['displayName'], 'bar');
                $this->assertEquals($message['instance']['name'], $instance['name']);
                return true;
            },
            $this->getOperationResponseMock()
        );

        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->instance->___setProperty('serializer', $this->serializer);

        $this->instance->update(['displayName' => 'bar']);
    }

    public function testUpdateWithProcessingUnits()
    {
        $instance = $this->getDefaultInstance();

        $this->mockSendRequest(
            InstanceAdminClient::class,
            'updateInstance',
            function ($args) use ($instance) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['instance']['processingUnits'], 500);
                $this->assertEquals($message['instance']['name'], $instance['name']);
                return true;
            },
            $this->getOperationResponseMock()
        );

        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->instance->___setProperty('serializer', $this->serializer);

        $this->instance->update(['processingUnits' => 500]);
    }

    public function testUpdateRaisesInvalidArgument()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->instance->update(['processingUnits' => 5000, 'nodeCount' => 5]);
    }

    public function testUpdateWithExistingLabels()
    {
        $instance = $this->getDefaultInstance();
        $instance['labels'] = ['foo' => 'bar'];

        $this->mockSendRequest(
            InstanceAdminClient::class,
            'updateInstance',
            function ($args) use ($instance) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['instance']['labels'], $instance['labels']);
                $this->assertEquals($message['instance']['name'], $instance['name']);
                return true;
            },
            $this->getOperationResponseMock()
        );

        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->instance->___setProperty('serializer', $this->serializer);

        $this->instance->update(['labels' => $instance['labels']]);
    }

    public function testUpdateWithChanges()
    {
        $instance = $this->getDefaultInstance();

        $changes = [
            'labels' => [
                'foo' => 'bar'
            ],
            'nodeCount' => 900,
            'displayName' => 'New Name',
        ];
        $this->mockSendRequest(
            InstanceAdminClient::class,
            'updateInstance',
            function ($args) use ($changes) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['instance']['displayName'], $changes['displayName']);
                $this->assertEquals($message['instance']['labels'], $changes['labels']);
                $this->assertEquals($message['instance']['nodeCount'], $changes['nodeCount']);
                return true;
            },
            $this->getOperationResponseMock()
        );

        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->instance->___setProperty('serializer', $this->serializer);

        $this->instance->update($changes);
    }

    public function testDelete()
    {
        $this->mockSendRequest(
            InstanceAdminClient::class,
            'deleteInstance',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['name'],
                    InstanceAdminClient::instanceName(self::PROJECT_ID, self::NAME)
                );
                return true;
            },
            null
        );

        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->instance->___setProperty('serializer', $this->serializer);

        $this->instance->delete();
    }

    public function testCreateDatabase()
    {
        $extra = ['foo', 'bar'];

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'createDatabase',
            function ($args) use ($extra) {
                $createStatement = 'CREATE DATABASE `test-database`';
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['createStatement'], $createStatement);
                $this->assertEquals(
                    $message['parent'],
                    InstanceAdminClient::instanceName(self::PROJECT_ID, self::NAME)
                );
                $this->assertEquals($message['extraStatements'], $extra);
                return true;
            },
            $this->getOperationResponseMock()
        );
        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->instance->___setProperty('serializer', $this->serializer);

        $database = $this->instance->createDatabase('test-database', [
            'statements' => $extra
        ]);

        $this->assertInstanceOf(OperationResponse::class, $database);
    }

    public function testCreateDatabaseFromBackupName()
    {
        $backupName = DatabaseAdminClient::backupName(self::PROJECT_ID, self::NAME, self::BACKUP);

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'restoreDatabase',
            function ($args) use ($backupName) {
                $this->assertEquals($args->getDatabaseId(), 'restore-database');
                $this->assertEquals($args->getParent(), $this->instance->name());
                $this->assertEquals($args->getBackup(), $backupName);
                return true;
            },
            $this->getOperationResponseMock()
        );
        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->instance->___setProperty('serializer', $this->serializer);

        $op = $this->instance->createDatabaseFromBackup('restore-database', $backupName);
        $this->assertInstanceOf(OperationResponse::class, $op);
    }

    public function testCreateDatabaseFromBackupObject()
    {
        $backupObject = $this->instance->backup(self::BACKUP);

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'restoreDatabase',
            function ($args) use ($backupObject) {
                $this->assertEquals($args->getDatabaseId(), 'restore-database');
                $this->assertEquals($args->getParent(), $this->instance->name());
                $this->assertEquals($args->getBackup(), $backupObject->name());
                return true;
            },
            $this->getOperationResponseMock()
        );
        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->instance->___setProperty('serializer', $this->serializer);

        $op = $this->instance->createDatabaseFromBackup('restore-database', $backupObject);
        $this->assertInstanceOf(OperationResponse::class, $op);
    }

    public function testDatabase()
    {
        $database = $this->instance->database('test-database');
        $this->assertInstanceOf(Database::class, $database);
        $this->assertEquals('test-database', DatabaseAdminClient::parseName($database->name())['database']);
    }

    public function testDatabases()
    {
        $databases = [
            ['name' => DatabaseAdminClient::databaseName(self::PROJECT_ID, self::NAME, 'database1')],
            ['name' => DatabaseAdminClient::databaseName(self::PROJECT_ID, self::NAME, 'database2')]
        ];

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'listDatabases',
            function ($args) {
                $this->assertEquals($args->getParent(), $this->instance->name());
                return true;
            },
            ['databases' => $databases]
        );
        $this->mockSendRequest(DatabaseAdminClient::class, 'getDatabase', null, null, 0);

        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->instance->___setProperty('serializer', $this->serializer);

        $dbs = $this->instance->databases();

        $this->assertInstanceOf(ItemIterator::class, $dbs);

        $dbs = iterator_to_array($dbs);

        $this->assertCount(2, $dbs);
        $this->assertEquals('database1', DatabaseAdminClient::parseName($dbs[0]->name())['database']);
        $this->assertEquals('database2', DatabaseAdminClient::parseName($dbs[1]->name())['database']);

        // Make sure the database->info is prefilled.
        $this->assertEquals($databases[0], $dbs[0]->info());
        $this->assertEquals($databases[1], $dbs[1]->info());
    }

    public function testDatabasesPaged()
    {
        $databases = [
            ['name' => DatabaseAdminClient::databaseName(self::PROJECT_ID, self::NAME, 'database1')],
            ['name' => DatabaseAdminClient::databaseName(self::PROJECT_ID, self::NAME, 'database2')]
        ];

        // ['databases' => [$databases[1]]]);
        $iteration = 0;
        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'listDatabases',
            function ($args) use (&$iteration) {
                $this->assertEquals($args->getParent(), $this->instance->name());
                $iteration++;
                return $iteration == 1;
            },
            ['databases' => [$databases[0]], 'nextPageToken' => 'foo']
        );
        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'listDatabases',
            function ($args) use (&$iteration) {
                $this->assertEquals($args->getParent(), $this->instance->name());
                return $iteration == 2;
            },
            ['databases' => [$databases[1]]]
        );
        $this->mockSendRequest(DatabaseAdminClient::class, 'getDatabase', null, null, 0);

        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->instance->___setProperty('serializer', $this->serializer);

        $dbs = $this->instance->databases();

        $this->assertInstanceOf(ItemIterator::class, $dbs);

        $dbs = iterator_to_array($dbs);

        $this->assertCount(2, $dbs);
        $this->assertEquals('database1', DatabaseAdminClient::parseName($dbs[0]->name())['database']);
        $this->assertEquals('database2', DatabaseAdminClient::parseName($dbs[1]->name())['database']);
    }

    public function testIam()
    {
        $this->assertInstanceOf(IamManager::class, $this->instance->iam());
    }

    public function testBackup()
    {
        $this->assertInstanceOf(
            Backup::class,
            $this->instance->backup(
                'backup-id'
            )
        );
    }

    public function testBackups()
    {
        $backups = [
            [
                'name' => DatabaseAdminClient::backupName(self::PROJECT_ID, self::NAME, 'backup1'),
            ],
            [
                'name' => DatabaseAdminClient::backupName(self::PROJECT_ID, self::NAME, 'backup2'),
            ]
        ];

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'listBackups',
            function ($args) {
                $this->assertEquals($args->getParent(), $this->instance->name());
                return true;
            },
            ['backups' => $backups]
        );

        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->instance->___setProperty('serializer', $this->serializer);

        $bkps = $this->instance->backups();

        $this->assertInstanceOf(ItemIterator::class, $bkps);

        $bkps = iterator_to_array($bkps);

        $this->assertCount(2, $bkps);
        $this->assertEquals('backup1', DatabaseAdminClient::parseName($bkps[0]->name())['backup']);
        $this->assertEquals('backup2', DatabaseAdminClient::parseName($bkps[1]->name())['backup']);
    }

    public function testBackupOperations()
    {
        $operations = [
            ['name' => 'operation1'],
            ['name' => 'operation2']
        ];

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'listBackupOperations',
            function ($args) {
                $this->assertEquals($args->getParent(), $this->instance->name());
                return true;
            },
            ['operations' => $operations]
        );

        $databaseAdminClient = $this->prophesize(DatabaseAdminClient::class);
        $databaseAdminClient->getOperationsClient()
            ->shouldBeCalledTimes(2)
            ->willReturn($this->prophesize(OperationsClient::class)->reveal());
        $this->requestHandler->getClientObject(DatabaseAdminClient::class)
            ->shouldBeCalledTimes(2)
            ->willReturn($databaseAdminClient->reveal());
        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->instance->___setProperty('serializer', $this->serializer);

        $bkpOps = $this->instance->backupOperations();

        $this->assertInstanceOf(ItemIterator::class, $bkpOps);

        $bkpOps = iterator_to_array($bkpOps);
        $this->assertCount(2, $bkpOps);
        $this->assertEquals('operation1', $bkpOps[0]->getName());
        $this->assertEquals('operation2', $bkpOps[1]->getName());
    }

    public function testListDatabaseOperations()
    {
        $operations = [
            ['name' => 'operation1'],
            ['name' => 'operation2']
        ];

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'listDatabaseOperations',
            function ($args) {
                $this->assertEquals($args->getParent(), $this->instance->name());
                return true;
            },
            ['operations' => $operations]
        );
        $databaseAdminClient = $this->prophesize(DatabaseAdminClient::class);
        $databaseAdminClient->getOperationsClient()
            ->shouldBeCalledTimes(2)
            ->willReturn($this->prophesize(OperationsClient::class)->reveal());
        $this->requestHandler->getClientObject(DatabaseAdminClient::class)
            ->shouldBeCalledTimes(2)
            ->willReturn($databaseAdminClient->reveal());

        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->instance->___setProperty('serializer', $this->serializer);

        $dbOps = $this->instance->databaseOperations();

        $this->assertInstanceOf(ItemIterator::class, $dbOps);

        $dbOps = iterator_to_array($dbOps);
        $this->assertCount(2, $dbOps);
        $this->assertEquals('operation1', $dbOps[0]->getName());
        $this->assertEquals('operation2', $dbOps[1]->getName());
    }

    public function testInstanceDatabaseRole()
    {
        $sql = 'SELECT * FROM Table';
        $database = $this->instance->database($this::DATABASE, ['databaseRole' => 'Reader']);

        $this->mockSendRequest(GapicSpannerClient::class, 'createSession', function ($args) {
            return $this->serializer->encodeMessage($args)['session']['creatorRole']
                == 'Reader';
        }, ['name' => self::SESSION]);
        $this->mockSendRequest(
            GapicSpannerClient::class,
            'executeStreamingSql',
            function ($args) use ($sql) {
                return $args->getSql() == $sql;
            },
            $this->resultGenerator()
        );
        $this->mockSendRequest(GapicSpannerClient::class, 'deleteSession', null, null);
        $database->execute($sql);
    }

    public function testInstanceExecuteWithDirectedRead()
    {
        $database = $this->instance->database(
            $this::DATABASE
        );
        $this->mockSendRequest(GapicSpannerClient::class, 'createSession', null, [
            'name' => self::SESSION
        ]);
        $this->mockSendRequest(
            GapicSpannerClient::class,
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
        $this->mockSendRequest(GapicSpannerClient::class, 'deleteSession', null, null);

        $sql = 'SELECT * FROM Table';
        $res = $database->execute($sql);
        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertCount(1, $rows);
    }

    public function testInstanceReadWithDirectedRead()
    {
        $table = 'foo';
        $keys = [10, 'bar'];
        $columns = ['id', 'name'];
        $database = $this->instance->database(
            $this::DATABASE,
        );
        $this->mockSendRequest(GapicSpannerClient::class, 'createSession', null, [
            'name' => self::SESSION
        ]);
        $this->mockSendRequest(
            GapicSpannerClient::class,
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
        $this->mockSendRequest(GapicSpannerClient::class, 'deleteSession', null, null);

        $res = $database->read(
            $table,
            new KeySet(['keys' => $keys]),
            $columns
        );
        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertCount(1, $rows);
    }

    // ************** //

    private function getDefaultInstance()
    {
        return json_decode(file_get_contents(Fixtures::INSTANCE_FIXTURE()), true);
    }
}
