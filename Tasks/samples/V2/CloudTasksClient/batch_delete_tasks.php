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

// [START cloudtasks_v2_generated_CloudTasks_BatchDeleteTasks_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Tasks\V2\BatchDeleteTasksRequest;
use Google\Cloud\Tasks\V2\Client\CloudTasksClient;
use Google\Rpc\Status;

/**
 * Deletes a batch of tasks.
 * This is a non-atomic operation: if deletion fails for some tasks, it
 * can still succeed for others. The metadata field of
 * google.longrunning.Operation contains details of failed deletions.
 * A maximum of 1000 tasks can be deleted in a batch.
 *
 * @param string $formattedParent       The queue name. For example:
 *                                      Format: `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID`
 *                                      Please see {@see CloudTasksClient::queueName()} for help formatting this field.
 * @param string $formattedNamesElement The names of the tasks to delete.
 *                                      A maximum of 1000 tasks can be deleted in a batch.
 *                                      For example:
 *                                      Format:
 *                                      `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID/tasks/TASK_ID`
 *                                      Please see {@see CloudTasksClient::taskName()} for help formatting this field.
 */
function batch_delete_tasks_sample(string $formattedParent, string $formattedNamesElement): void
{
    // Create a client.
    $cloudTasksClient = new CloudTasksClient();

    // Prepare the request message.
    $formattedNames = [$formattedNamesElement,];
    $request = (new BatchDeleteTasksRequest())
        ->setParent($formattedParent)
        ->setNames($formattedNames);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudTasksClient->batchDeleteTasks($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
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
    $formattedNamesElement = CloudTasksClient::taskName('[PROJECT]', '[LOCATION]', '[QUEUE]', '[TASK]');

    batch_delete_tasks_sample($formattedParent, $formattedNamesElement);
}
// [END cloudtasks_v2_generated_CloudTasks_BatchDeleteTasks_sync]
