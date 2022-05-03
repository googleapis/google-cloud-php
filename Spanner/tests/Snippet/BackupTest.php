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

use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Backup;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\SpannerClient;
use Prophecy\Argument;

 /**
 * @group spanner
 * @group spanner-backup
 */
class BackupTest extends SnippetTestCase
{
    use GrpcTestTrait;

    const PROJECT = 'my-awesome-project';
    const INSTANCE = 'my-instance';
    const DATABASE = 'my-database';
    const BACKUP = 'my-backup';

    private $connection;
    private $backup;
    private $client;
    private $instance;
    private $expireTime;

    public function set_up()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = TestHelpers::stub(SpannerClient::class);
        $this->expireTime = new \DateTime("+ 7 hours");
        $this->instance = TestHelpers::stub(Instance::class, [
            $this->connection->reveal(),
            $this->prophesize(LongRunningConnectionInterface::class)->reveal(),
            [],
            self::PROJECT,
            self::INSTANCE
        ], ['connection', 'lroConnection']);

        $this->backup = TestHelpers::stub(Backup::class, [
            $this->connection->reveal(),
            $this->instance,
            $this->prophesize(LongRunningConnectionInterface::class)->reveal(),
            [],
            self::PROJECT,
            self::BACKUP,
        ], ['instance', 'connection', 'lroConnection']);
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

        $this->connection->createBackup(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'my-operation'
            ]);

        $this->backup->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal());
    }

    public function testCreateCopy()
    {
        $snippet = $this->snippetFromMethod(Backup::class, 'createCopy');
        $snippet->addLocal('spanner', $this->client);

        $this->connection->copyBackup(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'my-operation'
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal());
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Backup::class, 'delete');
        $snippet->addLocal('backup', $this->backup);

        $this->connection->deleteBackup(Argument::any())
            ->shouldBeCalled();

        $this->backup->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(Backup::class, 'exists');
        $snippet->addLocal('backup', $this->backup);

        $this->connection->getBackup(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['foo' => 'bar']);

        $this->backup->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Backup exists!', $res->output());
    }

    public function testInfo()
    {
        $backup = ['name' => 'foo'];

        $snippet = $this->snippetFromMethod(Backup::class, 'info');
        $snippet->addLocal('backup', $this->backup);

        $this->connection->getBackup(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn($backup);

        $this->backup->___setProperty('connection', $this->connection->reveal());

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

        $this->connection->getBackup(Argument::any())
            ->shouldBeCalledTimes(2)
            ->willReturn($bkp);

        $this->backup->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('info');
        $this->assertEquals($bkp, $res->returnVal());
        $snippet->invoke();
    }

    public function testState()
    {
        $snippet = $this->snippetFromMethod(Backup::class, 'state');
        $snippet->addLocal('backup', $this->backup);

        $this->connection->getBackup(Argument::any())
            ->shouldBeCalledTimes(1)
            ->WillReturn(['state' => Backup::STATE_READY]);

        $this->backup->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Backup is ready!', $res->output());
    }

    public function testUpdateExpireTime()
    {
        $bkp = ['name' => 'foo', 'expireTime' => $this->expireTime->format('Y-m-d\TH:i:s.u\Z')];

        $snippet = $this->snippetFromMethod(Backup::class, 'updateExpireTime');
        $snippet->addLocal('backup', $this->backup);

        $this->connection->updateBackup(Argument::any())
            ->shouldBeCalled()
            ->willReturn($bkp);

        $this->backup->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('info');
        $this->assertEquals($bkp, $res->returnVal());
    }

    public function testResumeOperation()
    {
        $snippet = $this->snippetFromMagicMethod(Backup::class, 'resumeOperation');
        $snippet->addLocal('backup', $this->backup);
        $snippet->addLocal('operationName', 'foo');

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal());
        $this->assertEquals('foo', $res->returnVal()->name());
    }

    public function testLongRunningOperations()
    {
        $snippet = $this->snippetFromMethod(Backup::class, 'longRunningOperations');
        $snippet->addLocal('backup', $this->backup);

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

        $this->backup->___setProperty('lroConnection', $lroConnection->reveal());

        $res = $snippet->invoke('operations');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertContainsOnlyInstancesOf(LongRunningOperation::class, $res->returnVal());
    }
}
