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

// [START netapp_v1_generated_NetApp_UpdateBackupVault_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetApp\V1\BackupVault;
use Google\Cloud\NetApp\V1\Client\NetAppClient;
use Google\Cloud\NetApp\V1\UpdateBackupVaultRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates the settings of a specific backup vault.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_backup_vault_sample(): void
{
    // Create a client.
    $netAppClient = new NetAppClient();

    // Prepare the request message.
    $updateMask = new FieldMask();
    $backupVault = new BackupVault();
    $request = (new UpdateBackupVaultRequest())
        ->setUpdateMask($updateMask)
        ->setBackupVault($backupVault);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $netAppClient->updateBackupVault($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var BackupVault $result */
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
// [END netapp_v1_generated_NetApp_UpdateBackupVault_sync]
