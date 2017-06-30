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

use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\ValueMapper;
use Google\Cloud\Tests\GrpcTestTrait;
use Prophecy\Argument;

/**
 * @group spanner
 */
class TransactionTest extends \PHPUnit_Framework_TestCase
{
    use GrpcTestTrait;

    const TIMESTAMP = '2017-01-09T18:05:22.534799Z';

    const PROJECT = 'my-awesome-project';
    const DATABASE = 'my-database';
    const INSTANCE = 'my-instance';
    const SESSION = 'my-session';
    const TRANSACTION = 'my-transaction';

    private $connection;
    private $instance;
    private $session;
    private $database;

    private $transaction;
    private $singleUseTransaction;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->operation = new Operation($this->connection->reveal(), false);

        $this->session = new Session(
            $this->connection->reveal(),
            self::PROJECT,
            self::INSTANCE,
            self::DATABASE,
            self::SESSION
        );

        $args = [
            $this->operation,
            $this->session,
            self::TRANSACTION,
        ];

        $props = [
            'operation', 'readTimestamp', 'state'
        ];

        $this->transaction = \Google\Cloud\Dev\stub(Transaction::class, $args, $props);

        unset($args[2]);
        $this->singleUseTransaction = \Google\Cloud\Dev\stub(Transaction::class, $args, $props);
    }

    public function testInsert()
    {
        $this->transaction->insert('Posts', ['foo' => 'bar']);

        $mutations = $this->transaction->___getProperty('mutations');

        $this->assertEquals('Posts', $mutations[0]['insert']['table']);
        $this->assertEquals('foo', $mutations[0]['insert']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['insert']['values'][0]);
    }

    public function testInsertBatch()
    {
        $this->transaction->insertBatch('Posts', [['foo' => 'bar']]);

        $mutations = $this->transaction->___getProperty('mutations');

        $this->assertEquals('Posts', $mutations[0]['insert']['table']);
        $this->assertEquals('foo', $mutations[0]['insert']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['insert']['values'][0]);
    }

    public function testUpdate()
    {
        $this->transaction->update('Posts', ['foo' => 'bar']);

        $mutations = $this->transaction->___getProperty('mutations');

        $this->assertEquals('Posts', $mutations[0]['update']['table']);
        $this->assertEquals('foo', $mutations[0]['update']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['update']['values'][0]);
    }

    public function testUpdateBatch()
    {
        $this->transaction->updateBatch('Posts', [['foo' => 'bar']]);

        $mutations = $this->transaction->___getProperty('mutations');

        $this->assertEquals('Posts', $mutations[0]['update']['table']);
        $this->assertEquals('foo', $mutations[0]['update']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['update']['values'][0]);
    }

    public function testInsertOrUpdate()
    {
        $this->transaction->insertOrUpdate('Posts', ['foo' => 'bar']);

        $mutations = $this->transaction->___getProperty('mutations');

        $this->assertEquals('Posts', $mutations[0]['insertOrUpdate']['table']);
        $this->assertEquals('foo', $mutations[0]['insertOrUpdate']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['insertOrUpdate']['values'][0]);
    }

    public function testInsertOrUpdateBatch()
    {
        $this->transaction->insertOrUpdateBatch('Posts', [['foo' => 'bar']]);

        $mutations = $this->transaction->___getProperty('mutations');

        $this->assertEquals('Posts', $mutations[0]['insertOrUpdate']['table']);
        $this->assertEquals('foo', $mutations[0]['insertOrUpdate']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['insertOrUpdate']['values'][0]);
    }

    public function testReplace()
    {
        $this->transaction->replace('Posts', ['foo' => 'bar']);

        $mutations = $this->transaction->___getProperty('mutations');

        $this->assertEquals('Posts', $mutations[0]['replace']['table']);
        $this->assertEquals('foo', $mutations[0]['replace']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['replace']['values'][0]);
    }

    public function testReplaceBatch()
    {
        $this->transaction->replaceBatch('Posts', [['foo' => 'bar']]);

        $mutations = $this->transaction->___getProperty('mutations');

        $this->assertEquals('Posts', $mutations[0]['replace']['table']);
        $this->assertEquals('foo', $mutations[0]['replace']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['replace']['values'][0]);
    }

    public function testDelete()
    {
        $this->transaction->delete('Posts', new KeySet(['keys' => ['foo']]));

        $mutations = $this->transaction->___getProperty('mutations');
        $this->assertEquals('Posts', $mutations[0]['delete']['table']);
        $this->assertEquals('foo', $mutations[0]['delete']['keySet']['keys'][0]);
        $this->assertFalse(isset($mutations[0]['delete']['keySet']['all']));
    }

    public function testExecute()
    {
        $sql = 'SELECT * FROM Table';

        $this->connection->executeStreamingSql(Argument::that(function ($arg) use ($sql) {
            if ($arg['transaction']['id'] !== self::TRANSACTION) return false;
            if ($arg['sql'] !== $sql) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->resultGenerator());

        $this->refreshOperation();

        $res = $this->transaction->execute($sql);
        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertEquals(10, $rows[0]['ID']);
    }

    public function testRead()
    {
        $table = 'Table';
        $opts = ['foo' => 'bar'];

        $this->connection->streamingRead(Argument::that(function ($arg) use ($table, $opts) {
            if ($arg['transaction']['id'] !== self::TRANSACTION) return false;
            if ($arg['table'] !== $table) return false;
            if ($arg['keySet']['all'] !== true) return false;
            if ($arg['columns'] !== ['ID']) return false;

            return true;
        }))->shouldBeCalled()->willReturn($this->resultGenerator());

        $this->refreshOperation();

        $res = $this->transaction->read($table, new KeySet(['all' => true]), ['ID']);

        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertEquals(10, $rows[0]['ID']);
    }

    public function testCommit()
    {
        $this->transaction->insert('Posts', ['foo' => 'bar']);

        $mutations = $this->transaction->___getProperty('mutations');

        $operation = $this->prophesize(Operation::class);
        $operation->commit($this->session, $mutations, ['transactionId' => self::TRANSACTION])->shouldBeCalled();

        $this->transaction->___setProperty('operation', $operation->reveal());

        $this->transaction->commit();
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testCommitInvalidState()
    {
        $this->transaction->___setProperty('state', 'foo');
        $this->transaction->commit();
    }

    public function testRollback()
    {
        $this->connection->rollback(Argument::any())
            ->shouldBeCalled();

        $this->refreshOperation();

        $this->transaction->rollback();
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testRollbackInvalidState()
    {
        $this->transaction->___setProperty('state', 'foo');
        $this->transaction->rollback();
    }

    public function testId()
    {
        $this->assertEquals(self::TRANSACTION, $this->transaction->id());
    }

    public function testState()
    {
        $this->assertEquals(Transaction::STATE_ACTIVE, $this->transaction->state());

        $this->transaction->___setProperty('state', Transaction::STATE_COMMITTED);
        $this->assertEquals(Transaction::STATE_COMMITTED, $this->transaction->state());
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testInvalidReadContext()
    {
        $this->singleUseTransaction->execute('foo');
    }

    public function testIsRetryFalse()
    {
        $this->assertFalse($this->transaction->isRetry());
    }

    public function testIsRetryTrue()
    {
        $args = [
            $this->operation,
            $this->session,
            self::TRANSACTION,
            true
        ];

        $transaction = \Google\Cloud\Dev\stub(Transaction::class, $args);

        $this->assertTrue($transaction->isRetry());
    }

    // *******
    // Helpers

    private function resultGenerator()
    {
        yield [
            'metadata' => [
                'rowType' => [
                    'fields' => [
                        [
                            'name' => 'ID',
                            'type' => [
                                'code' => Database::TYPE_INT64
                            ]
                        ]
                    ]
                ]
            ],
            'values' => [
                '10'
            ]
        ];
    }

    private function refreshOperation()
    {
        $operation = new Operation($this->connection->reveal(), false);
        $this->transaction->___setProperty('operation', $operation);
    }

    private function commitResponse()
    {
        return ['commitTimestamp' => self::TIMESTAMP];
    }

    private function assertTimestampIsCorrect($res)
    {
        $ts = new \DateTimeImmutable($this->commitResponse()['commitTimestamp']);

        $this->assertEquals($ts->format('Y-m-d\TH:i:s\Z'), $res->get()->format('Y-m-d\TH:i:s\Z'));
    }
}
