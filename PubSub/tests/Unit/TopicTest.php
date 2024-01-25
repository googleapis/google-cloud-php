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

use Google\ApiCore\Serializer;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iam\IamManager;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\PubSub\BatchPublisher;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;
use Google\Cloud\PubSub\V1\Client\PublisherClient;
use Google\Cloud\PubSub\V1\Client\SubscriberClient;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group pubsub
 */
class TopicTest extends TestCase
{
    use ProphecyTrait;
    use ApiHelperTrait;

    const TOPIC = 'projects/project-name/topics/topic-name';

    private $topic;
    private $serializer;
    private $requestHandler;

    public function setUp(): void
    {
        $this->requestHandler = $this->prophesize(RequestHandler::class);
        $this->serializer = new Serializer([
            'publish_time' => function ($v) {
                return $this->formatTimestampFromApi($v);
            },
            'expiration_time' => function ($v) {
                return $this->formatTimestampFromApi($v);
            }
        ], [], [], [
            'google.protobuf.Duration' => function ($v) {
                return $this->formatDurationForApi($v);
            }
        ]);
        $this->topic = TestHelpers::stub(
            Topic::class,
            [
                $this->requestHandler->reveal(),
                $this->serializer,
                'project-name',
                'topic-name',
                true
            ],
            ['requestHandler', 'enableCompression', 'compressionBytesThreshold']
        );
    }

    public function testName()
    {
        $this->assertEquals($this->topic->name(), self::TOPIC);
    }

    public function testCreate()
    {
        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'createTopic',
            Argument::cetera()
        )->willReturn([
            'name' => self::TOPIC
        ]);

        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'getTopic',
            Argument::cetera()
        )->shouldNotBeCalled();

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->topic->create(['labels' => []]);

        // Make sure the topic data gets cached!
        $this->topic->info();

        $this->assertEquals(self::TOPIC, $res['name']);
    }

    public function testUpdate()
    {
        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'updateTopic',
            Argument::cetera()
        )->shouldBeCalled()->willReturn([
            'foo' => 'bar'
        ]);

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->topic->update(['labels' => []]);

        $this->assertEquals(['foo' => 'bar'], $res);
        $this->assertEquals('bar', $this->topic->info()['foo']);
    }

    public function testDelete()
    {
        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'deleteTopic',
            Argument::cetera()
        )->shouldBeCalled();

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->topic->delete(['foo' => 'bar']);
    }

    public function testExists()
    {
        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'getTopic',
            Argument::cetera()
        )->willReturn([
            'name' => self::TOPIC
        ]);

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->assertTrue($this->topic->exists(['foo' => 'bar']));
    }

    public function testExistsReturnsFalse()
    {
        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'getTopic',
            Argument::cetera()
        )->willThrow(new NotFoundException('uh oh'));

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->assertFalse($this->topic->exists(['foo' => 'bar']));
    }

    public function testInfo()
    {
        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'getTopic',
            Argument::cetera()
        )->willReturn([
            'name' => self::TOPIC
        ])->shouldBeCalledTimes(1);

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->topic->info(['foo' => 'bar']);
        $res2 = $this->topic->info();

        $this->assertEquals($res, $res2);
        $this->assertEquals($res['name'], self::TOPIC);
    }

    public function testReload()
    {
        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'getTopic',
            Argument::cetera()
        )->willReturn([
            'name' => self::TOPIC
        ]);

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->topic->reload(['foo' => 'bar']);

        $this->assertEquals($res['name'], self::TOPIC);
    }

    public function testPublish()
    {
        $message = [
            'data' => 'hello world',
            'attributes' => [
                'key' => 'value'
            ]
        ];

        $ids = [
            'message1id'
        ];

        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'publish',
            Argument::cetera()
        )->willReturn($ids);

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->topic->publish($message, ['foo' => 'bar']);

        $this->assertEquals($res, $ids);
    }

    public function testPublishBatch()
    {
        $messages = [
            [
                'data' => 'hello world',
                'attributes' => [
                    'key' => 'value'
                ]
            ], [
                'data' => 'hello again, world',
                'attributes' => [
                    'key' => 'other value i guess'
                ]
            ]
        ];

        $ids = [
            'message1id',
            'message2id'
        ];

        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'publish',
            Argument::cetera()
        )->willReturn($ids);

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->topic->publishBatch($messages, ['foo' => 'bar']);

        $this->assertEquals($res, $ids);
    }

    public function testPublishMalformedMessage()
    {
        $this->expectException(InvalidArgumentException::class);

        $message = [
            'key' => 'val'
        ];

        $this->topic->publishBatch([$message]);
    }

    public function testBatchPublisher()
    {
        $this->assertInstanceOf(
            BatchPublisher::class,
            $this->topic->batchPublisher()
        );
    }

    public function testSubscribe()
    {
        $subscriptionData = [
            'name' => 'projects/project-name/subscriptions/subscription-name',
            'topic' => self::TOPIC
        ];

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'createSubscription',
            Argument::cetera()
        )->willReturn($subscriptionData)
        ->shouldBeCalledTimes(1);

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $subscription = $this->topic->subscribe('subscription-name', ['labels' => []]);

        $this->assertInstanceOf(Subscription::class, $subscription);
    }

    public function testSubscription()
    {
        $subscription = $this->topic->subscription('subscription-name');

        $this->assertInstanceOf(Subscription::class, $subscription);
    }

    public function testSubscriptions()
    {
        $subscriptionResult = [
            'projects/project-name/subscriptions/subscription-a',
            'projects/project-name/subscriptions/subscription-b',
            'projects/project-name/subscriptions/subscription-c',
        ];

        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'listTopicSubscriptions',
            Argument::cetera()
        )->willReturn([
            'subscriptions' => $subscriptionResult
        ])->shouldBeCalledTimes(1);

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $subscriptions = $this->topic->subscriptions();

        $this->assertInstanceOf(ItemIterator::class, $subscriptions);

        $arr = iterator_to_array($subscriptions);
        $this->assertInstanceOf(Subscription::class, $arr[0]);
        $this->assertEquals($arr[0]->name(), $subscriptionResult[0]);
        $this->assertEquals($arr[1]->name(), $subscriptionResult[1]);
        $this->assertEquals($arr[2]->name(), $subscriptionResult[2]);
    }

    public function testSubscriptionsPaged()
    {
        $subscriptionResult = [
            'projects/project-name/subscriptions/subscription-a',
            'projects/project-name/subscriptions/subscription-b',
            'projects/project-name/subscriptions/subscription-c',
        ];

        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'listTopicSubscriptions',
            Argument::cetera(),
            Argument::allOf(
                Argument::that(function ($options) {
                    if (isset($options['pageToken']) && $options['pageToken'] !== 'foo') {
                        return false;
                    }

                    return true;
                })
            )
        )->willReturn([
            'subscriptions' => $subscriptionResult,
            'nextPageToken' => 'foo'
        ])->shouldBeCalledTimes(2);

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $subscriptions = $this->topic->subscriptions();

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

    public function testIam()
    {
        $this->assertInstanceOf(IamManager::class, $this->topic->iam());
    }

    /**
     * @dataProvider compressionOptionsProvider
     */
    public function testCompressionOptionsSetup(
        $enableCompression,
        $compressionBytesThreshold,
        $processedEnableCompression,
        $processedCompressionBytesThreshold
    ) {
        $info = [];
        if (isset($enableCompression)) {
            $info['enableCompression'] = $enableCompression;
        }
        if (isset($compressionBytesThreshold)) {
            $info['compressionBytesThreshold'] = $compressionBytesThreshold;
        }

        $topic = TestHelpers::stub(
            Topic::class,
            [
                $this->requestHandler->reveal(),
                $this->serializer,
                'project-name',
                'topic-name',
                true,
                $info
            ],
            ['requestHandler']
        );
        $messages = [['data' => 'hello world']];

        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'publish',
            Argument::cetera()
        )->shouldBeCalled(1)->willReturn([]);

        $topic->___setProperty('requestHandler', $this->requestHandler->reveal());
        $topic->publishBatch($messages);
    }

    public function compressionOptionsProvider()
    {
        // Each data is of the form
        // [
        //  $enableCompression                      Input option
        //  $compressionBytesThreshold              Input option
        //  $processedEnableCompression             Expected set option
        //  $processedCompressionBytesThreshold     Expected set option
        // ]
        return [
            [null, null, false, Topic::DEFAULT_COMPRESSION_BYTES_THRESHOLD],
            [false, null, false, Topic::DEFAULT_COMPRESSION_BYTES_THRESHOLD],
            [false, 10000, false, Topic::DEFAULT_COMPRESSION_BYTES_THRESHOLD],
            [true, null, true, Topic::DEFAULT_COMPRESSION_BYTES_THRESHOLD],
            [true, 10000, true, 10000],
        ];
    }
}
