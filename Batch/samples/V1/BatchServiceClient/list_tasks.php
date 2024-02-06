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

// [START batch_v1_generated_BatchService_ListTasks_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Batch\V1\Client\BatchServiceClient;
use Google\Cloud\Batch\V1\ListTasksRequest;
use Google\Cloud\Batch\V1\Task;

/**
 * List Tasks associated with a job.
 *
 * @param string $formattedParent Name of a TaskGroup from which Tasks are being requested.
 *                                Pattern:
 *                                "projects/{project}/locations/{location}/jobs/{job}/taskGroups/{task_group}"
 *                                Please see {@see BatchServiceClient::taskGroupName()} for help formatting this field.
 */
function list_tasks_sample(string $formattedParent): void
{
    // Create a client.
    $batchServiceClient = new BatchServiceClient();

    // Prepare the request message.
    $request = (new ListTasksRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $batchServiceClient->listTasks($request);

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
    $formattedParent = BatchServiceClient::taskGroupName(
        '[PROJECT]',
        '[LOCATION]',
        '[JOB]',
        '[TASK_GROUP]'
    );

    list_tasks_sample($formattedParent);
}
// [END batch_v1_generated_BatchService_ListTasks_sync]
