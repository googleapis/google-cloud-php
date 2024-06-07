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
use Google\Cloud\Core\LongRunning\LongRunningOperationManager;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Backup;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\Tests\RequestHandlingTestTrait;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

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

    private $requestHandler;
    private $serializer;
    private $instance;
    private $database;
    private $lroCallables;
    private $expireTime;
    private $createTime;
    private $versionTime;
    private $backup;
    private $copiedBackup;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->requestHandler = $this->getRequestHandlerStub();
        $this->serializer = $this->getSerializer();
        $this->instance = $this->prophesize(Instance::class);
        $this->database = $this->prophesize(Database::class);
        $this->database->name()->willReturn(
            DatabaseAdminClient::databaseName(self::PROJECT_ID, self::INSTANCE, self::DATABASE)
        );
        $this->instance->name()->willReturn(InstanceAdminClient::instanceName(self::PROJECT_ID, self::INSTANCE));
        $this->instance->database(Argument::any())->willReturn($this->database);
        $this->lroCallables = [];
        $this->expireTime = new \DateTime("+ 7 hours");
        $this->createTime = $this->expireTime;
        $this->versionTime = new \DateTime("- 2 hours");

        $args=[
           $this->requestHandler->reveal(),
           $this->serializer,
           $this->instance->reveal(),
           $this->lroCallables,
           self::PROJECT_ID,
           self::BACKUP
        ];
        $props = [
            'instance', 'requestHandler', 'serializer'
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
        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'createBackup',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['parent'],
                    InstanceAdminClient::instanceName(self::PROJECT_ID, self::INSTANCE)
                );
                $this->assertEquals($message['backupId'], self::BACKUP);
                $this->assertEquals(
                    $message['backup']['database'],
                    DatabaseAdminClient::databaseName(self::PROJECT_ID, self::INSTANCE, self::DATABASE)
                );
                $this->assertEquals(
                    $message['backup']['expireTime'],
                    $this->expireTime->format('Y-m-d\TH:i:s.u\Z')
                );
                $this->assertEquals(
                    $message['backup']['versionTime'],
                    $this->versionTime->format('Y-m-d\TH:i:s.u\Z')
                );
                return true;
            },
            $this->getOperationResponseMock()
        );

        $this->backup->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->backup->___setProperty('serializer', $this->serializer);
        $op = $this->backup->create(self::DATABASE, $this->expireTime, [
            'versionTime' => $this->versionTime,
        ]);
        $this->assertInstanceOf(LongRunningOperationManager::class, $op);
    }

    public function testCreateCopy()
    {
        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'copyBackup',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['parent'],
                    InstanceAdminClient::instanceName(self::PROJECT_ID, self::INSTANCE)
                );
                $this->assertEquals($message['backupId'], self::COPIED_BACKUP);
                $this->assertArrayHasKey('sourceBackup', $message);
                $this->assertEquals(
                    $message['expireTime'],
                    $this->expireTime->format('Y-m-d\TH:i:s.u\Z')
                );
                return true;
            },
            $this->getOperationResponseMock()
        );
        $op = $this->backup->createCopy($this->copiedBackup, $this->expireTime);
        $this->assertInstanceOf(LongRunningOperationManager::class, $op);
    }

    public function testDelete()
    {
        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'deleteBackup',
            function ($args) {
                $this->assertEquals(
                    $args->getName(),
                    $this->backup->name()
                );
                return true;
            },
            null
        );

        $this->backup->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->backup->___setProperty('serializer', $this->serializer);

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

    private function getOperationResponseMock()
    {
        $operation = $this->serializer->decodeMessage(
            new \Google\LongRunning\Operation(),
            ['metadata' => [
                'typeUrl' => 'type.googleapis.com/google.spanner.admin.database.v1.CreateDatabaseMetadata'
            ]]
        );
        $operationResponse = $this->prophesize(OperationResponse::class);
        $operationResponse->getLastProtoResponse()->willReturn($operation);
        $operationResponse->isDone()->willReturn(false);
        $operationResponse->getError()->willReturn(null);
        return $operationResponse;
    }
}
