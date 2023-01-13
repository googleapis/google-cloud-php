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

use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Backup;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\InstanceConfiguration;
use Google\Cloud\Spanner\Tests\StubCreationTrait;
use Prophecy\Argument;

/**
 * @group spanner
 * @group spanner-admin
 */
class InstanceTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use StubCreationTrait;

    const PROJECT = 'my-awesome-project';
    const INSTANCE = 'my-instance';
    const DATABASE = 'my-database';
    const BACKUP = 'my-backup';
    const OPERATION = 'my-operation';

    private $connection;
    private $instance;

    public function set_up()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->getConnStub();
        $this->instance = TestHelpers::stub(Instance::class, [
            $this->connection->reveal(),
            $this->prophesize(LongRunningConnectionInterface::class)->reveal(),
            [],
            self::PROJECT,
            self::INSTANCE
        ], ['connection', 'lroConnection']);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Instance::class);
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

        $this->connection->createInstance(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['name' => 'operations/foo']);

        $this->instance->___setProperty('connection', $this->connection->reveal());

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

        $this->connection->getInstance(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['nodeCount' => 1]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('1', $res->output());
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'exists');
        $snippet->addLocal('instance', $this->instance);

        $this->connection->getInstance(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['foo' => 'bar']);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Instance exists!', $res->output());
    }

    public function testReload()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'reload');
        $snippet->addLocal('instance', $this->instance);

        $this->connection->getInstance(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn(['nodeCount' => 1]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('info');
        $info = $this->instance->info();
        $this->assertEquals($info, $res->returnVal());
    }

    public function testState()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'state');
        $snippet->addLocal('instance', $this->instance);
        $snippet->addUse(Instance::class);

        $this->connection->getInstance(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn(['state' => Instance::STATE_READY]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Instance is ready!', $res->output());
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'update');
        $snippet->addLocal('instance', $this->instance);

        $this->connection->updateInstance(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'my-operation'
            ]);

        $this->instance->___setProperty('connection', $this->connection->reveal());
        $snippet->invoke();
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'delete');
        $snippet->addLocal('instance', $this->instance);

        $this->connection->deleteInstance(Argument::any())
            ->shouldBeCalled();

        $this->instance->___setProperty('connection', $this->connection->reveal());
        $snippet->invoke();
    }

    public function testCreateDatabase()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'createDatabase');
        $snippet->addLocal('instance', $this->instance);

        $this->connection->createDatabase(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'my-operation'
            ]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal());
    }

    public function testCreateDatabaseFromBackup()
    {
        $backup = DatabaseAdminClient::backupName(self::PROJECT, self::INSTANCE, self::BACKUP);
        $snippet = $this->snippetFromMethod(Instance::class, 'createDatabaseFromBackup');
        $snippet->addLocal('instance', $this->instance);
        $snippet->addLocal('backup', $backup);

        $this->connection->restoreDatabase(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'my-operation'
            ]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

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

        $this->connection->listDatabases(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'databases' => [
                    [
                        'name' => DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
                    ]
                ]
            ]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

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

        $this->connection->listBackups(Argument::any())
            ->shouldBeCalled()
            ->WillReturn([
                'backups' => [
                    [
                        'name' => DatabaseAdminClient::backupName(self::PROJECT, self::INSTANCE, self::BACKUP)
                    ]
                ]
            ]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

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

        $this->connection->listBackupOperations(Argument::any())
            ->shouldBeCalled()
            ->WillReturn([
                'operations' => [
                    [
                        'name' => $backupOperationName
                    ]
                ]
            ]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('backupOperations');

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal()->current());
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

        $this->connection->listDatabaseOperations(Argument::any())
            ->shouldBeCalled()
            ->WillReturn([
                'operations' => [
                    [
                        'name' => $databaseOperationName
                    ]
                ]
            ]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('databaseOperations');

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal()->current());
    }

    public function testIam()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'iam');
        $snippet->addLocal('instance', $this->instance);

        $res = $snippet->invoke('iam');
        $this->assertInstanceOf(Iam::class, $res->returnVal());
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

        $lroConnection = $this->prophesize(LongRunningConnectionInterface::class);
        $lroConnection->operations(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'operations' => [
                    [
                        'name' => 'foo'
                    ]
                ]
            ]);

        $this->instance->___setProperty('lroConnection', $lroConnection->reveal());

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
