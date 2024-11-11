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

use Google\ApiCore\Serializer;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\PagedListResponse;
use Google\ApiCore\Page;
use Google\LongRunning\Operation;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iam\IamManager;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\LongRunning\Client\OperationsClient;
use Google\Cloud\Spanner\Admin\Database\V1\Backup as BackupProto;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Database\V1\Database as DatabaseProto;
use Google\Cloud\Spanner\Admin\Database\V1\ListBackupsResponse;
use Google\Cloud\Spanner\Admin\Database\V1\ListBackupOperationsResponse;
use Google\Cloud\Spanner\Admin\Database\V1\ListDatabasesResponse;
use Google\Cloud\Spanner\Admin\Database\V1\ListDatabaseOperationsResponse;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\Instance as InstanceProto;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\DirectedReadOptions\ReplicaSelection\Type;
use Google\Cloud\Spanner\V1\Session;
use Google\Cloud\Spanner\V1\CreateSessionRequest;
use Google\Cloud\Spanner\V1\DeleteSessionRequest;
use Google\Cloud\Spanner\V1\ExecuteSqlRequest;
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

    const PROJECT_ID = 'test-project';
    const NAME = 'instance-name';
    const DATABASE = 'database-name';
    const BACKUP = 'my-backup';
    const SESSION = 'projects/test-project/instances/instance-name/databases/database-name/sessions/session';

    private $directedReadOptionsIncludeReplicas;
    private $instance;
    private $serializer;
    private $spannerClient;
    private $instanceAdminClient;
    private $databaseAdminClient;
    private $operationResponse;
    private $page;
    private $pagedListResponse;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->serializer = new Serializer();
        $this->directedReadOptionsIncludeReplicas = [
            'includeReplicas' => [
                'replicaSelections' => [[
                    'location' => 'us-central1',
                    'type' => Type::READ_WRITE,
                ]], 'autoFailoverDisabled' => false
            ]
        ];
        $this->spannerClient = $this->prophesize(SpannerClient::class);
        $this->instanceAdminClient = $this->prophesize(InstanceAdminClient::class);
        $this->databaseAdminClient = $this->prophesize(DatabaseAdminClient::class);
        $this->operationResponse = $this->prophesize(OperationResponse::class);
        $this->operationResponse->withResultFunction(Argument::type('callable'))
            ->willReturn($this->operationResponse->reveal());

        $this->page = $this->prophesize(Page::class);
        $this->pagedListResponse = $this->prophesize(PagedListResponse::class);
        $this->pagedListResponse->getPage()->willReturn($this->page->reveal());

        $this->instance = new Instance(
            $this->spannerClient->reveal(),
            $this->instanceAdminClient->reveal(),
            $this->databaseAdminClient->reveal(),
            $this->serializer,
            self::PROJECT_ID,
            self::NAME,
            false,
            [],
            ['directedReadOptions' => $this->directedReadOptionsIncludeReplicas]
        );
    }

    public function testName()
    {
        $this->assertEquals(self::NAME, InstanceAdminClient::parseName($this->instance->name())['instance']);
    }

    public function testInfo()
    {
        $this->instanceAdminClient->getInstance(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                return $message['name'] == $this->instance->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->getDefaultInstance());

        $info = $this->instance->info();
        $this->assertEquals('Instance Name', $info['displayName']);

        // test calling info again does not reload
        $this->assertEquals($info, $this->instance->info());
    }

    public function testInfoWithReloadAndFieldMask()
    {
        $requestedFieldNames = ["name", 'node_count'];
        $this->instanceAdminClient->getInstance(
            Argument::that(function ($request) use ($requestedFieldNames) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(['paths' => $requestedFieldNames], $message['fieldMask']);
                return $message['name'] == $this->instance->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new InstanceProto([
                'name' => $this->instance->name(),
                'node_count' => 1
            ]));

        $info = $this->instance->info(['fieldMask' => $requestedFieldNames]);

        $this->assertEquals($info, $this->instance->info());
    }

    public function testExists()
    {
        $this->instanceAdminClient->getInstance(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals($message['name'], $this->instance->name());
                return isset($message['fieldMask']) && ['paths' => ['name']] == $message['fieldMask'];
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new InstanceProto());

        $this->instanceAdminClient->getInstance(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals($message['name'], $this->instance->name());
                return !isset($message['fieldMask']);
            }),
            Argument::type('array')
        )
            ->shouldBeCalledTimes(2)
            ->willReturn(new InstanceProto([
                'name' => $this->instance->name(),
                'node_count' => 1,
            ]));

        $this->assertTrue($this->instance->exists());

        $info = $this->instance->reload();
        $this->assertTrue($this->instance->exists());
        $this->assertEquals($info, $this->instance->info());
    }

    public function testExistsNotFound()
    {
        $this->instanceAdminClient->getInstance(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals($message['name'], $this->instance->name());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willThrow(new NotFoundException('foo', 404));

        $this->assertFalse($this->instance->exists());
    }

    public function testReload()
    {
        $this->instanceAdminClient->getInstance(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals($message['name'], $this->instance->name());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->getDefaultInstance());

        $info = $this->instance->reload();

        $this->assertEquals('Instance Name', $info['displayName']);
    }

    public function testReloadWithFieldMask()
    {
        $requestedFieldNames = ["name", 'node_count'];
        $this->instanceAdminClient->getInstance(
            Argument::that(function ($request) use ($requestedFieldNames) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals($message['name'], $this->instance->name());
                return $message['fieldMask'] == ['paths' => $requestedFieldNames];
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new InstanceProto([
                'name' => $this->instance->name(),
                'node_count' => 1
            ]));

        $info = $this->instance->reload(['fieldMask' => $requestedFieldNames]);

        $this->assertEquals($info, $this->instance->info());
    }

    public function testState()
    {
        $this->instanceAdminClient->getInstance(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals($message['name'], $this->instance->name());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->getDefaultInstance());

        $this->assertEquals(Instance::STATE_READY, $this->instance->state());
    }

    public function testStateIsNull()
    {
        $this->instanceAdminClient->getInstance(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals($message['name'], $this->instance->name());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new InstanceProto());

        $this->assertNull($this->instance->state());
    }

    public function testUpdate()
    {
        $this->instanceAdminClient->updateInstance(
            Argument::that(function ($request) {
                $this->assertEquals('bar', $request->getInstance()->getDisplayName());
                $this->assertEquals($this->instance->name(), $request->getInstance()->getName());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        $this->instance->update(['displayName' => 'bar']);
    }

    public function testUpdateWithProcessingUnits()
    {
        $this->instanceAdminClient->updateInstance(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(500, $request->getInstance()->getProcessingUnits());
                $this->assertEquals($this->instance->name(), $request->getInstance()->getName());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        $this->instance->update(['processingUnits' => 500]);
    }

    public function testUpdateRaisesInvalidArgument()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->instance->update(['processingUnits' => 5000, 'nodeCount' => 5]);
    }

    public function testUpdateWithExistingLabels()
    {
        $this->instanceAdminClient->updateInstance(
            Argument::that(function ($request) {
                $this->assertEquals(['foo' => 'bar'], iterator_to_array($request->getInstance()->getLabels()));
                $this->assertEquals($this->instance->name(), $request->getInstance()->getName());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        $this->instance->update(['labels' => ['foo' => 'bar']]);
    }

    public function testUpdateWithChanges()
    {
        $this->instanceAdminClient->updateInstance(
            Argument::that(function ($request) {
                $this->assertEquals('New Name', $request->getInstance()->getDisplayName());
                $this->assertEquals(['foo' => 'bar'], iterator_to_array($request->getInstance()->getLabels()));
                $this->assertEquals(900, $request->getInstance()->getNodeCount());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        $this->instance->update([
            'labels' => [
                'foo' => 'bar'
            ],
            'nodeCount' => 900,
            'displayName' => 'New Name',
        ]);
    }

    public function testDelete()
    {
        $this->instanceAdminClient->deleteInstance(
            Argument::that(function ($request) {
                $this->assertEquals(
                    $request->getName(),
                    InstanceAdminClient::instanceName(self::PROJECT_ID, self::NAME)
                );
                return true;
            }),
            Argument::type('array')
        )->shouldBeCalledOnce();

        $this->instance->delete();
    }

    public function testCreateDatabase()
    {
        $extra = ['foo', 'bar'];

        $this->databaseAdminClient->createDatabase(
            Argument::that(function ($request) use ($extra) {
                $createStatement = 'CREATE DATABASE `test-database`';
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals($message['createStatement'], $createStatement);
                $this->assertEquals(
                    $message['parent'],
                    InstanceAdminClient::instanceName(self::PROJECT_ID, self::NAME)
                );
                $this->assertEquals($message['extraStatements'], $extra);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        $database = $this->instance->createDatabase('test-database', [
            'statements' => $extra
        ]);

        $this->assertInstanceOf(OperationResponse::class, $database);
    }

    public function testCreateDatabaseFromBackupName()
    {
        $backupName = DatabaseAdminClient::backupName(self::PROJECT_ID, self::NAME, self::BACKUP);

        $this->databaseAdminClient->restoreDatabase(
            Argument::that(function ($request) use ($backupName) {
                $this->assertEquals($request->getDatabaseId(), 'restore-database');
                $this->assertEquals($request->getParent(), $this->instance->name());
                $this->assertEquals($request->getBackup(), $backupName);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        $op = $this->instance->createDatabaseFromBackup('restore-database', $backupName);
        $this->assertInstanceOf(OperationResponse::class, $op);
    }

    public function testCreateDatabaseFromBackupObject()
    {
        $backupObject = $this->instance->backup(self::BACKUP);

        $this->databaseAdminClient->restoreDatabase(
            Argument::that(function ($request) use ($backupObject) {
                $this->assertEquals($request->getDatabaseId(), 'restore-database');
                $this->assertEquals($request->getParent(), $this->instance->name());
                $this->assertEquals($request->getBackup(), $backupObject->name());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

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
            new DatabaseProto(['name' => DatabaseAdminClient::databaseName(self::PROJECT_ID, self::NAME, 'database1')]),
            new DatabaseProto(['name' => DatabaseAdminClient::databaseName(self::PROJECT_ID, self::NAME, 'database2')])
        ];

        $this->page->getResponseObject()->willReturn(new ListDatabasesResponse(['databases' => $databases]));

        $this->databaseAdminClient->listDatabases(
            Argument::that(function ($request) {
                $this->assertEquals($request->getParent(), $this->instance->name());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->pagedListResponse->reveal());

        $this->databaseAdminClient->getDatabase(Argument::cetera())->shouldNotBeCalled();

        $dbs = $this->instance->databases();

        $this->assertInstanceOf(ItemIterator::class, $dbs);

        $dbs = iterator_to_array($dbs);

        $this->assertCount(2, $dbs);
        $this->assertEquals('database1', DatabaseAdminClient::parseName($dbs[0]->name())['database']);
        $this->assertEquals('database2', DatabaseAdminClient::parseName($dbs[1]->name())['database']);

        // Make sure the database->info is prefilled.
        $this->assertEquals($databases[0]->__debugInfo(), $dbs[0]->info());
        $this->assertEquals($databases[1]->__debugInfo(), $dbs[1]->info());
    }

    public function testDatabasesPaged()
    {
        $databases = [
            new DatabaseProto(['name' => DatabaseAdminClient::databaseName(self::PROJECT_ID, self::NAME, 'database1')]),
            new DatabaseProto(['name' => DatabaseAdminClient::databaseName(self::PROJECT_ID, self::NAME, 'database2')]),
        ];

        $page1 = $this->prophesize(Page::class);
        $page1->getResponseObject()
            ->willReturn(new ListDatabasesResponse([
                'databases' => [$databases[0]], 'next_page_token' => 'foo']
            ));
        $pagedListResponse1 = $this->prophesize(PagedListResponse::class);
        $pagedListResponse1->getPage()
            ->willReturn($page1->reveal());

        $iteration = 0;
        $this->databaseAdminClient->listDatabases(
            Argument::that(function ($request) use (&$iteration) {
                $this->assertEquals($request->getParent(), $this->instance->name());
                $iteration++;
                return $iteration == 1;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($pagedListResponse1->reveal());

        $page2 = $this->prophesize(Page::class);
        $page2->getResponseObject()
            ->willReturn(new ListDatabasesResponse(['databases' => [$databases[1]]]));
        $pagedListResponse2 = $this->prophesize(PagedListResponse::class);
        $pagedListResponse2->getPage()
            ->willReturn($page2->reveal());

        $this->databaseAdminClient->listDatabases(
            Argument::that(function ($request) use (&$iteration) {
                $this->assertEquals($request->getParent(), $this->instance->name());
                if ($iteration == 2) {
                    $this->assertEquals($request->getPageToken(), 'foo');
                    return true;
                }
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($pagedListResponse2->reveal());

        $this->databaseAdminClient->getDatabase(Argument::cetera())->shouldNotBeCalled();

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
            new BackupProto(['name' => DatabaseAdminClient::backupName(self::PROJECT_ID, self::NAME, 'backup1')]),
            new BackupProto(['name' => DatabaseAdminClient::backupName(self::PROJECT_ID, self::NAME, 'backup2')]),
        ];

        $this->page->getResponseObject()->willReturn(new ListBackupsResponse(['backups' => $backups]));

        $this->databaseAdminClient->listBackups(
            Argument::that(function ($request) {
                $this->assertEquals($request->getParent(), $this->instance->name());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->pagedListResponse->reveal());

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
            new Operation(['name' => 'operation1']),
            new Operation(['name' => 'operation2']),
        ];

        $this->page->getResponseObject()->willReturn(new ListBackupOperationsResponse(['operations' => $operations]));

        $this->databaseAdminClient->listBackupOperations(
            Argument::that(function ($request) {
                $this->assertEquals($request->getParent(), $this->instance->name());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->pagedListResponse->reveal());

        $this->databaseAdminClient->getOperationsClient()
            ->shouldBeCalledTimes(2)
            ->willReturn($this->prophesize(OperationsClient::class)->reveal());

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
            new Operation(['name' => 'operation1']),
            new Operation(['name' => 'operation2']),
        ];

        $this->page->getResponseObject()->willReturn(new ListDatabaseOperationsResponse(['operations' => $operations]));

        $this->databaseAdminClient->listDatabaseOperations(
            Argument::that(function ($request) {
                $this->assertEquals($request->getParent(), $this->instance->name());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->pagedListResponse->reveal());

        $this->databaseAdminClient->getOperationsClient()
            ->shouldBeCalledTimes(2)
            ->willReturn($this->prophesize(OperationsClient::class)->reveal());

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

        $this->spannerClient->createSession(
            Argument::that(function ($request) {
                return $this->serializer->encodeMessage($request)['session']['creatorRole']
                    == 'Reader';
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new Session(['name' => self::SESSION]));

        $this->spannerClient->executeStreamingSql(
            Argument::that(function (ExecuteSqlRequest $request) use ($sql) {
                return $request->getSql() == $sql;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream());

        $this->spannerClient->deleteSession(
            Argument::type(DeleteSessionRequest::class),
            Argument::type('array')
        )->shouldBeCalledOnce();

        $database->execute($sql);
    }

    public function testInstanceExecuteWithDirectedRead()
    {
        $database = $this->instance->database(
            $this::DATABASE
        );
        $this->spannerClient->createSession(
            Argument::type(CreateSessionRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new Session(['name' => self::SESSION]));

        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['directedReadOptions'],
                    $this->directedReadOptionsIncludeReplicas
                );
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
        $database = $this->instance->database($this::DATABASE);

        $this->spannerClient->createSession(
            Argument::type(CreateSessionRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new Session(['name' => self::SESSION]));

        $this->spannerClient->streamingRead(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['directedReadOptions'],
                    $this->directedReadOptionsIncludeReplicas
                );
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
        return new InstanceProto([
            'name' => 'projects/test-project/instances/instance-name',
            'config' => 'projects/test-project/instanceConfigs/regional-europe-west1',
            'display_name' => 'Instance Name',
            'node_count' => 1,
            'state' => 2
        ]);
    }
}
