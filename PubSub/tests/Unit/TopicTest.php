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

use Google\ApiCore\Veneer\Exception\NotFoundException;
use Google\ApiCore\Veneer\Iterator\ItemIterator;
use Google\ApiCore\Veneer\RequestHandler;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\V2\Iam;
use Google\Cloud\PubSub\BatchPublisher;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;
use Google\Cloud\PubSub\V1\PubsubMessage;
use Google\Cloud\PubSub\V1\Topic as V1Topic;
use Google\Protobuf\FieldMask;
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
    use ArgumentHelperTrait;

    const TOPIC = 'projects/project-name/topics/topic-name';

    private $topic;
    private $requestHandler;

    public function setUp(): void
    {
        $this->requestHandler = $this->prophesize(RequestHandler::class);
        $this->topic = TestHelpers::stub(Topic::class, [
            $this->requestHandler->reveal(),
            'project-name',
            'topic-name',
            true
        ],['requestHandler', 'enableCompression', 'compressionBytesThreshold']);
    }

    public function testName()
    {
        $this->assertEquals($this->topic->name(), self::TOPIC);
    }

    public function testCreate()
    {
        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('createTopic'), 2]
            ])
        )->willReturn([
            'name' => self::TOPIC
        ]);

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('getTopic'), 2]
            ])
        )->shouldNotBeCalled();

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->topic->create(['foo' => 'bar']);

        // Make sure the topic data gets cached!
        $this->topic->info();

        $this->assertEquals(self::TOPIC, $res['name']);
    }

    public function testUpdate()
    {
        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('updateTopic'), 2],
                [Argument::that(function($args) {
                    return $args[0] instanceof V1Topic && $args[1] instanceof FieldMask;
                }), 3]
            ])
        )->shouldBeCalled()->willReturn([
            'foo' => 'bar'
        ]);

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->topic->update(['labels' => ['bar']]);

        $this->assertEquals(['foo' => 'bar'], $res);
        $this->assertEquals('bar', $this->topic->info()['foo']);
    }

    public function testDelete()
    {
        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('deleteTopic'), 2]
            ])
        )->shouldBeCalled();

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->topic->delete(['foo' => 'bar']);
    }

    public function testExists()
    {
        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('getTopic'), 2]
            ])
        )->willReturn([
            'name' => self::TOPIC
        ]);

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->assertTrue($this->topic->exists(['foo' => 'bar']));
    }

    public function testExistsReturnsFalse()
    {
        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('getTopic'), 2]
            ])
        )->willThrow(new NotFoundException('uh oh'));

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->assertFalse($this->topic->exists(['foo' => 'bar']));
    }

    public function testInfo()
    {
        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('getTopic'), 2]
            ])
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
        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('getTopic'), 2]
            ])
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

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('publish'), 2],
                [Argument::that(function ($args) use ($message) {
                    $message['data'] = base64_encode($message['data']);

                    return $args[0] === self::TOPIC && $args[1][0] instanceof PubsubMessage && $args[1][0]->getData() === $message['data'];
                }), 3],
                [Argument::withEntry('foo', 'bar'), 4]
            ])
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

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('publish'), 2],
                [
                    Argument::that(function ($args) use ($messages) {
                        $validArg = $args[0] === self::TOPIC;
        
                        foreach($messages as $key => $msg) {
                            $validArg = $validArg && (base64_encode($msg['data']) == $args[1][$key]->getData());
                            $validArg = $validArg && $args[1][$key] instanceof PubsubMessage;
                        }
                        $messages[0]['data'] = base64_encode($messages[0]['data']);
                        $messages[1]['data'] = base64_encode($messages[1]['data']);
        
                        return  $validArg;
                    }), 3
                ],
                [Argument::withEntry('foo', 'bar'), 4]
            ])
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

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('publish'), 2]
            ])
        );

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

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

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('createSubscription'), 2],
                [Argument::withEntry('foo', 'bar'), 4]
            ])
        )->willReturn($subscriptionData)
        ->shouldBeCalledTimes(1);

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $subscription = $this->topic->subscribe('subscription-name', ['foo' => 'bar']);

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

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('listTopicSubscriptions'), 2]
            ])
        )->willReturn([
            'subscriptions' => $subscriptionResult
        ])->shouldBeCalledTimes(1);

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $subscriptions = $this->topic->subscriptions([
            'foo' => 'bar'
        ]);

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

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('listTopicSubscriptions'), 2],
                [Argument::that(function($options) {
                    if (isset($options['pageToken']) && $options['pageToken'] !== 'foo') {
                        return false;
                    }
    
                    return true;
                }), 4]
            ])
        )->willReturn([
            'subscriptions' => $subscriptionResult,
            'nextPageToken' => 'foo'
        ])->shouldBeCalledTimes(2);

        $this->topic->___setProperty('requestHandler', $this->requestHandler->reveal());

        $subscriptions = $this->topic->subscriptions([
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

    public function testIam()
    {
        $this->assertInstanceOf(Iam::class, $this->topic->iam());
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
                $this->connection->reveal(),
                'project-name',
                'topic-name',
                true,
                $info
            ],
            ['connection']
        );
        $messages = [['data' => 'hello world']];

        $this->connection->publishMessage(Argument::that(
            function ($args) use (
                $processedEnableCompression,
                $processedCompressionBytesThreshold
            ) {
                $result = is_array($args) &&
                    array_key_exists('messages', $args) &&
                    array_key_exists('topic', $args) &&
                    array_key_exists('compressionOptions', $args);

                if ($result &&
                    ($args['compressionOptions']['enableCompression'] === $processedEnableCompression) &&
                    ($args['compressionOptions']['compressionBytesThreshold'] === $processedCompressionBytesThreshold)
                ) {
                    return true;
                }

                return false;
            }
        ))->shouldBeCalled(1)->willReturn([]);

        $topic->___setProperty('connection', $this->connection->reveal());
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
