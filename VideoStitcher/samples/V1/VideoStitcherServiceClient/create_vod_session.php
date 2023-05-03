<?php
/*
 * Copyright 2022 Google LLC
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

// [START videostitcher_v1_generated_VideoStitcherService_CreateVodSession_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Video\Stitcher\V1\AdTracking;
use Google\Cloud\Video\Stitcher\V1\VideoStitcherServiceClient;
use Google\Cloud\Video\Stitcher\V1\VodSession;

/**
 * Creates a client side playback VOD session and returns the full
 * tracking and playback metadata of the session.
 *
 * @param string $formattedParent      The project and location in which the VOD session should be
 *                                     created, in the form of `projects/{project_number}/locations/{location}`. Please see
 *                                     {@see VideoStitcherServiceClient::locationName()} for help formatting this field.
 * @param string $vodSessionSourceUri  URI of the media to stitch.
 * @param string $vodSessionAdTagUri   Ad tag URI.
 * @param int    $vodSessionAdTracking Determines how the ad should be tracked. If
 *                                     [gam_vod_config][google.cloud.video.stitcher.v1.VodSession.gam_vod_config]
 *                                     is set, the value must be `CLIENT` because the IMA SDK handles ad tracking.
 */
function create_vod_session_sample(
    string $formattedParent,
    string $vodSessionSourceUri,
    string $vodSessionAdTagUri,
    int $vodSessionAdTracking
): void {
    // Create a client.
    $videoStitcherServiceClient = new VideoStitcherServiceClient();

    // Prepare the request message.
    $vodSession = (new VodSession())
        ->setSourceUri($vodSessionSourceUri)
        ->setAdTagUri($vodSessionAdTagUri)
        ->setAdTracking($vodSessionAdTracking);

    // Call the API and handle any network failures.
    try {
        /** @var VodSession $response */
        $response = $videoStitcherServiceClient->createVodSession($formattedParent, $vodSession);
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
    $formattedParent = VideoStitcherServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $vodSessionSourceUri = '[SOURCE_URI]';
    $vodSessionAdTagUri = '[AD_TAG_URI]';
    $vodSessionAdTracking = AdTracking::AD_TRACKING_UNSPECIFIED;

    create_vod_session_sample(
        $formattedParent,
        $vodSessionSourceUri,
        $vodSessionAdTagUri,
        $vodSessionAdTracking
    );
}
// [END videostitcher_v1_generated_VideoStitcherService_CreateVodSession_sync]
