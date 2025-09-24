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

namespace Google\Cloud\Spanner\Tests\Snippet\Batch;

use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Spanner\Batch\BatchClient;
use Google\Cloud\Spanner\Batch\BatchSnapshot;
use Google\Cloud\Spanner\Batch\PartitionInterface;
use Google\Cloud\Spanner\Batch\QueryPartition;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Serializer;
use Google\Cloud\Spanner\Session\SessionCache;
use Google\Cloud\Spanner\Tests\ResultGeneratorTrait;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\V1\BeginTransactionRequest;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\CreateSessionRequest;
use Google\Cloud\Spanner\V1\ExecuteSqlRequest;
use Google\Cloud\Spanner\V1\PartialResultSet;
use Google\Cloud\Spanner\V1\Partition;
use Google\Cloud\Spanner\V1\PartitionQueryRequest;
use Google\Cloud\Spanner\V1\PartitionReadRequest;
use Google\Cloud\Spanner\V1\PartitionResponse;
use Google\Cloud\Spanner\V1\Session as SessionProto;
use Google\Cloud\Spanner\V1\Transaction;
use Google\Protobuf\Timestamp as TimestampProto;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner
 * @group spanner-batch
 */
class BatchSnapshotTest extends SnippetTestCase
{
    const TRANSACTION = 'my-transaction';
    const SESSION = 'projects/my-awesome-project/instances/my-instance/databases/my-database/sessions/session-id';

    use GrpcTestTrait;
    use ProphecyTrait;
    use ResultGeneratorTrait;

    private $spannerClient;
    private $serializer;
    private $session;
    private $time;
    private $snapshot;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->serializer = new Serializer();
        $this->spannerClient = $this->prophesize(SpannerClient::class);

        $this->session = $this->prophesize(SessionCache::class);
        $this->session->name()->willReturn(self::SESSION);

        $this->time = time();
        $this->snapshot = new BatchSnapshot(
            new Operation($this->spannerClient->reveal(), $this->serializer),
            $this->session->reveal(),
            [
                'id' => self::TRANSACTION,
                'readTimestamp' => new Timestamp(\DateTime::createFromFormat('U', (string) $this->time))
            ]
        );
    }

    public function testClass()
    {
        $this->spannerClient->createSession(
            Argument::type(CreateSessionRequest::class),
            Argument::type('array')
        )->willReturn(new SessionProto(['name' => self::SESSION]));

        $this->spannerClient->beginTransaction(
            Argument::type(BeginTransactionRequest::class),
            Argument::type('array')
        )
            ->willReturn(new Transaction([
                'id' => self::TRANSACTION,
                'read_timestamp' => new TimestampProto([
                    'seconds' => $this->time
                ])
            ]));

        $client = new BatchClient(
            new Operation($this->spannerClient->reveal(), $this->serializer),
            $this->session->reveal()
        );

        $snippet = $this->snippetFromClass(BatchSnapshot::class);
        $snippet->setLine(3, '');
        $snippet->addLocal('batch', $client);

        $res = $snippet->invoke('snapshot');
        $this->assertInstanceOf(BatchSnapshot::class, $res->returnVal());
    }

    /**
     * @dataProvider provideSerializeIndex
     */
    public function testSerializeSnapshot($index)
    {
        $snippet = $this->snippetFromClass(BatchSnapshot::class, $index);
        $snippet->addLocal('snapshot', $this->snapshot);

        $res = $snippet->invoke('snapshotString');
        $this->assertEquals($this->snapshot->serialize(), $res->returnVal());
    }

    public function provideSerializeIndex()
    {
        return [[1], [2]];
    }

    public function testPartitionRead()
    {
        $this->spannerClient->partitionRead(
            Argument::type(PartitionReadRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new PartitionResponse([
                'partitions' => [
                    new Partition(['partition_token' => 'foo'])
                ]
            ]));

        $snippet = $this->snippetFromMethod(BatchSnapshot::class, 'partitionRead');
        $snippet->addLocal('snapshot', $this->snapshot);

        $res = $snippet->invoke('partitions');
        $this->assertContainsOnlyInstancesOf(PartitionInterface::class, $res->returnVal());
    }

    public function testPartitionQuery()
    {
        $this->spannerClient->partitionQuery(
            Argument::type(PartitionQueryRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new PartitionResponse([
                'partitions' => [
                    new Partition(['partition_token' => 'foo'])
                ]
            ]));

        $snippet = $this->snippetFromMethod(BatchSnapshot::class, 'partitionQuery');
        $snippet->addLocal('snapshot', $this->snapshot);

        $res = $snippet->invoke('partitions');
        $this->assertContainsOnlyInstancesOf(PartitionInterface::class, $res->returnVal());
    }

    public function testExecutePartition()
    {
        $token = 'foo';
        $sql = 'SELECT 1=1';
        $opts = [];
        $partition = new QueryPartition($token, $sql, $opts);

        $this->spannerClient->executeStreamingSql(
            Argument::type(ExecuteSqlRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->resultGeneratorStream([$this->serializer->decodeMessage(
                new PartialResultSet(),
                [
                    'metadata' => [
                        'rowType' => [
                            'fields' => [
                                [
                                    'name' => 'loginCount',
                                    'type' => [
                                        'code' => Database::TYPE_INT64
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'values' => [
                        ['numberValue' => 0]
                    ]
                ]
            )]));

        $snippet = $this->snippetFromMethod(BatchSnapshot::class, 'executePartition');
        $snippet->addLocal('snapshot', $this->snapshot);
        $snippet->addLocal('partition', $partition);

        $res = $snippet->invoke('result');
        $this->assertInstanceOf(Result::class, $res->returnVal());
        iterator_to_array($res->returnVal());
    }

    public function testSerialize()
    {
        $snippet = $this->snippetFromMethod(BatchSnapshot::class, 'serialize');
        $snippet->addLocal('snapshot', $this->snapshot);

        $res = $snippet->invoke('snapshotString');
        $this->assertEquals($this->snapshot->serialize(), $res->returnVal());
    }

    public function testReadTimestamp()
    {
        $snippet = $this->snippetFromMethod(BatchSnapshot::class, 'readTimestamp');
        $snippet->addLocal('snapshot', $this->snapshot);

        $res = $snippet->invoke('timestamp');
        $this->assertInstanceOf(Timestamp::class, $res->returnVal());
    }

    public function testId()
    {
        $snippet = $this->snippetFromMethod(BatchSnapshot::class, 'id');
        $snippet->addLocal('transaction', $this->snapshot);

        $res = $snippet->invoke('id');
        $this->assertEquals(self::TRANSACTION, $res->returnVal());
    }

    private function resultGenerator(array $data)
    {
        yield $data;
    }
}
