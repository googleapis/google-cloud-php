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

// [START compute_v1_generated_Projects_MoveDisk_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Compute\V1\Client\ProjectsClient;
use Google\Cloud\Compute\V1\DiskMoveRequest;
use Google\Cloud\Compute\V1\MoveDiskProjectRequest;
use Google\Rpc\Status;

/**
 * Starting September 29, 2025, you can't use the moveDisk API on new projects. To move a disk to a different region or zone, follow the steps in [Change the location of a disk](https://{$universe.dns_names.final_documentation_domain}/compute/docs/disks/migrate-to-hyperdisk#migrate-to-hd). Projects that already use the moveDisk API can continue usage until September 29, 2026. Starting November 1, 2025, API responses will include a warning message in the response body about the upcoming deprecation. You can skip the message to continue using the service without interruption.
 *
 * @param string $project Project ID for this request.
 */
function move_disk_sample(string $project): void
{
    // Create a client.
    $projectsClient = new ProjectsClient();

    // Prepare the request message.
    $diskMoveRequestResource = new DiskMoveRequest();
    $request = (new MoveDiskProjectRequest())
        ->setDiskMoveRequestResource($diskMoveRequestResource)
        ->setProject($project);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $projectsClient->moveDisk($request);
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
    $project = '[PROJECT]';

    move_disk_sample($project);
}
// [END compute_v1_generated_Projects_MoveDisk_sync]
