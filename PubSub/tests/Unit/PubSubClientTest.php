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
use Google\Cloud\PubSub\Message;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Schema;
use Google\Cloud\PubSub\Snapshot;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;
use Google\Cloud\PubSub\V1\PublisherClient;
use Google\Cloud\PubSub\V1\SchemaServiceClient;
use Google\Cloud\PubSub\V1\SubscriberClient;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Google\Cloud\PubSub\V1\Schema\Type;
use Google\Cloud\Core\RequestHandler;

/**
 * @group pubsub
 */
class PubSubClientTest extends TestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;

    const PROJECT = 'project';
    const SCHEMA = 'schema';

    private $requestHandler;

    private $client;

    public function setUp(): void
    {
        $this->requestHandler = $this->prophesize(RequestHandler::class);

        $this->client = TestHelpers::stub(PubSubClient::class, [
            [
                'projectId' => self::PROJECT,
                'transport' => 'rest'
            ]
        ],['requestHandler']);
    }

    public function testCreateTopic()
    {
        $topicName = 'test-topic';

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument(Argument::exact('createTopic'), 2)
        )->willReturn([
            'name' => SubscriberClient::topicName(self::PROJECT, $topicName)
        ]);

        // Set this to zero to make sure we're getting the cached result
        $this->requestHandler->sendReq(
            Argument::any(),
            Argument::exact('getTopic'),
            Argument::cetera()
        )->shouldNotBeCalled();

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

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

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument(Argument::exact('getTopic'), 2)
        )->willReturn([
            'name' => SubscriberClient::topicName(self::PROJECT, $topicName)
        ])->shouldBeCalledTimes(1);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

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

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument(Argument::exact('listTopics'), 2)
        )->willReturn([
                'topics' => $topicResult
        ])->shouldBeCalledTimes(1);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

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

        $this->requestHandler->sendReq(
            Argument::any(),
            Argument::exact('listTopics'),
            Argument::any(),
            Argument::that(function($options) {
                if (isset($options['pageToken']) && $options['pageToken'] !== 'foo') {
                    return false;
                }

                return true;
            })
        )->willReturn([
            'topics' => $topicResult,
            'nextPageToken' => 'foo'
        ])->shouldBeCalledTimes(2);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

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
        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument(Argument::exact('createSubscription'), 2)
        )->willReturn([
            'test' => 'value'
        ])->shouldBeCalledTimes(1);

        $this->requestHandler->sendReq(
            Argument::any(),
            Argument::exact('getSubscription'),
            Argument::cetera()
        )->shouldNotBeCalled();

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $subscription = $this->client->subscribe('subscription', 'topic', [
            'foo' => 'bar'
        ]);

        $this->assertInstanceOf(Subscription::class, $subscription);
        $this->assertEquals('value', $subscription->info()['test']);
    }

    public function testSubscription()
    {
        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument(Argument::exact('getSubscription'), 2)
        )->shouldBeCalledTimes(1)
        ->willReturn(['foo' => 'bar']);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

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

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument(Argument::exact('listSubscriptions'), 2)
        )->willReturn([
            'subscriptions' => $subscriptionResult
        ])->shouldBeCalledTimes(1);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

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

        $this->requestHandler->sendReq(
            Argument::any(),
            Argument::exact('listSubscriptions'),
            Argument::any(),
            Argument::that(function($options) {
                if (isset($options['pageToken']) && $options['pageToken'] !== 'foo') {
                    return false;
                }

                return true;
            })
        )->willReturn([
            'subscriptions' => $subscriptionResult,
            'nextPageToken' => 'foo'
        ])->shouldBeCalledTimes(2);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

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
        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument(Argument::exact('createSnapshot'), 2)
        )->shouldBeCalled()
        ->willReturn([]);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

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

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument(Argument::exact('listSnapshots'), 2)
        )->willReturn([
            'snapshots' => $snapshotResult
        ])->shouldBeCalledTimes(1);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

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

        $this->requestHandler->sendReq(
            Argument::any(),
            Argument::exact('listSnapshots'),
            Argument::any(),
            Argument::that(function($options) {
                if (isset($options['pageToken']) && $options['pageToken'] !== 'foo') {
                    return false;
                }

                return true;
            })
        )->willReturn([
            'snapshots' => $snapshotResult,
            'nextPageToken' => 'foo'
        ])->shouldBeCalledTimes(2);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

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
        $type = Type::AVRO;
        $definition = 'bar';
        $res = ['a' => 'b'];

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument(Argument::exact('createSchema'), 2)
        )->willReturn(['a' => 'b']);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

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

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument(Argument::exact('listSchemas'), 2)
        )->willReturn([
            'schemas' => $schemaResult
        ])->shouldBeCalledTimes(1);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

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
        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument(Argument::exact('validateSchema'), 2)
        )->shouldBeCalled()->willReturn(['foo' => 'bar']);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->client->validateSchema(['a' => 'schema']);

        // assert that we're returning whatever we get, even though the method
        // doesn't return anything.
        $this->assertEquals(['foo' => 'bar'], $res);
    }

    public function testValidateSchemaThrowsException()
    {
        $this->expectException(BadRequestException::class);

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument(Argument::exact('validateSchema'), 2)
        )->shouldBeCalled()
        ->willThrow(new BadRequestException('foo'));

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->client->validateSchema(['a' => 'schema']);
    }

    /**
     * @dataProvider messagesToValidate
     */
    public function testValidateMessage($schema, $requestArgs)
    {
        $message = 'hello';
        $encoding = 'JSON';
        $this->requestHandler->sendReq(
            Argument::any(),
            Argument::exact('validateMessage'),
            [SubscriberClient::projectName(self::PROJECT)],
            $requestArgs + [
                'message' => $message,
                'encoding' => $encoding
            ])->shouldBeCalled()->willReturn('foo');

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());
        $res = $this->client->validateMessage($schema, $message, $encoding);

        $this->assertEquals(
            'foo',
            $res
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

    public function testValidateMessageInvalidSchema()
    {
        $this->expectException(InvalidArgumentException::class);

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

    private function matchesNthArgument($wildcard, $num)
    {
        $args = [];
        for ($i = 0; $i < $num - 1; $i++) {
            $args[] = Argument::any();
        }

        $args[] = $wildcard;
        $args[] = Argument::cetera();
        return $args;
    }
}
