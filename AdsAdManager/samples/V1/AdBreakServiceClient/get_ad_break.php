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

// [START admanager_v1_generated_AdBreakService_GetAdBreak_sync]
use Google\Ads\AdManager\V1\AdBreak;
use Google\Ads\AdManager\V1\Client\AdBreakServiceClient;
use Google\Ads\AdManager\V1\GetAdBreakRequest;
use Google\ApiCore\ApiException;

/**
 * API to retrieve an `AdBreak` object.
 *
 * Query an ad break by its resource name or custom asset key. Check the
 * resource's `breakState` field to determine its state.
 *
 * @param string $formattedName The resource name of the AdBreak using the asset key or custom
 *                              asset key.
 *
 *                              Format:
 *                              `networks/{network_code}/liveStreamEventsByAssetKey/{asset_key}/adBreaks/{ad_break_id}`
 *                              `networks/{network_code}/liveStreamEventsByCustomAssetKey/{custom_asset_key}/adBreaks/{ad_break_id}`
 *                              Please see {@see AdBreakServiceClient::adBreakName()} for help formatting this field.
 */
function get_ad_break_sample(string $formattedName): void
{
    // Create a client.
    $adBreakServiceClient = new AdBreakServiceClient();

    // Prepare the request message.
    $request = (new GetAdBreakRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var AdBreak $response */
        $response = $adBreakServiceClient->getAdBreak($request);
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
    $formattedName = AdBreakServiceClient::adBreakName('[NETWORK_CODE]', '[ASSET_KEY]', '[AD_BREAK]');

    get_ad_break_sample($formattedName);
}
// [END admanager_v1_generated_AdBreakService_GetAdBreak_sync]
