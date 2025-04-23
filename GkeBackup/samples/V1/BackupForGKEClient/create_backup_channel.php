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

// [START gkebackup_v1_generated_BackupForGKE_CreateBackupChannel_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GkeBackup\V1\BackupChannel;
use Google\Cloud\GkeBackup\V1\Client\BackupForGKEClient;
use Google\Cloud\GkeBackup\V1\CreateBackupChannelRequest;
use Google\Rpc\Status;

/**
 * Creates a new BackupChannel in a given location.
 *
 * @param string $formattedParent                 The location within which to create the BackupChannel.
 *                                                Format: `projects/&#42;/locations/*`
 *                                                Please see {@see BackupForGKEClient::locationName()} for help formatting this field.
 * @param string $backupChannelDestinationProject Immutable. The project where Backups are allowed to be stored.
 *                                                The format is `projects/{project}`.
 *                                                Currently, {project} can only be the project number. Support for project
 *                                                IDs will be added in the future.
 */
function create_backup_channel_sample(
    string $formattedParent,
    string $backupChannelDestinationProject
): void {
    // Create a client.
    $backupForGKEClient = new BackupForGKEClient();

    // Prepare the request message.
    $backupChannel = (new BackupChannel())
        ->setDestinationProject($backupChannelDestinationProject);
    $request = (new CreateBackupChannelRequest())
        ->setParent($formattedParent)
        ->setBackupChannel($backupChannel);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $backupForGKEClient->createBackupChannel($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var BackupChannel $result */
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
    $formattedParent = BackupForGKEClient::locationName('[PROJECT]', '[LOCATION]');
    $backupChannelDestinationProject = '[DESTINATION_PROJECT]';

    create_backup_channel_sample($formattedParent, $backupChannelDestinationProject);
}
// [END gkebackup_v1_generated_BackupForGKE_CreateBackupChannel_sync]
