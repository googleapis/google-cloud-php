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

// [START admanager_v1_generated_AdBreakService_ListAdBreaks_sync]
use Google\Ads\AdManager\V1\Client\AdBreakServiceClient;
use Google\Ads\AdManager\V1\ListAdBreaksRequest;
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;

/**
 * API to retrieve a list of `AdBreak` objects.
 *
 * By default, when no `orderBy` query parameter is specified, ad breaks are
 * ordered reverse chronologically. However, ad breaks with a 'breakState' of
 * 'SCHEDULED' or 'DECISIONED' are prioritized and appear first.
 *
 * @param string $formattedParent The parent, which owns this collection of AdBreaks.
 *
 *                                Formats:
 *                                `networks/{network_code}/liveStreamEventsByAssetKey/{asset_key}`
 *                                `networks/{network_code}/liveStreamEventsByCustomAssetKey/{custom_asset_key}`
 *                                Please see {@see AdBreakServiceClient::liveStreamEventName()} for help formatting this field.
 */
function list_ad_breaks_sample(string $formattedParent): void
{
    // Create a client.
    $adBreakServiceClient = new AdBreakServiceClient();

    // Prepare the request message.
    $request = (new ListAdBreaksRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $adBreakServiceClient->listAdBreaks($request);

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
    $formattedParent = AdBreakServiceClient::liveStreamEventName(
        '[NETWORK_CODE]',
        '[LIVE_STREAM_EVENT]'
    );

    list_ad_breaks_sample($formattedParent);
}
// [END admanager_v1_generated_AdBreakService_ListAdBreaks_sync]
