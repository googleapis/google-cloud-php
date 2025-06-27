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

// [START admanager_v1_generated_AdBreakService_CreateAdBreak_sync]
use Google\Ads\AdManager\V1\AdBreak;
use Google\Ads\AdManager\V1\Client\AdBreakServiceClient;
use Google\Ads\AdManager\V1\CreateAdBreakRequest;
use Google\ApiCore\ApiException;
use Google\Protobuf\Duration;

/**
 * API to create an `AdBreak` object.
 *
 * Informs DAI of an upcoming ad break for a live stream event, with an
 * optional expected start time. DAI will begin decisioning ads for the break
 * shortly before the expected start time, if provided. Each live stream
 * event can only have one incomplete ad break at any given time. The next ad
 * break can be scheduled after the previous ad break has started serving,
 * indicated by its state being
 * [`COMPLETE`][google.ads.admanager.v1.AdBreakStateEnum.AdBreakState.COMPLETE],
 * or it has been deleted.
 *
 * This method cannot be used if the `LiveStreamEvent` has
 * [prefetching ad breaks
 * enabled](https://developers.google.com/ad-manager/api/reference/latest/LiveStreamEventService.LiveStreamEvent#prefetchenabled)
 * or the event is not active. If a `LiveStreamEvent` is deactivated after
 * creating an ad break and before the ad break is complete, the ad break
 * is discarded.
 *
 * An ad break's state is complete when the following occurs:
 * - Full service DAI: after a matching ad break shows in the
 * `LiveStreamEvent` manifest only when the ad break has started decisioning.
 * - Pod Serving: after the ad break is requested using the ad break ID or
 * break sequence.
 *
 * @param string $formattedParent The parent resource where this `AdBreak` will be created
 *                                identified by an asset key or custom asset key.
 *
 *                                Formats:
 *                                `networks/{network_code}/liveStreamEventsByAssetKey/{asset_key}`
 *                                `networks/{network_code}/liveStreamEventsByCustomAssetKey/{custom_asset_key}`
 *                                Please see {@see AdBreakServiceClient::liveStreamEventName()} for help formatting this field.
 */
function create_ad_break_sample(string $formattedParent): void
{
    // Create a client.
    $adBreakServiceClient = new AdBreakServiceClient();

    // Prepare the request message.
    $adBreakDuration = new Duration();
    $adBreak = (new AdBreak())
        ->setDuration($adBreakDuration);
    $request = (new CreateAdBreakRequest())
        ->setParent($formattedParent)
        ->setAdBreak($adBreak);

    // Call the API and handle any network failures.
    try {
        /** @var AdBreak $response */
        $response = $adBreakServiceClient->createAdBreak($request);
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
    $formattedParent = AdBreakServiceClient::liveStreamEventName(
        '[NETWORK_CODE]',
        '[LIVE_STREAM_EVENT]'
    );

    create_ad_break_sample($formattedParent);
}
// [END admanager_v1_generated_AdBreakService_CreateAdBreak_sync]
