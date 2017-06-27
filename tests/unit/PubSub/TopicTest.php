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

namespace Google\Cloud\Tests\Unit\PubSub;

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\PubSub\BatchPublisher;
use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;
use Prophecy\Argument;

/**
 * @group pubsub
 */
class TopicTest extends \PHPUnit_Framework_TestCase
{
    private $topic;
    private $connection;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->topic = new TopicStub(
            $this->connection->reveal(),
            'project-name',
            'topic-name',
            true
        );
    }

    public function testName()
    {
        $this->assertEquals($this->topic->name(), 'projects/project-name/topics/topic-name');
    }

    public function testCreate()
    {
        $this->connection->createTopic(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'name' => 'projects/project-name/topics/topic-name'
            ]);

        $this->connection->getTopic()->shouldNotBeCalled();

        $this->topic->setConnection($this->connection->reveal());

        $res = $this->topic->create(['foo' => 'bar']);

        // Make sure the topic data gets cached!
        $this->topic->info();

        $this->assertEquals('projects/project-name/topics/topic-name', $res['name']);
    }

    public function testDelete()
    {
        $this->connection->deleteTopic(Argument::withEntry('foo', 'bar'))
            ->shouldBeCalled();

        $this->topic->setConnection($this->connection->reveal());

        $res = $this->topic->delete(['foo' => 'bar']);
    }

    public function testExists()
    {
        $this->connection->getTopic(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'name' => 'projects/project-name/topics/topic-name'
            ]);

        $this->topic->setConnection($this->connection->reveal());

        $this->assertTrue($this->topic->exists(['foo' => 'bar']));
    }

    public function testExistsReturnsFalse()
    {
        $this->connection->getTopic(Argument::withEntry('foo', 'bar'))
            ->willThrow(new NotFoundException('uh oh'));

        $this->topic->setConnection($this->connection->reveal());

        $this->assertFalse($this->topic->exists(['foo' => 'bar']));
    }

    public function testInfo()
    {
        $this->connection->getTopic(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'name' => 'projects/project-name/topics/topic-name'
            ])->shouldBeCalledTimes(1);

        $this->topic->setConnection($this->connection->reveal());

        $res = $this->topic->info(['foo' => 'bar']);
        $res2 = $this->topic->info();

        $this->assertEquals($res, $res2);
        $this->assertEquals($res['name'], 'projects/project-name/topics/topic-name');
    }

    public function testReload()
    {
        $this->connection->getTopic(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'name' => 'projects/project-name/topics/topic-name'
            ]);

        $this->topic->setConnection($this->connection->reveal());

        $res = $this->topic->reload(['foo' => 'bar']);

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

        $this->topic->setConnection($this->connection->reveal());

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

        $this->connection->publishMessage(Argument::that(function ($options) use ($messages) {
            if ($options['foo'] !== 'bar') return false;

            $messages[0]['data'] = base64_encode($messages[0]['data']);
            $messages[1]['data'] = base64_encode($messages[1]['data']);
            if ($options['messages'] !== $messages) return false;

            return true;
        }))->willReturn($ids);

        $this->topic->setConnection($this->connection->reveal());

        $res = $this->topic->publishBatch($messages, ['foo' => 'bar']);

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

        $this->topic->setConnection($this->connection->reveal());

        $res = $this->topic->publishBatch([$message], ['foo' => 'bar', 'encode' => false]);
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

        $this->topic->setConnection($this->connection->reveal());

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
            'topic' => 'projects/project-name/topics/topic-name'
        ];

        $this->connection->createSubscription(Argument::withEntry('foo', 'bar'))
            ->willReturn($subscriptionData)
            ->shouldBeCalledTimes(1);

        $this->topic->setConnection($this->connection->reveal());

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

        $this->connection->listSubscriptionsByTopic(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'subscriptions' => $subscriptionResult
            ])->shouldBeCalledTimes(1);

        $this->topic->setConnection($this->connection->reveal());

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

        $this->connection->listSubscriptionsByTopic(Argument::that(function ($options) {
            if ($options['foo'] !== 'bar') return false;
            if (isset($options['pageToken']) && $options['pageToken'] !== 'foo') {
                return false;
            }

            return true;
        }))->willReturn([
            'subscriptions' => $subscriptionResult,
            'nextPageToken' => 'foo'
        ])->shouldBeCalledTimes(2);

        $this->topic->setConnection($this->connection->reveal());

        $subscriptions = $this->topic->subscriptions([
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

    public function testIam()
    {
        $this->assertInstanceOf(Iam::class, $this->topic->iam());
    }
}

class TopicStub extends Topic
{
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }
}
