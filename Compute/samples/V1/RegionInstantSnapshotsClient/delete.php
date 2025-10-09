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

// [START compute_v1_generated_RegionInstantSnapshots_Delete_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Compute\V1\Client\RegionInstantSnapshotsClient;
use Google\Cloud\Compute\V1\DeleteRegionInstantSnapshotRequest;
use Google\Rpc\Status;

/**
 * Deletes the specified InstantSnapshot resource. Keep in mind that deleting a single instantSnapshot might not necessarily delete all the data on that instantSnapshot. If any data on the instantSnapshot that is marked for deletion is needed for subsequent instantSnapshots, the data will be moved to the next corresponding instantSnapshot. For more information, see Deleting instantSnapshots.
 *
 * @param string $instantSnapshot Name of the InstantSnapshot resource to delete.
 * @param string $project         Project ID for this request.
 * @param string $region          The name of the region for this request.
 */
function delete_sample(string $instantSnapshot, string $project, string $region): void
{
    // Create a client.
    $regionInstantSnapshotsClient = new RegionInstantSnapshotsClient();

    // Prepare the request message.
    $request = (new DeleteRegionInstantSnapshotRequest())
        ->setInstantSnapshot($instantSnapshot)
        ->setProject($project)
        ->setRegion($region);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $regionInstantSnapshotsClient->delete($request);
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
    $instantSnapshot = '[INSTANT_SNAPSHOT]';
    $project = '[PROJECT]';
    $region = '[REGION]';

    delete_sample($instantSnapshot, $project, $region);
}
// [END compute_v1_generated_RegionInstantSnapshots_Delete_sync]
