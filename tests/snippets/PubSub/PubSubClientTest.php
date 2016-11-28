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

use Google\Cloud\Dev\SetStubConnectionTrait;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;
use Prophecy\Argument;

class PubSubClientTest extends SnippetTestCase
{
    const TOPIC = 'projects/foo/topics/my-new-topic';
    const SUBSCRIPTION = 'projects/foo/subscriptions/my-new-subscription';

    private $connection;
    private $client;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = new PubSubClientStub;
    }

    public function testClassExample1()
    {
        $snippet = $this->class(PubSubClient::class, '__construct');
        $res = $snippet->invoke('pubsub');

        $this->assertInstanceOf(PubSubClient::class, $res->return());
    }

    public function testCreateTopic()
    {
        $this->connection->createTopic(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => self::TOPIC
            ]);

        $this->client->setConnection($this->connection->reveal());

        $snippet = $this->method(PubSubClient::class, 'createTopic');
        $snippet->addLocal('pubsub', $this->client);

        $res = $snippet->invoke('topic');

        $this->assertInstanceOf(Topic::class, $res->return());
        $this->assertEquals(self::TOPIC, $res->return()->name());
        $this->assertEquals(self::TOPIC, $res->output());
    }

    public function testTopic()
    {
        $snippet = $this->method(PubSubClient::class, 'topic');
        $snippet->addLocal('pubsub', $this->client);

        $this->connection->getTopic(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => self::TOPIC
            ]);

        $this->client->setConnection($this->connection->reveal());

        $res = $snippet->invoke('topic');

        $this->assertInstanceOf(Topic::class, $res->return());
        $this->assertEquals(self::TOPIC, $res->return()->name());
        $this->assertEquals(self::TOPIC, $res->output());
    }

    public function testTopics()
    {
        $snippet = $this->method(PubSubClient::class, 'topics');
        $snippet->addLocal('pubsub', $this->client);

        $this->connection->listTopics(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'topics' => [
                    ['name' => self::TOPIC]
                ]
            ]);

        $this->client->setConnection($this->connection->reveal());

        $res = $snippet->invoke('topics');

        $this->assertInstanceOf(\Generator::class, $res->return());
        $this->assertEquals(self::TOPIC, $res->output());
    }

    public function testSubscribe()
    {
        $snippet = $this->method(PubSubClient::class, 'subscribe');
        $snippet->addLocal('pubsub', $this->client);

        $this->connection->createSubscription(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => self::SUBSCRIPTION,
                'topic' => self::TOPIC
            ]);

        $this->client->setConnection($this->connection->reveal());

        $res = $snippet->invoke('subscription');

        $this->assertInstanceOf(Subscription::class, $res->return());
        $this->assertEquals(self::SUBSCRIPTION, $res->return()->name());
        $this->assertEquals(self::SUBSCRIPTION, $res->return()->info()['name']);
        $this->assertEquals(self::TOPIC, $res->return()->info()['topic']);
    }

    public function testSubscription()
    {
        $snippet = $this->method(PubSubClient::class, 'subscription');
        $snippet->addLocal('pubsub', $this->client);

        $this->connection->getSubscription(['subscription' => self::SUBSCRIPTION])
            ->shouldBeCalled()
            ->willReturn([
                'name' => self::SUBSCRIPTION,
                'topic' => self::TOPIC
            ]);

        $this->client->setConnection($this->connection->reveal());

        $res = $snippet->invoke('subscription');

        $this->assertInstanceOf(Subscription::class, $res->return());
        $this->assertEquals(self::SUBSCRIPTION, $res->return()->name());
        $this->assertEquals(self::SUBSCRIPTION, $res->return()->info()['name']);
        $this->assertEquals(self::TOPIC, $res->return()->info()['topic']);
    }

    public function testSubscriptions()
    {
        $snippet = $this->method(PubSubClient::class, 'subscriptions');
        $snippet->addLocal('pubsub', $this->client);

        $this->connection->listSubscriptions(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'subscriptions' => [
                    ['name' => self::SUBSCRIPTION, 'topic' => self::TOPIC]
                ]
            ]);

        $this->client->setConnection($this->connection->reveal());

        $res = $snippet->invoke('subscriptions');
        $this->assertInstanceOf(\Generator::class, $res->return());
        $this->assertEquals(self::SUBSCRIPTION, $res->output());
    }
}

class PubSubClientStub extends PubSubClient
{
    use SetStubConnectionTrait;
}
