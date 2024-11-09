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

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\Serializer;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Database\V1\CopyBackupRequest;
use Google\Cloud\Spanner\Admin\Database\V1\CreateBackupRequest;
use Google\Cloud\Spanner\Admin\Database\V1\DeleteBackupRequest;
use Google\Cloud\Spanner\Admin\Database\V1\GetBackupRequest;
use Google\Cloud\Spanner\Admin\Database\V1\UpdateBackupRequest;
use Google\Cloud\Spanner\Admin\Database\V1\Backup as BackupProto;
use Google\Cloud\Spanner\Backup;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Protobuf\FieldMask;
use Google\Protobuf\Timestamp;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use DateTime;

/**
 * @group spanner
 * @group spanner-admin
 */
class BackupTest extends TestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;
    use ArraySubsetAsserts;
    use ApiHelperTrait;

    const PROJECT_ID = 'test-project';
    const INSTANCE = 'instance-name';
    const DATABASE = 'database-name';
    const BACKUP = 'backup-name';
    const COPIED_BACKUP = 'new-backup-name';

    private $databaseAdminClient;
    private Serializer $serializer;
    private $instance;
    private $operationResponse;

    private $database;
    private DateTime $expireTime;
    private $versionTime;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->databaseAdminClient = $this->prophesize(DatabaseAdminClient::class);
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

        $this->database = $this->prophesize(Database::class);
        $this->database->name()->willReturn(DatabaseAdminClient::databaseName(self::PROJECT_ID, self::INSTANCE, self::DATABASE));

        $this->instance = $this->prophesize(Instance::class);
        $this->instance->name()->willReturn(DatabaseAdminClient::instanceName(self::PROJECT_ID, self::INSTANCE));
        $this->instance->database(Argument::any())->willReturn($this->database);

        $this->operationResponse = $this->prophesize(OperationResponse::class);
        $this->operationResponse->withResultFunction(Argument::any())->willReturn($this->operationResponse->reveal());

        $this->expireTime = new DateTime("+7 hours");
        $this->versionTime = new DateTime("-2 hours");
    }

    public function testName()
    {
        $backup = new Backup(
            $this->databaseAdminClient->reveal(),
            $this->serializer,
            $this->instance->reveal(),
            self::PROJECT_ID,
            self::BACKUP
        );

        $this->assertEquals(
            DatabaseAdminClient::backupName(self::PROJECT_ID, self::INSTANCE, self::BACKUP),
            $backup->name()
        );
    }

    public function testCreate()
    {
        $expected = [
            'parent' => DatabaseAdminClient::instanceName(self::PROJECT_ID, self::INSTANCE),
            'database' => DatabaseAdminClient::databaseName(self::PROJECT_ID, self::INSTANCE, self::DATABASE),
            'expire_time' => $this->expireTime->format('U'),
            'version_time' => $this->versionTime->format('U'),
        ];
        $this->databaseAdminClient->createBackup(
            Argument::that(function (CreateBackupRequest $request) use ($expected) {
                $this->assertEquals($expected['parent'], $request->getParent());
                $this->assertEquals(self::BACKUP, $request->getBackupId());
                $this->assertEquals($expected['database'], $request->getBackup()->getDatabase());
                $this->assertEquals($expected['expire_time'], $request->getBackup()->getExpireTime()->getSeconds());
                $this->assertEquals($expected['version_time'], $request->getBackup()->getVersionTime()->getSeconds());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        $backup = new Backup(
            $this->databaseAdminClient->reveal(),
            $this->serializer,
            $this->instance->reveal(),
            self::PROJECT_ID,
            self::BACKUP
        );

        $operation = $backup->create(self::DATABASE, $this->expireTime, [
            'versionTime' => $this->versionTime,
        ]);
        $this->assertInstanceOf(OperationResponse::class, $operation);
    }

    public function testCreateCopy()
    {
        $expected = [
            'parent' => DatabaseAdminClient::instanceName(self::PROJECT_ID, self::INSTANCE),
            'source_backup' => DatabaseAdminClient::backupName(self::PROJECT_ID, self::INSTANCE, self::BACKUP),
            'expire_time' => $this->expireTime->format('U'),
        ];
        $this->databaseAdminClient->copyBackup(
            Argument::that(function (CopyBackupRequest $request) use ($expected) {
                $this->assertEquals($expected['parent'], $request->getParent());
                $this->assertEquals(self::COPIED_BACKUP, $request->getBackupId());
                $this->assertEquals($expected['source_backup'], $request->getSourceBackup());
                $this->assertEquals($expected['expire_time'], $request->getExpireTime()->getSeconds());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        $backup = new Backup(
            $this->databaseAdminClient->reveal(),
            $this->serializer,
            $this->instance->reveal(),
            self::PROJECT_ID,
            self::BACKUP
        );

        $copiedBackup = new Backup(
            $this->databaseAdminClient->reveal(),
            $this->serializer,
            $this->instance->reveal(),
            self::PROJECT_ID,
            self::COPIED_BACKUP
        );

        $op = $backup->createCopy($copiedBackup, $this->expireTime);
        $this->assertInstanceOf(OperationResponse::class, $op);
    }

    public function testDelete()
    {
        $this->databaseAdminClient->deleteBackup(
            Argument::type(DeleteBackupRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce();

        $backup = new Backup(
            $this->databaseAdminClient->reveal(),
            $this->serializer,
            $this->instance->reveal(),
            self::PROJECT_ID,
            self::BACKUP
        );

        $backup->delete();
    }

    public function testInfo()
    {
        $response = new BackupProto([
            'name' => DatabaseAdminClient::backupName(self::PROJECT_ID, self::INSTANCE, self::BACKUP),
            'expire_time' => new Timestamp(['seconds' => $this->expireTime->format('U')]),
            'create_time' => new Timestamp(['seconds' => $this->expireTime->format('U')]),
            'version_time' => new Timestamp(['seconds' => $this->versionTime->format('U')]),
        ]);

        $this->databaseAdminClient->getBackup(
            Argument::type(GetBackupRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($response);

        $backup = new Backup(
            $this->databaseAdminClient->reveal(),
            $this->serializer,
            $this->instance->reveal(),
            self::PROJECT_ID,
            self::BACKUP
        );

        $info = $backup->info();

        $this->assertArraySubset([
            'name' => $response->getName(),
            'expireTime' => $this->expireTime->format('Y-m-d\TH:i:s.000000\Z'),
            'createTime' => $this->expireTime->format('Y-m-d\TH:i:s.000000\Z'),
            'versionTime' => $this->versionTime->format('Y-m-d\TH:i:s.000000\Z'),
        ], $info);

        // Make sure the request only is sent once.
        $backup->info();
    }

    public function testReload()
    {
        $response = new BackupProto([
            'name' => DatabaseAdminClient::backupName(self::PROJECT_ID, self::INSTANCE, self::BACKUP),
        ]);

        $this->databaseAdminClient->getBackup(
            Argument::type(GetBackupRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($response);

        $backup = new Backup(
            $this->databaseAdminClient->reveal(),
            $this->serializer,
            $this->instance->reveal(),
            self::PROJECT_ID,
            self::BACKUP,
            ['name' => 'different-name']
        );

        $info = $backup->reload();

        $this->assertArraySubset([
            'name' => $response->getName(),
        ], $info);
    }

    public function testState()
    {
        $response = new BackupProto([
            'state' => Backup::STATE_READY,
        ]);

        $this->databaseAdminClient->getBackup(
            Argument::type(GetBackupRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($response);

        $backup = new Backup(
            $this->databaseAdminClient->reveal(),
            $this->serializer,
            $this->instance->reveal(),
            self::PROJECT_ID,
            self::BACKUP
        );

        $this->assertEquals(Backup::STATE_READY, $backup->state());

        // Make sure the request only is sent once.
        $backup->state();
    }

    public function testExists()
    {
        $this->databaseAdminClient->getBackup(
            Argument::type(GetBackupRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new BackupProto());

        $backup = new Backup(
            $this->databaseAdminClient->reveal(),
            $this->serializer,
            $this->instance->reveal(),
            self::PROJECT_ID,
            self::BACKUP
        );

        $this->assertTrue($backup->exists());
    }

    public function testUpdateExpireTime()
    {
        $newExpireTime = new DateTime("+1 day");

        $response = new BackupProto([
            'name' => 'foo',
            'expire_time' => new Timestamp(['seconds' => $newExpireTime->format('U')]),
        ]);

        $this->databaseAdminClient->updateBackup(
            Argument::that(function (UpdateBackupRequest $request) use ($newExpireTime) {
                $this->assertEquals(new FieldMask(['paths' => ['expire_time']]), $request->getUpdateMask());
                $this->assertEquals($newExpireTime->format('U'), $request->getBackup()->getExpireTime()->getSeconds());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($response);

        $backup = new Backup(
            $this->databaseAdminClient->reveal(),
            $this->serializer,
            $this->instance->reveal(),
            self::PROJECT_ID,
            self::BACKUP
        );

        $info = $backup->updateExpireTime($newExpireTime);
        $this->assertArraySubset([
            'expireTime' => $newExpireTime->format('Y-m-d\TH:i:s.000000\Z'),
        ], $info);
    }
}
