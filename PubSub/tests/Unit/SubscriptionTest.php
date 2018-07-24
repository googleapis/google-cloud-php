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

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\Message;
use Google\Cloud\PubSub\Snapshot;
use Google\Cloud\PubSub\Subscription;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group pubsub
 */
class SubscriptionTest extends TestCase
{
    const PROJECT = 'project-id';
    const SUBSCRIPTION = 'projects/project-id/subscriptions/subscription-name';
    const TOPIC = 'projects/project-id/topics/topic-name';

    private $subscription;
    private $connection;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->subscription = TestHelpers::stub(Subscription::class, [
            $this->connection->reveal(),
            'project-id',
            'subscription-name',
            'topic-name',
            true
        ], ['connection', 'info']);
    }

    public function testName()
    {
        $this->assertEquals($this->subscription->name(), self::SUBSCRIPTION);
    }

    public function testCreate()
    {
        $this->connection->createSubscription(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'name' => self::SUBSCRIPTION,
                'topic' => self::TOPIC
            ])->shouldBeCalledTimes(1);

        $this->connection->getSubscription()->shouldNotBeCalled();

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $sub = $this->subscription->create([ 'foo' => 'bar' ]);

        $this->assertEquals($sub['name'], self::SUBSCRIPTION);
        $this->assertEquals($sub['topic'], self::TOPIC);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCreateWithoutTopicName()
    {
        $subscription = new Subscription(
            $this->connection->reveal(),
            'project-id',
            'subscription-name',
            null,
            true
        );

        $sub = $subscription->create();
    }

    public function testUpdate()
    {
        $args = [
            'foo' => 'bar'
        ];

        $argsWithName = $args + [
            'name' => $this->subscription->name()
        ];

        $this->connection->updateSubscription($argsWithName)
            ->shouldBeCalled()
            ->willReturn($argsWithName);

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $res = $this->subscription->update($args);

        $this->assertEquals($res, $argsWithName);
        $this->assertEquals($this->subscription->info(), $argsWithName);
    }

    public function testDelete()
    {
        $this->connection->deleteSubscription(Argument::withEntry('foo', 'bar'))
            ->willReturn(null)
            ->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $res = $this->subscription->delete([ 'foo' => 'bar' ]);

        $this->assertNull($res);
    }

    public function testExists()
    {
        $this->connection->getSubscription(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'subscription' => self::SUBSCRIPTION,
                'topic' => self::TOPIC
            ])->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $this->assertTrue($this->subscription->exists([ 'foo' => 'bar' ]));
    }

    public function testExistsNotFound()
    {
        $this->connection->getSubscription(Argument::any())
            ->willThrow(new NotFoundException('bad'))
            ->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $this->assertFalse($this->subscription->exists());
    }

    public function testInfo()
    {
        $sub = [
            'subscription' => self::SUBSCRIPTION,
            'topic' => self::TOPIC
        ];

        $this->connection->getSubscription(Argument::withEntry('foo', 'bar'))
            ->willReturn($sub)
            ->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $res = $this->subscription->info([ 'foo' => 'bar' ]);
        $this->assertEquals($res, $sub);
    }

    public function testInfoNoRequest()
    {
        $sub = [
            'subscription' => self::SUBSCRIPTION,
            'topic' => self::TOPIC
        ];

        $this->connection->getSubscription()->shouldNotBeCalled();

        $this->subscription->___setProperty('info', $sub);
        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $res = $this->subscription->info();
        $this->assertEquals($res, $sub);
    }

    public function testReload()
    {
        $sub = [
            'subscription' => self::SUBSCRIPTION,
            'topic' => self::TOPIC
        ];

        $this->connection->getSubscription(Argument::withEntry('foo', 'bar'))
            ->willReturn($sub)
            ->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $res = $this->subscription->reload([ 'foo' => 'bar' ]);
        $this->assertEquals($res, $sub);
    }

    public function testPull()
    {
        $messages = [
            'receivedMessages' => [
                [
                    'message' => []
                ], [
                    'message' => []
                ]
            ]
        ];

        $this->connection->pull(Argument::withEntry('foo', 'bar'))
            ->willReturn($messages)
            ->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $result = $this->subscription->pull([
            'foo' => 'bar'
        ]);

        $this->assertContainsOnlyInstancesOf(Message::class, $result);
        $this->assertInstanceOf(Message::class, $result[0]);
        $this->assertInstanceOf(Message::class, $result[1]);
    }

    public function testPullWithCustomArgs()
    {
        $messages = [
            'receivedMessages' => [
                [
                    'message' => []
                ], [
                    'message' => []
                ]
            ]
        ];

        $this->connection->pull(Argument::allOf(
            Argument::withEntry('foo', 'bar'),
            Argument::withEntry('returnImmediately', true),
            Argument::withEntry('maxMessages', 2)
        ))->willReturn($messages)->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $result = $this->subscription->pull([
            'foo' => 'bar',
            'returnImmediately' => true,
            'maxMessages' => 2
        ]);

        $this->assertContainsOnlyInstancesOf(Message::class, $result);
        $this->assertInstanceOf(Message::class, $result[0]);
        $this->assertInstanceOf(Message::class, $result[1]);
    }

    public function testAcknowledge()
    {
        $ackId = 'foobar';

        $this->connection->acknowledge(Argument::allOf(
            Argument::withEntry('foo', 'bar'),
            Argument::withEntry('ackIds', [$ackId])
        ))->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $message = new Message([], ['ackId' => $ackId]);
        $this->subscription->acknowledge($message, ['foo' => 'bar']);
    }

    public function testAcknowledgeBatch()
    {
        $ackIds = [
            'foobar',
            'otherAckId'
        ];

        $messages = [];
        foreach ($ackIds as $id) {
            $messages[] = new Message([], ['ackId' => $id]);
        }

        $this->connection->acknowledge(Argument::allOf(
            Argument::withEntry('foo', 'bar'),
            Argument::withEntry('ackIds', $ackIds)
        ))->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $this->subscription->acknowledgeBatch($messages, ['foo' => 'bar']);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAcknowledgeBatchInvalidArgument()
    {
        $this->subscription->acknowledgeBatch(['foo']);
    }

    public function testModifyAckDeadline()
    {
        $ackId = 'foobar';
        $message = new Message([], ['ackId' => $ackId]);
        $seconds = 100;

        $this->connection->modifyAckDeadline(Argument::allOf(
            Argument::withEntry('foo', 'bar'),
            Argument::withEntry('ackIds', [$ackId]),
            Argument::withEntry('ackDeadlineSeconds', $seconds)
        ))->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $this->subscription->modifyAckDeadline($message, $seconds, ['foo' => 'bar']);
    }

    public function testModifyAckDeadlineBatch()
    {
        $ackIds = [
            'foobar',
            'otherAckId'
        ];

        $messages = [];
        foreach ($ackIds as $id) {
            $messages[] = new Message([], ['ackId' => $id]);
        }

        $seconds = 100;

        $this->connection->modifyAckDeadline(Argument::allOf(
            Argument::withEntry('foo', 'bar'),
            Argument::withEntry('ackIds', $ackIds),
            Argument::withEntry('ackDeadlineSeconds', $seconds)
        ))->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $this->subscription->modifyAckDeadlineBatch($messages, $seconds, ['foo' => 'bar']);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testModifyAckDeadlineBatchInvalidArgument()
    {
        $this->subscription->modifyAckDeadlineBatch(['foo'], 100);
    }

    public function testModifyPushConfig()
    {
        $config = [
            'hello' => 'world'
        ];

        $this->connection->modifyPushConfig(Argument::allOf(
            Argument::withEntry('foo', 'bar'),
            Argument::withEntry('pushConfig', $config)
        ))->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $this->subscription->modifyPushConfig($config, ['foo' => 'bar']);
    }

    public function testSeekToTime()
    {
        $dt = new \DateTime;
        $timestamp = new Timestamp($dt);

        $this->connection->seek([
            'subscription' => $this->subscription->name(),
            'time' => $timestamp->formatAsString()
        ])->shouldBeCalled()->willReturn('foo');

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $res = $this->subscription->seekToTime($timestamp);
        $this->assertEquals('foo', $res);
    }

    public function testSeekToSnapshot()
    {
        $stub = $this->prophesize(Snapshot::class);
        $stub->name()->willReturn('foo');

        $snapshot = $stub->reveal();

        $this->connection->seek([
            'subscription' => $this->subscription->name(),
            'snapshot' => $snapshot->name()
        ])->shouldBeCalled()->willReturn('foo');

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $res = $this->subscription->seekToSnapshot($snapshot);
        $this->assertEquals('foo', $res);
    }

    public function testIam()
    {
        $this->assertInstanceOf(Iam::class, $this->subscription->iam());
    }
}
