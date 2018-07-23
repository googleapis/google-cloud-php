<?php
/**
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
namespace Google\Cloud\Bigtable\Tests\Unit;

use Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient as TableAdminClient;
use Google\Cloud\Bigtable\Connection\ConnectionInterface;
use Google\Cloud\Bigtable\Table;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group bigtable
 * @group bigtableadmin
 */
class TableTest extends TestCase
{
    use GrpcTestTrait;

    const PROJECT_ID = 'my-awesome-project';
    const INSTANCE_ID = 'my-instance';
    const INSTANCE_NAME = 'projects/my-awesome-project/instances/my-instance';
    const TABLE_ID = 'my-table';
    const TABLE_NAME = 'projects/my-awesome-project/instances/my-instance/tables/my-table';

    private $connection;
    private $table;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->table = TestHelpers::stub(table::class, [
            $this->connection->reveal(),
            $this->prophesize(LongRunningConnectionInterface::class)->reveal(),
            [],
            self::PROJECT_ID,
            self::INSTANCE_ID,
            self::TABLE_ID
        ], [
            'info',
            'connection'
        ]);
    }

    public function testName()
    {
        $this->assertEquals(self::TABLE_NAME, $this->table->name());
    }

    public function testId()
    {
        $this->assertEquals(self::TABLE_ID, $this->table->id());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Please pass the table id, rather than the fully-qualified resource name.
     */
    public function testTableWhenBadIdFormatPassed()
    {
        $badTableId = 'badformat/my-table';
        $table = TestHelpers::stub(table::class, [
            $this->connection->reveal(),
            $this->prophesize(LongRunningConnectionInterface::class)->reveal(),
            [],
            self::PROJECT_ID,
            self::INSTANCE_ID,
            $badTableId
        ], [
            'info',
            'connection'
        ]);
    }

    public function testTableId()
    {
        $tableId = TableAdminClient::parseName($this->table->name())['table'];
        $this->assertEquals($this->table->id(), $tableId);
    }

    public function testCreate()
    {
        $args = [
            'parent' => self::INSTANCE_NAME,
            'tableId' => self::TABLE_ID,
        ];
        $this->connection->createTable($args)
            ->shouldBeCalled()
            ->willReturn([
                'name' => self::TABLE_NAME
            ]);
        $this->table->___setProperty('connection', $this->connection->reveal());

        $tableInfo = $this->table->create();
        $this->assertEquals(self::TABLE_NAME, $tableInfo['name']);
    }

    public function testDelete()
    {
        $args = [
            'name' => self::TABLE_NAME,
        ];
        $this->connection->deleteTable($args)
            ->shouldBeCalled()
            ->willReturn([]);
        $this->table->___setProperty('connection', $this->connection->reveal());

        $info = $this->table->delete();
        $this->assertEquals([], $info);
    }
}
