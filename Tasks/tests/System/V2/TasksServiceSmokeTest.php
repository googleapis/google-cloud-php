<?php
/*
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace Google\Cloud\Tasks\Tests\System\V2;

use Google\Cloud\Core\ExponentialBackoff;
use Google\Cloud\Core\Testing\System\SystemTestCase;
use Google\Cloud\Tasks\V2\Client\CloudTasksClient;
use Google\Cloud\Tasks\V2\CreateQueueRequest;
use Google\Cloud\Tasks\V2\DeleteQueueRequest;
use Google\Cloud\Tasks\V2\ListQueuesRequest;
use Google\Cloud\Tasks\V2\Queue;
use Google\Cloud\Tasks\V2\Task;

/**
 * @group tasks
 * @group gapic
 */
class TasksServiceSmokeTest extends SystemTestCase
{
    private function createQueue($client, $locationName, $queue)
    {
        $backoff = new ExponentialBackoff(8);
        $backoff->execute(function () use ($client, $locationName, $queue) {
            $client->createQueue(CreateQueueRequest::build($locationName, $queue));
        });
        self::$deletionQueue->add(function () use ($client, $queue) {
            $client->deleteQueue(DeleteQueueRequest::build($queue->getName()));
        });
    }

    /**
     * @test
     */
    public function smokeTest()
    {
        $projectId = getenv('PROJECT_ID');
        if ($projectId === false) {
            $this->fail('Environment variable PROJECT_ID must be set for smoke test');
        }
        $client = new CloudTasksClient();
        $location = 'us-central1';
        $queue = uniqid();
        $queueName = $client::queueName($projectId, $location, $queue);
        $locationName = $client::locationName($projectId, $location);
        $queue = new Queue([
            'name' => $queueName
        ]);
        $this->createQueue($client, $locationName, $queue);

        $resp = $client->listQueues(ListQueuesRequest::build($locationName));
        $found = false;
        foreach ($resp->iterateAllElements() as $q) {
            if ($queueName === $q->getName()) {
                $found = true;
            }
        }
        $this->assertTrue($found, "Queue $queueName should be found in the listQueues respons");
    }
}
