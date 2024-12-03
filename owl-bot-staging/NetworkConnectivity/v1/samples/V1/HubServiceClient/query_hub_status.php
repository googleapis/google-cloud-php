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

// [START networkconnectivity_v1_generated_HubService_QueryHubStatus_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\NetworkConnectivity\V1\Client\HubServiceClient;
use Google\Cloud\NetworkConnectivity\V1\HubStatusEntry;
use Google\Cloud\NetworkConnectivity\V1\QueryHubStatusRequest;

/**
 * Query the Private Service Connect propagation status of a Network
 * Connectivity Center hub.
 *
 * @param string $formattedName The name of the hub. Please see
 *                              {@see HubServiceClient::hubName()} for help formatting this field.
 */
function query_hub_status_sample(string $formattedName): void
{
    // Create a client.
    $hubServiceClient = new HubServiceClient();

    // Prepare the request message.
    $request = (new QueryHubStatusRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $hubServiceClient->queryHubStatus($request);

        /** @var HubStatusEntry $element */
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
    $formattedName = HubServiceClient::hubName('[PROJECT]', '[HUB]');

    query_hub_status_sample($formattedName);
}
// [END networkconnectivity_v1_generated_HubService_QueryHubStatus_sync]
