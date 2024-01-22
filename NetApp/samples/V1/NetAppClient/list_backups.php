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

// [START netapp_v1_generated_NetApp_ListBackups_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\NetApp\V1\Backup;
use Google\Cloud\NetApp\V1\Client\NetAppClient;
use Google\Cloud\NetApp\V1\ListBackupsRequest;

/**
 * Returns descriptions of all backups for a backupVault.
 *
 * @param string $formattedParent The backupVault for which to retrieve backup information,
 *                                in the format
 *                                `projects/{project_id}/locations/{location}/backupVaults/{backup_vault_id}`.
 *                                To retrieve backup information for all locations, use "-" for the
 *                                `{location}` value.
 *                                To retrieve backup information for all backupVaults, use "-" for the
 *                                `{backup_vault_id}` value.
 *                                To retrieve backup information for a volume, use "-" for the
 *                                `{backup_vault_id}` value and specify volume full name with the filter. Please see
 *                                {@see NetAppClient::backupVaultName()} for help formatting this field.
 */
function list_backups_sample(string $formattedParent): void
{
    // Create a client.
    $netAppClient = new NetAppClient();

    // Prepare the request message.
    $request = (new ListBackupsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $netAppClient->listBackups($request);

        /** @var Backup $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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

    list_backups_sample($formattedParent);
}
// [END netapp_v1_generated_NetApp_ListBackups_sync]
