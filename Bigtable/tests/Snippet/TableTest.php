<?php
/*
 * Copyright 2018, Google LLC All rights reserved.
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
namespace Google\Cloud\Bigtable\Tests\Snippet;

use Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient as TableAdminClient;
use Google\Cloud\Bigtable\Connection\ConnectionInterface;
use Google\Cloud\Bigtable\Instance;
use Google\Cloud\Bigtable\Table;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Prophecy\Argument;

/**
 * @group bigtable
 * @group bigtableadmin
 */
class TableTest extends SnippetTestCase
{
    use GrpcTestTrait;

    const PROJECT_ID = 'my-awesome-project';
    const INSTANCE_ID = 'my-instance';
    const INSTANCE_NAME = 'projects/my-awesome-project/instances/my-instance';
    const TABLE_ID = 'my-table';
    const TABLE_NAME = 'projects/my-awesome-project/instances/my-instance/tables/my-table';

    private $connection;
    private $instance;
    private $table;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->instance = TestHelpers::stub(Instance::class, [
            $this->connection->reveal(),
            $this->prophesize(LongRunningConnectionInterface::class)->reveal(),
            [],
            self::PROJECT_ID,
            self::INSTANCE_ID
        ]);
        $this->table = TestHelpers::stub(Table::class, [
            $this->connection->reveal(),
            $this->prophesize(LongRunningConnectionInterface::class)->reveal(),
            [],
            self::PROJECT_ID,
            self::INSTANCE_ID,
            self::TABLE_ID
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Table::class);
        $snippet->addLocal('instance', $this->instance);
        $res = $snippet->invoke('table');

        $this->assertInstanceOf(Table::class, $res->returnVal());
        $this->assertEquals(self::TABLE_NAME, $res->returnVal()->name());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(Table::class, 'name');
        $snippet->addLocal('table', $this->table);

        $res = $snippet->invoke('name');
        $this->assertEquals(self::TABLE_NAME, $res->returnVal());
    }

    public function testId()
    {
        $snippet = $this->snippetFromMethod(Table::class, 'id');
        $snippet->addLocal('table', $this->table);

        $res = $snippet->invoke('tableId');
        $this->assertEquals(self::TABLE_ID, $res->returnVal());
    }

    public function testCreate()
    {

        $snippet = $this->snippetFromMethod(Table::class, 'create');
        $snippet->addUse(Table::class);
        $snippet->addLocal('table', $this->table);

        $this->connection->createTable(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['name' => self::TABLE_ID]);

        $this->table->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('tableInfo');
        $this->assertEquals(self::TABLE_ID, $res->returnVal()['name']);
    }

    public function testResumeOperation()
    {
        $snippet = $this->snippetFromMagicMethod(Table::class, 'resumeOperation');
        $snippet->addLocal('table', $this->table);
        $snippet->addLocal('operationName', 'foo');

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal());
        $this->assertEquals('foo', $res->returnVal()->name());
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Table::class, 'delete');
        $snippet->addUse(Table::class);
        $snippet->addLocal('table', $this->table);

        $this->connection->deleteTable(Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);

        $this->table->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals(null, $res->returnVal());
    }

    public function testAddColumnFamilys()
    {
        $snippet = $this->snippetFromMethod(Table::class, 'addColumnFamilys');
        $snippet->addUse(Table::class);
        $snippet->addLocal('table', $this->table);

        $this->connection->modifyColumnFamilies(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['name' => self::TABLE_ID]);

        $this->table->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('tableInfo');
        $this->assertEquals(self::TABLE_ID, $res->returnVal()['name']);
    }

    public function testDropColumnFamilys()
    {
        $snippet = $this->snippetFromMethod(Table::class, 'dropColumnFamilys');
        $snippet->addUse(Table::class);
        $snippet->addLocal('table', $this->table);

        $this->connection->modifyColumnFamilies(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['name' => self::TABLE_ID]);

        $this->table->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('tableInfo');
        $this->assertEquals(self::TABLE_ID, $res->returnVal()['name']);
    }
}
