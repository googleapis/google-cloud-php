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

// [START cloudtasks_v2beta2_generated_CloudTasks_AcknowledgeTask_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Tasks\V2beta2\CloudTasksClient;
use Google\Protobuf\Timestamp;

/**
 * Acknowledges a pull task.
 *
 * The worker, that is, the entity that
 * [leased][google.cloud.tasks.v2beta2.CloudTasks.LeaseTasks] this task must call this method
 * to indicate that the work associated with the task has finished.
 *
 * The worker must acknowledge a task within the
 * [lease_duration][google.cloud.tasks.v2beta2.LeaseTasksRequest.lease_duration] or the lease
 * will expire and the task will become available to be leased
 * again. After the task is acknowledged, it will not be returned
 * by a later [LeaseTasks][google.cloud.tasks.v2beta2.CloudTasks.LeaseTasks],
 * [GetTask][google.cloud.tasks.v2beta2.CloudTasks.GetTask], or
 * [ListTasks][google.cloud.tasks.v2beta2.CloudTasks.ListTasks].
 *
 * @param string $formattedName The task name. For example:
 *                              `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID/tasks/TASK_ID`
 *                              Please see {@see CloudTasksClient::taskName()} for help formatting this field.
 */
function acknowledge_task_sample(string $formattedName): void
{
    // Create a client.
    $cloudTasksClient = new CloudTasksClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $scheduleTime = new Timestamp();

    // Call the API and handle any network failures.
    try {
        $cloudTasksClient->acknowledgeTask($formattedName, $scheduleTime);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = CloudTasksClient::taskName('[PROJECT]', '[LOCATION]', '[QUEUE]', '[TASK]');

    acknowledge_task_sample($formattedName);
}
// [END cloudtasks_v2beta2_generated_CloudTasks_AcknowledgeTask_sync]
