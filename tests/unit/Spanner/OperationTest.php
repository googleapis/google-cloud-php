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
use Google\Cloud\Spanner\KeyRange;
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
class OperationTest extends \PHPUnit_Framework_TestCase
{
    const SESSION = 'my-session-id';
    const TRANSACTION = 'my-transaction-id';
    const TIMESTAMP = '2017-01-09T18:05:22.534799Z';

    private $connection;
    private $operation;
    private $session;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);

        $this->operation = \Google\Cloud\Dev\stub(Operation::class, [
            $this->connection->reveal(),
            false
        ]);

        $session = $this->prophesize(Session::class);
        $session->name()->willReturn(self::SESSION);
        $this->session = $session->reveal();
    }

    public function testMutation()
    {
        $res = $this->operation->mutation(Operation::OP_INSERT, 'Posts', [
            'foo' => 'bar'
        ]);

        $this->assertEquals(Operation::OP_INSERT, array_keys($res)[0]);
        $this->assertEquals('Posts', $res[Operation::OP_INSERT]['table']);
        $this->assertEquals('foo', $res[Operation::OP_INSERT]['columns'][0]);
        $this->assertEquals('bar', $res[Operation::OP_INSERT]['values'][0]);
    }

    public function testDeleteMutation()
    {
        $keys = ['foo', 'bar'];
        $range = new KeyRange([
            'startType' => KeyRange::TYPE_CLOSED,
            'start' => ['foo'],
            'endType' => KeyRange::TYPE_OPEN,
            'end' => ['bar']
        ]);

        $keySet = new KeySet([
            'keys' => $keys,
            'ranges' => [$range]
        ]);

        $res = $this->operation->deleteMutation('Posts', $keySet);

        $this->assertEquals('Posts', $res['delete']['table']);
        $this->assertEquals($keys, $res['delete']['keySet']['keys']);
        $this->assertEquals($range->keyRangeObject(), $res['delete']['keySet']['ranges'][0]);
    }

    public function testCommit()
    {
        $mutations = [
            $this->operation->mutation(Operation::OP_INSERT, 'Posts', [
                'foo' => 'bar'
            ])
        ];

        $this->connection->commit(Argument::that(function ($arg) use ($mutations) {
            if ($arg['mutations'] !== $mutations) return false;
            if ($arg['singleUseTransaction']['readWrite'] !== []) return false;

            return true;
        }))->shouldBeCalled()->willReturn(['commitTimestamp' => self::TIMESTAMP]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $this->operation->commit($this->session, $mutations);

        $this->assertInstanceOf(Timestamp::class, $res);
    }

    public function testCommitWithExistingTransaction()
    {
        $mutations = [
            $this->operation->mutation(Operation::OP_INSERT, 'Posts', [
                'foo' => 'bar'
            ])
        ];

        $this->connection->commit(Argument::that(function ($arg) use ($mutations) {
            if ($arg['mutations'] !== $mutations) return false;
            if (isset($arg['singleUseTransaction'])) return false;
            if ($arg['transactionId'] !== self::TRANSACTION) return false;

            return true;
        }))->shouldBeCalled()->willReturn(['commitTimestamp' => self::TIMESTAMP]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $this->operation->commit($this->session, $mutations, [
            'transactionId' => self::TRANSACTION
        ]);

        $this->assertInstanceOf(Timestamp::class, $res);
    }

    public function testRollback()
    {
        $this->connection->rollback(Argument::that(function ($arg) {
            if ($arg['transactionId'] !== self::TRANSACTION) return false;
            if ($arg['session'] !== self::SESSION) return false;

            return true;
        }))->shouldBeCalled();

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $this->operation->rollback($this->session, self::TRANSACTION);
    }

    public function testExecute()
    {
        $sql = 'SELECT * FROM Posts WHERE ID = @id';
        $params = ['id' => 10];

        $this->connection->executeSql(Argument::that(function ($arg) use ($sql, $params) {
            if ($arg['sql'] !== $sql) return false;
            if ($arg['session'] !== self::SESSION) return false;
            if ($arg['params'] !== ['id' => '10']) return false;
            if ($arg['paramTypes']['id']['code'] !== ValueMapper::TYPE_INT64) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->executeAndReadResponse());

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $this->operation->execute($this->session, $sql, [
            'parameters' => $params
        ]);

        $this->assertInstanceOf(Result::class, $res);
        $this->assertEquals(10, $res->rows()[0]['ID']);
    }

    public function testRead()
    {
        $this->connection->read(Argument::that(function ($arg) {
            if ($arg['table'] !== 'Posts') return false;
            if ($arg['session'] !== self::SESSION) return false;
            if ($arg['keySet']['all'] !== true) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->executeAndReadResponse());

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $this->operation->read($this->session, 'Posts');
        $this->assertInstanceOf(Result::class, $res);
        $this->assertEquals(10, $res->rows()[0]['ID']);
    }

    public function testReadWithKeySet()
    {
        $keys = ['foo','bar'];

        $this->connection->read(Argument::that(function ($arg) use ($keys) {
            if ($arg['table'] !== 'Posts') return false;
            if ($arg['session'] !== self::SESSION) return false;
            if ($arg['keySet']['all'] === true) return false;
            if ($arg['keySet']['keys'] !== $keys) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->executeAndReadResponse());

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $this->operation->read($this->session, 'Posts', [
            'keySet' => new KeySet(['keys' => $keys])
        ]);
        $this->assertInstanceOf(Result::class, $res);
        $this->assertEquals(10, $res->rows()[0]['ID']);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testReadWithInvalidKeySet()
    {
        $this->operation->read($this->session, 'Posts', [
            'keySet' => 'foo'
        ]);
    }

    public function testTransaction()
    {
        $this->connection->beginTransaction(Argument::that(function ($arg) {
            if ($arg['session'] !== self::SESSION) return false;

            return true;
        }))->shouldBeCalled()->willReturn([
            'id' => self::TRANSACTION
        ]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $this->operation->transaction($this->session, SessionPoolInterface::CONTEXT_READWRITE);

        $this->assertInstanceOf(Transaction::class, $res);
        $this->assertEquals(self::TRANSACTION, $res->id());
        $this->assertEquals(SessionPoolInterface::CONTEXT_READWRITE, $res->context());
        $this->assertNull($res->readTimestamp());
    }

    public function testTransactionWithTimestamp()
    {
        $this->connection->beginTransaction(Argument::that(function ($arg) {
            if ($arg['session'] !== self::SESSION) return false;

            return true;
        }))->shouldBeCalled()->willReturn([
            'id' => self::TRANSACTION,
            'readTimestamp' => self::TIMESTAMP
        ]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $this->operation->transaction($this->session, SessionPoolInterface::CONTEXT_READWRITE);

        $this->assertInstanceOf(Transaction::class, $res);
        $this->assertInstanceOf(Timestamp::class, $res->readTimestamp());
    }

    private function executeAndReadResponse()
    {
        return [
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
                ['10']
            ]
        ];
    }
}
