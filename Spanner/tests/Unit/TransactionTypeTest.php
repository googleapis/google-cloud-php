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

use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Serializer;
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
    private $timestamp;
    private $protoTimestamp;
    private $database;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $time = \DateTime::createFromFormat('U', time());
        $nanos = 500000005;
        $this->timestamp = new Timestamp($time, $nanos);
        $this->protoTimestamp = new TimestampProto(['seconds' => $time->format('U'), 'nanos' => $nanos]);

        $this->spannerClient = $this->prophesize(SpannerClient::class);

        $instance = $this->prophesize(Instance::class);
        $instance->name()->willReturn(InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE));
        $instance->directedReadOptions()->willReturn([]);

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

        $this->database = new Database(
            $this->spannerClient->reveal(),
            $this->prophesize(DatabaseAdminClient::class)->reveal(),
            new Serializer(),
            $instance->reveal(),
            self::PROJECT,
            self::DATABASE,
        );
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
            ->willReturn(new CommitResponse());

        $this->database->runTransaction(function ($t) {
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
                    $this->createTransactionOptions(),
                    $request->getSingleUseTransaction(),
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new CommitResponse());

        $this->database->runTransaction(function ($t) {
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

        $transaction = $this->database->transaction();

        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertEquals($transaction->id(), self::TRANSACTION);
    }

    public function testDatabaseTransactionSingleUse()
    {
        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();

        $transaction = $this->database->transaction(['singleUse' => true]);

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

        $snapshot = $this->database->snapshot();

        $this->assertInstanceOf(Snapshot::class, $snapshot);
        $this->assertEquals($snapshot->id(), self::TRANSACTION);
    }

    public function testDatabaseSnapshotSingleUse()
    {
        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();

        $snapshot = $this->database->snapshot(['singleUse' => true]);

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
        $duration = new Duration(['seconds' => $seconds, 'nanos' => $nanos]);

        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();
        $this->spannerClient->executeStreamingSql(
            Argument::that(function (ExecuteSqlRequest $request) use ($duration) {
                $readOnly = $request->getTransaction()?->getSingleUse()->getReadOnly();
                $this->assertNotNull($readOnly);
                $this->assertNull($readOnly->getReadTimestamp());
                $this->assertEquals($duration, $readOnly->getMaxStaleness());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $snapshot = $this->database->snapshot([
            'singleUse' => true,
            'minReadTimestamp' => $this->timestamp,
            'maxStaleness' => $duration
        ]);

        $snapshot->execute('SELECT * FROM Table')->rows()->current();
    }

    public function testDatabasePreAllocatedSnapshotMinReadTimestamp()
    {
        $this->expectException(\BadMethodCallException::class);

        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();
        $this->spannerClient->executeStreamingSql(Argument::cetera())->shouldNotBeCalled();
        $this->spannerClient->deleteSession(Argument::cetera())->shouldNotBeCalled();

        $this->database->snapshot([
            'minReadTimestamp' => $this->timestamp,
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

        $this->database->snapshot([
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
        $duration = new Duration(['seconds' => $seconds, 'nanos' => $nanos]);

        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();
        $this->spannerClient->executeStreamingSql(
            Argument::that(function (ExecuteSqlRequest $request) use ($duration) {
                $readOnly = $request->getTransaction()?->getSingleUse()?->getReadOnly();
                $this->assertNotNull($readOnly);
                $this->assertNull($readOnly->getReadTimestamp());
                $this->assertEquals($duration, $readOnly->getExactStaleness());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $snapshot = $this->database->snapshot([
            'singleUse' => true,
            'readTimestamp' => $this->timestamp,
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

        $duration = new Duration(['seconds' => $seconds, 'nanos' => $nanos]);
        $transaction = new TransactionProto(['id' => self::TRANSACTION]);
        $this->spannerClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) use ($duration) {
                $readOnly = $request->getOptions()?->getReadOnly();
                $this->assertNotNull($readOnly);
                $this->assertNull($readOnly->getReadTimestamp());
                $this->assertEquals($duration, $readOnly->getExactStaleness());
                return true;
            }),
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

        $snapshot = $this->database->snapshot([
            'readTimestamp' => $this->timestamp,
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
        $this->spannerClient->executeStreamingSql(
            Argument::that(function (ExecuteSqlRequest $request) {
                $this->assertTrue($request->getTransaction()->getSingleUse()->getReadOnly()->getStrong());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $snapshot = $this->database->snapshot([
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
        $transaction = new TransactionProto(['id' => self::TRANSACTION]);
        $this->spannerClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) {
                $this->assertTrue($request->getOptions()->getReadOnly()->getStrong());
                return true;
            }),
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

        $snapshot = $this->database->snapshot([
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
        $this->spannerClient->executeStreamingSql(
            Argument::that(function (ExecuteSqlRequest $request) {
                $this->assertTrue($request->getTransaction()->getSingleUse()->getReadOnly()->getStrong());
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream($chunks));

        $snapshot = $this->database->snapshot([
            'singleUse' => true,
        ]);

        $snapshot->execute('SELECT * FROM Table')->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabasePreAllocatedSnapshotDefaultsToStrongConsistency($chunks)
    {
        $transaction = new TransactionProto(['id' => self::TRANSACTION]);
        $this->spannerClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) {
                $this->assertTrue($request->getOptions()->getReadOnly()->getStrong());
                return true;
            }),
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

        $snapshot = $this->database->snapshot();
        $snapshot->execute('SELECT * FROM Table')->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseSnapshotReturnReadTimestamp($chunks)
    {
        $transaction = new TransactionProto(['id' => self::TRANSACTION]);
        $this->spannerClient->beginTransaction(
            Argument::that(function (BeginTransactionRequest $request) {
                $this->assertTrue($request->getOptions()->getReadOnly()->getReturnReadTimestamp());
                return true;
            }),
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

        $snapshot = $this->database->snapshot([
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
            ->willReturn(new CommitResponse());

        $this->database->insert('Table', [
            'column' => 'value'
        ]);
    }

    public function testDatabaseInsertBatchSingleUseReadWrite()
    {
        $this->createMockedCommitDatabase();

        $this->database->insertBatch('Table', [[
            'column' => 'value'
        ]]);
    }

    public function testDatabaseUpdateSingleUseReadWrite()
    {
        $this->createMockedCommitDatabase();

        $this->database->update('Table', [
            'column' => 'value'
        ]);
    }

    public function testDatabaseUpdateBatchSingleUseReadWrite()
    {
        $this->createMockedCommitDatabase();

        $this->database->updateBatch('Table', [[
            'column' => 'value'
        ]]);
    }

    public function testDatabaseInsertOrUpdateSingleUseReadWrite()
    {
        $this->createMockedCommitDatabase();

        $this->database->insertOrUpdate('Table', [
            'column' => 'value'
        ]);
    }

    public function testDatabaseInsertOrUpdateBatchSingleUseReadWrite()
    {
        $this->createMockedCommitDatabase();

        $this->database->insertOrUpdateBatch('Table', [[
            'column' => 'value'
        ]]);
    }

    public function testDatabaseReplaceSingleUseReadWrite()
    {
        $this->createMockedCommitDatabase();

        $this->database->replace('Table', [
            'column' => 'value'
        ]);
    }

    public function testDatabaseReplaceBatchSingleUseReadWrite()
    {
        $this->createMockedCommitDatabase();

        $this->database->replaceBatch('Table', [[
            'column' => 'value'
        ]]);
    }

    public function testDatabaseDeleteSingleUseReadWrite()
    {
        $this->createMockedCommitDatabase();

        $this->database->delete('Table', new KeySet());
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

        $this->spannerClient->deleteSession(
            Argument::type(DeleteSessionRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce();

        $serializer = $this->serializerForStreamingSql($chunks, $transaction);
        $database = $this->database($serializer);
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

        $this->spannerClient->deleteSession(
            Argument::type(DeleteSessionRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce();

        $serializer = $this->serializerForStreamingSql($chunks, $transaction);
        $database = $this->database($serializer);
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

        $this->spannerClient->deleteSession(
            Argument::type(DeleteSessionRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce();

        $serializer = $this->serializerForStreamingSql($chunks, $transaction);
        $database = $this->database($serializer);
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

        $this->spannerClient->deleteSession(
            Argument::type(DeleteSessionRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce();

        $serializer = $this->serializerForStreamingRead($chunks, $transaction);
        $database = $this->database($serializer);
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

        $this->spannerClient->deleteSession(
            Argument::type(DeleteSessionRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce();

        $serializer = $this->serializerForStreamingRead($chunks, $transaction);
        $database = $this->database($serializer);
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

        $this->spannerClient->deleteSession(
            Argument::type(DeleteSessionRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce();

        $serializer = $this->serializerForStreamingRead($chunks, $transaction);
        $database = $this->database($serializer);
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

        $t = $this->database->transaction();
        $t->rollback();
    }

    public function testTransactionSingleUseRollback()
    {
        $this->expectException(\BadMethodCallException::class);

        $this->spannerClient->beginTransaction(Argument::cetera())->shouldNotBeCalled();
        $this->spannerClient->rollback(Argument::cetera())->shouldNotBeCalled();

        $t = $this->database->transaction(['singleUse' => true]);
        $t->rollback();
    }

    private function database(?Serializer $serializer = null)
    {
        $instance = $this->prophesize(Instance::class);
        $instance->name()->willReturn(InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE));
        $instance->directedReadOptions()->willReturn([]);

        return new Database(
            $this->spannerClient->reveal(),
            $this->prophesize(DatabaseAdminClient::class)->reveal(),
            $serializer ?: new Serializer(),
            $instance->reveal(),
            self::PROJECT,
            self::DATABASE,
        );
    }

    private function serializerForStreamingRead(array $chunks, array $expectedTransaction): Serializer
    {
        $serializer = $this->prophesize(Serializer::class);

        // mock serializer responses for streaming read
        $serializer->decodeMessage(
            Argument::type(ReadRequest::class),
            Argument::that(function ($data) use ($expectedTransaction) {
                $this->assertEquals($data['transaction'], $expectedTransaction);
                return true;
            })
        )
            ->shouldBeCalledOnce()
            ->willReturn(new ReadRequest());

        $serializer->decodeMessage(
            Argument::type(CreateSessionRequest::class),
            Argument::type('array')
        )
            ->willReturn(new CreateSessionRequest([
                'database' => SpannerClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE),
            ]));

        $serializer->encodeMessage(
            Argument::type(Session::class)
        )
            ->willReturn([
                'name' => SpannerClient::sessionName(self::PROJECT, self::INSTANCE, self::DATABASE, self::SESSION),
            ]);

        $serializer->decodeMessage(
            Argument::type(DeleteSessionRequest::class),
            Argument::type('array')
        )
            ->willReturn(new DeleteSessionRequest());

        foreach ($chunks as $chunk) {
            $result = new PartialResultSet();
            $result->mergeFromJsonString($chunk);
            $serializer->encodeMessage($result)
                ->shouldBeCalledOnce()
                ->willReturn(json_decode($chunk, true));
        }

        return $serializer->reveal();
    }

    private function serializerForStreamingSql(array $chunks, array $expectedTransaction): Serializer
    {
        $serializer = $this->prophesize(Serializer::class);

        // mock serializer responses for streaming read
        $serializer->decodeMessage(
            Argument::type(ExecuteSqlRequest::class),
            Argument::that(function ($data) use ($expectedTransaction) {
                $this->assertEquals($expectedTransaction, $data['transaction']);
                return true;
            })
        )
            ->shouldBeCalledOnce()
            ->willReturn(new ExecuteSqlRequest());

        $serializer->decodeMessage(
            Argument::type(BeginTransactionRequest::class),
            Argument::type('array')
        )
            ->willReturn(new BeginTransactionRequest());

        $serializer->decodeMessage(
            Argument::type(CreateSessionRequest::class),
            Argument::type('array')
        )
            ->willReturn(new CreateSessionRequest([
                'database' => SpannerClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE),
            ]));

        $serializer->encodeMessage(
            Argument::type(Session::class)
        )
            ->willReturn([
                'name' => SpannerClient::sessionName(self::PROJECT, self::INSTANCE, self::DATABASE, self::SESSION),
            ]);

        $serializer->decodeMessage(
            Argument::type(DeleteSessionRequest::class),
            Argument::type('array')
        )
            ->willReturn(new DeleteSessionRequest());

        foreach ($chunks as $chunk) {
            $result = new PartialResultSet();
            $result->mergeFromJsonString($chunk);
            $serializer->encodeMessage($result)
                ->shouldBeCalledOnce()
                ->willReturn(json_decode($chunk, true));
        }

        return $serializer->reveal();
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
            ->willReturn(new CommitResponse([
                'commit_timestamp' => new TimestampProto(['seconds' => time()])
            ]));
    }
}
