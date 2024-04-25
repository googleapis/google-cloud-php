<?php
/*
 * Copyright 2023 Google LLC
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

// [START networkconnectivity_v1_generated_HubService_RejectHubSpoke_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkConnectivity\V1\Client\HubServiceClient;
use Google\Cloud\NetworkConnectivity\V1\RejectHubSpokeRequest;
use Google\Cloud\NetworkConnectivity\V1\RejectHubSpokeResponse;
use Google\Rpc\Status;

/**
 * Rejects a Network Connectivity Center spoke from being attached to a hub.
 * If the spoke was previously in the `ACTIVE` state, it
 * transitions to the `INACTIVE` state and is no longer able to
 * connect to other spokes that are attached to the hub.
 *
 * @param string $formattedName     The name of the hub from which to reject the spoke. Please see
 *                                  {@see HubServiceClient::hubName()} for help formatting this field.
 * @param string $formattedSpokeUri The URI of the spoke to reject from the hub. Please see
 *                                  {@see HubServiceClient::spokeName()} for help formatting this field.
 */
function reject_hub_spoke_sample(string $formattedName, string $formattedSpokeUri): void
{
    // Create a client.
    $hubServiceClient = new HubServiceClient();

    // Prepare the request message.
    $request = (new RejectHubSpokeRequest())
        ->setName($formattedName)
        ->setSpokeUri($formattedSpokeUri);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $hubServiceClient->rejectHubSpoke($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var RejectHubSpokeResponse $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
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
    $formattedName = HubServiceClient::hubName('[PROJECT]', '[HUB]');
    $formattedSpokeUri = HubServiceClient::spokeName('[PROJECT]', '[LOCATION]', '[SPOKE]');

    reject_hub_spoke_sample($formattedName, $formattedSpokeUri);
}
// [END networkconnectivity_v1_generated_HubService_RejectHubSpoke_sync]
