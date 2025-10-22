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

// [START admanager_v1_generated_PlacementService_BatchUpdatePlacements_sync]
use Google\Ads\AdManager\V1\BatchUpdatePlacementsRequest;
use Google\Ads\AdManager\V1\BatchUpdatePlacementsResponse;
use Google\Ads\AdManager\V1\Client\PlacementServiceClient;
use Google\Ads\AdManager\V1\Placement;
use Google\Ads\AdManager\V1\UpdatePlacementRequest;
use Google\ApiCore\ApiException;
use Google\Protobuf\FieldMask;

/**
 * API to batch update `Placement` objects.
 *
 * @param string $formattedParent              The parent resource where `Placements` will be updated.
 *                                             Format: `networks/{network_code}`
 *                                             The parent field in the UpdatePlacementsRequest must match this
 *                                             field. Please see
 *                                             {@see PlacementServiceClient::networkName()} for help formatting this field.
 * @param string $requestsPlacementDisplayName The display name of the placement. This attribute has a maximum
 *                                             length of 255 characters.
 */
function batch_update_placements_sample(
    string $formattedParent,
    string $requestsPlacementDisplayName
): void {
    // Create a client.
    $placementServiceClient = new PlacementServiceClient();

    // Prepare the request message.
    $requestsPlacement = (new Placement())
        ->setDisplayName($requestsPlacementDisplayName);
    $requestsUpdateMask = new FieldMask();
    $updatePlacementRequest = (new UpdatePlacementRequest())
        ->setPlacement($requestsPlacement)
        ->setUpdateMask($requestsUpdateMask);
    $requests = [$updatePlacementRequest,];
    $request = (new BatchUpdatePlacementsRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchUpdatePlacementsResponse $response */
        $response = $placementServiceClient->batchUpdatePlacements($request);
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
    $requestsPlacementDisplayName = '[DISPLAY_NAME]';

    batch_update_placements_sample($formattedParent, $requestsPlacementDisplayName);
}
// [END admanager_v1_generated_PlacementService_BatchUpdatePlacements_sync]
