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

// [START netapp_v1_generated_NetApp_CreateBackup_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetApp\V1\Backup;
use Google\Cloud\NetApp\V1\Client\NetAppClient;
use Google\Cloud\NetApp\V1\CreateBackupRequest;
use Google\Rpc\Status;

/**
 * Creates a backup from the volume specified in the request
 * The backup can be created from the given snapshot if specified in the
 * request. If no snapshot specified, there'll be a new snapshot taken to
 * initiate the backup creation.
 *
 * @param string $formattedParent The NetApp backupVault to create the backups of, in the format
 *                                `projects/&#42;/locations/&#42;/backupVaults/{backup_vault_id}`
 *                                Please see {@see NetAppClient::backupVaultName()} for help formatting this field.
 * @param string $backupId        The ID to use for the backup.
 *                                The ID must be unique within the specified backupVault.
 *                                Must contain only letters, numbers, underscore and hyphen, with the first
 *                                character a letter or underscore, the last a letter or underscore or a
 *                                number, and a 63 character maximum.
 */
function create_backup_sample(string $formattedParent, string $backupId): void
{
    // Create a client.
    $netAppClient = new NetAppClient();

    // Prepare the request message.
    $backup = new Backup();
    $request = (new CreateBackupRequest())
        ->setParent($formattedParent)
        ->setBackupId($backupId)
        ->setBackup($backup);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $netAppClient->createBackup($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Backup $result */
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
    $formattedParent = NetAppClient::backupVaultName('[PROJECT]', '[LOCATION]', '[BACKUP_VAULT]');
    $backupId = '[BACKUP_ID]';

    create_backup_sample($formattedParent, $backupId);
}
// [END netapp_v1_generated_NetApp_CreateBackup_sync]
