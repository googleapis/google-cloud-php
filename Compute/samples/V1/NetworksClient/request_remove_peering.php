<?php
/*
 * Copyright 2025 Google LLC
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

// [START compute_v1_generated_Networks_RequestRemovePeering_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Compute\V1\Client\NetworksClient;
use Google\Cloud\Compute\V1\NetworksRequestRemovePeeringRequest;
use Google\Cloud\Compute\V1\RequestRemovePeeringNetworkRequest;
use Google\Rpc\Status;

/**
 * Requests to remove a peering from the specified network. Applicable only for PeeringConnection with update_strategy=CONSENSUS.
 *
 * @param string $network Name of the network resource to remove peering from.
 * @param string $project Project ID for this request.
 */
function request_remove_peering_sample(string $network, string $project): void
{
    // Create a client.
    $networksClient = new NetworksClient();

    // Prepare the request message.
    $networksRequestRemovePeeringRequestResource = new NetworksRequestRemovePeeringRequest();
    $request = (new RequestRemovePeeringNetworkRequest())
        ->setNetwork($network)
        ->setNetworksRequestRemovePeeringRequestResource($networksRequestRemovePeeringRequestResource)
        ->setProject($project);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $networksClient->requestRemovePeering($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
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
    $network = '[NETWORK]';
    $project = '[PROJECT]';

    request_remove_peering_sample($network, $project);
}
// [END compute_v1_generated_Networks_RequestRemovePeering_sync]
