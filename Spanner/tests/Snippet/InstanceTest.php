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
use Google\Cloud\Core\LongRunning\LongRunningOperationManager;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Spanner\Tests\RequestHandlingTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
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
    use RequestHandlingTestTrait;

    const PROJECT = 'my-awesome-project';
    const INSTANCE = 'my-instance';
    const DATABASE = 'my-database';
    const BACKUP = 'my-backup';
    const OPERATION = 'my-operation';

    private $requestHandler;
    private $serializer;
    private $instance;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->requestHandler = $this->getRequestHandlerStub();
        $this->serializer = $this->getSerializer();
        $this->instance = TestHelpers::stub(Instance::class, [
            $this->requestHandler->reveal(),
            $this->serializer,
            [],
            self::PROJECT,
            self::INSTANCE
        ], ['requestHandler', 'serializer']);
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

        $this->mockSendRequest(
            InstanceAdminClient::class,
            'createInstance',
            null,
            $this->getOperationResponseMock()
        );

        $this->instance->___setProperty(
            'requestHandler',
            $this->requestHandler->reveal()
        );
        $this->instance->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperationManager::class, $res->returnVal());
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

        $this->mockSendRequest(
            InstanceAdminClient::class,
            'getInstance',
            null,
            ['nodeCount' => 1]
        );

        $this->instance->___setProperty(
            'requestHandler',
            $this->requestHandler->reveal()
        );
        $this->instance->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke();
        $this->assertEquals('1', $res->output());
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'exists');
        $snippet->addLocal('instance', $this->instance);

        $this->mockSendRequest(
            InstanceAdminClient::class,
            'getInstance',
            null,
            ['foo' => 'bar']
        );

        $this->instance->___setProperty(
            'requestHandler',
            $this->requestHandler->reveal()
        );
        $this->instance->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke();
        $this->assertEquals('Instance exists!', $res->output());
    }

    public function testReload()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'reload');
        $snippet->addLocal('instance', $this->instance);

        $this->mockSendRequest(
            InstanceAdminClient::class,
            'getInstance',
            null,
            ['nodeCount' => 1]
        );

        $this->instance->___setProperty(
            'requestHandler',
            $this->requestHandler->reveal()
        );
        $this->instance->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke('info');
        $info = $this->instance->info();
        $this->assertEquals($info, $res->returnVal());
    }

    public function testState()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'state');
        $snippet->addLocal('instance', $this->instance);
        $snippet->addUse(Instance::class);

        $this->mockSendRequest(
            InstanceAdminClient::class,
            'getInstance',
            null,
            ['state' => Instance::STATE_READY]
        );

        $this->instance->___setProperty(
            'requestHandler',
            $this->requestHandler->reveal()
        );
        $this->instance->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke();
        $this->assertEquals('Instance is ready!', $res->output());
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'update');
        $snippet->addLocal('instance', $this->instance);

        $this->mockSendRequest(
            InstanceAdminClient::class,
            'updateInstance',
            null,
            $this->getOperationResponseMock()
        );

        $this->instance->___setProperty(
            'requestHandler',
            $this->requestHandler->reveal()
        );
        $this->instance->___setProperty('serializer', $this->serializer);
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
        $this->instance->___setProperty('serializer', $this->serializer);
        $snippet->invoke();
    }

    public function testCreateDatabase()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'createDatabase');
        $snippet->addLocal('instance', $this->instance);

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'createDatabase',
            null,
            $this->getOperationResponseMock()
        );

        $this->instance->___setProperty(
            'requestHandler',
            $this->requestHandler->reveal()
        );
        $this->instance->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperationManager::class, $res->returnVal());
    }

    public function testCreateDatabaseFromBackup()
    {
        $backup = DatabaseAdminClient::backupName(self::PROJECT, self::INSTANCE, self::BACKUP);
        $snippet = $this->snippetFromMethod(Instance::class, 'createDatabaseFromBackup');
        $snippet->addLocal('instance', $this->instance);
        $snippet->addLocal('backup', $backup);

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'restoreDatabase',
            null,
            $this->getOperationResponseMock()
        );

        $this->instance->___setProperty(
            'requestHandler',
            $this->requestHandler->reveal()
        );
        $this->instance->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperationManager::class, $res->returnVal());
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

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'listDatabases',
            null,
            [
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
        $this->instance->___setProperty('serializer', $this->serializer);

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

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'listBackups',
            null,
            [
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
        $this->instance->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke('backups');

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertInstanceOf(Backup::class, $res->returnVal()->current());
    }

    public function testBackupOperations()
    {
        $backupOperationName = sprintf(
            "%s/operations/%s",
            DatabaseAdminClient::backupName(self::PROJECT, self::INSTANCE, self::BACKUP),
            self::OPERATION
        );

        $snippet = $this->snippetFromMethod(Instance::class, 'backupOperations');
        $snippet->addLocal('instance', $this->instance);

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'listBackupOperations',
            null,
            [
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
        $this->instance->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke('backupOperations');

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertInstanceOf(LongRunningOperationManager::class, $res->returnVal()->current());
    }

    public function testDatabaseOperations()
    {
        $databaseOperationName = sprintf(
            "%s/operations/%s",
            DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE),
            self::OPERATION
        );

        $snippet = $this->snippetFromMethod(Instance::class, 'databaseOperations');
        $snippet->addLocal('instance', $this->instance);

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'listDatabaseOperations',
            null,
            [
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
        $this->instance->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke('databaseOperations');

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertInstanceOf(LongRunningOperationManager::class, $res->returnVal()->current());
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
        $this->assertInstanceOf(LongRunningOperationManager::class, $res->returnVal());
        $this->assertEquals('foo', $res->returnVal()->name());
    }

    public function testLongRunningOperations()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'longRunningOperations');
        $snippet->addLocal('instance', $this->instance);

        $this->requestHandler
            ->getClientObject(Argument::any())
            ->willReturn(new DatabaseAdminClient());
        $this->requestHandler
            ->addClientObject(Argument::any(), Argument::any())
            ->willReturn(null);
        $this->requestHandler
            ->sendRequest(
                Argument::any(),
                'listOperations',
                Argument::cetera()
            )
            ->willReturn([$this->getOperationResponseMock()]);

        $this->instance->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->instance->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke('operations');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertContainsOnlyInstancesOf(LongRunningOperationManager::class, $res->returnVal());
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
