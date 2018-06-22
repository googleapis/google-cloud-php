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
namespace Google\Cloud\Tasks\Tests\System\V2beta2;

use Google\Cloud\Core\ExponentialBackoff;
use Google\Cloud\Core\Testing\System\SystemTestCase;
use Google\Cloud\Tasks\V2beta2\CloudTasksClient;
use Google\Cloud\Tasks\V2beta2\LeaseDuration;
use Google\Cloud\Tasks\V2beta2\PullMessage;
use Google\Cloud\Tasks\V2beta2\PullTarget;
use Google\Cloud\Tasks\V2beta2\Queue;
use Google\Cloud\Tasks\V2beta2\Task;
use Google\Cloud\Tasks\V2beta2\Task_View;
use Google\Protobuf\Duration;

/**
 * @group tasks
 * @group gapic
 */
class TasksServiceSmokeTest extends SystemTestCase
{

    public function createQueue($client, $locationName, $queue)
    {
        $backoff = new ExponentialBackoff(8);
        $backoff->execute(function () use ($client, $locationName, $queue) {
            $client->createQueue($locationName, $queue);
        });
        self::$deletionQueue->add(function () use ($backoff, $client, $queue) {
            $backoff->execute(function () use ($client, $queue) {
                $client->deleteQueue($queue->getName());
            });
        });
        sleep(120);
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
        $queue = new Queue();
        $queue->setName($queueName);
        $queue->setPullTarget(new PullTarget());
        $this->createQueue($client, $locationName, $queue);
        $pullMessage = new PullMessage();
        $payload = 'a message for the consumer: ' . uniqid();
        $pullMessage->setPayload($payload);
        $task = new Task();
        $task->setPullMessage($pullMessage);
        $client->createTask($queueName, $task);

        $leaseDuration = new Duration();
        $leaseDuration->setSeconds(600);
        $resp = $client->leaseTasks(
            $queueName,
            $leaseDuration,
            [
                'maxTasks' => 1,
                'responseView' => Task_View::FULL
            ]
        );
        $task = $resp->getTasks()[0];
        $this->assertEquals($payload, $task->getPullMessage()->getPayload());

        // Acknowledge the task
        $client->acknowledgeTask($task->getName(), $task->getScheduleTime());
    }
}
