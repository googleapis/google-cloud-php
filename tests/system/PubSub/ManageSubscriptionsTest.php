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

namespace Google\Cloud\Tests\System\PubSub;

use Google\Cloud\PubSub\Snapshot;
use Google\Cloud\Core\ExponentialBackoff;

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
        $topicName = uniqid(self::TESTING_PREFIX);
        $topic = $client->createTopic($topicName);
        self::$deletionQueue->add($topic);

        $subsToCreate = [
            uniqid(self::TESTING_PREFIX),
            uniqid(self::TESTING_PREFIX)
        ];

        foreach ($subsToCreate as $subToCreate) {
            self::$deletionQueue->add($client->subscribe($subToCreate, $topicName));
        }

        $this->assertSubsFound($client, $subsToCreate);
        $this->assertSubsFound($topic, $subsToCreate);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testReloadSub($client)
    {
        $topicName = uniqid(self::TESTING_PREFIX);
        $topic = $client->createTopic($topicName);
        self::$deletionQueue->add($topic);

        $shortName = uniqid(self::TESTING_PREFIX);
        $this->assertFalse($topic->subscription($shortName)->exists());

        $sub = $client->subscribe($shortName, $topic->name());
        self::$deletionQueue->add($sub);

        $this->assertTrue($topic->subscription($shortName)->exists());
        $this->assertEquals($sub->name(), $sub->reload()['name']);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testCreateAndListSnapshots($client)
    {
        $subs = $client->subscriptions();
        $sub = $subs->current();

        $snapName = uniqid(self::TESTING_PREFIX);

        $snap = $client->createSnapshot($snapName, $sub);
        self::$deletionQueue->add($snap);

        $this->assertInstanceOf(Snapshot::class, $snap);

        $backoff = new ExponentialBackoff(8);
        $hasFoundSub = $backoff->execute(function () use ($client, $snapName) {
            $snaps = $client->snapshots();
            $filtered = array_filter(iterator_to_array($snaps), function ($snap) use ($snapName) {
                return strpos($snap->name(), $snapName) !== false;
            });

            if (count($filtered) === 1) {
                return true;
            }

            throw new \Exception('Items not found in the allotted number of attempts.');
        });

        $this->assertTrue($hasFoundSub);

        $sub->seekToSnapshot($client->snapshot($snapName));

        $sub->seekToTime($client->timestamp(new \DateTime));
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
