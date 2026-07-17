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

// [START admanager_v1_generated_LiveStreamService_BatchPauseAdsLiveStreams_sync]
use Google\Ads\AdManager\V1\BatchPauseAdsLiveStreamsRequest;
use Google\Ads\AdManager\V1\BatchPauseAdsLiveStreamsResponse;
use Google\Ads\AdManager\V1\Client\LiveStreamServiceClient;
use Google\ApiCore\ApiException;

/**
 * Batch pauses ads on `LiveStream` objects.
 *
 * @param string $formattedParent       Format: `networks/{network_code}`
 *                                      Please see {@see LiveStreamServiceClient::networkName()} for help formatting this field.
 * @param string $formattedNamesElement The resource names of the `LiveStream`s to pause ads on.
 *                                      Format: `networks/{network_code}/liveStreams/{live_stream_id}`
 *                                      Please see {@see LiveStreamServiceClient::liveStreamName()} for help formatting this field.
 */
function batch_pause_ads_live_streams_sample(
    string $formattedParent,
    string $formattedNamesElement
): void {
    // Create a client.
    $liveStreamServiceClient = new LiveStreamServiceClient();

    // Prepare the request message.
    $formattedNames = [$formattedNamesElement,];
    $request = (new BatchPauseAdsLiveStreamsRequest())
        ->setParent($formattedParent)
        ->setNames($formattedNames);

    // Call the API and handle any network failures.
    try {
        /** @var BatchPauseAdsLiveStreamsResponse $response */
        $response = $liveStreamServiceClient->batchPauseAdsLiveStreams($request);
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
    $formattedParent = LiveStreamServiceClient::networkName('[NETWORK_CODE]');
    $formattedNamesElement = LiveStreamServiceClient::liveStreamName('[NETWORK_CODE]', '[LIVE_STREAM]');

    batch_pause_ads_live_streams_sample($formattedParent, $formattedNamesElement);
}
// [END admanager_v1_generated_LiveStreamService_BatchPauseAdsLiveStreams_sync]
