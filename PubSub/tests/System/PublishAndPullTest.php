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

        $this->assertEquals($messages[0]['data'], $actualMessages[0]->data());
        $this->assertEquals($messages[0]['attributes'], $actualMessages[0]->attributes());
        $this->assertEquals($messages[1]['data'], $actualMessages[1]->data());
        $this->assertEquals($messages[1]['attributes'], $actualMessages[1]->attributes());
    }

    /**
     * @dataProvider clientProvider
     */
    public function testOrderingKeys($client)
    {
        if ($client instanceof PubSubClientRest) {
            $this->markTestSkipped(
                'enableMessageOrdering not available in REST transport during experimental period.'
            );
        }

        list ($topic, $sub) = self::topicAndSubscription($client, [], [
            'enableMessageOrdering' => true
        ]);

        $key = 'foo';

        $message = (new MessageBuilder())
            ->setData('foobar')
            ->setOrderingKey($key)
            ->build();

        $topic->publish($message);
        sleep(1);

        $pulled = $sub->pull();

        $this->assertEquals($key, $pulled[0]->orderingKey());
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
}
