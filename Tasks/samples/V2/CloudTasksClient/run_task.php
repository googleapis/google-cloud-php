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

// [START cloudtasks_v2_generated_CloudTasks_RunTask_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Tasks\V2\Client\CloudTasksClient;
use Google\Cloud\Tasks\V2\RunTaskRequest;
use Google\Cloud\Tasks\V2\Task;

/**
 * Forces a task to run now.
 *
 * When this method is called, Cloud Tasks will dispatch the task, even if
 * the task is already running, the queue has reached its
 * [RateLimits][google.cloud.tasks.v2.RateLimits] or is
 * [PAUSED][google.cloud.tasks.v2.Queue.State.PAUSED].
 *
 * This command is meant to be used for manual debugging. For
 * example, [RunTask][google.cloud.tasks.v2.CloudTasks.RunTask] can be used to
 * retry a failed task after a fix has been made or to manually force a task
 * to be dispatched now.
 *
 * The dispatched task is returned. That is, the task that is returned
 * contains the [status][Task.status] after the task is dispatched but
 * before the task is received by its target.
 *
 * If Cloud Tasks receives a successful response from the task's
 * target, then the task will be deleted; otherwise the task's
 * [schedule_time][google.cloud.tasks.v2.Task.schedule_time] will be reset to
 * the time that [RunTask][google.cloud.tasks.v2.CloudTasks.RunTask] was
 * called plus the retry delay specified in the queue's
 * [RetryConfig][google.cloud.tasks.v2.RetryConfig].
 *
 * [RunTask][google.cloud.tasks.v2.CloudTasks.RunTask] returns
 * [NOT_FOUND][google.rpc.Code.NOT_FOUND] when it is called on a
 * task that has already succeeded or permanently failed.
 *
 * @param string $formattedName The task name. For example:
 *                              `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID/tasks/TASK_ID`
 *                              Please see {@see CloudTasksClient::taskName()} for help formatting this field.
 */
function run_task_sample(string $formattedName): void
{
    // Create a client.
    $cloudTasksClient = new CloudTasksClient();

    // Prepare the request message.
    $request = (new RunTaskRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Task $response */
        $response = $cloudTasksClient->runTask($request);
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
    $formattedName = CloudTasksClient::taskName('[PROJECT]', '[LOCATION]', '[QUEUE]', '[TASK]');

    run_task_sample($formattedName);
}
// [END cloudtasks_v2_generated_CloudTasks_RunTask_sync]
