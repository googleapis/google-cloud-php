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

// [START cloudtasks_v2beta2_generated_CloudTasks_LeaseTasks_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Tasks\V2beta2\CloudTasksClient;
use Google\Cloud\Tasks\V2beta2\LeaseTasksResponse;
use Google\Protobuf\Duration;

/**
 * Leases tasks from a pull queue for
 * [lease_duration][google.cloud.tasks.v2beta2.LeaseTasksRequest.lease_duration].
 *
 * This method is invoked by the worker to obtain a lease. The
 * worker must acknowledge the task via
 * [AcknowledgeTask][google.cloud.tasks.v2beta2.CloudTasks.AcknowledgeTask] after they have
 * performed the work associated with the task.
 *
 * The [payload][google.cloud.tasks.v2beta2.PullMessage.payload] is intended to store data that
 * the worker needs to perform the work associated with the task. To
 * return the payloads in the [response][google.cloud.tasks.v2beta2.LeaseTasksResponse], set
 * [response_view][google.cloud.tasks.v2beta2.LeaseTasksRequest.response_view] to
 * [FULL][google.cloud.tasks.v2beta2.Task.View.FULL].
 *
 * A maximum of 10 qps of [LeaseTasks][google.cloud.tasks.v2beta2.CloudTasks.LeaseTasks]
 * requests are allowed per
 * queue. [RESOURCE_EXHAUSTED][google.rpc.Code.RESOURCE_EXHAUSTED]
 * is returned when this limit is
 * exceeded. [RESOURCE_EXHAUSTED][google.rpc.Code.RESOURCE_EXHAUSTED]
 * is also returned when
 * [max_tasks_dispatched_per_second][google.cloud.tasks.v2beta2.RateLimits.max_tasks_dispatched_per_second]
 * is exceeded.
 *
 * @param string $formattedParent The queue name. For example:
 *                                `projects/PROJECT_ID/locations/LOCATION_ID/queues/QUEUE_ID`
 *                                Please see {@see CloudTasksClient::queueName()} for help formatting this field.
 */
function lease_tasks_sample(string $formattedParent): void
{
    // Create a client.
    $cloudTasksClient = new CloudTasksClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $leaseDuration = new Duration();

    // Call the API and handle any network failures.
    try {
        /** @var LeaseTasksResponse $response */
        $response = $cloudTasksClient->leaseTasks($formattedParent, $leaseDuration);
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

    lease_tasks_sample($formattedParent);
}
// [END cloudtasks_v2beta2_generated_CloudTasks_LeaseTasks_sync]
