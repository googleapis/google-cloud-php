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

// [START iam_v3_generated_PolicyBindings_DeletePolicyBinding_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Iam\V3\Client\PolicyBindingsClient;
use Google\Cloud\Iam\V3\DeletePolicyBindingRequest;
use Google\Rpc\Status;

/**
 * Deletes a policy binding and returns a long-running operation.
 * Callers will need the IAM permissions on both the policy and target.
 * Once the binding is deleted, the policy no longer applies to the target.
 *
 * @param string $formattedName The name of the policy binding to delete.
 *
 *                              Format:
 *
 *                              * `projects/{project_id}/locations/{location}/policyBindings/{policy_binding_id}`
 *                              * `projects/{project_number}/locations/{location}/policyBindings/{policy_binding_id}`
 *                              * `folders/{folder_id}/locations/{location}/policyBindings/{policy_binding_id}`
 *                              * `organizations/{organization_id}/locations/{location}/policyBindings/{policy_binding_id}`
 *                              Please see {@see PolicyBindingsClient::policyBindingName()} for help formatting this field.
 */
function delete_policy_binding_sample(string $formattedName): void
{
    // Create a client.
    $policyBindingsClient = new PolicyBindingsClient();

    // Prepare the request message.
    $request = (new DeletePolicyBindingRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $policyBindingsClient->deletePolicyBinding($request);
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
    $formattedName = PolicyBindingsClient::policyBindingName(
        '[ORGANIZATION]',
        '[LOCATION]',
        '[POLICY_BINDING]'
    );

    delete_policy_binding_sample($formattedName);
}
// [END iam_v3_generated_PolicyBindings_DeletePolicyBinding_sync]
