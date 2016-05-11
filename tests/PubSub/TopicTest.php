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

namespace Google\Cloud\Tests\PubSub;

use Generator;
use Google\Cloud\Exception\NotFoundException;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;
use Prophecy\Argument;

class TopicTest extends \PHPUnit_Framework_TestCase
{
    private $connection;

    public function setUp()
    {
        $this->connection = $this->prophesize('Google\Cloud\PubSub\Connection\ConnectionInterface');
    }

    public function testCreate()
    {
        $this->connection->createTopic(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'name' => 'projects/project-name/topics/topic-name'
            ]);

        $this->connection->getTopic()->shouldNotBeCalled();

        $topic = new Topic(
            $this->connection->reveal(),
            'topic-name',
            'project-name'
        );

        $res = $topic->create(['foo' => 'bar']);

        // Make sure the topic data gets cached!
        $topic->info();

        $this->assertEquals('projects/project-name/topics/topic-name', $res['name']);
    }

    public function testDelete()
    {
        $this->connection->deleteTopic(Argument::withEntry('foo', 'bar'));

        $topic = new Topic(
            $this->connection->reveal(),
            'topic-name',
            'project-name'
        );

        $res = $topic->delete(['foo' => 'bar']);
    }

    public function testExists()
    {
        $this->connection->getTopic(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'name' => 'projects/project-name/topics/topic-name'
            ]);

        $topic = new Topic(
            $this->connection->reveal(),
            'topic-name',
            'project-name'
        );

        $this->assertTrue($topic->exists(['foo' => 'bar']));
    }

    public function testExistsReturnsFalse()
    {
        $this->connection->getTopic(Argument::withEntry('foo', 'bar'))
            ->willThrow(new NotFoundException('uh oh'));

        $topic = new Topic(
            $this->connection->reveal(),
            'topic-name',
            'project-name'
        );

        $this->assertFalse($topic->exists(['foo' => 'bar']));
    }

    public function testInfo()
    {
        $this->connection->getTopic(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'name' => 'projects/project-name/topics/topic-name'
            ])->shouldBeCalledTimes(1);

        $topic = new Topic(
            $this->connection->reveal(),
            'topic-name',
            'project-name'
        );

        $res = $topic->info(['foo' => 'bar']);
        $res2 = $topic->info();

        $this->assertEquals($res, $res2);
        $this->assertEquals($res['name'], 'projects/project-name/topics/topic-name');
    }

    public function testReload()
    {
        $this->connection->getTopic(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'name' => 'projects/project-name/topics/topic-name'
            ]);

        $topic = new Topic(
            $this->connection->reveal(),
            'topic-name',
            'project-name'
        );

        $res = $topic->reload(['foo' => 'bar']);

        $this->assertEquals($res['name'], 'projects/project-name/topics/topic-name');
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

        $this->connection->publishMessage(Argument::that(function ($options) use ($message) {
            if ($options['foo'] !== 'bar') return false;

            $message['data'] = base64_encode($message['data']);
            if ($options['messages'] !== [$message]) return false;

            return true;
        }))->willReturn($ids);

        $topic = new Topic(
            $this->connection->reveal(),
            'topic-name',
            'project-name'
        );

        $res = $topic->publish($message, ['foo' => 'bar']);

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

        $this->connection->publishMessage(Argument::that(function ($options) use ($messages) {
            if ($options['foo'] !== 'bar') return false;

            $messages[0]['data'] = base64_encode($messages[0]['data']);
            $messages[1]['data'] = base64_encode($messages[1]['data']);
            if ($options['messages'] !== $messages) return false;

            return true;
        }))->willReturn($ids);

        $topic = new Topic(
            $this->connection->reveal(),
            'topic-name',
            'project-name'
        );

        $res = $topic->publishBatch($messages, ['foo' => 'bar']);

        $this->assertEquals($res, $ids);
    }

    public function testPublishBatchUnencoded()
    {
        $message = [
            'data' => 'hello world',
            'attributes' => [
                'key' => 'value'
            ]
        ];

        $this->connection->publishMessage(Argument::that(function ($options) use ($message) {
            if ($options['foo'] !== 'bar') return false;

            if ($options['messages'] !== [$message]) return false;

            // If the message was encoded, this will fail the test.
            if ($options['messages'][0]['data'] !== $message['data']) return false;

            return true;
        }));

        $topic = new Topic(
            $this->connection->reveal(),
            'topic-name',
            'project-name'
        );

        $res = $topic->publishBatch([$message], ['foo' => 'bar', 'encode' => false]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testPublishMalformedMessage()
    {
        $message = [
            'key' => 'val'
        ];

        $this->connection->publishMessage(Argument::any());

        $topic = new Topic(
            $this->connection->reveal(),
            'topic-name',
            'project-name'
        );

        $topic->publishBatch([$message]);
    }

    public function testSubscribe()
    {
        $subscriptionData = [
            'name' => 'projects/project-name/subscriptions/subscription-name',
            'topic' => 'projects/project-name/topics/topic-name'
        ];

        $this->connection->createSubscription(Argument::withEntry('foo', 'bar'))
            ->willReturn($subscriptionData)
            ->shouldBeCalledTimes(1);

        $topic = new Topic(
            $this->connection->reveal(),
            'topic-name',
            'project-name'
        );

        $subscription = $topic->subscribe('subscription-name', ['foo' => 'bar']);

        $this->assertInstanceOf(Subscription::class, $subscription);
    }

    public function testSubscription()
    {
        $topic = new Topic(
            $this->connection->reveal(),
            'topic-name',
            'project-name'
        );

        $subscription = $topic->subscription('subscription-name', ['name' => 'subscription-name']);

        $this->assertInstanceOf(Subscription::class, $subscription);
        $this->assertEquals('subscription-name', $subscription->info()['name']);
    }

    public function testSubscriptions()
    {
        $subscriptionResult = [
            [
                'name' => 'projects/project-name/subscriptions/subscription-a',
                'topic' => 'projects/project-name/topics/topic-name'
            ], [
                'name' => 'projects/project-name/subscriptions/subscription-b',
                'topic' => 'projects/project-name/topics/topic-name'
            ], [
                'name' => 'projects/project-name/subscriptions/subscription-c',
                'topic' => 'projects/project-name/topics/topic-name'
            ]
        ];

        $this->connection->listSubscriptionsByTopic(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'subscriptions' => $subscriptionResult
            ])->shouldBeCalledTimes(1);

        $topic = new Topic(
            $this->connection->reveal(),
            'topic-name',
            'project-name'
        );

        $subscriptions = $topic->subscriptions([
            'foo' => 'bar'
        ]);

        $this->assertInstanceOf(Generator::class, $subscriptions);

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
                'name' => 'projects/project-name/subscriptions/subscription-a',
                'topic' => 'projects/project-name/topics/topic-name'
            ], [
                'name' => 'projects/project-name/subscriptions/subscription-b',
                'topic' => 'projects/project-name/topics/topic-name'
            ], [
                'name' => 'projects/project-name/subscriptions/subscription-c',
                'topic' => 'projects/project-name/topics/topic-name'
            ]
        ];

        $this->connection->listSubscriptionsByTopic(Argument::that(function ($options) {
            if ($options['foo'] !== 'bar') return false;
            if ($options['pageToken'] !== 'foo' && !is_null($options['pageToken'])) return false;

            return true;
        }))->willReturn([
            'subscriptions' => $subscriptionResult,
            'nextPageToken' => 'foo'
        ])->shouldBeCalledTimes(2);

        $topic = new Topic(
            $this->connection->reveal(),
            'topic-name',
            'project-name'
        );

        $subscriptions = $topic->subscriptions([
            'foo' => 'bar'
        ]);

        // enumerate the iterator and kill after it loops twice.
        $arr = [];
        $i = 0;
        foreach ($subscriptions as $subscription) {
            $i++;
            $arr[] = $subscription;
            if ($i == 6) break;
        }

        $this->assertEquals(6, count($arr));
    }
}
