<?php
/*
 * Copyright 2023 Google LLC
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

// [START videostitcher_v1_generated_VideoStitcherService_CreateLiveConfig_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Video\Stitcher\V1\AdTracking;
use Google\Cloud\Video\Stitcher\V1\LiveConfig;
use Google\Cloud\Video\Stitcher\V1\VideoStitcherServiceClient;
use Google\Rpc\Status;

/**
 * Registers the live config with the provided unique ID in
 * the specified region.
 *
 * @param string $formattedParent      The project in which the live config should be created, in
 *                                     the form of `projects/{project_number}/locations/{location}`. Please see
 *                                     {@see VideoStitcherServiceClient::locationName()} for help formatting this field.
 * @param string $liveConfigId         The unique identifier ID to use for the live config.
 * @param string $liveConfigSourceUri  Source URI for the live stream manifest.
 * @param int    $liveConfigAdTracking Determines how the ads are tracked. If
 *                                     [gam_live_config][google.cloud.video.stitcher.v1.LiveConfig.gam_live_config]
 *                                     is set, the value must be `CLIENT` because the IMA SDK handles ad tracking.
 */
function create_live_config_sample(
    string $formattedParent,
    string $liveConfigId,
    string $liveConfigSourceUri,
    int $liveConfigAdTracking
): void {
    // Create a client.
    $videoStitcherServiceClient = new VideoStitcherServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $liveConfig = (new LiveConfig())
        ->setSourceUri($liveConfigSourceUri)
        ->setAdTracking($liveConfigAdTracking);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $videoStitcherServiceClient->createLiveConfig(
            $formattedParent,
            $liveConfigId,
            $liveConfig
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var LiveConfig $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
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
    $formattedParent = VideoStitcherServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $liveConfigId = '[LIVE_CONFIG_ID]';
    $liveConfigSourceUri = '[SOURCE_URI]';
    $liveConfigAdTracking = AdTracking::AD_TRACKING_UNSPECIFIED;

    create_live_config_sample(
        $formattedParent,
        $liveConfigId,
        $liveConfigSourceUri,
        $liveConfigAdTracking
    );
}
// [END videostitcher_v1_generated_VideoStitcherService_CreateLiveConfig_sync]
