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
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\Message;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Subscription;
use Prophecy\Argument;

/**
 * @group pubsub
 */
class SubscriptionTest extends SnippetTestCase
{
    const TOPIC = 'projects/my-awesome-project/topics/my-new-topic';
    const SUBSCRIPTION = 'projects/my-awesome-project/subscriptions/my-new-subscription';

    private $connection;
    private $subscription;
    private $pubsub;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->subscription = \Google\Cloud\Dev\stub(Subscription::class, [
            $this->connection->reveal(),
            'foo',
            self::SUBSCRIPTION,
            self::TOPIC,
            false
        ]);

        $this->pubsub = \Google\Cloud\Dev\stub(PubSubClient::class, [['transport' => 'rest']]);
        $this->pubsub->___setProperty('connection', $this->connection->reveal());
    }

    public function testClassThroughTopic()
    {
        $snippet = $this->snippetFromClass(Subscription::class);
        $res = $snippet->invoke('subscription');

        $this->assertInstanceOf(Subscription::class, $res->returnVal());
        $this->assertEquals(self::SUBSCRIPTION, $res->returnVal()->name());
    }

    public function testClassThroughPubSubClient()
    {
        $snippet = $this->snippetFromClass(Subscription::class, 1);
        $res = $snippet->invoke('subscription');

        $this->assertInstanceOf(Subscription::class, $res->returnVal());
        $this->assertEquals(self::SUBSCRIPTION, $res->returnVal()->name());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(Subscription::class, 'name');
        $snippet->addLocal('subscription', $this->subscription);
        $res = $snippet->invoke();
        $this->assertEquals(self::SUBSCRIPTION, $res->output());
    }

    public function testCreate()
    {
        $snippet = $this->snippetFromMethod(Subscription::class, 'create');
        $snippet->addLocal('pubsub', $this->pubsub);

        $return = ['foo' => 'bar'];
        $this->connection->createSubscription(Argument::any())
            ->shouldBeCalled()
            ->willReturn($return);

        $this->pubsub->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('result');
        $this->assertEquals($return, $res->returnVal());
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(Subscription::class, 'update');
        $snippet->addLocal('subscription', $this->subscription);

        $this->connection->updateSubscription(Argument::any())
            ->shouldBeCalled();

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Subscription::class, 'delete');
        $snippet->addLocal('subscription', $this->subscription);

        $this->connection->deleteSubscription(Argument::any())
            ->shouldBeCalled();

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(Subscription::class, 'exists');
        $snippet->addLocal('subscription', $this->subscription);

        $this->connection->getSubscription(Argument::any())
            ->shouldBeCalled();

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Subscription exists!', $res->output());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(Subscription::class, 'info');
        $snippet->addLocal('subscription', $this->subscription);

        $this->connection->getSubscription(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['name' => self::SUBSCRIPTION]);

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals(self::SUBSCRIPTION, $res->output());
    }

    public function testReload()
    {
        $snippet = $this->snippetFromMethod(Subscription::class, 'reload');
        $snippet->addLocal('subscription', $this->subscription);

        $this->connection->getSubscription(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['name' => self::SUBSCRIPTION]);

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();

        $res = $snippet->invoke();
        $this->assertEquals(self::SUBSCRIPTION, $res->output());
    }

    public function testPull()
    {
        $snippet = $this->snippetFromMethod(Subscription::class, 'pull');
        $snippet->addLocal('subscription', $this->subscription);

        $this->connection->pull(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'receivedMessages' => [
                    ['message' => ['data' => 'hello world']]
                ]
            ]);

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('messages');
        $this->assertContainsOnlyInstancesOf(Message::class, $res->returnVal());
        $this->assertEquals('hello world', $res->output());
    }

    public function testAcknowledge()
    {
        $snippet = $this->snippetFromMethod(Subscription::class, 'acknowledge');
        $snippet->addLocal('subscription', $this->subscription);

        $this->connection->pull(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'receivedMessages' => [
                    ['message' => ['data' => 'hello world']]
                ]
            ]);

        $this->connection->acknowledge(Argument::any())
            ->shouldBeCalled();

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
    }

    public function testAcknowledgeBatch()
    {
        $snippet = $this->snippetFromMethod(Subscription::class, 'acknowledgeBatch');
        $snippet->addLocal('subscription', $this->subscription);

        $this->connection->pull(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'receivedMessages' => [
                    ['message' => ['data' => 'hello world']]
                ]
            ]);

        $this->connection->acknowledge(Argument::any())
            ->shouldBeCalled();

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
    }

    public function testModifyAckDeadline()
    {
        $snippet = $this->snippetFromMethod(Subscription::class, 'modifyAckDeadline');
        $snippet->addLocal('subscription', $this->subscription);

        $this->connection->pull(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'receivedMessages' => [
                    ['message' => ['data' => 'hello world']]
                ]
            ]);

        $this->connection->acknowledge(Argument::any())
            ->shouldBeCalled();

        $this->connection->modifyAckDeadline(Argument::any())
            ->shouldBeCalled();

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
    }

    public function testModifyAckDeadlineBatch()
    {
        $snippet = $this->snippetFromMethod(Subscription::class, 'modifyAckDeadlineBatch');
        $snippet->addLocal('subscription', $this->subscription);

        $this->connection->pull(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'receivedMessages' => [
                    ['message' => ['data' => 'hello world']]
                ]
            ]);

        $this->connection->acknowledge(Argument::any())
            ->shouldBeCalled();

        $this->connection->modifyAckDeadline(Argument::any())
            ->shouldBeCalled();

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
    }

    public function testModifyPushConfig()
    {
        $snippet = $this->snippetFromMethod(Subscription::class, 'modifyPushConfig');
        $snippet->addLocal('subscription', $this->subscription);

        $this->connection->modifyPushConfig(Argument::any())
            ->shouldBeCalled();

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
    }

    public function testSeekToTime()
    {
        $snippet = $this->snippetFromMethod(Subscription::class, 'seekToTime');
        $snippet->addLocal('pubsub', $this->pubsub);
        $snippet->addLocal('subscription', $this->subscription);

        $this->connection->seek(Argument::any())
            ->shouldBeCalled();

        $this->subscription->___setProperty('connection', $this->connection->reveal());
        $snippet->invoke();
    }

    public function testSeekToSnapshot()
    {
        $snippet = $this->snippetFromMethod(Subscription::class, 'seekToSnapshot');
        $snippet->addLocal('pubsub', $this->pubsub);
        $snippet->addLocal('subscription', $this->subscription);

        $this->connection->seek(Argument::any())
            ->shouldBeCalled();

        $this->subscription->___setProperty('connection', $this->connection->reveal());
        $snippet->invoke();
    }

    public function testIam()
    {
        $snippet = $this->snippetFromMethod(Subscription::class, 'iam');
        $snippet->addLocal('subscription', $this->subscription);

        $this->assertInstanceof(Iam::class, $snippet->invoke('iam')->returnVal());
    }
}
