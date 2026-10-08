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

// [START netapp_v1_generated_NetApp_GetSplitStatus_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\NetApp\V1\Client\NetAppClient;
use Google\Cloud\NetApp\V1\GetSplitStatusRequest;
use Google\Cloud\NetApp\V1\SplitStatus;

/**
 * Retrieves the current state, progress, and details of a split operation for
 * a volume. This method is relevant when the volume is a clone. For volumes
 * that are not clones, this method will return an error.
 *
 * @param string $formattedName The full name of the volume.
 *                              Format: projects/{project_number}/locations/{location}/volumes/{volume_id}
 *                              Please see {@see NetAppClient::volumeName()} for help formatting this field.
 */
function get_split_status_sample(string $formattedName): void
{
    // Create a client.
    $netAppClient = new NetAppClient();

    // Prepare the request message.
    $request = (new GetSplitStatusRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var SplitStatus $response */
        $response = $netAppClient->getSplitStatus($request);
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
    $formattedName = NetAppClient::volumeName('[PROJECT]', '[LOCATION]', '[VOLUME]');

    get_split_status_sample($formattedName);
}
// [END netapp_v1_generated_NetApp_GetSplitStatus_sync]
