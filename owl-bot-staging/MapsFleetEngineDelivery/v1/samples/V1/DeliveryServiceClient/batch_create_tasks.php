<?php
/*
 * Copyright 2024 Google LLC
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

// [START fleetengine_v1_generated_DeliveryService_BatchCreateTasks_sync]
use Google\ApiCore\ApiException;
use Google\Maps\FleetEngine\Delivery\V1\BatchCreateTasksRequest;
use Google\Maps\FleetEngine\Delivery\V1\BatchCreateTasksResponse;
use Google\Maps\FleetEngine\Delivery\V1\Client\DeliveryServiceClient;
use Google\Maps\FleetEngine\Delivery\V1\CreateTaskRequest;
use Google\Maps\FleetEngine\Delivery\V1\Task;
use Google\Maps\FleetEngine\Delivery\V1\Task\State;
use Google\Maps\FleetEngine\Delivery\V1\Task\Type;
use Google\Protobuf\Duration;

/**
 * Creates and returns a batch of new `Task` objects.
 *
 * @param string $formattedParent   The parent resource shared by all tasks. This value must be in
 *                                  the format `providers/{provider}`. The `provider` must be the Google Cloud
 *                                  Project ID. For example, `sample-cloud-project`. The parent field in the
 *                                  `CreateTaskRequest` messages must either  be empty, or it must match this
 *                                  field. Please see
 *                                  {@see DeliveryServiceClient::providerName()} for help formatting this field.
 * @param string $requestsParent    Must be in the format `providers/{provider}`. The `provider` must
 *                                  be the Google Cloud Project ID. For example, `sample-cloud-project`.
 * @param string $requestsTaskId    The Task ID must be unique, but it should be not a shipment
 *                                  tracking ID. To store a shipment tracking ID, use the `tracking_id` field.
 *                                  Note that multiple tasks can have the same `tracking_id`. Task IDs are
 *                                  subject to the following restrictions:
 *
 *                                  * Must be a valid Unicode string.
 *                                  * Limited to a maximum length of 64 characters.
 *                                  * Normalized according to [Unicode Normalization Form C]
 *                                  (http://www.unicode.org/reports/tr15/).
 *                                  * May not contain any of the following ASCII characters: '/', ':', '?',
 *                                  ',', or '#'.
 * @param int    $requestsTaskType  Immutable. Defines the type of the Task. For example, a break or
 *                                  shipment.
 * @param int    $requestsTaskState The current execution state of the Task.
 */
function batch_create_tasks_sample(
    string $formattedParent,
    string $requestsParent,
    string $requestsTaskId,
    int $requestsTaskType,
    int $requestsTaskState
): void {
    // Create a client.
    $deliveryServiceClient = new DeliveryServiceClient();

    // Prepare the request message.
    $requestsTaskTaskDuration = new Duration();
    $requestsTask = (new Task())
        ->setType($requestsTaskType)
        ->setState($requestsTaskState)
        ->setTaskDuration($requestsTaskTaskDuration);
    $createTaskRequest = (new CreateTaskRequest())
        ->setParent($requestsParent)
        ->setTaskId($requestsTaskId)
        ->setTask($requestsTask);
    $requests = [$createTaskRequest,];
    $request = (new BatchCreateTasksRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchCreateTasksResponse $response */
        $response = $deliveryServiceClient->batchCreateTasks($request);
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
    $formattedParent = DeliveryServiceClient::providerName('[PROVIDER]');
    $requestsParent = '[PARENT]';
    $requestsTaskId = '[TASK_ID]';
    $requestsTaskType = Type::TYPE_UNSPECIFIED;
    $requestsTaskState = State::STATE_UNSPECIFIED;

    batch_create_tasks_sample(
        $formattedParent,
        $requestsParent,
        $requestsTaskId,
        $requestsTaskType,
        $requestsTaskState
    );
}
// [END fleetengine_v1_generated_DeliveryService_BatchCreateTasks_sync]
