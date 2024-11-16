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
use Google\Cloud\Core\Iam\IamManager;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Spanner\Admin\Database\V1\CreateDatabaseRequest;
use Google\Cloud\Spanner\Admin\Database\V1\RestoreDatabaseRequest;
use Google\Cloud\Spanner\Admin\Database\V1\ListDatabasesRequest;
use Google\Cloud\Spanner\Admin\Database\V1\ListBackupsRequest;
use Google\Cloud\Spanner\Admin\Database\V1\ListBackupOperationsRequest;
use Google\Cloud\Spanner\Admin\Database\V1\ListDatabaseOperationsRequest;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\CreateInstanceRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\GetInstanceRequest;
use Google\Cloud\Spanner\Backup;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\InstanceConfiguration;
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
    private $serializer;
    private $instance;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->serializer = new Serializer();
        $this->instance = new Instance(
            $this->requestHandler->reveal(),
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
            ->willReturn($this->prophesize(OperationResponse::class)->reveal());

        $this->instance->___setProperty(
            'requestHandler',
            $this->requestHandler->reveal()
        );
        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(OperationResponse::class, $res->returnVal());
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
            ->willReturn(new GetInstanceResponse(['nodeCount' => 1]));

        $this->instance->___setProperty(
            'requestHandler',
            $this->requestHandler->reveal()
        );
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
            ->willReturn(new GetInstanceResponse(['foo' => 'bar']));

        $this->instance->___setProperty(
            'requestHandler',
            $this->requestHandler->reveal()
        );
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
            ->willReturn(new GetInstanceResponse(['nodeCount' => 1]));

        $this->instance->___setProperty(
            'requestHandler',
            $this->requestHandler->reveal()
        );
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
            ->willReturn(new GetInstanceResponse(['state' => Instance::STATE_READY]));

        $this->instance->___setProperty(
            'requestHandler',
            $this->requestHandler->reveal()
        );
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
            ->willReturn($this->prophesize(OperationResponse::class)->reveal());

        $this->instance->___setProperty(
            'requestHandler',
            $this->requestHandler->reveal()
        );
        $snippet->invoke();
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'delete');
        $snippet->addLocal('instance', $this->instance);

        $this->mockSendRequest(InstanceAdminClient::class, 'deleteInstance', null, null);

        $this->instance->___setProperty(
            'requestHandler',
            $this->requestHandler->reveal()
        );
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
            ->willReturn($this->prophesize(OperationResponse::class)->reveal());

        $this->instance->___setProperty(
            'requestHandler',
            $this->requestHandler->reveal()
        );
        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(OperationResponse::class, $res->returnVal());
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
            ->willReturn($this->prophesize(OperationResponse::class)->reveal());

        $this->instance->___setProperty(
            'requestHandler',
            $this->requestHandler->reveal()
        );
        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(OperationResponse::class, $res->returnVal());
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

        $this->databaseAdminClient->listDatabases(
            Argument::type(ListDatabasesRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn([
                'databases' => [
                    [
                        'name' => DatabaseAdminClient::databaseName(
                            self::PROJECT,
                            self::INSTANCE,
                            self::DATABASE
                        )
                    ]
                ]
            ]
        );

        $this->instance->___setProperty(
            'requestHandler',
            $this->requestHandler->reveal()
        );
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

        $this->databaseAdminClient->listBackups(
            Argument::type(ListBackupsRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn([
                'backups' => [
                    [
                        'name' => DatabaseAdminClient::backupName(
                            self::PROJECT,
                            self::INSTANCE,
                            self::BACKUP
                        )
                    ]
                ]
            ]
        );

        $this->instance->___setProperty(
            'requestHandler',
            $this->requestHandler->reveal()
        );
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

        $snippet = $this->snippetFromMethod(Instance::class, 'backupOperations');
        $snippet->addLocal('instance', $this->instance);

        $this->databaseAdminClient->listBackupOperations(
            Argument::type(ListBackupOperationsRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn([
                'operations' => [
                    [
                        'name' => $backupOperationName
                    ]
                ]
            ]
        );

        $this->instance->___setProperty(
            'requestHandler',
            $this->requestHandler->reveal()
        );
        $res = $snippet->invoke('backupOperations');

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertInstanceOf(OperationResponse::class, $res->returnVal()->current());
    }

    public function testDatabaseOperations()
    {
        $databaseOperationName = sprintf(
            '%s/operations/%s',
            DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE),
            self::OPERATION
        );

        $snippet = $this->snippetFromMethod(Instance::class, 'databaseOperations');
        $snippet->addLocal('instance', $this->instance);

        $this->databaseAdminClient->listDatabaseOperations(
            Argument::type(ListDatabaseOperationsRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn([
                'operations' => [
                    [
                        'name' => $databaseOperationName
                    ]
                ]
            ]
        );

        $this->instance->___setProperty(
            'requestHandler',
            $this->requestHandler->reveal()
        );
        $res = $snippet->invoke('databaseOperations');

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertInstanceOf(OperationResponse::class, $res->returnVal()->current());
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
        $this->assertInstanceOf(OperationResponse::class, $res->returnVal());
        $this->assertEquals('foo', $res->returnVal()->name());
    }

    public function testLongRunningOperations()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'longRunningOperations');
        $snippet->addLocal('instance', $this->instance);

        $this->requestHandler
            ->sendRequest(
                Argument::any(),
                'listOperations',
                Argument::cetera()
            )
            ->willReturn([$this->getOperationResponseMock()]);

        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $res = $snippet->invoke('operations');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertContainsOnlyInstancesOf(OperationResponse::class, $res->returnVal());
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
