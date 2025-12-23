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

// [START admanager_v1_generated_AdUnitService_BatchUpdateAdUnits_sync]
use Google\Ads\AdManager\V1\AdUnit;
use Google\Ads\AdManager\V1\BatchUpdateAdUnitsRequest;
use Google\Ads\AdManager\V1\BatchUpdateAdUnitsResponse;
use Google\Ads\AdManager\V1\Client\AdUnitServiceClient;
use Google\Ads\AdManager\V1\UpdateAdUnitRequest;
use Google\ApiCore\ApiException;
use Google\Protobuf\FieldMask;

/**
 * API to batch update `AdUnit` objects.
 *
 * @param string $formattedParent                     The parent resource where `AdUnits` will be updated.
 *                                                    Format: `networks/{network_code}`
 *                                                    The parent field in the UpdateAdUnitRequest must match this
 *                                                    field. Please see
 *                                                    {@see AdUnitServiceClient::networkName()} for help formatting this field.
 * @param string $formattedRequestsAdUnitParentAdUnit Immutable. The AdUnit's parent. Every ad unit has a parent except
 *                                                    for the root ad unit, which is created by Google. Format:
 *                                                    "networks/{network_code}/adUnits/{ad_unit_id}"
 *                                                    Please see {@see AdUnitServiceClient::adUnitName()} for help formatting this field.
 * @param string $requestsAdUnitDisplayName           The display name of the ad unit. Its maximum length is 255
 *                                                    characters.
 */
function batch_update_ad_units_sample(
    string $formattedParent,
    string $formattedRequestsAdUnitParentAdUnit,
    string $requestsAdUnitDisplayName
): void {
    // Create a client.
    $adUnitServiceClient = new AdUnitServiceClient();

    // Prepare the request message.
    $requestsAdUnit = (new AdUnit())
        ->setParentAdUnit($formattedRequestsAdUnitParentAdUnit)
        ->setDisplayName($requestsAdUnitDisplayName);
    $requestsUpdateMask = new FieldMask();
    $updateAdUnitRequest = (new UpdateAdUnitRequest())
        ->setAdUnit($requestsAdUnit)
        ->setUpdateMask($requestsUpdateMask);
    $requests = [$updateAdUnitRequest,];
    $request = (new BatchUpdateAdUnitsRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchUpdateAdUnitsResponse $response */
        $response = $adUnitServiceClient->batchUpdateAdUnits($request);
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
    $formattedParent = AdUnitServiceClient::networkName('[NETWORK_CODE]');
    $formattedRequestsAdUnitParentAdUnit = AdUnitServiceClient::adUnitName(
        '[NETWORK_CODE]',
        '[AD_UNIT]'
    );
    $requestsAdUnitDisplayName = '[DISPLAY_NAME]';

    batch_update_ad_units_sample(
        $formattedParent,
        $formattedRequestsAdUnitParentAdUnit,
        $requestsAdUnitDisplayName
    );
}
// [END admanager_v1_generated_AdUnitService_BatchUpdateAdUnits_sync]
