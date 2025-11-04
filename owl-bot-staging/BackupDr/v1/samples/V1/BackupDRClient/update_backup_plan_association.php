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

// [START backupdr_v1_generated_BackupDR_UpdateBackupPlanAssociation_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\BackupDR\V1\BackupPlanAssociation;
use Google\Cloud\BackupDR\V1\Client\BackupDRClient;
use Google\Cloud\BackupDR\V1\UpdateBackupPlanAssociationRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Update a BackupPlanAssociation.
 *
 * @param string $backupPlanAssociationResourceType        Immutable. Resource type of workload on which backupplan is
 *                                                         applied
 * @param string $backupPlanAssociationResource            Immutable. Resource name of workload on which the backup plan is
 *                                                         applied.
 *
 *                                                         The format can either be the resource name (e.g.,
 *                                                         "projects/my-project/zones/us-central1-a/instances/my-instance") or the
 *                                                         full resource URI (e.g.,
 *                                                         "https://www.googleapis.com/compute/v1/projects/my-project/zones/us-central1-a/instances/my-instance").
 * @param string $formattedBackupPlanAssociationBackupPlan Resource name of backup plan which needs to be applied on
 *                                                         workload. Format:
 *                                                         projects/{project}/locations/{location}/backupPlans/{backupPlanId}
 *                                                         Please see {@see BackupDRClient::backupPlanName()} for help formatting this field.
 */
function update_backup_plan_association_sample(
    string $backupPlanAssociationResourceType,
    string $backupPlanAssociationResource,
    string $formattedBackupPlanAssociationBackupPlan
): void {
    // Create a client.
    $backupDRClient = new BackupDRClient();

    // Prepare the request message.
    $backupPlanAssociation = (new BackupPlanAssociation())
        ->setResourceType($backupPlanAssociationResourceType)
        ->setResource($backupPlanAssociationResource)
        ->setBackupPlan($formattedBackupPlanAssociationBackupPlan);
    $updateMask = new FieldMask();
    $request = (new UpdateBackupPlanAssociationRequest())
        ->setBackupPlanAssociation($backupPlanAssociation)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $backupDRClient->updateBackupPlanAssociation($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var BackupPlanAssociation $result */
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
    $backupPlanAssociationResourceType = '[RESOURCE_TYPE]';
    $backupPlanAssociationResource = '[RESOURCE]';
    $formattedBackupPlanAssociationBackupPlan = BackupDRClient::backupPlanName(
        '[PROJECT]',
        '[LOCATION]',
        '[BACKUP_PLAN]'
    );

    update_backup_plan_association_sample(
        $backupPlanAssociationResourceType,
        $backupPlanAssociationResource,
        $formattedBackupPlanAssociationBackupPlan
    );
}
// [END backupdr_v1_generated_BackupDR_UpdateBackupPlanAssociation_sync]
