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

use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\BatchPublisher;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;
use Google\Cloud\Core\Iterator\ItemIterator;
use Prophecy\Argument;

/**
 * @group pubsub
 */
class TopicTest extends SnippetTestCase
{
    const TOPIC = 'projects/my-awesome-project/topics/my-new-topic';
    const SUBSCRIPTION = 'projects/my-awesome-project/subscriptions/my-new-subscription';

    private $connection;
    private $pubsub;
    private $topic;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->pubsub = \Google\Cloud\Dev\stub(PubSubClient::class);
        $this->topic = \Google\Cloud\Dev\stub(Topic::class, [
            $this->connection->reveal(),
            'my-awesome-project',
            self::TOPIC,
            false
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Topic::class);
        $snippet->addLocal('pubsub', $this->pubsub);

        $res = $snippet->invoke('topic');
        $this->assertInstanceOf(Topic::class, $res->returnVal());
        $this->assertEquals(self::TOPIC, $res->returnVal()->name());
    }

    public function testClassWithFullyQualifiedName()
    {
        $snippet = $this->snippetFromClass(Topic::class, 1);
        $snippet->addLocal('pubsub', $this->pubsub);

        $res = $snippet->invoke('topic');
        $this->assertInstanceOf(Topic::class, $res->returnVal());
        $this->assertEquals(self::TOPIC, $res->returnVal()->name());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'name');
        $snippet->addLocal('topic', $this->topic);

        $res = $snippet->invoke();
        $this->assertEquals(self::TOPIC, $res->output());
    }

    public function testCreate()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'create');
        $snippet->addLocal('topic', $this->topic);

        $this->connection->createTopic(Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);

        $this->topic->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('topicInfo');
        $this->assertEquals([], $res->returnVal());
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'delete');
        $snippet->addLocal('topic', $this->topic);

        $this->connection->deleteTopic(Argument::any())
            ->shouldBeCalled();

        $this->topic->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'exists');
        $snippet->addLocal('topic', $this->topic);

        $this->connection->getTopic(Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);

        $this->topic->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Topic exists', $res->output());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'info');
        $snippet->addLocal('topic', $this->topic);

        $this->connection->getTopic(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => self::TOPIC
            ]);

        $this->topic->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals(self::TOPIC, $res->output());
    }

    public function testReload()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'reload');
        $snippet->addLocal('topic', $this->topic);

        $this->connection->getTopic(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => self::TOPIC
            ]);

        $this->topic->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals(self::TOPIC, $res->output());
    }

    public function testPublish()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'publish');
        $snippet->addLocal('topic', $this->topic);

        $this->connection->publishMessage(Argument::any())
            ->shouldBeCalled();

        $this->topic->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testPublishBatch()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'publishBatch');
        $snippet->addLocal('topic', $this->topic);

        $this->connection->publishMessage(Argument::any())
            ->shouldBeCalled();

        $this->topic->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testBatchPublisher()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'batchPublisher');
        $batchPublisher = $this->prophesize(BatchPublisher::class);
        $batchPublisher->publish(Argument::type('array'))
            ->willReturn(true);
        $topic = $this->prophesize(Topic::class);
        $topic->batchPublisher()
            ->willReturn($batchPublisher->reveal());
        $snippet->addLocal('topic', $topic->reveal());

        $snippet->invoke();
    }

    public function testSubscribe()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'subscribe');
        $snippet->addLocal('topic', $this->topic);

        $this->connection->createSubscription(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => self::SUBSCRIPTION
            ]);

        $this->topic->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('subscription');
        $this->assertInstanceOf(Subscription::class, $res->returnVal());
    }

    public function testSubscription()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'subscription');
        $snippet->addLocal('topic', $this->topic);

        $res = $snippet->invoke('subscription');
        $this->assertInstanceOf(Subscription::class, $res->returnVal());
    }

    public function testSubscriptions()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'subscriptions');
        $snippet->addLocal('topic', $this->topic);

        $this->connection->listSubscriptionsByTopic(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'subscriptions' => [
                    self::SUBSCRIPTION
                ]
            ]);

        $this->topic->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('subscriptions');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertEquals(self::SUBSCRIPTION, $res->output());
    }

    public function testIam()
    {
        $snippet = $this->snippetFromMethod(Topic::class, 'iam');
        $snippet->addLocal('topic', $this->topic);
        $res = $snippet->invoke('iam');

        $this->assertInstanceOf(Iam::class, $res->returnVal());
    }
}
