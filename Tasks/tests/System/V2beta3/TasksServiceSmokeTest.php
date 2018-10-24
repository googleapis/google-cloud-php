<?php
/*
 * Copyright 2018 Google LLC
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
namespace Google\Cloud\Tasks\Tests\System\V2beta3;

use Google\Cloud\Core\ExponentialBackoff;
use Google\Cloud\Core\Testing\System\SystemTestCase;
use Google\Cloud\Tasks\V2beta3\AppEngineHttpQueue;
use Google\Cloud\Tasks\V2beta3\CloudTasksClient;
use Google\Cloud\Tasks\V2beta3\LeaseDuration;
use Google\Cloud\Tasks\V2beta3\PullMessage;
use Google\Cloud\Tasks\V2beta3\Queue;
use Google\Cloud\Tasks\V2beta3\Task;
use Google\Cloud\Tasks\V2beta3\Task\View;
use Google\Protobuf\Duration;

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
            $client->createQueue($locationName, $queue);
        });
        self::$deletionQueue->add(function () use ($client, $queue) {
            $client->deleteQueue($queue->getName());
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
            'name' => $queueName,
            'app_engine_http_queue' => new AppEngineHttpQueue()
        ]);
        $this->createQueue($client, $locationName, $queue);

        $resp = $client->listQueues($locationName);
        $found = false;
        foreach ($resp->iterateAllElements() as $q) {
            if ($queueName === $q->getName()) {
                $found = true;
            }
        }
        $this->assertTrue($found, "Queue $queueName should be found in the listQueues respons");
    }
}
