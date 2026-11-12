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

// [START backupdr_v1_generated_BackupDR_GetRestoreVerificationPlanAssociation_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BackupDR\V1\Client\BackupDRClient;
use Google\Cloud\BackupDR\V1\GetRestoreVerificationPlanAssociationRequest;
use Google\Cloud\BackupDR\V1\RestoreVerificationPlanAssociation;

/**
 * Gets details of a single RestoreVerificationPlanAssociation in a given
 * RestoreVerificationPlan.
 *
 * @param string $formattedName The resource name of the RestoreVerificationPlanAssociation to
 *                              retrieve.
 *                              Format:
 *                              `projects/{project}/locations/{location}/restoreVerificationPlans/{restore_verification_plan}/associations/{association}`
 *                              Please see {@see BackupDRClient::restoreVerificationPlanAssociationName()} for help formatting this field.
 */
function get_restore_verification_plan_association_sample(string $formattedName): void
{
    // Create a client.
    $backupDRClient = new BackupDRClient();

    // Prepare the request message.
    $request = (new GetRestoreVerificationPlanAssociationRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var RestoreVerificationPlanAssociation $response */
        $response = $backupDRClient->getRestoreVerificationPlanAssociation($request);
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
    $formattedName = BackupDRClient::restoreVerificationPlanAssociationName(
        '[PROJECT]',
        '[LOCATION]',
        '[RESTORE_VERIFICATION_PLAN]',
        '[ASSOCIATION]'
    );

    get_restore_verification_plan_association_sample($formattedName);
}
// [END backupdr_v1_generated_BackupDR_GetRestoreVerificationPlanAssociation_sync]
