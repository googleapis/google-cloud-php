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
class ManageIAMPoliciesTest extends PubSubTestCase
{
    /**
     * @dataProvider clientProvider
     */
    public function testManageTopicIAM($client)
    {
        $topic = $client->createTopic(uniqid(self::TESTING_PREFIX));
        self::$deletionQueue[] = $topic;
        $this->assertIam($topic->iam());
    }

    /**
     * @dataProvider clientProvider
     */
    public function testManageSubscriptionIAM($client)
    {
        $topic = $client->createTopic(uniqid(self::TESTING_PREFIX));
        self::$deletionQueue[] = $topic;
        $sub = $client->subscribe(uniqid(self::TESTING_PREFIX), $topic->name());
        self::$deletionQueue[] = $sub;

        $this->assertIam($sub->iam());
    }

    private function assertIam($iam)
    {
        $policy = [
            'bindings' => [
                [
                    'role' => 'roles/pubsub.admin',
                    'members' => [
                        'user:gcloud.php.tests@gmail.com'
                    ]
                ]
            ]
        ];
        $iam->setPolicy($policy);
        $actualPolicy = $iam->reload();

        $this->assertEquals($policy['bindings'][0], $actualPolicy['bindings'][0]);
    }
}
