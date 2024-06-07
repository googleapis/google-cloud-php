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
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Spanner\Batch\BatchClient;
use Google\Cloud\Spanner\Batch\BatchSnapshot;
use Google\Cloud\Spanner\Batch\QueryPartition;
use Google\Cloud\Spanner\Batch\ReadPartition;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Tests\OperationRefreshTrait;
use Google\Cloud\Spanner\Tests\RequestHandlingTestTrait;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Google\Cloud\Spanner\Tests\StubCreationTrait;
use Google\Cloud\Spanner\V1\BeginTransactionRequest;
use Google\Cloud\Spanner\V1\Client\SpannerClient as GapicSpannerClient;
use Google\Cloud\Spanner\V1\CreateSessionRequest;

/**
 * @group spanner
 * @group spanner-batch
 * @group spanner-batch-client
 */
class BatchClientTest extends TestCase
{
    use OperationRefreshTrait;
    use ProphecyTrait;
    use RequestHandlingTestTrait;
    use StubCreationTrait;
    use TimeTrait;

    const DATABASE = 'projects/my-awesome-project/instances/my-instance/databases/my-database';
    const SESSION = 'projects/my-awesome-project/instances/my-instance/databases/my-database/sessions/session-id';
    const TRANSACTION = 'transaction-id';

    private $requestHandler;
    private $serializer;
    private $connection;
    private $client;

    public function setUp(): void
    {
        $this->connection = $this->getConnStub();
        $this->requestHandler = $this->getRequestHandlerStub();
        $this->serializer = $this->getSerializer();
        $this->client = TestHelpers::stub(BatchClient::class, [
            new Operation($this->requestHandler->reveal(), $this->serializer, false),
            self::DATABASE
        ], [
            'operation'
        ]);
    }

    public function testSnapshot()
    {
        $time = time();

        $this->mockSendRequest(GapicSpannerClient::class, 'createSession', function ($args) {
                Argument::type(CreateSessionRequest::class);
                $this->assertEquals(
                    $args->getDatabase(),
                    self::DATABASE
                );
                return true;
        }, ['name' => self::SESSION]);
        $this->mockSendRequest(
            GapicSpannerClient::class,
            'beginTransaction',
            function ($args) {
                Argument::type(BeginTransactionRequest::class);
                $this->assertEquals(
                    $this->serializer->encodeMessage($args)['options']['readOnly'],
                    ['returnReadTimestamp' => true]
                );
                return true;
            },
            [
                'id' => self::TRANSACTION,
                'readTimestamp' => \DateTime::createFromFormat('U', (string) $time)->format(Timestamp::FORMAT)
            ]
        );

        $this->refreshOperation($this->client, $this->requestHandler->reveal(), $this->serializer);
        $snapshot = $this->client->snapshot();
        $this->assertInstanceOf(BatchSnapshot::class, $snapshot);
    }

    public function testSnapshotFromString()
    {
        $time = time();

        $identifier = base64_encode(json_encode([
            'sessionName' => self::SESSION,
            'transactionId' => self::TRANSACTION,
            'readTimestamp' => \DateTime::createFromFormat('U', (string) $time)->format(Timestamp::FORMAT)
        ]));

        $snapshot = $this->client->snapshotFromString($identifier);
        $this->assertEquals(self::SESSION, $snapshot->session()->name());
        $this->assertEquals(self::TRANSACTION, $snapshot->id());
        $this->assertEquals(
            $time,
            $snapshot->readTimestamp()->get()->format('U')
        );
    }

    public function testQueryPartitionFromString()
    {
        $token = 'foobar';
        $sql = 'SELECT 1=1';
        $options = ['hello' => 'world'];

        $partition = new QueryPartition($token, $sql, $options);
        $string = (string) $partition;

        $res = $this->client->partitionFromString($partition);
        $this->assertEquals($token, $res->token());
        $this->assertEquals($sql, $res->sql());
        $this->assertEquals($options, $res->options());
    }

    public function testReadPartitionFromString()
    {
        $token = 'foobar';
        $table = 'table';
        $keyset = new KeySet(['all' => true]);
        $columns = ['a','b'];
        $options = ['hello' => 'world'];

        $partition = new ReadPartition($token, $table, $keyset, $columns, $options);
        $string = (string) $partition;

        $res = $this->client->partitionFromString($partition);
        $this->assertEquals($token, $res->token());
        $this->assertEquals($table, $res->table());
        $this->assertEquals($keyset->keySetObject(), $res->keySet()->keySetObject());
        $this->assertEquals($columns, $res->columns());
        $this->assertEquals($options, $res->options());
    }

    public function testMissingPartitionTypeKey()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid partition data.');

        $data = base64_encode(json_encode(['hello' => 'world']));
        $this->client->partitionFromString($data);
    }

    public function testInvalidPartitionType()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid partition type.');

        $data = base64_encode(json_encode([BatchClient::PARTITION_TYPE_KEY => uniqid('this-is-not-real')]));
        $this->client->partitionFromString($data);
    }

    public function testSnapshotDatabaseRole()
    {
        $time = time();

        $client = TestHelpers::stub(BatchClient::class, [
            new Operation($this->requestHandler->reveal(), $this->serializer, false),
            self::DATABASE,
            ['databaseRole' => 'Reader']
        ], [
            'operation'
        ]);

        $this->mockSendRequest(GapicSpannerClient::class, 'createSession', function ($args) {
                Argument::type(CreateSessionRequest::class);
                return $this->serializer->encodeMessage($args)['session']['creatorRole']
                    == 'Reader';
        }, ['name' => self::SESSION]);
        $this->mockSendRequest(
            GapicSpannerClient::class,
            'beginTransaction',
            function ($args) {
                Argument::type(BeginTransactionRequest::class);
                $this->assertEquals(
                    $this->serializer->encodeMessage($args)['options']['readOnly'],
                    ['returnReadTimestamp' => true]
                );
                return true;
            },
            [
                'id' => self::TRANSACTION,
                'readTimestamp' => \DateTime::createFromFormat('U', (string) $time)->format(Timestamp::FORMAT)
            ]
        );

        $snapshot = $client->snapshot();
    }
}
