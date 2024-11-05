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

// [START fleetengine_v1_generated_DeliveryService_CreateTask_sync]
use Google\ApiCore\ApiException;
use Google\Maps\FleetEngine\Delivery\V1\Client\DeliveryServiceClient;
use Google\Maps\FleetEngine\Delivery\V1\CreateTaskRequest;
use Google\Maps\FleetEngine\Delivery\V1\Task;
use Google\Maps\FleetEngine\Delivery\V1\Task\State;
use Google\Maps\FleetEngine\Delivery\V1\Task\Type;
use Google\Protobuf\Duration;

/**
 * Creates and returns a new `Task` object.
 *
 * @param string $parent    Must be in the format `providers/{provider}`. The `provider` must
 *                          be the Google Cloud Project ID. For example, `sample-cloud-project`.
 * @param string $taskId    The Task ID must be unique, but it should be not a shipment
 *                          tracking ID. To store a shipment tracking ID, use the `tracking_id` field.
 *                          Note that multiple tasks can have the same `tracking_id`. Task IDs are
 *                          subject to the following restrictions:
 *
 *                          * Must be a valid Unicode string.
 *                          * Limited to a maximum length of 64 characters.
 *                          * Normalized according to [Unicode Normalization Form C]
 *                          (http://www.unicode.org/reports/tr15/).
 *                          * May not contain any of the following ASCII characters: '/', ':', '?',
 *                          ',', or '#'.
 * @param int    $taskType  Immutable. Defines the type of the Task. For example, a break or
 *                          shipment.
 * @param int    $taskState The current execution state of the Task.
 */
function create_task_sample(string $parent, string $taskId, int $taskType, int $taskState): void
{
    // Create a client.
    $deliveryServiceClient = new DeliveryServiceClient();

    // Prepare the request message.
    $taskTaskDuration = new Duration();
    $task = (new Task())
        ->setType($taskType)
        ->setState($taskState)
        ->setTaskDuration($taskTaskDuration);
    $request = (new CreateTaskRequest())
        ->setParent($parent)
        ->setTaskId($taskId)
        ->setTask($task);

    // Call the API and handle any network failures.
    try {
        /** @var Task $response */
        $response = $deliveryServiceClient->createTask($request);
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
    $parent = '[PARENT]';
    $taskId = '[TASK_ID]';
    $taskType = Type::TYPE_UNSPECIFIED;
    $taskState = State::STATE_UNSPECIFIED;

    create_task_sample($parent, $taskId, $taskType, $taskState);
}
// [END fleetengine_v1_generated_DeliveryService_CreateTask_sync]
