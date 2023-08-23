<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\PubSub\Tests\System;

use Google\Cloud\PubSub\Message;
use Google\Cloud\PubSub\MessageBuilder;

/**
 * @group pubsub
 * @group pubsub-publish
 */
class PublishAndPullTest extends PubSubTestCase
{
    /**
     * @dataProvider clientProvider
     */
    public function testPublishMessageAndPull($client)
    {
        list ($topic, $sub) = self::topicAndSubscription($client);

        $message = [
            'data' => 'A message.',
            'attributes' => [
                'location' => 'Detroit'
            ]
        ];
        $topic->publish($message);

        $messages = $sub->pull();
        $sub->modifyAckDeadline($messages[0], 15);
        $sub->acknowledge($messages[0]);

        $this->assertEquals($message['data'], $messages[0]->data());
        $this->assertEquals($message['attributes'], $messages[0]->attributes());
    }

    /**
     * @dataProvider clientProvider
     */
    public function testPublishMessagesAndPull($client)
    {
        list ($topic, $sub) = self::topicAndSubscription($client);

        $messages = [
            [
                'data' => 'First.',
                'attributes' => [
                    'first' => 'yes'
                ]
            ],
            [
                'data' => 'Second.',
                'attributes' => [
                    'second' => 'yes'
                ]
            ]
        ];

        $topic->publishBatch($messages);

        $actualMessages = $sub->pull();
        $sub->modifyAckDeadlineBatch($actualMessages, 15);
        $sub->acknowledgeBatch($actualMessages);

        $data = [$actualMessages[0]->data(), $actualMessages[1]->data()];
        $attributes = [$actualMessages[0]->attributes(), $actualMessages[1]->attributes()];
        $this->assertTrue(in_array($messages[0]['data'], $data));
        $this->assertTrue(in_array($messages[0]['attributes'], $attributes));
        $this->assertTrue(in_array($messages[1]['data'], $data));
        $this->assertTrue(in_array($messages[1]['attributes'], $attributes));
    }

    /**
     * @dataProvider clientProvider
     */
    public function testOrderingKeys($client)
    {
        list ($topic, $sub) = self::topicAndSubscription($client, [], [
            'enableMessageOrdering' => true
        ]);

        $key = 'foo';
        $numOfMessages = 5;

        foreach (range(1, $numOfMessages) as $i) {
            $topic->publish((new MessageBuilder())
            ->setData('message' . $i)
            ->setOrderingKey($key)
            ->build());
        }

        $messages = $sub->pull();
        $messagesReceived = array();
        while (count($messagesReceived) != $numOfMessages) {
            foreach ($messages as $message) {
                if (!in_array($message->data(), $messagesReceived)) {
                    // Append message to understand the order
                    array_push($messagesReceived, $message->data());
                }
                // Acknowledgment may take time to reach server
                $sub->acknowledge($message);
            }
            sleep(1);
            $messages = $sub->pull();
        }

        $i = 1;
        foreach ($messagesReceived as $message) {
            $this->assertEquals('message' . $i, $message);
            $i++;
        }
    }

    /**
     * @dataProvider clientProvider
     */
    public function testLateAcknowledge($client)
    {
        $topic = self::topic($client);

        $subscription = self::subscription($client, $topic);
        $expiry = $subscription->info()['ackDeadlineSeconds'];

        // we keep a low ackDeadlineSeconds value
        // as we need to `sleep` for more than this value to trigger an exception
        $eodSubscription = self::exactlyOnceSubscription($client, $topic, ['ackDeadlineSeconds' => 10]);
        $eodExpiry = $eodSubscription->info()['ackDeadlineSeconds'];

        $topic->publish(['data'=>'test']);
        $messages = $subscription->pull();
        $eodMessages = $eodSubscription->pull();

        // we sleep for more than the expiry
        // so that the EOD enabled sub throws an exception when msgs are acknowledged
        sleep(max($expiry, $eodExpiry) + 1);

        // the acknowledgeBatch method shouldn't bubble up the exception for the test to pass
        try {
            $subscription->acknowledgeBatch($messages);
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->fail();
        }

        // the acknowledgeBatch method shouldn't bubble up the exception for the test to pass
        try {
            $eodSubscription->acknowledgeBatch($eodMessages);
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->fail();
        }
    }

    /**
     * @dataProvider clientProvider
     */
    public function testLateModifyAcknowledge($client)
    {
        $topic = self::topic($client);

        $subscription = self::subscription($client, $topic);
        $expiry = $subscription->info()['ackDeadlineSeconds'];

        // we keep a low ackDeadlineSeconds value
        // as we need to `sleep` for more than this value to trigger an exception
        $eodSubscription = self::exactlyOnceSubscription($client, $topic, ['ackDeadlineSeconds' => 10]);
        $eodExpiry = $eodSubscription->info()['ackDeadlineSeconds'];

        $topic->publish(['data'=>'test']);
        $messages = $subscription->pull();
        $eodMessages = $eodSubscription->pull();

        // we sleep for more than the expiry
        // so that the EOD enabled sub throws an exception
        // when the deadline is attempted to be modified
        sleep(max($expiry, $eodExpiry) + 1);

        // the modifyAckDeadlineBatch method shouldn't bubble up the exception for the test to pass
        try {
            $subscription->modifyAckDeadlineBatch($messages, 20);
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->fail();
        }

        // the modifyAckDeadlineBatch method shouldn't bubble up the exception for the test to pass
        try {
            $eodSubscription->modifyAckDeadlineBatch($eodMessages, 20);
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->fail();
        }
    }

    /**
     * @dataProvider clientProvider
     */
    public function testAckAndModAckContainFailedMsgs($client)
    {
        self::skipIfEmulatorUsed();
        $topic = self::topic($client);

        // we keep a low ackDeadlineSeconds value
        // as we need to `sleep` for more than this value to trigger an exception
        $eodSubscription = self::exactlyOnceSubscription($client, $topic, ['ackDeadlineSeconds' => 10]);
        $eodExpiry = $eodSubscription->info()['ackDeadlineSeconds'];

        $topic->publish(['data' => 'test']);
        $messages = $eodSubscription->pull();

        sleep($eodExpiry + 1);

        $failedMsgs = $eodSubscription->acknowledgeBatch($messages, ['returnFailures' => true]);
        // Since acknowledgeBatch was called after the expiry and with the `returnFailures` flag,
        // all the msgs should be returned
        $this->assertIsArray($failedMsgs);

        foreach ($failedMsgs as $msg) {
            $this->assertInstanceOf(Message::class, $msg);
        }

        // Now we test the modifyAckDeadline messages.
        // Testing in the same methods helps in creation/deletion of less resources and
        // we only have to call `sleep` once
        // We do publish a msg again due to a bug in the emulator where
        // acking a set of msgs after expiry was causing the msgs to be removed

        $topic->publish(['data' => 'test']);
        $messages = $eodSubscription->pull();

        sleep($eodExpiry + 1);

        $failedMsgs = $eodSubscription->modifyAckDeadlineBatch($messages, 10, ['returnFailures' => true]);
        // Since modifyAckDeadlineBatch was called after the expiry and with the `returnFailures` flag,
        // all the msgs should be returned
        $this->assertIsArray($failedMsgs);

        foreach ($failedMsgs as $msg) {
            $this->assertInstanceOf(Message::class, $msg);
        }
    }
}
