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

// [START devicestreaming_v1_generated_DirectAccessService_CreateDeviceSession_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DeviceStreaming\V1\AndroidDevice;
use Google\Cloud\DeviceStreaming\V1\Client\DirectAccessServiceClient;
use Google\Cloud\DeviceStreaming\V1\CreateDeviceSessionRequest;
use Google\Cloud\DeviceStreaming\V1\DeviceSession;

/**
 * Creates a DeviceSession.
 *
 * @param string $formattedParent                            The Compute Engine project under which this device will be
 *                                                           allocated. "projects/{project_id}"
 *                                                           Please see {@see DirectAccessServiceClient::projectName()} for help formatting this field.
 * @param string $deviceSessionAndroidDeviceAndroidModelId   The id of the Android device to be used.
 *                                                           Use the TestEnvironmentDiscoveryService to get supported options.
 * @param string $deviceSessionAndroidDeviceAndroidVersionId The id of the Android OS version to be used.
 *                                                           Use the TestEnvironmentDiscoveryService to get supported options.
 */
function create_device_session_sample(
    string $formattedParent,
    string $deviceSessionAndroidDeviceAndroidModelId,
    string $deviceSessionAndroidDeviceAndroidVersionId
): void {
    // Create a client.
    $directAccessServiceClient = new DirectAccessServiceClient();

    // Prepare the request message.
    $deviceSessionAndroidDevice = (new AndroidDevice())
        ->setAndroidModelId($deviceSessionAndroidDeviceAndroidModelId)
        ->setAndroidVersionId($deviceSessionAndroidDeviceAndroidVersionId);
    $deviceSession = (new DeviceSession())
        ->setAndroidDevice($deviceSessionAndroidDevice);
    $request = (new CreateDeviceSessionRequest())
        ->setParent($formattedParent)
        ->setDeviceSession($deviceSession);

    // Call the API and handle any network failures.
    try {
        /** @var DeviceSession $response */
        $response = $directAccessServiceClient->createDeviceSession($request);
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
    $formattedParent = DirectAccessServiceClient::projectName('[PROJECT]');
    $deviceSessionAndroidDeviceAndroidModelId = '[ANDROID_MODEL_ID]';
    $deviceSessionAndroidDeviceAndroidVersionId = '[ANDROID_VERSION_ID]';

    create_device_session_sample(
        $formattedParent,
        $deviceSessionAndroidDeviceAndroidModelId,
        $deviceSessionAndroidDeviceAndroidVersionId
    );
}
// [END devicestreaming_v1_generated_DirectAccessService_CreateDeviceSession_sync]
