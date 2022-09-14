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

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\Tests\StubCreationTrait;
use Google\Cloud\Spanner\Backup;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group spanner
 * @group spanner-admin
 */
class InstanceTest extends TestCase
{
    use ExpectException;
    use GrpcTestTrait;
    use StubCreationTrait;

    const PROJECT_ID = 'test-project';
    const NAME = 'instance-name';
    const DATABASE = 'database-name';
    const BACKUP = 'my-backup';

    private $connection;
    private $instance;
    private $lroConnection;

    public function set_up()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->getConnStub();
        $this->instance = TestHelpers::stub(Instance::class, [
            $this->connection->reveal(),
            $this->prophesize(LongRunningConnectionInterface::class)->reveal(),
            [],
            self::PROJECT_ID,
            self::NAME
        ], [
            'info',
            'connection'
        ]);
    }

    public function testName()
    {
        $this->assertEquals(self::NAME, InstanceAdminClient::parseName($this->instance->name())['instance']);
    }

    public function testInfo()
    {
        $this->connection->getInstance(Argument::any())->shouldNotBeCalled();

        $this->instance->___setProperty('info', ['foo' => 'bar']);
        $this->assertEquals('bar', $this->instance->info()['foo']);
    }

    public function testInfoWithReload()
    {
        $instance = $this->getDefaultInstance();

        $this->connection->getInstance(Argument::allOf(
            Argument::withEntry(
                'projectName',
                InstanceAdminClient::projectName(self::PROJECT_ID)
            ),
            Argument::withEntry('name', $this->instance->name())
        ))
            ->shouldBeCalledTimes(1)
            ->willReturn($instance);

        $this->instance->___setProperty('connection', $this->connection->reveal());

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
        $this->connection->getInstance(Argument::allOf(
            Argument::withEntry('name', $this->instance->name()),
            Argument::withEntry('fieldMask', $requestedFieldNames)
        ))
            ->shouldBeCalledTimes(1)
            ->willReturn($instance);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $info = $this->instance->info(['fieldMask' => $requestedFieldNames]);

        $this->assertEquals($info, $this->instance->info());
    }

    public function testExists()
    {
        $this->connection->getInstance(Argument::allOf(
            Argument::withEntry('name', $this->instance->name()),
            Argument::withEntry(
                'projectName',
                InstanceAdminClient::projectName(self::PROJECT_ID)
            ),
            Argument::withEntry('fieldMask', ['name'])
        ))
            ->shouldBeCalledTimes(1)
            ->willReturn([]);

        $this->connection->getInstance(Argument::allOf(
            Argument::withEntry('name', $this->instance->name()),
            Argument::withEntry(
                'projectName',
                InstanceAdminClient::projectName(self::PROJECT_ID)
            ),
            Argument::not(Argument::withKey('fieldMask'))
        ))
            ->shouldBeCalledTimes(2)
            ->willReturn([
                'name' => $this->instance->name(),
                'nodeCount' => 1,
            ]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $this->assertTrue($this->instance->exists());

        $info = $this->instance->reload();
        $this->assertTrue($this->instance->exists());
        $this->assertEquals($info, $this->instance->info());
    }

    public function testExistsNotFound()
    {
        $this->connection->getInstance(Argument::allOf(
            Argument::withEntry(
                'projectName',
                InstanceAdminClient::projectName(self::PROJECT_ID)
            ),
            Argument::withEntry('name', $this->instance->name())
        ))
            ->shouldBeCalled()
            ->willThrow(new NotFoundException('foo', 404));

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $this->assertFalse($this->instance->exists());
    }

    public function testReload()
    {
        $instance = $this->getDefaultInstance();

        $this->connection->getInstance(Argument::allOf(
            Argument::withEntry('name', $this->instance->name()),
            Argument::withEntry(
                'projectName',
                InstanceAdminClient::projectName(self::PROJECT_ID)
            )
        ))
            ->shouldBeCalledTimes(1)
            ->willReturn($instance);

        $this->instance->___setProperty('connection', $this->connection->reveal());

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
        $this->connection->getInstance(Argument::allOf(
            Argument::withEntry('name', $this->instance->name()),
            Argument::withEntry(
                'projectName',
                InstanceAdminClient::projectName(self::PROJECT_ID)
            ),
            Argument::withEntry('fieldMask', $requestedFieldNames)
        ))
            ->shouldBeCalledTimes(1)
            ->willReturn($instance);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $info = $this->instance->reload(['fieldMask' => $requestedFieldNames]);

        $this->assertEquals($info, $this->instance->info());
    }

    public function testState()
    {
        $instance = $this->getDefaultInstance();

        $this->connection->getInstance(Argument::allOf(
            Argument::withEntry(
                'projectName',
                InstanceAdminClient::projectName(self::PROJECT_ID)
            ),
            Argument::withEntry('name', $this->instance->name())
        ))
            ->shouldBeCalledTimes(1)
            ->willReturn($instance);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $this->assertEquals(Instance::STATE_READY, $this->instance->state());
    }

    public function testStateIsNull()
    {
        $this->connection->getInstance(Argument::allOf(
            Argument::withEntry(
                'projectName',
                InstanceAdminClient::projectName(self::PROJECT_ID)
            ),
            Argument::withEntry('name', $this->instance->name())
        ))
            ->shouldBeCalledTimes(1)
            ->willReturn([]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $this->assertNull($this->instance->state());
    }

    public function testUpdate()
    {
        $instance = $this->getDefaultInstance();

        $this->connection->updateInstance([
            'displayName' => 'bar',
            'name' => $instance['name'],
        ])->shouldBeCalled()->willReturn([
            'name' => 'my-operation'
        ]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $this->instance->update(['displayName' => 'bar']);
    }

    public function testUpdateWithProcessingUnits()
    {
        $instance = $this->getDefaultInstance();

        $this->connection->updateInstance([
            'processingUnits' => 500,
            'name' => $instance['name'],
        ])->shouldBeCalled()->willReturn([
            'name' => 'my-operation'
        ]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $this->instance->update(['processingUnits' => 500]);
    }

    public function testUpdateRaisesInvalidArgument()
    {
        $this->expectException('\InvalidArgumentException');

        $this->instance->update(['processingUnits' => 5000, 'nodeCount' => 5]);
    }

    public function testUpdateWithExistingLabels()
    {
        $instance = $this->getDefaultInstance();
        $instance['labels'] = ['foo' => 'bar'];

        $this->connection->updateInstance([
            'labels' => $instance['labels'],
            'name' => $instance['name'],
        ])->shouldBeCalled()->willReturn([
            'name' => 'my-operation'
        ]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

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

        $this->connection->updateInstance([
            'name' => $instance['name'],
            'displayName' => $changes['displayName'],
            'nodeCount' => $changes['nodeCount'],
            'labels' => $changes['labels'],
        ])->shouldBeCalled()->willReturn([
            'name' => 'my-operation'
        ]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $this->instance->update($changes);
    }

    public function testDelete()
    {
        $this->connection->deleteInstance([
            'name' => InstanceAdminClient::instanceName(self::PROJECT_ID, self::NAME)
        ])->shouldBeCalled();

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $this->instance->delete();
    }

    public function testCreateDatabase()
    {
        $extra = ['foo', 'bar'];

        $this->connection->createDatabase([
            'instance' => InstanceAdminClient::instanceName(self::PROJECT_ID, self::NAME),
            'createStatement' => 'CREATE DATABASE `test-database`',
            'extraStatements' => $extra
        ])
            ->shouldBeCalled()
            ->willReturn(['name' => 'operations/foo']);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $database = $this->instance->createDatabase('test-database', [
            'statements' => $extra
        ]);

        $this->assertInstanceOf(LongRunningOperation::class, $database);
    }

    public function testCreateDatabaseFromBackupName()
    {
        $backupName = DatabaseAdminClient::backupName(self::PROJECT_ID, self::NAME, self::BACKUP);
        $this->connection->restoreDatabase(Argument::allOf(
            Argument::withEntry('databaseId', 'restore-database'),
            Argument::withEntry('instance', $this->instance->name()),
            Argument::withEntry('backup', $backupName)
        ))
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'my-operation'
            ]);
        $this->instance->___setProperty('connection', $this->connection->reveal());

        $op = $this->instance->createDatabaseFromBackup('restore-database', $backupName);
        $this->assertInstanceOf(LongRunningOperation::class, $op);
    }

    public function testCreateDatabaseFromBackupObject()
    {
        $backupObject = $this->instance->backup(self::BACKUP);
        $this->connection->restoreDatabase(Argument::allOf(
            Argument::withEntry('databaseId', 'restore-database'),
            Argument::withEntry('instance', $this->instance->name()),
            Argument::withEntry('backup', $backupObject->name())
        ))
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'my-operation'
            ]);
        $this->instance->___setProperty('connection', $this->connection->reveal());

        $op = $this->instance->createDatabaseFromBackup('restore-database', $backupObject);
        $this->assertInstanceOf(LongRunningOperation::class, $op);
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

        $this->connection->listDatabases(Argument::withEntry('instance', $this->instance->name()))
            ->shouldBeCalled()
            ->willReturn(['databases' => $databases]);

        $this->connection->getDatabase(Argument::any())->shouldNotBeCalled();

        $this->instance->___setProperty('connection', $this->connection->reveal());

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

        $iteration = 0;
        $this->connection->listDatabases(Argument::withEntry('instance', $this->instance->name()))
            ->shouldBeCalledTimes(2)
            ->willReturn(['databases' => [$databases[0]], 'nextPageToken' => 'foo'], ['databases' => [$databases[1]]]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $dbs = $this->instance->databases();

        $this->assertInstanceOf(ItemIterator::class, $dbs);

        $dbs = iterator_to_array($dbs);

        $this->assertCount(2, $dbs);
        $this->assertEquals('database1', DatabaseAdminClient::parseName($dbs[0]->name())['database']);
        $this->assertEquals('database2', DatabaseAdminClient::parseName($dbs[1]->name())['database']);
    }

    public function testIam()
    {
        $this->assertInstanceOf(Iam::class, $this->instance->iam());
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

        $this->connection->listBackups(Argument::withEntry('instance', $this->instance->name()))
            ->shouldBeCalled()
            ->willReturn(['backups' => $backups]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

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

        $this->connection->listBackupOperations(Argument::withEntry('instance', $this->instance->name()))
            ->shouldBeCalled()
            ->willReturn(['operations' => $operations]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $bkpOps = $this->instance->backupOperations();

        $this->assertInstanceOf(ItemIterator::class, $bkpOps);

        $bkpOps = iterator_to_array($bkpOps);
        $this->assertCount(2, $bkpOps);
        $this->assertEquals('operation1', $bkpOps[0]->name());
        $this->assertEquals('operation2', $bkpOps[1]->name());
    }

    public function testListDatabaseOperations()
    {
        $operations = [
            ['name' => 'operation1'],
            ['name' => 'operation2']
        ];

        $this->connection->listDatabaseOperations(Argument::withEntry('instance', $this->instance->name()))
            ->shouldBeCalled()
            ->willReturn(['operations' => $operations]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $dbOps = $this->instance->databaseOperations();

        $this->assertInstanceOf(ItemIterator::class, $dbOps);

        $dbOps = iterator_to_array($dbOps);
        $this->assertCount(2, $dbOps);
        $this->assertEquals('operation1', $dbOps[0]->name());
        $this->assertEquals('operation2', $dbOps[1]->name());
    }

    // ************** //

    private function getDefaultInstance()
    {
        return json_decode(file_get_contents(Fixtures::INSTANCE_FIXTURE()), true);
    }
}
