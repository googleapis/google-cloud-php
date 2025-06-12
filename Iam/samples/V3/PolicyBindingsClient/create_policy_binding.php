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

// [START iam_v3_generated_PolicyBindings_CreatePolicyBinding_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Iam\V3\Client\PolicyBindingsClient;
use Google\Cloud\Iam\V3\CreatePolicyBindingRequest;
use Google\Cloud\Iam\V3\PolicyBinding;
use Google\Cloud\Iam\V3\PolicyBinding\Target;
use Google\Rpc\Status;

/**
 * Creates a policy binding and returns a long-running operation.
 * Callers will need the IAM permissions on both the policy and target.
 * Once the binding is created, the policy is applied to the target.
 *
 * @param string $formattedParent     The parent resource where this policy binding will be created.
 *                                    The binding parent is the closest Resource Manager resource (project,
 *                                    folder or organization) to the binding target.
 *
 *                                    Format:
 *
 *                                    * `projects/{project_id}/locations/{location}`
 *                                    * `projects/{project_number}/locations/{location}`
 *                                    * `folders/{folder_id}/locations/{location}`
 *                                    * `organizations/{organization_id}/locations/{location}`
 *                                    Please see {@see PolicyBindingsClient::organizationLocationName()} for help formatting this field.
 * @param string $policyBindingId     The ID to use for the policy binding, which will become the final
 *                                    component of the policy binding's resource name.
 *
 *                                    This value must start with a lowercase letter followed by up to 62
 *                                    lowercase letters, numbers, hyphens, or dots. Pattern,
 *                                    /[a-z][a-z0-9-\.]{2,62}/.
 * @param string $policyBindingPolicy Immutable. The resource name of the policy to be bound. The
 *                                    binding parent and policy must belong to the same organization.
 */
function create_policy_binding_sample(
    string $formattedParent,
    string $policyBindingId,
    string $policyBindingPolicy
): void {
    // Create a client.
    $policyBindingsClient = new PolicyBindingsClient();

    // Prepare the request message.
    $policyBindingTarget = new Target();
    $policyBinding = (new PolicyBinding())
        ->setTarget($policyBindingTarget)
        ->setPolicy($policyBindingPolicy);
    $request = (new CreatePolicyBindingRequest())
        ->setParent($formattedParent)
        ->setPolicyBindingId($policyBindingId)
        ->setPolicyBinding($policyBinding);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $policyBindingsClient->createPolicyBinding($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var PolicyBinding $result */
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
    $formattedParent = PolicyBindingsClient::organizationLocationName('[ORGANIZATION]', '[LOCATION]');
    $policyBindingId = '[POLICY_BINDING_ID]';
    $policyBindingPolicy = '[POLICY]';

    create_policy_binding_sample($formattedParent, $policyBindingId, $policyBindingPolicy);
}
// [END iam_v3_generated_PolicyBindings_CreatePolicyBinding_sync]
