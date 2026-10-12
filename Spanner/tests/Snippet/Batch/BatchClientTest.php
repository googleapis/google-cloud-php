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
use Google\Cloud\PubSub\Message;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;
use Google\Cloud\Spanner\Batch\BatchClient;
use Google\Cloud\Spanner\Batch\BatchSnapshot;
use Google\Cloud\Spanner\Batch\QueryPartition;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Operation;
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
use Google\Cloud\Spanner\V1\PartitionResponse;
use Google\Cloud\Spanner\V1\Session as SessionProto;
use Google\Cloud\Spanner\V1\Transaction as TransactionProto;
use Google\Protobuf\Timestamp as TimestampProto;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner
 * @group spanner-batch
 */
class BatchClientTest extends SnippetTestCase
{
    const TRANSACTION = 'my-transaction';
    const SESSION = 'projects/my-awesome-project/instances/my-instance/databases/my-database/sessions/session-id';

    use ProphecyTrait;
    use GrpcTestTrait;
    use ResultGeneratorTrait;

    private $spannerClient;
    private $serializer;
    private $client;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->spannerClient = $this->prophesize(SpannerClient::class);
        $this->serializer = new Serializer();
        $session = $this->prophesize(SessionCache::class);
        $session->name()->willReturn(self::SESSION);

        $this->client = new BatchClient(
            new Operation($this->spannerClient->reveal(), $this->serializer),
            $session->reveal(),
        );
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
        $topic = $this->prophesize(Topic::class);
        $topic->publish(Argument::cetera())
            ->shouldBeCalledTimes(2);
        $pubsub = $this->prophesize(PubSubClient::class);
        $pubsub->topic(Argument::cetera())
            ->shouldBeCalled()
            ->willReturn($topic->reveal());

        $subscription = $this->prophesize(Subscription::class);
        $subscription->pull(Argument::cetera())
            ->shouldBeCalledOnce()
            ->willReturn([
                new Message([
                    'attributes' => [
                        'snapshot' => $snapshotString,
                        'partition' => $partition1->serialize()
                    ]
                ])
            ]);

        $pubsub->subscription(Argument::cetera())
            ->shouldBeCalledOnce()
            ->willReturn($subscription->reveal());

        // setup spanner service call stubs
        $this->spannerClient->partitionQuery(
            Argument::type(PartitionQueryRequest::class),
            Argument::type('array')
        )->willReturn(new PartitionResponse([
                'partitions' => [
                    new Partition(['partition_token' => $partition1->token()]),
                    new Partition(['partition_token' => $partition2->token()]),
                ]
            ]));

        $this->spannerClient->executeStreamingSql(
            Argument::that(function (ExecuteSqlRequest $request) use ($partition1) {
                $this->assertEquals(
                    $request->getPartitionToken(),
                    $partition1->token()
                );
                $this->assertEquals(
                    $request->getTransaction()->getId(),
                    self::TRANSACTION
                );
                $this->assertEquals($request->getSession(), self::SESSION);
                return true;
            }),
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

        $this->spannerClient->createSession(
            Argument::type(CreateSessionRequest::class),
            Argument::type('array')
        )->willReturn(new SessionProto(['name' => self::SESSION]));

        $this->spannerClient->beginTransaction(
            Argument::type(BeginTransactionRequest::class),
            Argument::type('array')
        )
            ->willReturn(new TransactionProto([
                'id' => self::TRANSACTION,
                'read_timestamp' => new TimestampProto(['seconds' => $time])
            ]));

        // inject clients
        $publisher->addLocal('batch', $this->client);
        $publisher->addLocal('pubsub', $pubsub->reveal());
        $publisher->replace('$pubsub = new PubSubClient();', '');
        $publisher->insertAfterLine(0, 'function areWorkersDone() { return true; }');
        $subscriber->addLocal('batch', $this->client);
        $subscriber->addLocal('pubsub', $pubsub->reveal());
        $subscriber->replace('$pubsub = new PubSubClient();', '');
        $publisher->insertAfterLine(0, 'function processResult($res) {iterator_to_array($res);}');

        $publisher->invoke();
        $subscriber->invoke();
    }

    public function testSnapshot()
    {
        $snippet = $this->snippetFromMethod(BatchClient::class, 'snapshot');
        $snippet->addLocal('batch', $this->client);

        $time = time();

        $this->spannerClient->beginTransaction(
            Argument::type(BeginTransactionRequest::class),
            Argument::type('array')
        )
            ->willReturn(new TransactionProto([
                'id' => self::TRANSACTION,
                'read_timestamp' => new TimestampProto(['seconds' => $time])
            ]));
        $this->spannerClient->createSession(
            Argument::type(CreateSessionRequest::class),
            Argument::type('array')
        )->willReturn(new SessionProto(['name' => self::SESSION]));

        $res = $snippet->invoke('snapshot');
        $this->assertInstanceOf(BatchSnapshot::class, $res->returnVal());
    }

    public function testSnapshotFromString()
    {
        $timestamp = new Timestamp(new \DateTime());

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
