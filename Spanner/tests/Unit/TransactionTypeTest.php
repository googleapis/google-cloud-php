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
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\Snapshot;
use Google\Cloud\Spanner\Tests\ResultGeneratorTrait;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\V1\BeginTransactionRequest;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\CommitRequest;
use Google\Cloud\Spanner\V1\CommitResponse;
use Google\Cloud\Spanner\V1\CreateSessionRequest;
use Google\Cloud\Spanner\V1\DeleteSessionRequest;
use Google\Cloud\Spanner\V1\ExecuteSqlRequest;
use Google\Cloud\Spanner\V1\PartialResultSet;
use Google\Cloud\Spanner\V1\ReadRequest;
use Google\Cloud\Spanner\V1\RollbackRequest;
use Google\Cloud\Spanner\V1\Session;
use Google\Cloud\Spanner\V1\Transaction as TransactionProto;
use Google\Cloud\Spanner\V1\TransactionOptions;
use Google\Cloud\Spanner\V1\TransactionOptions\PBReadOnly;
use Google\Cloud\Spanner\V1\TransactionOptions\ReadWrite;
use Google\Protobuf\Duration;
use Google\Protobuf\Timestamp as TimestampProto;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner
 * @group spanner-transaction-type
 */
class TransactionTypeTest extends TestCase
{
    use ApiHelperTrait;
    use GrpcTestTrait;
    use ProphecyTrait;
    use ResultGeneratorTrait;
    use TimeTrait;

    const PROJECT = 'my-project';
    const INSTANCE = 'my-instance';
    const DATABASE = 'my-database';
    const TRANSACTION = 'my-transaction';
    const SESSION = 'my-session';

    private $spannerClient;
    private $serializer;
    private $timestamp;
    private $protoTimestamp;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $time = \DateTime::createFromFormat('U', time());
        $nanos = 500000005;
        $this->timestamp = (new Timestamp($time, $nanos))->formatAsString();
        $this->protoTimestamp = new TimestampProto(['seconds' => $time->format('U'), 'nanos' => $nanos]);

        $this->spannerClient = $this->prophesize(SpannerClient::class);
        $this->serializer = $this->prophesize(Serializer::class);

        // mock serializer responses for sessions (used for streaming tests)
        $this->serializer = $this->prophesize(Serializer::class);
        $this->serializer->decodeMessage(
            Argument::type(CreateSessionRequest::class),
            Argument::type('array')
        )
            ->willReturn(new CreateSessionRequest([
                'database' => SpannerClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
            ]));
        $this->serializer->encodeMessage(Argument::type(Session::class))
            ->willReturn(['name' => $this->getFullyQualifiedSessionName()]);

        $this->serializer->decodeMessage(
            Argument::type(DeleteSessionRequest::class),
            Argument::type('array')
        )
            ->willReturn(new DeleteSessionRequest());

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
            ->willReturn(new Session(['name' => $this->getFullyQualifiedSessionName()]));

        $this->spannerClient->deleteSession(Argument::cetera())
            ->shouldBeCalledOnce();
    }

    public function testDatabaseRunTransactionPreAllocate()
    {
        $this->spannerClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) {
                $this->assertEquals($request->getSession(), $this->getFullyQualifiedSessionName());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new TransactionProto(['id' => self::TRANSACTION]));

        $this->spannerClient->commit(
            Argument::that(function (CommitRequest $request) {
                $this->assertEquals($request->getTransactionId(), self::TRANSACTION);
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new CommitResponse(['commit_timestamp' => $this->protoTimestamp]));

        $database = $this->database($this->spannerClient->reveal());

        $database->runTransaction(function ($t) {
            // Transaction gets created at the commit operation
            $t->commit();
        });
    }

    public function testDatabaseRunTransactionSingleUse()
    {
        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();

        $this->spannerClient->commit(
            Argument::that(function (CommitRequest $request) {
                $this->assertEquals(
                    $request->getSingleUseTransaction(),
                    $this->createTransactionOptions()
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new CommitResponse(['commit_timestamp' => $this->protoTimestamp]));

        $database = $this->database($this->spannerClient->reveal());

        $database->runTransaction(function ($t) {
            $this->assertNull($t->id());

            $t->commit();
        }, ['singleUse' => true]);
    }

    public function testDatabaseTransactionPreAllocate()
    {
        $this->spannerClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) {
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

        $database = $this->database($this->spannerClient->reveal());

        $transaction = $database->transaction(['singleUse' => true]);

        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertNull($transaction->id());
    }

    public function testDatabaseSnapshotPreAllocate()
    {
        $this->spannerClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) {
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

        $transaction = [
            'singleUse' => [
                'readOnly' => [
                    'minReadTimestamp' => ['seconds' => $time[0]->format('U'), 'nanos' => $time[1]],
                    'maxStaleness' => $duration,
                ]
            ]
        ];

        $this->spannerClient->executeStreamingSql(
            Argument::type(ExecuteSqlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $serializer = $this->serializerForStreamingSql($chunks, $transaction);
        $database = $this->database($this->spannerClient->reveal(), $serializer);
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
        $this->spannerClient->deleteSession(Argument::cetera())->shouldNotBeCalled();

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
        $this->spannerClient->deleteSession(Argument::cetera())->shouldNotBeCalled();

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
        $transaction = [
            'singleUse' => [
                'readOnly' => [
                    'readTimestamp' => $this->formatTimestampForApi($this->timestamp),
                    'exactStaleness' => $duration,
                ]
            ]
        ];

        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();

        $this->spannerClient->executeStreamingSql(
            Argument::type(ExecuteSqlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $serializer = $this->serializerForStreamingSql($chunks, $transaction);
        $database = $this->database($this->spannerClient->reveal(), $serializer);

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
                'exactStaleness' => $duration,
            ]
        ];
        $transaction = new TransactionProto(['id' => self::TRANSACTION]);
        $this->spannerClient->beginTransaction(
            Argument::type(BeginTransactionRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($transaction);

        $this->spannerClient->executeStreamingSql(
            Argument::type(ExecuteSqlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $this->serializer->decodeMessage(
            Argument::type(BeginTransactionRequest::class),
            Argument::that(function (array $data) use ($options) {
                $this->assertEquals($data['options'], $options);
                return true;
            }),
        )
            ->shouldBeCalledOnce()
            ->willReturn(new BeginTransactionRequest());

        $this->serializer->encodeMessage($transaction)
            ->shouldBeCalledOnce()
            ->willReturn([]);

        $serializer = $this->serializerForStreamingSql($chunks, ['singleUse' => $options]);
        $database = $this->database($this->spannerClient->reveal(), $serializer);

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

        $transaction = [
            'singleUse' => [
                'readOnly' => [
                    'strong' => true
                ]
            ]
        ];

        $this->spannerClient->executeStreamingSql(
            Argument::type(ExecuteSqlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $serializer = $this->serializerForStreamingSql($chunks, $transaction);
        $database = $this->database($this->spannerClient->reveal(), $serializer);

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
        $transaction = new TransactionProto(['id' => self::TRANSACTION]);
        $this->spannerClient->beginTransaction(
            Argument::type(BeginTransactionRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($transaction);

        $this->spannerClient->executeStreamingSql(
            Argument::type(ExecuteSqlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $this->serializer->decodeMessage(
            Argument::type(BeginTransactionRequest::class),
            Argument::that(function (array $data) use ($options) {
                $this->assertEquals($data['options'], $options);
                return true;
            }),
        )
            ->shouldBeCalledOnce()
            ->willReturn(new BeginTransactionRequest());

        $this->serializer->encodeMessage($transaction)
            ->shouldBeCalledOnce()
            ->willReturn([]);

        $serializer = $this->serializerForStreamingSql($chunks, ['singleUse' => $options]);
        $database = $this->database($this->spannerClient->reveal(), $serializer);

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
        $transaction = [
            'singleUse' => [
                'readOnly' => [
                    'strong' => true
                ]
            ]
        ];
        $this->spannerClient->executeStreamingSql(
            Argument::type(ExecuteSqlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $serializer = $this->serializerForStreamingSql($chunks, $transaction);
        $database = $this->database($this->spannerClient->reveal(), $serializer);

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
        $transaction = new TransactionProto(['id' => self::TRANSACTION]);
        $this->spannerClient->beginTransaction(
            Argument::type(BeginTransactionRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($transaction);

        $this->spannerClient->executeStreamingSql(
            Argument::type(ExecuteSqlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $this->serializer->decodeMessage(
            Argument::type(BeginTransactionRequest::class),
            Argument::that(function (array $data) use ($options) {
                $this->assertEquals($data['options'], $options);
                return true;
            }),
        )
            ->shouldBeCalledOnce()
            ->willReturn(new BeginTransactionRequest());

        $this->serializer->encodeMessage($transaction)
            ->shouldBeCalledOnce()
            ->willReturn([]);

        $serializer = $this->serializerForStreamingSql($chunks, ['singleUse' => $options]);
        $database = $this->database($this->spannerClient->reveal(), $serializer);

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
        $transaction = new TransactionProto(['id' => self::TRANSACTION]);
        $this->spannerClient->beginTransaction(
            Argument::type(BeginTransactionRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($transaction);

        $this->spannerClient->executeStreamingSql(
            Argument::type(ExecuteSqlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $this->serializer->decodeMessage(
            Argument::type(BeginTransactionRequest::class),
            Argument::that(function (array $data) use ($options) {
                $this->assertEquals($data['options'], $options);
                return true;
            }),
        )
            ->shouldBeCalledOnce()
            ->willReturn(new BeginTransactionRequest());

        $this->serializer->encodeMessage($transaction)
            ->shouldBeCalledOnce()
            ->willReturn([]);

        $serializer = $this->serializerForStreamingSql($chunks, ['singleUse' => $options]);
        $database = $this->database($this->spannerClient->reveal(), $serializer);

        $snapshot = $database->snapshot([
            'returnReadTimestamp' => true
        ]);

        $snapshot->execute('SELECT * FROM Table')->rows()->current();
    }

    public function testDatabaseInsertSingleUseReadWrite()
    {
        $this->spannerClient->commit(
            Argument::that(function (CommitRequest $request) {
                $this->assertEquals(
                    $request->getSingleUseTransaction(),
                    $this->createTransactionOptions()
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new CommitResponse(['commit_timestamp' => $this->protoTimestamp]));

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

        $database->delete('Table', new KeySet());
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseExecuteSingleUseReadOnly($chunks)
    {
        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();
        $transaction = [
            'singleUse' => [
                'readOnly' => [
                    'strong' => true
                ]
            ]
        ];
        $this->spannerClient->executeStreamingSql(
            Argument::type(ExecuteSqlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $serializer = $this->serializerForStreamingSql($chunks, $transaction);
        $database = $this->database($this->spannerClient->reveal(), $serializer);
        $database->execute('SELECT * FROM Table')->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseExecuteBeginReadOnly($chunks)
    {
        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();

        $transaction = [
            'begin' => [
                'readOnly' => [
                    'strong' => true
                ]
            ]
        ];

        $this->spannerClient->executeStreamingSql(
            Argument::type(ExecuteSqlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $serializer = $this->serializerForStreamingSql($chunks, $transaction);
        $database = $this->database($this->spannerClient->reveal(), $serializer);
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
        $transaction = [
            'begin' => [
                'readWrite' => []
            ]
        ];
        $this->spannerClient->executeStreamingSql(
            Argument::type(ExecuteSqlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $serializer = $this->serializerForStreamingSql($chunks, $transaction);
        $database = $this->database($this->spannerClient->reveal(), $serializer);
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
        $transaction = [
            'singleUse' => [
                'readOnly' => [
                    'strong' => true
                ]
            ]
        ];
        $this->spannerClient->streamingRead(
            Argument::type(ReadRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $serializer = $this->serializerForStreamingRead($chunks, $transaction);
        $database = $this->database($this->spannerClient->reveal(), $serializer);
        $database->read('Table', new KeySet(), [])->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseReadBeginReadOnly($chunks)
    {
        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();
        $transaction = [
            'begin' => [
                'readOnly' => [
                    'strong' => true
                ]
            ]
        ];

        $this->spannerClient->streamingRead(
            Argument::type(ReadRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $serializer = $this->serializerForStreamingRead($chunks, $transaction);
        $database = $this->database($this->spannerClient->reveal(), $serializer);
        $database->read('Table', new KeySet(), [], [
            'begin' => true
        ])->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseReadBeginReadWrite($chunks)
    {
        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();
        $transaction = [
            'begin' => [
                'readWrite' => []
            ]
        ];
        $this->spannerClient->streamingRead(
            Argument::type(ReadRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $serializer = $this->serializerForStreamingRead($chunks, $transaction);
        $database = $this->database($this->spannerClient->reveal(), $serializer);
        $database->read('Table', new KeySet(), [], [
            'begin' => true,
            'transactionType' => SessionPoolInterface::CONTEXT_READWRITE
        ])->rows()->current();
    }

    public function testTransactionPreAllocatedRollback()
    {
        $this->spannerClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) {
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

    private function database(SpannerClient $spannerClient, Serializer $serializer = null)
    {
        $instance = $this->prophesize(Instance::class);
        $instance->name()->willReturn(InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE));
        $instance->directedReadOptions()->willReturn([]);

        $database = new Database(
            $spannerClient,
            $this->prophesize(DatabaseAdminClient::class)->reveal(),
            $serializer ?: new Serializer(),
            $instance->reveal(),
            self::PROJECT,
            self::DATABASE
        );

        return $database;
    }

    private function serializerForStreamingRead(array $chunks, array $expectedTransaction): Serializer
    {
        // mock serializer responses for streaming read
        $this->serializer->decodeMessage(
            Argument::type(ReadRequest::class),
            Argument::that(function ($data) use ($expectedTransaction) {
                $this->assertEquals($data['transaction'], $expectedTransaction);
                return true;
            })
        )
            ->shouldBeCalledOnce()
            ->willReturn(new ReadRequest());

        foreach ($chunks as $chunk) {
            $result = new PartialResultSet();
            $result->mergeFromJsonString($chunk);
            $this->serializer->encodeMessage($result)
                ->shouldBeCalledOnce()
                ->willReturn(json_decode($chunk, true));
        }

        return $this->serializer->reveal();
    }

    private function serializerForStreamingSql(array $chunks, array $expectedTransaction): Serializer
    {
        // mock serializer responses for streaming read
        $this->serializer->decodeMessage(
            Argument::type(ExecuteSqlRequest::class),
            Argument::that(function ($data) use ($expectedTransaction) {
                $this->assertEquals($data['transaction'], $expectedTransaction);
                return true;
            })
        )
            ->shouldBeCalledOnce()
            ->willReturn(new ExecuteSqlRequest());

        foreach ($chunks as $chunk) {
            $result = new PartialResultSet();
            $result->mergeFromJsonString($chunk);
            $this->serializer->encodeMessage($result)
                ->shouldBeCalledOnce()
                ->willReturn(json_decode($chunk, true));
        }

        return $this->serializer->reveal();
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
        $serializer = new Serializer();
        $transactionOptions = new TransactionOptions();
        if (isset($options['readOnly'])) {
            $readOnly = $serializer->decodeMessage(
                new PBReadOnly(),
                $options['readOnly']
            );
            $transactionOptions->setReadOnly($readOnly);
        } else {
            $readWrite = $readOnly = $serializer->decodeMessage(
                new ReadWrite(),
                $options['readOnly'] ?? []
            );
            $transactionOptions->setReadWrite($readWrite);
        }
        return $transactionOptions;
    }

    private function createMockedCommitDatabase()
    {
        $this->spannerClient->commit(
            Argument::that(function (CommitRequest $request) {
                $this->assertEquals(
                    $request->getSingleUseTransaction(),
                    $this->createTransactionOptions()
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new CommitResponse(['commit_timestamp' => $this->protoTimestamp]));

        return $this->database($this->spannerClient->reveal());
    }

    // private function resultGeneratorStream(array $chunks)
    // {
    //     foreach ($chunks as $i => $chunk) {
    //         $result = new PartialResultSet();
    //         $result->mergeFromJsonString($chunk);
    //         $chunks[$i] = $result;
    //     }
    //     $this->stream = $this->prophesize(ServerStream::class);
    //     $this->stream->readAll()
    //         ->willReturn($this->resultGenerator($chunks));

    //     return $this->stream->reveal();
    // }

    // private function resultGenerator($chunks)
    // {
    //     foreach ($chunks as $chunk) {
    //         yield $chunk;
    //     }
    // }
}
