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

use Google\ApiCore\OperationResponse;
use Google\ApiCore\Serializer;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Database\V1\CopyBackupRequest;
use Google\Cloud\Spanner\Admin\Database\V1\CreateBackupRequest;
use Google\Cloud\Spanner\Admin\Database\V1\DeleteBackupRequest;
use Google\Cloud\Spanner\Admin\Database\V1\GetBackupRequest;
use Google\Cloud\Spanner\Admin\Database\V1\Backup as ProtoBackup;
use Google\Cloud\Spanner\Backup;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\Tests\RequestHandlingTestTrait;
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
    use RequestHandlingTestTrait;

    const PROJECT_ID = 'test-project';
    const INSTANCE = 'instance-name';
    const DATABASE = 'database-name';
    const BACKUP = 'backup-name';
    const COPIED_BACKUP = 'new-backup-name';

    private $databaseAdminClient;
    private Serializer $serializer;
    private $instance;

    private $database;
    private DateTime $expireTime;
    private $versionTime;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->databaseAdminClient = $this->prophesize(DatabaseAdminClient::class);
        $this->serializer = $this->getSerializer();

        $this->database = $this->prophesize(Database::class);
        $this->database->name()->willReturn(DatabaseAdminClient::databaseName(self::PROJECT_ID, self::INSTANCE, self::DATABASE));

        $this->instance = $this->prophesize(Instance::class);
        $this->instance->name()->willReturn(DatabaseAdminClient::instanceName(self::PROJECT_ID, self::INSTANCE));
        $this->instance->database(Argument::any())->willReturn($this->database);

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
            ->willReturn($this->getOperationResponseMock());

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
            ->willReturn($this->getOperationResponseMock());

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
        $response = new ProtoBackup([
            'name' => DatabaseAdminClient::backupName(self::PROJECT_ID, self::INSTANCE, self::BACKUP),
            'expire_time' => new \Google\Protobuf\Timestamp(['seconds' => $this->expireTime->format('U')]),
            'create_time' => new \Google\Protobuf\Timestamp(['seconds' => $this->expireTime->format('U')]),
            'version_time' => new \Google\Protobuf\Timestamp(['seconds' => $this->versionTime->format('U')]),
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

        $this->assertEquals([
            'name' => $response->getName(),
            'expireTime' => $this->expireTime->format('Y-m-d\TH:i:s.u\Z'),
            'createTime' => $this->expireTime->format('Y-m-d\TH:i:s.u\Z'),
            'versionTime' => $this->versionTime->format('Y-m-d\TH:i:s.u\Z'),
        ], $info);

        // Make sure the request only is sent once.
        $backup->info();
    }

    public function testReload()
    {
        $res = [
            'name' => $this->backup->name(),
            'expireTime' => $this->expireTime->format('Y-m-d\TH:i:s.u\Z'),
            'createTime' => $this->createTime->format('Y-m-d\TH:i:s.u\Z'),
            'versionTime' => $this->versionTime->format('Y-m-d\TH:i:s.u\Z')
        ];

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'getBackup',
            function ($args) {
                $this->assertEquals($args->getName(), $this->backup->name());
                return true;
            },
            $res
        );

        $this->backup->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->backup->___setProperty('serializer', $this->serializer);

        $info = $this->backup->reload();

        $this->assertEquals($res, $info);
    }

    public function testState()
    {
        $res = [
            'state' => Backup::STATE_READY
        ];
        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'getBackup',
            function ($args) {
                $this->assertEquals($args->getName(), $this->backup->name());
                return true;
            },
            $res
        );

        $this->backup->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->backup->___setProperty('serializer', $this->serializer);

        $this->assertEquals(Backup::STATE_READY, $this->backup->state());

        // Make sure the request only is sent once.
        $this->backup->state();
    }

    public function testExists()
    {
        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'getBackup',
            function ($args) {
                $this->assertEquals($args->getName(), $this->backup->name());
                return true;
            },
            []
        );

        $this->backup->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->backup->___setProperty('serializer', $this->serializer);

        $this->assertTrue($this->backup->exists());
    }

    public function testUpdateExpireTime()
    {
        $res = ['name' => 'foo', 'expireTime' => $this->expireTime->format('Y-m-d\TH:i:s.u\Z')];

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'updateBackup',
            function ($args) use ($res) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['backup']['name'],
                    $this->backup->name()
                );
                $this->assertEquals(
                    $message['backup']['expireTime'],
                    $this->expireTime->format('Y-m-d\TH:i:s.u\Z')
                );
                $this->assertEquals($message['updateMask'], ['paths' => ['expire_time']]);
                return $res;
            },
            $res
        );

        $this->backup->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->backup->___setProperty('serializer', $this->serializer);

        $info = $this->backup->updateExpireTime($this->expireTime);
        $this->assertEquals($res, $info);
    }
}
