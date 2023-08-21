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

// [START cloudtasks_v2beta3_generated_CloudTasks_CreateTask_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Tasks\V2beta3\CloudTasksClient;
use Google\Cloud\Tasks\V2beta3\Task;

/**
 * Creates a task and adds it to a queue.
 *
 * Tasks cannot be updated after creation; there is no UpdateTask command.
 *
 * * The maximum task size is 100KB.
 *
 * @param string $formattedParent The queue name. For example:
 *                                `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID`
 *
 *                                The queue must already exist. Please see
 *                                {@see CloudTasksClient::queueName()} for help formatting this field.
 */
function create_task_sample(string $formattedParent): void
{
    // Create a client.
    $cloudTasksClient = new CloudTasksClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $task = new Task();

    // Call the API and handle any network failures.
    try {
        /** @var Task $response */
        $response = $cloudTasksClient->createTask($formattedParent, $task);
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
    $formattedParent = CloudTasksClient::queueName('[PROJECT]', '[LOCATION]', '[QUEUE]');

    create_task_sample($formattedParent);
}
// [END cloudtasks_v2beta3_generated_CloudTasks_CreateTask_sync]
