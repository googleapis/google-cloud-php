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

// [START baremetalsolution_v2_generated_BareMetalSolution_RestoreVolumeSnapshot_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\BareMetalSolution\V2\Client\BareMetalSolutionClient;
use Google\Cloud\BareMetalSolution\V2\RestoreVolumeSnapshotRequest;
use Google\Cloud\BareMetalSolution\V2\VolumeSnapshot;
use Google\Rpc\Status;

/**
 * Uses the specified snapshot to restore its parent volume.
 * Returns INVALID_ARGUMENT if called for a non-boot volume.
 *
 * @param string $formattedVolumeSnapshot Name of the snapshot which will be used to restore its parent
 *                                        volume. Please see
 *                                        {@see BareMetalSolutionClient::volumeSnapshotName()} for help formatting this field.
 */
function restore_volume_snapshot_sample(string $formattedVolumeSnapshot): void
{
    // Create a client.
    $bareMetalSolutionClient = new BareMetalSolutionClient();

    // Prepare the request message.
    $request = (new RestoreVolumeSnapshotRequest())
        ->setVolumeSnapshot($formattedVolumeSnapshot);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $bareMetalSolutionClient->restoreVolumeSnapshot($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var VolumeSnapshot $result */
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
    $formattedVolumeSnapshot = BareMetalSolutionClient::volumeSnapshotName(
        '[PROJECT]',
        '[LOCATION]',
        '[VOLUME]',
        '[SNAPSHOT]'
    );

    restore_volume_snapshot_sample($formattedVolumeSnapshot);
}
// [END baremetalsolution_v2_generated_BareMetalSolution_RestoreVolumeSnapshot_sync]
