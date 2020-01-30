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

use Google\Cloud\Core\ExponentialBackoff;

/**
 * @group pubsub
 * @group pubsub-topic
 */
class ManageTopicsTest extends PubSubTestCase
{
    /**
     * @dataProvider clientProvider
     */
    public function testCreateAndListTopics($client)
    {
        $createdTopics = [];
        for ($i = 0; $i++; $i < 2) {
            $createdTopics[] = self::topic($client)->name();
        }

        $backoff = new ExponentialBackoff(8);
        $hasFoundTopics = $backoff->execute(function () use ($client, $createdTopics) {
            $foundTopics = [];
            $topics = $client->topics();

            foreach ($topics as $topic) {
                foreach ($createdTopics as $key => $createdTopic) {
                    if ($topic->name() === $createdTopic) {
                        $foundTopics[$key] = $sName;
                    }
                }
            }

            if (sort($foundTopics) === sort($createdTopics)) {
                return true;
            }

            throw new \Exception('Items not found in the allotted number of attempts.');
        });

        $this->assertTrue($hasFoundTopics);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testReloadTopic($client)
    {
        $topic = self::topic($client);

        $this->assertTrue($topic->exists());
        $this->assertEquals($topic->name(), $topic->reload()['name']);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testUpdateTopic($client)
    {
        $topic = self::topic($client);

        $policy = [
            'allowedPersistenceRegions' => ['us-central1', 'us-east1']
        ];

        $topic->update([
            'messageStoragePolicy' => $policy
        ]);

        $this->assertEquals($policy, $topic->info()['messageStoragePolicy']);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testUpdateTopicWithUpdateMask($client)
    {
        $topic = self::topic($client);

        $labels = [
            'foo' => 'bar'
        ];

        $topic->update([
            'labels' => $labels
        ], [
            'updateMask' => [ 'labels' ]
        ]);

        $this->assertEquals($labels, $topic->info()['labels']);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testMessageStoragePolicyAllowedPersistenceRegions($client)
    {
        $region = 'us-central1';
        $topic = self::topic($client, [
            'messageStoragePolicy' => [
                'allowedPersistenceRegions' => [
                    $region
                ]
            ]
        ]);

        $info = $topic->reload();
        $this->assertEquals($region, $info['messageStoragePolicy']['allowedPersistenceRegions'][0]);
    }
}
