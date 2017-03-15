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

use Generator;
use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\Connection\Grpc;
use Google\Cloud\PubSub\Connection\Rest;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;
use Prophecy\Argument;

/**
 * @group pubsub
 */
class PubSubClientTest extends \PHPUnit_Framework_TestCase
{
    private $connection;

    private $client;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);

        $this->client = new PubSubClientStub([
            'projectId' => 'project',
            'transport' => 'rest'
        ]);
    }

    public function testUsesGrpcConnectionByDefault()
    {
        if (!extension_loaded('grpc')) {
            $this->markTestSkipped('Must have the grpc extension installed to run this test.');
        }
        $client = new PubSubClientStub(['projectId' => 'project']);

        $this->assertInstanceOf(Grpc::class, $client->getConnection());
    }

    public function testCreateTopic()
    {
        $topicName = 'test-topic';

        $this->connection->createTopic(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'name' => 'projects/project/topics/'. $topicName
            ]);

        // Set this to zero to make sure we're getting the cached result
        $this->connection->getTopic(Argument::any())->shouldNotBeCalled();

        $this->client->setConnection($this->connection->reveal());

        $topic = $this->client->createTopic($topicName, [
            'foo' => 'bar'
        ]);

        $this->assertInstanceOf(Topic::class, $topic);

        $info = $topic->info();
        $this->assertEquals($info['name'], 'projects/project/topics/'. $topicName);
    }

    public function testTopic()
    {
        $topicName = 'test-topic';

        $this->connection->getTopic(Argument::any())
            ->willReturn([
                'name' => 'projects/project/topics/'. $topicName
            ])->shouldBeCalledTimes(1);

        $this->client->setConnection($this->connection->reveal());

        $topic = $this->client->topic($topicName);

        $this->assertInstanceOf(Topic::class, $topic);

        $info = $topic->info();
        $this->assertEquals($info['name'], 'projects/project/topics/'. $topicName);
    }

    public function testTopics()
    {
        $topicResult = [
            [
                'name' => 'projects/project/topics/topic-a'
            ], [
                'name' => 'projects/project/topics/topic-b'
            ], [
                'name' => 'projects/project/topics/topic-c'
            ]
        ];

        $this->connection->listTopics(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'topics' => $topicResult
            ])->shouldBeCalledTimes(1);

        $this->client->setConnection($this->connection->reveal());

        $topics = $this->client->topics([
            'foo' => 'bar'
        ]);

        $this->assertInstanceOf(Generator::class, $topics);

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
                'name' => 'projects/project/topics/topic-a'
            ], [
                'name' => 'projects/project/topics/topic-b'
            ], [
                'name' => 'projects/project/topics/topic-c'
            ]
        ];

        $this->connection->listTopics(Argument::that(function ($options) {
            if ($options['foo'] !== 'bar') return false;
            if ($options['pageToken'] !== 'foo' && !is_null($options['pageToken'])) return false;

            return true;
        }))->willReturn([
            'topics' => $topicResult,
            'nextPageToken' => 'foo'
        ])->shouldBeCalledTimes(2);

        $this->client->setConnection($this->connection->reveal());

        $topics = $this->client->topics([
            'foo' => 'bar'
        ]);

        // enumerate the iterator and kill after it loops twice.
        $arr = [];
        $i = 0;
        foreach ($topics as $topic) {
            $i++;
            $arr[] = $topic;
            if ($i == 6) break;
        }

        $this->assertEquals(6, count($arr));
    }

    public function testSubscribe()
    {
        $this->connection->createSubscription(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'test' => 'value'
            ])->shouldBeCalledTimes(1);

        $this->connection->getSubscription()->shouldNotBeCalled();

        $this->client->setConnection($this->connection->reveal());

        $subscription = $this->client->subscribe('subscription', 'topic', [
            'foo' => 'bar'
        ]);

        $this->assertInstanceOf(Subscription::class, $subscription);
        $this->assertEquals('value', $subscription->info()['test']);
    }

    public function testSubscription()
    {
        $this->connection->getSubscription(Argument::any())->shouldBeCalledTimes(1)->willReturn(['foo' => 'bar']);

        $this->client->setConnection($this->connection->reveal());

        $subscription = $this->client->subscription('subscription-name', 'topic-name');

        $info = $subscription->info();

        $this->assertInstanceOf(Subscription::class, $subscription);

        $this->assertEquals('bar', $info['foo']);
    }

    public function testSubscriptions()
    {
        $subscriptionResult = [
            [
                'name' => 'projects/project/subscriptions/subscription-a',
                'topic' => 'projects/project/topics/topic-a'
            ], [
                'name' => 'projects/project/subscriptions/subscription-b',
                'topic' => 'projects/project/topics/topic-a'
            ], [
                'name' => 'projects/project/subscriptions/subscription-c',
                'topic' => 'projects/project/topics/topic-a'
            ]
        ];

        $this->connection->listSubscriptions(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'subscriptions' => $subscriptionResult
            ])->shouldBeCalledTimes(1);

        $this->client->setConnection($this->connection->reveal());

        $subscriptions = $this->client->subscriptions([
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
                'name' => 'projects/project/subscriptions/subscription-a',
                'topic' => 'projects/project/topics/topic-a'
            ], [
                'name' => 'projects/project/subscriptions/subscription-b',
                'topic' => 'projects/project/topics/topic-a'
            ], [
                'name' => 'projects/project/subscriptions/subscription-c',
                'topic' => 'projects/project/topics/topic-a'
            ]
        ];

        $this->connection->listSubscriptions(Argument::that(function ($options) {
            if ($options['foo'] !== 'bar') return false;
            if ($options['pageToken'] !== 'foo' && !is_null($options['pageToken'])) return false;

            return true;
        }))->willReturn([
            'subscriptions' => $subscriptionResult,
            'nextPageToken' => 'foo'
        ])->shouldBeCalledTimes(2);

        $this->client->setConnection($this->connection->reveal());

        $subscriptions = $this->client->subscriptions([
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

class PubSubClientStub extends PubSubClient
{
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
