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

// [START admanager_v1_generated_AdBreakService_DeleteAdBreak_sync]
use Google\Ads\AdManager\V1\Client\AdBreakServiceClient;
use Google\Ads\AdManager\V1\DeleteAdBreakRequest;
use Google\ApiCore\ApiException;

/**
 * API to delete an `AdBreak` object.
 *
 * Deletes and cancels an incomplete ad break, mitigating the need to wait
 * for the current break to serve before recreating an ad break. You can
 * delete an ad break that has not started serving or seen in manifests,
 * indicated by its state being
 * [`SCHEDULED`][google.ads.admanager.v1.AdBreakStateEnum.AdBreakState.SCHEDULED]
 * or
 * [`DECISIONED`][google.ads.admanager.v1.AdBreakStateEnum.AdBreakState.DECISIONED].
 *
 * @param string $formattedName The name of the ad break to delete.
 *
 *                              Format:
 *                              `networks/{network_code}/liveStreamEventsByAssetKey/{asset_key}/adBreaks/{ad_break}`
 *                              Please see {@see AdBreakServiceClient::adBreakName()} for help formatting this field.
 */
function delete_ad_break_sample(string $formattedName): void
{
    // Create a client.
    $adBreakServiceClient = new AdBreakServiceClient();

    // Prepare the request message.
    $request = (new DeleteAdBreakRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $adBreakServiceClient->deleteAdBreak($request);
        printf('Call completed successfully.' . PHP_EOL);
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

    delete_ad_break_sample($formattedName);
}
// [END admanager_v1_generated_AdBreakService_DeleteAdBreak_sync]
