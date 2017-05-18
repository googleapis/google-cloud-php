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

namespace Google\Cloud\Tests\Snippets\PubSub;

use Google\Cloud\Core\Duration;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Dev\SetStubConnectionTrait;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\Message;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Snapshot;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;
use Prophecy\Argument;

/**
 * @group pubsub
 */
class PubSubClientTest extends SnippetTestCase
{
    const TOPIC = 'projects/my-awesome-project/topics/my-new-topic';
    const SUBSCRIPTION = 'projects/my-awesome-project/subscriptions/my-new-subscription';
    const SNAPSHOT = 'projects/my-awesome-project/snapshots/my-snapshot';

    private $connection;
    private $client;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = \Google\Cloud\Dev\stub(PubSubClient::class, [['transport' => 'rest']]);
    }

    public function testClassExample()
    {
        $snippet = $this->snippetFromClass(PubSubClient::class);
        $res = $snippet->invoke('pubsub');

        $this->assertInstanceOf(PubSubClient::class, $res->returnVal());
    }

    // phpunit doesn't get the value of $_ENV, so testing PUBSUB_EMULATOR_HOST is pretty tough.
    public function testClassExample3()
    {
        $snippet = $this->snippetFromClass(PubSubClient::class, 1);
        $res = $snippet->invoke('pubsub');

        $this->assertInstanceOf(PubSubClient::class, $res->returnVal());
    }

    public function testCreateTopic()
    {
        $this->connection->createTopic(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => self::TOPIC
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(PubSubClient::class, 'createTopic');
        $snippet->addLocal('pubsub', $this->client);

        $res = $snippet->invoke('topic');

        $this->assertInstanceOf(Topic::class, $res->returnVal());
        $this->assertEquals(self::TOPIC, $res->returnVal()->name());
        $this->assertEquals(self::TOPIC, $res->output());
    }

    public function testTopic()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'topic');
        $snippet->addLocal('pubsub', $this->client);

        $this->connection->getTopic(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => self::TOPIC
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('topic');

        $this->assertInstanceOf(Topic::class, $res->returnVal());
        $this->assertEquals(self::TOPIC, $res->returnVal()->name());
        $this->assertEquals(self::TOPIC, $res->output());
    }

    public function testTopics()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'topics');
        $snippet->addLocal('pubsub', $this->client);

        $this->connection->listTopics(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'topics' => [
                    ['name' => self::TOPIC]
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('topics');

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertEquals(self::TOPIC, $res->output());
    }

    public function testSubscribe()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'subscribe');
        $snippet->addLocal('pubsub', $this->client);

        $this->connection->createSubscription(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => self::SUBSCRIPTION,
                'topic' => self::TOPIC
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('subscription');

        $this->assertInstanceOf(Subscription::class, $res->returnVal());
        $this->assertEquals(self::SUBSCRIPTION, $res->returnVal()->name());
        $this->assertEquals(self::SUBSCRIPTION, $res->returnVal()->info()['name']);
        $this->assertEquals(self::TOPIC, $res->returnVal()->info()['topic']);
    }

    public function testSubscription()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'subscription');
        $snippet->addLocal('pubsub', $this->client);

        $this->connection->getSubscription(['subscription' => self::SUBSCRIPTION])
            ->shouldBeCalled()
            ->willReturn([
                'name' => self::SUBSCRIPTION,
                'topic' => self::TOPIC
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('subscription');

        $this->assertInstanceOf(Subscription::class, $res->returnVal());
        $this->assertEquals(self::SUBSCRIPTION, $res->returnVal()->name());
        $this->assertEquals(self::SUBSCRIPTION, $res->returnVal()->info()['name']);
        $this->assertEquals(self::TOPIC, $res->returnVal()->info()['topic']);
    }

    public function testSubscriptions()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'subscriptions');
        $snippet->addLocal('pubsub', $this->client);

        $this->connection->listSubscriptions(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'subscriptions' => [
                    ['name' => self::SUBSCRIPTION, 'topic' => self::TOPIC]
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('subscriptions');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertEquals(self::SUBSCRIPTION, $res->output());
    }

    public function testCreateSnapshot()
    {
        $this->connection->createSnapshot(Argument::any())
            ->shouldBecalled()
            ->willReturn([]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(PubSubClient::class, 'createSnapshot');
        $snippet->addLocal('pubsub', $this->client);
        $snippet->addLocal('subscriptionName', self::SUBSCRIPTION);

        $res = $snippet->invoke('snapshot');
        $this->assertInstanceOf(Snapshot::class, $res->returnVal());
    }

    public function testSnapshot()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'snapshot');
        $snippet->addLocal('pubsub', $this->client);

        $res = $snippet->invoke('snapshot');
        $this->assertInstanceOf(Snapshot::class, $res->returnVal());
    }

    public function testSnapshots()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'snapshots');
        $snippet->addLocal('pubsub', $this->client);

        $this->connection->listSnapshots(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'snapshots' => [
                    ['name' => self::SNAPSHOT]
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('snapshots');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertEquals(self::SNAPSHOT, $res->output());
    }

    public function testConsume()
    {
        $message = [
            "message" => [
                "attributes" => [],
                "data" => base64_encode('content'),
                "message_id" => "message-id",
                "publish_time" => (new \DateTime)->format('c'),
            ],
            "subscription" => self::SUBSCRIPTION
        ];

        $snippet = $this->snippetFromMethod(PubSubClient::class, 'consume');
        $snippet->addLocal('pubsub', $this->client);
        $snippet->setLine(0, '$httpPostRequestBody = \''. json_encode($message) .'\';');

        $res = $snippet->invoke('message');
        $this->assertInstanceOf(Message::class, $res->returnVal());
    }

    public function testTimestamp()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'timestamp');
        $snippet->addLocal('pubsub', $this->client);
        $res = $snippet->invoke('timestamp');
        $this->assertInstanceOf(Timestamp::class, $res->returnVal());
    }

    public function testDuration()
    {
        $snippet = $this->snippetFromMethod(PubSubClient::class, 'duration');
        $snippet->addLocal('pubsub', $this->client);
        $res = $snippet->invoke('duration');
        $this->assertInstanceOf(Duration::class, $res->returnVal());
    }
}
