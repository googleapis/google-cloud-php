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

// [START baremetalsolution_v2_generated_BareMetalSolution_RenameNfsShare_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BareMetalSolution\V2\Client\BareMetalSolutionClient;
use Google\Cloud\BareMetalSolution\V2\NfsShare;
use Google\Cloud\BareMetalSolution\V2\RenameNfsShareRequest;

/**
 * RenameNfsShare sets a new name for an nfsshare.
 * Use with caution, previous names become immediately invalidated.
 *
 * @param string $formattedName The `name` field is used to identify the nfsshare.
 *                              Format: projects/{project}/locations/{location}/nfsshares/{nfsshare}
 *                              Please see {@see BareMetalSolutionClient::nFSShareName()} for help formatting this field.
 * @param string $newNfsshareId The new `id` of the nfsshare.
 */
function rename_nfs_share_sample(string $formattedName, string $newNfsshareId): void
{
    // Create a client.
    $bareMetalSolutionClient = new BareMetalSolutionClient();

    // Prepare the request message.
    $request = (new RenameNfsShareRequest())
        ->setName($formattedName)
        ->setNewNfsshareId($newNfsshareId);

    // Call the API and handle any network failures.
    try {
        /** @var NfsShare $response */
        $response = $bareMetalSolutionClient->renameNfsShare($request);
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
    $formattedName = BareMetalSolutionClient::nFSShareName('[PROJECT]', '[LOCATION]', '[NFS_SHARE]');
    $newNfsshareId = '[NEW_NFSSHARE_ID]';

    rename_nfs_share_sample($formattedName, $newNfsshareId);
}
// [END baremetalsolution_v2_generated_BareMetalSolution_RenameNfsShare_sync]
