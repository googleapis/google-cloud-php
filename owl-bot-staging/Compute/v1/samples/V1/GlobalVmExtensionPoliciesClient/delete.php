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

// [START compute_v1_generated_GlobalVmExtensionPolicies_Delete_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Compute\V1\Client\GlobalVmExtensionPoliciesClient;
use Google\Cloud\Compute\V1\DeleteGlobalVmExtensionPolicyRequest;
use Google\Cloud\Compute\V1\GlobalVmExtensionPolicyRolloutOperationRolloutInput;
use Google\Rpc\Status;

/**
 * Purge scoped resources (zonal policies) from a global VM extension
 * policy, and then delete the global VM extension policy. Purge of the scoped
 * resources is a pre-condition of the global VM extension policy deletion.
 * The deletion of the global VM extension policy happens after the purge
 * rollout is done, so it's not a part of the LRO. It's an automatic process
 * that triggers in the backend.
 *
 * @param string $globalVmExtensionPolicy Name of the global VM extension policy to purge scoped resources for.
 * @param string $project                 Project ID for this request.
 */
function delete_sample(string $globalVmExtensionPolicy, string $project): void
{
    // Create a client.
    $globalVmExtensionPoliciesClient = new GlobalVmExtensionPoliciesClient();

    // Prepare the request message.
    $globalVmExtensionPolicyRolloutOperationRolloutInputResource = new GlobalVmExtensionPolicyRolloutOperationRolloutInput();
    $request = (new DeleteGlobalVmExtensionPolicyRequest())
        ->setGlobalVmExtensionPolicy($globalVmExtensionPolicy)
        ->setGlobalVmExtensionPolicyRolloutOperationRolloutInputResource(
            $globalVmExtensionPolicyRolloutOperationRolloutInputResource
        )
        ->setProject($project);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $globalVmExtensionPoliciesClient->delete($request);
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
    $globalVmExtensionPolicy = '[GLOBAL_VM_EXTENSION_POLICY]';
    $project = '[PROJECT]';

    delete_sample($globalVmExtensionPolicy, $project);
}
// [END compute_v1_generated_GlobalVmExtensionPolicies_Delete_sync]
