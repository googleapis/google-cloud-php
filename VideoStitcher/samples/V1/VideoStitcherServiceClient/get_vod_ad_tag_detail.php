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

// [START videostitcher_v1_generated_VideoStitcherService_GetVodAdTagDetail_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Video\Stitcher\V1\VideoStitcherServiceClient;
use Google\Cloud\Video\Stitcher\V1\VodAdTagDetail;

/**
 * Returns the specified ad tag detail for the specified VOD session.
 *
 * @param string $formattedName The name of the ad tag detail for the specified VOD session, in
 *                              the form of
 *                              `projects/{project}/locations/{location}/vodSessions/{vod_session_id}/vodAdTagDetails/{vod_ad_tag_detail}`. Please see
 *                              {@see VideoStitcherServiceClient::vodAdTagDetailName()} for help formatting this field.
 */
function get_vod_ad_tag_detail_sample(string $formattedName): void
{
    // Create a client.
    $videoStitcherServiceClient = new VideoStitcherServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var VodAdTagDetail $response */
        $response = $videoStitcherServiceClient->getVodAdTagDetail($formattedName);
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
    $formattedName = VideoStitcherServiceClient::vodAdTagDetailName(
        '[PROJECT]',
        '[LOCATION]',
        '[VOD_SESSION]',
        '[VOD_AD_TAG_DETAIL]'
    );

    get_vod_ad_tag_detail_sample($formattedName);
}
// [END videostitcher_v1_generated_VideoStitcherService_GetVodAdTagDetail_sync]
