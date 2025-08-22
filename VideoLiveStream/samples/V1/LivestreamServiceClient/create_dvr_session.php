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

// [START livestream_v1_generated_LivestreamService_CreateDvrSession_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Video\LiveStream\V1\Client\LivestreamServiceClient;
use Google\Cloud\Video\LiveStream\V1\CreateDvrSessionRequest;
use Google\Cloud\Video\LiveStream\V1\DvrSession;
use Google\Cloud\Video\LiveStream\V1\DvrSession\DvrManifest;
use Google\Cloud\Video\LiveStream\V1\DvrSession\DvrWindow;
use Google\Rpc\Status;

/**
 * Creates a DVR session with the provided unique ID in the specified channel.
 *
 * @param string $formattedParent                   The parent resource name, in the following form:
 *                                                  `projects/{project}/locations/{location}/channels/{channelId}`. Please see
 *                                                  {@see LivestreamServiceClient::channelName()} for help formatting this field.
 * @param string $dvrSessionId                      Id of the requesting object in the following form:
 *
 *                                                  1. 1 character minimum, 63 characters maximum
 *                                                  2. Only contains letters, digits, underscores, and hyphens
 * @param string $dvrSessionDvrManifestsManifestKey A unique key that identifies a manifest config in the parent
 *                                                  channel. This key is the same as `channel.manifests.key` for the selected
 *                                                  manifest.
 */
function create_dvr_session_sample(
    string $formattedParent,
    string $dvrSessionId,
    string $dvrSessionDvrManifestsManifestKey
): void {
    // Create a client.
    $livestreamServiceClient = new LivestreamServiceClient();

    // Prepare the request message.
    $dvrManifest = (new DvrManifest())
        ->setManifestKey($dvrSessionDvrManifestsManifestKey);
    $dvrSessionDvrManifests = [$dvrManifest,];
    $dvrSessionDvrWindows = [new DvrWindow()];
    $dvrSession = (new DvrSession())
        ->setDvrManifests($dvrSessionDvrManifests)
        ->setDvrWindows($dvrSessionDvrWindows);
    $request = (new CreateDvrSessionRequest())
        ->setParent($formattedParent)
        ->setDvrSessionId($dvrSessionId)
        ->setDvrSession($dvrSession);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $livestreamServiceClient->createDvrSession($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var DvrSession $result */
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
    $formattedParent = LivestreamServiceClient::channelName('[PROJECT]', '[LOCATION]', '[CHANNEL]');
    $dvrSessionId = '[DVR_SESSION_ID]';
    $dvrSessionDvrManifestsManifestKey = '[MANIFEST_KEY]';

    create_dvr_session_sample($formattedParent, $dvrSessionId, $dvrSessionDvrManifestsManifestKey);
}
// [END livestream_v1_generated_LivestreamService_CreateDvrSession_sync]
