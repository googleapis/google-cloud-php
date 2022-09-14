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
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group spanner
 */
class TransactionTest extends TestCase
{
    use ExpectException;
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
    const TRANSACTION_TAG = 'my-transaction-tag';
    const REQUEST_TAG = 'my-request-tag';

    private $connection;
    private $instance;
    private $session;
    private $database;
    private $operation;

    private $transaction;
    private $singleUseTransaction;

    public function set_up()
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
            false,
            self::TRANSACTION_TAG
        ];

        $props = [
            'operation', 'readTimestamp', 'state'
        ];

        $this->transaction = TestHelpers::stub(Transaction::class, $args, $props);

        $args = [
            $this->operation,
            $this->session,
        ];
        $this->singleUseTransaction = TestHelpers::stub(Transaction::class, $args, $props);
    }

    public function testSingleUseTagError()
    {
        $this->expectException('InvalidArgumentException');

        new Transaction(
            $this->operation,
            $this->session,
            null,
            false,
            self::TRANSACTION_TAG
        );
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
            Argument::withEntry('transactionId', self::TRANSACTION),
            Argument::withEntry('requestOptions', [
                'requestTag' => self::REQUEST_TAG,
                'transactionTag' => self::TRANSACTION_TAG
            ])
        ))->shouldBeCalled()->willReturn($this->resultGenerator(true));

        $this->refreshOperation($this->transaction, $this->connection->reveal());
        $res = $this->transaction->executeUpdate($sql, ['requestOptions' => ['requestTag' => self::REQUEST_TAG]]);

        $this->assertEquals(1, $res);
    }

    public function testDmlSeqno()
    {
        $sql = 'UPDATE foo SET bar = @bar';
        $this->connection->executeStreamingSql(Argument::allOf(
            Argument::withEntry('seqno', 1),
            Argument::withEntry('requestOptions', [
                'transactionTag' => self::TRANSACTION_TAG,
                'requestTag' => self::REQUEST_TAG
            ])
        ))->shouldBeCalled()->willReturn($this->resultGenerator(true));

        $this->refreshOperation($this->transaction, $this->connection->reveal());
        $this->transaction->executeUpdate($sql, ['requestOptions' => ['requestTag' => self::REQUEST_TAG]]);

        $this->connection->executeStreamingSql(Argument::allOf(
            Argument::withEntry('seqno', 2),
            Argument::withEntry('requestOptions', [
                'requestTag' => self::REQUEST_TAG,
                'transactionTag' => self::TRANSACTION_TAG
            ])
        ))->shouldBeCalled()->willReturn($this->resultGenerator(true));

        $this->refreshOperation($this->transaction, $this->connection->reveal());
        $this->transaction->executeUpdate($sql, ['requestOptions' => ['requestTag' => self::REQUEST_TAG]]);

        $this->connection->executeBatchDml(Argument::allOf(
            Argument::withEntry('seqno', 3),
            Argument::withEntry('requestOptions', [
                'transactionTag' => self::TRANSACTION_TAG,
                'requestTag' => self::REQUEST_TAG
            ])
        ))->shouldBeCalled()->willReturn([
            'resultSets' => []
        ]);

        $this->refreshOperation($this->transaction, $this->connection->reveal());
        $this->transaction->executeUpdateBatch(
            [
                ['sql' => 'SELECT 1'],
            ],
            ['requestOptions' => ['requestTag' => self::REQUEST_TAG]]
        );
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
            ]),
            Argument::withEntry('requestOptions', [
                'transactionTag' => self::TRANSACTION_TAG,
                'requestTag' => self::REQUEST_TAG
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
        $res = $this->transaction->executeUpdateBatch(
            $this->bdmlStatements(),
            ['requestOptions' => ['requestTag' => self::REQUEST_TAG]]
        );

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

        $this->connection->executeBatchDml(Argument::allOf(
            Argument::withEntry('session', $this->session->name()),
            Argument::withEntry('requestOptions', [
                'transactionTag' => self::TRANSACTION_TAG,
                'requestTag' => self::REQUEST_TAG
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
                ]
            ],
            'status' => $err
        ]);

        $this->refreshOperation($this->transaction, $this->connection->reveal());
        $statements = $this->bdmlStatements();
        $res = $this->transaction->executeUpdateBatch(
            $statements,
            ['requestOptions' => ['requestTag' => self::REQUEST_TAG]]
        );

        $this->assertEquals([1,2], $res->rowCounts());
        $this->assertEquals($err, $res->error()['status']);
        $this->assertEquals($statements[2], $res->error()['statement']);
    }

    public function testExecuteUpdateBatchInvalidStatement()
    {
        $this->expectException('InvalidArgumentException');

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

    public function testExecuteUpdateNonDml()
    {
        $this->expectException('InvalidArgumentException');

        $sql = 'UPDATE foo SET bar = @bar';
        $this->connection->executeStreamingSql(Argument::allOf(
            Argument::withEntry('sql', $sql),
            Argument::withEntry('transactionId', self::TRANSACTION),
            Argument::withEntry('requestOptions', [
                'transactionTag' => self::TRANSACTION_TAG,
                'requestTag' => self::REQUEST_TAG
            ])
        ))->shouldBeCalled()->willReturn($this->resultGenerator());

        $this->refreshOperation($this->transaction, $this->connection->reveal());
        $res = $this->transaction->executeUpdate($sql, ['requestOptions' => ['requestTag' => self::REQUEST_TAG]]);

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
            Argument::withEntry('columns', ['ID']),
            Argument::withEntry('requestOptions', [
                'transactionTag' => self::TRANSACTION_TAG,
                'requestTag' => self::REQUEST_TAG
            ])
        ))->shouldBeCalled()->willReturn($this->resultGenerator());

        $this->refreshOperation($this->transaction, $this->connection->reveal());

        $res = $this->transaction->read(
            $table,
            new KeySet(['all' => true]),
            ['ID'],
            ['requestOptions' => ['requestTag' => self::REQUEST_TAG]]
        );

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
            [
                'transactionId' => self::TRANSACTION,
                'requestOptions' => [
                    'transactionTag' => self::TRANSACTION_TAG
                ]
            ]
        )->shouldBeCalled()->willReturn($this->commitResponseWithCommitStats());

        $this->transaction->___setProperty('operation', $operation->reveal());

        $this->transaction->commit(['requestOptions' => ['requestTag' => 'unused']]);
    }

    public function testCommitWithReturnCommitStats()
    {
        $this->transaction->insert('Posts', ['foo' => 'bar']);

        $mutations = $this->transaction->___getProperty('mutations');

        $operation = $this->prophesize(Operation::class);
        $operation->commitWithResponse(
            $this->session,
            $mutations,
            [
                'transactionId' => self::TRANSACTION,
                'returnCommitStats' => true,
                'requestOptions' => [
                    'transactionTag' => self::TRANSACTION_TAG
                ]
            ]
        )->shouldBeCalled()->willReturn($this->commitResponseWithCommitStats());

        $this->transaction->___setProperty('operation', $operation->reveal());

        $this->transaction->commit(['returnCommitStats' => true]);

        $this->assertEquals(['mutationCount' => 1], $this->transaction->getCommitStats());
    }

    public function testCommitInvalidState()
    {
        $this->expectException('BadMethodCallException');

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

    public function testRollbackInvalidState()
    {
        $this->expectException('BadMethodCallException');

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

    public function testInvalidReadContext()
    {
        $this->expectException('BadMethodCallException');

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
