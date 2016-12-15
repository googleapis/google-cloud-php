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

namespace Google\Cloud\Tests\Spanner;

use Google\Cloud\Exception\NotFoundException;
use Google\Cloud\Iam\Iam;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminApi;
use Google\Cloud\Spanner\Connection\AdminConnectionInterface;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Prophecy\Argument;

/**
 * @group spanner
 */
class DatabaseTest extends \PHPUnit_Framework_TestCase
{
    const PROJECT_ID = 'test-project';
    const INSTANCE_NAME = 'test-instance';
    const NAME = 'test-database';

    private $adminConnection;
    private $instance;
    private $database;

    public function setUp()
    {
        $this->adminConnection = $this->prophesize(AdminConnectionInterface::class);
        $this->instance = $this->prophesize(Instance::class);
        $this->instance->name()->willReturn(self::INSTANCE_NAME);

        $this->database = new DatabaseStub(
            $this->adminConnection->reveal(),
            $this->instance->reveal(),
            self::PROJECT_ID,
            self::NAME
        );
    }

    public function testName()
    {
        $this->assertEquals(self::NAME, $this->database->name());
    }

    public function testExists()
    {
        $this->adminConnection->getDatabaseDDL(Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);

        $this->database->setAdminConnection($this->adminConnection->reveal());

        $this->assertTrue($this->database->exists());
    }

    public function testExistsNotFound()
    {
        $this->adminConnection->getDatabaseDDL(Argument::any())
            ->shouldBeCalled()
            ->willThrow(new NotFoundException('', 404));

        $this->database->setAdminConnection($this->adminConnection->reveal());

        $this->assertFalse($this->database->exists());
    }

    public function testUpdate()
    {
        $statements = ['foo', 'bar'];
        $this->adminConnection->updateDatabase([
            'name' => DatabaseAdminApi::formatDatabaseName(self::PROJECT_ID, self::INSTANCE_NAME, self::NAME),
            'statements' => $statements
        ]);

        $this->database->setAdminConnection($this->adminConnection->reveal());

        $this->database->update($statements);
    }

    public function testUpdateWithSingleStatement()
    {
        $statement = 'foo';
        $this->adminConnection->updateDatabase([
            'name' => DatabaseAdminApi::formatDatabaseName(self::PROJECT_ID, self::INSTANCE_NAME, self::NAME),
            'statements' => ['foo'],
            'operationId' => null,
        ])->shouldBeCalled();

        $this->database->setAdminConnection($this->adminConnection->reveal());

        $this->database->update($statement);
    }

    public function testDrop()
    {
        $this->adminConnection->dropDatabase([
            'name' => DatabaseAdminApi::formatDatabaseName(self::PROJECT_ID, self::INSTANCE_NAME, self::NAME)
        ])->shouldBeCalled();

        $this->database->setAdminConnection($this->adminConnection->reveal());

        $this->database->drop();
    }

    public function testDdl()
    {
        $ddl = ['create table users', 'create table posts'];
        $this->adminConnection->getDatabaseDDL([
            'name' => DatabaseAdminApi::formatDatabaseName(self::PROJECT_ID, self::INSTANCE_NAME, self::NAME)
        ])->willReturn(['statements' => $ddl]);

        $this->database->setAdminConnection($this->adminConnection->reveal());

        $this->assertEquals($ddl, $this->database->ddl());
    }

    public function testDdlNoResult()
    {
        $this->adminConnection->getDatabaseDDL([
            'name' => DatabaseAdminApi::formatDatabaseName(self::PROJECT_ID, self::INSTANCE_NAME, self::NAME)
        ])->willReturn([]);

        $this->database->setAdminConnection($this->adminConnection->reveal());

        $this->assertEquals([], $this->database->ddl());
    }

    public function testIam()
    {
        $this->assertInstanceOf(Iam::class, $this->database->iam());
    }
}

class DatabaseStub extends Database
{
    public function setAdminConnection($conn)
    {
        $this->adminConnection = $conn;
    }
}
