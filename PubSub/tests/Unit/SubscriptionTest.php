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

use Google\ApiCore\Veneer\Exception\NotFoundException;
use Google\ApiCore\Veneer\RequestHandler;
use Google\Cloud\Core\Duration;
use Google\ApiCore\Veneer\Exception\BadRequestException;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\PubSub\Message;
use Google\Cloud\PubSub\Snapshot;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;
use Google\Cloud\PubSub\V1\PushConfig;
use Google\Cloud\PubSub\V1\Subscription as V1Subscription;
use Google\Protobuf\FieldMask;
use Google\Protobuf\Timestamp as ProtobufTimestamp;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group pubsub
 * @group pubsub-subscription
 */
class SubscriptionTest extends TestCase
{
    use ProphecyTrait;
    use ArgumentHelperTrait;

    const PROJECT = 'project-id';
    const SUBSCRIPTION = 'projects/project-id/subscriptions/subscription-name';
    const TOPIC = 'projects/project-id/topics/topic-name';

    private $subscription;
    private $requestHandler;
    private $ackIds;
    private $messages;

    public function setUp(): void
    {
        $this->requestHandler = $this->prophesize(RequestHandler::class);
        $this->subscription = TestHelpers::stub(Subscription::class, [
            $this->requestHandler->reveal(),
            'project-id',
            'subscription-name',
            'topic-name',
            true
        ], ['requestHandler', 'info']);
        // make sure the ExponentialBackOff retries don't delay for our test.
        Subscription::setMaxEodRetryTime(0);

        $this->ackIds = [
            'foobar',
            'otherAckId'
        ];

        $this->messages = [];
        foreach ($this->ackIds as $id) {
            $this->messages[] = new Message([], ['ackId' => $id]);
        }
    }

    public function testName()
    {
        $this->assertEquals($this->subscription->name(), self::SUBSCRIPTION);
    }

    public function testDetached()
    {
        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('getSubscription'), 2],
                [[self::SUBSCRIPTION], 3]
            ])
        )->willReturn([
            'detached' => true
        ]);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->assertTrue($this->subscription->detached());
    }

    public function testCreate()
    {
        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('createSubscription'), 2],
                [Argument::withEntry('foo', 'bar'), 4]
            ])
        )->willReturn([
            'name' => self::SUBSCRIPTION,
            'topic' => self::TOPIC
        ])->shouldBeCalledTimes(1);

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('getSubscription'), 2]
            ])
        )->shouldNotBeCalled();

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $sub = $this->subscription->create(['foo' => 'bar']);

        $this->assertEquals($sub['name'], self::SUBSCRIPTION);
        $this->assertEquals($sub['topic'], self::TOPIC);
    }

    public function testCreateWithoutTopicName()
    {
        $this->expectException(InvalidArgumentException::class);

        $subscription = new Subscription(
            $this->requestHandler->reveal(),
            'project-id',
            'subscription-name',
            null,
            true
        );

        $sub = $subscription->create();
    }

    public function testUpdate()
    {
        $prop = 'ack_deadline_seconds';
        $val = 5;
        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('updateSubscription'), 2],
                [
                    Argument::that(function($args) use($prop, $val) {
                        $sub = $args[0];
                        $mask = $args[1];

                        $isValid = $sub instanceof V1Subscription && $mask instanceof FieldMask;
                        $isValid = $isValid && $sub->getAckDeadlineSeconds() === $val;
                        $isValid = $isValid && $mask->getPaths()->offsetGet(0) === $prop;
                        return $isValid;
                    }), 3
                ]
            ])
        )->shouldBeCalled()->willReturn([
            $prop => $val
        ]);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->subscription->update([$prop => $val]);

        $this->assertEquals([$prop => $val], $res);
        $this->assertEquals($val, $this->subscription->info()[$prop]);
    }

    public function testDurations()
    {
        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('updateSubscription'), 2]
            ])
        )->shouldBeCalled()->willReturn([
            'name' => 'foo'
        ]);

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('createSubscription'), 2]
            ])
        )->shouldBeCalled()->willReturn([
            'name' => 'bar'
        ]);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

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

        $res = $this->subscription->update($args,[
            'updateMask' => ['messageRetentionDuration','retryPolicy']
        ]);
        $this->assertArrayHasKey('name', $res);
        $this->assertEquals($res['name'], 'foo');
        $res = $this->subscription->create($args);
        $this->assertArrayHasKey('name', $res);
        $this->assertEquals($res['name'], 'bar');
    }

    public function testDeadLetterPolicyTopicNames()
    {
        $mock = $this->prophesize(Topic::class);
        $mock->name()->willReturn(self::TOPIC);
        $topic = $mock->reveal();

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('createSubscription'), 2]
            ])
        )->shouldBeCalledTimes(2)->willReturn([
            'foo' => 'bar'
        ]);

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('updateSubscription'), 2]
            ])
        )->shouldBeCalledTimes(2)->willReturn([
            'foo' => 'bar'
        ]);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

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
        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('deleteSubscription'), 2],
                [Argument::withEntry('foo', 'bar'), 4]
            ])
        )->willReturn(null)
        ->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->subscription->delete([ 'foo' => 'bar' ]);

        $this->assertNull($res);
    }

    public function testExists()
    {
        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('getSubscription'), 2],
                [Argument::withEntry('foo', 'bar'), 4]
            ])
        )->willReturn([
            'subscription' => self::SUBSCRIPTION,
            'topic' => self::TOPIC
        ])->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->assertTrue($this->subscription->exists([ 'foo' => 'bar' ]));
    }

    public function testExistsNotFound()
    {
        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('getSubscription'), 2]
            ])
        )->willThrow(new NotFoundException('bad'))
        ->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->assertFalse($this->subscription->exists());
    }

    public function testInfo()
    {
        $sub = [
            'subscription' => self::SUBSCRIPTION,
            'topic' => self::TOPIC
        ];

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('getSubscription'), 2],
                [Argument::withEntry('foo', 'bar'), 4]
            ])
        )->willReturn($sub)
        ->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->subscription->info([ 'foo' => 'bar' ]);
        $this->assertEquals($res, $sub);
    }

    public function testInfoNoRequest()
    {
        $sub = [
            'subscription' => self::SUBSCRIPTION,
            'topic' => self::TOPIC
        ];

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('getSubscription'), 2]
            ])
        )->shouldNotBeCalled();

        $this->subscription->___setProperty('info', $sub);
        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->subscription->info();
        $this->assertEquals($res, $sub);
    }

    public function testReload()
    {
        $sub = [
            'subscription' => self::SUBSCRIPTION,
            'topic' => self::TOPIC
        ];

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('getSubscription'), 2],
                [Argument::withEntry('foo', 'bar'), 4]
            ])
        )->willReturn($sub)
        ->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

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

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('pull'), 2],
                [Argument::withEntry('foo', 'bar'), 4]
            ])
        )->willReturn($messages)
        ->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

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

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('pull'), 2],
                [Argument::withEntry('foo', 'bar'), 4]
            ])
        )->willReturn($messages)
        ->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

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

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('pull'), 2],
                [Argument::containing(2), 3],   // maxMessages
                [Argument::allOf(
                    Argument::withEntry('foo', 'bar'),
                    Argument::withEntry('returnImmediately', true),
                ), 4]
            ])
        )->willReturn($messages)->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

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

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('acknowledge'), 2],
                [Argument::withEntry(1, [$ackId]), 3],
                [Argument::withEntry('foo', 'bar'), 4]
            ])
        )->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $message = new Message([], ['ackId' => $ackId]);
        $this->subscription->acknowledge($message, ['foo' => 'bar']);
    }

    public function testAcknowledgeBatch()
    {
        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('acknowledge'), 2],
                [Argument::withEntry(1, $this->ackIds), 3],
                [Argument::withEntry('foo', 'bar'), 4]
            ])
        )->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->subscription->acknowledgeBatch($this->messages, ['foo' => 'bar']);
    }

    /**
     * The method acknowledgBatch should suppress any exception if it is
     * with a reason with EOD.
     */
    public function testAcknowledgeBatchSuppressExceptionsForEod()
    {
        $metadata = [
            'foobar' => 'PERMANENT_FAILURE_INVALID_ACK_ID',
            'otherAckId' => 'PERMANENT_FAILURE_INVALID_ACK_ID'
        ];
        $ex = $this->generateEodException($metadata);

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('acknowledge'), 2],
                [Argument::withEntry(1, $this->ackIds), 3]
            ])
        )->willThrow($ex);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        try {
            $this->subscription->acknowledgeBatch($this->messages);
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
        $metadata = [
            'foobar' => 'PERMANENT_FAILURE_INVALID_ACK_ID',
            'otherAckId' => 'PERMANENT_FAILURE_INVALID_ACK_ID'
        ];

        // If an exception has a reason different than 'EXACTLY_ONCE_ACKID_FAILURE'
        // in it's exception msg, then it should bubble up
        $ex = $this->generateEodException($metadata, 'FAILURE_REASON');

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('acknowledge'), 2],
                [Argument::withEntry(1, $this->ackIds), 3]
            ])
        )->willThrow($ex);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        try {
            $this->subscription->acknowledgeBatch($this->messages);
            $this->fail();
        } catch (BadRequestException $e) {
            // we expect the exception so, our test passes
            $this->assertTrue(true);
        }
    }

    public function testAcknowledgeBatchWithReturn()
    {
        $metadata = [
            'foobar' => 'PERMANENT_FAILURE_INVALID_ACK_ID',
            'otherAckId' => 'PERMANENT_FAILURE_INVALID_ACK_ID'
        ];

        $ex = $this->generateEodException($metadata);

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('acknowledge'), 2],
                [Argument::withEntry(1, $this->ackIds), 3]
            ])
        )->willThrow($ex);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());
        $failedMsgs = $this->subscription->acknowledgeBatch($this->messages, ['returnFailures' => true]);

        // Check if the acknowledgeBatch method returned an array of failedMsgs
        $this->assertIsArray($failedMsgs);
        $this->assertEquals(count($failedMsgs), count($this->ackIds));
    }

    public function testAcknowledgeBatchRetryNever()
    {
        // Since all sent msgs are permananently failed,
        // the retry will never take place
        $metadata = [
            'foobar' => 'PERMANENT_FAILURE_INVALID_ACK_ID',
            'otherAckId' => 'PERMANENT_FAILURE_INVALID_ACK_ID'
        ];

        $ex = $this->generateEodException($metadata);

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('acknowledge'), 2],
                [Argument::withEntry(1, $this->ackIds), 3]
            ])
        )->shouldBeCalledTimes(1)->willThrow($ex);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->subscription->acknowledgeBatch($this->messages, ['returnFailures' => true]);
    }

    public function testAcknowledgeBatchRetryPartial()
    {
        // Exception with first msg as a temporary failure
        $metadata1 = [
            'foobar' => 'TRANSIENT_FAILURE_SERVICE_UNAVAILABLE',
            'otherAckId' => 'PERMANENT_FAILURE_INVALID_ACK_ID'
        ];

        // Exception with both msgs as a permanent failure
        $metadata2 = [
            'foobar' => 'PERMANENT_FAILURE_INVALID_ACK_ID',
            'otherAckId' => 'PERMANENT_FAILURE_INVALID_ACK_ID'
        ];

        $ex1 = $this->generateEodException($metadata1);
        $ex2 = $this->generateEodException($metadata2);

        $allEx = [$ex1, $ex1, $ex2];

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('acknowledge'), 2]
            ])
        )->shouldBeCalledTimes(3)->will(function () use (&$allEx) {
            throw array_shift($allEx);
        });

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());
        $failedMsgs = $this->subscription->acknowledgeBatch($this->messages, ['returnFailures' => true]);

        // eventually both msgs failed, so they should be present in our response
        $this->assertEquals(count($failedMsgs), count($this->ackIds));
    }

    public function testAcknowledgeBatchRetryWithSuccess()
    {
        $metadata = [
            'foobar' => 'TRANSIENT_FAILURE_SERVICE_UNAVAILABLE',
            'otherAckId' => 'TRANSIENT_FAILURE_SERVICE_UNAVAILABLE'
        ];

        $ex = $this->generateEodException($metadata);
        $allEx = [$ex, $ex];

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('acknowledge'), 2]
            ])
        )->shouldBeCalledTimes(3)->will(function () use (&$allEx) {
            // An exception is thrown until we have in our list,
            // then we simply return implying a success
            if (count($allEx) > 0) {
                throw array_shift($allEx);
            } else {
                return;
            }
        });

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());
        $failedMsgs = $this->subscription->acknowledgeBatch($this->messages, ['returnFailures' => true]);

        // eventually both msgs were acked, so our $failedMsgs should be empty
        $this->assertEquals(count($failedMsgs), 0);
    }

    public function testAcknowledgeBatchNeverRetriesOnSuccess()
    {
        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('acknowledge'), 2]
            ])
        )->shouldBeCalledTimes(1)->willReturn();

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());
        $failedMsgs = $this->subscription->acknowledgeBatch($this->messages, ['returnFailures' => true]);

        // Both msgs were acked, so our $failedMsgs should be empty
        $this->assertEquals(count($failedMsgs), 0);
    }

    /**
     * We test if a sub with EOD disabled, behaves the same even if it is called
     * with the `returnFailures` flag.
     */
    public function testAcknowledgeBatchReturnsVoidForNonEod()
    {
        $metadata = [
            'foobar' => 'PERMANENT_FAILURE_INVALID_ACK_ID',
            'otherAckId' => 'PERMANENT_FAILURE_INVALID_ACK_ID'
        ];

        // Any reason other than `EXACTLY_ONCE_ACKID_FAILURE` will work
        $ex = $this->generateEodException($metadata, 'FAILURE_REASON');

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('acknowledge'), 2]
            ])
        )->shouldBeCalledTimes(1)->willThrow($ex);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());
        $failedMsgs = $this->subscription->acknowledgeBatch($this->messages, ['returnFailures' => true]);

        // Both msgs were acked, so our $failedMsgs should be empty
        $this->assertIsNotArray($failedMsgs);
    }

    public function testAcknowledgeBatchInvalidArgument()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->subscription->acknowledgeBatch(['foo']);
    }

    public function testModifyAckDeadline()
    {
        $ackId = 'foobar';
        $message = new Message([], ['ackId' => $ackId]);
        $seconds = 100;

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('modifyAckDeadline'), 2],
                [
                    Argument::allOf(
                        Argument::withEntry(1, [$ackId]),
                        Argument::withEntry(2, $seconds)
                    ), 3
                ],
                [Argument::withEntry('foo', 'bar'), 4]
            ])
        )->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->subscription->modifyAckDeadline($message, $seconds, ['foo' => 'bar']);
    }

    public function testModifyAckDeadlineBatch()
    {
        $seconds = 100;

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('modifyAckDeadline'), 2],
                [
                    Argument::allOf(
                        Argument::withEntry(1, $this->ackIds),
                        Argument::withEntry(2, $seconds)
                    ), 3
                ],
                [Argument::withEntry('foo', 'bar'), 4]
            ])
        )->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->subscription->modifyAckDeadlineBatch($this->messages, $seconds, ['foo' => 'bar']);
    }

    /**
     * The method modifyAckDeadlineBatch should suppress any exception if it is
     * with a reason with EOD.
     */
    public function testmodifyAckDeadlineBatchSuppressesExceptionsForEod()
    {
        $seconds = 10;
        $metadata = [
            'foobar' => 'PERMANENT_FAILURE_INVALID_ACK_ID',
            'otherAckId' => 'PERMANENT_FAILURE_INVALID_ACK_ID'
        ];
        $ex = $this->generateEodException($metadata);

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('modifyAckDeadline'), 2],
                [
                    Argument::allOf(
                        Argument::withEntry(1, $this->ackIds),
                        Argument::withEntry(2, $seconds)
                    ), 3
                ]
            ])
        )->willThrow($ex);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        try {
            $this->subscription->modifyAckDeadlineBatch($this->messages, $seconds);
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
        $metadata = [
            'foobar' => 'PERMANENT_FAILURE_INVALID_ACK_ID',
            'otherAckId' => 'PERMANENT_FAILURE_INVALID_ACK_ID'
        ];
        $seconds = 10;
        // If an exception has a reason different than 'EXACTLY_ONCE_ACKID_FAILURE'
        // in it's exception msg, then it should bubble up
        $ex = $this->generateEodException($metadata, 'FAILURE_REASON');

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('modifyAckDeadline'), 2],
                [
                    Argument::allOf(
                        Argument::withEntry(1, $this->ackIds),
                        Argument::withEntry(2, $seconds)
                    ), 3
                ]
            ])
        )->willThrow($ex);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        try {
            $this->subscription->modifyAckDeadlineBatch($this->messages, $seconds);
            $this->fail();
        } catch (BadRequestException $e) {
            // we expect the exception so, our test passes
            $this->assertTrue(true);
        }
    }

    public function testModifyAckDeadlineBatchWithReturn()
    {
        $seconds = 10;
        $metadata = [
            'foobar' => 'PERMANENT_FAILURE_INVALID_ACK_ID',
            'otherAckId' => 'PERMANENT_FAILURE_INVALID_ACK_ID'
        ];

        $ex = $this->generateEodException($metadata);

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('modifyAckDeadline'), 2],
                [
                    Argument::allOf(
                        Argument::withEntry(1, $this->ackIds),
                        Argument::withEntry(2, $seconds)
                    ), 3
                ]
            ])
        )->willThrow($ex);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());
        $failedMsgs = $this->subscription->modifyAckDeadlineBatch($this->messages, $seconds, ['returnFailures' => true]);

        // Check if the modifyAckDeadlineBatch method returned an array of failedMsgs
        $this->assertIsArray($failedMsgs);
        $this->assertEquals(count($failedMsgs), count($this->ackIds));
    }

    public function testModifyAckDeadlineBatchRetryNever()
    {
        $seconds = 10;
        // Since all sent msgs are permananently failed,
        // the retry will never take place
        $metadata = [
            'foobar' => 'PERMANENT_FAILURE_INVALID_ACK_ID',
            'otherAckId' => 'PERMANENT_FAILURE_INVALID_ACK_ID'
        ];

        $ex = $this->generateEodException($metadata);

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('modifyAckDeadline'), 2],
                [
                    Argument::allOf(
                        Argument::withEntry(1, $this->ackIds),
                        Argument::withEntry(2, $seconds)
                    ), 3
                ]
            ])
        )->shouldBeCalledTimes(1)->willThrow($ex);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->subscription->modifyAckDeadlineBatch($this->messages, $seconds, ['returnFailures' => true]);
    }

    public function testModifyAckDeadlineBatchRetryPartial()
    {
        $seconds = 10;
        // Exception with first msg as a temporary failure
        $metadata1 = [
            'foobar' => 'TRANSIENT_FAILURE_SERVICE_UNAVAILABLE',
            'otherAckId' => 'PERMANENT_FAILURE_INVALID_ACK_ID'
        ];

        // Exception with both msgs as a permanent failure
        $metadata2 = [
            'foobar' => 'PERMANENT_FAILURE_INVALID_ACK_ID',
            'otherAckId' => 'PERMANENT_FAILURE_INVALID_ACK_ID'
        ];

        $ex1 = $this->generateEodException($metadata1);
        $ex2 = $this->generateEodException($metadata2);

        $allEx = [$ex1, $ex1, $ex2];

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('modifyAckDeadline'), 2],
                [
                    Argument::allOf(
                        Argument::withEntry(2, $seconds)
                    ), 3
                ]
            ])
        )->shouldBeCalledTimes(3)->will(function () use (&$allEx) {
            throw array_shift($allEx);
        });

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());
        $failedMsgs = $this->subscription->modifyAckDeadlineBatch($this->messages, $seconds, ['returnFailures' => true]);

        // eventually both msgs failed, so they should be present in our response
        $this->assertEquals(count($failedMsgs), count($this->ackIds));
    }

    public function testModifyAckDeadlineBatchRetryWithSuccess()
    {
        $seconds = 10;
        $metadata = [
            'foobar' => 'TRANSIENT_FAILURE_SERVICE_UNAVAILABLE',
            'otherAckId' => 'TRANSIENT_FAILURE_SERVICE_UNAVAILABLE'
        ];

        $ex = $this->generateEodException($metadata);
        $allEx = [$ex, $ex];

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('modifyAckDeadline'), 2],
                [
                    Argument::allOf(
                        Argument::withEntry(2, $seconds)
                    ), 3
                ]
            ])
        )->shouldBeCalledTimes(3)->will(function () use (&$allEx) {
            // An exception is thrown until we have in our list,
            // then we simply return implying a success
            if (count($allEx) > 0) {
                throw array_shift($allEx);
            } else {
                return;
            }
        });

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());
        $failedMsgs = $this->subscription->modifyAckDeadlineBatch($this->messages, $seconds, ['returnFailures' => true]);

        // eventually both msgs were acked, so our $failedMsgs should be empty
        $this->assertEquals(count($failedMsgs), 0);
    }

    public function testModifyAckDeadlineBatchNeverRetriesOnSuccess()
    {
        $seconds = 10;
        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('modifyAckDeadline'), 2],
                [
                    Argument::allOf(
                        Argument::withEntry(1, $this->ackIds),
                        Argument::withEntry(2, $seconds)
                    ), 3
                ]
            ])
        )->shouldBeCalledTimes(1)->willReturn();

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());
        $failedMsgs = $this->subscription->modifyAckDeadlineBatch($this->messages, $seconds, ['returnFailures' => true]);

        // Both msgs were acked, so our $failedMsgs should be empty
        $this->assertEquals(count($failedMsgs), 0);
    }

    /**
     * We test if a sub with EOD disabled, behaves the same even if it is called
     * with the `returnFailures` flag.
     */
    public function testModifyAckDeadlineBatchReturnsVoidForNonEod()
    {
        $seconds = 10;
        $metadata = [
            'foobar' => 'PERMANENT_FAILURE_INVALID_ACK_ID',
            'otherAckId' => 'PERMANENT_FAILURE_INVALID_ACK_ID'
        ];

        // Any reason other than `EXACTLY_ONCE_ACKID_FAILURE` will work
        $ex = $this->generateEodException($metadata, 'FAILURE_REASON');

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('modifyAckDeadline'), 2],
                [
                    Argument::allOf(
                        Argument::withEntry(1, $this->ackIds),
                        Argument::withEntry(2, $seconds)
                    ), 3
                ]
            ])
        )->shouldBeCalledTimes(1)->willThrow($ex);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());
        $failedMsgs = $this->subscription->modifyAckDeadlineBatch($this->messages, $seconds, ['returnFailures' => true]);

        // Both msgs were acked, so our $failedMsgs should be empty
        $this->assertIsNotArray($failedMsgs);
    }

    public function testModifyAckDeadlineBatchInvalidArgument()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->subscription->modifyAckDeadlineBatch(['foo'], 100);
    }

    public function testModifyPushConfig()
    {
        $config = [
            'push_endpoint' => 'test'
        ];

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('modifyPushConfig'), 2],
                [Argument::that(function($args) {
                    return $args[1] instanceof PushConfig && $args[1]->getPushEndpoint() === "test";
                }), 3],
                [Argument::withEntry('foo', 'bar'), 4]
            ])
        )->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->subscription->modifyPushConfig($config, ['foo' => 'bar']);
    }

    public function testSeekToTime()
    {
        $dt = new \DateTime;
        $timestamp = new Timestamp($dt);

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('seek'), 2],
                [Argument::that(function($args) {
                    return isset($args['time']) && $args['time'] instanceof ProtobufTimestamp;
                }), 4],
                [Argument::exact(true), 5]
            ],5)
        )->shouldBeCalled()->willReturn('foo');

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->subscription->seekToTime($timestamp);
        $this->assertEquals('foo', $res);
    }

    public function testSeekToSnapshot()
    {
        $stub = $this->prophesize(Snapshot::class);
        $stub->name()->willReturn('foo');

        $snapshot = $stub->reveal();

        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('seek'), 2],
                [Argument::that(function($args) {
                    return isset($args['snapshot']) && $args['snapshot'] === "foo";
                }), 4],
                [Argument::exact(true), 5]
            ],5)
        )->shouldBeCalled()->willReturn('foo');

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->subscription->seekToSnapshot($snapshot);
        $this->assertEquals('foo', $res);
    }

    public function testIam()
    {
        $this->assertInstanceOf(Iam::class, $this->subscription->iam());
    }

    public function testDetach()
    {
        $this->requestHandler->sendReq(
            ...$this->matchesNthArgument([
                [Argument::exact('detachSubscription'), 2],
                [Argument::withEntry(0, self::SUBSCRIPTION), 3]
            ])
        )->shouldBeCalled()->willReturn([]);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->assertEquals([], $this->subscription->detach());
    }

    // Helper method to generate the exception sent during an invalid EOD operation
    // like acknowledge or modifyAckDeadline
    private function generateEodException($metadata, $failureReason = 'EXACTLY_ONCE_ACKID_FAILURE')
    {
        $arr = [
            'error' => [
                'code' => 400,
                'message' => '',
                'status' => 'INVALID_ARGUMENT',
                'details' => [
                    [
                        '@type' => 'type.googleapis.com/google.rpc.ErrorInfo',
                        'reason' => $failureReason,
                        'domain' => 'pubsub.googleapis.com',
                        'metadata' => $metadata
                    ],
                    [
                        '@type' => 'type.googleapis.com/google.rpc.DebugInfo',
                        'detail' => ''
                    ]
                ]
            ]
        ];

        return new BadRequestException(json_encode($arr));
    }
}
