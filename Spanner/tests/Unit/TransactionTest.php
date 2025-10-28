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

use DateTimeImmutable;
use Google\ApiCore\ValidationException;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Spanner\BatchDmlResult;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Serializer;
use Google\Cloud\Spanner\Session\SessionCache;
use Google\Cloud\Spanner\Tests\ResultGeneratorTrait;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\CommitResponse;
use Google\Cloud\Spanner\V1\CommitResponse\CommitStats;
use Google\Cloud\Spanner\V1\ExecuteBatchDmlRequest;
use Google\Cloud\Spanner\V1\ExecuteBatchDmlResponse;
use Google\Cloud\Spanner\V1\ExecuteSqlRequest;
use Google\Cloud\Spanner\V1\MultiplexedSessionPrecommitToken;
use Google\Cloud\Spanner\V1\ReadRequest;
use Google\Cloud\Spanner\V1\ResultSet;
use Google\Cloud\Spanner\V1\ResultSetStats;
use Google\Cloud\Spanner\V1\RollbackRequest;
use Google\Cloud\Spanner\V1\TransactionOptions\IsolationLevel;
use Google\Protobuf\Duration;
use Google\Protobuf\Timestamp as TimestampProto;
use Google\Rpc\Status;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use ReflectionClass;

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
    const SESSION = 'projects/my-awesome-project/instances/my-instance/databases/my-database/sessions/session-id';
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

        $this->serializer = new Serializer();
        $this->spannerClient = $this->prophesize(SpannerClient::class);
        $this->operation = new Operation(
            $this->spannerClient->reveal(),
            $this->serializer,
        );

        $this->session = $this->prophesize(SessionCache::class);
        $this->session->name()->willReturn(self::SESSION);

        $this->transaction = new Transaction(
            $this->operation,
            $this->session->reveal(),
            self::TRANSACTION,
            ['tag' => self::TRANSACTION_TAG]
        );
    }

    public function testSingleUseTagError()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot set a transaction tag on a single-use transaction.');

        new Transaction(
            $this->operation,
            $this->session->reveal(),
            null,
            ['tag' => self::TRANSACTION_TAG]
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
                $this->assertEquals($callOptions['route-to-leader'], true);
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
                $this->assertEquals($callOptions['route-to-leader'], true);
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
                $this->assertEquals($request->getSession(), self::SESSION);
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
                    self::TRANSACTION_TAG,
                    $request->getRequestOptions()->getTransactionTag(),
                );
                $this->assertEquals(
                    self::REQUEST_TAG,
                    $request->getRequestOptions()->getRequestTag(),
                );

                return true;
            }),
            Argument::that(function (array $callOptions) {
                $this->assertArrayHasKey('route-to-leader', $callOptions);
                $this->assertEquals(true, $callOptions['route-to-leader']);

                return true;
            })
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream([]));

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
        $operation->commit(
            $this->session->reveal(),
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
            $this->session->reveal(),
            self::TRANSACTION,
            ['tag' => self::TRANSACTION_TAG]
        );

        $transaction->insert('Posts', ['foo' => 'bar']);
        $transaction->commit(['requestOptions' => ['requestTag' => 'unused']]);
    }

    public function testCommitWithReturnCommitStats()
    {
        $operation = $this->prophesize(Operation::class);
        $operation->commit(
            $this->session->reveal(),
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
            $this->session->reveal(),
            self::TRANSACTION,
            ['tag' => self::TRANSACTION_TAG]
        );

        $transaction->insert('Posts', ['foo' => 'bar']);
        $transaction->commit(['returnCommitStats' => true]);

        $this->assertEquals(1, $transaction->getCommitStats()->getMutationCount());
    }

    public function testCommitWithMaxCommitDelay()
    {
        $duration = new Duration(['seconds' => 0, 'nanos' => 100000000]);

        $operation = $this->prophesize(Operation::class);
        $operation->commit(
            $this->session->reveal(),
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
            $this->session->reveal(),
            self::TRANSACTION,
            ['tag' => self::TRANSACTION_TAG]
        );
        $transaction->insert('Posts', ['foo' => 'bar']);
        $transaction->commit([
            'returnCommitStats' => true,
            'maxCommitDelay' => $duration
        ]);

        $this->assertEquals(1, $transaction->getCommitStats()->getMutationCount());
    }

    public function testCommitInvalidState()
    {
        $this->expectException(\BadMethodCallException::class);

        $operation = $this->prophesize(Operation::class);
        $operation->commit(Argument::cetera())
            ->shouldBeCalledOnce()
            ->willReturn(new CommitResponse());

        $transaction = new Transaction(
            $operation->reveal(),
            $this->session->reveal(),
            self::TRANSACTION,
            ['tag' => self::TRANSACTION_TAG]
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
                $this->assertEquals($request->getSession(), self::SESSION);
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
        $operation->commit(Argument::cetera())
            ->shouldBeCalledOnce()
            ->willReturn(new CommitResponse());

        $transaction = new Transaction(
            $operation->reveal(),
            $this->session->reveal(),
            self::TRANSACTION,
            ['tag' => self::TRANSACTION_TAG]
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
        $operation->commit(Argument::cetera())
            ->shouldBeCalledOnce()
            ->willReturn(new CommitResponse());

        $transaction = new Transaction(
            $operation->reveal(),
            $this->session->reveal(),
            self::TRANSACTION,
            ['tag' => self::TRANSACTION_TAG]
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
            $this->session->reveal(),
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
            $this->session->reveal(),
            self::TRANSACTION,
            ['isRetry' => true]
        );

        $this->assertTrue($transaction->isRetry());
    }

    public function testPrecommitTokenIsSentInCommitRequestForExecuteUpdate()
    {
        $precommitToken = (new MultiplexedSessionPrecommitToken())
            ->setPrecommitToken('abc');

        $this->spannerClient->executeStreamingSql(
            Argument::type(ExecuteSqlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream(
                [
                    [
                        'name' => 'foo',
                        'type' => 1,
                        'value' => 'bar',
                        'precommitToken' => $precommitToken
                    ],
                ],
                new ResultSetStats(['row_count_exact' => 1]),
                'transaction-id'
            ));
        $this->spannerClient->commit(
            Argument::that(function ($commitRequest) use ($precommitToken) {
                $this->assertEquals($commitRequest->getPrecommitToken(), $precommitToken);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->commitResponseWithCommitStats());

        $transaction = new Transaction(
            $this->operation,
            $this->session->reveal(),
            self::TRANSACTION,
        );

        $transaction->executeUpdate('SELECT *');
        $transaction->commit();
    }

    public function testPrecommitTokenIsSentInCommitRequestForExecuteUpdateBatch()
    {
        $precommitToken = (new MultiplexedSessionPrecommitToken())
            ->setPrecommitToken('abc');

        $this->spannerClient->executeBatchDml(
            Argument::type(ExecuteBatchDmlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new ExecuteBatchDmlResponse([
                'precommit_token' => $precommitToken,
            ]));
        $this->spannerClient->commit(
            Argument::that(function ($commitRequest) use ($precommitToken) {
                $this->assertEquals($commitRequest->getPrecommitToken(), $precommitToken);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->commitResponseWithCommitStats());

        $transaction = new Transaction(
            $this->operation,
            $this->session->reveal(),
            self::TRANSACTION,
        );
        $transaction->executeUpdateBatch([
            [
                'sql' => 'UPDATE posts SET author = @author WHERE id = @id',
                'params' => [
                    'author' => 'John',
                    'id' => 1
                ]
            ]
        ]);
        $transaction->commit();
    }

    public function testSavePrecommitTokenWithHighestSequenceNum()
    {
        $transaction = new Transaction(
            $this->operation,
            $this->session->reveal(),
            self::TRANSACTION,
        );

        $precommitToken1 = (new MultiplexedSessionPrecommitToken())
            ->setSeqNum(1)
            ->setPrecommitToken('abc');
        $precommitToken2 = (new MultiplexedSessionPrecommitToken())
            ->setSeqNum(2)
            ->setPrecommitToken('def');
        $precommitToken3 = (new MultiplexedSessionPrecommitToken())
            ->setSeqNum(0)
            ->setPrecommitToken('ghi');

        $precommitTokenProp = (new ReflectionClass($transaction))->getProperty('precommitToken');

        $transaction->setPrecommitToken($precommitToken1);
        $this->assertEquals($precommitToken1, $precommitTokenProp->getValue($transaction));
        // setting a precommit token with a higher sequence number updates the token
        $transaction->setPrecommitToken($precommitToken2);
        $this->assertEquals($precommitToken2, $precommitTokenProp->getValue($transaction));
        // setting a precommit token with a lower sequence number does not update the token
        $transaction->setPrecommitToken($precommitToken3);
        $this->assertEquals($precommitToken2, $precommitTokenProp->getValue($transaction));
    }

    // *******
    // Helpers

    private function commitResponseWithCommitStats()
    {
        return new CommitResponse([
            'commit_timestamp' => new TimestampProto(['seconds' => strtotime(self::TIMESTAMP)]),
            'commit_stats' => new CommitStats(['mutation_count' => 1])
        ]);
    }
}
