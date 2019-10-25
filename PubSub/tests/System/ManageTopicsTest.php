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
        $topicsToCreate = [
            uniqid(self::TESTING_PREFIX),
            uniqid(self::TESTING_PREFIX)
        ];

        foreach ($topicsToCreate as $topicToCreate) {
            self::$deletionQueue->add($client->createTopic($topicToCreate));
        }

        $backoff = new ExponentialBackoff(8);
        $hasFoundTopics = $backoff->execute(function () use ($client, $topicsToCreate) {
            $foundTopics = [];
            $topics = $client->topics();

            foreach ($topics as $topic) {
                $nameParts = explode('/', $topic->name());
                $sName = end($nameParts);
                foreach ($topicsToCreate as $key => $topicToCreate) {
                    if ($sName === $topicToCreate) {
                        $foundTopics[$key] = $sName;
                    }
                }
            }

            if (sort($foundTopics) === sort($topicsToCreate)) {
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
        $shortName = uniqid(self::TESTING_PREFIX);
        $this->assertFalse($client->topic($shortName)->exists());
        $topic = $client->createTopic($shortName);
        self::$deletionQueue->add($topic);

        $this->assertTrue($client->topic($shortName)->exists());
        $this->assertEquals($topic->name(), $topic->reload()['name']);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testUpdateTopic($client)
    {
        $shortName = uniqid(self::TESTING_PREFIX);
        $this->assertFalse($client->topic($shortName)->exists());
        $topic = $client->createTopic($shortName);
        self::$deletionQueue->add($topic);

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
        $shortName = uniqid(self::TESTING_PREFIX);
        $this->assertFalse($client->topic($shortName)->exists());
        $topic = $client->createTopic($shortName);
        self::$deletionQueue->add($topic);

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
        $shortName = uniqid(self::TESTING_PREFIX);
        $topic = $client->createTopic($shortName, [
            'messageStoragePolicy' => [
                'allowedPersistenceRegions' => [
                    $region
                ]
            ]
        ]);
        self::$deletionQueue->add($topic);

        $info = $topic->reload();
        $this->assertEquals($region, $info['messageStoragePolicy']['allowedPersistenceRegions'][0]);
    }
}
