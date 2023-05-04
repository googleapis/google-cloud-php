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

// [START osconfig_v1_generated_OsConfigZonalService_UpdateOSPolicyAssignment_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\OsConfig\V1\FixedOrPercent;
use Google\Cloud\OsConfig\V1\OSPolicy;
use Google\Cloud\OsConfig\V1\OSPolicyAssignment;
use Google\Cloud\OsConfig\V1\OSPolicyAssignment\InstanceFilter;
use Google\Cloud\OsConfig\V1\OSPolicyAssignment\Rollout;
use Google\Cloud\OsConfig\V1\OSPolicy\Mode;
use Google\Cloud\OsConfig\V1\OSPolicy\Resource;
use Google\Cloud\OsConfig\V1\OSPolicy\ResourceGroup;
use Google\Cloud\OsConfig\V1\OsConfigZonalServiceClient;
use Google\Protobuf\Duration;
use Google\Rpc\Status;

/**
 * Update an existing OS policy assignment.
 *
 * This method creates a new revision of the OS policy assignment.
 *
 * This method returns a long running operation (LRO) that contains the
 * rollout details. The rollout can be cancelled by cancelling the LRO.
 *
 * For more information, see [Method:
 * projects.locations.osPolicyAssignments.operations.cancel](https://cloud.google.com/compute/docs/osconfig/rest/v1/projects.locations.osPolicyAssignments.operations/cancel).
 *
 * @param string $osPolicyAssignmentOsPoliciesId                        The id of the OS policy with the following restrictions:
 *
 *                                                                      * Must contain only lowercase letters, numbers, and hyphens.
 *                                                                      * Must start with a letter.
 *                                                                      * Must be between 1-63 characters.
 *                                                                      * Must end with a number or a letter.
 *                                                                      * Must be unique within the assignment.
 * @param int    $osPolicyAssignmentOsPoliciesMode                      Policy mode
 * @param string $osPolicyAssignmentOsPoliciesResourceGroupsResourcesId The id of the resource with the following restrictions:
 *
 *                                                                      * Must contain only lowercase letters, numbers, and hyphens.
 *                                                                      * Must start with a letter.
 *                                                                      * Must be between 1-63 characters.
 *                                                                      * Must end with a number or a letter.
 *                                                                      * Must be unique within the OS policy.
 */
function update_os_policy_assignment_sample(
    string $osPolicyAssignmentOsPoliciesId,
    int $osPolicyAssignmentOsPoliciesMode,
    string $osPolicyAssignmentOsPoliciesResourceGroupsResourcesId
): void {
    // Create a client.
    $osConfigZonalServiceClient = new OsConfigZonalServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $resource = (new Resource())
        ->setId($osPolicyAssignmentOsPoliciesResourceGroupsResourcesId);
    $osPolicyAssignmentOsPoliciesResourceGroupsResources = [$resource,];
    $resourceGroup = (new ResourceGroup())
        ->setResources($osPolicyAssignmentOsPoliciesResourceGroupsResources);
    $osPolicyAssignmentOsPoliciesResourceGroups = [$resourceGroup,];
    $oSPolicy = (new OSPolicy())
        ->setId($osPolicyAssignmentOsPoliciesId)
        ->setMode($osPolicyAssignmentOsPoliciesMode)
        ->setResourceGroups($osPolicyAssignmentOsPoliciesResourceGroups);
    $osPolicyAssignmentOsPolicies = [$oSPolicy,];
    $osPolicyAssignmentInstanceFilter = new InstanceFilter();
    $osPolicyAssignmentRolloutDisruptionBudget = new FixedOrPercent();
    $osPolicyAssignmentRolloutMinWaitDuration = new Duration();
    $osPolicyAssignmentRollout = (new Rollout())
        ->setDisruptionBudget($osPolicyAssignmentRolloutDisruptionBudget)
        ->setMinWaitDuration($osPolicyAssignmentRolloutMinWaitDuration);
    $osPolicyAssignment = (new OSPolicyAssignment())
        ->setOsPolicies($osPolicyAssignmentOsPolicies)
        ->setInstanceFilter($osPolicyAssignmentInstanceFilter)
        ->setRollout($osPolicyAssignmentRollout);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $osConfigZonalServiceClient->updateOSPolicyAssignment($osPolicyAssignment);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var OSPolicyAssignment $result */
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
    $osPolicyAssignmentOsPoliciesId = '[ID]';
    $osPolicyAssignmentOsPoliciesMode = Mode::MODE_UNSPECIFIED;
    $osPolicyAssignmentOsPoliciesResourceGroupsResourcesId = '[ID]';

    update_os_policy_assignment_sample(
        $osPolicyAssignmentOsPoliciesId,
        $osPolicyAssignmentOsPoliciesMode,
        $osPolicyAssignmentOsPoliciesResourceGroupsResourcesId
    );
}
// [END osconfig_v1_generated_OsConfigZonalService_UpdateOSPolicyAssignment_sync]
