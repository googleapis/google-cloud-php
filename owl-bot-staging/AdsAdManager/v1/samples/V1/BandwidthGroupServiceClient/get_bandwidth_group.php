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

// [START admanager_v1_generated_BandwidthGroupService_GetBandwidthGroup_sync]
use Google\Ads\AdManager\V1\BandwidthGroup;
use Google\Ads\AdManager\V1\Client\BandwidthGroupServiceClient;
use Google\Ads\AdManager\V1\GetBandwidthGroupRequest;
use Google\ApiCore\ApiException;

/**
 * API to retrieve a `BandwidthGroup` object.
 *
 * @param string $formattedName The resource name of the BandwidthGroup.
 *                              Format: `networks/{network_code}/bandwidthGroups/{bandwidth_group_id}`
 *                              Please see {@see BandwidthGroupServiceClient::bandwidthGroupName()} for help formatting this field.
 */
function get_bandwidth_group_sample(string $formattedName): void
{
    // Create a client.
    $bandwidthGroupServiceClient = new BandwidthGroupServiceClient();

    // Prepare the request message.
    $request = (new GetBandwidthGroupRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var BandwidthGroup $response */
        $response = $bandwidthGroupServiceClient->getBandwidthGroup($request);
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
    $formattedName = BandwidthGroupServiceClient::bandwidthGroupName(
        '[NETWORK_CODE]',
        '[BANDWIDTH_GROUP]'
    );

    get_bandwidth_group_sample($formattedName);
}
// [END admanager_v1_generated_BandwidthGroupService_GetBandwidthGroup_sync]
