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
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\Snapshot;
use Google\Cloud\Spanner\Tests\RequestHandlingTestTrait;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\V1\BeginTransactionRequest;
use Google\Cloud\Spanner\V1\BeginTransactionResponse;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\CommitRequest;
use Google\Cloud\Spanner\V1\CommitResponse;
use Google\Cloud\Spanner\V1\CreateSessionRequest;
use Google\Cloud\Spanner\V1\ExecuteSqlRequest;
use Google\Cloud\Spanner\V1\ReadRequest;
use Google\Cloud\Spanner\V1\RollbackRequest;
use Google\Cloud\Spanner\V1\Session;
use Google\Cloud\Spanner\V1\Transaction as TransactionProto;
use Google\Cloud\Spanner\V1\TransactionOptions;
use Google\Cloud\Spanner\V1\TransactionSelector;
use Google\Cloud\Spanner\V1\TransactionOptions\PBReadOnly;
use Google\Cloud\Spanner\V1\TransactionOptions\ReadWrite;
use Google\Protobuf\Duration;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Google\Protobuf\Timestamp as ProtoTimestamp;

/**
 * @group spanner
 * @group spanner-transaction-type
 */
class TransactionTypeTest extends TestCase
{
    use ApiHelperTrait;
    use GrpcTestTrait;
    use ProphecyTrait;
    use ResultTestTrait;
    use TimeTrait;

    const PROJECT = 'my-project';
    const INSTANCE = 'my-instance';
    const DATABASE = 'my-database';
    const TRANSACTION = 'my-transaction';
    const SESSION = 'my-session';

    private $spannerClient;
    private $serializer;
    private $timestamp;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->timestamp = (new Timestamp(\DateTime::createFromFormat('U', time()), 500000005))->formatAsString();

        $this->spannerClient = $this->prophesize(SpannerClient::class);
        $this->serializer = new Serializer();
        $this->spannerClient->createSession(
            Argument::that(function (CreateSessionRequest $request) {
                $this->assertEquals(
                    $request->getDatabase(),
                    SpannerClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new Session(['name' => $this->getFullyQualifiedSessionName()]));

        $this->spannerClient->deleteSession()
            ->shouldBeCalled();
    }

    public function testDatabaseRunTransactionPreAllocate()
    {
        $this->spannerClient->beginTransaction(
            Argument::that(function ($request) {
                Argument::type(BeginTransactionRequest::class);
                $this->assertEquals($request->getSession(), $this->getFullyQualifiedSessionName());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $this->spannerClient->commit(
            Argument::that(function ($request) {
                Argument::type(CommitRequest::class);
                $this->assertEquals($request->getTransactionId(), self::TRANSACTION);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new CommitResponse(['commit_timestamp' => $this->timestamp]));

        $database = $this->database(
            $this->spannerClient->reveal(),
            $this->serializer
        );

        $database->runTransaction(function ($t) {
            // Transaction gets created at the commit operation
            $t->commit();
        });
    }

    public function testDatabaseRunTransactionSingleUse()
    {
        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();

        $this->spannerClient->commit(
            Argument::that(function ($request) {
                Argument::type(CommitRequest::class);
                $this->assertEquals(
                    $request->getSingleUseTransaction(),
                    $this->createTransactionOptions()
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new CommitResponse(['commit_timestamp' => $this->timestamp]));

        $database = $this->database(
            $this->spannerClient->reveal(),
            $this->serializer
        );

        $database->runTransaction(function ($t) {
            $this->assertNull($t->id());

            $t->commit();
        }, ['singleUse' => true]);
    }

    public function testDatabaseTransactionPreAllocate()
    {
        $this->spannerClient->beginTransaction(
            Argument::that(function ($request) {
                Argument::type(BeginTransactionRequest::class);
                $this->assertEquals($request->getOptions(), $this->createTransactionOptions());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $database = $this->database($this->spannerClient->reveal());
        $transaction = $database->transaction();

        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertEquals($transaction->id(), self::TRANSACTION);
    }

    public function testDatabaseTransactionSingleUse()
    {
        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();

        $database = $this->database(
            $this->spannerClient->reveal(),
            $this->serializer
        );

        $transaction = $database->transaction(['singleUse' => true]);

        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertNull($transaction->id());
    }

    public function testDatabaseSnapshotPreAllocate()
    {
        $this->spannerClient->beginTransaction(
            Argument::that(function ($request) {
                Argument::type(BeginTransactionRequest::class);
                $this->assertEquals(
                    $request->getOptions(),
                    $this->createTransactionOptions(['readOnly' => ['strong' => true]])
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $database = $database = $this->database(
            $this->spannerClient->reveal(),
            $this->serializer
        );

        $snapshot = $database->snapshot();

        $this->assertInstanceOf(Snapshot::class, $snapshot);
        $this->assertEquals($snapshot->id(), self::TRANSACTION);
    }

    public function testDatabaseSnapshotSingleUse()
    {
        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();

        $database = $database = $this->database(
            $this->spannerClient->reveal(),
            $this->serializer
        );

        $snapshot = $database->snapshot(['singleUse' => true]);

        $this->assertInstanceOf(Snapshot::class, $snapshot);
        $this->assertNull($snapshot->id());
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseSingleUseSnapshotMinReadTimestampAndMaxStaleness($chunks)
    {
        $seconds = 1;
        $nanos = 2;

        $time = $this->parseTimeString($this->timestamp);
        $timestamp = new Timestamp($time[0], $time[1]);
        $duration = new Duration(['seconds' => $seconds, 'nanos' => $nanos]);

        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();

        $transaction = new TransactionSelector([
            'single_use' => new TransactionOptions([
                'read_only' => new PBReadOnly([
                    'min_read_timestamp' => new ProtoTimestamp([
                        'seconds' => $time[0]->format('U'),
                        'nanos' => $time[1]
                    ]),
                    'max_staleness' => $duration,
                ])
            ])
        ]);

        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) use ($transaction) {
                Argument::type(ExecuteSqlRequest::class);
                $this->assertEquals($request->getTransaction(), $transaction);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $database = $this->database($this->spannerClient->reveal());
        $snapshot = $database->snapshot([
            'singleUse' => true,
            'minReadTimestamp' => $timestamp,
            'maxStaleness' => $duration
        ]);

        $result = $snapshot->execute('SELECT * FROM Table')->rows()->current();
    }

    public function testDatabasePreAllocatedSnapshotMinReadTimestamp()
    {
        $this->expectException(\BadMethodCallException::class);

        $time = $this->parseTimeString($this->timestamp);
        $timestamp = new Timestamp($time[0], $time[1]);

        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();
        $this->spannerClient->executeStreamingSql(Argument::cetera())->shouldNotBeCalled();

        $database = $this->database($this->spannerClient->reveal());

        $snapshot = $database->snapshot([
            'minReadTimestamp' => $timestamp,
        ]);
    }

    public function testDatabasePreAllocatedSnapshotMaxStaleness()
    {
        $this->expectException(\BadMethodCallException::class);

        $seconds = 1;
        $nanos = 2;

        $duration = new Duration(['seconds' => $seconds, 'nanos' => $nanos]);

        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();
        $this->spannerClient->executeStreamingSql(Argument::cetera())->shouldNotBeCalled();

        $database = $this->database($this->spannerClient->reveal());

        $snapshot = $database->snapshot([
            'maxStaleness' => $duration
        ]);
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseSnapshotSingleUseReadTimestampAndExactStaleness($chunks)
    {
        $seconds = 1;
        $nanos = 2;

        $time = $this->parseTimeString($this->timestamp);
        $timestamp = new Timestamp($time[0], $time[1]);
        $duration = new Duration(['seconds' => $seconds, 'nanos' => $nanos]);
        $transaction = new TransactionSelector([
            'single_use' => new TransactionOptions([
                'read_only' => new PBReadOnly([
                    'min_read_timestamp' => new ProtoTimestamp([
                        'seconds' => $time[0]->format('U'),
                        'nanos' => $time[1]
                    ]),
                    'exact_staleness' => $duration,
                ])
            ])
        ]);

        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();

        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) use ($transaction) {
                Argument::type(ExecuteSqlRequest::class);
                $this->assertEquals($request->getTransaction(), $transaction);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $database = $this->database($this->spannerClient->reveal());

        $snapshot = $database->snapshot([
            'singleUse' => true,
            'readTimestamp' => $timestamp,
            'exactStaleness' => $duration
        ]);

        $snapshot->execute('SELECT * FROM Table')->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseSnapshotPreAllocateReadTimestampAndExactStaleness($chunks)
    {
        $seconds = 1;
        $nanos = 2;

        $time = $this->parseTimeString($this->timestamp);
        $timestamp = new Timestamp($time[0], $time[1]);
        $duration = new Duration(['seconds' => $seconds, 'nanos' => $nanos]);
        $options = [
            'readOnly' => [
                'readTimestamp' => $this->formatTimestampForApi($this->timestamp),
                'exactStaleness' => [
                    'seconds' => $seconds,
                    'nanos' => $nanos
                ]
            ]
        ];
        $this->spannerClient->beginTransaction(
            Argument::that(function ($request) use ($options) {
                Argument::type(BeginTransactionRequest::class);
                $this->assertEquals(
                    $request->getOptions(),
                    $this->createTransactionOptions($options)
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) {
                Argument::type(ExecuteSqlRequest::class);
                $this->assertEquals($request->getTransaction()->getId(), self::TRANSACTION);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $database = $this->database($this->spannerClient->reveal());

        $snapshot = $database->snapshot([
            'readTimestamp' => $timestamp,
            'exactStaleness' => $duration
        ]);

        $snapshot->execute('SELECT * FROM Table')->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseSingleUseSnapshotStrongConsistency($chunks)
    {
        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();
        $transaction = new TransactionSelector([
            'single_use' => new TransactionOptions([
                'read_only' => new PBReadOnly([
                    'strong' => true
                ])
            ])
        ]);
        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) use ($transaction) {
                Argument::type(executeSqlRequest::class);
                $this->assertEquals($request->getTransaction(), $transaction);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));
        $database = $this->database($this->spannerClient->reveal());

        $snapshot = $database->snapshot([
            'singleUse' => true,
            'strong' => true
        ]);

        $snapshot->execute('SELECT * FROM Table')->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabasePreAllocatedSnapshotStrongConsistency($chunks)
    {
        $options = [
            'readOnly' => [
                'strong' => true
            ]
        ];
        $this->spannerClient->beginTransaction(
            Argument::that(function ($request) use ($options) {
                Argument::type(BeginTransactionRequest::class);
                $this->assertEquals(
                    $request->getOptions(),
                    $this->createTransactionOptions($options)
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) {
                Argument::type(executeSqlRequest::class);
                $this->assertEquals($request->getTransaction()->getId(), self::TRANSACTION);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $database = $this->database($this->spannerClient->reveal());

        $snapshot = $database->snapshot([
            'strong' => true
        ]);

        $snapshot->execute('SELECT * FROM Table')->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseSingleUseSnapshotDefaultsToStrongConsistency($chunks)
    {
        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();
        $transaction = new TransactionSelector([
            'single_use' => new TransactionOptions([
                'read_only' => new PBReadOnly([
                    'strong' => true
                ])
            ])
        ]);
        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) use ($transaction) {
                Argument::type(executeSqlRequest::class);
                $this->assertEquals($request->getTransaction(), $transaction);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $database = $this->database($this->spannerClient->reveal());

        $snapshot = $database->snapshot([
            'singleUse' => true,
        ]);

        $snapshot->execute('SELECT * FROM Table')->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabasePreAllocatedSnapshotDefaultsToStrongConsistency($chunks)
    {
        $options = [
            'readOnly' => [
                'strong' => true
            ]
        ];
        $this->spannerClient->beginTransaction(
            Argument::that(function ($request) use ($options) {
                Argument::type(BeginTransactionRequest::class);
                $this->assertEquals(
                    $request->getOptions(),
                    $this->createTransactionOptions($options)
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) {
                Argument::type(executeSqlRequest::class);
                $this->assertEquals($request->getTransaction()->getId(), self::TRANSACTION);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $database = $this->database($this->spannerClient->reveal());

        $snapshot = $database->snapshot();

        $snapshot->execute('SELECT * FROM Table')->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseSnapshotReturnReadTimestamp($chunks)
    {
        $options = [
            'readOnly' => [
                'returnReadTimestamp' => true
            ]
        ];
        $this->spannerClient->beginTransaction(
            Argument::that(function ($request) use ($options) {
                Argument::type(BeginTransactionRequest::class);
                $this->assertEquals(
                    $request->getOptions(),
                    $this->createTransactionOptions($options)
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) {
                Argument::type(executeSqlRequest::class);
                $this->assertEquals($request->getTransaction()->getId(), self::TRANSACTION);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $database = $this->database($this->spannerClient->reveal());

        $snapshot = $database->snapshot([
            'returnReadTimestamp' => true
        ]);

        $snapshot->execute('SELECT * FROM Table')->rows()->current();
    }

    public function testDatabaseInsertSingleUseReadWrite()
    {
        $this->spannerClient->commit(
            Argument::that(function ($request) {
                Argument::type(CommitRequest::class);
                $this->assertEquals(
                    $request->getSingleUseTransaction(),
                    $this->createTransactionOptions()
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new CommitResponse(['commit_timestamp' => $this->timestamp]));

        $database = $this->database($this->spannerClient->reveal());

        $database->insert('Table', [
            'column' => 'value'
        ]);
    }

    public function testDatabaseInsertBatchSingleUseReadWrite()
    {
        $database = $this->createMockedCommitDatabase();

        $database->insertBatch('Table', [[
            'column' => 'value'
        ]]);
    }

    public function testDatabaseUpdateSingleUseReadWrite()
    {
        $database = $this->createMockedCommitDatabase();

        $database->update('Table', [
            'column' => 'value'
        ]);
    }

    public function testDatabaseUpdateBatchSingleUseReadWrite()
    {
        $database = $this->createMockedCommitDatabase();

        $database->updateBatch('Table', [[
            'column' => 'value'
        ]]);
    }

    public function testDatabaseInsertOrUpdateSingleUseReadWrite()
    {
        $database = $this->createMockedCommitDatabase();

        $database->insertOrUpdate('Table', [
            'column' => 'value'
        ]);
    }

    public function testDatabaseInsertOrUpdateBatchSingleUseReadWrite()
    {
        $database = $this->createMockedCommitDatabase();

        $database->insertOrUpdateBatch('Table', [[
            'column' => 'value'
        ]]);
    }

    public function testDatabaseReplaceSingleUseReadWrite()
    {
        $database = $this->createMockedCommitDatabase();

        $database->replace('Table', [
            'column' => 'value'
        ]);
    }

    public function testDatabaseReplaceBatchSingleUseReadWrite()
    {
        $database = $this->createMockedCommitDatabase();

        $database->replaceBatch('Table', [[
            'column' => 'value'
        ]]);
    }

    public function testDatabaseDeleteSingleUseReadWrite()
    {
        $database = $this->createMockedCommitDatabase();

        $database->delete('Table', new KeySet);
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseExecuteSingleUseReadOnly($chunks)
    {
        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();
        $transaction = new TransactionSelector([
            'single_use' => new TransactionOptions([
                'read_only' => new PBReadOnly([
                    'strong' => true
                ])
            ])
        ]);
        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) use ($transaction) {
                Argument::type(ExecuteSqlRequest::class);
                $this->assertEquals($request->getTransaction(), $transaction);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $database = $this->database($this->spannerClient->reveal());
        $database->execute('SELECT * FROM Table')->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseExecuteBeginReadOnly($chunks)
    {
        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();
        $transaction = new TransactionSelector([
            'begin' => new TransactionOptions([
                'read_only' => new PBReadOnly([
                    'strong' => true
                ])
            ])
        ]);
        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) use ($transaction) {
                Argument::type(executeSqlRequest::class);
                $this->assertEquals($request->getTransaction(), $transaction);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $database = $this->database($this->spannerClient->reveal());
        $database->execute('SELECT * FROM Table', [
            'begin' => true
        ])->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseExecuteBeginReadWrite($chunks)
    {
        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();
        $transaction = new TransactionSelector([
            'begin' => new TransactionOptions([
                'read_write' => new ReadWrite()
            ])
        ]);
        $this->spannerClient->executeStreamingSql(
            Argument::that(function ($request) use ($transaction) {
                Argument::type(executeSqlRequest::class);
                $this->assertEquals($request->getTransaction(), $transaction);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $database = $this->database($this->spannerClient->reveal());
        $database->execute('SELECT * FROM Table', [
            'begin' => true,
            'transactionType' => SessionPoolInterface::CONTEXT_READWRITE
        ])->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseReadSingleUseReadOnly($chunks)
    {
        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();
        $transaction = new TransactionSelector([
            'single_use' => new TransactionOptions([
                'read_only' => new PBReadOnly([
                    'strong' => true
                ])
            ])
        ]);
        $this->spannerClient->streamingRead(
            Argument::that(function ($request) use ($transaction) {
                Argument::type(readRequest::class);
                $this->assertEquals($request->getTransaction(), $transaction);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $database = $this->database($this->spannerClient->reveal());
        $database->read('Table', new KeySet, [])->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseReadBeginReadOnly($chunks)
    {
        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();
        $transaction = new TransactionSelector([
            'begin' => new TransactionOptions([
                'read_only' => new PBReadOnly([
                    'strong' => true
                ])
            ])
        ]);
        $this->spannerClient->streamingRead(
            Argument::that(function ($request) use ($transaction) {
                Argument::type(ReadRequest::class);
                $this->assertEquals($request->getTransaction(), $transaction);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $database = $this->database($this->spannerClient->reveal());
        $database->read('Table', new KeySet, [], [
            'begin' => true
        ])->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseReadBeginReadWrite($chunks)
    {
        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();
        $transaction = new TransactionSelector([
            'begin' => new TransactionOptions([
                'read_write' => new ReadWrite(),
            ])
        ]);
        $this->spannerClient->streamingRead(
            Argument::that(function ($request) use ($transaction) {
                Argument::type(ReadRequest::class);
                $this->assertEquals($request->getTransaction(), $transaction);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $database = $this->database($this->spannerClient->reveal());
        $database->read('Table', new KeySet, [], [
            'begin' => true,
            'transactionType' => SessionPoolInterface::CONTEXT_READWRITE
        ])->rows()->current();
    }

    public function testTransactionPreAllocatedRollback()
    {
        $this->spannerClient->beginTransaction(
            Argument::that(function ($request) {
                Argument::type(BeginTransactionRequest::class);
                $this->assertEquals($request->getOptions(), $this->createTransactionOptions());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $session = SpannerClient::sessionName(
            self::PROJECT,
            self::INSTANCE,
            self::DATABASE,
            self::SESSION
        );
        $this->spannerClient->rollback(
            Argument::that(function ($request) use ($session) {
                Argument::type(RollbackRequest::class);
                $this->assertEquals($request->getTransactionId(), self::TRANSACTION);
                $this->assertEquals($request->getSession(), $session);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce();

        $database = $this->database($this->spannerClient->reveal());
        $t = $database->transaction();
        $t->rollback();
    }

    public function testTransactionSingleUseRollback()
    {
        $this->expectException(\BadMethodCallException::class);

        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();
        $this->spannerClient->rollback(Argument::cetera())->shouldNotBeCalled();

        $database = $this->database($this->spannerClient->reveal());
        $t = $database->transaction(['singleUse' => true]);
        $t->rollback();
    }

    private function database(SpannerClient $spannerClient)
    {
        $instance = $this->prophesize(Instance::class);
        $instance->name()->willReturn(InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE));
        $instance->directedReadOptions()->willReturn([]);

        $database = new Database(
            $spannerClient,
            $this->prophesize(DatabaseAdminClient::class)->reveal(),
            $this->serializer,
            $instance->reveal(),
            self::PROJECT,
            self::DATABASE
        );

        return $database;
    }

    private function getFullyQualifiedSessionName()
    {
        return SpannerClient::sessionName(
            self::PROJECT,
            self::INSTANCE,
            self::DATABASE,
            self::SESSION
        );
    }

    private function createTransactionOptions($options = [])
    {
        $transactionOptions = new TransactionOptions;
        if (isset($options['readOnly'])) {
            $readOnly = $this->serializer->decodeMessage(
                new PBReadOnly(),
                $options['readOnly']
            );
            $transactionOptions->setReadOnly($readOnly);
        } else {
            $readWrite = $readOnly = $this->serializer->decodeMessage(
                new ReadWrite(),
                $options['readOnly'] ?? []
            );
            $transactionOptions->setReadWrite($readWrite);
        }
        return $transactionOptions;
    }

    private function createMockedCommitDatabase()
    {
        $time = $this->parseTimeString($this->timestamp);
        $timestamp = new ProtoTimestamp(['seconds' => $time[0]->format('U'), 'nanos' => $time[1]]);

        $this->spannerClient->commit(
            Argument::that(function ($request) {
                Argument::type(CommitRequest::class);
                $this->assertEquals(
                    $request->getSingleUseTransaction(),
                    $this->createTransactionOptions()
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new CommitResponse(['commit_timestamp' => $timestamp]));

        return $this->database($this->spannerClient->reveal());
    }

    private function resultGeneratorStream(array $chunks)
    {
        $this->stream = $this->prophesize(ServerStream::class);
        $this->stream->readAll()
            ->willReturn($this->resultGenerator($chunks));

        return $this->stream->reveal();
    }
}
