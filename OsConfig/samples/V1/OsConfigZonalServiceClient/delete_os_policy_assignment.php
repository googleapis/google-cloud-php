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

// [START osconfig_v1_generated_OsConfigZonalService_DeleteOSPolicyAssignment_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\OsConfig\V1\OsConfigZonalServiceClient;
use Google\Rpc\Status;

/**
 * Delete the OS policy assignment.
 *
 * This method creates a new revision of the OS policy assignment.
 *
 * This method returns a long running operation (LRO) that contains the
 * rollout details. The rollout can be cancelled by cancelling the LRO.
 *
 * If the LRO completes and is not cancelled, all revisions associated with
 * the OS policy assignment are deleted.
 *
 * For more information, see [Method:
 * projects.locations.osPolicyAssignments.operations.cancel](https://cloud.google.com/compute/docs/osconfig/rest/v1/projects.locations.osPolicyAssignments.operations/cancel).
 *
 * @param string $formattedName The name of the OS policy assignment to be deleted
 *                              Please see {@see OsConfigZonalServiceClient::oSPolicyAssignmentName()} for help formatting this field.
 */
function delete_os_policy_assignment_sample(string $formattedName): void
{
    // Create a client.
    $osConfigZonalServiceClient = new OsConfigZonalServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $osConfigZonalServiceClient->deleteOSPolicyAssignment($formattedName);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
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
    $formattedName = OsConfigZonalServiceClient::oSPolicyAssignmentName(
        '[PROJECT]',
        '[LOCATION]',
        '[OS_POLICY_ASSIGNMENT]'
    );

    delete_os_policy_assignment_sample($formattedName);
}
// [END osconfig_v1_generated_OsConfigZonalService_DeleteOSPolicyAssignment_sync]
