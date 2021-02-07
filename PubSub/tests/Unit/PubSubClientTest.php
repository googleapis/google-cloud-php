<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\PubSub\Tests\Unit;

use Google\Cloud\Core\Duration;
use Google\Cloud\Core\Exception\BadRequestException;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\Connection\Grpc;
use Google\Cloud\PubSub\Message;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Schema;
use Google\Cloud\PubSub\Snapshot;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;
use Google\Cloud\PubSub\V1\PublisherClient;
use Google\Cloud\PubSub\V1\SchemaServiceClient;
use Google\Cloud\PubSub\V1\SubscriberClient;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group pubsub
 */
class PubSubClientTest extends TestCase
{
    use GrpcTestTrait;

    const PROJECT = 'project';
    const SCHEMA = 'schema';

    private $connection;

    private $client;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);

        $this->client = TestHelpers::stub(PubSubClient::class, [
            [
                'projectId' => self::PROJECT,
                'transport' => 'rest'
            ]
        ]);
    }

    public function testUsesGrpcConnectionByDefault()
    {
        $this->checkAndSkipGrpcTests();
        $client = TestHelpers::stub(PubSubClient::class, [
            ['projectId' => self::PROJECT]
        ]);

        $this->assertInstanceOf(Grpc::class, $client->___getProperty('connection'));
    }

    public function testCreateTopic()
    {
        $topicName = 'test-topic';

        $this->connection->createTopic(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'name' => SubscriberClient::topicName(self::PROJECT, $topicName)
            ]);

        // Set this to zero to make sure we're getting the cached result
        $this->connection->getTopic(Argument::any())->shouldNotBeCalled();

        $this->client->___setProperty('connection', $this->connection->reveal());

        $topic = $this->client->createTopic($topicName, [
            'foo' => 'bar'
        ]);

        $this->assertInstanceOf(Topic::class, $topic);

        $info = $topic->info();
        $this->assertEquals($info['name'], SubscriberClient::topicName(self::PROJECT, $topicName));
    }

    public function testTopic()
    {
        $topicName = 'test-topic';

        $this->connection->getTopic(Argument::any())
            ->willReturn([
                'name' => SubscriberClient::topicName(self::PROJECT, $topicName)
            ])->shouldBeCalledTimes(1);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $topic = $this->client->topic($topicName);

        $this->assertInstanceOf(Topic::class, $topic);

        $info = $topic->info();
        $this->assertEquals($info['name'], SubscriberClient::topicName(self::PROJECT, $topicName));
    }

    public function testTopics()
    {
        $topicResult = [
            [
                'name' => SubscriberClient::topicName(self::PROJECT, 'topic-a')
            ], [
                'name' => SubscriberClient::topicName(self::PROJECT, 'topic-b')
            ], [
                'name' => SubscriberClient::topicName(self::PROJECT, 'topic-c')
            ]
        ];

        $this->connection->listTopics(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'topics' => $topicResult
            ])->shouldBeCalledTimes(1);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $topics = $this->client->topics([
            'foo' => 'bar'
        ]);

        $this->assertInstanceOf(ItemIterator::class, $topics);

        $arr = iterator_to_array($topics);
        $this->assertInstanceOf(Topic::class, $arr[0]);
        $this->assertEquals($arr[0]->info()['name'], $topicResult[0]['name']);
        $this->assertEquals($arr[1]->info()['name'], $topicResult[1]['name']);
        $this->assertEquals($arr[2]->info()['name'], $topicResult[2]['name']);
    }

    public function testTopicsPaged()
    {
        $topicResult = [
            [
                'name' => SubscriberClient::topicName(self::PROJECT, 'topic-a')
            ], [
                'name' => SubscriberClient::topicName(self::PROJECT, 'topic-b')
            ], [
                'name' => SubscriberClient::topicName(self::PROJECT, 'topic-c')
            ]
        ];

        $this->connection->listTopics(Argument::allOf(
            Argument::withEntry('foo', 'bar'),
            Argument::that(function ($options) {
                if (isset($options['pageToken']) && $options['pageToken'] !== 'foo') {
                    return false;
                }

                return true;
            })
        ))->willReturn([
            'topics' => $topicResult,
            'nextPageToken' => 'foo'
        ])->shouldBeCalledTimes(2);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $topics = $this->client->topics([
            'foo' => 'bar'
        ]);

        // enumerate the iterator and kill after it loops twice.
        $arr = [];
        $i = 0;
        foreach ($topics as $topic) {
            $i++;
            $arr[] = $topic;
            if ($i == 6) {
                break;
            }
        }

        $this->assertCount(6, $arr);
    }

    public function testSubscribe()
    {
        $this->connection->createSubscription(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'test' => 'value'
            ])->shouldBeCalledTimes(1);

        $this->connection->getSubscription()->shouldNotBeCalled();

        $this->client->___setProperty('connection', $this->connection->reveal());

        $subscription = $this->client->subscribe('subscription', 'topic', [
            'foo' => 'bar'
        ]);

        $this->assertInstanceOf(Subscription::class, $subscription);
        $this->assertEquals('value', $subscription->info()['test']);
    }

    public function testSubscription()
    {
        $this->connection->getSubscription(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn(['foo' => 'bar']);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $subscription = $this->client->subscription('subscription-name', 'topic-name');

        $info = $subscription->info();

        $this->assertInstanceOf(Subscription::class, $subscription);

        $this->assertEquals('bar', $info['foo']);
    }

    public function testSubscriptions()
    {
        $subscriptionResult = [
            [
                'name' => SubscriberClient::subscriptionName(self::PROJECT, 'subscription-a'),
                'topic' => SubscriberClient::topicName(self::PROJECT, 'topic-a')
            ], [
                'name' => SubscriberClient::subscriptionName(self::PROJECT, 'subscription-b'),
                'topic' => SubscriberClient::topicName(self::PROJECT, 'topic-a')
            ], [
                'name' => SubscriberClient::subscriptionName(self::PROJECT, 'subscription-c'),
                'topic' => SubscriberClient::topicName(self::PROJECT, 'topic-a')
            ]
        ];

        $this->connection->listSubscriptions(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'subscriptions' => $subscriptionResult
            ])->shouldBeCalledTimes(1);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $subscriptions = $this->client->subscriptions([
            'foo' => 'bar'
        ]);

        $this->assertInstanceOf(ItemIterator::class, $subscriptions);

        $arr = iterator_to_array($subscriptions);
        $this->assertInstanceOf(Subscription::class, $arr[0]);
        $this->assertEquals($arr[0]->info()['name'], $subscriptionResult[0]['name']);
        $this->assertEquals($arr[1]->info()['name'], $subscriptionResult[1]['name']);
        $this->assertEquals($arr[2]->info()['name'], $subscriptionResult[2]['name']);
    }

    public function testSubscriptionsPaged()
    {
        $subscriptionResult = [
            [
                'name' => SubscriberClient::subscriptionName(self::PROJECT, 'subscription-a'),
                'topic' => SubscriberClient::topicName(self::PROJECT, 'topic-a')
            ], [
                'name' => SubscriberClient::subscriptionName(self::PROJECT, 'subscription-b'),
                'topic' => SubscriberClient::topicName(self::PROJECT, 'topic-a')
            ], [
                'name' => SubscriberClient::subscriptionName(self::PROJECT, 'subscription-c'),
                'topic' => SubscriberClient::topicName(self::PROJECT, 'topic-a')
            ]
        ];

        $this->connection->listSubscriptions(Argument::allOf(
            Argument::withEntry('foo', 'bar'),
            Argument::that(function ($options) {
                if (isset($options['pageToken']) && $options['pageToken'] !== 'foo') {
                    return false;
                }

                return true;
            })
        ))->willReturn([
            'subscriptions' => $subscriptionResult,
            'nextPageToken' => 'foo'
        ])->shouldBeCalledTimes(2);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $subscriptions = $this->client->subscriptions([
            'foo' => 'bar'
        ]);

        // enumerate the iterator and kill after it loops twice.
        $arr = [];
        $i = 0;
        foreach ($subscriptions as $subscription) {
            $i++;
            $arr[] = $subscription;
            if ($i == 6) {
                break;
            }
        }

        $this->assertCount(6, $arr);
    }

    public function testCreateSnapshot()
    {
        $this->connection->createSnapshot(Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $subscription = $this->client->subscription('bar');

        $res = $this->client->createSnapshot('foo', $subscription);
        $this->assertInstanceOf(Snapshot::class, $res);
        $this->assertEquals(SubscriberClient::snapshotName(self::PROJECT, 'foo'), $res->name());
    }

    public function testSnapshot()
    {
        $res = $this->client->snapshot('foo');
        $this->assertInstanceOf(Snapshot::class, $res);
        $this->assertEquals(SubscriberClient::snapshotName(self::PROJECT, 'foo'), $res->name());
    }

    public function testSnapshots()
    {
        $snapshotResult = [
            [
                'name' => SubscriberClient::snapshotName(self::PROJECT, 'snapshot-a')
            ], [
                'name' => SubscriberClient::snapshotName(self::PROJECT, 'snapshot-b')
            ], [
                'name' => SubscriberClient::snapshotName(self::PROJECT, 'snapshot-c')
            ]
        ];

        $this->connection->listSnapshots(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'snapshots' => $snapshotResult
            ])->shouldBeCalledTimes(1);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $snapshots = $this->client->snapshots([
            'foo' => 'bar'
        ]);

        $this->assertInstanceOf(ItemIterator::class, $snapshots);

        $arr = iterator_to_array($snapshots);
        $this->assertInstanceOf(Snapshot::class, $arr[0]);
        $this->assertEquals($arr[0]->info()['name'], $snapshotResult[0]['name']);
        $this->assertEquals($arr[1]->info()['name'], $snapshotResult[1]['name']);
        $this->assertEquals($arr[2]->info()['name'], $snapshotResult[2]['name']);
    }

    public function testSnapshotsPaged()
    {
        $snapshotResult = [
            [
                'name' => SubscriberClient::snapshotName(self::PROJECT, 'snapshot-a')
            ], [
                'name' => SubscriberClient::snapshotName(self::PROJECT, 'snapshot-b')
            ], [
                'name' => SubscriberClient::snapshotName(self::PROJECT, 'snapshot-c')
            ]
        ];

        $this->connection->listSnapshots(Argument::allOf(
            Argument::withEntry('foo', 'bar'),
            Argument::that(function ($options) {
                if (isset($options['pageToken']) && $options['pageToken'] !== 'foo') {
                    return false;
                }

                return true;
            })
        ))->willReturn([
            'snapshots' => $snapshotResult,
            'nextPageToken' => 'foo'
        ])->shouldBeCalledTimes(2);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $snapshots = $this->client->snapshots([
            'foo' => 'bar'
        ]);

        // enumerate the iterator and kill after it loops twice.
        $arr = [];
        $i = 0;
        foreach ($snapshots as $snapshot) {
            $i++;
            $arr[] = $snapshot;
            if ($i == 6) {
                break;
            }
        }

        $this->assertCount(6, $arr);
    }

    public function testSchema()
    {
        $schema = $this->client->schema(self::SCHEMA);
        $this->assertInstanceOf(Schema::class, $schema);
        $this->assertEquals(
            SchemaServiceClient::schemaName('project', self::SCHEMA),
            $schema->name()
        );
    }

    public function testCreateSchema()
    {
        $type = 'foo';
        $definition = 'bar';
        $res = ['a' => 'b'];

        $this->connection->createSchema([
            'parent' => SubscriberClient::projectName(self::PROJECT),
            'schemaId' => self::SCHEMA,
            'type' => $type,
            'definition' => $definition,
            'schema' => [
                'other' => 'thing',
            ]
        ])->willReturn(['a' => 'b']);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $schema = $this->client->createSchema(self::SCHEMA, $type, $definition, [
            'schema' => [
                'other' => 'thing'
            ]
        ]);

        $this->assertInstanceOf(Schema::class, $schema);
        $this->assertEquals($res, $schema->info());
    }

    public function testSchemas()
    {
        $schemaResult = [
            [
                'name' => PublisherClient::schemaName(self::PROJECT, 'schema-a')
            ], [
                'name' => PublisherClient::schemaName(self::PROJECT, 'schema-b')
            ], [
                'name' => PublisherClient::schemaName(self::PROJECT, 'schema-c')
            ]
        ];

        $this->connection->listSchemas(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'schemas' => $schemaResult
            ])->shouldBeCalledTimes(1);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $schemas = $this->client->schemas([
            'foo' => 'bar'
        ]);

        $this->assertInstanceOf(ItemIterator::class, $schemas);

        $arr = iterator_to_array($schemas);
        $this->assertInstanceOf(Schema::class, $arr[0]);
        $this->assertEquals($arr[0]->info()['name'], $schemaResult[0]['name']);
        $this->assertEquals($arr[1]->info()['name'], $schemaResult[1]['name']);
        $this->assertEquals($arr[2]->info()['name'], $schemaResult[2]['name']);
    }

    public function testValidateSchema()
    {
        $this->connection->validateSchema([
            'parent' => SubscriberClient::projectName(self::PROJECT),
            'schema' => ['a' => 'schema'],
        ])->shouldBeCalled()->willReturn(['foo' => 'bar']);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $this->client->validateSchema(['a' => 'schema']);

        // assert that we're returning whatever we get, even though the method
        // doesn't return anything.
        $this->assertEquals(['foo' => 'bar'], $res);
    }

    /**
     * @expectedException Google\Cloud\Core\Exception\BadRequestException
     */
    public function testValidateSchemaThrowsException()
    {
        $this->connection->validateSchema(Argument::any())
            ->shouldBeCalled()
            ->willThrow(new BadRequestException('foo'));

        $this->client->___setProperty('connection', $this->connection->reveal());

        $this->client->validateSchema(['a' => 'schema']);
    }

    /**
     * @dataProvider messagesToValidate
     */
    public function testValidateMessage($schema, $requestArgs)
    {
        $message = 'hello';
        $encoding = 'JSON';
        $this->connection->validateMessage([
            'parent' => SubscriberClient::projectName(self::PROJECT),
            'message' => $message,
            'encoding' => $encoding,
        ] + $requestArgs)->shouldBeCalled()->willReturn('foo');

        $this->client->___setProperty('connection', $this->connection->reveal());

        $this->assertEquals(
            'foo',
            $this->client->validateMessage($schema, $message, $encoding)
        );
    }

    public function messagesToValidate()
    {
        $schemaName = PublisherClient::schemaName(self::PROJECT, self::SCHEMA);
        $fake = $this->prophesize(Schema::class);
        $fake->name()->willReturn(
            $schemaName
        );

        return [
            [
                $schemaName,
                [
                    'name' => $schemaName,
                ]
            ], [
                $fake->reveal(),
                [
                    'name' => $schemaName,
                ]
            ], [
                ['foo' => 'bar'],
                [
                    'schema' => [
                        'foo' => 'bar'
                    ]
                ]
            ]
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testValidateMessageInvalidSchema()
    {
        $this->client->validateMessage(1, 'foo', 'bar');
    }

    public function testConsume()
    {
        $requestData = [
            'message' => [
                'data' => 'foo'
            ]
        ];

        $res = $this->client->consume($requestData);
        $this->assertInstanceOf(Message::class, $res);
    }

    public function testTimestamp()
    {
        $dt = new \DateTime;
        $ts = $this->client->timestamp($dt);
        $this->assertInstanceOf(Timestamp::class, $ts);
        $this->assertEquals($ts->get(), $dt);
    }

    public function testDuration()
    {
        $val = ['seconds' => 1, 'nanos' => 2];
        $dur = $this->client->duration($val['seconds'], $val['nanos']);
        $this->assertInstanceOf(Duration::class, $dur);
        $this->assertEquals($dur->get(), $val);
    }

    public function testUsesProvidedPublisherClient()
    {
        $this->checkAndSkipGrpcTests();

        $publisherClient = $this->prophesize(PublisherClient::class);
        $publisherClient
            ->getTopic(
                SubscriberClient::topicName(self::PROJECT, 'topic'),
                [ 'retrySettings' => ['retriesEnabled' => false] ]
            )
            ->shouldBeCalled()
        ;

        $client = new PubSubClient([
            'projectId' => 'project',
            'gapicPublisherClient' => $publisherClient->reveal(),
            'transport' => 'grpc',
        ]);
        $client->topic('topic')->reload();
    }

    public function testUsesProvidedSubscriberClient()
    {
        $this->checkAndSkipGrpcTests();

        $subscriberClient = $this->prophesize(SubscriberClient::class);
        $subscriberClient
            ->getSubscription(
                SubscriberClient::subscriptionName(self::PROJECT, 'subscription'),
                [ 'retrySettings' => ['retriesEnabled' => false] ]
            )
            ->shouldBeCalled()
        ;

        $client = new PubSubClient([
            'projectId' => 'project',
            'gapicSubscriberClient' => $subscriberClient->reveal(),
            'transport' => 'grpc',
        ]);
        $client->subscription('subscription', 'topic')->reload();
    }
}
