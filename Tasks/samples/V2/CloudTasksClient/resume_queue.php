<?php
/*
 * Copyright 2022 Google LLC
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

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

require_once __DIR__ . '/../../../vendor/autoload.php';

// [START cloudtasks_v2_generated_CloudTasks_ResumeQueue_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Tasks\V2\CloudTasksClient;
use Google\Cloud\Tasks\V2\Queue;

/**
 * Resume a queue.
 *
 * This method resumes a queue after it has been
 * [PAUSED][google.cloud.tasks.v2.Queue.State.PAUSED] or
 * [DISABLED][google.cloud.tasks.v2.Queue.State.DISABLED]. The state of a
 * queue is stored in the queue's [state][google.cloud.tasks.v2.Queue.state];
 * after calling this method it will be set to
 * [RUNNING][google.cloud.tasks.v2.Queue.State.RUNNING].
 *
 * WARNING: Resuming many high-QPS queues at the same time can
 * lead to target overloading. If you are resuming high-QPS
 * queues, follow the 500/50/5 pattern described in
 * [Managing Cloud Tasks Scaling
 * Risks](https://cloud.google.com/tasks/docs/manage-cloud-task-scaling).
 *
 * @param string $formattedName The queue name. For example:
 *                              `projects/PROJECT_ID/location/LOCATION_ID/queues/QUEUE_ID`
 *                              Please see {@see CloudTasksClient::queueName()} for help formatting this field.
 */
function resume_queue_sample(string $formattedName): void
{
    // Create a client.
    $cloudTasksClient = new CloudTasksClient();

    // Call the API and handle any network failures.
    try {
        /** @var Queue $response */
        $response = $cloudTasksClient->resumeQueue($formattedName);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}

/**
 * Helper to execute the sample.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function callSample(): void
{
    $formattedName = CloudTasksClient::queueName('[PROJECT]', '[LOCATION]', '[QUEUE]');

    resume_queue_sample($formattedName);
}
// [END cloudtasks_v2_generated_CloudTasks_ResumeQueue_sync]
