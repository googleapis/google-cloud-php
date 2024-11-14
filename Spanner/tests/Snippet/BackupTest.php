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

use Google\ApiCore\OperationResponse;
use Google\ApiCore\Page;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Serializer;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Database\V1\CreateBackupRequest;
use Google\Cloud\Spanner\Admin\Database\V1\DeleteBackupRequest;
use Google\Cloud\Spanner\Admin\Database\V1\GetBackupRequest;
use Google\Cloud\Spanner\Admin\Database\V1\Backup as BackupProto;
use Google\Cloud\Spanner\Admin\Database\V1\ListBackupsRequest;
use Google\Cloud\Spanner\Admin\Database\V1\UpdateBackupRequest;
use Google\Cloud\Spanner\Admin\Database\V1\CopyBackupRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Backup;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\SpannerClient;
use Google\LongRunning\Client\OperationsClient;
use Google\LongRunning\ListOperationsRequest;
use Google\LongRunning\ListOperationsResponse;
use Google\LongRunning\Operation;
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

    const PROJECT = 'my-awesome-project';
    const INSTANCE = 'my-instance';
    const DATABASE = 'my-database';
    const BACKUP = 'my-backup';

    private $serializer;
    private $backup;
    private $spanner;
    private $instance;
    private $expireTime;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->databaseAdminClient = $this->prophesize(DatabaseAdminClient::class);

        $this->serializer = new Serializer();
        $this->spanner = new SpannerClient(['projectId' => 'my-project']);
        $this->expireTime = new \DateTime('+ 7 hours');
        $database = $this->prophesize(Database::class);
        $database->name()->willReturn(DatabaseAdminClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE));
        $instance = $this->prophesize(Instance::class);
        $instance->name()->willReturn(InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE));
        $instance->database('my-database')->willReturn($database->reveal());

        $this->backup = new Backup(
            $this->databaseAdminClient->reveal(),
            $this->serializer,
            $instance->reveal(),
            self::PROJECT,
            self::BACKUP
        );
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

        $this->databaseAdminClient->createBackup(
            Argument::type(CreateBackupRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->prophesize(OperationResponse::class)->reveal());

        $res = $snippet->invoke('operation');
        // $this->assertInstanceOf(OperationResponse::class, $res->returnVal());
    }

    // public function testCreateCopy()
    // {
    //     $snippet = $this->snippetFromMethod(Backup::class, 'createCopy');
    //     $snippet->addLocal('spanner', $this->spanner);

    //     $this->databaseAdminClient->copyBackup(
    //         Argument::type(CopyBackupRequest::class),
    //         Argument::type('array')
    //     )
    //         ->shouldBeCalledOnce()
    //         ->willReturn($this->prophesize(OperationResponse::class)->reveal());


    //     $res = $snippet->invoke('operation');
    //     $this->assertInstanceOf(OperationResponse::class, $res->returnVal());
    // }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Backup::class, 'delete');
        $snippet->addLocal('backup', $this->backup);

        $this->databaseAdminClient->deleteBackup(
            Argument::type(DeleteBackupRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce();


        $snippet->invoke();
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(Backup::class, 'exists');
        $snippet->addLocal('backup', $this->backup);

        $this->databaseAdminClient->getBackup(
            Argument::type(GetBackupRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new BackupProto());

        $res = $snippet->invoke();
        $this->assertEquals('Backup exists!', $res->output());
    }

    public function testInfo()
    {
        $backup = ['name' => 'foo'];

        $snippet = $this->snippetFromMethod(Backup::class, 'info');
        $snippet->addLocal('backup', $this->backup);

        $this->databaseAdminClient->getBackup(
            Argument::type(GetBackupRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new BackupProto($backup));


        $res = $snippet->invoke('info');
        $this->assertEquals($backup['name'], $res->returnVal()['name']);
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
        $backup = ['name' => 'foo'];

        $snippet = $this->snippetFromMethod(Backup::class, 'reload');
        $snippet->addLocal('backup', $this->backup);

        $this->databaseAdminClient->getBackup(
            Argument::type(GetBackupRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledTimes(2)
            ->willReturn(new BackupProto($backup));


        $res = $snippet->invoke('info');
        $this->assertEquals($backup['name'], $res->returnVal()['name']);
        $snippet->invoke();
    }

    public function testState()
    {
        $snippet = $this->snippetFromMethod(Backup::class, 'state');
        $snippet->addLocal('backup', $this->backup);

        $this->databaseAdminClient->getBackup(
            Argument::type(GetBackupRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new BackupProto(['state' => Backup::STATE_READY]));


        $res = $snippet->invoke();
        $this->assertEquals('Backup is ready!', $res->output());
    }

    public function testUpdateExpireTime()
    {
        $backup = [
            'name' => 'foo',
            'expire_time' => new \Google\Protobuf\Timestamp(['seconds' => $this->expireTime->format('U')])
        ];

        $snippet = $this->snippetFromMethod(Backup::class, 'updateExpireTime');
        $snippet->addLocal('backup', $this->backup);

        $this->databaseAdminClient->updateBackup(
            Argument::type(UpdateBackupRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new BackupProto($backup));


        $res = $snippet->invoke('info');
        $this->assertEquals($backup['name'], $res->returnVal()['name']);
        $this->assertEquals(
            $this->expireTime->format('Y-m-d\TH:i:s.000000\Z'),
            $res->returnVal()['expireTime']
        );
    }

    public function testResumeOperation()
    {
        $snippet = $this->snippetFromMagicMethod(Backup::class, 'resumeOperation');
        $snippet->addLocal('spanner', $this->spanner);
        $snippet->addLocal('backup', $this->backup);
        $snippet->addLocal('operationName', 'foo');

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(OperationResponse::class, $res->returnVal());
        $this->assertEquals('foo', $res->returnVal()->getName());
    }

    public function testLongRunningOperations()
    {
        $snippet = $this->snippetFromMethod(Backup::class, 'longRunningOperations');
        $snippet->addLocal('backup', $this->backup);

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
        $operationsClient->listOperations(
            Argument::type(ListOperationsRequest::class),
            Argument::type('array')
        )
            ->willReturn($pagedListResponse->reveal());

        $this->databaseAdminClient->getOperationsClient()
            ->shouldBeCalled()
            ->willReturn($operationsClient->reveal());

        $res = $snippet->invoke('operations');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertContainsOnlyInstancesOf(OperationResponse::class, $res->returnVal());
    }
}
