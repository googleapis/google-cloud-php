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

// [START admanager_v1_generated_PlacementService_BatchCreatePlacements_sync]
use Google\Ads\AdManager\V1\BatchCreatePlacementsRequest;
use Google\Ads\AdManager\V1\BatchCreatePlacementsResponse;
use Google\Ads\AdManager\V1\Client\PlacementServiceClient;
use Google\Ads\AdManager\V1\CreatePlacementRequest;
use Google\Ads\AdManager\V1\Placement;
use Google\ApiCore\ApiException;

/**
 * API to batch create `Placement` objects.
 *
 * @param string $formattedParent              The parent resource where the `Placement`s will be created.
 *                                             Format: `networks/{network_code}`
 *                                             The parent field in the CreatePlacementRequest messages match this
 *                                             field. Please see
 *                                             {@see PlacementServiceClient::networkName()} for help formatting this field.
 * @param string $formattedRequestsParent      The parent resource where this `Placement` will be created.
 *                                             Format: `networks/{network_code}`
 *                                             Please see {@see PlacementServiceClient::networkName()} for help formatting this field.
 * @param string $requestsPlacementDisplayName The display name of the placement. This attribute has a maximum
 *                                             length of 255 characters.
 */
function batch_create_placements_sample(
    string $formattedParent,
    string $formattedRequestsParent,
    string $requestsPlacementDisplayName
): void {
    // Create a client.
    $placementServiceClient = new PlacementServiceClient();

    // Prepare the request message.
    $requestsPlacement = (new Placement())
        ->setDisplayName($requestsPlacementDisplayName);
    $createPlacementRequest = (new CreatePlacementRequest())
        ->setParent($formattedRequestsParent)
        ->setPlacement($requestsPlacement);
    $requests = [$createPlacementRequest,];
    $request = (new BatchCreatePlacementsRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchCreatePlacementsResponse $response */
        $response = $placementServiceClient->batchCreatePlacements($request);
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
    $formattedParent = PlacementServiceClient::networkName('[NETWORK_CODE]');
    $formattedRequestsParent = PlacementServiceClient::networkName('[NETWORK_CODE]');
    $requestsPlacementDisplayName = '[DISPLAY_NAME]';

    batch_create_placements_sample(
        $formattedParent,
        $formattedRequestsParent,
        $requestsPlacementDisplayName
    );
}
// [END admanager_v1_generated_PlacementService_BatchCreatePlacements_sync]
