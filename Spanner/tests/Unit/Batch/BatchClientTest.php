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

use Google\Cloud\Core\Testing\SpannerOperationRefreshTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Spanner\Batch\BatchClient;
use Google\Cloud\Spanner\Batch\BatchSnapshot;
use Google\Cloud\Spanner\Batch\QueryPartition;
use Google\Cloud\Spanner\Batch\ReadPartition;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Operation;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group spanner
 * @group spanner-batch
 * @group spanner-batch-client
 */
class BatchClientTest extends TestCase
{
    use SpannerOperationRefreshTrait;
    use TimeTrait;

    const DATABASE = 'projects/example_project/instances/example_instance/databases/example_database';
    const SESSION = 'projects/example_project/instances/example_instance/databases/example_database/sessions/session-id';
    const TRANSACTION = 'transaction-id';

    private $connection;
    private $client;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = TestHelpers::stub(BatchClient::class, [
            new Operation($this->connection->reveal(), false),
            self::DATABASE
        ], [
            'operation'
        ]);
    }

    public function testSnapshot()
    {
        $time = time();

        $this->connection->createSession(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([
                'name' => self::SESSION
            ]);
        $this->connection->beginTransaction(Argument::that(function(array $args) {
            if ($args['singleUse'] !== false) return false;
            if ($args['transactionOptions']['readOnly']['returnReadTimestamp'] !== true) return false;
            if ($args['session'] !== self::SESSION) return false;

            $db = explode('/', self::DATABASE);
            if ($args['database'] !== array_pop($db)) return false;

            return true;
        }))->shouldBeCalled()
            ->willReturn([
                'id' => self::TRANSACTION,
                'readTimestamp' => \DateTime::createFromFormat('U', (string) $time)->format(Timestamp::FORMAT)
            ]);

        $this->refreshOperation($this->client, $this->connection->reveal());

        $snapshot = $this->client->snapshot();
        $this->assertInstanceOf(BatchSnapshot::class, $snapshot);
    }

    /**
     * @group foo
     */
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

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid partition data.
     */
    public function testMissingPartitionTypeKey()
    {
        $data = base64_encode(json_encode(['hello' => 'world']));
        $this->client->partitionFromString($data);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid partition type.
     */
    public function testInvalidPartitionType()
    {
        $data = base64_encode(json_encode([BatchClient::PARTITION_TYPE_KEY => uniqid('this-is-not-real')]));
        $this->client->partitionFromString($data);
    }
}
