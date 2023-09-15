<?php
/*
 * Copyright 2023 Google LLC
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

// [START cloudtasks_v2beta2_generated_CloudTasks_BufferTask_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Tasks\V2beta2\BufferTaskResponse;
use Google\Cloud\Tasks\V2beta2\CloudTasksClient;

/**
 * Creates and buffers a new task without the need to explicitly define a Task
 * message. The queue must have [HTTP
 * target][google.cloud.tasks.v2beta2.HttpTarget]. To create the task with a
 * custom ID, use the following format and set TASK_ID to your desired ID:
 * projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID/tasks/TASK_ID:buffer
 * To create the task with an automatically generated ID, use the following
 * format:
 * projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID/tasks:buffer.
 * Note: This feature is in its experimental stage. You must request access to
 * the API through the [Cloud Tasks BufferTask Experiment Signup
 * form](https://forms.gle/X8Zr5hiXH5tTGFqh8).
 *
 * @param string $formattedQueue The parent queue name. For example:
 *                               projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID`
 *
 *                               The queue must already exist. Please see
 *                               {@see CloudTasksClient::queueName()} for help formatting this field.
 */
function buffer_task_sample(string $formattedQueue): void
{
    // Create a client.
    $cloudTasksClient = new CloudTasksClient();

    // Call the API and handle any network failures.
    try {
        /** @var BufferTaskResponse $response */
        $response = $cloudTasksClient->bufferTask($formattedQueue);
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
    $formattedQueue = CloudTasksClient::queueName('[PROJECT]', '[LOCATION]', '[QUEUE]');

    buffer_task_sample($formattedQueue);
}
// [END cloudtasks_v2beta2_generated_CloudTasks_BufferTask_sync]
