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

// [START cloudtasks_v2beta2_generated_CloudTasks_DeleteQueue_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Tasks\V2beta2\CloudTasksClient;

/**
 * Deletes a queue.
 *
 * This command will delete the queue even if it has tasks in it.
 *
 * Note: If you delete a queue, a queue with the same name can't be created
 * for 7 days.
 *
 * WARNING: Using this method may have unintended side effects if you are
 * using an App Engine `queue.yaml` or `queue.xml` file to manage your queues.
 * Read
 * [Overview of Queue Management and
 * queue.yaml](https://cloud.google.com/tasks/docs/queue-yaml) before using
 * this method.
 *
 * @param string $formattedName The queue name. For example:
 *                              `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID`
 *                              Please see {@see CloudTasksClient::queueName()} for help formatting this field.
 */
function delete_queue_sample(string $formattedName): void
{
    // Create a client.
    $cloudTasksClient = new CloudTasksClient();

    // Call the API and handle any network failures.
    try {
        $cloudTasksClient->deleteQueue($formattedName);
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
    $formattedName = CloudTasksClient::queueName('[PROJECT]', '[LOCATION]', '[QUEUE]');

    delete_queue_sample($formattedName);
}
// [END cloudtasks_v2beta2_generated_CloudTasks_DeleteQueue_sync]
