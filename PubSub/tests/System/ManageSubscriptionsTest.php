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

use Google\Cloud\Core\Duration;
use Google\Cloud\Core\ExponentialBackoff;
use Google\Cloud\PubSub\Snapshot;

/**
 * @group pubsub
 * @group pubsub-subscription
 */
class ManageSubscriptionsTest extends PubSubTestCase
{
    /**
     * @dataProvider clientProvider
     */
    public function testCreateAndListSubscriptions($client)
    {
        $topic = self::topic($client);

        $subsToCreate = [
            uniqid(self::TESTING_PREFIX),
            uniqid(self::TESTING_PREFIX)
        ];

        foreach ($subsToCreate as $subToCreate) {
            self::$deletionQueue->add($client->subscribe($subToCreate, $topic));
        }

        $this->assertSubsFound($client, $subsToCreate);
        $this->assertSubsFound($topic, $subsToCreate);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testSubscribeAndReload($client)
    {
        $topic = self::topic($client);

        $subscriptionId = uniqid(self::TESTING_PREFIX);
        $this->assertFalse($topic->subscription($subscriptionId)->exists());

        // Subscribe via the topic.
        $subscription = $topic->subscribe($subscriptionId);
        $this->assertTrue($subscription->exists());

        $subscriptionId2 = uniqid(self::TESTING_PREFIX);
        $this->assertFalse($topic->subscription($subscriptionId2)->exists());

        // Subscribe via pubsubclient
        $subscription2 = $client->subscribe($subscriptionId2, $topic);
        $this->assertTrue($subscription2->exists());

        self::$deletionQueue->add($subscription);
        self::$deletionQueue->add($subscription2);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testCreateAndListSnapshots($client)
    {
        $subs = $client->subscriptions();
        $sub = $subs->current();

        $snapshotId = uniqid(self::TESTING_PREFIX);

        $snap = $client->createSnapshot($snapshotId, $sub);
        self::$deletionQueue->add($snap);

        $this->assertInstanceOf(Snapshot::class, $snap);

        $backoff = new ExponentialBackoff(8);
        $hasFoundSub = $backoff->execute(function () use ($client, $snapshotId) {
            $snaps = $client->snapshots();
            $filtered = array_filter(iterator_to_array($snaps), function ($snap) use ($snapshotId) {
                return strpos($snap->name(), $snapshotId) !== false;
            });

            if (count($filtered) === 1) {
                return true;
            }

            throw new \Exception('Items not found in the allotted number of attempts.');
        });

        $this->assertTrue($hasFoundSub);

        $sub->seekToSnapshot($client->snapshot($snapshotId));

        $sub->seekToTime($client->timestamp(new \DateTime));
    }

    /**
     * @dataProvider clientProvider
     */
    public function testUpdateSubscription($client)
    {
        $subs = $client->subscriptions();
        $sub = $subs->current();
        $ackDeadlineSeconds = isset($sub->info()['ackDeadlineSeconds'])
            ? $sub->info()['ackDeadlineSeconds']
            : false;

        $newDeadline = rand(10, 200);
        $sub->update([
            'ackDeadlineSeconds' => $newDeadline
        ]);

        $this->assertEquals($newDeadline, $sub->info()['ackDeadlineSeconds']);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testUpdateSubscriptionWithUpdateMask($client)
    {
        list ($topic, $sub) = self::topicAndSubscription($client);

        $labels = [
            'foo' => 'bar',
            'bat' => 'baz'
        ];

        $sub->update([
            'labels' => $labels,
            'pushConfig' => [
                'attributes' => [
                    'x-goog-version' => 'v1beta1'
                ]
            ]
        ], [
            'updateMask' => [
                'labels',
                'pushConfig.attributes'
            ]
        ]);

        $this->assertEquals($labels, $sub->info()['labels']);
        $this->assertEquals('v1beta1', $sub->info()['pushConfig']['attributes']['x-goog-version']);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testSubscriptionDurations($client)
    {
        $durationSeconds = 129600;
        $durationNanos = 1001;

        list ($topic, $sub) = self::topicAndSubscription($client, [], [
            'expirationPolicy' => [
                'ttl' => new Duration($durationSeconds, $durationNanos)
            ],
            'messageRetentionDuration' => new Duration($durationSeconds, $durationNanos)
        ]);

        $info = $sub->info();
        if (!isset($info['messageRetentionDuration']) || !isset($info['expirationPolicy']['ttl'])) {
            $this->assertTrue(false, 'Missing expected response data');
        }

        if (is_string($info['messageRetentionDuration'])) {
            $d = explode('.', trim($info['messageRetentionDuration'], 's'));
            if (count($d) !== 2) {
                return null;
            }

            $info['messageRetentionDuration'] = [
                'seconds' => (int) $d[0],
                'nanos' => (int) trim((string) $d[1], '0')
            ];
        }

        $this->assertEquals($durationSeconds, $info['messageRetentionDuration']['seconds']);
        $this->assertEquals($durationNanos, $info['messageRetentionDuration']['nanos']);

        if (is_string($info['expirationPolicy']['ttl'])) {
            $d = explode('.', trim($info['expirationPolicy']['ttl'], 's'));
            if (count($d) !== 2) {
                return null;
            }

            $info['expirationPolicy']['ttl'] = [
                'seconds' => (int) $d[0],
                'nanos' => (int) trim((string) $d[1], '0')
            ];
        }

        $this->assertEquals($durationSeconds, $info['expirationPolicy']['ttl']['seconds']);
        $this->assertEquals($durationNanos, $info['expirationPolicy']['ttl']['nanos']);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testEnableMessageOrdering($client)
    {
        if ($client instanceof PubSubClientRest) {
            $this->markTestSkipped(
                'enableMessageOrdering not available in REST transport during experimental period.'
            );
        }

        list ($topic, $sub) = self::topicAndSubscription($client, [], [
            'enableMessageOrdering' => true
        ]);

        $this->assertTrue($sub->info()['enableMessageOrdering']);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testDeadLetterPolicy($client)
    {
        $dlqTopic1 = $client->createTopic(uniqid(self::TESTING_PREFIX));
        $dlqTopic2 = $client->createTopic(uniqid(self::TESTING_PREFIX));

        $resourceId = uniqid(self::TESTING_PREFIX);
        $topic = $client->createTopic($resourceId);
        $sub = $topic->subscribe($resourceId, [
            'deadLetterPolicy' => [
                'deadLetterTopic' => $dlqTopic1
            ],
        ]);

        self::$deletionQueue->add($dlqTopic1);
        self::$deletionQueue->add($dlqTopic2);
        self::$deletionQueue->add($topic);
        self::$deletionQueue->add($sub);

        $this->assertEquals($dlqTopic1->name(), $sub->reload()['deadLetterPolicy']['deadLetterTopic']);
        $this->assertEquals(5, $sub->reload()['deadLetterPolicy']['maxDeliveryAttempts']);

        $sub->update([
            'deadLetterPolicy' => [
                'deadLetterTopic' => $dlqTopic2->name(),
                'maxDeliveryAttempts' => 10
            ]
        ]);

        $this->assertEquals($dlqTopic2->name(), $sub->reload()['deadLetterPolicy']['deadLetterTopic']);
        $this->assertEquals(10, $sub->reload()['deadLetterPolicy']['maxDeliveryAttempts']);

        $topic->publish(['data' => 'foo']);
        sleep(2);
        $msg = $sub->pull();
        $this->assertEquals(1, $msg[0]->deliveryAttempt());
    }

    private function assertSubsFound($class, $expectedSubs)
    {
        $backoff = new ExponentialBackoff(8);
        $hasFoundSubs = $backoff->execute(function () use ($class, $expectedSubs) {
            $foundSubs = [];
            $subs = $class->subscriptions();

            foreach ($subs as $sub) {
                $nameParts = explode('/', $sub->name());
                $sName = end($nameParts);
                foreach ($expectedSubs as $key => $expectedSub) {
                    if ($sName === $expectedSub) {
                        $foundSubs[$key] = $sName;
                    }
                }
            }

            if (sort($foundSubs) === sort($expectedSubs)) {
                return true;
            }

            throw new \Exception('Items not found in the allotted number of attempts.');
        });

        $this->assertTrue($hasFoundSubs);
    }
}
