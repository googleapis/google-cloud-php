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

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Iam\Iam;
use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;
use Prophecy\Argument;

/**
 * @group pubsub
 */
class TopicTest extends SnippetTestCase
{
    const TOPIC = 'projects/my-awesome-project/topics/my-new-topic';
    const SUBSCRIPTION = 'projects/my-awesome-project/subscriptions/my-new-subscription';

    private $connection;
    private $topic;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->topic = new \TopicStub(
            $this->connection->reveal(),
            'my-awesome-project',
            self::TOPIC,
            false
        );
    }

    public function testClass()
    {
        $snippet = $this->class(Topic::class);
        $snippet->addLocal('pubsub', new \PubSubClientStub);

        $res = $snippet->invoke('topic');
        $this->assertInstanceOf(Topic::class, $res->return());
        $this->assertEquals(self::TOPIC, $res->return()->name());
    }

    public function testClassWithFullyQualifiedName()
    {
        $snippet = $this->class(Topic::class, 1);
        $snippet->addLocal('pubsub', new \PubSubClientStub);

        $res = $snippet->invoke('topic');
        $this->assertInstanceOf(Topic::class, $res->return());
        $this->assertEquals(self::TOPIC, $res->return()->name());
    }

    public function testName()
    {
        $snippet = $this->method(Topic::class, 'name');
        $snippet->addLocal('topic', $this->topic);

        $res = $snippet->invoke();
        $this->assertEquals(self::TOPIC, $res->output());
    }

    public function testCreate()
    {
        $snippet = $this->method(Topic::class, 'create');
        $snippet->addLocal('topic', $this->topic);

        $this->connection->createTopic(Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);

        $this->topic->setConnection($this->connection->reveal());

        $res = $snippet->invoke('topicInfo');
        $this->assertEquals([], $res->return());
    }

    public function testDelete()
    {
        $snippet = $this->method(Topic::class, 'delete');
        $snippet->addLocal('topic', $this->topic);

        $this->connection->deleteTopic(Argument::any())
            ->shouldBeCalled();

        $this->topic->setConnection($this->connection->reveal());

        $snippet->invoke();
    }

    public function testExists()
    {
        $snippet = $this->method(Topic::class, 'exists');
        $snippet->addLocal('topic', $this->topic);

        $this->connection->getTopic(Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);

        $this->topic->setConnection($this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Topic exists', $res->output());
    }

    public function testInfo()
    {
        $snippet = $this->method(Topic::class, 'info');
        $snippet->addLocal('topic', $this->topic);

        $this->connection->getTopic(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => self::TOPIC
            ]);

        $this->topic->setConnection($this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals(self::TOPIC, $res->output());
    }

    public function testReload()
    {
        $snippet = $this->method(Topic::class, 'reload');
        $snippet->addLocal('topic', $this->topic);

        $this->connection->getTopic(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => self::TOPIC
            ]);

        $this->topic->setConnection($this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals(self::TOPIC, $res->output());
    }

    public function testPublish()
    {
        $snippet = $this->method(Topic::class, 'publish');
        $snippet->addLocal('topic', $this->topic);

        $this->connection->publishMessage(Argument::any())
            ->shouldBeCalled();

        $this->topic->setConnection($this->connection->reveal());

        $snippet->invoke();
    }

    public function testPublishBatch()
    {
        $snippet = $this->method(Topic::class, 'publishBatch');
        $snippet->addLocal('topic', $this->topic);

        $this->connection->publishMessage(Argument::any())
            ->shouldBeCalled();

        $this->topic->setConnection($this->connection->reveal());

        $snippet->invoke();
    }

    public function testSubscribe()
    {
        $snippet = $this->method(Topic::class, 'subscribe');
        $snippet->addLocal('topic', $this->topic);

        $this->connection->createSubscription(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => self::SUBSCRIPTION
            ]);

        $this->topic->setConnection($this->connection->reveal());

        $res = $snippet->invoke('subscription');
        $this->assertInstanceOf(Subscription::class, $res->return());
    }

    public function testSubscription()
    {
        $snippet = $this->method(Topic::class, 'subscription');
        $snippet->addLocal('topic', $this->topic);

        $res = $snippet->invoke('subscription');
        $this->assertInstanceOf(Subscription::class, $res->return());
    }

    public function testSubscriptions()
    {
        $snippet = $this->method(Topic::class, 'subscriptions');
        $snippet->addLocal('topic', $this->topic);

        $this->connection->listSubscriptionsByTopic(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'subscriptions' => [
                    self::SUBSCRIPTION
                ]
            ]);

        $this->topic->setConnection($this->connection->reveal());

        $res = $snippet->invoke('subscriptions');
        $this->assertInstanceOf(\Generator::class, $res->return());
        $this->assertEquals(self::SUBSCRIPTION, $res->output());
    }

    public function iam()
    {
        $snippet = $this->method(Topic::class, 'iam');
        $snippet->addLocal('topic', $this->topic);
        $res = $snippet->invoke('iam');

        $this->assertInstanceOf(Iam::class, $res->return());
    }
}
