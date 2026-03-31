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

// [START networksecurity_v1_generated_NetworkSecurity_UpdateAuthzPolicy_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkSecurity\V1\AuthzPolicy;
use Google\Cloud\NetworkSecurity\V1\AuthzPolicy\AuthzAction;
use Google\Cloud\NetworkSecurity\V1\AuthzPolicy\Target;
use Google\Cloud\NetworkSecurity\V1\Client\NetworkSecurityClient;
use Google\Cloud\NetworkSecurity\V1\UpdateAuthzPolicyRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates the parameters of a single AuthzPolicy.
 *
 * @param string $authzPolicyName                   Identifier. Name of the `AuthzPolicy` resource in the following
 *                                                  format:
 *                                                  `projects/{project}/locations/{location}/authzPolicies/{authz_policy}`.
 * @param string $authzPolicyTargetResourcesElement A list of references to the Forwarding Rules on which this
 *                                                  policy will be applied.
 * @param int    $authzPolicyAction                 Can be one of `ALLOW`, `DENY`, `CUSTOM`.
 *
 *                                                  When the action is `CUSTOM`, `customProvider` must be specified.
 *
 *                                                  When the action is `ALLOW`, only requests matching the policy will
 *                                                  be allowed.
 *
 *                                                  When the action is `DENY`, only requests matching the policy will be
 *                                                  denied.
 *
 *                                                  When a request arrives, the policies are evaluated in the following order:
 *
 *                                                  1. If there is a `CUSTOM` policy that matches the request, the `CUSTOM`
 *                                                  policy is evaluated using the custom authorization providers and the
 *                                                  request is denied if the provider rejects the request.
 *
 *                                                  2. If there are any `DENY` policies that match the request, the request
 *                                                  is denied.
 *
 *                                                  3. If there are no `ALLOW` policies for the resource or if any of the
 *                                                  `ALLOW` policies match the request, the request is allowed.
 *
 *                                                  4. Else the request is denied by default if none of the configured
 *                                                  AuthzPolicies with `ALLOW` action match the request.
 */
function update_authz_policy_sample(
    string $authzPolicyName,
    string $authzPolicyTargetResourcesElement,
    int $authzPolicyAction
): void {
    // Create a client.
    $networkSecurityClient = new NetworkSecurityClient();

    // Prepare the request message.
    $updateMask = new FieldMask();
    $authzPolicyTargetResources = [$authzPolicyTargetResourcesElement,];
    $authzPolicyTarget = (new Target())
        ->setResources($authzPolicyTargetResources);
    $authzPolicy = (new AuthzPolicy())
        ->setName($authzPolicyName)
        ->setTarget($authzPolicyTarget)
        ->setAction($authzPolicyAction);
    $request = (new UpdateAuthzPolicyRequest())
        ->setUpdateMask($updateMask)
        ->setAuthzPolicy($authzPolicy);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $networkSecurityClient->updateAuthzPolicy($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AuthzPolicy $result */
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
    $authzPolicyName = '[NAME]';
    $authzPolicyTargetResourcesElement = '[RESOURCES]';
    $authzPolicyAction = AuthzAction::AUTHZ_ACTION_UNSPECIFIED;

    update_authz_policy_sample(
        $authzPolicyName,
        $authzPolicyTargetResourcesElement,
        $authzPolicyAction
    );
}
// [END networksecurity_v1_generated_NetworkSecurity_UpdateAuthzPolicy_sync]
