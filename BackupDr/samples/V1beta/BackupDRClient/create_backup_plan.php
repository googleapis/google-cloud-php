<?php
/*
 * Copyright 2026 Google LLC
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

// [START backupdr_v1beta_generated_BackupDR_CreateBackupPlan_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\BackupDR\V1beta\BackupPlan;
use Google\Cloud\BackupDR\V1beta\Client\BackupDRClient;
use Google\Cloud\BackupDR\V1beta\CreateBackupPlanRequest;
use Google\Rpc\Status;

/**
 * Create a BackupPlan
 *
 * @param string $formattedParent                The `BackupPlan` project and location in the format
 *                                               `projects/{project}/locations/{location}`. In Google Cloud Backup and DR
 *                                               locations map to Google Cloud regions, for example **us-central1**. Please see
 *                                               {@see BackupDRClient::locationName()} for help formatting this field.
 * @param string $backupPlanId                   The name of the `BackupPlan` to create. The name must be unique
 *                                               for the specified project and location.The name must start with a lowercase
 *                                               letter followed by up to 62 lowercase letters, numbers, or hyphens.
 *                                               Pattern, /[a-z][a-z0-9-]{,62}/.
 * @param string $backupPlanResourceType         The resource type to which the `BackupPlan` will be applied.
 *                                               Examples include, "compute.googleapis.com/Instance",
 *                                               "sqladmin.googleapis.com/Instance", "alloydb.googleapis.com/Cluster",
 *                                               "compute.googleapis.com/Disk".
 * @param string $formattedBackupPlanBackupVault Resource name of backup vault which will be used as storage
 *                                               location for backups. Format:
 *                                               projects/{project}/locations/{location}/backupVaults/{backupvault}
 *                                               Please see {@see BackupDRClient::backupVaultName()} for help formatting this field.
 */
function create_backup_plan_sample(
    string $formattedParent,
    string $backupPlanId,
    string $backupPlanResourceType,
    string $formattedBackupPlanBackupVault
): void {
    // Create a client.
    $backupDRClient = new BackupDRClient();

    // Prepare the request message.
    $backupPlan = (new BackupPlan())
        ->setResourceType($backupPlanResourceType)
        ->setBackupVault($formattedBackupPlanBackupVault);
    $request = (new CreateBackupPlanRequest())
        ->setParent($formattedParent)
        ->setBackupPlanId($backupPlanId)
        ->setBackupPlan($backupPlan);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $backupDRClient->createBackupPlan($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var BackupPlan $result */
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
    $backupPlanId = '[BACKUP_PLAN_ID]';
    $backupPlanResourceType = '[RESOURCE_TYPE]';
    $formattedBackupPlanBackupVault = BackupDRClient::backupVaultName(
        '[PROJECT]',
        '[LOCATION]',
        '[BACKUPVAULT]'
    );

    create_backup_plan_sample(
        $formattedParent,
        $backupPlanId,
        $backupPlanResourceType,
        $formattedBackupPlanBackupVault
    );
}
// [END backupdr_v1beta_generated_BackupDR_CreateBackupPlan_sync]
