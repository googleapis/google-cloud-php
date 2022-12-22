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

// [START cloudtasks_v2beta3_generated_CloudTasks_ListTasks_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Tasks\V2beta3\CloudTasksClient;
use Google\Cloud\Tasks\V2beta3\Task;

/**
 * Lists the tasks in a queue.
 *
 * By default, only the [BASIC][google.cloud.tasks.v2beta3.Task.View.BASIC] view is retrieved
 * due to performance considerations;
 * [response_view][google.cloud.tasks.v2beta3.ListTasksRequest.response_view] controls the
 * subset of information which is returned.
 *
 * The tasks may be returned in any order. The ordering may change at any
 * time.
 *
 * @param string $formattedParent The queue name. For example:
 *                                `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID`
 *                                Please see {@see CloudTasksClient::queueName()} for help formatting this field.
 */
function list_tasks_sample(string $formattedParent): void
{
    // Create a client.
    $cloudTasksClient = new CloudTasksClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $cloudTasksClient->listTasks($formattedParent);

        /** @var Task $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
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

    list_tasks_sample($formattedParent);
}
// [END cloudtasks_v2beta3_generated_CloudTasks_ListTasks_sync]
