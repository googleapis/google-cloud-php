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
use Google\Cloud\Spanner\Batch\ReadPartition;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Serializer;
use Google\Cloud\Spanner\V1\BeginTransactionRequest;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Google\Cloud\Spanner\V1\CreateSessionRequest;
use Google\Cloud\Spanner\V1\Partition;
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
class ReadPartitionTest extends SnippetTestCase
{
    use ProphecyTrait;
    use GrpcTestTrait;
    use PartitionSharedSnippetTestTrait {
        provideGetters as private getters;
    }

    const DATABASE = 'projects/my-awesome-project/instances/my-instance/databases/my-database';
    const SESSION = 'projects/my-awesome-project/instances/my-instance/databases/my-database/sessions/session-id';
    const TRANSACTION = 'transaction-id';

    private $spannerClient;
    private $serializer;
    private $className = ReadPartition::class;
    private $time;
    private $table;
    private $keySet;
    private $columns;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->spannerClient = $this->prophesize(SpannerClient::class);
        $this->serializer = new Serializer();
        $this->time = time();
        $this->table = 'table';
        $this->keySet = new KeySet(['all' => true]);
        $this->columns = ['foo', 'bar'];
        $this->partition = new ReadPartition($this->token, $this->table, $this->keySet, $this->columns, $this->options);
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
        $this->spannerClient->partitionRead(
            Argument::type(PartitionReadRequest::class),
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

        $snippet = $this->snippetFromClass(ReadPartition::class);
        $snippet->setLine(4, '');
        $snippet->addLocal('batch', $client);

        $res = $snippet->invoke('partitions');
        $this->assertContainsOnlyInstancesOf(ReadPartition::class, $res->returnVal());
    }

    public function provideGetters()
    {
        $parent = $this->getters();
        return array_merge($parent, [
            ['table'],
            ['keySet'],
            ['columns']
        ]);
    }
}
