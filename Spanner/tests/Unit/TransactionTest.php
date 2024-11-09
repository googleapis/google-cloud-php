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
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
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
use Google\Cloud\Spanner\V1\ExecuteSqlRequest;
use Google\Cloud\Spanner\V1\ReadRequest;
use Google\Cloud\Spanner\V1\RollbackRequest;
use Google\Protobuf\Duration;
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
    private $requestHandler;
    private $serializer;
    private $headers;

    private $transaction;
    private $singleUseTransaction;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->serializer = new Serializer();
        $this->operation = new Operation(
            $this->requestHandler->reveal(),
            $this->serializer,
            false
        );

        $this->session = new Session(
            $this->requestHandler->reveal(),
            $this->serializer,
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
        $this->expectException(InvalidArgumentException::class);

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

        $mutations = $this->transaction->___getProperty('mutationData');

        $this->assertEquals('Posts', $mutations[0]['insert']['table']);
        $this->assertEquals('foo', $mutations[0]['insert']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['insert']['values'][0]);
    }

    public function testInsertBatch()
    {
        $this->transaction->insertBatch('Posts', [['foo' => 'bar']]);

        $mutations = $this->transaction->___getProperty('mutationData');

        $this->assertEquals('Posts', $mutations[0]['insert']['table']);
        $this->assertEquals('foo', $mutations[0]['insert']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['insert']['values'][0]);
    }

    public function testUpdate()
    {
        $this->transaction->update('Posts', ['foo' => 'bar']);

        $mutations = $this->transaction->___getProperty('mutationData');

        $this->assertEquals('Posts', $mutations[0]['update']['table']);
        $this->assertEquals('foo', $mutations[0]['update']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['update']['values'][0]);
    }

    public function testUpdateBatch()
    {
        $this->transaction->updateBatch('Posts', [['foo' => 'bar']]);

        $mutations = $this->transaction->___getProperty('mutationData');

        $this->assertEquals('Posts', $mutations[0]['update']['table']);
        $this->assertEquals('foo', $mutations[0]['update']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['update']['values'][0]);
    }

    public function testInsertOrUpdate()
    {
        $this->transaction->insertOrUpdate('Posts', ['foo' => 'bar']);

        $mutations = $this->transaction->___getProperty('mutationData');

        $this->assertEquals('Posts', $mutations[0]['insertOrUpdate']['table']);
        $this->assertEquals('foo', $mutations[0]['insertOrUpdate']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['insertOrUpdate']['values'][0]);
    }

    public function testInsertOrUpdateBatch()
    {
        $this->transaction->insertOrUpdateBatch('Posts', [['foo' => 'bar']]);

        $mutations = $this->transaction->___getProperty('mutationData');

        $this->assertEquals('Posts', $mutations[0]['insertOrUpdate']['table']);
        $this->assertEquals('foo', $mutations[0]['insertOrUpdate']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['insertOrUpdate']['values'][0]);
    }

    public function testReplace()
    {
        $this->transaction->replace('Posts', ['foo' => 'bar']);

        $mutations = $this->transaction->___getProperty('mutationData');

        $this->assertEquals('Posts', $mutations[0]['replace']['table']);
        $this->assertEquals('foo', $mutations[0]['replace']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['replace']['values'][0]);
    }

    public function testReplaceBatch()
    {
        $this->transaction->replaceBatch('Posts', [['foo' => 'bar']]);

        $mutations = $this->transaction->___getProperty('mutationData');

        $this->assertEquals('Posts', $mutations[0]['replace']['table']);
        $this->assertEquals('foo', $mutations[0]['replace']['columns'][0]);
        $this->assertEquals('bar', $mutations[0]['replace']['values'][0]);
    }

    public function testDelete()
    {
        $this->transaction->delete('Posts', new KeySet(['keys' => ['foo']]));

        $mutations = $this->transaction->___getProperty('mutationData');
        $this->assertEquals('Posts', $mutations[0]['delete']['table']);
        $this->assertEquals('foo', $mutations[0]['delete']['keySet']['keys'][0]);
        $this->assertArrayNotHasKey('all', $mutations[0]['delete']['keySet']);
    }

    public function testExecute()
    {
        $sql = 'SELECT * FROM Table';
        $this->spannerClient->executeStreamingSql(
            function ($args) use ($sql) {
                Argument::type(ExecuteSqlRequest::class);
                $this->assertEquals($args->getTransaction()->getId(), self::TRANSACTION);
                $this->assertEquals($args->getSql(), $sql);
                return true;
            },
            $this->resultGenerator(),
            1,
            function ($args) {
                $this->assertEquals(
                    $args['headers']['x-goog-spanner-route-to-leader'],
                    ['true']
                );
                return true;
            }
        );
        $this->refreshOperation(
            $this->transaction,
            $this->requestHandler->reveal(),
            $this->serializer
        );

        $res = $this->transaction->execute($sql);
        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertEquals(10, $rows[0]['ID']);
    }

    public function testExecuteUpdate()
    {
        $sql = 'UPDATE foo SET bar = @bar';
        $this->spannerClient->executeStreamingSql(
            function ($args) use ($sql) {
                Argument::type(ExecuteSqlRequest::class);
                $this->assertEquals($args->getSql(), $sql);
                $this->assertEquals($args->getTransaction()->getId(), self::TRANSACTION);
                $this->assertEquals(
                    $args->getRequestOptions()->getRequestTag(),
                    self::REQUEST_TAG
                );
                $this->assertEquals(
                    $args->getRequestOptions()->getTransactionTag(),
                    self::TRANSACTION_TAG
                );
                return true;
            },
            $this->resultGenerator(true)
        );
        $this->refreshOperation(
            $this->transaction,
            $this->requestHandler->reveal(),
            $this->serializer
        );
        $res = $this->transaction->executeUpdate($sql, ['requestOptions' => ['requestTag' => self::REQUEST_TAG]]);
        $this->assertEquals(1, $res);
    }

    public function testDmlSeqno()
    {
        $sql = 'UPDATE foo SET bar = @bar';
        $this->spannerClient->executeStreamingSql(
            function ($args) {
                Argument::type(ExecuteSqlRequest::class);
                $this->assertEquals($args->getSeqno(), 1);
                return true;
            },
            $this->resultGenerator(true)
        );
        $this->refreshOperation(
            $this->transaction,
            $this->requestHandler->reveal(),
            $this->serializer
        );
        $this->transaction->executeUpdate(
            $sql,
            ['requestOptions' => ['requestTag' => self::REQUEST_TAG]]
        );

        $this->spannerClient->executeBatchDml(
            function ($args) {
                Argument::type(ExecuteBatchDmlRequest::class);
                $this->assertEquals(
                    $args->getSeqno(),
                    2
                );
                return true;
            },
            ['resultSets' => []]
        );
        $this->refreshOperation(
            $this->transaction,
            $this->requestHandler->reveal(),
            $this->serializer
        );
        $this->transaction->executeUpdateBatch(
            [
                ['sql' => 'SELECT 1'],
            ],
            ['requestOptions' => ['requestTag' => self::REQUEST_TAG]]
        );
    }

    public function testExecuteUpdateBatch()
    {
        $this->spannerClient->executeBatchDml(
            function ($args) {
                Argument::type(ExecuteBatchDmlRequest::class);
                $this->assertEquals(
                    $args->getRequestOptions()->getRequestTag(),
                    self::REQUEST_TAG
                );
                $this->assertEquals(
                    $args->getRequestOptions()->getTransactionTag(),
                    self::TRANSACTION_TAG
                );
                $statements = $args->getStatements();
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
            },
            [
                'resultSets' => [
                    [
                        'stats' => [
                            'rowCountExact' => 1
                        ]
                    ],
                    [
                        'stats' => [
                            'rowCountExact' => 2
                        ]
                    ],
                    [
                        'stats' => [
                            'rowCountExact' => 3
                        ]
                    ]
                ]
            ],
            1,
            function ($args) {
                $this->assertEquals(
                    $args['headers']['x-goog-spanner-route-to-leader'],
                    ['true']
                );
                return true;
            }
        );
        $this->refreshOperation(
            $this->transaction,
            $this->requestHandler->reveal(),
            $this->serializer
        );
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
            function ($args) {
                Argument::type(ExecuteBatchDmlRequest::class);
                $this->assertEquals($args->getSession(), $this->session->name());
                $this->assertEquals(
                    $args->getRequestOptions()->getRequestTag(),
                    self::REQUEST_TAG
                );
                $this->assertEquals(
                    $args->getRequestOptions()->getTransactionTag(),
                    self::TRANSACTION_TAG
                );
                return true;
            },
            [
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
            ]
        );

        $this->refreshOperation(
            $this->transaction,
            $this->requestHandler->reveal(),
            $this->serializer
        );
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
            function ($args) use ($sql) {
                Argument::type(ExecuteSqlRequest::class);
                $this->assertEquals($args->getSql(), $sql);
                $this->assertEquals($args->getTransaction()->getId(), self::TRANSACTION);
                $this->assertEquals(
                    $args->getRequestOptions()->getRequestTag(),
                    self::REQUEST_TAG
                );
                $this->assertEquals(
                    $args->getRequestOptions()->getTransactionTag(),
                    self::TRANSACTION_TAG
                );
                return true;
            },
            $this->resultGenerator()
        );
        $this->refreshOperation(
            $this->transaction,
            $this->requestHandler->reveal(),
            $this->serializer
        );

        $res = $this->transaction->executeUpdate($sql, ['requestOptions' => ['requestTag' => self::REQUEST_TAG]]);

        $this->assertEquals(1, $res);
    }

    public function testRead()
    {
        $table = 'Table';
        $opts = ['foo' => 'bar'];

        $this->spannerClient->streamingRead(
            function ($args) use ($table) {
                Argument::type(ReadRequest::class);
                $this->assertEquals($args->getTransaction()->getId(), self::TRANSACTION);
                $this->assertEquals($args->getTable(), $table);
                $this->assertTrue($args->getKeySet()->getAll());
                $this->assertEquals(iterator_to_array($args->getColumns()), ['ID']);
                $this->assertEquals(
                    $args->getRequestOptions()->getTransactionTag(),
                    self::TRANSACTION_TAG
                );
                $this->assertEquals(
                    $args->getRequestOptions()->getRequestTag(),
                    self::REQUEST_TAG
                );

                return true;
            },
            $this->resultGenerator(),
            1,
            function ($args) {
                $this->assertEquals(
                    $args['headers']['x-goog-spanner-route-to-leader'],
                    ['true']
                );

                return true;
            }
        );

        $this->refreshOperation(
            $this->transaction,
            $this->requestHandler->reveal(),
            $this->serializer
        );

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

        $mutations = $this->transaction->___getProperty('mutationData');

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

        $mutations = $this->transaction->___getProperty('mutationData');

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

    public function testCommitWithMaxCommitDelay()
    {
        $duration = new Duration(['seconds' => 0, 'nanos' => 100000000]);
        $this->transaction->insert('Posts', ['foo' => 'bar']);

        $mutations = $this->transaction->___getProperty('mutationData');

        $operation = $this->prophesize(Operation::class);
        $operation->commitWithResponse(
            $this->session,
            $mutations,
            [
                'transactionId' => self::TRANSACTION,
                'returnCommitStats' => true,
                'maxCommitDelay' => $duration,
                'requestOptions' => [
                    'transactionTag' => self::TRANSACTION_TAG
                ]
            ]
        )->shouldBeCalled()->willReturn($this->commitResponseWithCommitStats());

        $this->transaction->___setProperty('operation', $operation->reveal());

        $this->transaction->commit([
            'returnCommitStats' => true,
            'maxCommitDelay' => $duration
        ]);

        $this->assertEquals(['mutationCount' => 1], $this->transaction->getCommitStats());
    }

    public function testCommitInvalidState()
    {
        $this->expectException(\BadMethodCallException::class);

        $this->transaction->___setProperty('state', 'foo');
        $this->transaction->commit();
    }

    public function testRollback()
    {
        $this->spannerClient->rollback(
            function ($args) {
                Argument::type(RollbackRequest::class);
                $this->assertEquals($args->getSession(), $this->session->name());
                return true;
            },
            null
        );
        $this->refreshOperation(
            $this->transaction,
            $this->requestHandler->reveal(),
            $this->serializer
        );
        $this->transaction->rollback();
    }

    public function testRollbackInvalidState()
    {
        $this->expectException(\BadMethodCallException::class);

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
        $this->expectException(\BadMethodCallException::class);

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
