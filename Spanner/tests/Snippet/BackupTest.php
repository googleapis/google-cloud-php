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

namespace Google\Cloud\Spanner\Tests\Snippet;

use Google\LongRunning\Client\OperationsClient;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\LongRunning\LongRunningOperationManager;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Backup;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\SpannerClient;
use Google\Cloud\Spanner\Tests\RequestHandlingTestTrait;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

 /**
 * @group spanner
 * @group spanner-backup
 */
class BackupTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;
    use RequestHandlingTestTrait;

    const PROJECT = 'my-awesome-project';
    const INSTANCE = 'my-instance';
    const DATABASE = 'my-database';
    const BACKUP = 'my-backup';

    private $requestHandler;
    private $serializer;
    private $backup;
    private $client;
    private $instance;
    private $expireTime;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->requestHandler = $this->getRequestHandlerStub();
        $this->serializer = $this->getSerializer();
        $this->client = TestHelpers::stub(
            SpannerClient::class,
            ['projectId' => 'my-project'],
            ['requestHandler', 'serializer']
        );
        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->client->___setProperty('serializer', $this->serializer);
        $this->expireTime = new \DateTime("+ 7 hours");
        $this->instance = TestHelpers::stub(Instance::class, [
            $this->requestHandler->reveal(),
            $this->serializer,
            [],
            self::PROJECT,
            self::INSTANCE
        ], ['requestHandler', 'serializer']);

        $this->backup = TestHelpers::stub(Backup::class, [
            $this->requestHandler->reveal(),
            $this->serializer,
            $this->instance,
            [],
            self::PROJECT,
            self::BACKUP,
        ], ['instance', 'requestHandler', 'serializer']);
    }

    public function testClass()
    {
        if (!extension_loaded('grpc')) {
            $this->markTestSkipped('Must have the grpc extension installed to run this test.');
        }

        $snippet = $this->snippetFromClass(Backup::class);
        $res = $snippet->invoke('backup');
        $this->assertInstanceOf(Backup::class, $res->returnVal());
        $this->assertEquals(self::BACKUP, DatabaseAdminClient::parseName($res->returnVal()->name())['backup']);
    }

    public function testCreate()
    {
        $snippet = $this->snippetFromMethod(Backup::class, 'create');
        $snippet->addLocal('backup', $this->backup);

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'createBackup',
            null,
            $this->getOperationResponseMock()
        );

        $this->backup->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->backup->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperationManager::class, $res->returnVal());
    }

    public function testCreateCopy()
    {
        $snippet = $this->snippetFromMethod(Backup::class, 'createCopy');
        $snippet->addLocal('spanner', $this->client);

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'copyBackup',
            null,
            $this->getOperationResponseMock()
        );

        $this->backup->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->backup->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperationManager::class, $res->returnVal());
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Backup::class, 'delete');
        $snippet->addLocal('backup', $this->backup);

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'deleteBackup',
            null,
            null
        );

        $this->backup->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->backup->___setProperty('serializer', $this->serializer);

        $snippet->invoke();
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(Backup::class, 'exists');
        $snippet->addLocal('backup', $this->backup);

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'getBackup',
            null,
            ['foo' => 'bar']
        );

        $this->backup->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->backup->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke();
        $this->assertEquals('Backup exists!', $res->output());
    }

    public function testInfo()
    {
        $backup = ['name' => 'foo'];

        $snippet = $this->snippetFromMethod(Backup::class, 'info');
        $snippet->addLocal('backup', $this->backup);

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'getBackup',
            null,
            $backup
        );

        $this->backup->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->backup->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke('info');
        $this->assertEquals($backup, $res->returnVal());
        $snippet->invoke();
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(Backup::class, 'name');
        $snippet->addLocal('backup', $this->backup);

        $res = $snippet->invoke('name');
        $this->assertEquals(
            DatabaseAdminClient::backupName(self::PROJECT, self::INSTANCE, self::BACKUP),
            $res->returnVal()
        );
    }

    public function testReload()
    {
        $bkp = ['name' => 'foo'];

        $snippet = $this->snippetFromMethod(Backup::class, 'reload');
        $snippet->addLocal('backup', $this->backup);

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'getBackup',
            null,
            $bkp,
            2
        );

        $this->backup->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->backup->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke('info');
        $this->assertEquals($bkp, $res->returnVal());
        $snippet->invoke();
    }

    public function testState()
    {
        $snippet = $this->snippetFromMethod(Backup::class, 'state');
        $snippet->addLocal('backup', $this->backup);

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'getBackup',
            null,
            ['state' => Backup::STATE_READY]
        );

        $this->backup->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->backup->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke();
        $this->assertEquals('Backup is ready!', $res->output());
    }

    public function testUpdateExpireTime()
    {
        $bkp = ['name' => 'foo', 'expireTime' => $this->expireTime->format('Y-m-d\TH:i:s.u\Z')];

        $snippet = $this->snippetFromMethod(Backup::class, 'updateExpireTime');
        $snippet->addLocal('backup', $this->backup);

        $this->mockSendRequest(
            DatabaseAdminClient::class,
            'updateBackup',
            null,
            $bkp
        );

        $this->backup->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->backup->___setProperty('serializer', $this->serializer);
        

        $res = $snippet->invoke('info');
        $this->assertEquals($bkp, $res->returnVal());
    }

    public function testResumeOperation()
    {
        $snippet = $this->snippetFromMagicMethod(Backup::class, 'resumeOperation');
        $snippet->addLocal('backup', $this->backup);
        $snippet->addLocal('operationName', 'foo');

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperationManager::class, $res->returnVal());
        $this->assertEquals('foo', $res->returnVal()->name());
    }

    public function testLongRunningOperations()
    {
        $snippet = $this->snippetFromMethod(Backup::class, 'longRunningOperations');
        $snippet->addLocal('backup', $this->backup);

        $this->requestHandler
            ->getClientObject(Argument::any())
            ->willReturn(new DatabaseAdminClient());
        $this->requestHandler
            ->addClientObject(Argument::any(), Argument::any())
            ->willReturn(null);
        $this->mockSendRequest(
            OperationsClient::class,
            'listOperations',
            null,
            [$this->getOperationResponseMock()]
        );

        $this->backup->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->backup->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke('operations');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertContainsOnlyInstancesOf(LongRunningOperationManager::class, $res->returnVal());
    }
}
