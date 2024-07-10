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

// [START fleetengine_v1_generated_DeliveryService_ListTasks_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Maps\FleetEngine\Delivery\V1\Client\DeliveryServiceClient;
use Google\Maps\FleetEngine\Delivery\V1\ListTasksRequest;
use Google\Maps\FleetEngine\Delivery\V1\Task;

/**
 * Gets all `Task`s that meet the specified filtering criteria.
 *
 * @param string $formattedParent Must be in the format `providers/{provider}`.
 *                                The `provider` must be the Google Cloud Project ID. For example,
 *                                `sample-cloud-project`. Please see
 *                                {@see DeliveryServiceClient::providerName()} for help formatting this field.
 */
function list_tasks_sample(string $formattedParent): void
{
    // Create a client.
    $deliveryServiceClient = new DeliveryServiceClient();

    // Prepare the request message.
    $request = (new ListTasksRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $deliveryServiceClient->listTasks($request);

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
    $formattedParent = DeliveryServiceClient::providerName('[PROVIDER]');

    list_tasks_sample($formattedParent);
}
// [END fleetengine_v1_generated_DeliveryService_ListTasks_sync]
