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

// [START cloudtasks_v2_generated_CloudTasks_GetQueue_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Tasks\V2\Client\CloudTasksClient;
use Google\Cloud\Tasks\V2\GetQueueRequest;
use Google\Cloud\Tasks\V2\Queue;

/**
 * Gets a queue.
 *
 * @param string $formattedName The resource name of the queue. For example:
 *                              `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID`
 *                              Please see {@see CloudTasksClient::queueName()} for help formatting this field.
 */
function get_queue_sample(string $formattedName): void
{
    // Create a client.
    $cloudTasksClient = new CloudTasksClient();

    // Prepare the request message.
    $request = (new GetQueueRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Queue $response */
        $response = $cloudTasksClient->getQueue($request);
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

    get_queue_sample($formattedName);
}
// [END cloudtasks_v2_generated_CloudTasks_GetQueue_sync]
