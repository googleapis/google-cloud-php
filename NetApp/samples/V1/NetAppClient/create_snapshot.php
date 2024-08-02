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

// [START netapp_v1_generated_NetApp_CreateSnapshot_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetApp\V1\Client\NetAppClient;
use Google\Cloud\NetApp\V1\CreateSnapshotRequest;
use Google\Cloud\NetApp\V1\Snapshot;
use Google\Rpc\Status;

/**
 * Create a new snapshot for a volume.
 *
 * @param string $formattedParent The NetApp volume to create the snapshots of, in the format
 *                                `projects/{project_id}/locations/{location}/volumes/{volume_id}`
 *                                Please see {@see NetAppClient::volumeName()} for help formatting this field.
 * @param string $snapshotId      ID of the snapshot to create. Must be unique within the parent
 *                                resource. Must contain only letters, numbers, underscore and hyphen, with
 *                                the first character a letter or underscore, the last a letter or underscore
 *                                or a number, and a 63 character maximum.
 */
function create_snapshot_sample(string $formattedParent, string $snapshotId): void
{
    // Create a client.
    $netAppClient = new NetAppClient();

    // Prepare the request message.
    $snapshot = new Snapshot();
    $request = (new CreateSnapshotRequest())
        ->setParent($formattedParent)
        ->setSnapshot($snapshot)
        ->setSnapshotId($snapshotId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $netAppClient->createSnapshot($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Snapshot $result */
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
    $formattedParent = NetAppClient::volumeName('[PROJECT]', '[LOCATION]', '[VOLUME]');
    $snapshotId = '[SNAPSHOT_ID]';

    create_snapshot_sample($formattedParent, $snapshotId);
}
// [END netapp_v1_generated_NetApp_CreateSnapshot_sync]
