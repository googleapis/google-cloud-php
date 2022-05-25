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
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Batch\QueryPartition;
use Google\Cloud\Spanner\Batch\ReadPartition;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\KeyRange;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\Snapshot;
use Google\Cloud\Spanner\Tests\StubCreationTrait;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\V1\CommitResponse;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Prophecy\Argument;

/**
 * @group spanner
 */
class OperationTest extends TestCase
{
    use GrpcTestTrait;
    use StubCreationTrait;

    const SESSION = 'my-session-id';
    const TRANSACTION = 'my-transaction-id';
    const TRANSACTION_TAG = 'my-transaction-tag';
    const DATABASE = 'projects/my-awesome-project/instances/my-instance/databases/my-database';
    const TIMESTAMP = '2017-01-09T18:05:22.534799Z';

    private $connection;
    private $operation;
    private $session;

    public function set_up()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->getConnStub();

        $this->operation = TestHelpers::stub(Operation::class, [
            $this->connection->reveal(),
            false
        ]);

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
        $mutations = [
            $this->operation->mutation(Operation::OP_INSERT, 'Posts', [
                'foo' => 'bar'
            ])
        ];

        $this->connection->commit(Argument::allOf(
            Argument::withEntry('mutations', $mutations),
            Argument::withEntry('transactionId', 'foo')
        ))->shouldBeCalled()->willReturn([
            'commitTimestamp' => self::TIMESTAMP
        ]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $this->operation->commit($this->session, $mutations, [
            'transactionId' => 'foo'
        ]);

        $this->assertInstanceOf(Timestamp::class, $res);
    }

    public function testCommitWithReturnCommitStats()
    {
        $mutations = [
            $this->operation->mutation(Operation::OP_INSERT, 'Posts', [
                'foo' => 'bar'
            ])
        ];

        $this->connection->commit(Argument::allOf(
            Argument::withEntry('mutations', $mutations),
            Argument::withEntry('transactionId', 'foo'),
            Argument::withEntry('returnCommitStats', true)
        ))->shouldBeCalled()->willReturn([
            'commitTimestamp' => self::TIMESTAMP,
            'commitStats' => ['mutationCount' => 1]
        ]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $this->operation->commitWithResponse($this->session, $mutations, [
            'transactionId' => 'foo',
            'returnCommitStats' => true
        ]);

        $this->assertInstanceOf(Timestamp::class, $res[0]);
        $this->assertEquals([
            'commitTimestamp' => self::TIMESTAMP,
            'commitStats' => ['mutationCount' => 1]
        ], $res[1]);
    }

    public function testCommitWithExistingTransaction()
    {
        $mutations = [
            $this->operation->mutation(Operation::OP_INSERT, 'Posts', [
                'foo' => 'bar'
            ])
        ];

        $this->connection->commit(Argument::allOf(
            Argument::withEntry('mutations', $mutations),
            Argument::withEntry('transactionId', self::TRANSACTION),
            Argument::that(function ($arg) {
                return !isset($arg['singleUseTransaction']);
            })
        ))->shouldBeCalled()->willReturn([
            'commitTimestamp' => self::TIMESTAMP
        ]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $this->operation->commit($this->session, $mutations, [
            'transactionId' => self::TRANSACTION
        ]);

        $this->assertInstanceOf(Timestamp::class, $res);
    }

    public function testRollback()
    {
        $this->connection->rollback(Argument::allOf(
            Argument::withEntry('transactionId', self::TRANSACTION),
            Argument::withEntry('session', self::SESSION)
        ))->shouldBeCalled();

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $this->operation->rollback($this->session, self::TRANSACTION);
    }

    public function testExecute()
    {
        $sql = 'SELECT * FROM Posts WHERE ID = @id';
        $params = ['id' => 10];

        $this->connection->executeStreamingSql(Argument::allOf(
            Argument::withEntry('sql', $sql),
            Argument::withEntry('session', self::SESSION),
            Argument::withEntry('params', ['id' => '10']),
            Argument::that(function ($arg) {
                return $arg['paramTypes']['id']['code'] === Database::TYPE_INT64;
            })
        ))->shouldBeCalled()->willReturn($this->executeAndReadResponse());

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $this->operation->execute($this->session, $sql, [
            'parameters' => $params
        ]);

        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertEquals(10, $rows[0]['ID']);
    }

    public function testRead()
    {
        $this->connection->streamingRead(Argument::allOf(
            Argument::withEntry('table', 'Posts'),
            Argument::withEntry('session', self::SESSION),
            Argument::withEntry('keySet', ['all' => true]),
            Argument::withEntry('columns', ['foo'])
        ))->shouldBeCalled()->willReturn($this->executeAndReadResponse());

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $this->operation->read($this->session, 'Posts', new KeySet(['all' => true]), ['foo']);
        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertEquals(10, $rows[0]['ID']);
    }

    public function testReadWithTransaction()
    {
        $this->connection->streamingRead(Argument::allOf(
            Argument::withEntry('table', 'Posts'),
            Argument::withEntry('session', self::SESSION),
            Argument::withEntry('keySet', ['all' => true]),
            Argument::withEntry('columns', ['foo'])
        ))->shouldBeCalled()->willReturn($this->executeAndReadResponse([
            'transaction' => ['id' => self::TRANSACTION]
        ]));

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $this->operation->read($this->session, 'Posts', new KeySet(['all' => true]), ['foo'], [
            'transactionContext' => SessionPoolInterface::CONTEXT_READWRITE
        ]);
        $res->rows()->next();

        $this->assertInstanceOf(Transaction::class, $res->transaction());
        $this->assertEquals(self::TRANSACTION, $res->transaction()->id());
    }

    public function testReadWithSnapshot()
    {
        $this->connection->streamingRead(Argument::allOf(
            Argument::withEntry('table', 'Posts'),
            Argument::withEntry('session', self::SESSION),
            Argument::withEntry('keySet', ['all' => true]),
            Argument::withEntry('columns', ['foo'])
        ))->shouldBeCalled()->willReturn($this->executeAndReadResponse([
            'transaction' => ['id' => self::TRANSACTION]
        ]));

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $this->operation->read($this->session, 'Posts', new KeySet(['all' => true]), ['foo'], [
            'transactionContext' => SessionPoolInterface::CONTEXT_READ
        ]);
        $res->rows()->next();

        $this->assertInstanceOf(Snapshot::class, $res->snapshot());
        $this->assertEquals(self::TRANSACTION, $res->snapshot()->id());
    }

    public function testTransaction()
    {
        $this->connection->beginTransaction(Argument::allOf(
            Argument::withEntry('database', self::DATABASE),
            Argument::withEntry('session', $this->session->name()),
            Argument::withEntry('requestOptions', ['transactionTag' => self::TRANSACTION_TAG])
        ))
            ->shouldBeCalled()
            ->willReturn(['id' => self::TRANSACTION]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $t = $this->operation->transaction($this->session, ['tag' => self::TRANSACTION_TAG]);
        $this->assertInstanceOf(Transaction::class, $t);
        $this->assertEquals(self::TRANSACTION, $t->id());
    }

    public function testTransactionNoTag()
    {
        $this->connection->beginTransaction(Argument::allOf(
            Argument::withEntry('database', self::DATABASE),
            Argument::withEntry('session', $this->session->name()),
            Argument::withEntry('requestOptions', [])
        ))
            ->shouldBeCalled()
            ->willReturn(['id' => self::TRANSACTION]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $t = $this->operation->transaction($this->session);
        $this->assertInstanceOf(Transaction::class, $t);
        $this->assertEquals(self::TRANSACTION, $t->id());
    }

    public function testSnapshot()
    {
        $this->connection->beginTransaction(Argument::allOf(
            Argument::withEntry('database', self::DATABASE),
            Argument::withEntry('session', $this->session->name())
        ))
            ->shouldBeCalled()
            ->willReturn(['id' => self::TRANSACTION]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $snap = $this->operation->snapshot($this->session);
        $this->assertInstanceOf(Snapshot::class, $snap);
        $this->assertEquals(Snapshot::TYPE_PRE_ALLOCATED, $snap->type());
        $this->assertEquals(self::TRANSACTION, $snap->id());
    }

    public function testSnapshotSingleUse()
    {
        $this->connection->beginTransaction(Argument::any())
            ->shouldNotBeCalled();

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $snap = $this->operation->snapshot($this->session, ['singleUse' => true]);
        $this->assertInstanceOf(Snapshot::class, $snap);
        $this->assertEquals(Snapshot::TYPE_SINGLE_USE, $snap->type());
        $this->assertNull($snap->id());
    }

    public function testSnapshotWithTimestamp()
    {
        $this->connection->beginTransaction(Argument::allOf(
            Argument::withEntry('database', self::DATABASE),
            Argument::withEntry('session', $this->session->name())
        ))
            ->shouldBeCalled()
            ->willReturn(['id' => self::TRANSACTION, 'readTimestamp' => self::TIMESTAMP]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

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

        $this->connection->partitionQuery(Argument::allOf(
            Argument::withEntry('sql', $sql),
            Argument::withEntry('session', self::SESSION),
            Argument::withEntry('params', ['id' => '10']),
            Argument::that(function ($arg) use ($transactionId) {
                if ($arg['paramTypes']['id']['code'] !== Database::TYPE_INT64) {
                    return false;
                }

                return $arg['transactionId'] === $transactionId;
            })
        ))->shouldBeCalled()->willReturn([
            'partitions' => [
                [
                    'partitionToken' => $partitionToken1
                ], [
                    'partitionToken' => $partitionToken2
                ]
            ]
        ]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

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
        $sql = 'SELECT * FROM Posts WHERE ID = @id';
        $params = ['id' => 10];
        $transactionId = 'foo';

        $partitionToken1 = 'token1';
        $partitionToken2 = 'token2';

        $this->connection->partitionRead(Argument::allOf(
            Argument::withEntry('table', 'Posts'),
            Argument::withEntry('session', self::SESSION),
            Argument::withEntry('keySet', ['all' => true]),
            Argument::withEntry('columns', ['foo'])
        ))->shouldBeCalled()->willReturn([
            'partitions' => [
                [
                    'partitionToken' => $partitionToken1
                ], [
                    'partitionToken' => $partitionToken2
                ]
            ]
        ]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $this->operation->partitionRead(
            $this->session,
            $transactionId,
            'Posts',
            new KeySet(['all' => true]),
            ['foo'],
            [
                'parameters' => $params
            ]
        );

        $this->assertContainsOnlyInstancesOf(ReadPartition::class, $res);
        $this->assertCount(2, $res);
        $this->assertEquals($partitionToken1, $res[0]->token());
        $this->assertEquals($partitionToken2, $res[1]->token());
    }

    private function executeAndReadResponse(array $additionalMetadata = [])
    {
        yield [
            'metadata' => array_merge([
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
            ], $additionalMetadata),
            'values' => [
                '10'
            ]
        ];
    }
}
