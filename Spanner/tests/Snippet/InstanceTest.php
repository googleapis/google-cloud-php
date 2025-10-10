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
use Google\Cloud\Spanner\Admin\Database\V1\CreateDatabaseRequest;
use Google\Cloud\Spanner\Admin\Database\V1\Database as DatabaseProto;
use Google\Cloud\Spanner\Admin\Database\V1\ListBackupOperationsRequest;
use Google\Cloud\Spanner\Admin\Database\V1\ListBackupOperationsResponse;
use Google\Cloud\Spanner\Admin\Database\V1\ListBackupsRequest;
use Google\Cloud\Spanner\Admin\Database\V1\ListBackupsResponse;
use Google\Cloud\Spanner\Admin\Database\V1\ListDatabaseOperationsRequest;
use Google\Cloud\Spanner\Admin\Database\V1\ListDatabaseOperationsResponse;
use Google\Cloud\Spanner\Admin\Database\V1\ListDatabasesRequest;
use Google\Cloud\Spanner\Admin\Database\V1\ListDatabasesResponse;
use Google\Cloud\Spanner\Admin\Database\V1\RestoreDatabaseRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\CreateInstanceRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\DeleteInstanceRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\GetInstanceRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\Instance as InstanceProto;
use Google\Cloud\Spanner\Admin\Instance\V1\UpdateInstanceRequest;
use Google\Cloud\Spanner\Backup;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\InstanceConfiguration;
use Google\Cloud\Spanner\Serializer;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\LongRunning\Client\OperationsClient;
use Google\LongRunning\ListOperationsResponse;
use Google\LongRunning\Operation;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner
 * @group spanner-admin
 */
class InstanceTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;

    const PROJECT = 'my-awesome-project';
    const INSTANCE = 'my-instance';
    const DATABASE = 'my-database';
    const BACKUP = 'my-backup';
    const OPERATION = 'my-operation';

    private $spannerClient;
    private $instanceAdminClient;
    private $databaseAdminClient;
    private $serializer;
    private $instance;
    private $operationResponse;
    private $page;
    private $pagedListResponse;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->spannerClient = $this->prophesize(SpannerClient::class);
        $this->instanceAdminClient = $this->prophesize(InstanceAdminClient::class);
        $this->databaseAdminClient = $this->prophesize(DatabaseAdminClient::class);
        $this->operationResponse = $this->prophesize(OperationResponse::class);

        $this->page = $this->prophesize(Page::class);
        $this->page->getNextPageToken()
            ->willReturn(null);
        $this->pagedListResponse = $this->prophesize(PagedListResponse::class);
        $this->pagedListResponse->getPage()
            ->willReturn($this->page->reveal());

        $this->serializer = new Serializer();
        $this->instance = new Instance(
            $this->spannerClient->reveal(),
            $this->instanceAdminClient->reveal(),
            $this->databaseAdminClient->reveal(),
            $this->serializer,
            self::PROJECT,
            self::INSTANCE
        );
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Instance::class);
        $snippet->addLocal('projectId', self::PROJECT);
        $res = $snippet->invoke('instance');
        $this->assertInstanceOf(Instance::class, $res->returnVal());
        $this->assertEquals(
            InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE),
            $res->returnVal()->name()
        );
    }

    /**
     * @group spanneradmin
     */
    public function testCreate()
    {
        $config = $this->prophesize(InstanceConfiguration::class);
        $config->name()->willReturn(InstanceAdminClient::instanceConfigName(self::PROJECT, 'foo'));

        $snippet = $this->snippetFromMethod(Instance::class, 'create');
        $snippet->addLocal('configuration', $config->reveal());
        $snippet->addLocal('instance', $this->instance);

        $this->instanceAdminClient->createInstance(
            Argument::type(CreateInstanceRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'name');
        $snippet->addLocal('instance', $this->instance);

        $res = $snippet->invoke('name');
        $this->assertEquals(InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE), $res->returnVal());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'info');
        $snippet->addLocal('instance', $this->instance);

        $this->instanceAdminClient->getInstance(
            Argument::type(GetInstanceRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new InstanceProto(['node_count' => 1]));

        $res = $snippet->invoke();
        $this->assertEquals('1', $res->output());
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'exists');
        $snippet->addLocal('instance', $this->instance);

        $this->instanceAdminClient->getInstance(
            Argument::type(GetInstanceRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new InstanceProto(['name' => 'foo']));

        $res = $snippet->invoke();
        $this->assertEquals('Instance exists!', $res->output());
    }

    public function testReload()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'reload');
        $snippet->addLocal('instance', $this->instance);

        $this->instanceAdminClient->getInstance(
            Argument::type(GetInstanceRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new InstanceProto(['node_count' => 1]));

        $res = $snippet->invoke('info');
        $info = $this->instance->info();
        $this->assertEquals($info, $res->returnVal());
    }

    public function testState()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'state');
        $snippet->addLocal('instance', $this->instance);
        $snippet->addUse(Instance::class);

        $this->instanceAdminClient->getInstance(
            Argument::type(GetInstanceRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new InstanceProto(['state' => Instance::STATE_READY]));

        $res = $snippet->invoke();
        $this->assertEquals('Instance is ready!', $res->output());
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'update');
        $snippet->addLocal('instance', $this->instance);

        $this->instanceAdminClient->updateInstance(
            Argument::type(UpdateInstanceRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        $snippet->invoke();
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'delete');
        $snippet->addLocal('instance', $this->instance);

        $this->instanceAdminClient->deleteInstance(
            Argument::type(DeleteInstanceRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce();

        $snippet->invoke();
    }

    public function testCreateDatabase()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'createDatabase');
        $snippet->addLocal('instance', $this->instance);

        $this->databaseAdminClient->createDatabase(
            Argument::type(CreateDatabaseRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal());
    }

    public function testCreateDatabaseFromBackup()
    {
        $backup = DatabaseAdminClient::backupName(self::PROJECT, self::INSTANCE, self::BACKUP);
        $snippet = $this->snippetFromMethod(Instance::class, 'createDatabaseFromBackup');
        $snippet->addLocal('instance', $this->instance);
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

    public function testDatabase()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'database');
        $snippet->addLocal('instance', $this->instance);

        $res = $snippet->invoke('database');
        $this->assertInstanceOf(Database::class, $res->returnVal());
        $this->assertEquals(self::DATABASE, DatabaseAdminClient::parseName($res->returnVal()->name())['database']);
    }

    public function testDatabases()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'databases');
        $snippet->addLocal('instance', $this->instance);

        $database = new DatabaseProto([
            'name' => DatabaseAdminClient::databaseName(
                self::PROJECT,
                self::INSTANCE,
                self::DATABASE
            )
        ]);

        $this->page->getResponseObject()
            ->willReturn(new ListDatabasesResponse(['databases' => [$database]]));

        $this->databaseAdminClient->listDatabases(
            Argument::type(ListDatabasesRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->pagedListResponse->reveal());

        $res = $snippet->invoke('databases');

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertInstanceOf(Database::class, $res->returnVal()->current());
    }

    public function testBackup()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'backup');
        $snippet->addLocal('instance', $this->instance);

        $res = $snippet->invoke('backup');
        $this->assertInstanceOf(Backup::class, $res->returnVal());
        $this->assertEquals(self::BACKUP, DatabaseAdminClient::parseName($res->returnVal()->name())['backup']);
    }

    public function testBackups()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'backups');
        $snippet->addLocal('instance', $this->instance);

        $backup = new BackupProto([
            'name' => DatabaseAdminClient::backupName(
                self::PROJECT,
                self::INSTANCE,
                self::BACKUP
            )
        ]);

        $this->page->getResponseObject()
            ->willReturn(new ListBackupsResponse(['backups' => [$backup]]));

        $this->databaseAdminClient->listBackups(
            Argument::type(ListBackupsRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->pagedListResponse->reveal());

        $res = $snippet->invoke('backups');

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertInstanceOf(Backup::class, $res->returnVal()->current());
    }

    public function testBackupOperations()
    {
        $backupOperationName = sprintf(
            '%s/operations/%s',
            DatabaseAdminClient::backupName(self::PROJECT, self::INSTANCE, self::BACKUP),
            self::OPERATION
        );

        $operation = new Operation(['name' => $backupOperationName]);
        $this->page->getResponseObject()
            ->willReturn(new ListBackupOperationsResponse(['operations' => [$operation]]));

        $snippet = $this->snippetFromMethod(Instance::class, 'backupOperations');
        $snippet->addLocal('instance', $this->instance);

        $this->databaseAdminClient->listBackupOperations(
            Argument::type(ListBackupOperationsRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->pagedListResponse->reveal());

        $res = $snippet->invoke('backupOperations');

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal()->current());
    }

    public function testDatabaseOperations()
    {
        $databaseOperationName = sprintf(
            '%s/operations/%s',
            DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE),
            self::OPERATION
        );

        $operation = new Operation(['name' => $databaseOperationName]);
        $this->page->getResponseObject()
            ->willReturn(new ListDatabaseOperationsResponse(['operations' => [$operation]]));

        $snippet = $this->snippetFromMethod(Instance::class, 'databaseOperations');
        $snippet->addLocal('instance', $this->instance);

        $this->databaseAdminClient->listDatabaseOperations(
            Argument::type(ListDatabaseOperationsRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->pagedListResponse->reveal());

        $res = $snippet->invoke('databaseOperations');

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal()->current());
    }

    public function testIam()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'iam');
        $snippet->addLocal('instance', $this->instance);

        $res = $snippet->invoke('iam');
        $this->assertInstanceOf(IamManager::class, $res->returnVal());
    }

    public function testResumeOperation()
    {
        $snippet = $this->snippetFromMagicMethod(Instance::class, 'resumeOperation');
        $snippet->addLocal('instance', $this->instance);
        $snippet->addLocal('operationName', 'foo');

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal());
        $this->assertEquals('foo', $res->returnVal()->name());
    }

    public function testLongRunningOperations()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'longRunningOperations');
        $snippet->addLocal('instance', $this->instance);

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

        $this->instanceAdminClient->getOperationsClient()
            ->shouldBeCalledOnce()
            ->willReturn($operationsClient->reveal());

        $res = $snippet->invoke('operations');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertContainsOnlyInstancesOf(LongRunningOperation::class, $res->returnVal());
    }

    public function testDatabaseWithDatabaseRole()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'database', 1);
        $snippet->addLocal('instance', $this->instance);

        $res = $snippet->invoke('database');
        $this->assertInstanceOf(Database::class, $res->returnVal());
        $this->assertEquals(self::DATABASE, DatabaseAdminClient::parseName($res->returnVal()->name())['database']);
    }
}
