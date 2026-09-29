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
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Testing\Snippet\Fixtures;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\PubSub\Message;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Schema;
use Google\Cloud\PubSub\Snapshot;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;
use Google\Cloud\PubSub\V1\Client\PublisherClient;
use Google\Cloud\PubSub\V1\Client\SchemaServiceClient;
use Google\Cloud\PubSub\V1\Client\SubscriberClient;
use Google\Cloud\PubSub\V1\Schema\Type;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

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
    private $serializer;
    private $client;

    public function setUp(): void
    {
        $this->requestHandler = $this->prophesize(RequestHandler::class);

        $this->client = TestHelpers::stub(PubSubClient::class, [
            [
                'projectId' => self::PROJECT,
                'transport' => 'rest',
                'credentials' => Fixtures::KEYFILE_STUB_FIXTURE()
            ]
        ], ['requestHandler']);
    }

    public function testCreateTopic()
    {
        $topicName = 'test-topic';

        $this->requestHandler
            ->sendRequest(
                PublisherClient::class,
                'createTopic',
                Argument::cetera()
            )
                ->willReturn([
                'name' => PublisherClient::topicName(self::PROJECT, $topicName)
            ]);

        // Set this to zero to make sure we're getting the cached result
        $this->requestHandler
            ->sendRequest(
                PublisherClient::class,
                'getTopic',
                Argument::cetera()
            )
            ->shouldNotBeCalled();

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $topic = $this->client->createTopic($topicName, [
            'labels' => []
        ]);

        $this->assertInstanceOf(Topic::class, $topic);

        $info = $topic->info();
        $this->assertEquals($info['name'], PublisherClient::topicName(self::PROJECT, $topicName));
    }

    public function testTopic()
    {
        $topicName = 'test-topic';

        $this->requestHandler
            ->sendRequest(
                PublisherClient::class,
                'getTopic',
                Argument::cetera()
            )
            ->willReturn([
                'name' => PublisherClient::topicName(self::PROJECT, $topicName)
            ])
            ->shouldBeCalledTimes(1);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $topic = $this->client->topic($topicName);

        $this->assertInstanceOf(Topic::class, $topic);

        $info = $topic->info();
        $this->assertEquals($info['name'], PublisherClient::topicName(self::PROJECT, $topicName));
    }

    public function testTopics()
    {
        $topicResult = [
            [
                'name' => PublisherClient::topicName(self::PROJECT, 'topic-a')
            ], [
                'name' => PublisherClient::topicName(self::PROJECT, 'topic-b')
            ], [
                'name' => PublisherClient::topicName(self::PROJECT, 'topic-c')
            ]
        ];

        $this->requestHandler
            ->sendRequest(
                PublisherClient::class,
                'listTopics',
                Argument::cetera()
            )
            ->willReturn([
                'topics' => $topicResult
            ])
            ->shouldBeCalledTimes(1);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $topics = $this->client->topics();

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
                'name' => PublisherClient::topicName(self::PROJECT, 'topic-a')
            ], [
                'name' => PublisherClient::topicName(self::PROJECT, 'topic-b')
            ], [
                'name' => PublisherClient::topicName(self::PROJECT, 'topic-c')
            ]
        ];

        $this->requestHandler
            ->sendRequest(
                PublisherClient::class,
                'listTopics',
                Argument::any(),
                Argument::allOf(
                    Argument::that(function ($options) {
                        if (isset($options['pageToken']) && $options['pageToken'] !== 'foo') {
                            return false;
                        }

                        return true;
                    })
                )
            )
            ->willReturn([
                'topics' => $topicResult,
                'nextPageToken' => 'foo'
            ])
            ->shouldBeCalledTimes(2);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $topics = $this->client->topics();

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
        $this->requestHandler
            ->sendRequest(
                SubscriberClient::class,
                'createSubscription',
                Argument::cetera()
            )
            ->willReturn([
                'test' => 'value'
            ])
            ->shouldBeCalledTimes(1);

        $this->requestHandler
            ->sendRequest(
                SubscriberClient::class,
                'getSubscription',
            )
            ->shouldNotBeCalled();

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $subscription = $this->client->subscribe('subscription', 'topic');

        $this->assertInstanceOf(Subscription::class, $subscription);
        $this->assertEquals('value', $subscription->info()['test']);
    }

    public function testSubscription()
    {
        $this->requestHandler
            ->sendRequest(
                SubscriberClient::class,
                'getSubscription',
                Argument::cetera()
            )
            ->shouldBeCalledTimes(1)
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
                'topic' => PublisherClient::topicName(self::PROJECT, 'topic-a')
            ], [
                'name' => SubscriberClient::subscriptionName(self::PROJECT, 'subscription-b'),
                'topic' => PublisherClient::topicName(self::PROJECT, 'topic-a')
            ], [
                'name' => SubscriberClient::subscriptionName(self::PROJECT, 'subscription-c'),
                'topic' => PublisherClient::topicName(self::PROJECT, 'topic-a')
            ]
        ];

        $this->requestHandler
            ->sendRequest(
                SubscriberClient::class,
                'listSubscriptions',
                Argument::cetera()
            )
            ->willReturn([
                'subscriptions' => $subscriptionResult
            ])
            ->shouldBeCalledTimes(1);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $subscriptions = $this->client->subscriptions();

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
                'topic' => PublisherClient::topicName(self::PROJECT, 'topic-a')
            ], [
                'name' => SubscriberClient::subscriptionName(self::PROJECT, 'subscription-b'),
                'topic' => PublisherClient::topicName(self::PROJECT, 'topic-a')
            ], [
                'name' => SubscriberClient::subscriptionName(self::PROJECT, 'subscription-c'),
                'topic' => PublisherClient::topicName(self::PROJECT, 'topic-a')
            ]
        ];

        $this->requestHandler
            ->sendRequest(
                SubscriberClient::class,
                'listSubscriptions',
                Argument::any(),
                Argument::allOf(
                    Argument::that(function ($options) {
                        if (isset($options['pageToken']) && $options['pageToken'] !== 'foo') {
                            return false;
                        }

                        return true;
                    })
                )
            )
            ->willReturn([
                'subscriptions' => $subscriptionResult,
                'nextPageToken' => 'foo'
            ])
            ->shouldBeCalledTimes(2);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $subscriptions = $this->client->subscriptions();

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
        $this->requestHandler
            ->sendRequest(
                SubscriberClient::class,
                'createSnapshot',
                Argument::cetera()
            )
            ->shouldBeCalled()
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

        $this->requestHandler
            ->sendRequest(
                SubscriberClient::class,
                'listSnapshots',
                Argument::cetera()
            )
            ->willReturn([
                'snapshots' => $snapshotResult
            ])
            ->shouldBeCalledTimes(1);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $snapshots = $this->client->snapshots();

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

        $this->requestHandler
            ->sendRequest(
                SubscriberClient::class,
                'listSnapshots',
                Argument::any(),
                Argument::allOf(
                    Argument::that(function ($options) {
                        if (isset($options['pageToken']) && $options['pageToken'] !== 'foo') {
                            return false;
                        }

                        return true;
                    })
                )
            )
            ->willReturn([
                'snapshots' => $snapshotResult,
                'nextPageToken' => 'foo'
            ])
            ->shouldBeCalledTimes(2);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $snapshots = $this->client->snapshots();

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

        $this->requestHandler
            ->sendRequest(
                SchemaServiceClient::class,
                'createSchema',
                Argument::cetera()
            )
            ->willReturn(['a' => 'b']);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $schema = $this->client->createSchema(self::SCHEMA, $type, $definition);

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

        $this->requestHandler
            ->sendRequest(
                SchemaServiceClient::class,
                'listSchemas',
                Argument::cetera()
            )
            ->willReturn([
                'schemas' => $schemaResult
            ])
            ->shouldBeCalledTimes(1);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $schemas = $this->client->schemas();

        $this->assertInstanceOf(ItemIterator::class, $schemas);

        $arr = iterator_to_array($schemas);
        $this->assertInstanceOf(Schema::class, $arr[0]);
        $this->assertEquals($arr[0]->info()['name'], $schemaResult[0]['name']);
        $this->assertEquals($arr[1]->info()['name'], $schemaResult[1]['name']);
        $this->assertEquals($arr[2]->info()['name'], $schemaResult[2]['name']);
    }

    public function testValidateSchema()
    {
        $this->requestHandler
            ->sendRequest(
                SchemaServiceClient::class,
                'validateSchema',
                Argument::cetera()
            )
            ->shouldBeCalled()
            ->willReturn(['foo' => 'bar']);

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->client->validateSchema([
            'type' => 'AVRO',
            'definition' => ''
        ]);

        $this->assertEquals(['foo' => 'bar'], $res);
    }

    public function testValidateSchemaThrowsException()
    {
        $this->expectException(BadRequestException::class);

        $this->requestHandler
            ->sendRequest(
                SchemaServiceClient::class,
                'validateSchema',
                Argument::cetera()
            )
            ->shouldBeCalled()
            ->willThrow(new BadRequestException('foo'));

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->client->validateSchema([
            'type' => 'AVRO',
            'definition' => ''
        ]);
    }

    /**
     * @dataProvider messagesToValidate
     */
    public function testValidateMessage($schema)
    {
        $message = 'hello';
        $encoding = 'JSON';
        $this->requestHandler
            ->sendRequest(
                SchemaServiceClient::class,
                'validateMessage',
                Argument::cetera()
            )
            ->shouldBeCalled()
            ->willReturn('foo');

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());

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
                // string
                $schemaName
            ], [
                // instance of Schema class
                $fake->reveal()
            ], [
                // array
                [
                    'type' => 'AVRO',
                    'definition' => ''
                ]
            ]
        ];
    }

    public function testValidateMessageInvalidSchema()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->client->validateMessage(1, 'foo', 'JSON');
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
}
