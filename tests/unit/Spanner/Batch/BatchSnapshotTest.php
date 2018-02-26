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

namespace Google\Cloud\Tests\Unit\Spanner\Batch;

use Google\Cloud\Core\Testing\SpannerOperationRefreshTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Batch\BatchSnapshot;
use Google\Cloud\Spanner\Batch\PartitionInterface;
use Google\Cloud\Spanner\Batch\QueryPartition;
use Google\Cloud\Spanner\Batch\ReadPartition;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\V1\Gapic\SpannerGapicClient;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group spanner
 * @group spanner-batch
 * @group spanner-batch-snapshot
 */
class BatchSnapshotTest extends TestCase
{
    use SpannerOperationRefreshTrait;

    const DATABASE = 'projects/example_project/instances/example_instance/databases/example_database';
    const SESSION = 'projects/example_project/instances/example_instance/databases/example_database/sessions/session-id';
    const TRANSACTION = 'transaction-id';

    private $session;
    private $timestamp;
    private $connection;
    private $snapshot;

    public function setUp()
    {
        $sessData = SpannerGapicClient::parseName(self::SESSION, 'session');
        $this->session = $this->prophesize(Session::class);
        $this->session->name()->willReturn(self::SESSION);
        $this->session->info()->willReturn($sessData + [
            'name' => self::SESSION
        ]);

        $this->timestamp = new Timestamp(new \DateTime());

        $this->connection = $this->prophesize(ConnectionInterface::class);
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
        $db = explode('/', self::DATABASE);
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
            Argument::withEntry('database', array_pop($db)),
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
        $db = explode('/', self::DATABASE);
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
            Argument::withEntry('database', array_pop($db)),
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
        $db = explode('/', self::DATABASE);
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
            Argument::withEntry('database', array_pop($db)),
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
        $db = explode('/', self::DATABASE);
        $token = 'token';
        $db = explode('/', self::DATABASE);
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
            Argument::withEntry('database', array_pop($db)),
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

    /**
     * @expectedException BadMethodCallException
     * @expectedExceptionMessage Unsupported partition type.
     */
    public function testExecutePartitionInvalidType()
    {
        $dummy = new DummyPartition;
        $this->snapshot->executePartition($dummy);
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
}

class DummyPartition implements PartitionInterface
{
    public function __toString() {}
    public function serialize() {}
    public static function hydrate(array $data) {}
}
