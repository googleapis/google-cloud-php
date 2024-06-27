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

// [START videostitcher_v1_generated_VideoStitcherService_DeleteVodConfig_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Video\Stitcher\V1\Client\VideoStitcherServiceClient;
use Google\Cloud\Video\Stitcher\V1\DeleteVodConfigRequest;
use Google\Rpc\Status;

/**
 * Deletes the specified VOD config.
 *
 * @param string $formattedName The name of the VOD config to be deleted, in the form of
 *                              `projects/{project_number}/locations/{location}/vodConfigs/{id}`. Please see
 *                              {@see VideoStitcherServiceClient::vodConfigName()} for help formatting this field.
 */
function delete_vod_config_sample(string $formattedName): void
{
    // Create a client.
    $videoStitcherServiceClient = new VideoStitcherServiceClient();

    // Prepare the request message.
    $request = (new DeleteVodConfigRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $videoStitcherServiceClient->deleteVodConfig($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
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
    $formattedName = VideoStitcherServiceClient::vodConfigName(
        '[PROJECT]',
        '[LOCATION]',
        '[VOD_CONFIG]'
    );

    delete_vod_config_sample($formattedName);
}
// [END videostitcher_v1_generated_VideoStitcherService_DeleteVodConfig_sync]
