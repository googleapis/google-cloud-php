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

/**
 * @group pubsub
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
        $subsToCreate = [
            uniqid(self::TESTING_PREFIX),
            uniqid(self::TESTING_PREFIX)
        ];

        foreach ($subsToCreate as $subToCreate) {
            self::$deletionQueue[] = $client->subscribe($subToCreate, $topicName);
        }

        $subs = $client->subscriptions();
        $subsByTopic = $topic->subscriptions();

        $this->assertSubsFound($subs, $subsToCreate);
        $this->assertSubsFound($subsByTopic, $subsToCreate);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testReloadSub($client)
    {
        $topicName = uniqid(self::TESTING_PREFIX);
        $topic = $client->createTopic($topicName);
        self::$deletionQueue[] = $topic;
        $shortName = uniqid(self::TESTING_PREFIX);
        $this->assertFalse($topic->subscription($shortName)->exists());
        $sub = $client->subscribe($shortName, $topic->name());
        self::$deletionQueue[] = $sub;

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
        $this->assertInstanceOf(Snapshot::class, $snap);

        $snaps = $client->snapshots();
        $filtered = array_filter(iterator_to_array($snaps), function ($snap) use ($snapName) {
            return strpos($snap->name(), $snapName) !== false;
        });

        $this->assertEquals(1, count($filtered));

        self::$deletionQueue[] = $snap;

        $this->sub->seekToSnapshot($client->snapshot($this->snapName));

        $this->sub->seekToTime($client->timestamp(new \DateTime));
    }

    private function assertSubsFound($subs, $expectedSubs)
    {
        $foundSubs = [];
        foreach ($subs as $sub) {
            $nameParts = explode('/', $sub->name());
            $sName = end($nameParts);
            foreach ($expectedSubs as $key => $expectedSub) {
                if ($sName === $expectedSub) {
                    $foundSubs[$key] = $sName;
                }
            }
        }

        $this->assertEquals($expectedSubs, $foundSubs);
    }
}
