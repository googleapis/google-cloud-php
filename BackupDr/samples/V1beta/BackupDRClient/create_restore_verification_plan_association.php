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

// [START backupdr_v1beta_generated_BackupDR_CreateRestoreVerificationPlanAssociation_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\BackupDR\V1beta\Client\BackupDRClient;
use Google\Cloud\BackupDR\V1beta\CreateRestoreVerificationPlanAssociationRequest;
use Google\Cloud\BackupDR\V1beta\RestoreVerificationPlanAssociation;
use Google\Rpc\Status;

/**
 * Creates a new RestoreVerificationPlanAssociation in a given
 * RestoreVerificationPlan.
 *
 * @param string $formattedParent                                            The parent resource where this association will be created.
 *                                                                           Format:
 *                                                                           `projects/{project}/locations/{location}/restoreVerificationPlans/{restore_verification_plan}`
 *                                                                           Please see {@see BackupDRClient::restoreVerificationPlanName()} for help formatting this field.
 * @param string $restoreVerificationPlanAssociationId                       The ID to use for the association, which will become the final
 *                                                                           component of the association's resource name.
 *
 *                                                                           This value should be 1-63 characters, and valid characters are
 *                                                                           /[a-z0-9_-]/.
 * @param string $formattedRestoreVerificationPlanAssociationRestoreTemplate Immutable. The canonical name of the RestoreTemplate to
 *                                                                           trigger. Please see
 *                                                                           {@see BackupDRClient::restoreTemplateName()} for help formatting this field.
 * @param string $restoreVerificationPlanAssociationResourceType             Immutable. The type of the Google Cloud resource (e.g.,
 *                                                                           `compute.googleapis.com/Instance`, `sqladmin.googleapis.com/Instance`).
 */
function create_restore_verification_plan_association_sample(
    string $formattedParent,
    string $restoreVerificationPlanAssociationId,
    string $formattedRestoreVerificationPlanAssociationRestoreTemplate,
    string $restoreVerificationPlanAssociationResourceType
): void {
    // Create a client.
    $backupDRClient = new BackupDRClient();

    // Prepare the request message.
    $restoreVerificationPlanAssociation = (new RestoreVerificationPlanAssociation())
        ->setRestoreTemplate($formattedRestoreVerificationPlanAssociationRestoreTemplate)
        ->setResourceType($restoreVerificationPlanAssociationResourceType);
    $request = (new CreateRestoreVerificationPlanAssociationRequest())
        ->setParent($formattedParent)
        ->setRestoreVerificationPlanAssociationId($restoreVerificationPlanAssociationId)
        ->setRestoreVerificationPlanAssociation($restoreVerificationPlanAssociation);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $backupDRClient->createRestoreVerificationPlanAssociation($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var RestoreVerificationPlanAssociation $result */
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
    $formattedParent = BackupDRClient::restoreVerificationPlanName(
        '[PROJECT]',
        '[LOCATION]',
        '[RESTOREVERIFICATIONPLAN]'
    );
    $restoreVerificationPlanAssociationId = '[RESTORE_VERIFICATION_PLAN_ASSOCIATION_ID]';
    $formattedRestoreVerificationPlanAssociationRestoreTemplate = BackupDRClient::restoreTemplateName(
        '[PROJECT]',
        '[LOCATION]',
        '[RESTORE_TEMPLATE]'
    );
    $restoreVerificationPlanAssociationResourceType = '[RESOURCE_TYPE]';

    create_restore_verification_plan_association_sample(
        $formattedParent,
        $restoreVerificationPlanAssociationId,
        $formattedRestoreVerificationPlanAssociationRestoreTemplate,
        $restoreVerificationPlanAssociationResourceType
    );
}
// [END backupdr_v1beta_generated_BackupDR_CreateRestoreVerificationPlanAssociation_sync]
