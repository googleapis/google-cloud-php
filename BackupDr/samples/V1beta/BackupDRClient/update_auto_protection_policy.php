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

// [START backupdr_v1beta_generated_BackupDR_UpdateAutoProtectionPolicy_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\BackupDR\V1beta\AutoProtectionPolicy;
use Google\Cloud\BackupDR\V1beta\BackupPlanDetail;
use Google\Cloud\BackupDR\V1beta\Client\BackupDRClient;
use Google\Cloud\BackupDR\V1beta\Criteria;
use Google\Cloud\BackupDR\V1beta\MatchingCondition;
use Google\Cloud\BackupDR\V1beta\UpdateAutoProtectionPolicyRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates the parameters of a single AutoProtectionPolicy.
 *
 * @param string $autoProtectionPolicyBackupPlanDetailsResourceType        The type of resource that this policy will automatically protect.
 *                                                                         For MVP, `compute.googleapis.com/Instance` and
 *                                                                         `compute.googleapis.com/Disk` are supported.
 * @param string $formattedAutoProtectionPolicyBackupPlanDetailsBackupPlan The resource name of the BackupPlan to apply to resources that
 *                                                                         match the policy's criteria. This backup plan must be in the same location
 *                                                                         as AutoProtectionPolicy. Format:
 *                                                                         projects/{project}/locations/{location}/backupPlans/{backupPlanId}
 *                                                                         Please see {@see BackupDRClient::backupPlanName()} for help formatting this field.
 */
function update_auto_protection_policy_sample(
    string $autoProtectionPolicyBackupPlanDetailsResourceType,
    string $formattedAutoProtectionPolicyBackupPlanDetailsBackupPlan
): void {
    // Create a client.
    $backupDRClient = new BackupDRClient();

    // Prepare the request message.
    $backupPlanDetail = (new BackupPlanDetail())
        ->setResourceType($autoProtectionPolicyBackupPlanDetailsResourceType)
        ->setBackupPlan($formattedAutoProtectionPolicyBackupPlanDetailsBackupPlan);
    $autoProtectionPolicyBackupPlanDetails = [$backupPlanDetail,];
    $autoProtectionPolicyCriteriaMatchingConditions = [new MatchingCondition()];
    $autoProtectionPolicyCriteria = (new Criteria())
        ->setMatchingConditions($autoProtectionPolicyCriteriaMatchingConditions);
    $autoProtectionPolicy = (new AutoProtectionPolicy())
        ->setBackupPlanDetails($autoProtectionPolicyBackupPlanDetails)
        ->setCriteria($autoProtectionPolicyCriteria);
    $updateMask = new FieldMask();
    $request = (new UpdateAutoProtectionPolicyRequest())
        ->setAutoProtectionPolicy($autoProtectionPolicy)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $backupDRClient->updateAutoProtectionPolicy($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AutoProtectionPolicy $result */
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
    $autoProtectionPolicyBackupPlanDetailsResourceType = '[RESOURCE_TYPE]';
    $formattedAutoProtectionPolicyBackupPlanDetailsBackupPlan = BackupDRClient::backupPlanName(
        '[PROJECT]',
        '[LOCATION]',
        '[BACKUP_PLAN]'
    );

    update_auto_protection_policy_sample(
        $autoProtectionPolicyBackupPlanDetailsResourceType,
        $formattedAutoProtectionPolicyBackupPlanDetailsBackupPlan
    );
}
// [END backupdr_v1beta_generated_BackupDR_UpdateAutoProtectionPolicy_sync]
