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
use Google\Cloud\Spanner\Batch\QueryPartition;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Serializer;
use Google\Cloud\Spanner\V1\BeginTransactionRequest;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\CreateSessionRequest;
use Google\Cloud\Spanner\V1\Partition;
use Google\Cloud\Spanner\V1\PartitionQueryRequest;
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
class QueryPartitionTest extends SnippetTestCase
{
    use ProphecyTrait;
    use GrpcTestTrait;
    use PartitionSharedSnippetTestTrait;

    const DATABASE = 'projects/my-awesome-project/instances/my-instance/databases/my-database';
    const SESSION = 'projects/my-awesome-project/instances/my-instance/databases/my-database/sessions/session-id';
    const TRANSACTION = 'transaction-id';

    private $spannerClient;
    private $serializer;
    private $className = QueryPartition::class;
    private $sql = 'SELECT 1=1';
    private $time;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->spannerClient = $this->prophesize(SpannerClient::class);
        $this->serializer = new Serializer();
        $this->time = time();
        $this->partition = new QueryPartition($this->token, $this->sql, $this->options);
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
                'read_timestamp' => new TimestampProto(['seconds' => $this->time])
            ]));
        $this->spannerClient->partitionQuery(
            Argument::type(PartitionQueryRequest::class),
            Argument::type('array')
        )->willReturn(new PartitionResponse([
                'partitions' => [
                    new Partition(['partition_token' => 'foo'])
                ]
            ]));

        $client = new BatchClient(
            new Operation($this->spannerClient->reveal(), $this->serializer),
            self::DATABASE
        );

        $snippet = $this->snippetFromClass(QueryPartition::class);
        $snippet->setLine(3, '');
        $snippet->addLocal('batch', $client);

        $res = $snippet->invoke('partitions');
        $this->assertContainsOnlyInstancesOf(QueryPartition::class, $res->returnVal());
    }

    public function testSql()
    {
        $snippet = $this->snippetFromMethod(QueryPartition::class, 'sql');
        $snippet->addLocal('partition', $this->partition);

        $res = $snippet->invoke('sql');
        $this->assertEquals($this->sql, $res->returnVal());
    }
}
