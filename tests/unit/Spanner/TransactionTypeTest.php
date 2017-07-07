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

namespace Google\Cloud\Tests\Unit\Spanner;

use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Duration;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\Snapshot;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Transaction;
use Google\Cloud\Spanner\V1\SpannerClient;
use Google\Cloud\Tests\GrpcTestTrait;
use Prophecy\Argument;

/**
 * @group spanner
 */
class TransactionTypeTest extends \PHPUnit_Framework_TestCase
{
    use GrpcTestTrait;

    use ResultTestTrait;

    const PROJECT = 'my-project';
    const INSTANCE = 'my-instance';
    const DATABASE = 'my-database';
    const TRANSACTION = 'my-transaction';
    const SESSION = 'my-session';

    private $connection;

    private $timestamp;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->timestamp = (new \DateTimeImmutable)->format(Timestamp::FORMAT);

        $this->connection = $this->prophesize(ConnectionInterface::class);

        $this->connection->createSession(Argument::any())
            ->willReturn(['name' => SpannerClient::formatSessionName(
                self::PROJECT,
                self::INSTANCE,
                self::DATABASE,
                self::SESSION
            )]);
    }

    public function testDatabaseRunTransactionPreAllocate()
    {
        $this->connection->beginTransaction(Argument::that(function ($arg) {
            if (!isset($arg['transactionOptions']['readWrite'])) return false;
            if ($arg['singleUse']) return false;

            return true;
        }))->shouldBeCalledTimes(1)
          ->willReturn(['id' => self::TRANSACTION]);

        $this->connection->commit(Argument::withEntry('transactionId', self::TRANSACTION))
            ->shouldBeCalledTimes(1)
            ->willReturn(['commitTimestamp' => $this->timestamp]);

        $database = $this->database($this->connection->reveal());

        $database->runTransaction(function($t){
            $this->assertEquals($t->id(), self::TRANSACTION);

            $t->commit();
        });
    }

    public function testDatabaseRunTransactionSingleUse()
    {
        $this->connection->beginTransaction(Argument::any())
            ->shouldNotbeCalled();

        $this->connection->commit(Argument::withEntry('singleUseTransaction', ['readWrite' => []]))
            ->shouldBeCalledTimes(1)
            ->willReturn(['commitTimestamp' => $this->timestamp]);

        $database = $this->database($this->connection->reveal());

        $database->runTransaction(function($t){
            $this->assertNull($t->id());

            $t->commit();
        }, ['singleUse' => true]);
    }

    public function testDatabaseTransactionPreAllocate()
    {
        $this->connection->beginTransaction(Argument::that(function ($arg) {
            if (!isset($arg['transactionOptions']['readWrite'])) return false;
            if ($arg['singleUse']) return false;

            return true;
        }))->shouldBeCalledTimes(1)
          ->willReturn(['id' => self::TRANSACTION]);

        $database = $this->database($this->connection->reveal());

        $transaction = $database->transaction();

        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertEquals($transaction->id(), self::TRANSACTION);
    }

    public function testDatabaseTransactionSingleUse()
    {
        $this->connection->beginTransaction(Argument::any())
            ->shouldNotbeCalled();

        $database = $this->database($this->connection->reveal());

        $transaction = $database->transaction(['singleUse' => true]);

        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertNull($transaction->id());
    }

    public function testDatabaseSnapshotPreAllocate()
    {
        $this->connection->beginTransaction(Argument::that(function ($arg) {
            if (!isset($arg['transactionOptions']['readOnly'])) return false;
            if ($arg['singleUse']) return false;

            return true;
        }))->shouldBeCalledTimes(1)
          ->willReturn(['id' => self::TRANSACTION]);

        $database = $this->database($this->connection->reveal());

        $snapshot = $database->snapshot();

        $this->assertInstanceOf(Snapshot::class, $snapshot);
        $this->assertEquals($snapshot->id(), self::TRANSACTION);
    }

    public function testDatabaseSnapshotSingleUse()
    {
        $this->connection->beginTransaction(Argument::any())
            ->shouldNotbeCalled();

        $database = $this->database($this->connection->reveal());

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

        $timestamp = new Timestamp(new \DateTimeImmutable($this->timestamp));
        $duration = new Duration($seconds, $nanos);

        $this->connection->beginTransaction(Argument::any())
            ->shouldNotbeCalled();

        $this->connection->executeStreamingSql(Argument::that(function ($arg) use ($seconds, $nanos) {
            $opts = $arg['transaction']['singleUse']['readOnly'];
            if (isset($opts['strong'])) return false;
            if ($opts['minReadTimestamp'] !== $this->timestamp) return false;
            if ($opts['maxStaleness']['seconds'] !== $seconds) return false;
            if ($opts['maxStaleness']['nanos'] !== $nanos) return false;

            return true;
        }))->shouldBeCalledTimes(1)->willReturn($this->resultGenerator($chunks));

        $database = $this->database($this->connection->reveal());

        $snapshot = $database->snapshot([
            'singleUse' => true,
            'minReadTimestamp' => $timestamp,
            'maxStaleness' => $duration
        ]);

        $result = $snapshot->execute('SELECT * FROM Table')->rows()->current();
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testDatabasePreAllocatedSnapshotMinReadTimestamp()
    {
        $timestamp = new Timestamp(new \DateTimeImmutable($this->timestamp));

        $this->connection->beginTransaction(Argument::any())
            ->shouldNotbeCalled();

        $this->connection->executeStreamingSql(Argument::any())
            ->shouldNotbeCalled();

        $database = $this->database($this->connection->reveal());

        $snapshot = $database->snapshot([
            'minReadTimestamp' => $timestamp,
        ]);
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testDatabasePreAllocatedSnapshotMaxStaleness()
    {
        $seconds = 1;
        $nanos = 2;

        $duration = new Duration($seconds, $nanos);

        $this->connection->beginTransaction(Argument::any())
            ->shouldNotbeCalled();

        $this->connection->executeStreamingSql(Argument::any())
            ->shouldNotbeCalled();

        $database = $this->database($this->connection->reveal());

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

        $timestamp = new Timestamp(new \DateTimeImmutable($this->timestamp));
        $duration = new Duration($seconds, $nanos);

        $this->connection->beginTransaction(Argument::any())
            ->shouldNotbeCalled();

        $this->connection->executeStreamingSql(Argument::that(function ($arg) use ($seconds, $nanos) {
            $opts = $arg['transaction']['singleUse']['readOnly'];
            if (isset($opts['strong'])) return false;
            if ($opts['readTimestamp'] !== $this->timestamp) return false;
            if ($opts['exactStaleness']['seconds'] !== $seconds) return false;
            if ($opts['exactStaleness']['nanos'] !== $nanos) return false;

            return true;
        }))->shouldBeCalledTimes(1)->willReturn($this->resultGenerator($chunks));

        $database = $this->database($this->connection->reveal());

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

        $timestamp = new Timestamp(new \DateTimeImmutable($this->timestamp));
        $duration = new Duration($seconds, $nanos);

        $this->connection->beginTransaction(Argument::that(function ($arg) use ($seconds, $nanos) {
            if ($arg['singleUse']) return false;

            $opts = $arg['transactionOptions']['readOnly'];
            if (isset($opts['strong'])) return false;
            if ($opts['readTimestamp'] !== $this->timestamp) return false;
            if ($opts['exactStaleness']['seconds'] !== $seconds) return false;
            if ($opts['exactStaleness']['nanos'] !== $nanos) return false;

            return true;
        }))->shouldBeCalledTimes(1)->willReturn([
            'id' => self::TRANSACTION
        ]);

        $this->connection->executeStreamingSql(Argument::withEntry('transaction', ['id' => self::TRANSACTION]))
            ->shouldBeCalledTimes(1)
            ->willReturn($this->resultGenerator($chunks));

        $database = $this->database($this->connection->reveal());

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
        $this->connection->beginTransaction(Argument::any())
            ->shouldNotbeCalled();

        $this->connection->executeStreamingSql(Argument::that(function ($arg) {
            if (!$arg['transaction']['singleUse']['readOnly']['strong']) return false;

            return true;
        }))->shouldBeCalledTimes(1)->willReturn($this->resultGenerator($chunks));

        $database = $this->database($this->connection->reveal());

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
        $this->connection->beginTransaction(Argument::that(function ($arg) {
            if ($arg['singleUse']) return false;

            if (!$arg['transactionOptions']['readOnly']['strong']) return false;

            return true;
        }))->shouldBeCalledTimes(1)->willReturn([
            'id' => self::TRANSACTION
        ]);

        $this->connection->executeStreamingSql(Argument::withEntry('transaction', ['id' => self::TRANSACTION]))
            ->shouldBeCalledTimes(1)
            ->willReturn($this->resultGenerator($chunks));

        $database = $this->database($this->connection->reveal());

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
        $this->connection->beginTransaction(Argument::any())
            ->shouldNotbeCalled();

        $this->connection->executeStreamingSql(Argument::that(function ($arg) {
            if (!$arg['transaction']['singleUse']['readOnly']['strong']) return false;

            return true;
        }))->shouldBeCalledTimes(1)->willReturn($this->resultGenerator($chunks));

        $database = $this->database($this->connection->reveal());

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
        $this->connection->beginTransaction(Argument::that(function ($arg) {
            if ($arg['singleUse']) return false;

            if (!$arg['transactionOptions']['readOnly']['strong']) return false;

            return true;
        }))->shouldBeCalledTimes(1)->willReturn([
            'id' => self::TRANSACTION
        ]);

        $this->connection->executeStreamingSql(Argument::withEntry('transaction', ['id' => self::TRANSACTION]))
            ->shouldBeCalledTimes(1)
            ->willReturn($this->resultGenerator($chunks));

        $database = $this->database($this->connection->reveal());

        $snapshot = $database->snapshot();

        $snapshot->execute('SELECT * FROM Table')->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseSnapshotReturnReadTimestamp($chunks)
    {
        $this->connection->beginTransaction(Argument::that(function ($arg) {
            if ($arg['singleUse']) return false;

            if (!$arg['transactionOptions']['readOnly']['returnReadTimestamp']) return false;

            return true;
        }))->shouldBeCalledTimes(1)->willReturn([
            'id' => self::TRANSACTION
        ]);

        $this->connection->executeStreamingSql(Argument::withEntry('transaction', ['id' => self::TRANSACTION]))
            ->shouldBeCalledTimes(1)
            ->willReturn($this->resultGenerator($chunks));

        $database = $this->database($this->connection->reveal());

        $snapshot = $database->snapshot([
            'returnReadTimestamp' => true
        ]);

        $snapshot->execute('SELECT * FROM Table')->rows()->current();
    }

    public function testDatabaseInsertSingleUseReadWrite()
    {
        $this->connection->commit(Argument::that(function ($arg) {
            if ($arg['singleUseTransaction']['readWrite'] !== []) return false;

            return true;
        }))->shouldBeCalled()->willReturn([
            'commitTimestamp' => $this->timestamp
        ]);

        $database = $this->database($this->connection->reveal());

        $database->insert('Table', [
            'column' => 'value'
        ]);
    }

    public function testDatabaseInsertBatchSingleUseReadWrite()
    {
        $this->connection->commit(Argument::that(function ($arg) {
            if ($arg['singleUseTransaction']['readWrite'] !== []) return false;

            return true;
        }))->shouldBeCalled()->willReturn([
            'commitTimestamp' => $this->timestamp
        ]);

        $database = $this->database($this->connection->reveal());

        $database->insertBatch('Table', [[
            'column' => 'value'
        ]]);
    }

    public function testDatabaseUpdateSingleUseReadWrite()
    {
        $this->connection->commit(Argument::that(function ($arg) {
            if ($arg['singleUseTransaction']['readWrite'] !== []) return false;

            return true;
        }))->shouldBeCalled()->willReturn([
            'commitTimestamp' => $this->timestamp
        ]);

        $database = $this->database($this->connection->reveal());

        $database->update('Table', [
            'column' => 'value'
        ]);
    }

    public function testDatabaseUpdateBatchSingleUseReadWrite()
    {
        $this->connection->commit(Argument::that(function ($arg) {
            if ($arg['singleUseTransaction']['readWrite'] !== []) return false;

            return true;
        }))->shouldBeCalled()->willReturn([
            'commitTimestamp' => $this->timestamp
        ]);

        $database = $this->database($this->connection->reveal());

        $database->updateBatch('Table', [[
            'column' => 'value'
        ]]);
    }

    public function testDatabaseInsertOrUpdateSingleUseReadWrite()
    {
        $this->connection->commit(Argument::that(function ($arg) {
            if ($arg['singleUseTransaction']['readWrite'] !== []) return false;

            return true;
        }))->shouldBeCalled()->willReturn([
            'commitTimestamp' => $this->timestamp
        ]);

        $database = $this->database($this->connection->reveal());

        $database->insertOrUpdate('Table', [
            'column' => 'value'
        ]);
    }

    public function testDatabaseInsertOrUpdateBatchSingleUseReadWrite()
    {
        $this->connection->commit(Argument::that(function ($arg) {
            if ($arg['singleUseTransaction']['readWrite'] !== []) return false;

            return true;
        }))->shouldBeCalled()->willReturn([
            'commitTimestamp' => $this->timestamp
        ]);

        $database = $this->database($this->connection->reveal());

        $database->insertOrUpdateBatch('Table', [[
            'column' => 'value'
        ]]);
    }

    public function testDatabaseReplaceSingleUseReadWrite()
    {
        $this->connection->commit(Argument::that(function ($arg) {
            if ($arg['singleUseTransaction']['readWrite'] !== []) return false;

            return true;
        }))->shouldBeCalled()->willReturn([
            'commitTimestamp' => $this->timestamp
        ]);

        $database = $this->database($this->connection->reveal());

        $database->replace('Table', [
            'column' => 'value'
        ]);
    }

    public function testDatabaseReplaceBatchSingleUseReadWrite()
    {
        $this->connection->commit(Argument::that(function ($arg) {
            if ($arg['singleUseTransaction']['readWrite'] !== []) return false;

            return true;
        }))->shouldBeCalled()->willReturn([
            'commitTimestamp' => $this->timestamp
        ]);

        $database = $this->database($this->connection->reveal());

        $database->replaceBatch('Table', [[
            'column' => 'value'
        ]]);
    }

    public function testDatabaseDeleteSingleUseReadWrite()
    {
        $this->connection->commit(Argument::that(function ($arg) {
            if ($arg['singleUseTransaction']['readWrite'] !== []) return false;

            return true;
        }))->shouldBeCalled()->willReturn([
            'commitTimestamp' => $this->timestamp
        ]);

        $database = $this->database($this->connection->reveal());

        $database->delete('Table', new KeySet);
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseExecuteSingleUseReadOnly($chunks)
    {
        $this->connection->beginTransaction(Argument::any())
            ->shouldNotbeCalled();

        $this->connection->executeStreamingSql(Argument::that(function ($arg) {
            if (!$arg['transaction']['singleUse']['readOnly']['strong']) return false;

            return true;
        }))->shouldBeCalledTimes(1)->willReturn($this->resultGenerator($chunks));

        $database = $this->database($this->connection->reveal());
        $database->execute('SELECT * FROM Table')->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseExecuteBeginReadOnly($chunks)
    {
        $this->connection->beginTransaction(Argument::any())
            ->shouldNotbeCalled();

        $this->connection->executeStreamingSql(Argument::that(function ($arg) {
            if (!$arg['transaction']['begin']['readOnly']['strong']) return false;

            return true;
        }))->shouldBeCalledTimes(1)->willReturn($this->resultGenerator($chunks));

        $database = $this->database($this->connection->reveal());
        $database->execute('SELECT * FROM Table', [
            'begin' => true
        ])->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseExecuteBeginReadWrite($chunks)
    {
        $this->connection->beginTransaction(Argument::any())
            ->shouldNotbeCalled();

        $this->connection->executeStreamingSql(Argument::that(function ($arg) {
            if ($arg['transaction']['begin']['readWrite'] !== []) return false;

            return true;
        }))->shouldBeCalledTimes(1)->willReturn($this->resultGenerator($chunks));

        $database = $this->database($this->connection->reveal());
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
        $this->connection->beginTransaction(Argument::any())
            ->shouldNotbeCalled();

        $this->connection->streamingRead(Argument::that(function ($arg) {
            if (!$arg['transaction']['singleUse']['readOnly']['strong']) return false;

            return true;
        }))->shouldBeCalledTimes(1)->willReturn($this->resultGenerator($chunks));

        $database = $this->database($this->connection->reveal());
        $database->read('Table', new KeySet, [])->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseReadBeginReadOnly($chunks)
    {
        $this->connection->beginTransaction(Argument::any())
            ->shouldNotbeCalled();

        $this->connection->streamingRead(Argument::that(function ($arg) {
            if (!$arg['transaction']['begin']['readOnly']['strong']) return false;

            return true;
        }))->shouldBeCalledTimes(1)->willReturn($this->resultGenerator($chunks));

        $database = $this->database($this->connection->reveal());
        $database->read('Table', new KeySet, [], [
            'begin' => true
        ])->rows()->current();
    }

    /**
     * @dataProvider streamingDataProviderFirstChunk
     */
    public function testDatabaseReadBeginReadWrite($chunks)
    {
        $this->connection->beginTransaction(Argument::any())
            ->shouldNotbeCalled();

        $this->connection->streamingRead(Argument::that(function ($arg) {
            if ($arg['transaction']['begin']['readWrite'] !== []) return false;

            return true;
        }))->shouldBeCalledTimes(1)->willReturn($this->resultGenerator($chunks));

        $database = $this->database($this->connection->reveal());
        $database->read('Table', new KeySet, [], [
            'begin' => true,
            'transactionType' => SessionPoolInterface::CONTEXT_READWRITE
        ])->rows()->current();
    }

    public function testTransactionPreAllocatedRollback()
    {
        $this->connection->beginTransaction(Argument::that(function ($arg) {
            if (!isset($arg['transactionOptions']['readWrite'])) return false;

            return true;
        }))->shouldBeCalledTimes(1)->willReturn(['id' => self::TRANSACTION]);

        $this->connection->rollback(Argument::that(function ($arg) {
            if ($arg['transactionId'] !== self::TRANSACTION) return false;
            if ($arg['session'] !== SpannerClient::formatSessionName(
                self::PROJECT,
                self::INSTANCE,
                self::DATABASE,
                self::SESSION
            )) return false;

            return true;
        }))->shouldBeCalled();

        $database = $this->database($this->connection->reveal());
        $t = $database->transaction();
        $t->rollback();
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testTransactionSingleUseRollback()
    {
        $this->connection->beginTransaction(Argument::any())->shouldNotbeCalled();
        $this->connection->rollback(Argument::any())->shouldNotbeCalled();

        $database = $this->database($this->connection->reveal());
        $t = $database->transaction(['singleUse' => true]);
        $t->rollback();
    }

    private function database(ConnectionInterface $connection)
    {
        $operation = new Operation($connection, false);
        $instance = $this->prophesize(Instance::class);
        $instance->name()->willReturn(InstanceAdminClient::formatInstanceName(self::PROJECT, self::INSTANCE));

        $database = \Google\Cloud\Dev\stub(Database::class, [
            $connection,
            $instance->reveal(),
            $this->prophesize(LongRunningConnectionInterface::class)->reveal(),
            [],
            self::PROJECT,
            self::DATABASE
        ], ['operation']);

        $database->___setProperty('operation', $operation);

        return $database;
    }
}
