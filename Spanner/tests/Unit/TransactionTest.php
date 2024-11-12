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

use Google\ApiCore\Serializer;
use Google\ApiCore\ValidationException;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Spanner\BatchDmlResult;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Tests\ResultGeneratorTrait;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\ExecuteBatchDmlRequest;
use Google\Cloud\Spanner\V1\ExecuteBatchDmlResponse;
use Google\Cloud\Spanner\V1\ExecuteSqlRequest;
use Google\Cloud\Spanner\V1\ReadRequest;
use Google\Cloud\Spanner\V1\ResultSet;
use Google\Cloud\Spanner\V1\ResultSetStats;
use Google\Cloud\Spanner\V1\RollbackRequest;
use Google\Protobuf\Duration;
use Google\Rpc\Status;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner
 */
class TransactionTest extends TestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;
    use ResultGeneratorTrait;
    use TimeTrait;
    use ApiHelperTrait;

    const TIMESTAMP = '2017-01-09T18:05:22.534799Z';

    const PROJECT = 'my-awesome-project';
    const DATABASE = 'my-database';
    const INSTANCE = 'my-instance';
    const SESSION = 'my-session';
    const TRANSACTION = 'my-transaction';
    const TRANSACTION_TAG = 'my-transaction-tag';
    const REQUEST_TAG = 'my-request-tag';

    private $instance;
    private $session;
    private $database;
    private $operation;
    private $serializer;
    private $headers;
    private $spannerClient;

    private $transaction;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->serializer = new Serializer([], [
            'google.protobuf.Value' => function ($v) {
                return $this->flattenValue($v);
            },
            'google.protobuf.ListValue' => function ($v) {
                return $this->flattenListValue($v);
            },
            'google.protobuf.Struct' => function ($v) {
                return $this->flattenStruct($v);
            },
            'google.protobuf.Timestamp' => function ($v) {
                return $this->formatTimestampFromApi($v);
            }
        ]);
        $this->spannerClient = $this->prophesize(SpannerClient::class);
        $this->operation = new Operation(
            $this->spannerClient->reveal(),
            $this->serializer,
            false
        );

        $this->session = new Session(
            $this->spannerClient->reveal(),
            $this->serializer,
            self::PROJECT,
            self::INSTANCE,
            self::DATABASE,
            self::SESSION
        );

        $this->transaction = new Transaction(
            $this->operation,
            $this->session,
            self::TRANSACTION,
            false,
            self::TRANSACTION_TAG
        );
    }

    public function testSingleUseTagError()
    {
        $this->expectException(InvalidArgumentException::class);

        new Transaction(
            $this->operation,
            $this->session,
            null,
            false,
            self::TRANSACTION_TAG
        );
    }

    public function testExecute()
    {
        $sql = 'SELECT * FROM Table';
        $this->spannerClient->executeStreamingSql(
            Argument::that(function (ExecuteSqlRequest $request) use ($sql) {
                $this->assertEquals($request->getTransaction()->getId(), self::TRANSACTION);
                $this->assertEquals($request->getSql(), $sql);
                return true;
            }),
            Argument::that(function (array $callOptions) {
                $this->assertEquals(
                    $callOptions['headers']['x-goog-spanner-route-to-leader'],
                    ['true']
                );
                return true;
            })
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream());

        $res = $this->transaction->execute($sql);
        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertEquals(10, $rows[0]['ID']);
    }

    public function testExecuteUpdate()
    {
        $sql = 'UPDATE foo SET bar = @bar';
        $this->spannerClient->executeStreamingSql(
            Argument::that(function (ExecuteSqlRequest $request) use ($sql) {
                $this->assertEquals($request->getSql(), $sql);
                $this->assertEquals($request->getTransaction()->getId(), self::TRANSACTION);
                $this->assertEquals(
                    $request->getRequestOptions()->getRequestTag(),
                    self::REQUEST_TAG
                );
                $this->assertEquals(
                    $request->getRequestOptions()->getTransactionTag(),
                    self::TRANSACTION_TAG
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream(null, new ResultSetStats(['row_count_exact' => 1])));

        $res = $this->transaction->executeUpdate($sql, ['requestOptions' => ['requestTag' => self::REQUEST_TAG]]);
        $this->assertEquals(1, $res);
    }

    public function testExecuteUpdateWithExcludeTxnFromChangeStreamsThrowsException()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage(
            'The excludeTxnFromChangeStreams option cannot be set for individual DML requests'
        );

        $sql = 'UPDATE foo SET bar = @bar';
        $this->transaction->executeUpdate($sql, [
           'transaction' => ['begin' => ['excludeTxnFromChangeStreams' => true]]
        ]);
    }

    public function testDmlSeqno()
    {
        $sql = 'UPDATE foo SET bar = @bar';
        $this->spannerClient->executeStreamingSql(
            Argument::that(function (ExecuteSqlRequest $request) {
                $this->assertEquals($request->getSeqno(), 1);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream(null, new ResultSetStats(['row_count_exact' => 1])));

        $this->transaction->executeUpdate(
            $sql,
            ['requestOptions' => ['requestTag' => self::REQUEST_TAG]]
        );

        $this->spannerClient->executeBatchDml(
            Argument::that(function (ExecuteBatchDmlRequest $request) {
                $this->assertEquals(
                    $request->getSeqno(),
                    2
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new ExecuteBatchDmlResponse(['result_sets' => []]));

        $this->transaction->executeUpdateBatch(
            [['sql' => 'SELECT 1']],
            ['requestOptions' => ['requestTag' => self::REQUEST_TAG]]
        );
    }

    public function testExecuteUpdateBatch()
    {
        $this->spannerClient->executeBatchDml(
            Argument::that(function (ExecuteBatchDmlRequest $request) {
                $this->assertEquals(
                    $request->getRequestOptions()->getRequestTag(),
                    self::REQUEST_TAG
                );
                $this->assertEquals(
                    $request->getRequestOptions()->getTransactionTag(),
                    self::TRANSACTION_TAG
                );
                $statements = $request->getStatements();
                $this->assertEquals(3, count($statements));

                $statement1 = $statements[0];
                $this->assertEquals('SELECT 1', $statement1->getSql());
                $this->assertEmpty($statement1->getParams());
                $this->assertEmpty($statement1->getParamTypes());

                $statement2 = $statements[1];
                $this->assertEquals('SELECT @foo', $statement2->getSql());
                $this->assertEquals('bar', $statement2->getParams()->getFields()['foo']->getStringValue());
                $types = $statement2->getParamTypes();
                $this->assertEquals(Database::TYPE_STRING, $types['foo']->getCode());

                $statement3 = $statements[2];
                $this->assertEquals('SELECT @foo', $statement3->getSql());
                $this->assertEmpty($statement3->getParams()->getFields()['foo']->getStringValue());
                $types = $statement3->getParamTypes();
                $this->assertEquals(Database::TYPE_STRING, $types['foo']->getCode());
                return true;
            }),
            Argument::that(function (array $callOptions) {
                $this->assertEquals(
                    $callOptions['headers']['x-goog-spanner-route-to-leader'],
                    ['true']
                );
                return true;
            })
        )
            ->shouldBeCalledOnce()
            ->willReturn(new ExecuteBatchDmlResponse([
                'result_sets' => [
                    new ResultSet([
                        'stats' => new ResultSetStats([
                            'row_count_exact' => 1
                        ])
                    ]),
                    new ResultSet([
                        'stats' => new ResultSetStats([
                            'row_count_exact' => 2
                        ])
                    ]),
                    new ResultSet([
                        'stats' => new ResultSetStats([
                            'row_count_exact' => 3
                        ])
                    ])
                ]
            ]));

        $res = $this->transaction->executeUpdateBatch(
            $this->bdmlStatements(),
            ['requestOptions' => ['requestTag' => self::REQUEST_TAG]]
        );
        $this->assertInstanceOf(BatchDmlResult::class, $res);
        $this->assertNull($res->error());
        $this->assertEquals([1, 2, 3], $res->rowCounts());
    }

    public function testExecuteUpdateBatchError()
    {
        $err = [
            'code' => 3,
            'message' => 'whatev',
            'details' => []
        ];

        $this->spannerClient->executeBatchDml(
            Argument::that(function (ExecuteBatchDmlRequest $request) {
                $this->assertEquals($request->getSession(), $this->session->name());
                $this->assertEquals(
                    $request->getRequestOptions()->getRequestTag(),
                    self::REQUEST_TAG
                );
                $this->assertEquals(
                    $request->getRequestOptions()->getTransactionTag(),
                    self::TRANSACTION_TAG
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new ExecuteBatchDmlResponse([
                'result_sets' => [
                    new ResultSet([
                        'stats' => new ResultSetStats([
                            'row_count_exact' => 1
                        ])
                    ]),
                    new ResultSet([
                        'stats' => new ResultSetStats([
                            'row_count_exact' => 2
                        ])
                    ])
                ],
                'status' => new Status($err)
            ]));

        $statements = $this->bdmlStatements();
        $res = $this->transaction->executeUpdateBatch(
            $statements,
            ['requestOptions' => ['requestTag' => self::REQUEST_TAG]]
        );

        $this->assertEquals([1, 2], $res->rowCounts());
        $this->assertEquals($err, $res->error()['status']);
        $this->assertEquals($statements[2], $res->error()['statement']);
    }

    public function testExecuteUpdateBatchInvalidStatement()
    {
        $this->expectException(InvalidArgumentException::class);

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
        $this->expectException(InvalidArgumentException::class);

        $sql = 'UPDATE foo SET bar = @bar';
        $this->spannerClient->executeStreamingSql(
            Argument::that(function (ExecuteSqlRequest $request) use ($sql) {
                $this->assertEquals($request->getSql(), $sql);
                $this->assertEquals($request->getTransaction()->getId(), self::TRANSACTION);
                $this->assertEquals(
                    $request->getRequestOptions()->getRequestTag(),
                    self::REQUEST_TAG
                );
                $this->assertEquals(
                    $request->getRequestOptions()->getTransactionTag(),
                    self::TRANSACTION_TAG
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream());

        $res = $this->transaction->executeUpdate($sql, ['requestOptions' => ['requestTag' => self::REQUEST_TAG]]);

        $this->assertEquals(1, $res);
    }

    public function testRead()
    {
        $table = 'Table';
        $opts = ['foo' => 'bar'];

        $this->spannerClient->streamingRead(
            Argument::that(function (ReadRequest $request) use ($table) {
                $this->assertEquals($request->getTransaction()->getId(), self::TRANSACTION);
                $this->assertEquals($request->getTable(), $table);
                $this->assertTrue($request->getKeySet()->getAll());
                $this->assertEquals(iterator_to_array($request->getColumns()), ['ID']);
                $this->assertEquals(
                    $request->getRequestOptions()->getTransactionTag(),
                    self::TRANSACTION_TAG
                );
                $this->assertEquals(
                    $request->getRequestOptions()->getRequestTag(),
                    self::REQUEST_TAG
                );

                return true;
            }),
            Argument::that(function (array $callOptions) {
                $this->assertEquals(
                    $callOptions['headers']['x-goog-spanner-route-to-leader'],
                    ['true']
                );

                return true;
            })
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream());

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
        $operation = $this->prophesize(Operation::class);
        $operation->commitWithResponse(
            $this->session,
            Argument::that(function ($mutations) {
                $this->assertEquals(1, count($mutations));
                $this->assertEquals('Posts', $mutations[0]['insert']['table']);
                $this->assertEquals('foo', $mutations[0]['insert']['columns'][0]);
                $this->assertEquals('bar', $mutations[0]['insert']['values'][0]);
                return true;
            }),
            [
                'transactionId' => self::TRANSACTION,
                'requestOptions' => [
                    'transactionTag' => self::TRANSACTION_TAG
                ]
            ]
        )
            ->shouldBeCalled()
            ->willReturn($this->commitResponseWithCommitStats());

        $transaction = new Transaction(
            $operation->reveal(),
            $this->session,
            self::TRANSACTION,
            false,
            self::TRANSACTION_TAG
        );

        $transaction->insert('Posts', ['foo' => 'bar']);
        $transaction->commit(['requestOptions' => ['requestTag' => 'unused']]);
    }

    public function testCommitWithReturnCommitStats()
    {
        $operation = $this->prophesize(Operation::class);
        $operation->commitWithResponse(
            $this->session,
            Argument::that(function ($mutations) {
                $this->assertEquals(1, count($mutations));
                $this->assertEquals('Posts', $mutations[0]['insert']['table']);
                $this->assertEquals('foo', $mutations[0]['insert']['columns'][0]);
                $this->assertEquals('bar', $mutations[0]['insert']['values'][0]);
                return true;
            }),
            [
                'transactionId' => self::TRANSACTION,
                'returnCommitStats' => true,
                'requestOptions' => [
                    'transactionTag' => self::TRANSACTION_TAG
                ]
            ]
        )
            ->shouldBeCalled()
            ->willReturn($this->commitResponseWithCommitStats());

        $transaction = new Transaction(
            $operation->reveal(),
            $this->session,
            self::TRANSACTION,
            false,
            self::TRANSACTION_TAG
        );

        $transaction->insert('Posts', ['foo' => 'bar']);
        $transaction->commit(['returnCommitStats' => true]);

        $this->assertEquals(['mutationCount' => 1], $transaction->getCommitStats());
    }

    public function testCommitWithMaxCommitDelay()
    {
        $duration = new Duration(['seconds' => 0, 'nanos' => 100000000]);

        $operation = $this->prophesize(Operation::class);
        $operation->commitWithResponse(
            $this->session,
            Argument::that(function ($mutations) {
                $this->assertEquals(1, count($mutations));
                $this->assertEquals('Posts', $mutations[0]['insert']['table']);
                $this->assertEquals('foo', $mutations[0]['insert']['columns'][0]);
                $this->assertEquals('bar', $mutations[0]['insert']['values'][0]);

                return true;
            }),
            [
                'transactionId' => self::TRANSACTION,
                'returnCommitStats' => true,
                'maxCommitDelay' => $duration,
                'requestOptions' => [
                    'transactionTag' => self::TRANSACTION_TAG
                ]
            ]
        )
            ->shouldBeCalled()
            ->willReturn($this->commitResponseWithCommitStats());

        $transaction = new Transaction(
            $operation->reveal(),
            $this->session,
            self::TRANSACTION,
            false,
            self::TRANSACTION_TAG
        );
        $transaction->insert('Posts', ['foo' => 'bar']);
        $transaction->commit([
            'returnCommitStats' => true,
            'maxCommitDelay' => $duration
        ]);

        $this->assertEquals(['mutationCount' => 1], $transaction->getCommitStats());
    }

    public function testCommitInvalidState()
    {
        $this->expectException(\BadMethodCallException::class);

        $operation = $this->prophesize(Operation::class);
        $operation->commitWithResponse(Argument::cetera())
            ->shouldBeCalledOnce()
            ->willReturn([[]]);

        $transaction = new Transaction(
            $operation->reveal(),
            $this->session,
            self::TRANSACTION,
            false,
            self::TRANSACTION_TAG
        );

        // call "commit" to mock closing the state
        $transaction->commit();

        // transaction is considered closed after the first commit, so this should throw an exception
        $transaction->commit();
    }

    public function testRollback()
    {
        $this->spannerClient->rollback(
            Argument::that(function (RollbackRequest $request) {
                $this->assertEquals($request->getSession(), $this->session->name());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce();

        $this->transaction->rollback();
    }

    public function testRollbackInvalidState()
    {
        $this->expectException(\BadMethodCallException::class);

        $operation = $this->prophesize(Operation::class);
        $operation->commitWithResponse(Argument::cetera())
            ->shouldBeCalledOnce()
            ->willReturn([[]]);

        $transaction = new Transaction(
            $operation->reveal(),
            $this->session,
            self::TRANSACTION,
            false,
            self::TRANSACTION_TAG
        );

        // call "commit" to mock closing the state
        $transaction->commit();

        // transaction is considered closed after the first commit, so this should throw an exception
        $transaction->rollback();
    }

    public function testId()
    {
        $this->assertEquals(self::TRANSACTION, $this->transaction->id());
    }

    public function testState()
    {
        $operation = $this->prophesize(Operation::class);
        $operation->commitWithResponse(Argument::cetera())
            ->shouldBeCalledOnce()
            ->willReturn([[]]);

        $transaction = new Transaction(
            $operation->reveal(),
            $this->session,
            self::TRANSACTION,
            false,
            self::TRANSACTION_TAG
        );

        $this->assertEquals(Transaction::STATE_ACTIVE, $transaction->state());

        // call "commit" to mock closing the state
        $transaction->commit();

        $this->assertEquals(Transaction::STATE_COMMITTED, $transaction->state());
    }

    public function testInvalidReadContext()
    {
        $this->expectException(\BadMethodCallException::class);

        $singleUseTransaction = new Transaction(
            $this->operation,
            $this->session,
        );
        $singleUseTransaction->execute('foo');
    }

    public function testIsRetryFalse()
    {
        $this->assertFalse($this->transaction->isRetry());
    }

    public function testIsRetryTrue()
    {
        $transaction = new Transaction(
            $this->operation,
            $this->session,
            self::TRANSACTION,
            true
        );

        $this->assertTrue($transaction->isRetry());
    }

    // *******
    // Helpers

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
}
