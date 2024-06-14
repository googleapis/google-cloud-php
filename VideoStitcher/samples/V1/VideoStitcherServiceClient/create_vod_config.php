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

// [START videostitcher_v1_generated_VideoStitcherService_CreateVodConfig_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Video\Stitcher\V1\Client\VideoStitcherServiceClient;
use Google\Cloud\Video\Stitcher\V1\CreateVodConfigRequest;
use Google\Cloud\Video\Stitcher\V1\VodConfig;
use Google\Rpc\Status;

/**
 * Registers the VOD config with the provided unique ID in
 * the specified region.
 *
 * @param string $formattedParent    The project in which the VOD config should be created, in
 *                                   the form of `projects/{project_number}/locations/{location}`. Please see
 *                                   {@see VideoStitcherServiceClient::locationName()} for help formatting this field.
 * @param string $vodConfigId        The unique identifier ID to use for the VOD config.
 * @param string $vodConfigSourceUri Source URI for the VOD stream manifest.
 * @param string $vodConfigAdTagUri  The default ad tag associated with this VOD config.
 */
function create_vod_config_sample(
    string $formattedParent,
    string $vodConfigId,
    string $vodConfigSourceUri,
    string $vodConfigAdTagUri
): void {
    // Create a client.
    $videoStitcherServiceClient = new VideoStitcherServiceClient();

    // Prepare the request message.
    $vodConfig = (new VodConfig())
        ->setSourceUri($vodConfigSourceUri)
        ->setAdTagUri($vodConfigAdTagUri);
    $request = (new CreateVodConfigRequest())
        ->setParent($formattedParent)
        ->setVodConfigId($vodConfigId)
        ->setVodConfig($vodConfig);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $videoStitcherServiceClient->createVodConfig($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var VodConfig $result */
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
    $vodConfigId = '[VOD_CONFIG_ID]';
    $vodConfigSourceUri = '[SOURCE_URI]';
    $vodConfigAdTagUri = '[AD_TAG_URI]';

    create_vod_config_sample($formattedParent, $vodConfigId, $vodConfigSourceUri, $vodConfigAdTagUri);
}
// [END videostitcher_v1_generated_VideoStitcherService_CreateVodConfig_sync]
