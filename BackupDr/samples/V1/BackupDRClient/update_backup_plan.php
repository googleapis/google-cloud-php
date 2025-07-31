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

// [START backupdr_v1_generated_BackupDR_UpdateBackupPlan_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\BackupDR\V1\BackupPlan;
use Google\Cloud\BackupDR\V1\BackupRule;
use Google\Cloud\BackupDR\V1\Client\BackupDRClient;
use Google\Cloud\BackupDR\V1\UpdateBackupPlanRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Update a BackupPlan.
 *
 * @param string $backupPlanBackupRulesRuleId              Immutable. The unique id of this `BackupRule`. The `rule_id` is
 *                                                         unique per `BackupPlan`.The `rule_id` must start with a lowercase letter
 *                                                         followed by up to 62 lowercase letters, numbers, or hyphens. Pattern,
 *                                                         /[a-z][a-z0-9-]{,62}/.
 * @param int    $backupPlanBackupRulesBackupRetentionDays Configures the duration for which backup data will be kept. It is
 *                                                         defined in “days”. The value should be greater than or equal to minimum
 *                                                         enforced retention of the backup vault.
 *
 *                                                         Minimum value is 1 and maximum value is 36159 for custom retention
 *                                                         on-demand backup.
 *                                                         Minimum and maximum values are workload specific for all other rules.
 * @param string $backupPlanResourceType                   The resource type to which the `BackupPlan` will be applied.
 *                                                         Examples include, "compute.googleapis.com/Instance",
 *                                                         "sqladmin.googleapis.com/Instance", "alloydb.googleapis.com/Cluster",
 *                                                         "compute.googleapis.com/Disk".
 * @param string $formattedBackupPlanBackupVault           Resource name of backup vault which will be used as storage
 *                                                         location for backups. Format:
 *                                                         projects/{project}/locations/{location}/backupVaults/{backupvault}
 *                                                         Please see {@see BackupDRClient::backupVaultName()} for help formatting this field.
 */
function update_backup_plan_sample(
    string $backupPlanBackupRulesRuleId,
    int $backupPlanBackupRulesBackupRetentionDays,
    string $backupPlanResourceType,
    string $formattedBackupPlanBackupVault
): void {
    // Create a client.
    $backupDRClient = new BackupDRClient();

    // Prepare the request message.
    $backupRule = (new BackupRule())
        ->setRuleId($backupPlanBackupRulesRuleId)
        ->setBackupRetentionDays($backupPlanBackupRulesBackupRetentionDays);
    $backupPlanBackupRules = [$backupRule,];
    $backupPlan = (new BackupPlan())
        ->setBackupRules($backupPlanBackupRules)
        ->setResourceType($backupPlanResourceType)
        ->setBackupVault($formattedBackupPlanBackupVault);
    $updateMask = new FieldMask();
    $request = (new UpdateBackupPlanRequest())
        ->setBackupPlan($backupPlan)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $backupDRClient->updateBackupPlan($request);
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
    $backupPlanBackupRulesRuleId = '[RULE_ID]';
    $backupPlanBackupRulesBackupRetentionDays = 0;
    $backupPlanResourceType = '[RESOURCE_TYPE]';
    $formattedBackupPlanBackupVault = BackupDRClient::backupVaultName(
        '[PROJECT]',
        '[LOCATION]',
        '[BACKUPVAULT]'
    );

    update_backup_plan_sample(
        $backupPlanBackupRulesRuleId,
        $backupPlanBackupRulesBackupRetentionDays,
        $backupPlanResourceType,
        $formattedBackupPlanBackupVault
    );
}
// [END backupdr_v1_generated_BackupDR_UpdateBackupPlan_sync]
