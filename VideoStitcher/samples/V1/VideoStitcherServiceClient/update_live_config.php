<?php
/*
 * Copyright 2024 Google LLC
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

// [START videostitcher_v1_generated_VideoStitcherService_UpdateLiveConfig_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Video\Stitcher\V1\AdTracking;
use Google\Cloud\Video\Stitcher\V1\Client\VideoStitcherServiceClient;
use Google\Cloud\Video\Stitcher\V1\LiveConfig;
use Google\Cloud\Video\Stitcher\V1\UpdateLiveConfigRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates the specified LiveConfig. Only update fields specified
 * in the call method body.
 *
 * @param string $liveConfigSourceUri  Source URI for the live stream manifest.
 * @param int    $liveConfigAdTracking Determines how the ads are tracked.
 */
function update_live_config_sample(string $liveConfigSourceUri, int $liveConfigAdTracking): void
{
    // Create a client.
    $videoStitcherServiceClient = new VideoStitcherServiceClient();

    // Prepare the request message.
    $liveConfig = (new LiveConfig())
        ->setSourceUri($liveConfigSourceUri)
        ->setAdTracking($liveConfigAdTracking);
    $updateMask = new FieldMask();
    $request = (new UpdateLiveConfigRequest())
        ->setLiveConfig($liveConfig)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $videoStitcherServiceClient->updateLiveConfig($request);
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
    $liveConfigSourceUri = '[SOURCE_URI]';
    $liveConfigAdTracking = AdTracking::AD_TRACKING_UNSPECIFIED;

    update_live_config_sample($liveConfigSourceUri, $liveConfigAdTracking);
}
// [END videostitcher_v1_generated_VideoStitcherService_UpdateLiveConfig_sync]
