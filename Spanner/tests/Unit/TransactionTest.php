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

namespace Google\Cloud\Spanner\Tests\Unit;

use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Spanner\BatchDmlResult;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Tests\OperationRefreshTrait;
use Google\Cloud\Spanner\Tests\ResultGeneratorTrait;
use Google\Cloud\Spanner\Tests\StubCreationTrait;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group spanner
 */
class TransactionTest extends TestCase
{
    use GrpcTestTrait;
    use OperationRefreshTrait;
    use ResultGeneratorTrait;
    use StubCreationTrait;
    use TimeTrait;

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
    private $operation;

    private $transaction;
    private $singleUseTransaction;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->getConnStub();
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

        $this->transaction = TestHelpers::stub(Transaction::class, $args, $props);

        unset($args[2]);
        $this->singleUseTransaction = TestHelpers::stub(Transaction::class, $args, $props);
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
        $this->assertArrayNotHasKey('all', $mutations[0]['delete']['keySet']);
    }

    public function testExecute()
    {
        $sql = 'SELECT * FROM Table';

        $this->connection->executeStreamingSql(Argument::allOf(
            Argument::withEntry('transaction', ['id' => self::TRANSACTION]),
            Argument::withEntry('sql', $sql)
        ))->shouldBeCalled()->willReturn($this->resultGenerator());

        $this->refreshOperation($this->transaction, $this->connection->reveal());

        $res = $this->transaction->execute($sql);
        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertEquals(10, $rows[0]['ID']);
    }

    public function testExecuteUpdate()
    {
        $sql = 'UPDATE foo SET bar = @bar';
        $this->connection->executeStreamingSql(Argument::allOf(
            Argument::withEntry('sql', $sql),
            Argument::withEntry('transactionId', self::TRANSACTION)
        ))->shouldBeCalled()->willReturn($this->resultGenerator(true));

        $this->refreshOperation($this->transaction, $this->connection->reveal());
        $res = $this->transaction->executeUpdate($sql);

        $this->assertEquals(1, $res);
    }

    public function testDmlSeqno()
    {
        $sql = 'UPDATE foo SET bar = @bar';
        $this->connection->executeStreamingSql(Argument::withEntry('seqno', 1))
            ->shouldBeCalled()
            ->willReturn($this->resultGenerator(true));

        $this->refreshOperation($this->transaction, $this->connection->reveal());
        $this->transaction->executeUpdate($sql);

        $this->connection->executeStreamingSql(Argument::withEntry('seqno', 2))
            ->shouldBeCalled()
            ->willReturn($this->resultGenerator(true));

        $this->refreshOperation($this->transaction, $this->connection->reveal());
        $this->transaction->executeUpdate($sql);

        $this->connection->executeBatchDml(Argument::withEntry('seqno', 3))
            ->shouldBeCalled()
            ->willReturn([
                'resultSets' => []
            ]);

        $this->refreshOperation($this->transaction, $this->connection->reveal());
        $this->transaction->executeUpdateBatch([
            ['sql' => 'SELECT 1']
        ]);
    }

    public function testExecuteUpdateBatch()
    {
        $this->connection->executeBatchDml(Argument::allOf(
            Argument::withEntry('statements', [
                [
                    'sql' => 'SELECT 1',
                    'params' => [],
                    'paramTypes' => []
                ], [
                    'sql' => 'SELECT @foo',
                    'params' => [
                        'foo' => 'bar'
                    ],
                    'paramTypes' => [
                        'foo' => [
                            'code' => Database::TYPE_STRING
                        ]
                    ]
                ], [
                    'sql' => 'SELECT @foo',
                    'params' => [
                        'foo' => null
                    ],
                    'paramTypes' => [
                        'foo' => [
                            'code' => Database::TYPE_STRING
                        ]
                    ]
                ]
            ])
        ))->shouldBeCalled()->willReturn([
            'resultSets' => [
                [
                    'stats' => [
                        'rowCountExact' => 1
                    ]
                ], [
                    'stats' => [
                        'rowCountExact' => 2
                    ]
                ], [
                    'stats' => [
                        'rowCountExact' => 3
                    ]
                ]
            ]
        ]);

        $this->refreshOperation($this->transaction, $this->connection->reveal());
        $res = $this->transaction->executeUpdateBatch($this->bdmlStatements());

        $this->assertInstanceOf(BatchDmlResult::class, $res);
        $this->assertNull($res->error());
        $this->assertEquals([1,2,3], $res->rowCounts());
    }

    public function testExecuteUpdateBatchError()
    {
        $err = [
            'code' => 3,
            'message' => 'whatev',
            'details' => []
        ];

        $this->connection->executeBatchDml(Argument::withEntry('session', $this->session->name()))
            ->shouldBeCalled()
            ->willReturn([
                'resultSets' => [
                    [
                        'stats' => [
                            'rowCountExact' => 1
                        ]
                    ], [
                        'stats' => [
                            'rowCountExact' => 2
                        ]
                    ]
                ],
                'status' => $err
            ]);

        $this->refreshOperation($this->transaction, $this->connection->reveal());
        $statements = $this->bdmlStatements();
        $res = $this->transaction->executeUpdateBatch($statements);

        $this->assertEquals([1,2], $res->rowCounts());
        $this->assertEquals($err, $res->error()['status']);
        $this->assertEquals($statements[2], $res->error()['statement']);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testExecuteUpdateBatchInvalidStatement()
    {
        $this->transaction->executeUpdateBatch([
            ['foo' => 'bar']
        ]);
    }

    private function bdmlStatements()
    {
        return [
            [
                'sql' => 'SELECT 1',
            ], [
                'sql' => 'SELECT @foo',
                'parameters' => [
                    'foo' => 'bar'
                ]
            ], [
                'sql' => 'SELECT @foo',
                'parameters' => [
                    'foo' => null
                ],
                'types' => [
                    'foo' => Database::TYPE_STRING
                ]
            ]
        ];
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testExecuteUpdateNonDml()
    {
        $sql = 'UPDATE foo SET bar = @bar';
        $this->connection->executeStreamingSql(Argument::allOf(
            Argument::withEntry('sql', $sql),
            Argument::withEntry('transactionId', self::TRANSACTION)
        ))->shouldBeCalled()->willReturn($this->resultGenerator());

        $this->refreshOperation($this->transaction, $this->connection->reveal());
        $res = $this->transaction->executeUpdate($sql);

        $this->assertEquals(1, $res);
    }

    public function testRead()
    {
        $table = 'Table';
        $opts = ['foo' => 'bar'];

        $this->connection->streamingRead(Argument::allOf(
            Argument::withEntry('transaction', ['id' => self::TRANSACTION]),
            Argument::withEntry('table', $table),
            Argument::withEntry('keySet', ['all' => true]),
            Argument::withEntry('columns', ['ID'])
        ))->shouldBeCalled()->willReturn($this->resultGenerator());

        $this->refreshOperation($this->transaction, $this->connection->reveal());

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
        $operation->commitWithResponse(
            $this->session,
            $mutations,
            ['transactionId' => self::TRANSACTION]
        )->shouldBeCalled()->willReturn($this->commitResponseWithCommitStats());

        $this->transaction->___setProperty('operation', $operation->reveal());

        $this->transaction->commit();
    }

    public function testCommitWithReturnCommitStats()
    {
        $this->transaction->insert('Posts', ['foo' => 'bar']);

        $mutations = $this->transaction->___getProperty('mutations');

        $operation = $this->prophesize(Operation::class);
        $operation->commitWithResponse(
            $this->session,
            $mutations,
            ['transactionId' => self::TRANSACTION, 'returnCommitStats' => true]
        )->shouldBeCalled()->willReturn($this->commitResponseWithCommitStats());

        $this->transaction->___setProperty('operation', $operation->reveal());

        $this->transaction->commit(['returnCommitStats' => true]);

        $this->assertEquals(['mutationCount' => 1], $this->transaction->getCommitStats());
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
        $this->connection->rollback(Argument::withEntry('session', $this->session->name()))
            ->shouldBeCalled();

        $this->refreshOperation($this->transaction, $this->connection->reveal());

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

        $transaction = TestHelpers::stub(Transaction::class, $args);

        $this->assertTrue($transaction->isRetry());
    }

    public function testCommitWithTags()
    {
        $operation = $this->prophesize(Operation::class);
        $operation->commitWithResponse(
            Argument::any(),
            Argument::any(),
            Argument::withEntry('tags', ['transactionTag' => 't-tag'])
        )->shouldBeCalled();
        $operation->mutation(Argument::cetera())->shouldBeCalled();
        $transaction = new Transaction($operation->reveal(), $this->session, 'my-transaction', false, 't-tag');
        $transaction
            ->insert('my-table', [])
            ->commit([
                'requestTag' => 'foo',
                'transactionTag' => 'bar',
            ]);
    }

    public function testExecuteWithTags()
    {
        $operation = $this->prophesize(Operation::class);
        $operation->execute(
            Argument::any(),
            Argument::any(),
            Argument::withEntry('tags', [
                'requestTag' => 'foo',
                'transactionTag' => 't-tag',
            ])
        )->shouldBeCalled();

        $transaction = new Transaction($operation->reveal(), $this->session, 'my-transaction', false, 't-tag');
        $transaction->execute('SELECT 1', [
            'requestTag' => 'foo',
            'transactionTag' => 'bar',
        ]);
    }

    public function testReadWithTags()
    {
        $operation = $this->prophesize(Operation::class);
        $operation->read(
            Argument::any(),
            Argument::any(),
            Argument::any(),
            Argument::any(),
            Argument::withEntry('tags', [
                'requestTag' => 'foo',
                'transactionTag' => 't-tag',
            ])
        )->shouldBeCalled();

        $transaction = new Transaction($operation->reveal(), $this->session, 'my-transaction', false, 't-tag');
        $transaction->read('myTable', new KeySet(), [], [
            'requestTag' => 'foo',
            'transactionTag' => 'bar',
        ]);
    }

    public function testExecuteUpdateWithTags()
    {
        $operation = $this->prophesize(Operation::class);
        $operation->executeUpdate(
            Argument::any(),
            Argument::any(),
            Argument::any(),
            Argument::withEntry('tags', [
                'requestTag' => 'foo',
                'transactionTag' => 't-tag',
            ])
        )->shouldBeCalled();

        $transaction = new Transaction($operation->reveal(), $this->session, 'my-transaction', false, 't-tag');
        $transaction->executeUpdate('SELECT 1', [
            'requestTag' => 'foo',
            'transactionTag' => 'bar',
        ]);
    }

    public function testExecuteUpdateBatchWithTags()
    {
        $operation = $this->prophesize(Operation::class);
        $operation->executeUpdateBatch(
            Argument::any(),
            Argument::any(),
            Argument::any(),
            Argument::withEntry('tags', [
                'transactionTag' => 't-tag',
            ])
        )->shouldBeCalled();

        $transaction = new Transaction($operation->reveal(), $this->session, 'my-transaction', false, 't-tag');
        $transaction->executeUpdateBatch([['sql' => 'SELECT 1']], [
            'requestTag' => 'foo',
            'transactionTag' => 'bar',
        ]);
    }

    // *******
    // Helpers

    private function commitResponse()
    {
        return ['commitTimestamp' => self::TIMESTAMP];
    }

    private function commitResponseWithCommitStats()
    {
        $time = $this->parseTimeString(self::TIMESTAMP);
        $timestamp = new Timestamp($time[0], $time[1]);
        return [
            $timestamp,
            [
                'commitTimestamp' => self::TIMESTAMP,
                'commitStats' => ['mutationCount' => 1]
            ]
        ];
    }

    private function assertTimestampIsCorrect($res)
    {
        $ts = new \DateTimeImmutable($this->commitResponse()['commitTimestamp']);

        $this->assertEquals($ts->format('Y-m-d\TH:i:s\Z'), $res->get()->format('Y-m-d\TH:i:s\Z'));
    }
}
