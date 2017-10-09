<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Tests\System\Storage;

/**
 * @group storage
 * @group storage-notifications
 */
class ManageNotificationsTest extends StorageTestCase
{
    public function testCreateAndListNotifications()
    {
        $created = [];
        $topic = self::createTopic(self::$pubsubClient, uniqid(self::TESTING_PREFIX));
        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
        $data = json_decode(file_get_contents($keyFilePath), true);
        $projectId = $data['project_id'];
        $policy = $topic->iam()->policy();
        $policy['bindings'] = [
            [
                'role' => 'roles/pubsub.publisher',
                'members' => [
                    "serviceAccount:$projectId@gs-project-accounts.iam.gserviceaccount.com"
                ]
            ]
        ];
        $topic->iam()->setPolicy($policy);

        for ($i = 0; $i < 2; $i++) {
            $created[] = self::$bucket->createNotification($topic, [
                'object_name_prefix' => uniqid('OBJ_PREFIX')
            ]);
        }

        $notifications = iterator_to_array(self::$bucket->notifications());
        $this->assertEquals(count($created), count($notifications));

        foreach ($created as $cNotification) {
            $cNotification->delete();
        }

        $notifications = iterator_to_array(self::$bucket->notifications());
        $this->assertEquals(0, count($notifications));
    }
}
