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

namespace Google\Cloud\Tests\Snippets\Spanner\Batch;

use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\SpannerOperationRefreshTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\PubSub\Connection\ConnectionInterface as PubSubConnectionInterface;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\Spanner\Batch\BatchClient;
use Google\Cloud\Spanner\Batch\BatchSnapshot;
use Google\Cloud\Spanner\Batch\QueryPartition;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Timestamp;
use Prophecy\Argument;

/**
 * @group spanner
 * @group spanner-batch
 */
class BatchClientTest extends SnippetTestCase
{
    const DATABASE = 'projects/example_project/instances/example_instance/databases/example_database';
    const SESSION = 'projects/example_project/instances/example_instance/databases/example_database/sessions/session-id';
    const TRANSACTION = 'transaction-id';

    use SpannerOperationRefreshTrait;

    private $connection;
    private $client;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = TestHelpers::stub(BatchClient::class, [
            new Operation($this->connection->reveal(), false),
            self::DATABASE
        ], ['operation']);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(BatchClient::class);
        $res = $snippet->invoke('batch');
        $this->assertInstanceOf(BatchClient::class, $res->returnVal());
    }

    public function testPubSubExample()
    {
        $time = time();
        $query = 'SELECT * FROM Users WHERE firstName = %s AND location = %s';
        $opts = [
            'parameters' => [
                'firstName' => 'John',
                'location' => 'USA'
            ]
        ];

        $publisher = $this->snippetFromClass(BatchClient::class, 1);
        $subscriber = $this->snippetFromClass(BatchClient::class, 2);
        $snapshotString = base64_encode(json_encode([
            'sessionName' => self::SESSION,
            'transactionId' => self::TRANSACTION,
            'readTimestamp' => (new Timestamp(\DateTime::createFromFormat('U', (string) $time)))->formatAsString()
        ]));

        $partition1 = new QueryPartition('foo', $query, $opts);
        $partition2 = new QueryPartition('bar', $query, $opts);
        $message1 = [
            'attributes' => [
                'snapshot' => $snapshotString,
                'partition' => $partition1->serialize()
            ]
        ];
        $message2 = $message1;
        $message2['attributes']['partition'] = $partition2->serialize();

        // setup pubsub service call stubs
        $pubsub = TestHelpers::stub(PubSubClient::class);
        $pConnection = $this->prophesize(PubSubConnectionInterface::class);
        $pConnection->publishMessage(Argument::withEntry('messages', [$message1]))
            ->shouldBeCalled()
            ->will(function() use ($message2) {
                $this->publishMessage(Argument::withEntry('messages', [$message2]))
                    ->shouldBeCalled();
            });

        $pConnection->pull(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'receivedMessages' => [
                    [
                        'message' => [
                            'attributes' => [
                                'snapshot' => $snapshotString,
                                'partition' => $partition1->serialize()
                            ]
                        ]
                    ]
                ]
            ]);

        $pubsub->___setProperty('connection', $pConnection->reveal());

        // setup spanner service call stubs
        $this->connection->partitionQuery(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'partitions' => [
                    ['partitionToken' => $partition1->token()],
                    ['partitionToken' => $partition2->token()]
                ]
            ]);

        $this->connection->executeStreamingSql(Argument::allOf(
            Argument::withEntry('partitionToken', $partition1->token()),
            Argument::withEntry('transaction', ['id' => self::TRANSACTION]),
            Argument::withEntry('session', self::SESSION)
        ))->shouldBeCalled()->willReturn($this->resultGenerator([
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

        $this->connection->createSession(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => self::SESSION
            ]);

        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'id' => self::TRANSACTION,
                'readTimestamp' => [
                    'seconds' => $time,
                    'nanos' => 0
                ]
            ]);

        $this->connection->deleteSession(Argument::any())
            ->shouldBeCalled();

        // inject clients
        $publisher->addLocal('batch', $this->client);
        $publisher->addLocal('pubsub', $pubsub);
        $publisher->replace('$pubsub = new PubSubClient();', '');
        $publisher->insertAfterLine(0, 'function areWorkersDone() { return true; }');
        $subscriber->addLocal('batch', $this->client);
        $subscriber->addLocal('pubsub', $pubsub);
        $subscriber->replace('$pubsub = new PubSubClient();', '');
        $publisher->insertAfterLine(0, 'function processResult($res) {iterator_to_array($res);}');

        $this->refreshOperation($this->client, $this->connection->reveal());
        $publisher->invoke();

        $subscriber->invoke();
    }

    public function testSnapshot()
    {
        $snippet = $this->snippetFromMethod(BatchClient::class, 'snapshot');
        $snippet->addLocal('batch', $this->client);

        $time = time();

        $this->connection->createSession(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn([
                'name' => self::SESSION
            ]);
        $this->connection->beginTransaction(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'id' => self::TRANSACTION,
                'readTimestamp' => [
                    'seconds' => $time,
                    'nanos' => 0
                ]
            ]);

        $this->refreshOperation($this->client, $this->connection->reveal());

        $res = $snippet->invoke('snapshot');
        $this->assertInstanceOf(BatchSnapshot::class, $res->returnVal());
    }

    public function testSnapshotFromString()
    {
        $timestamp = new Timestamp(new \DateTime);

        $identifier = base64_encode(json_encode([
            'sessionName' => self::SESSION,
            'transactionId' => self::TRANSACTION,
            'readTimestamp' => (string) $timestamp
        ]));

        $snippet = $this->snippetFromMethod(BatchClient::class, 'snapshotFromString');
        $snippet->addLocal('batch', $this->client);
        $snippet->addLocal('snapshotString', $identifier);

        $res = $snippet->invoke('snapshot');
        $this->assertInstanceOf(BatchSnapshot::class, $res->returnVal());
    }

    public function testPartitionFromString()
    {
        $token = 'foo';
        $sql = 'SELECT 1=1';
        $opts = [];
        $partition = new QueryPartition($token, $sql, $opts);

        $snippet = $this->snippetFromMethod(BatchClient::class, 'partitionFromString');
        $snippet->addLocal('batch', $this->client);
        $snippet->addLocal('partitionString', (string) $partition);

        $res = $snippet->invoke('partition');
        $this->assertInstanceOf(QueryPartition::class, $res->returnVal());
    }

    private function resultGenerator(array $data)
    {
        yield $data;
    }
}
