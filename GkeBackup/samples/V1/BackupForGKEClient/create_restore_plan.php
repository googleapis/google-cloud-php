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

// [START gkebackup_v1_generated_BackupForGKE_CreateRestorePlan_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GkeBackup\V1\Client\BackupForGKEClient;
use Google\Cloud\GkeBackup\V1\CreateRestorePlanRequest;
use Google\Cloud\GkeBackup\V1\RestoreConfig;
use Google\Cloud\GkeBackup\V1\RestorePlan;
use Google\Rpc\Status;

/**
 * Creates a new RestorePlan in a given location.
 *
 * @param string $formattedParent                The location within which to create the RestorePlan.
 *                                               Format: `projects/&#42;/locations/*`
 *                                               Please see {@see BackupForGKEClient::locationName()} for help formatting this field.
 * @param string $formattedRestorePlanBackupPlan Immutable. A reference to the
 *                                               [BackupPlan][google.cloud.gkebackup.v1.BackupPlan] from which Backups may
 *                                               be used as the source for Restores created via this RestorePlan. Format:
 *                                               `projects/&#42;/locations/&#42;/backupPlans/*`. Please see
 *                                               {@see BackupForGKEClient::backupPlanName()} for help formatting this field.
 * @param string $formattedRestorePlanCluster    Immutable. The target cluster into which Restores created via
 *                                               this RestorePlan will restore data. NOTE: the cluster's region must be the
 *                                               same as the RestorePlan. Valid formats:
 *
 *                                               - `projects/&#42;/locations/&#42;/clusters/*`
 *                                               - `projects/&#42;/zones/&#42;/clusters/*`
 *                                               Please see {@see BackupForGKEClient::clusterName()} for help formatting this field.
 * @param string $restorePlanId                  The client-provided short name for the RestorePlan resource.
 *                                               This name must:
 *
 *                                               - be between 1 and 63 characters long (inclusive)
 *                                               - consist of only lower-case ASCII letters, numbers, and dashes
 *                                               - start with a lower-case letter
 *                                               - end with a lower-case letter or number
 *                                               - be unique within the set of RestorePlans in this location
 */
function create_restore_plan_sample(
    string $formattedParent,
    string $formattedRestorePlanBackupPlan,
    string $formattedRestorePlanCluster,
    string $restorePlanId
): void {
    // Create a client.
    $backupForGKEClient = new BackupForGKEClient();

    // Prepare the request message.
    $restorePlanRestoreConfig = new RestoreConfig();
    $restorePlan = (new RestorePlan())
        ->setBackupPlan($formattedRestorePlanBackupPlan)
        ->setCluster($formattedRestorePlanCluster)
        ->setRestoreConfig($restorePlanRestoreConfig);
    $request = (new CreateRestorePlanRequest())
        ->setParent($formattedParent)
        ->setRestorePlan($restorePlan)
        ->setRestorePlanId($restorePlanId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $backupForGKEClient->createRestorePlan($request);
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
    $formattedParent = BackupForGKEClient::locationName('[PROJECT]', '[LOCATION]');
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
    $restorePlanId = '[RESTORE_PLAN_ID]';

    create_restore_plan_sample(
        $formattedParent,
        $formattedRestorePlanBackupPlan,
        $formattedRestorePlanCluster,
        $restorePlanId
    );
}
// [END gkebackup_v1_generated_BackupForGKE_CreateRestorePlan_sync]
