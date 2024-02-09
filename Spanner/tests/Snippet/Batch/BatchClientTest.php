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

use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\V1\Client\PublisherClient;
use Google\Cloud\PubSub\V1\Client\SubscriberClient;
use Google\Cloud\Spanner\Batch\BatchClient;
use Google\Cloud\Spanner\Batch\BatchSnapshot;
use Google\Cloud\Spanner\Batch\QueryPartition;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Operation;
use Google\Cloud\Spanner\Tests\OperationRefreshTrait;
use Google\Cloud\Spanner\Tests\StubCreationTrait;
use Google\Cloud\Spanner\Timestamp;
use Prophecy\Argument;

/**
 * @group spanner
 * @group spanner-batch
 */
class BatchClientTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use OperationRefreshTrait;
    use StubCreationTrait;

    const DATABASE = 'projects/my-awesome-project/instances/my-instance/databases/my-database';
    const SESSION = 'projects/my-awesome-project/instances/my-instance/databases/my-database/sessions/session-id';
    const TRANSACTION = 'transaction-id';

    private $connection;
    private $client;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->getConnStub();
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

        if (!property_exists(PubSubClient::class, 'requestHandler')) {
            $this->markTestSkipped("Skipping testPubSubExample test as property 'requestHandler' is missing");
        }

        // setup pubsub service call stubs
        $pubsub = TestHelpers::stub(PubSubClient::class, [['projectId' => 'test']], ['requestHandler']);
        $requestHandler = $this->prophesize(RequestHandler::class);
        $requestHandler->sendRequest(
            PublisherClient::class,
            'publish',
            Argument::cetera()
        )->shouldBeCalled()
        ->will(function () use ($requestHandler) {
            $requestHandler->sendRequest(
                PublisherClient::class,
                'publish',
                Argument::cetera()
            )->shouldBeCalled();
        });

        $requestHandler->sendRequest(
            SubscriberClient::class,
            'pull',
            Argument::cetera()
        )->shouldBeCalled()
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

        $pubsub->___setProperty('requestHandler', $requestHandler->reveal());

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
                'readTimestamp' => \DateTime::createFromFormat('U', (string) $time)->format(Timestamp::FORMAT)
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
                'readTimestamp' => \DateTime::createFromFormat('U', (string) $time)->format(Timestamp::FORMAT)
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
