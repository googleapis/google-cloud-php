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

use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Duration;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\ValueMapper;
use Prophecy\Argument;

/**
 * @group spanner
 */
class DatabaseTest extends \PHPUnit_Framework_TestCase
{
    const PROJECT = 'my-awesome-project';
    const DATABASE = 'my-database';
    const INSTANCE = 'my-instance';
    const SESSION = 'my-session';
    const TRANSACTION = 'my-transaction';

    private $connection;
    private $instance;
    private $sessionPool;
    private $database;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->instance = $this->prophesize(Instance::class);
        $this->sessionPool = $this->prophesize(SessionPoolInterface::class);
        $this->sessionPool->session(self::INSTANCE, self::DATABASE, Argument::any())
            ->willReturn(new Session(
                $this->connection->reveal(),
                self::PROJECT,
                self::INSTANCE,
                self::DATABASE,
                self::SESSION
            ));

        $this->instance->name()->willReturn(self::INSTANCE);

        $args = [
            $this->connection->reveal(),
            $this->instance->reveal(),
            $this->sessionPool->reveal(),
            self::PROJECT,
            self::DATABASE,
        ];

        $props = [
            'connection', 'operation'
        ];

        $this->database = \Google\Cloud\Dev\stub(Database::class, $args, $props);
    }

    public function testInsert()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][OPERATION::OP_INSERT]['table'] !== $table) return false;
            if ($arg['mutations'][0][OPERATION::OP_INSERT]['columns'][0] !== array_keys($row)[0]) return false;
            if ($arg['mutations'][0][OPERATION::OP_INSERT]['values'][0] !== current($row)) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation();

        $res = $this->database->insert($table, $row);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testInsertBatch()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][OPERATION::OP_INSERT]['table'] !== $table) return false;
            if ($arg['mutations'][0][OPERATION::OP_INSERT]['columns'][0] !== array_keys($row)[0]) return false;
            if ($arg['mutations'][0][OPERATION::OP_INSERT]['values'][0] !== current($row)) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation();

        $res = $this->database->insertBatch($table, [$row]);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testUpdate()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][Operation::OP_UPDATE]['table'] !== $table) return false;
            if ($arg['mutations'][0][Operation::OP_UPDATE]['columns'][0] !== array_keys($row)[0]) return false;
            if ($arg['mutations'][0][Operation::OP_UPDATE]['values'][0] !== current($row)) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation();

        $res = $this->database->update($table, $row);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testUpdateBatch()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][Operation::OP_UPDATE]['table'] !== $table) return false;
            if ($arg['mutations'][0][Operation::OP_UPDATE]['columns'][0] !== array_keys($row)[0]) return false;
            if ($arg['mutations'][0][Operation::OP_UPDATE]['values'][0] !== current($row)) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation();

        $res = $this->database->updateBatch($table, [$row]);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testInsertOrUpdate()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][Operation::OP_INSERT_OR_UPDATE]['table'] !== $table) return false;
            if ($arg['mutations'][0][Operation::OP_INSERT_OR_UPDATE]['columns'][0] !== array_keys($row)[0]) return false;
            if ($arg['mutations'][0][Operation::OP_INSERT_OR_UPDATE]['values'][0] !== current($row)) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation();

        $res = $this->database->insertOrUpdate($table, $row);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testInsertOrUpdateBatch()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][Operation::OP_INSERT_OR_UPDATE]['table'] !== $table) return false;
            if ($arg['mutations'][0][Operation::OP_INSERT_OR_UPDATE]['columns'][0] !== array_keys($row)[0]) return false;
            if ($arg['mutations'][0][Operation::OP_INSERT_OR_UPDATE]['values'][0] !== current($row)) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation();

        $res = $this->database->insertOrUpdateBatch($table, [$row]);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testReplace()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][Operation::OP_REPLACE]['table'] !== $table) return false;
            if ($arg['mutations'][0][Operation::OP_REPLACE]['columns'][0] !== array_keys($row)[0]) return false;
            if ($arg['mutations'][0][Operation::OP_REPLACE]['values'][0] !== current($row)) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation();

        $res = $this->database->replace($table, $row);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testReplaceBatch()
    {
        $table = 'foo';
        $row = ['col' => 'val'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $row) {
            if ($arg['mutations'][0][Operation::OP_REPLACE]['table'] !== $table) return false;
            if ($arg['mutations'][0][Operation::OP_REPLACE]['columns'][0] !== array_keys($row)[0]) return false;
            if ($arg['mutations'][0][Operation::OP_REPLACE]['values'][0] !== current($row)) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation();

        $res = $this->database->replaceBatch($table, [$row]);
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testDelete()
    {
        $table = 'foo';
        $keys = [10, 'bar'];

        $this->connection->commit(Argument::that(function ($arg) use ($table, $keys) {
            if ($arg['mutations'][0][Operation::OP_DELETE]['table'] !== $table) return false;
            if ($arg['mutations'][0][Operation::OP_DELETE]['keySet']['keys'][0] !== (string) $keys[0]) return false;
            if ($arg['mutations'][0][Operation::OP_DELETE]['keySet']['keys'][1] !== $keys[1]) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation();

        $res = $this->database->delete($table, new KeySet(['keys' => $keys]));
        $this->assertInstanceOf(Timestamp::class, $res);
        $this->assertTimestampIsCorrect($res);
    }

    public function testExecute()
    {
        $sql = 'SELECT * FROM Table';

        $this->connection->executeSql(Argument::that(function ($arg) use ($sql) {
            if ($arg['sql'] !== $sql) return false;

            return true;
        }))->shouldBeCalled()->willReturn([
            'metadata' => [
                'rowType' => [
                    'fields' => [
                        [
                            'name' => 'ID',
                            'type' => [
                                'code' => ValueMapper::TYPE_INT64
                            ]
                        ]
                    ]
                ]
            ],
            'rows' => [
                [
                    '10'
                ]
            ]
        ]);

        $this->refreshOperation();

        $res = $this->database->execute($sql);
        $this->assertInstanceOf(Result::class, $res);
        $this->assertEquals(10, $res->rows()[0]['ID']);
    }

    public function testRead()
    {
        $table = 'Table';
        $opts = ['foo' => 'bar'];

        $this->connection->read(Argument::that(function ($arg) use ($table, $opts) {
            if ($arg['table'] !== $table) return false;
            if ($arg['keySet']['all'] !== true) return false;
            if ($arg['columns'] !== ['ID']) return false;

            return true;
        }))->shouldBeCalled()->willReturn([
            'metadata' => [
                'rowType' => [
                    'fields' => [
                        [
                            'name' => 'ID',
                            'type' => [
                                'code' => ValueMapper::TYPE_INT64
                            ]
                        ]
                    ]
                ]
            ],
            'rows' => [
                [
                    '10'
                ]
            ]
        ]);

        $this->refreshOperation();

        $res = $this->database->read($table, new KeySet(['all' => true]), ['ID']);
        $this->assertInstanceOf(Result::class, $res);
        $this->assertEquals(10, $res->rows()[0]['ID']);
    }

    // *******
    // Helpers

    private function refreshOperation()
    {
        $operation = new Operation($this->connection->reveal(), false);
        $this->database->___setProperty('operation', $operation);
    }

    private function commitResponse()
    {
        return ['commitTimestamp' => '2017-01-09T18:05:22.534799Z'];
    }

    private function assertTimestampIsCorrect($res)
    {
        $ts = new \DateTimeImmutable($this->commitResponse()['commitTimestamp']);

        $this->assertEquals($ts->format('Y-m-d\TH:i:s\Z'), $res->get()->format('Y-m-d\TH:i:s\Z'));
    }
}
