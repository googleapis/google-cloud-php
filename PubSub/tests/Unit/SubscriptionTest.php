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

use Google\Cloud\Core\Duration;
use Google\Cloud\Core\Exception\BadRequestException;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\Message;
use Google\Cloud\PubSub\Snapshot;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group pubsub
 * @group pubsub-subscription
 */
class SubscriptionTest extends TestCase
{
    use ExpectException;

    const PROJECT = 'project-id';
    const SUBSCRIPTION = 'projects/project-id/subscriptions/subscription-name';
    const TOPIC = 'projects/project-id/topics/topic-name';

    private $subscription;
    private $connection;

    public function set_up()
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

    public function testDetached()
    {
        $this->connection->getSubscription(Argument::withEntry(
            'subscription',
            self::SUBSCRIPTION
        ))->willReturn([
            'detached' => true
        ]);

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $this->assertTrue($this->subscription->detached());
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

        $sub = $this->subscription->create(['foo' => 'bar']);

        $this->assertEquals($sub['name'], self::SUBSCRIPTION);
        $this->assertEquals($sub['topic'], self::TOPIC);
    }

    public function testCreateWithoutTopicName()
    {
        $this->expectException('InvalidArgumentException');

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
        $this->connection->updateSubscription(Argument::allOf(
            Argument::withEntry('subscription', [
                'name' => $this->subscription->name(),
                'foo' => 'bar'
            ]),
            Argument::withEntry('updateMask', 'foo')
        ))->shouldBeCalled()->willReturn([
            'foo' => 'bar'
        ]);

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $res = $this->subscription->update(['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], $res);
        $this->assertEquals('bar', $this->subscription->info()['foo']);
    }

    public function testDurations()
    {
        $this->connection->updateSubscription(Argument::allOf(
            Argument::withEntry('subscription', [
                'name' => $this->subscription->name(),
                'messageRetentionDuration' => '1.1s',
                'expirationPolicy' => [
                    'ttl' => '2.1s'
                ],
                'retryPolicy' => [
                    'minimumBackoff' => '3.1s',
                    'maximumBackoff' => '4.1s'
                ]
            ])
        ))->shouldBeCalled()->willReturn([
            'foo' => 'bar'
        ]);

        $this->connection->createSubscription(Argument::allOf(
            Argument::withEntry('messageRetentionDuration', '1.1s'),
            Argument::withEntry('expirationPolicy', [
                'ttl' => '2.1s'
            ]),
            Argument::withEntry('retryPolicy', [
                'minimumBackoff' => '3.1s',
                'maximumBackoff' => '4.1s'
            ])
        ))->shouldBeCalled()->willReturn([
            'foo' => 'bar'
        ]);

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $args = [
            'messageRetentionDuration' => new Duration(1, 1e+9),
            'expirationPolicy' => [
                'ttl' => new Duration(2, 1e+9)
            ],
            'retryPolicy' => [
                'minimumBackoff' => new Duration(3, 1e+9),
                'maximumBackoff' => new Duration(4, 1e+9),
            ]
        ];

        $this->subscription->update($args);
        $this->subscription->create($args);
    }

    public function testDeadLetterPolicyTopicNames()
    {
        $mock = $this->prophesize(Topic::class);
        $mock->name()->willReturn(self::TOPIC);
        $topic = $mock->reveal();

        $this->connection->updateSubscription(
            Argument::withEntry('subscription', Argument::withEntry('deadLetterPolicy', [
                'deadLetterTopic' => $topic->name()
            ]))
        )->shouldBeCalledTimes(2)->willReturn([
            'foo' => 'bar'
        ]);

        $this->connection->createSubscription(Argument::withEntry('deadLetterPolicy', [
            'deadLetterTopic' => $topic->name()
        ]))->shouldBeCalledTimes(2)->willReturn([
            'foo' => 'bar'
        ]);

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $this->subscription->create([
            'deadLetterPolicy' => [
                'deadLetterTopic' => $topic
            ]
        ]);

        $this->subscription->create([
            'deadLetterPolicy' => [
                'deadLetterTopic' => $topic->name()
            ]
        ]);

        $this->subscription->update([
            'deadLetterPolicy' => [
                'deadLetterTopic' => $topic
            ]
        ]);

        $this->subscription->update([
            'deadLetterPolicy' => [
                'deadLetterTopic' => $topic->name()
            ]
        ]);
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
                    'message' => [],
                    'ackId' => 'foo',
                    'deliveryAttempt' => 4
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

        $this->assertEquals('foo', $result[0]->ackId());
        $this->assertEquals(4, $result[0]->deliveryAttempt());
    }

    public function testPullNoDeliveryAttempt()
    {
        $messages = [
            'receivedMessages' => [
                [
                    'message' => [],
                    'ackId' => 'foo',
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

        $this->assertEquals('foo', $result[0]->ackId());
        $this->assertEquals(0, $result[0]->deliveryAttempt());
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
     * The method acknowledgBatch should suppress any exception if it is
     * with a reason with EOD.
     */
    public function testAcknowledgeBatchSuppressExceptionsForEod()
    {
        $ackIds = [
            'foobar',
            'otherAckId'
        ];

        $messages = [];
        foreach ($ackIds as $id) {
            $messages[] = new Message([], ['ackId' => $id]);
        }
        
        // The JSON exception msg for a failure in a sub with EOD enabled
        $exMsg = '{"error":{"code":400,"message":"...","status":"INVALID_ARGUMENT","details":[{"@type":"type.googleapis.com/google.rpc.ErrorInfo","reason":"EXACTLY_ONCE_ACKID_FAILURE","domain":"pubsub.googleapis.com","metadata":{"foobar":"PERMANENT_FAILURE_INVALID_ACK_ID","otherAckId":"PERMANENT_FAILURE_INVALID_ACK_ID"}},{"@type":"type.googleapis.com/google.rpc.DebugInfo","detail":"..."}]}}';//phpcs:ignore

        $this->connection->acknowledge(Argument::allOf(
            Argument::withEntry('ackIds', $ackIds)
        ))->willThrow(new BadRequestException($exMsg));

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        try {
            $this->subscription->acknowledgeBatch($messages);
            $this->assertTrue(true);
        } catch (BadRequestException $e) {
            // if there was an exception, then our test failed
            $this->fail();
        }
    }

    /**
     * The method acknowledgBatch should bubble up any exceptions
     * if the reason isn't EOD related.
     */
    public function testAcknowledgeBatchThrowsForNonEod()
    {
        $ackIds = [
            'foobar',
            'otherAckId'
        ];

        $messages = [];
        foreach ($ackIds as $id) {
            $messages[] = new Message([], ['ackId' => $id]);
        }
        
        // If an exception has a reason different than 'EXACTLY_ONCE_ACKID_FAILURE'
        // in it's exception msg, then it should bubble up
        $exMsg = '{"error":{"code":400,"message":"...","status":"INVALID_ARGUMENT","details":[{"@type":"type.googleapis.com/google.rpc.ErrorInfo","reason":"FAILURE_REASON","domain":"pubsub.googleapis.com","metadata":{"foobar":"PERMANENT_FAILURE_INVALID_ACK_ID","otherAckId":"PERMANENT_FAILURE_INVALID_ACK_ID"}},{"@type":"type.googleapis.com/google.rpc.DebugInfo","detail":"..."}]}}';//phpcs:ignore

        $this->connection->acknowledge(Argument::allOf(
            Argument::withEntry('ackIds', $ackIds)
        ))->willThrow(new BadRequestException($exMsg));

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        try {
            $this->subscription->acknowledgeBatch($messages);
            $this->fail();
        } catch (BadRequestException $e) {
            // we expect the exception so, our test passes
            $this->assertTrue(true);
        }
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAcknowledgeBatchInvalidArgument()
    {
        $this->expectException('InvalidArgumentException');

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
     * The method modifyAckDeadlineBatch should suppress any exception if it is
     * with a reason with EOD.
     */
    public function testmodifyAckDeadlineBatchSuppressesExceptionsForEod()
    {
        $ackIds = [
            'foobar',
            'otherAckId'
        ];
        $seconds = 10;
        $messages = [];

        foreach ($ackIds as $id) {
            $messages[] = new Message([], ['ackId' => $id]);
        }
        
        // The JSON exception msg for a failure in a sub with EOD enabled
        $exMsg = '{"error":{"code":400,"message":"...","status":"INVALID_ARGUMENT","details":[{"@type":"type.googleapis.com/google.rpc.ErrorInfo","reason":"EXACTLY_ONCE_ACKID_FAILURE","domain":"pubsub.googleapis.com","metadata":{"foobar":"PERMANENT_FAILURE_INVALID_ACK_ID","otherAckId":"PERMANENT_FAILURE_INVALID_ACK_ID"}},{"@type":"type.googleapis.com/google.rpc.DebugInfo","detail":"..."}]}}';//phpcs:ignore


        $this->connection->modifyAckDeadline(Argument::allOf(
            Argument::withEntry('ackIds', $ackIds),
            Argument::withEntry('ackDeadlineSeconds', $seconds)
        ))->willThrow(new BadRequestException($exMsg));

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        try {
            $this->subscription->modifyAckDeadlineBatch($messages, $seconds);
            $this->assertTrue(true);
        } catch (BadRequestException $e) {
            // if there was an exception, then our test failed
            $this->fail();
        }
    }

    /**
     * The method modifyAckDeadlineBatch should bubble up any exceptions
     * if the reason isn't EOD related.
     */
    public function testmodifyAckDeadlineBatchThrowsForNonEod()
    {
        $ackIds = [
            'foobar',
            'otherAckId'
        ];
        $seconds = 10;
        $messages = [];
        
        foreach ($ackIds as $id) {
            $messages[] = new Message([], ['ackId' => $id]);
        }
        
        // If an exception has a reason different than 'EXACTLY_ONCE_ACKID_FAILURE'
        // in it's exception msg, then it should bubble up
        $exMsg = '{"error":{"code":400,"message":"...","status":"INVALID_ARGUMENT","details":[{"@type":"type.googleapis.com/google.rpc.ErrorInfo","reason":"FAILURE_REASON","domain":"pubsub.googleapis.com","metadata":{"foobar":"PERMANENT_FAILURE_INVALID_ACK_ID","otherAckId":"PERMANENT_FAILURE_INVALID_ACK_ID"}},{"@type":"type.googleapis.com/google.rpc.DebugInfo","detail":"..."}]}}';//phpcs:ignore

        $this->connection->modifyAckDeadline(Argument::allOf(
            Argument::withEntry('ackIds', $ackIds),
            Argument::withEntry('ackDeadlineSeconds', $seconds)
        ))->willThrow(new BadRequestException($exMsg));

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        try {
            $this->subscription->modifyAckDeadlineBatch($messages, $seconds);
            $this->fail();
        } catch (BadRequestException $e) {
            // we expect the exception so, our test passes
            $this->assertTrue(true);
        }
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testModifyAckDeadlineBatchInvalidArgument()
    {
        $this->expectException('InvalidArgumentException');

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

    public function testDetach()
    {
        $this->connection->detachSubscription(Argument::withEntry(
            'subscription',
            self::SUBSCRIPTION
        ))->shouldBeCalled()->willReturn([]);

        $this->subscription->___setProperty('connection', $this->connection->reveal());

        $this->assertEquals([], $this->subscription->detach());
    }
}
