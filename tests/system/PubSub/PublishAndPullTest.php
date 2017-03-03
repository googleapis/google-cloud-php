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
class PublishAndPullTest extends PubSubTestCase
{
    /**
     * @dataProvider clientProvider
     */
    public function testPublishMessageAndPull($client)
    {
        $topicName = uniqid(self::TESTING_PREFIX);
        $subName = uniqid(self::TESTING_PREFIX);
        $topic = $client->createTopic($topicName);
        $sub = $client->subscribe($subName, $topicName);
        self::$deletionQueue[] = $topic;
        self::$deletionQueue[] = $sub;

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
        $topicName = uniqid(self::TESTING_PREFIX);
        $subName = uniqid(self::TESTING_PREFIX);
        $topic = $client->createTopic($topicName);
        $sub = $client->subscribe($subName, $topicName);
        self::$deletionQueue[] = $topic;
        self::$deletionQueue[] = $sub;

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
}
