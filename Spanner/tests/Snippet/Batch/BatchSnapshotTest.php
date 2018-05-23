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
use Google\Cloud\Core\Testing\SpannerOperationRefreshTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Batch\BatchClient;
use Google\Cloud\Spanner\Batch\BatchSnapshot;
use Google\Cloud\Spanner\Batch\PartitionInterface;
use Google\Cloud\Spanner\Batch\QueryPartition;
use Google\Cloud\Spanner\Batch\ReadPartition;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Result;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\V1\Gapic\SpannerGapicClient;
use Prophecy\Argument;

/**
 * @group spanner
 * @group spanner-batch
 */
class BatchSnapshotTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use SpannerOperationRefreshTrait;

    const DATABASE = 'projects/example_project/instances/example_instance/databases/example_database';
    const SESSION = 'projects/example_project/instances/example_instance/databases/example_database/sessions/session-id';
    const TRANSACTION = 'transaction-id';

    private $connection;
    private $session;
    private $time;
    private $snapshot;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);

        $sessData = SpannerGapicClient::parseName(self::SESSION, 'session');
        $this->session = $this->prophesize(Session::class);
        $this->session->name()->willReturn(self::SESSION);
        $this->session->info()->willReturn($sessData + [
            'name' => self::SESSION
        ]);

        $this->time = time();
        $this->snapshot = TestHelpers::stub(BatchSnapshot::class, [
            new Operation($this->connection->reveal(), false),
            $this->session->reveal(),
            ['id' => self::TRANSACTION, 'readTimestamp' => new Timestamp(\DateTime::createFromFormat('U', (string) $this->time))]
        ], ['operation', 'session']);
    }

    public function testClass()
    {
        $this->connection->createSession(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([
                'name' => self::SESSION
            ]);
        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'id' => self::TRANSACTION,
                'readTimestamp' => \DateTime::createFromFormat('U', (string) $this->time)->format(Timestamp::FORMAT)
            ]);

        $client = TestHelpers::stub(BatchClient::class, [
            new Operation($this->connection->reveal(), false),
            self::DATABASE
        ]);

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
        return [[1],[2]];
    }

    public function testClose()
    {
        $this->session->delete([])
            ->shouldBeCalled();

        $this->snapshot->___setProperty('session', $this->session->reveal());

        $snippet = $this->snippetFromMethod(BatchSnapshot::class, 'close');
        $snippet->addLocal('snapshot', $this->snapshot);

        $res = $snippet->invoke();
    }

    /**
     * @dataProvider providePartitionMethods
     */
    public function testPartitionRead($method)
    {
        $this->connection->$method(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'partitions' => [
                    ['partitionToken' => 'foo']
                ]
            ]);

        $this->refreshOperation($this->snapshot, $this->connection->reveal());

        $snippet = $this->snippetFromMethod(BatchSnapshot::class, $method);
        $snippet->addLocal('snapshot', $this->snapshot);

        $res = $snippet->invoke('partitions');
        $this->assertContainsOnlyInstancesOf(PartitionInterface::class, $res->returnVal());
    }

    public function providePartitionMethods()
    {
        return [['partitionRead'],['partitionQuery']];
    }

    public function testExecutePartition()
    {
        $token = 'foo';
        $sql = 'SELECT 1=1';
        $opts = [];
        $partition = new QueryPartition($token, $sql, $opts);

        $this->connection->executeStreamingSql(Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->resultGenerator([
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
                'values' => [0]
            ]));

        $this->refreshOperation($this->snapshot, $this->connection->reveal());

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

    private function resultGenerator(array $data)
    {
        yield $data;
    }
}
