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

// [START videostitcher_v1_generated_VideoStitcherService_CreateLiveSession_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Video\Stitcher\V1\Client\VideoStitcherServiceClient;
use Google\Cloud\Video\Stitcher\V1\CreateLiveSessionRequest;
use Google\Cloud\Video\Stitcher\V1\LiveSession;

/**
 * Creates a new live session.
 *
 * @param string $formattedParent                The project and location in which the live session should be
 *                                               created, in the form of `projects/{project_number}/locations/{location}`. Please see
 *                                               {@see VideoStitcherServiceClient::locationName()} for help formatting this field.
 * @param string $formattedLiveSessionLiveConfig The resource name of the live config for this session, in the
 *                                               form of `projects/{project}/locations/{location}/liveConfigs/{id}`. Please see
 *                                               {@see VideoStitcherServiceClient::liveConfigName()} for help formatting this field.
 */
function create_live_session_sample(
    string $formattedParent,
    string $formattedLiveSessionLiveConfig
): void {
    // Create a client.
    $videoStitcherServiceClient = new VideoStitcherServiceClient();

    // Prepare the request message.
    $liveSession = (new LiveSession())
        ->setLiveConfig($formattedLiveSessionLiveConfig);
    $request = (new CreateLiveSessionRequest())
        ->setParent($formattedParent)
        ->setLiveSession($liveSession);

    // Call the API and handle any network failures.
    try {
        /** @var LiveSession $response */
        $response = $videoStitcherServiceClient->createLiveSession($request);
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
    $formattedLiveSessionLiveConfig = VideoStitcherServiceClient::liveConfigName(
        '[PROJECT]',
        '[LOCATION]',
        '[LIVE_CONFIG]'
    );

    create_live_session_sample($formattedParent, $formattedLiveSessionLiveConfig);
}
// [END videostitcher_v1_generated_VideoStitcherService_CreateLiveSession_sync]
