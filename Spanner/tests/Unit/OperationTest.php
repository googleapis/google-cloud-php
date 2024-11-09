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
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Protobuf\Duration;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner
 */
class OperationTest extends TestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;

    const SESSION = 'my-session-id';
    const TRANSACTION = 'my-transaction-id';
    const TRANSACTION_TAG = 'my-transaction-tag';
    const DATABASE = 'projects/my-awesome-project/instances/my-instance/databases/my-database';
    const TIMESTAMP = '2017-01-09T18:05:22.534799Z';

    private $operation;
    private $session;
    private $requestHandler;
    private $serializer;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->serializer = new Serializer();

        $this->operation = TestHelpers::stub(Operation::class, [
            $this->requestHandler->reveal(),
            $this->serializer,
            false
        ], ['requestHandler', 'serializer']);

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

        $this->spannerClient->commit(
            function ($args) use ($mutations) {
                $mutations[0]['insert']['values'] = [$mutations[0]['insert']['values']];
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['mutations'], $mutations);
                $this->assertEquals($message['transactionId'], self::TRANSACTION);
                return true;
            },
            ['commitTimestamp' => self::TIMESTAMP]
        );

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->operation->___setProperty('serializer', $this->serializer);

        $res = $this->operation->commit($this->session, $mutations, [
            'transactionId' => self::TRANSACTION
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

        $this->spannerClient->commit(
            function ($args) use ($mutations) {
                $mutations[0]['insert']['values'] = [$mutations[0]['insert']['values']];
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['mutations'], $mutations);
                $this->assertEquals($message['transactionId'], 'foo');
                $this->assertEquals($message['returnCommitStats'], true);
                return true;
            },
            [
                'commitTimestamp' => self::TIMESTAMP,
                'commitStats' => ['mutationCount' => 1]
            ]
        );

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->operation->___setProperty('serializer', $this->serializer);

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

    public function testCommitWithMaxCommitDelay()
    {
        $duration = new Duration(['seconds' => 0, 'nanos' => 100000000]);
        $mutations = [
            $this->operation->mutation(Operation::OP_INSERT, 'Posts', [
                'foo' => 'bar'
            ])
        ];

        $this->spannerClient->commit(
            function ($args) use ($mutations, $duration) {
                $mutations[0]['insert']['values'] = [$mutations[0]['insert']['values']];
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['mutations'], $mutations);
                $this->assertEquals($message['transactionId'], 'foo');
                $this->assertEquals(
                    $message['maxCommitDelay']['seconds'],
                    $duration->getSeconds()
                );
                $this->assertEquals(
                    $message['maxCommitDelay']['nanos'],
                    $duration->getNanos()
                );
                return true;
            },
            [
                'commitTimestamp' => self::TIMESTAMP,
            ]
        );

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->operation->___setProperty('serializer', $this->serializer);

        $res = $this->operation->commitWithResponse($this->session, $mutations, [
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
        $mutations = [
            $this->operation->mutation(Operation::OP_INSERT, 'Posts', [
                'foo' => 'bar'
            ])
        ];

        $this->spannerClient->commit(
            function ($args) use ($mutations) {
                $mutations[0]['insert']['values'] = [$mutations[0]['insert']['values']];
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['mutations'], $mutations);
                $this->assertEquals($message['transactionId'], self::TRANSACTION);
                return !isset($message['singleUseTransaction']);
            },
            [
                'commitTimestamp' => self::TIMESTAMP
            ]
        );

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->operation->___setProperty('serializer', $this->serializer);

        $res = $this->operation->commit($this->session, $mutations, [
            'transactionId' => self::TRANSACTION
        ]);

        $this->assertInstanceOf(Timestamp::class, $res);
    }

    public function testRollback()
    {
        $this->spannerClient->rollback(
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['transactionId'], self::TRANSACTION);
                $this->assertEquals($message['session'], self::SESSION);
                return true;
            },
            null
        );

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->operation->___setProperty('serializer', $this->serializer);

        $this->operation->rollback($this->session, self::TRANSACTION);
    }

    public function testExecute()
    {
        $sql = 'SELECT * FROM Posts WHERE ID = @id';
        $params = ['id' => 10];

        $this->spannerClient->executeStreamingSql(
            function ($args) use ($sql) {
                $this->assertEquals($args->getSql(), $sql);
                $this->assertEquals($args->getSession(), self::SESSION);
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['params'], ['id' => '10']);
                $this->assertEquals(
                    $message['paramTypes'],
                    ['id' => ['code' => Database::TYPE_INT64, 'typeAnnotation' => 0, 'protoTypeFqn' => '']]
                );
                return true;
            },
            $this->executeAndReadResponse()
        );

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->operation->___setProperty('serializer', $this->serializer);

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
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['table'], 'Posts');
                $this->assertEquals($message['session'], self::SESSION);
                $this->assertTrue($message['keySet']['all']);
                $this->assertEquals($message['columns'], ['foo']);
                return true;
            },
            $this->executeAndReadResponse()
        );

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->operation->___setProperty('serializer', $this->serializer);

        $res = $this->operation->read($this->session, 'Posts', new KeySet(['all' => true]), ['foo']);
        $this->assertInstanceOf(Result::class, $res);
        $rows = iterator_to_array($res->rows());
        $this->assertEquals(10, $rows[0]['ID']);
    }

    public function testReadWithTransaction()
    {
        $this->spannerClient->streamingRead(
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['table'], 'Posts');
                $this->assertEquals($message['session'], self::SESSION);
                $this->assertTrue($message['keySet']['all']);
                $this->assertEquals($message['columns'], ['foo']);
                return true;
            },
            $this->executeAndReadResponse(['transaction' => ['id' => self::TRANSACTION]])
        );

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->operation->___setProperty('serializer', $this->serializer);

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
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['table'], 'Posts');
                $this->assertEquals($message['session'], self::SESSION);
                $this->assertTrue($message['keySet']['all']);
                $this->assertEquals($message['columns'], ['foo']);
                return true;
            },
            $this->executeAndReadResponse(['transaction' => ['id' => self::TRANSACTION]])
        );

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->operation->___setProperty('serializer', $this->serializer);

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
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['session'], $this->session->name());
                return $message['requestOptions']['transactionTag'] == self::TRANSACTION_TAG;
            },
            ['id' => self::TRANSACTION]
        );

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->operation->___setProperty('serializer', $this->serializer);

        $t = $this->operation->transaction($this->session, ['tag' => self::TRANSACTION_TAG]);
        $this->assertInstanceOf(Transaction::class, $t);
        $this->assertEquals(self::TRANSACTION, $t->id());
    }

    public function testTransactionNoTag()
    {
        $this->spannerClient->beginTransaction(
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['session'], $this->session->name());
                return $message['requestOptions'] == [
                    'priority' => 0,
                    'requestTag' => '',
                    'transactionTag' => '',
                ];
            },
            ['id' => self::TRANSACTION]
        );

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->operation->___setProperty('serializer', $this->serializer);

        $t = $this->operation->transaction($this->session);
        $this->assertInstanceOf(Transaction::class, $t);
        $this->assertEquals(self::TRANSACTION, $t->id());
    }

    public function testSnapshot()
    {
        $this->spannerClient->beginTransaction(
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return $message['session'] == $this->session->name();
            },
            ['id' => self::TRANSACTION]
        );

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->operation->___setProperty('serializer', $this->serializer);

        $snap = $this->operation->snapshot($this->session);
        $this->assertInstanceOf(Snapshot::class, $snap);
        $this->assertEquals(Snapshot::TYPE_PRE_ALLOCATED, $snap->type());
        $this->assertEquals(self::TRANSACTION, $snap->id());
    }

    public function testSnapshotSingleUse()
    {
        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->operation->___setProperty('serializer', $this->serializer);

        $snap = $this->operation->snapshot($this->session, ['singleUse' => true]);
        $this->assertInstanceOf(Snapshot::class, $snap);
        $this->assertEquals(Snapshot::TYPE_SINGLE_USE, $snap->type());
        $this->assertNull($snap->id());
    }

    public function testSnapshotWithTimestamp()
    {
        $this->spannerClient->beginTransaction(
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                return $message['session'] == $this->session->name();
            },
            ['id' => self::TRANSACTION, 'readTimestamp' => self::TIMESTAMP]
        );

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->operation->___setProperty('serializer', $this->serializer);

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
            function ($args) use ($sql, $transactionId, $partitionToken1, $partitionToken2) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['sql'], $sql);
                $this->assertEquals($message['session'], self::SESSION);
                $this->assertEquals($message['params'], ['id' => '10']);
                $this->assertEquals($message['paramTypes']['id']['code'], Database::TYPE_INT64);
                $this->assertEquals($message['transaction']['id'], $transactionId);
                return true;
            },
            [
                'partitions' => [
                    [
                        'partitionToken' => $partitionToken1
                    ], [
                        'partitionToken' => $partitionToken2
                    ]
                ]
            ]
        );
        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->operation->___setProperty('serializer', $this->serializer);

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
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['table'], 'Posts');
                $this->assertEquals($message['session'], self::SESSION);
                $this->assertEquals($message['keySet']['all'], true);
                $this->assertEquals($message['columns'], ['foo']);
                return true;
            },
            [
                'partitions' => [
                    [
                        'partitionToken' => $partitionToken1
                    ], [
                        'partitionToken' => $partitionToken2
                    ]
                ]
            ]
        );
        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->operation->___setProperty('serializer', $this->serializer);

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
