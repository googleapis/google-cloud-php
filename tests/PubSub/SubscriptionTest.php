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
use Google\Cloud\Iam\Iam;
use Google\Cloud\PubSub\Subscription;
use Prophecy\Argument;

class SubscriptionTest extends \PHPUnit_Framework_TestCase
{
    private $connection;

    public function setUp()
    {
        $this->connection = $this->prophesize('Google\Cloud\PubSub\Connection\ConnectionInterface');
    }

    public function testCreate()
    {
        $this->connection->createSubscription(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'name' => 'projects/project-id/subscriptions/subscription-name',
                'topic' => 'projects/project-id/topics/topic-name'
            ])->shouldBeCalledTimes(1);

        $this->connection->getSubscription()->shouldNotBeCalled();

        $subscription = new Subscription(
            $this->connection->reveal(),
            'subscription-name',
            'topic-name',
            'project-id'
        );

        $sub = $subscription->create([ 'foo' => 'bar' ]);

        $this->assertEquals($sub['name'], 'projects/project-id/subscriptions/subscription-name');
        $this->assertEquals($sub['topic'], 'projects/project-id/topics/topic-name');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCreateWithoutTopicName()
    {
        $subscription = new Subscription(
            $this->connection->reveal(),
            'subscription-name',
            null,
            'project-id'
        );

        $sub = $subscription->create();
    }

    public function testDelete()
    {
        $this->connection->deleteSubscription(Argument::withEntry('foo', 'bar'))
            ->willReturn(null)
            ->shouldBeCalledTimes(1);

        $subscription = new Subscription(
            $this->connection->reveal(),
            'subscription-name',
            'topic-name',
            'project-id'
        );

        $res = $subscription->delete([ 'foo' => 'bar' ]);

        $this->assertNull($res);
    }

    public function testExists()
    {
        $this->connection->getSubscription(Argument::withEntry('foo', 'bar'))
            ->willReturn([
                'subscription' => 'projects/project-id/subscriptions/subscription-name',
                'topic' => 'projects/project-id/topics/topic-name'
            ])->shouldBeCalledTimes(1);

        $subscription = new Subscription(
            $this->connection->reveal(),
            'subscription-name',
            'topic-name',
            'project-id'
        );

        $this->assertTrue($subscription->exists([ 'foo' => 'bar' ]));
    }

    public function testExistsNotFound()
    {
        $this->connection->getSubscription(Argument::any())
            ->willThrow(new NotFoundException('bad'))
            ->shouldBeCalledTimes(1);

        $subscription = new Subscription(
            $this->connection->reveal(),
            'subscription-name',
            'topic-name',
            'project-id'
        );

        $this->assertFalse($subscription->exists());
    }

    public function testInfo()
    {
        $sub = [
            'subscription' => 'projects/project-id/subscriptions/subscription-name',
            'topic' => 'projects/project-id/topics/topic-name'
        ];

        $this->connection->getSubscription(Argument::withEntry('foo', 'bar'))
            ->willReturn($sub)
            ->shouldBeCalledTimes(1);

        $subscription = new Subscription(
            $this->connection->reveal(),
            'subscription-name',
            'topic-name',
            'project-id'
        );

        $res = $subscription->info([ 'foo' => 'bar' ]);
        $this->assertEquals($res, $sub);
    }

    public function testInfoNoRequest()
    {
        $sub = [
            'subscription' => 'projects/project-id/subscriptions/subscription-name',
            'topic' => 'projects/project-id/topics/topic-name'
        ];

        $this->connection->getSubscription()->shouldNotBeCalled();

        $subscription = new Subscription(
            $this->connection->reveal(),
            'subscription-name',
            'topic-name',
            'project-id',
            $sub
        );

        $res = $subscription->info();
        $this->assertEquals($res, $sub);
    }

    public function testReload()
    {
        $sub = [
            'subscription' => 'projects/project-id/subscriptions/subscription-name',
            'topic' => 'projects/project-id/topics/topic-name'
        ];

        $this->connection->getSubscription(Argument::withEntry('foo', 'bar'))
            ->willReturn($sub)
            ->shouldBeCalledTimes(1);

        $subscription = new Subscription(
            $this->connection->reveal(),
            'subscription-name',
            'topic-name',
            'project-id'
        );

        $res = $subscription->reload([ 'foo' => 'bar' ]);
        $this->assertEquals($res, $sub);
    }

    public function testPull()
    {
        $messages = [
            'receivedMessages' => [
                [
                    'foo' => 'bar'
                ], [
                    'foo' => 'bat'
                ]
            ]
        ];

        $this->connection->pull(Argument::withEntry('foo', 'bar'))
            ->willReturn($messages)
            ->shouldBeCalledTimes(1);

        $subscription = new Subscription(
            $this->connection->reveal(),
            'subscription-name',
            'topic-name',
            'project-id'
        );

        $result = $subscription->pull([
            'foo' => 'bar'
        ]);

        $this->assertInstanceOf(Generator::class, $result);

        $arr = iterator_to_array($result);
        $this->assertEquals($arr[0]['foo'], 'bar');
        $this->assertEquals($arr[1]['foo'], 'bat');
    }

    public function testPullWithCustomArgs()
    {
        $messages = [
            'receivedMessages' => [
                [
                    'foo' => 'bar'
                ], [
                    'foo' => 'bat'
                ]
            ]
        ];

        $this->connection->pull(Argument::that(function ($args) {
                if ($args['foo'] !== 'bar') return false;
                if ($args['returnImmediately'] !== true) return false;
                if ($args['maxMessages'] !== 2) return false;

                return true;
            }))->willReturn($messages)
            ->shouldBeCalledTimes(1);

        $subscription = new Subscription(
            $this->connection->reveal(),
            'subscription-name',
            'topic-name',
            'project-id'
        );

        $result = $subscription->pull([
            'foo' => 'bar',
            'returnImmediately' => true,
            'maxMessages' => 2
        ]);

        $this->assertInstanceOf(Generator::class, $result);

        $arr = iterator_to_array($result);
        $this->assertEquals($arr[0]['foo'], 'bar');
        $this->assertEquals($arr[1]['foo'], 'bat');
    }

    public function testPullPaged()
    {
        $messages = [
            'receivedMessages' => [
                [
                    'foo' => 'bar'
                ], [
                    'foo' => 'bat'
                ]
            ],
            'nextPageToken' => 'foo'
        ];

        $this->connection->pull(Argument::that(function ($args) {
                if ($args['foo'] !== 'bar') return false;
                if ($args['returnImmediately'] !== true) return false;
                if ($args['maxMessages'] !== 2) return false;
                if (!in_array($args['pageToken'], [null, 'foo'])) return false;

                return true;
            }))->willReturn($messages)
            ->shouldBeCalledTimes(3);

        $subscription = new Subscription(
            $this->connection->reveal(),
            'subscription-name',
            'topic-name',
            'project-id'
        );

        $result = $subscription->pull([
            'foo' => 'bar',
            'returnImmediately' => true,
            'maxMessages' => 2
        ]);

        $this->assertInstanceOf(Generator::class, $result);

        // enumerate the iterator and kill after it loops twice.
        $arr = [];
        $i = 0;
        foreach ($result as $message) {
            $i++;
            $arr[] = $message;
            if ($i == 6) break;
        }

        $this->assertEquals(6, count($arr));
    }

    public function testAcknowledge()
    {
        $ackId = 'foobar';

        $this->connection->acknowledge(Argument::that(function ($args) use ($ackId) {
            if ($args['foo'] !== 'bar') return false;
            if ($args['ackIds'] !== [$ackId]) return false;

            return true;
        }))->shouldBeCalledTimes(1);

        $subscription = new Subscription(
            $this->connection->reveal(),
            'subscription-name',
            'topic-name',
            'project-id'
        );

        $subscription->acknowledge($ackId, ['foo' => 'bar']);
    }

    public function testAcknowledgeBatch()
    {
        $ackIds = [
            'foobar',
            'otherAckId'
        ];

        $this->connection->acknowledge(Argument::that(function ($args) use ($ackIds) {
            if ($args['foo'] !== 'bar') return false;
            if ($args['ackIds'] !== $ackIds) return false;

            return true;
        }))->shouldBeCalledTimes(1);

        $subscription = new Subscription(
            $this->connection->reveal(),
            'subscription-name',
            'topic-name',
            'project-id'
        );

        $subscription->acknowledgeBatch($ackIds, ['foo' => 'bar']);
    }

    public function testModifyAckDeadline()
    {
        $ackId = 'foobar';

        $this->connection->modifyAckDeadline(Argument::that(function ($args) use ($ackId) {
            if ($args['foo'] !== 'bar') return false;
            if ($args['ackIds'] !== [$ackId]) return false;

            return true;
        }))->shouldBeCalledTimes(1);

        $subscription = new Subscription(
            $this->connection->reveal(),
            'subscription-name',
            'topic-name',
            'project-id'
        );

        $subscription->modifyAckDeadline($ackId, 100, ['foo' => 'bar']);
    }

    public function testModifyAckDeadlineBatch()
    {
        $ackIds = [
            'foobar',
            'otherAckId'
        ];

        $seconds = 100;

        $this->connection->modifyAckDeadline(Argument::that(function ($args) use ($ackIds, $seconds) {
            if ($args['foo'] !== 'bar') return false;
            if ($args['ackIds'] !== $ackIds) return false;
            if ($args['ackDeadlineSeconds'] !== $seconds) return false;

            return true;
        }))->shouldBeCalledTimes(1);

        $subscription = new Subscription(
            $this->connection->reveal(),
            'subscription-name',
            'topic-name',
            'project-id'
        );

        $subscription->modifyAckDeadlineBatch($ackIds, $seconds, ['foo' => 'bar']);
    }

    public function testModifyPushConfig()
    {
        $config = [
            'hello' => 'world'
        ];

        $this->connection->modifyPushConfig(Argument::that(function ($args) use ($config) {
            if ($args['foo'] !== 'bar') return false;
            if ($args['pushConfig'] !== $config) return false;

            return true;
        }))->shouldBeCalledTimes(1);

        $subscription = new Subscription(
            $this->connection->reveal(),
            'subscription-name',
            'topic-name',
            'project-id'
        );

        $subscription->modifyPushConfig($config, ['foo' => 'bar']);
    }

    public function testIam()
    {
        $subscription = new Subscription(
            $this->connection->reveal(),
            'subscription-name',
            'topic-name',
            'project-id'
        );

        $this->assertInstanceOf(Iam::class, $subscription->iam());
    }
}
