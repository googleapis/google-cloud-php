<?php
/**
 * Copyright 2020 Google Inc.
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

use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Backup;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\Timestamp;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Prophecy\Argument;

/**
 * @group spanner
 * @group spanner-admin
 */
class BackupTest extends TestCase
{
    use GrpcTestTrait;

    const PROJECT_ID = 'test-project';
    const INSTANCE = 'instance-name';
    const DATABASE = 'database-name';
    const BACKUP = 'backup-name';
    const COPIED_BACKUP = 'new-backup-name';

    private $connection;
    private $instance;
    private $database;
    private $lro;
    private $lroCallables;
    private $expireTime;
    private $createTime;
    private $versionTime;
    private $backup;
    private $copiedBackup;

    public function set_up()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->instance = $this->prophesize(Instance::class);
        $this->database = $this->prophesize(Database::class);
        $this->database->name()->willReturn(
            DatabaseAdminClient::databaseName(self::PROJECT_ID, self::INSTANCE, self::DATABASE)
        );
        $this->instance->name()->willReturn(InstanceAdminClient::instanceName(self::PROJECT_ID, self::INSTANCE));
        $this->instance->database(Argument::any())->willReturn($this->database);
        $this->lro = $this->prophesize(LongRunningConnectionInterface::class);
        $this->lroCallables = [];
        $this->expireTime = new \DateTime("+ 7 hours");
        $this->createTime = $this->expireTime;
        $this->versionTime = new \DateTime("- 2 hours");

        $args=[
           $this->connection->reveal(),
           $this->instance->reveal(),
           $this->lro->reveal(),
           $this->lroCallables,
           self::PROJECT_ID,
           self::BACKUP
        ];
        $props = [
            'instance', 'connection'
        ];
        $this->backup = TestHelpers::stub(Backup::class, $args, $props);

        // copiedBackup will contain a mock of the backup object where
        // $backup will be copied into
        $copyArgs = $args;
        $copyArgs[5] = self::COPIED_BACKUP;
        $this->copiedBackup = TestHelpers::stub(Backup::class, $copyArgs, $props);
    }

    public function testName()
    {
        $this->assertEquals(
            DatabaseAdminClient::backupName(self::PROJECT_ID, self::INSTANCE, self::BACKUP),
            $this->backup->name()
        );
    }

    public function testCreate()
    {
        $this->connection->createBackup(Argument::allOf(
            Argument::withEntry('instance', InstanceAdminClient::instanceName(self::PROJECT_ID, self::INSTANCE)),
            Argument::withEntry('backupId', self::BACKUP),
            Argument::withEntry('backup', [
                'database' => DatabaseAdminClient::databaseName(self::PROJECT_ID, self::INSTANCE, self::DATABASE),
                'expireTime' => $this->expireTime->format('Y-m-d\TH:i:s.u\Z'),
            ]),
            Argument::withEntry('versionTime', $this->versionTime->format('Y-m-d\TH:i:s.u\Z'))
        ))
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'my-operation'
            ]);

        $this->backup->___setProperty('connection', $this->connection->reveal());
        $op = $this->backup->create(self::DATABASE, $this->expireTime, [
            'versionTime' => $this->versionTime,
        ]);
        $this->assertInstanceOf(LongRunningOperation::class, $op);
    }

    public function testCreateCopy()
    {
        $this->connection->copyBackup(Argument::allOf(
            Argument::withEntry('instance', InstanceAdminClient::instanceName(self::PROJECT_ID, self::INSTANCE)),
            Argument::withEntry('backupId', self::COPIED_BACKUP),
            Argument::withKey('sourceBackupId'),
            Argument::withEntry('expireTime', $this->expireTime->format('Y-m-d\TH:i:s.u\Z'))
        ))
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'my-operation'
            ]);

        $this->backup->___setProperty('connection', $this->connection->reveal());
        $op = $this->backup->createCopy($this->copiedBackup, $this->expireTime);
        $this->assertInstanceOf(LongRunningOperation::class, $op);
    }

    public function testDelete()
    {
        $this->connection->deleteBackup(Argument::withEntry('name', $this->backup->name()))
            ->shouldBeCalled();

        $this->backup->___setProperty('connection', $this->connection->reveal());

        $this->backup->delete();
    }

    public function testInfo()
    {
        $res = [
            'name' => $this->backup->name(),
            'expireTime' => $this->expireTime->format('Y-m-d\TH:i:s.u\Z'),
            'createTime' => $this->createTime->format('Y-m-d\TH:i:s.u\Z'),
            'versionTime' => $this->versionTime->format('Y-m-d\TH:i:s.u\Z')
        ];

        $this->connection->getBackup(Argument::withEntry('name', $this->backup->name()))
            ->shouldBeCalledTimes(1)
            ->willReturn($res);

        $this->backup->___setProperty('connection', $this->connection->reveal());

        $info = $this->backup->info();

        $this->assertEquals($res, $info);

        // Make sure the request only is sent once.
        $this->backup->info();
    }

    public function testReload()
    {
        $res = [
            'name' => $this->backup->name(),
            'expireTime' => $this->expireTime->format('Y-m-d\TH:i:s.u\Z'),
            'createTime' => $this->createTime->format('Y-m-d\TH:i:s.u\Z'),
            'versionTime' => $this->versionTime->format('Y-m-d\TH:i:s.u\Z')
        ];

        $this->connection->getBackup(Argument::withEntry('name', $this->backup->name()))
            ->shouldBeCalled()
            ->willReturn($res);

        $this->backup->___setProperty('connection', $this->connection->reveal());

        $info = $this->backup->reload();

        $this->assertEquals($res, $info);
    }

    public function testState()
    {
        $res = [
            'state' => Backup::STATE_READY
        ];
        $this->connection->getBackup(Argument::withEntry('name', $this->backup->name()))
            ->shouldBeCalledTimes(1)
            ->willReturn($res);

        $this->backup->___setProperty('connection', $this->connection->reveal());

        $this->assertEquals(Backup::STATE_READY, $this->backup->state());

        // Make sure the request only is sent once.
        $this->backup->state();
    }

    public function testExists()
    {
        $this->connection->getBackup(Argument::withEntry('name', $this->backup->name()))
            ->shouldBeCalled()
            ->willReturn([]);

        $this->backup->___setProperty('connection', $this->connection->reveal());

        $this->assertTrue($this->backup->exists());
    }

    public function testUpdateExpireTime()
    {
        $res = ['name' => 'foo', 'expireTime' => $this->expireTime->format('Y-m-d\TH:i:s.u\Z')];

        $this->connection->updateBackup(Argument::allOf(
            Argument::withEntry('backup', [
                'name' => $this->backup->name(),
                'expireTime' => $this->expireTime->format('Y-m-d\TH:i:s.u\Z')
            ]),
            Argument::withEntry('updateMask', ['paths' => ['expire_time']])
        ))
            ->shouldBeCalled()
            ->willReturn($res);

        $this->backup->___setProperty('connection', $this->connection->reveal());

        $info = $this->backup->updateExpireTime($this->expireTime);
        $this->assertEquals($res, $info);
    }
}
