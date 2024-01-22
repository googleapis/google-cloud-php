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

use Google\ApiCore\Serializer;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\Duration;
use Google\Cloud\Core\Exception\BadRequestException;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iam\IamManager;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\PubSub\Message;
use Google\Cloud\PubSub\Snapshot;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;
use Google\Cloud\PubSub\V1\Client\SubscriberClient;
use Google\Cloud\PubSub\V1\Client\PublisherClient;
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
    use ApiHelperTrait;

    const PROJECT = 'project-id';
    const SUBSCRIPTION = 'projects/project-id/subscriptions/subscription-name';
    const TOPIC = 'projects/project-id/topics/topic-name';

    private $subscription;
    private $serializer;
    private $requestHandler;
    private $ackIds;
    private $messages;

    public function setUp(): void
    {
        $this->requestHandler = $this->prophesize(RequestHandler::class);
        $this->serializer = new Serializer([
            'publish_time' => function ($v) {
                return $this->formatTimestampFromApi($v);
            },
            'expiration_time' => function ($v) {
                return $this->formatTimestampFromApi($v);
            }
        ], [], [], [
            'google.protobuf.Duration' => function ($v) {
                return $this->formatDurationForApi($v);
            }
        ]);

        $this->subscription = TestHelpers::stub(Subscription::class, [
            $this->requestHandler->reveal(),
            $this->serializer,
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
        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'getSubscription',
            Argument::cetera()
        )->willReturn([
            'detached' => true
        ]);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->assertTrue($this->subscription->detached());
    }

    public function testCreate()
    {
        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'createSubscription',
            Argument::cetera()
        )->willReturn([
            'name' => self::SUBSCRIPTION,
            'topic' => self::TOPIC
        ])->shouldBeCalledTimes(1);

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'getSubscription',
            Argument::cetera()
        )->shouldNotBeCalled();

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $sub = $this->subscription->create(['name' => 'testName']);

        $this->assertEquals($sub['name'], self::SUBSCRIPTION);
        $this->assertEquals($sub['topic'], self::TOPIC);
    }

    public function testCreateWithoutTopicName()
    {
        $this->expectException(InvalidArgumentException::class);

        $subscription = new Subscription(
            $this->requestHandler->reveal(),
            $this->serializer,
            'project-id',
            'subscription-name',
            null,
            true
        );

        $sub = $subscription->create();
    }

    public function testUpdate()
    {
        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'updateSubscription',
            Argument::cetera()
        )->shouldBeCalled()->willReturn([
            'foo' => 'bar'
        ]);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->subscription->update(['labels' => ['key' => 'val']]);

        $this->assertEquals(['foo' => 'bar'], $res);
        $this->assertEquals('bar', $this->subscription->info()['foo']);
    }

    public function testDurations()
    {
        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'updateSubscription',
            Argument::cetera()
        )->shouldBeCalled()->willReturn([
            'foo' => 'bar'
        ]);

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'createSubscription',
            Argument::cetera()
        )->shouldBeCalled()->willReturn([
            'foo' => 'bar'
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

        $this->subscription->update($args);
        $this->subscription->create($args);
    }

    public function testDeadLetterPolicyTopicNames()
    {
        $mock = $this->prophesize(Topic::class);
        $mock->name()->willReturn(self::TOPIC);
        $topic = $mock->reveal();

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'updateSubscription',
            Argument::cetera()
        )->shouldBeCalledTimes(2)->willReturn([
            'foo' => 'bar'
        ]);

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'createSubscription',
            Argument::cetera()
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
        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'deleteSubscription',
            Argument::cetera()
        )->willReturn(null)
        ->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->subscription->delete([ 'foo' => 'bar' ]);

        $this->assertNull($res);
    }

    public function testExists()
    {
        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'getSubscription',
            Argument::cetera()
        )->willReturn([
            'subscription' => self::SUBSCRIPTION,
            'topic' => self::TOPIC
        ])->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->assertTrue($this->subscription->exists([ 'foo' => 'bar' ]));
    }

    public function testExistsNotFound()
    {
        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'getSubscription',
            Argument::cetera()
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

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'getSubscription',
            Argument::cetera()
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

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'getSubscription',
            Argument::cetera()
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

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'getSubscription',
            Argument::cetera()
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

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'pull',
            Argument::cetera()
        )->willReturn($messages)
        ->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $result = $this->subscription->pull([
            'maxMessages' => 10
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

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'pull',
            Argument::cetera()
        )->willReturn($messages)
        ->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $result = $this->subscription->pull();

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

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'pull',
            Argument::cetera()
        )->willReturn($messages)->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $result = $this->subscription->pull([
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

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'acknowledge',
            Argument::cetera()
        )->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $message = new Message([], ['ackId' => $ackId]);
        $this->subscription->acknowledge($message, ['foo' => 'bar']);
    }

    public function testAcknowledgeBatch()
    {
        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'acknowledge',
            Argument::cetera()
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

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'acknowledge',
            Argument::cetera()
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

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'acknowledge',
            Argument::cetera()
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

        $failedMsgs = [];
        $ackIds = $this->ackIds;

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'acknowledge',
            Argument::cetera()
        )->shouldBeCalled()
        ->will(function ($args) use (&$failedMsgs, $ex, $ackIds) {
            // We modify the $failedMsgs here
            // instead of returning them from the acknowledgeBatch call
            // because in the Subscription class, they are modified in the retry function.
            // So, we are merely trying to emulate that.
            $failedMsgs = $ackIds;

            throw $ex;
        });

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->subscription->acknowledgeBatch($this->messages, [
            'returnFailures' => true
        ]);

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

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'acknowledge',
            Argument::cetera()
        )->shouldBeCalledTimes(1)->willThrow($ex);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->subscription->acknowledgeBatch($this->messages, ['returnFailures' => true]);
    }

    public function testAcknowledgeBatchNeverRetriesOnSuccess()
    {
        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'acknowledge',
            Argument::cetera()
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
        $failedMsgs = [];

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'acknowledge',
            Argument::cetera()
        )->shouldBeCalledTimes(1)
        ->will(function ($args) use ($ex, &$failedMsgs) {
            $failedMsgs = null;

            throw $ex;
        });

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->subscription->acknowledgeBatch($this->messages, ['returnFailures' => true]);

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

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'modifyAckDeadline',
            Argument::cetera()
        )->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->subscription->modifyAckDeadline($message, $seconds, ['foo' => 'bar']);
    }

    public function testModifyAckDeadlineBatch()
    {
        $seconds = 100;

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'modifyAckDeadline',
            Argument::cetera()
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

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'modifyAckDeadline',
            Argument::cetera()
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

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'modifyAckDeadline',
            Argument::cetera()
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
        $metadata = [
            'foobar' => 'PERMANENT_FAILURE_INVALID_ACK_ID',
            'otherAckId' => 'PERMANENT_FAILURE_INVALID_ACK_ID'
        ];

        $ex = $this->generateEodException($metadata);
        $failedMsgs = [];
        $ackIds = $this->ackIds;

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'modifyAckDeadline',
            Argument::cetera()
        )->will(function ($args) use ($ex, &$failedMsgs, $ackIds) {
            // We modify the $failedMsgs here
            // instead of returning them from the modifyAckDeadlineBatch call
            // because in the Subscription class, they are modified in the retry function.
            // So, we are merely trying to emulate that.
            $failedMsgs = $ackIds;

            throw $ex;
        });

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->subscription->modifyAckDeadlineBatch($this->messages, 10, ['returnFailures' => true]);

        // Check if the modifyAckDeadlineBatch method returned an array of failedMsgs
        $this->assertIsArray($failedMsgs);
        $this->assertEquals(count($failedMsgs), count($this->ackIds));
    }

    public function testModifyAckDeadlineBatchRetryNever()
    {
        // Since all sent msgs are permananently failed,
        // the retry will never take place
        $metadata = [
            'foobar' => 'PERMANENT_FAILURE_INVALID_ACK_ID',
            'otherAckId' => 'PERMANENT_FAILURE_INVALID_ACK_ID'
        ];

        $ex = $this->generateEodException($metadata);

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'modifyAckDeadline',
            Argument::cetera()
        )->shouldBeCalledTimes(1)->willThrow($ex);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->subscription->modifyAckDeadlineBatch($this->messages, 10, ['returnFailures' => true]);
    }

    public function testModifyAckDeadlineBatchNeverRetriesOnSuccess()
    {
        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'modifyAckDeadline',
            Argument::cetera()
        )->shouldBeCalledTimes(1)->willReturn();

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());
        $failedMsgs = $this->subscription->modifyAckDeadlineBatch($this->messages, 10, ['returnFailures' => true]);

        // Both msgs were acked, so our $failedMsgs should be empty
        $this->assertEquals(count($failedMsgs), 0);
    }

    /**
     * We test if a sub with EOD disabled, behaves the same even if it is called
     * with the `returnFailures` flag.
     */
    public function testModifyAckDeadlineBatchReturnsVoidForNonEod()
    {
        $metadata = [
            'foobar' => 'PERMANENT_FAILURE_INVALID_ACK_ID',
            'otherAckId' => 'PERMANENT_FAILURE_INVALID_ACK_ID'
        ];

        // Any reason other than `EXACTLY_ONCE_ACKID_FAILURE` will work
        $ex = $this->generateEodException($metadata, 'FAILURE_REASON');
        $failedMsgs = [];

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'modifyAckDeadline',
            Argument::cetera()
        )->shouldBeCalledTimes(1)
        ->will(function ($args) use ($ex, &$failedMsgs) {
            $failedMsgs = null;

            throw $ex;
        });

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->subscription->modifyAckDeadlineBatch($this->messages, 10, ['returnFailures' => true]);

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
            'pushEndpoint' => ''
        ];

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'modifyPushConfig',
            Argument::cetera()
        )->shouldBeCalledTimes(1);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->subscription->modifyPushConfig($config);
    }

    public function testSeekToTime()
    {
        $dt = new \DateTime;
        $timestamp = new Timestamp($dt);

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'seek',
            Argument::cetera()
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

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'seek',
            Argument::cetera()
        )->shouldBeCalled()->willReturn('foo');

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->subscription->seekToSnapshot($snapshot);
        $this->assertEquals('foo', $res);
    }

    public function testIam()
    {
        $this->assertInstanceOf(IamManager::class, $this->subscription->iam());
    }

    public function testDetach()
    {
        $this->requestHandler->sendRequest(
            PublisherClient::class,
            'detachSubscription',
            Argument::cetera()
        )->shouldBeCalled()->willReturn([]);

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->assertEquals([], $this->subscription->detach());
    }

    public function testCreateSubscriptionWithCloudStorageConfig()
    {
        $bucket = [
            'bucket' => 'pubsub-test-bucket',
            'maxDuration' => new Duration(3, 1e+9)
        ];
        $bucketString = [
            'bucket' => 'pubsub-test-bucket',
            'maxDuration' => '3.1s'
        ];
        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'createSubscription',
            Argument::cetera()
        )->willReturn([
            'name' => self::SUBSCRIPTION,
            'topic' => self::TOPIC
        ])->shouldBeCalledTimes(1);

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'getSubscription',
            Argument::cetera()
        )->shouldNotBeCalled();

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $sub = $this->subscription->create([
            'name' => 'testName',
            'cloudStorageConfig' => $bucket
        ]);

        $this->assertEquals($sub['name'], self::SUBSCRIPTION);
        $this->assertEquals($sub['topic'], self::TOPIC);
    }

    public function testUpdateSubscriptionWithCloudStorageConfig()
    {
        $bucket = [
            'bucket' => 'pubsub-test-bucket',
            'maxDuration' => new Duration(3, 1e+9)
        ];
        $bucketString = [
            'name' => 'projects/project-id/subscriptions/subscription-name',
            'cloudStorageConfig' => [
                'bucket' => 'pubsub-test-bucket',
                'maxDuration' => '3.1s'
                ]
            ];
        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'updateSubscription',
            Argument::cetera()
        )->willReturn([
            'name' => self::SUBSCRIPTION,
            'topic' => self::TOPIC
        ])->shouldBeCalledTimes(1);

        $this->requestHandler->sendRequest(
            SubscriberClient::class,
            'getSubscription',
            Argument::cetera()
        )->shouldNotBeCalled();

        $this->subscription->___setProperty('requestHandler', $this->requestHandler->reveal());

        $sub = $this->subscription->update([
            'cloudStorageConfig' => $bucket
        ]);

        $this->assertEquals($sub['name'], self::SUBSCRIPTION);
        $this->assertEquals($sub['topic'], self::TOPIC);
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
