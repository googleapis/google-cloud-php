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

namespace Google\Cloud\Tests\Unit\Spanner;

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Configuration;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Tests\GrpcTestTrait;
use Prophecy\Argument;

/**
 * @group spanner
 * @group spanneradmin
 */
class InstanceTest extends \PHPUnit_Framework_TestCase
{
    use GrpcTestTrait;

    const PROJECT_ID = 'test-project';
    const NAME = 'instance-name';

    private $connection;
    private $instance;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->instance = \Google\Cloud\Dev\stub(Instance::class, [
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
        $this->assertEquals(self::NAME, InstanceAdminClient::parseInstanceFromInstanceName($this->instance->name()));
    }

    public function testInfo()
    {
        $this->connection->getInstance()->shouldNotBeCalled();

        $this->instance->___setProperty('info', ['foo' => 'bar']);
        $this->assertEquals('bar', $this->instance->info()['foo']);
    }

    public function testInfoWithReload()
    {
        $instance = $this->getDefaultInstance();

        $this->connection->getInstance(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn($instance);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $info = $this->instance->info();
        $this->assertEquals('Instance Name', $info['displayName']);

        $this->assertEquals($info, $this->instance->info());
    }

    public function testExists()
    {
        $this->connection->getInstance(Argument::any())->shouldBeCalled()->willReturn([]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $this->assertTrue($this->instance->exists());
    }

    public function testExistsNotFound()
    {
        $this->connection->getInstance(Argument::any())
            ->shouldBeCalled()
            ->willThrow(new NotFoundException('foo', 404));

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $this->assertFalse($this->instance->exists());
    }

    public function testReload()
    {
        $instance = $this->getDefaultInstance();

        $this->connection->getInstance(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn($instance);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $info = $this->instance->reload();

        $this->assertEquals('Instance Name', $info['displayName']);
    }

    public function testState()
    {
        $instance = $this->getDefaultInstance();

        $this->connection->getInstance(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn($instance);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $this->assertEquals(Instance::STATE_READY, $this->instance->state());
    }

    public function testStateIsNull()
    {
        $this->connection->getInstance(Argument::any())
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
            'name' => InstanceAdminClient::formatInstanceName(self::PROJECT_ID, self::NAME)
        ])->shouldBeCalled();

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $this->instance->delete();
    }

    public function testCreateDatabase()
    {
        $extra = ['foo', 'bar'];

        $this->connection->createDatabase([
            'instance' => InstanceAdminClient::formatInstanceName(self::PROJECT_ID, self::NAME),
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

    public function testDatabase()
    {
        $database = $this->instance->database('test-database');
        $this->assertInstanceOf(Database::class, $database);
        $this->assertEquals('test-database', DatabaseAdminClient::parseDatabaseFromDatabaseName($database->name()));
    }

    public function testDatabases()
    {
        $databases = [
            ['name' => DatabaseAdminClient::formatDatabaseName(self::PROJECT_ID, self::NAME, 'database1')],
            ['name' => DatabaseAdminClient::formatDatabaseName(self::PROJECT_ID, self::NAME, 'database2')]
        ];

        $this->connection->listDatabases(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['databases' => $databases]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $dbs = $this->instance->databases();

        $this->assertInstanceOf(ItemIterator::class, $dbs);

        $dbs = iterator_to_array($dbs);

        $this->assertEquals(2, count($dbs));
        $this->assertEquals('database1', DatabaseAdminClient::parseDatabaseFromDatabaseName($dbs[0]->name()));
        $this->assertEquals('database2', DatabaseAdminClient::parseDatabaseFromDatabaseName($dbs[1]->name()));
    }

    public function testDatabasesPaged()
    {
        $databases = [
            ['name' => DatabaseAdminClient::formatDatabaseName(self::PROJECT_ID, self::NAME, 'database1')],
            ['name' => DatabaseAdminClient::formatDatabaseName(self::PROJECT_ID, self::NAME, 'database2')]
        ];

        $iteration = 0;
        $this->connection->listDatabases(Argument::any())
            ->shouldBeCalledTimes(2)
            ->willReturn(['databases' => [$databases[0]], 'nextPageToken' => 'foo'], ['databases' => [$databases[1]]]);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $dbs = $this->instance->databases();

        $this->assertInstanceOf(ItemIterator::class, $dbs);

        $dbs = iterator_to_array($dbs);

        $this->assertEquals(2, count($dbs));
        $this->assertEquals('database1', DatabaseAdminClient::parseDatabaseFromDatabaseName($dbs[0]->name()));
        $this->assertEquals('database2', DatabaseAdminClient::parseDatabaseFromDatabaseName($dbs[1]->name()));
    }

    public function testIam()
    {
        $this->assertInstanceOf(Iam::class, $this->instance->iam());
    }

    // ************** //

    private function getDefaultInstance()
    {
        return json_decode(file_get_contents(__DIR__ .'/../fixtures/spanner/instance.json'), true);
    }
}
