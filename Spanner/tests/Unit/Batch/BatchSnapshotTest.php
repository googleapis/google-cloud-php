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

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Batch\BatchSnapshot;
use Google\Cloud\Spanner\Batch\PartitionInterface;
use Google\Cloud\Spanner\Batch\QueryPartition;
use Google\Cloud\Spanner\Batch\ReadPartition;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Tests\OperationRefreshTrait;
use Google\Cloud\Spanner\Tests\ResultGeneratorTrait;
use Google\Cloud\Spanner\Tests\StubCreationTrait;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\V1\SpannerClient;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group spanner
 * @group spanner-batch
 * @group spanner-batch-snapshot
 */
class BatchSnapshotTest extends TestCase
{
    use ExpectException;
    use OperationRefreshTrait;
    use ResultGeneratorTrait;
    use StubCreationTrait;

    const DATABASE = 'projects/my-awesome-project/instances/my-instance/databases/my-database';
    const SESSION = 'projects/my-awesome-project/instances/my-instance/databases/my-database/sessions/session-id';
    const TRANSACTION = 'transaction-id';

    private $session;
    private $timestamp;
    private $connection;
    private $snapshot;

    public function set_up()
    {
        $sessData = SpannerClient::parseName(self::SESSION, 'session');
        $this->session = $this->prophesize(Session::class);
        $this->session->name()->willReturn(self::SESSION);
        $this->session->info()->willReturn($sessData + [
            'name' => self::SESSION,
            'databaseName' => self::DATABASE
        ]);

        $this->timestamp = new Timestamp(new \DateTime());

        $this->connection = $this->getConnStub();
        $this->snapshot = TestHelpers::stub(BatchSnapshot::class, [
            new Operation($this->connection->reveal(), false),
            $this->session->reveal(),
            ['id' => self::TRANSACTION, 'readTimestamp' => $this->timestamp]
        ], [
            'operation', 'session'
        ]);
    }

    public function testClose()
    {
        $session = $this->prophesize(Session::class);
        $session->delete([])->shouldBeCalled();

        $this->snapshot->___setProperty('session', $session->reveal());
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

        $this->connection->partitionRead(Argument::allOf(
            Argument::withEntry('session', self::SESSION),
            Argument::withEntry('database', self::DATABASE),
            Argument::withEntry('transactionId', self::TRANSACTION),
            Argument::withEntry('table', $table),
            Argument::withEntry('columns', $columns),
            Argument::withEntry('keySet', $keySet->keySetObject()),
            Argument::withEntry('index', $opts['index']),
            Argument::withEntry('partitionOptions', [
                'maxPartitions' => $opts['maxPartitions'],
                'partitionSizeBytes' => $opts['partitionSizeBytes']
            ])
        ))->shouldBeCalled()->willReturn([
            'partitions' => [
                [
                    'partitionToken' => 'token1'
                ], [
                    'partitionToken' => 'token2'
                ]
            ]
        ]);

        $this->refreshOperation($this->snapshot, $this->connection->reveal());

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

        $this->connection->partitionQuery(Argument::allOf(
            Argument::withEntry('session', self::SESSION),
            Argument::withEntry('database', self::DATABASE),
            Argument::withEntry('transactionId', self::TRANSACTION),
            Argument::withEntry('sql', $sql),
            Argument::withEntry('params', $opts['parameters']),
            Argument::withEntry('paramTypes', ['foo' => ['code' => 6]]),
            Argument::withEntry('partitionOptions', [
                'maxPartitions' => $opts['maxPartitions'],
                'partitionSizeBytes' => $opts['partitionSizeBytes']
            ])
        ))->shouldBeCalled()->willReturn([
            'partitions' => [
                [
                    'partitionToken' => 'token1'
                ], [
                    'partitionToken' => 'token2'
                ]
            ]
        ]);

        $this->refreshOperation($this->snapshot, $this->connection->reveal());

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

        $this->connection->executeStreamingSql(Argument::allOf(
            Argument::withEntry('partitionToken', $token),
            Argument::withEntry('session', self::SESSION),
            Argument::withEntry('database', self::DATABASE),
            Argument::withEntry('transaction', ['id' => self::TRANSACTION]),
            Argument::withEntry('sql', $sql),
            Argument::withEntry('params', $opts['parameters']),
            Argument::withEntry('paramTypes', ['foo' => ['code' => 6]])
        ))->shouldBeCalled()->willReturn($this->resultGenerator());

        $this->refreshOperation($this->snapshot, $this->connection->reveal());
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

        $this->connection->streamingRead(Argument::allOf(
            Argument::withEntry('partitionToken', $token),
            Argument::withEntry('session', self::SESSION),
            Argument::withEntry('database', self::DATABASE),
            Argument::withEntry('transaction', ['id' => self::TRANSACTION]),
            Argument::withEntry('table', $table),
            Argument::withEntry('columns', $columns),
            Argument::withEntry('keySet', $keySet->keySetObject()),
            Argument::withEntry('index', $opts['index'])
        ))->shouldBeCalled()->willReturn($this->resultGenerator());

        $this->refreshOperation($this->snapshot, $this->connection->reveal());
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
        $this->expectException('BadMethodCallException');
        $this->expectExceptionMessage('Unsupported partition type.');

        $dummy = new DummyPartition;
        $this->snapshot->executePartition($dummy);
    }
}

//@codingStandardsIgnoreStart
class DummyPartition implements PartitionInterface
{
    public function __toString() {}
    public function serialize() {}
    public static function hydrate(array $data) {}
}
//@codingStandardsIgnoreEnd
