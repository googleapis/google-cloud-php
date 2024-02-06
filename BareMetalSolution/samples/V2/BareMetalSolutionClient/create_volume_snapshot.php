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

// [START baremetalsolution_v2_generated_BareMetalSolution_CreateVolumeSnapshot_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BareMetalSolution\V2\Client\BareMetalSolutionClient;
use Google\Cloud\BareMetalSolution\V2\CreateVolumeSnapshotRequest;
use Google\Cloud\BareMetalSolution\V2\VolumeSnapshot;

/**
 * Takes a snapshot of a boot volume.
 * Returns INVALID_ARGUMENT if called for a non-boot volume.
 *
 * @param string $formattedParent The volume to snapshot. Please see
 *                                {@see BareMetalSolutionClient::volumeName()} for help formatting this field.
 */
function create_volume_snapshot_sample(string $formattedParent): void
{
    // Create a client.
    $bareMetalSolutionClient = new BareMetalSolutionClient();

    // Prepare the request message.
    $volumeSnapshot = new VolumeSnapshot();
    $request = (new CreateVolumeSnapshotRequest())
        ->setParent($formattedParent)
        ->setVolumeSnapshot($volumeSnapshot);

    // Call the API and handle any network failures.
    try {
        /** @var VolumeSnapshot $response */
        $response = $bareMetalSolutionClient->createVolumeSnapshot($request);
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
    $formattedParent = BareMetalSolutionClient::volumeName('[PROJECT]', '[LOCATION]', '[VOLUME]');

    create_volume_snapshot_sample($formattedParent);
}
// [END baremetalsolution_v2_generated_BareMetalSolution_CreateVolumeSnapshot_sync]
