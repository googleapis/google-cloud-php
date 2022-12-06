<?php
/*
 * Copyright 2022 Google LLC
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

// [START gkebackup_v1_generated_BackupForGKE_UpdateRestorePlan_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GkeBackup\V1\BackupForGKEClient;
use Google\Cloud\GkeBackup\V1\RestoreConfig;
use Google\Cloud\GkeBackup\V1\RestorePlan;
use Google\Rpc\Status;

/**
 * Update a RestorePlan.
 *
 * @param string $formattedRestorePlanBackupPlan Immutable. A reference to the [BackupPlan][google.cloud.gkebackup.v1.BackupPlan] from which Backups may be used as the
 *                                               source for Restores created via this RestorePlan.
 *                                               Format: projects/&#42;/locations/&#42;/backupPlans/*. Please see
 *                                               {@see BackupForGKEClient::backupPlanName()} for help formatting this field.
 * @param string $formattedRestorePlanCluster    Immutable. The target cluster into which Restores created via this RestorePlan
 *                                               will restore data. NOTE: the cluster's region must be the same as the
 *                                               RestorePlan.
 *                                               Valid formats:
 *
 *                                               - projects/&#42;/locations/&#42;/clusters/*
 *                                               - projects/&#42;/zones/&#42;/clusters/*
 *                                               Please see {@see BackupForGKEClient::clusterName()} for help formatting this field.
 */
function update_restore_plan_sample(
    string $formattedRestorePlanBackupPlan,
    string $formattedRestorePlanCluster
): void {
    // Create a client.
    $backupForGKEClient = new BackupForGKEClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $restorePlanRestoreConfig = new RestoreConfig();
    $restorePlan = (new RestorePlan())
        ->setBackupPlan($formattedRestorePlanBackupPlan)
        ->setCluster($formattedRestorePlanCluster)
        ->setRestoreConfig($restorePlanRestoreConfig);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $backupForGKEClient->updateRestorePlan($restorePlan);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var RestorePlan $result */
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
    $formattedRestorePlanBackupPlan = BackupForGKEClient::backupPlanName(
        '[PROJECT]',
        '[LOCATION]',
        '[BACKUP_PLAN]'
    );
    $formattedRestorePlanCluster = BackupForGKEClient::clusterName(
        '[PROJECT]',
        '[LOCATION]',
        '[CLUSTER]'
    );

    update_restore_plan_sample($formattedRestorePlanBackupPlan, $formattedRestorePlanCluster);
}
// [END gkebackup_v1_generated_BackupForGKE_UpdateRestorePlan_sync]
