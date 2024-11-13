<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\Cloud\Spanner\Tests\Unit\Batch;

use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\Serializer;
use Google\Cloud\Spanner\Batch\BatchSnapshot;
use Google\Cloud\Spanner\Batch\PartitionInterface;
use Google\Cloud\Spanner\Batch\QueryPartition;
use Google\Cloud\Spanner\Batch\ReadPartition;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Tests\ResultGeneratorTrait;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\ExecuteSqlRequest;
use Google\Cloud\Spanner\V1\Partition;
use Google\Cloud\Spanner\V1\PartitionQueryRequest;
use Google\Cloud\Spanner\V1\PartitionReadRequest;
use Google\Cloud\Spanner\V1\PartitionResponse;
use Google\Cloud\Spanner\V1\ReadRequest;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner
 * @group spanner-batch
 * @group spanner-batch-snapshot
 */
class BatchSnapshotTest extends TestCase
{
    use ProphecyTrait;
    use ResultGeneratorTrait;
    use ApiHelperTrait;

    const DATABASE = 'projects/my-awesome-project/instances/my-instance/databases/my-database';
    const SESSION = 'projects/my-awesome-project/instances/my-instance/databases/my-database/sessions/session-id';
    const TRANSACTION = 'transaction-id';

    private $spannerClient;
    private $serializer;
    private $session;
    private $timestamp;
    private $snapshot;

    public function setUp(): void
    {
        $sessData = SpannerClient::parseName(self::SESSION, 'session');
        $this->session = $this->prophesize(Session::class);
        $this->session->name()->willReturn(self::SESSION);
        $this->session->info()->willReturn($sessData + [
            'name' => self::SESSION,
            'databaseName' => self::DATABASE
        ]);

        $this->timestamp = new Timestamp(new \DateTime());

        $this->serializer = new Serializer();
        $this->spannerClient = $this->prophesize(SpannerClient::class);

        $this->snapshot = new BatchSnapshot(
            new Operation($this->spannerClient->reveal(), $this->serializer, false),
            $this->session->reveal(),
            ['id' => self::TRANSACTION, 'readTimestamp' => $this->timestamp]
        );
    }

    public function testClose()
    {
        $session = $this->prophesize(Session::class);
        $session->delete([])->shouldBeCalledOnce();

        $this->snapshot = new BatchSnapshot(
            $this->prophesize(Operation::class)->reveal(),
            $session->reveal()
        );

        $this->snapshot->close();
    }

    public function testPartitionRead()
    {
        $table = 'table';
        $keySet = new KeySet(['all' =>  true]);
        $columns = ['a', 'b'];
        $opts = [
            'index' => 'foo',
            'maxPartitions' => 10,
            'partitionSizeBytes' => 1
        ];

        $expectedArguments = [
            'session' => self::SESSION,
            'transaction' => ['id' => self::TRANSACTION],
            'table' => $table,
            'columns' => $columns,
            'keySet' => $keySet->keySetObject() + ['keys' => [], 'ranges' => []],
            'index' => $opts['index'],
            'partitionOptions' => [
                'maxPartitions' => $opts['maxPartitions'],
                'partitionSizeBytes' => $opts['partitionSizeBytes']
            ]
        ];

        $this->spannerClient->partitionRead(
            Argument::that(function (PartitionReadRequest $request) use ($expectedArguments) {
                $actualArguments = $this->serializer->encodeMessage($request);
                return $actualArguments == $expectedArguments;
            }),
            Argument::type('array')
        )->shouldBeCalledOnce()->willReturn(new PartitionResponse([
            'partitions' => [
                new Partition(['partition_token' => 'token1']),
                new Partition(['partition_token' => 'token2'])
            ]
        ]));

        $partitions = $this->snapshot->partitionRead($table, $keySet, $columns, $opts);
        $this->assertContainsOnlyInstancesOf(ReadPartition::class, $partitions);

        $this->assertEquals('token1', $partitions[0]->token());
        $this->assertEquals('token2', $partitions[1]->token());

        $this->assertEquals($opts, $partitions[0]->options());
    }

    public function testPartitionQuery()
    {
        $sql = 'SELECT 1=1';
        $opts = [
            'parameters' => [
                'foo' => 'bar'
            ],
            'maxPartitions' => 10,
            'partitionSizeBytes' => 1
        ];

        $expectedArguments = [
            'session' => self::SESSION,
            'transaction' => ['id' => self::TRANSACTION],
            'sql' => $sql,
            'params' => $opts['parameters'],
            'paramTypes' => ['foo' => ['code' => 6, 'typeAnnotation' => 0, 'protoTypeFqn' => '']],
            'partitionOptions' => [
                'maxPartitions' => $opts['maxPartitions'],
                'partitionSizeBytes' => $opts['partitionSizeBytes']
            ]
        ];

        $this->spannerClient->partitionQuery(
            Argument::that(function (PartitionQueryRequest $request) use ($expectedArguments) {
                $actualArguments = $this->serializer->encodeMessage($request);
                return $actualArguments == $expectedArguments;
            }),
            Argument::type('array')
        )->shouldBeCalledOnce()->willReturn(new PartitionResponse([
                'partitions' => [
                    new Partition(['partition_token' => 'token1']),
                    new Partition(['partition_token' => 'token2'])
                ]
            ]));

        $partitions = $this->snapshot->partitionQuery($sql, $opts);
        $this->assertContainsOnlyInstancesOf(QueryPartition::class, $partitions);

        $this->assertEquals('token1', $partitions[0]->token());
        $this->assertEquals('token2', $partitions[1]->token());

        $this->assertEquals($sql, $partitions[0]->sql());
        $this->assertEquals($opts, $partitions[0]->options());
    }

    public function testExecuteQueryPartition()
    {
        $token = 'token';
        $sql = 'SELECT 1=1';
        $opts = [
            'parameters' => [
                'foo' => 'bar'
            ]
        ];

        $partition = new QueryPartition($token, $sql, $opts);

        $this->spannerClient->executeStreamingSql(
            Argument::that(function (ExecuteSqlRequest $request) use ($sql, $opts, $token) {
                $this->assertEquals($request->getSql(), $sql);
                $this->assertEquals($request->getSession(), self::SESSION);
                $this->assertEquals($request->getTransaction()->getId(), self::TRANSACTION);
                $this->assertEquals($request->getPartitionToken(), $token);
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals($message['params'], $opts['parameters']);
                $this->assertEquals(
                    $message['paramTypes'],
                    ['foo' => ['code' => 6, 'typeAnnotation' => 0, 'protoTypeFqn' => '']]
                );
                return true;
            }),
            Argument::type('array')
        )->shouldBeCalledOnce()->willReturn(
            $this->resultGeneratorStream()
        );

        $res = $this->snapshot->executePartition($partition);
        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertEquals(10, $rows[0]['ID']);
    }

    public function testExecuteReadPartition()
    {
        $token = 'token';
        $table = 'table';
        $keySet = new KeySet(['all' =>  true]);
        $columns = ['a', 'b'];
        $opts = [
            'index' => 'foo',
        ];

        $partition = new ReadPartition($token, $table, $keySet, $columns, $opts);

        $this->spannerClient->streamingRead(
            Argument::that(function (ReadRequest $request) use ($token, $table, $columns, $keySet, $opts) {
                $this->assertEquals($request->getSession(), self::SESSION);
                $this->assertEquals($request->getPartitionToken(), $token);
                $this->assertEquals($request->getTable(), $table);
                $this->assertEquals($request->getIndex(), $opts['index']);
                $this->assertEquals(iterator_to_array($request->getColumns()), $columns);
                $this->assertEquals(
                    $request->getTransaction()->getId(),
                    self::TRANSACTION
                );
                $this->assertTrue($this->serializer->encodeMessage($request->getKeySet())['all']);
                return true;
            }),
            Argument::type('array')
        )->shouldBeCalledOnce()->willReturn(
            $this->resultGeneratorStream()
        );

        $res = $this->snapshot->executePartition($partition);
        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertEquals(10, $rows[0]['ID']);
    }

    public function testSerialize()
    {
        $identifier = base64_encode(json_encode([
            'sessionName' => $this->session->reveal()->name(),
            'transactionId' => self::TRANSACTION,
            'readTimestamp' => (string) $this->timestamp
        ]));

        $this->assertEquals($identifier, $this->snapshot->serialize());
        $this->assertEquals($identifier, (string) $this->snapshot);
    }

    public function testExecutePartitionInvalidType()
    {
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('Unsupported partition type.');

        $dummy = new DummyPartition();
        $this->snapshot->executePartition($dummy);
    }
}

//@codingStandardsIgnoreStart
class DummyPartition implements PartitionInterface
{
    public function __toString()
    {
    }
    public function serialize()
    {
    }
    public static function hydrate(array $data)
    {
    }
}
//@codingStandardsIgnoreEnd
