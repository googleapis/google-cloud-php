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

// [START backupdr_v1_generated_BackupDR_CreateManagementServer_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\BackupDR\V1\Client\BackupDRClient;
use Google\Cloud\BackupDR\V1\CreateManagementServerRequest;
use Google\Cloud\BackupDR\V1\ManagementServer;
use Google\Cloud\BackupDR\V1\NetworkConfig;
use Google\Rpc\Status;

/**
 * Creates a new ManagementServer in a given project and location.
 *
 * @param string $formattedParent    The management server project and location in the format
 *                                   'projects/{project_id}/locations/{location}'. In Cloud Backup and DR
 *                                   locations map to Google Cloud regions, for example **us-central1**. Please see
 *                                   {@see BackupDRClient::locationName()} for help formatting this field.
 * @param string $managementServerId The name of the management server to create. The name must be
 *                                   unique for the specified project and location.
 */
function create_management_server_sample(
    string $formattedParent,
    string $managementServerId
): void {
    // Create a client.
    $backupDRClient = new BackupDRClient();

    // Prepare the request message.
    $managementServerNetworks = [new NetworkConfig()];
    $managementServer = (new ManagementServer())
        ->setNetworks($managementServerNetworks);
    $request = (new CreateManagementServerRequest())
        ->setParent($formattedParent)
        ->setManagementServerId($managementServerId)
        ->setManagementServer($managementServer);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $backupDRClient->createManagementServer($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ManagementServer $result */
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
    $formattedParent = BackupDRClient::locationName('[PROJECT]', '[LOCATION]');
    $managementServerId = '[MANAGEMENT_SERVER_ID]';

    create_management_server_sample($formattedParent, $managementServerId);
}
// [END backupdr_v1_generated_BackupDR_CreateManagementServer_sync]
