<?php
/*
 * Copyright 2026 Google LLC
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

// [START admanager_v1_generated_SuggestedAdUnitService_ListSuggestedAdUnits_sync]
use Google\Ads\AdManager\V1\Client\SuggestedAdUnitServiceClient;
use Google\Ads\AdManager\V1\ListSuggestedAdUnitsRequest;
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;

/**
 * Retrieve a list of `SuggestedAdUnit` objects.
 *
 * @param string $formattedParent The parent, which owns this collection of SuggestedAdUnits.
 *                                Format: `networks/{network_code}`
 *                                Please see {@see SuggestedAdUnitServiceClient::networkName()} for help formatting this field.
 */
function list_suggested_ad_units_sample(string $formattedParent): void
{
    // Create a client.
    $suggestedAdUnitServiceClient = new SuggestedAdUnitServiceClient();

    // Prepare the request message.
    $request = (new ListSuggestedAdUnitsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $suggestedAdUnitServiceClient->listSuggestedAdUnits($request);

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
    $formattedParent = SuggestedAdUnitServiceClient::networkName('[NETWORK_CODE]');

    list_suggested_ad_units_sample($formattedParent);
}
// [END admanager_v1_generated_SuggestedAdUnitService_ListSuggestedAdUnits_sync]
