<?php
/*
 * Copyright 2026 Google LLC
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

// [START cloudtasks_v2_generated_CloudTasks_BatchCreateTasks_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Tasks\V2\BatchCreateTasksRequest;
use Google\Cloud\Tasks\V2\BatchCreateTasksResponse;
use Google\Cloud\Tasks\V2\Client\CloudTasksClient;
use Google\Cloud\Tasks\V2\CreateTaskRequest;
use Google\Cloud\Tasks\V2\Task;
use Google\Rpc\Status;

/**
 * Creates a batch of tasks and adds them to a queue.
 *
 * All tasks must be for the same queue.
 * A maximum of 100 tasks can be created in a single batch.
 *
 * @param string $formattedParent         The queue name. For example:
 *                                        `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID`
 *
 *                                        The queue must already exist. Please see
 *                                        {@see CloudTasksClient::queueName()} for help formatting this field.
 * @param string $formattedRequestsParent The queue name. For example:
 *                                        `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID`
 *
 *                                        The queue must already exist. Please see
 *                                        {@see CloudTasksClient::queueName()} for help formatting this field.
 */
function batch_create_tasks_sample(string $formattedParent, string $formattedRequestsParent): void
{
    // Create a client.
    $cloudTasksClient = new CloudTasksClient();

    // Prepare the request message.
    $requestsTask = new Task();
    $createTaskRequest = (new CreateTaskRequest())
        ->setParent($formattedRequestsParent)
        ->setTask($requestsTask);
    $requests = [$createTaskRequest,];
    $request = (new BatchCreateTasksRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudTasksClient->batchCreateTasks($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var BatchCreateTasksResponse $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
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
    $formattedRequestsParent = CloudTasksClient::queueName('[PROJECT]', '[LOCATION]', '[QUEUE]');

    batch_create_tasks_sample($formattedParent, $formattedRequestsParent);
}
// [END cloudtasks_v2_generated_CloudTasks_BatchCreateTasks_sync]
