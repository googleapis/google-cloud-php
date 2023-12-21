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

// [START netapp_v1_generated_NetApp_GetBackup_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\NetApp\V1\Backup;
use Google\Cloud\NetApp\V1\Client\NetAppClient;
use Google\Cloud\NetApp\V1\GetBackupRequest;

/**
 * Returns the description of the specified backup
 *
 * @param string $formattedName The backup resource name, in the format
 *                              `projects/{project_id}/locations/{location}/backupVaults/{backup_vault_id}/backups/{backup_id}`
 *                              Please see {@see NetAppClient::backupName()} for help formatting this field.
 */
function get_backup_sample(string $formattedName): void
{
    // Create a client.
    $netAppClient = new NetAppClient();

    // Prepare the request message.
    $request = (new GetBackupRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Backup $response */
        $response = $netAppClient->getBackup($request);
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
    $formattedName = NetAppClient::backupName('[PROJECT]', '[LOCATION]', '[BACKUP_VAULT]', '[BACKUP]');

    get_backup_sample($formattedName);
}
// [END netapp_v1_generated_NetApp_GetBackup_sync]
