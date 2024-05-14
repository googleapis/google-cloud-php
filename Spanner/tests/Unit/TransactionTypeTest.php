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
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Duration;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\Snapshot;
use Google\Cloud\Spanner\Tests\StubCreationTrait;
use Google\Cloud\Spanner\Tests\RequestHandlingTestTrait;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\V1\BeginTransactionRequest;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\CommitRequest;
use Google\Cloud\Spanner\V1\CreateSessionRequest;
use Google\Cloud\Spanner\V1\ExecuteSqlRequest;
use Google\Cloud\Spanner\V1\ReadRequest;
use Google\Cloud\Spanner\V1\RollbackRequest;
use Google\Cloud\Spanner\V1\TransactionOptions;
use Google\Cloud\Spanner\V1\TransactionSelector;
use Google\Cloud\Spanner\V1\TransactionOptions\PBReadOnly;
use Google\Cloud\Spanner\V1\TransactionOptions\ReadWrite;
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
    use RequestHandlingTestTrait;
    use StubCreationTrait;
    use TimeTrait;

    const PROJECT = 'my-project';
    const INSTANCE = 'my-instance';
    const DATABASE = 'my-database';
    const TRANSACTION = 'my-transaction';
    const SESSION = 'my-session';

    private $connection;
    private $requestHandler;
    private $serializer;
    private $timestamp;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->timestamp = (new Timestamp(\DateTime::createFromFormat('U', time()), 500000005))->formatAsString();

        $this->connection = $this->getConnStub();
        $this->requestHandler = $this->getRequestHandlerStub();
        $this->serializer = $this->getSerializer();
        $this->mockSendRequest(
            SpannerClient::class,
            'createSession',
            function($args) {
                Argument::type(BeginTransactionRequest::class);
                $this->assertEquals(
                    $args->getDatabase(),
                    SpannerClient::databaseName(self::PROJECT, self::INSTANCE, self::DATABASE)
                );
                return true;
            },
            ['name' => $this->getFullyQualifiedSessionName()],
            -1
        );
        $this->mockSendRequest(SpannerClient::class, 'deleteSession', null, [], -1);
    }

    public function testDatabaseRunTransactionPreAllocate()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            function($args) {
                Argument::type(BeginTransactionRequest::class);
                $this->assertEquals($args->getSession(), $this->getFullyQualifiedSessionName());
                return true;
            },
            ['id' => self::TRANSACTION]
        );
        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function($args) {
                Argument::type(CommitRequest::class);
                $this->assertEquals($args->getTransactionId(), self::TRANSACTION);
                return true;
            },
            ['commitTimestamp' => $this->timestamp]
        );

        $database = $this->database(
            $this->requestHandler->reveal(),
            $this->serializer
        );

        $database->runTransaction(function ($t) {
            // Transaction gets created at the commit operation
            $t->commit();
        });
    }

    public function testDatabaseRunTransactionSingleUse()
    {
        $this->mockSendRequest(SpannerClient::class, 'beginTransaction', null, null, 0);

        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function($args) {
                Argument::type(CommitRequest::class);
                $this->assertEquals(
                    $args->getSingleUseTransaction(),
                    $this->createTransactionOptions()
                );
                return true;
            },
            ['commitTimestamp' => $this->timestamp]
        );

        $database = $this->database(
            $this->requestHandler->reveal(),
            $this->serializer
        );

        $database->runTransaction(function ($t) {
            $this->assertNull($t->id());

            $t->commit();
        }, ['singleUse' => true]);
    }

    public function testDatabaseTransactionPreAllocate()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            function($args) {
                Argument::type(BeginTransactionRequest::class);
                $this->assertEquals($args->getOptions(), $this->createTransactionOptions());
                return true;
            },
            ['id' => self::TRANSACTION]
        );

        $database = $this->database($this->requestHandler->reveal(), $this->serializer);
        $transaction = $database->transaction();

        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertEquals($transaction->id(), self::TRANSACTION);
    }

    public function testDatabaseTransactionSingleUse()
    {
        $this->mockSendRequest(SpannerClient::class, 'beginTransaction', null, null, 0);

        $database = $this->database(
            $this->requestHandler->reveal(),
            $this->serializer
        );

        $transaction = $database->transaction(['singleUse' => true]);

        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertNull($transaction->id());
    }

    public function testDatabaseSnapshotPreAllocate()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            function($args) {
                Argument::type(BeginTransactionRequest::class);
                $this->assertEquals(
                    $args->getOptions(),
                    $this->createTransactionOptions(['readOnly' => ['strong' => true]])
                );
                return true;
            },
            ['id' => self::TRANSACTION]
        );

        $database = $database = $this->database(
            $this->requestHandler->reveal(),
            $this->serializer
        );

        $snapshot = $database->snapshot();

        $this->assertInstanceOf(Snapshot::class, $snapshot);
        $this->assertEquals($snapshot->id(), self::TRANSACTION);
    }

    public function testDatabaseSnapshotSingleUse()
    {
        $this->mockSendRequest(SpannerClient::class, 'beginTransaction', null, null, 0);

        $database = $database = $this->database(
            $this->requestHandler->reveal(),
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
        $duration = new Duration($seconds, $nanos);

        $this->mockSendRequest(SpannerClient::class, 'beginTransaction', null, null, 0);
        $transaction = [
            'singleUse' => [
                'readOnly' => [
                    'minReadTimestamp' => $this->formatTimestampForApi($this->timestamp),
                    'maxStaleness' => [
                        'seconds' => $seconds,
                        'nanos' => $nanos
                    ]
                ]
            ]
        ];
        $selector = $this->serializer->decodeMessage(new TransactionSelector, $transaction);

        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function($args) use ($selector) {
                Argument::type(ExecuteSqlRequest::class);
                $this->assertEquals($args->getTransaction(), $selector);
                return true;
            },
            $this->resultGenerator($chunks)
        );

        $database = $this->database($this->requestHandler->reveal(), $this->serializer);
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

        $this->mockSendRequest(SpannerClient::class, 'beginTransaction', null, null, 0);
        $this->mockSendRequest(SpannerClient::class, 'executeStreamingSql', null, null, 0);

        $database = $this->database($this->requestHandler->reveal(), $this->serializer);

        $snapshot = $database->snapshot([
            'minReadTimestamp' => $timestamp,
        ]);
    }

    public function testDatabasePreAllocatedSnapshotMaxStaleness()
    {
        $this->expectException(\BadMethodCallException::class);

        $seconds = 1;
        $nanos = 2;

        $duration = new Duration($seconds, $nanos);

        $this->mockSendRequest(SpannerClient::class, 'beginTransaction', null, null, 0);
        $this->mockSendRequest(SpannerClient::class, 'executeStreamingSql', null, null, 0);

        $database = $this->database($this->requestHandler->reveal(), $this->serializer);

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
        $duration = new Duration($seconds, $nanos);
        $transaction = [
            'singleUse' => [
                'readOnly' => [
                    'minReadTimestamp' => $this->formatTimestampForApi($this->timestamp),
                    'exactStaleness' => [
                        'seconds' => $seconds,
                        'nanos' => $nanos
                    ]
                ]
            ]
        ];
        $selector = $this->serializer->decodeMessage(new TransactionSelector, $transaction);

        $this->mockSendRequest(SpannerClient::class, 'beginTransaction', null, null, 0);
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function($args) use ($selector) {
                Argument::type(ExecuteSqlRequest::class);
                $this->assertEquals($args->getTransaction(), $selector);
                return true;
            },
            $this->resultGenerator($chunks)
        );

        $database = $this->database($this->requestHandler->reveal(), $this->serializer);

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
        $duration = new Duration($seconds, $nanos);
        $options = [
            'readOnly' => [
                'readTimestamp' => $this->formatTimestampForApi($this->timestamp),
                'exactStaleness' => [
                    'seconds' => $seconds,
                    'nanos' => $nanos
                ]
            ]
        ];
        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            function($args) use ($options) {
                Argument::type(BeginTransactionRequest::class);
                $this->assertEquals(
                    $args->getOptions(),
                    $this->createTransactionOptions($options)
                );
                return true;
            },
            ['id' => self::TRANSACTION]
        );
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function($args) {
                Argument::type(ExecuteSqlRequest::class);
                $this->assertEquals($args->getTransaction()->getId(), self::TRANSACTION);
                return true;
            },
            $this->resultGenerator($chunks)
        );

        $database = $this->database($this->requestHandler->reveal(), $this->serializer);

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
        $this->mockSendRequest(SpannerClient::class, 'beginTransaction', null, null, 0);
        $transaction = [
            'singleUse' => [
                'readOnly' => [
                    'strong' => true
                ]
            ]
        ];
        $selector = $this->serializer->decodeMessage(new TransactionSelector, $transaction);
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function($args) use ($selector) {
                Argument::type(executeSqlRequest::class);
                $this->assertEquals($args->getTransaction(), $selector);
                return true;
            },
            $this->resultGenerator($chunks)
        );
        $database = $this->database($this->requestHandler->reveal(), $this->serializer);

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
        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            function($args) use ($options) {
                Argument::type(BeginTransactionRequest::class);
                $this->assertEquals(
                    $args->getOptions(),
                    $this->createTransactionOptions($options)
                );
                return true;
            },
            ['id' => self::TRANSACTION]
        );
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function($args) {
                Argument::type(executeSqlRequest::class);
                $this->assertEquals($args->getTransaction()->getId(), self::TRANSACTION);
                return true;
            },
            $this->resultGenerator($chunks)
        );

        $database = $this->database($this->requestHandler->reveal(), $this->serializer);

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
        $this->mockSendRequest(SpannerClient::class, 'beginTransaction', null, null, 0);
        $transaction = [
            'singleUse' => [
                'readOnly' => [
                    'strong' => true
                ]
            ]
        ];
        $selector = $this->serializer->decodeMessage(new TransactionSelector, $transaction);
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function($args) use ($selector) {
                Argument::type(executeSqlRequest::class);
                $this->assertEquals($args->getTransaction(), $selector);
                return true;
            },
            $this->resultGenerator($chunks)
        );

        $database = $this->database($this->requestHandler->reveal(), $this->serializer);

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
        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            function($args) use ($options) {
                Argument::type(BeginTransactionRequest::class);
                $this->assertEquals(
                    $args->getOptions(),
                    $this->createTransactionOptions($options)
                );
                return true;
            },
            ['id' => self::TRANSACTION]
        );
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function($args) {
                Argument::type(executeSqlRequest::class);
                $this->assertEquals($args->getTransaction()->getId(), self::TRANSACTION);
                return true;
            },
            $this->resultGenerator($chunks)
        );
   
        $database = $this->database($this->requestHandler->reveal(), $this->serializer);
   
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
        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            function($args) use ($options) {
                Argument::type(BeginTransactionRequest::class);
                $this->assertEquals(
                    $args->getOptions(),
                    $this->createTransactionOptions($options)
                );
                return true;
            },
            ['id' => self::TRANSACTION]
        );
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function($args) {
                Argument::type(executeSqlRequest::class);
                $this->assertEquals($args->getTransaction()->getId(), self::TRANSACTION);
                return true;
            },
            $this->resultGenerator($chunks)
        );

        $database = $this->database($this->requestHandler->reveal(), $this->serializer);

        $snapshot = $database->snapshot([
            'returnReadTimestamp' => true
        ]);

        $snapshot->execute('SELECT * FROM Table')->rows()->current();
    }

    public function testDatabaseInsertSingleUseReadWrite()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function($args) {
                Argument::type(CommitRequest::class);
                $this->assertEquals(
                    $args->getSingleUseTransaction(),
                    $this->createTransactionOptions()
                );
                return true;
            },
            ['commitTimestamp' => $this->timestamp]
        );

        $database = $this->database($this->requestHandler->reveal(), $this->serializer);

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
        $this->mockSendRequest(SpannerClient::class, 'beginTransaction', null, null, 0);
        $transaction = [
            'singleUse' => [
                'readOnly' => [
                    'strong' => true
                ]
            ]
        ];
        $selector = $this->serializer->decodeMessage(new TransactionSelector, $transaction);
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function($args) use ($selector) {
                Argument::type(executeSqlRequest::class);
                $this->assertEquals($args->getTransaction(), $selector);
                return true;
            },
            $this->resultGenerator($chunks)
        );

        $database = $this->database($this->requestHandler->reveal(), $this->serializer);
        $database->execute('SELECT * FROM Table')->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseExecuteBeginReadOnly($chunks)
    {
        $this->mockSendRequest(SpannerClient::class, 'beginTransaction', null, null, 0);
        $transaction = [
            'begin' => [
                'readOnly' => [
                    'strong' => true
                ]
            ]
        ];
        $selector = $this->serializer->decodeMessage(new TransactionSelector, $transaction);
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function($args) use ($selector) {
                Argument::type(executeSqlRequest::class);
                $this->assertEquals($args->getTransaction(), $selector);
                return true;
            },
            $this->resultGenerator($chunks)
        );

        $database = $this->database($this->requestHandler->reveal(), $this->serializer);
        $database->execute('SELECT * FROM Table', [
            'begin' => true
        ])->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseExecuteBeginReadWrite($chunks)
    {
        $this->mockSendRequest(SpannerClient::class, 'beginTransaction', null, null, 0);
        $transaction = [
            'begin' => [
                'readWrite' => []
            ]
        ];
        $selector = $this->serializer->decodeMessage(new TransactionSelector, $transaction);
        $this->mockSendRequest(
            SpannerClient::class,
            'executeStreamingSql',
            function($args) use ($selector) {
                Argument::type(executeSqlRequest::class);
                $this->assertEquals($args->getTransaction(), $selector);
                return true;
            },
            $this->resultGenerator($chunks)
        );

        $database = $this->database($this->requestHandler->reveal(), $this->serializer);
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
        $this->mockSendRequest(SpannerClient::class, 'beginTransaction', null, null, 0);
        $transaction = [
            'singleUse' => [
                'readOnly' => [
                    'strong' => true
                ]
            ]
        ];
        $selector = $this->serializer->decodeMessage(new TransactionSelector, $transaction);
        $this->mockSendRequest(
            SpannerClient::class,
            'streamingRead',
            function($args) use ($selector) {
                Argument::type(readRequest::class);
                $this->assertEquals($args->getTransaction(), $selector);
                return true;
            },
            $this->resultGenerator($chunks)
        );

        $database = $this->database($this->requestHandler->reveal(), $this->serializer);
        $database->read('Table', new KeySet, [])->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseReadBeginReadOnly($chunks)
    {
        $this->mockSendRequest(SpannerClient::class, 'beginTransaction', null, null, 0);
        $transaction = [
            'begin' => [
                'readOnly' => [
                    'strong' => true
                ]
            ]
        ];
        $selector = $this->serializer->decodeMessage(new TransactionSelector, $transaction);
        $this->mockSendRequest(
            SpannerClient::class,
            'streamingRead',
            function($args) use ($selector) {
                Argument::type(ReadRequest::class);
                $this->assertEquals($args->getTransaction(), $selector);
                return true;
            },
            $this->resultGenerator($chunks)
        );

        $database = $this->database($this->requestHandler->reveal(), $this->serializer);
        $database->read('Table', new KeySet, [], [
            'begin' => true
        ])->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseReadBeginReadWrite($chunks)
    {
        $this->mockSendRequest(SpannerClient::class, 'beginTransaction', null, null, 0);
        $transaction = [
            'begin' => [
                'readWrite' => []
            ]
        ];
        $selector = $this->serializer->decodeMessage(new TransactionSelector, $transaction);
        $this->mockSendRequest(
            SpannerClient::class,
            'streamingRead',
            function($args) use ($selector) {
                Argument::type(ReadRequest::class);
                $this->assertEquals($args->getTransaction(), $selector);
                return true;
            },
            $this->resultGenerator($chunks)
        );

        $database = $this->database($this->requestHandler->reveal(), $this->serializer);
        $database->read('Table', new KeySet, [], [
            'begin' => true,
            'transactionType' => SessionPoolInterface::CONTEXT_READWRITE
        ])->rows()->current();
    }

    public function testTransactionPreAllocatedRollback()
    {
        $this->mockSendRequest(
            SpannerClient::class,
            'beginTransaction',
            function($args) {
                Argument::type(BeginTransactionRequest::class);
                $this->assertEquals($args->getOptions(), $this->createTransactionOptions());
                return true;
            },
            ['id' => self::TRANSACTION]
        );
        $session = SpannerClient::sessionName(
            self::PROJECT,
            self::INSTANCE,
            self::DATABASE,
            self::SESSION
        );
        $this->mockSendRequest(
            SpannerClient::class,
            'rollback',
            function($args) use ($session) {
                Argument::type(RollbackRequest::class);
                $this->assertEquals($args->getTransactionId(), self::TRANSACTION);
                $this->assertEquals($args->getSession(), $session);
                return true;
            },
            ['id' => self::TRANSACTION]
        );

        $database = $this->database($this->requestHandler->reveal(), $this->serializer);
        $t = $database->transaction();
        $t->rollback();
    }

    public function testTransactionSingleUseRollback()
    {
        $this->expectException(\BadMethodCallException::class);

        $this->mockSendRequest(SpannerClient::class, 'beginTransaction', null, null, 0);
        $this->mockSendRequest(SpannerClient::class, 'rollback', null, null, 0);

        $database = $this->database($this->requestHandler->reveal(), $this->serializer);
        $t = $database->transaction(['singleUse' => true]);
        $t->rollback();
    }

    private function database(RequestHandler $requestHandler, Serializer $serializer)
    {
        $operation = new Operation($requestHandler, $serializer, false);
        $instance = $this->prophesize(Instance::class);
        $instance->name()->willReturn(InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE));
        $instance->directedReadOptions()->willReturn([]);

        $database = TestHelpers::stub(Database::class, [
            $requestHandler,
            $serializer,
            $instance->reveal(),
            [],
            self::PROJECT,
            self::DATABASE
        ], ['operation']);

        $database->___setProperty('operation', $operation);

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
        $this->mockSendRequest(
            SpannerClient::class,
            'commit',
            function($args) {
                Argument::type(CommitRequest::class);
                $this->assertEquals(
                    $args->getSingleUseTransaction(),
                    $this->createTransactionOptions()
                );
                return true;
            },
            ['commitTimestamp' => $this->timestamp]
        );

        return $this->database($this->requestHandler->reveal(), $this->serializer);
    }
}
