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
use Google\ApiCore\ServerStream;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Batch\QueryPartition;
use Google\Cloud\Spanner\Batch\ReadPartition;
use Google\Cloud\Spanner\Connection\Grpc;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\KeyRange;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\Snapshot;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\CommitResponse;
use Google\Cloud\Spanner\V1\CommitResponse\CommitStats;
use Google\Cloud\Spanner\V1\PartialResultSet;
use Google\Cloud\Spanner\V1\Partition;
use Google\Cloud\Spanner\V1\PartitionResponse;
use Google\Cloud\Spanner\V1\ResultSetMetadata;
use Google\Cloud\Spanner\V1\StructType;
use Google\Cloud\Spanner\V1\StructType\Field;
use Google\Cloud\Spanner\V1\Transaction as TransactionProto;
use Google\Cloud\Spanner\V1\Type;
use Google\Protobuf\Value;
use Google\Protobuf\Duration;
use Google\Protobuf\Timestamp as TimestampProto;
use Google\Cloud\Spanner\V1\ResultSet;
use Google\Cloud\Spanner\V1\ResultSetStats;
use Google\Cloud\Spanner\V1\TransactionOptions;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Argument;

/**
 * @group spanner
 */
class OperationTest extends TestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;
    use ApiHelperTrait;

    const SESSION = 'my-session-id';
    const TRANSACTION = 'my-transaction-id';
    const TRANSACTION_TAG = 'my-transaction-tag';
    const DATABASE = 'projects/my-awesome-project/instances/my-instance/databases/my-database';
    const TIMESTAMP = '2017-01-09T18:05:22.534799Z';

    private $operation;
    private $session;
    private $spannerClient;
    private $serializer;

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

        $session = $this->prophesize(Session::class);
        $session->name()->willReturn(self::SESSION);
        $session->info()->willReturn(['databaseName' => self::DATABASE]);
        $this->session = $session->reveal();
    }

    public function testMutation()
    {
        $res = $this->operation->mutation(Operation::OP_INSERT, 'Posts', [
            'foo' => 'bar',
            'baz' => null
        ]);

        $this->assertEquals(Operation::OP_INSERT, array_keys($res)[0]);
        $this->assertEquals('Posts', $res[Operation::OP_INSERT]['table']);
        $this->assertEquals(['foo', 'baz'], $res[Operation::OP_INSERT]['columns']);
        $this->assertEquals(['bar', null], $res[Operation::OP_INSERT]['values']);
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
        $mutation = $this->operation->mutation(Operation::OP_INSERT, 'Posts', ['foo' => 'bar']);

        $this->spannerClient->commit(
            Argument::that(function ($request) {
                $this->assertEquals('Posts', $request->getMutations()[0]->getInsert()->getTable());
                $this->assertEquals(
                    $this->serializer->encodeMessage($request->getMutations()[0]->getInsert())['values'],
                    [['bar']]
                );
                $this->assertEquals(
                    $request->getMutations()[0]->getInsert()->getColumns()[0],
                    'foo'
                );
                $this->assertEquals(self::TRANSACTION, $request->getTransactionId());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->commitResponse());

        $res = $this->operation->commit($this->session, [$mutation], [
            'transactionId' => self::TRANSACTION
        ]);

        $this->assertInstanceOf(Timestamp::class, $res);
    }

    public function testCommitWithReturnCommitStats()
    {
        $mutation = $this->operation->mutation(Operation::OP_INSERT, 'Posts', ['foo' => 'bar']);

        $this->spannerClient->commit(
            Argument::that(function ($request) {
                $this->assertEquals('Posts', $request->getMutations()[0]->getInsert()->getTable());
                $this->assertEquals('foo', $request->getTransactionId());
                $this->assertEquals(true, $request->getReturnCommitStats());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->commitResponse([
                'commit_stats' => new CommitStats(['mutation_count' => 1])
            ]));

        $res = $this->operation->commitWithResponse($this->session, [$mutation], [
            'transactionId' => 'foo',
            'returnCommitStats' => true
        ]);

        $this->assertInstanceOf(Timestamp::class, $res[0]);
        $this->assertEquals([
            'commitTimestamp' => self::TIMESTAMP,
            'commitStats' => ['mutationCount' => 1]
        ], $res[1]);
    }

    public function testCommitWithMaxCommitDelay()
    {
        $duration = new Duration(['seconds' => 0, 'nanos' => 100000000]);
        $mutation = $this->operation->mutation(Operation::OP_INSERT, 'Posts', ['foo' => 'bar']);

        $this->spannerClient->commit(
            Argument::that(function ($request) use ($duration) {
                $this->assertEquals('Posts', $request->getMutations()[0]->getInsert()->getTable());
                $this->assertEquals('foo', $request->getTransactionId());
                $this->assertEquals(
                    $duration->getSeconds(),
                    $request->getMaxCommitDelay()->getSeconds()
                );
                $this->assertEquals(
                    $duration->getNanos(),
                    $request->getMaxCommitDelay()->getNanos()
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->commitResponse());

        $res = $this->operation->commitWithResponse($this->session, [$mutation], [
            'transactionId' => 'foo',
            'maxCommitDelay' => $duration,
        ]);

        $this->assertInstanceOf(Timestamp::class, $res[0]);
        $this->assertEquals([
            'commitTimestamp' => self::TIMESTAMP,
        ], $res[1]);
    }

    public function testCommitWithExistingTransaction()
    {
        $mutation = $this->operation->mutation(Operation::OP_INSERT, 'Posts', ['foo' => 'bar']);

        $this->spannerClient->commit(
            Argument::that(function ($request) {
                $this->assertEquals('Posts', $request->getMutations()[0]->getInsert()->getTable());
                $this->assertEquals(self::TRANSACTION, $request->getTransactionId());
                return !$request->hasSingleUseTransaction();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->commitResponse());

        $res = $this->operation->commit($this->session, [$mutation], [
            'transactionId' => self::TRANSACTION
        ]);

        $this->assertInstanceOf(Timestamp::class, $res);
    }

    public function testRollback()
    {
        $this->spannerClient->rollback(
            Argument::that(function ($request) {
                $this->assertEquals(self::TRANSACTION, $request->getTransactionId());
                $this->assertEquals(self::SESSION, $request->getSession());
                return true;
            }),
            Argument::type('array')
        )->shouldBeCalledOnce();

        $this->operation->rollback($this->session, self::TRANSACTION);
    }

    public function testExecute()
    {
        $sql = 'SELECT * FROM Posts WHERE ID = @id';
        $params = ['id' => 10];

        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) use ($sql) {
                $data = $this->serializer->encodeMessage($request);
                $this->assertEquals($sql, $request->getSql());
                $this->assertEquals(self::SESSION, $request->getSession());
                $this->assertEquals(['id' => '10'], $data['params']);
                $this->assertEquals(
                    ['id' => ['code' => Database::TYPE_INT64, 'typeAnnotation' => 0, 'protoTypeFqn' => '']],
                    $data['paramTypes'],
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->executeAndReadResponseStream());

        $res = $this->operation->execute($this->session, $sql, [
            'parameters' => $params
        ]);

        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertEquals(10, $rows[0]['ID']);
    }

    public function testRead()
    {
        $this->spannerClient->streamingRead(
            Argument::that(function ($request) {
                $this->assertEquals('Posts', $request->getTable());
                $this->assertEquals(self::SESSION, $request->getSession());
                $this->assertTrue($request->getKeySet()->getAll());
                $this->assertEquals(['foo'], $this->serializer->encodeMessage($request)['columns']);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->executeAndReadResponseStream());

        $res = $this->operation->read($this->session, 'Posts', new KeySet(['all' => true]), ['foo']);
        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertEquals(10, $rows[0]['ID']);
    }

    public function testReadWithTransaction()
    {
        $this->spannerClient->streamingRead(
            Argument::that(function ($request) {
                $this->assertEquals('Posts', $request->getTable());
                $this->assertEquals(self::SESSION, $request->getSession());
                $this->assertTrue($request->getKeySet()->getAll());
                $this->assertEquals(['foo'], $this->serializer->encodeMessage($request)['columns']);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->executeAndReadResponseStream(self::TRANSACTION));

        $res = $this->operation->read($this->session, 'Posts', new KeySet(['all' => true]), ['foo'], [
            'transactionContext' => SessionPoolInterface::CONTEXT_READWRITE
        ]);

        $res->rows()->next();

        $this->assertInstanceOf(Transaction::class, $res->transaction());
        $this->assertEquals(self::TRANSACTION, $res->transaction()->id());
    }

    public function testReadWithSnapshot()
    {
        $this->spannerClient->streamingRead(
            Argument::that(function ($request) {
                $this->assertEquals('Posts', $request->getTable());
                $this->assertEquals(self::SESSION, $request->getSession());
                $this->assertTrue($request->getKeySet()->getAll());
                $this->assertEquals(['foo'], $this->serializer->encodeMessage($request)['columns']);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->executeAndReadResponseStream(self::TRANSACTION));

        $res = $this->operation->read($this->session, 'Posts', new KeySet(['all' => true]), ['foo'], [
            'transactionContext' => SessionPoolInterface::CONTEXT_READ
        ]);
        $res->rows()->next();

        $this->assertInstanceOf(Snapshot::class, $res->snapshot());
        $this->assertEquals(self::TRANSACTION, $res->snapshot()->id());
    }

    public function testTransaction()
    {
        $this->spannerClient->beginTransaction(
            Argument::that(function ($request) {
                $this->assertEquals($request->getSession(), $this->session->name());
                return $request->getRequestOptions()->getTransactionTag() == self::TRANSACTION_TAG;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $t = $this->operation->transaction($this->session, ['tag' => self::TRANSACTION_TAG]);
        $this->assertInstanceOf(Transaction::class, $t);
        $this->assertEquals(self::TRANSACTION, $t->id());
    }

    public function testTransactionNoTag()
    {
        $this->spannerClient->beginTransaction(
            Argument::that(function ($request) {
                $this->assertEquals($request->getSession(), $this->session->name());
                $this->assertEquals(0, $request->getRequestOptions()->getPriority());
                $this->assertEquals('', $request->getRequestOptions()->getRequestTag());
                $this->assertEquals('', $request->getRequestOptions()->getTransactionTag());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalled()
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $t = $this->operation->transaction($this->session);
        $this->assertInstanceOf(Transaction::class, $t);
        $this->assertEquals(self::TRANSACTION, $t->id());
    }

    public function testTransactionWithExcludeTxnFromChangeStreams()
    {
        $gapic = $this->prophesize(SpannerClient::class);
        $gapic->beginTransaction(
            self::SESSION,
            Argument::that(function (TransactionOptions $options) {
                $this->assertTrue($options->getExcludeTxnFromChangeStreams());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalled()
            ->willReturn(new TransactionProto(['id' => 'foo']));

        $operation = new Operation(
            new Grpc(['gapicSpannerClient' => $gapic->reveal()]),
            true
        );

        $transaction = $operation->transaction($this->session, [
           'transactionOptions' => ['excludeTxnFromChangeStreams' => true]
        ]);

        $this->assertEquals('foo', $transaction->id());
    }

    public function testExecuteAndExecuteUpdateWithExcludeTxnFromChangeStreams()
    {
        $sql = 'SELECT example FROM sql_query';

        $resultSet = new ResultSet(['stats' => new ResultSetStats(['row_count_exact' => 0])]);
        $stream = $this->prophesize(ServerStream::class);
        $stream->readAll()->shouldBeCalledTimes(2)->willReturn([$resultSet]);

        $gapic = $this->prophesize(SpannerClient::class);
        $gapic->executeStreamingSql(self::SESSION, $sql, Argument::that(function (array $options) {
            $this->assertArrayHasKey('transaction', $options);
            $this->assertNotNull($transactionOptions = $options['transaction']->getBegin());
            $this->assertTrue($transactionOptions->getExcludeTxnFromChangeStreams());
            return true;
        }))
            ->shouldBeCalledTimes(2)
            ->willReturn($stream->reveal());

        $operation = new Operation(
            new Grpc(['gapicSpannerClient' => $gapic->reveal()]),
            true
        );

        $operation->execute($this->session, $sql, [
           'transaction' => ['begin' => ['excludeTxnFromChangeStreams' => true]]
        ]);

        $transaction = $this->prophesize(Transaction::class)->reveal();

        $operation->executeUpdate($this->session, $transaction, $sql, [
           'transaction' => ['begin' => ['excludeTxnFromChangeStreams' => true]]
        ]);
    }

    public function testSnapshot()
    {
        $this->spannerClient->beginTransaction(
            Argument::that(function ($request) {
                return $request->getSession() == $this->session->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalled()
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $snap = $this->operation->snapshot($this->session);
        $this->assertInstanceOf(Snapshot::class, $snap);
        $this->assertEquals(Snapshot::TYPE_PRE_ALLOCATED, $snap->type());
        $this->assertEquals(self::TRANSACTION, $snap->id());
    }

    public function testSnapshotSingleUse()
    {
        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();

        $snap = $this->operation->snapshot($this->session, ['singleUse' => true]);
        $this->assertInstanceOf(Snapshot::class, $snap);
        $this->assertEquals(Snapshot::TYPE_SINGLE_USE, $snap->type());
        $this->assertNull($snap->id());
    }

    public function testSnapshotWithTimestamp()
    {
        $this->spannerClient->beginTransaction(
            Argument::that(function ($request) {
                return $request->getSession() == $this->session->name();
            }),
            Argument::type('array')
        )
            ->shouldBeCalled()
            ->willReturn(new TransactionProto([
                'id' => self::TRANSACTION,
                'read_timestamp' => new TimestampProto(['seconds' => (new \DateTime(self::TIMESTAMP))->format('U')])
            ]));

        $snap = $this->operation->snapshot($this->session);
        $this->assertInstanceOf(Snapshot::class, $snap);
        $this->assertEquals(self::TRANSACTION, $snap->id());
        $this->assertInstanceOf(Timestamp::class, $snap->readTimestamp());
    }

    public function testPartitionQuery()
    {
        $sql = 'SELECT * FROM Posts WHERE ID = @id';
        $params = ['id' => 10];
        $transactionId = 'foo';

        $partitionToken1 = 'token1';
        $partitionToken2 = 'token2';

        $this->spannerClient->partitionQuery(
            Argument::that(function ($request) use ($sql, $transactionId, $partitionToken1, $partitionToken2) {
                $this->assertEquals($request->getSql(), $sql);
                $this->assertEquals(self::SESSION, $request->getSession());
                $this->assertEquals(['id' => '10'], $request->getParams()->__debugInfo());
                $this->assertEquals(Database::TYPE_INT64, $request->getParamTypes()['id']->getCode());
                $this->assertEquals($transactionId, $request->getTransaction()->getId());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalled()
            ->willReturn(new PartitionResponse([
                'partitions' => [
                    new Partition(['partition_token' => $partitionToken1]),
                    new Partition(['partition_token' => $partitionToken2]),
                ]
            ]));

        $res = $this->operation->partitionQuery($this->session, $transactionId, $sql, [
            'parameters' => $params
        ]);

        $this->assertContainsOnlyInstancesOf(QueryPartition::class, $res);
        $this->assertCount(2, $res);
        $this->assertEquals($partitionToken1, $res[0]->token());
        $this->assertEquals($partitionToken2, $res[1]->token());
    }

    public function testPartitionRead()
    {
        $params = ['id' => 10];
        $transactionId = 'foo';

        $partitionToken1 = 'token1';
        $partitionToken2 = 'token2';

        $this->spannerClient->partitionRead(
            Argument::that(function ($request) {
                $this->assertEquals('Posts', $request->getTable());
                $this->assertEquals(self::SESSION, $request->getSession());
                $this->assertEquals(true, $request->getKeySet()->getAll());
                $this->assertEquals(['foo'], $this->serializer->encodeMessage($request)['columns']);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalled()
            ->willReturn(new PartitionResponse([
                'partitions' => [
                    new Partition(['partition_token' => $partitionToken1]),
                    new Partition(['partition_token' => $partitionToken2]),
                ]
            ]));

        $res = $this->operation->partitionRead(
            $this->session,
            $transactionId,
            'Posts',
            new KeySet(['all' => true]),
            ['foo']
        );

        $this->assertContainsOnlyInstancesOf(ReadPartition::class, $res);
        $this->assertCount(2, $res);
        $this->assertEquals($partitionToken1, $res[0]->token());
        $this->assertEquals($partitionToken2, $res[1]->token());
    }

    private function executeAndReadResponseStream(string $transactionId = null)
    {
        $stream = $this->prophesize(ServerStream::class);
        $stream->readAll()->willReturn($this->executeAndReadResponse($transactionId));

        return $stream->reveal();
    }

    private function executeAndReadResponse(string $transactionId = null)
    {
        $transactionMetadata = [];
        if ($transactionId) {
            $transactionMetadata = ['transaction' => new TransactionProto(['id' => $transactionId])];
        }
        yield new PartialResultSet([
            'metadata' => new ResultSetMetadata([
                'row_type' => new StructType([
                    'fields' => [
                        new Field([
                            'name' => 'ID',
                            'type' => new Type(['code' => Database::TYPE_INT64])
                        ]),
                    ]
                ])
            ] + $transactionMetadata),
            'values' => [
                new Value(['string_value' => '10'])
            ]
        ]);
    }

    private function commitResponse($commit = [])
    {
        return new CommitResponse($commit + [
            'commit_timestamp' => new TimestampProto([
                'seconds' => (new \DateTime(self::TIMESTAMP))->format('U'),
                'nanos' => 534799000
            ])
        ]);
    }
}
