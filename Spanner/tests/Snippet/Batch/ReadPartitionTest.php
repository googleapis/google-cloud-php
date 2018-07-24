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
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Batch\BatchClient;
use Google\Cloud\Spanner\Batch\ReadPartition;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Timestamp;
use Prophecy\Argument;

/**
 * @group spanner
 * @group spanner-batch
 */
class ReadPartitionTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use PartitionSharedSnippetTestTrait {
        provideGetters as private getters;
    }

    const DATABASE = 'projects/my-awesome-project/instances/my-instance/databases/my-database';
    const SESSION = 'projects/my-awesome-project/instances/my-instance/databases/my-database/sessions/session-id';
    const TRANSACTION = 'transaction-id';

    private $className = ReadPartition::class;
    private $time;
    private $table;
    private $keySet;
    private $columns;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->time = time();
        $this->table = 'table';
        $this->keySet = new KeySet(['all' => true]);
        $this->columns = ['foo', 'bar'];
        $this->partition = new ReadPartition($this->token, $this->table, $this->keySet, $this->columns, $this->options);
    }

    public function testClass()
    {
        $connection = $this->prophesize(ConnectionInterface::class);
        $connection->createSession(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([
                'name' => self::SESSION
            ]);
        $connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'id' => self::TRANSACTION,
                'readTimestamp' => \DateTime::createFromFormat('U', (string) $this->time)->format(Timestamp::FORMAT)
            ]);
        $connection->partitionRead(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'partitions' => [
                    ['partitionToken' => 'foo']
                ]
            ]);

        $client = TestHelpers::stub(BatchClient::class, [
            new Operation($connection->reveal(), false),
            self::DATABASE
        ]);

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
