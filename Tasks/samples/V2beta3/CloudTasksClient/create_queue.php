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

// [START cloudtasks_v2beta3_generated_CloudTasks_CreateQueue_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Tasks\V2beta3\CloudTasksClient;
use Google\Cloud\Tasks\V2beta3\Queue;

/**
 * Creates a queue.
 *
 * Queues created with this method allow tasks to live for a maximum of 31
 * days. After a task is 31 days old, the task will be deleted regardless of whether
 * it was dispatched or not.
 *
 * WARNING: Using this method may have unintended side effects if you are
 * using an App Engine `queue.yaml` or `queue.xml` file to manage your queues.
 * Read
 * [Overview of Queue Management and
 * queue.yaml](https://cloud.google.com/tasks/docs/queue-yaml) before using
 * this method.
 *
 * @param string $formattedParent The location name in which the queue will be created.
 *                                For example: `projects/PROJECT_ID/locations/LOCATION_ID`
 *
 *                                The list of allowed locations can be obtained by calling Cloud
 *                                Tasks' implementation of
 *                                [ListLocations][google.cloud.location.Locations.ListLocations]. Please see
 *                                {@see CloudTasksClient::locationName()} for help formatting this field.
 */
function create_queue_sample(string $formattedParent): void
{
    // Create a client.
    $cloudTasksClient = new CloudTasksClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $queue = new Queue();

    // Call the API and handle any network failures.
    try {
        /** @var Queue $response */
        $response = $cloudTasksClient->createQueue($formattedParent, $queue);
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
    $formattedParent = CloudTasksClient::locationName('[PROJECT]', '[LOCATION]');

    create_queue_sample($formattedParent);
}
// [END cloudtasks_v2beta3_generated_CloudTasks_CreateQueue_sync]
