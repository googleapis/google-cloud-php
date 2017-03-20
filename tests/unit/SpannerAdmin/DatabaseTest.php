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

namespace Google\Cloud\Tests\Unit\SpannerAdmin;

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Prophecy\Argument;

/**
 * @group spanneradmin
 */
class DatabaseTest extends \PHPUnit_Framework_TestCase
{
    const PROJECT_ID = 'test-project';
    const INSTANCE_NAME = 'test-instance';
    const NAME = 'test-database';

    private $connection;
    private $instance;
    private $database;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->instance = $this->prophesize(Instance::class);
        $this->instance->name()->willReturn(self::INSTANCE_NAME);

        $this->database = \Google\Cloud\Dev\stub(Database::class, [
            $this->connection->reveal(),
            $this->instance->reveal(),
            $this->prophesize(SessionPoolInterface::class)->reveal(),
            $this->prophesize(LongRunningConnectionInterface::class)->reveal(),
            [],
            self::PROJECT_ID,
            self::NAME
        ]);
    }

    public function testName()
    {
        $this->assertEquals(self::NAME, $this->database->name());
    }

    public function testExists()
    {
        $this->connection->getDatabaseDDL(Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $this->assertTrue($this->database->exists());
    }

    public function testExistsNotFound()
    {
        $this->connection->getDatabaseDDL(Argument::any())
            ->shouldBeCalled()
            ->willThrow(new NotFoundException('', 404));

        $this->database->___setProperty('connection', $this->connection->reveal());

        $this->assertFalse($this->database->exists());
    }

    public function testUpdateDdl()
    {
        $statement = 'foo';
        $this->connection->updateDatabase([
            'name' => DatabaseAdminClient::formatDatabaseName(self::PROJECT_ID, self::INSTANCE_NAME, self::NAME),
            'statements' => [$statement]
        ]);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $this->database->updateDdl($statement);
    }

    public function testUpdateDdlBatch()
    {
        $statements = ['foo', 'bar'];
        $this->connection->updateDatabase([
            'name' => DatabaseAdminClient::formatDatabaseName(self::PROJECT_ID, self::INSTANCE_NAME, self::NAME),
            'statements' => $statements
        ]);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $this->database->updateDdl($statements);
    }

    public function testUpdateWithSingleStatement()
    {
        $statement = 'foo';
        $this->connection->updateDatabase([
            'name' => DatabaseAdminClient::formatDatabaseName(self::PROJECT_ID, self::INSTANCE_NAME, self::NAME),
            'statements' => ['foo']
        ])->shouldBeCalled()->willReturn(['name' => 'operations/foo']);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $res = $this->database->updateDdl($statement);
        $this->assertInstanceOf(LongRunningOperation::class, $res);
    }

    public function testDrop()
    {
        $this->connection->dropDatabase([
            'name' => DatabaseAdminClient::formatDatabaseName(self::PROJECT_ID, self::INSTANCE_NAME, self::NAME)
        ])->shouldBeCalled();

        $this->database->___setProperty('connection', $this->connection->reveal());

        $this->database->drop();
    }

    public function testDdl()
    {
        $ddl = ['create table users', 'create table posts'];
        $this->connection->getDatabaseDDL([
            'name' => DatabaseAdminClient::formatDatabaseName(self::PROJECT_ID, self::INSTANCE_NAME, self::NAME)
        ])->willReturn(['statements' => $ddl]);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $this->assertEquals($ddl, $this->database->ddl());
    }

    public function testDdlNoResult()
    {
        $this->connection->getDatabaseDDL([
            'name' => DatabaseAdminClient::formatDatabaseName(self::PROJECT_ID, self::INSTANCE_NAME, self::NAME)
        ])->willReturn([]);

        $this->database->___setProperty('connection', $this->connection->reveal());

        $this->assertEquals([], $this->database->ddl());
    }

    public function testIam()
    {
        $this->assertInstanceOf(Iam::class, $this->database->iam());
    }
}
