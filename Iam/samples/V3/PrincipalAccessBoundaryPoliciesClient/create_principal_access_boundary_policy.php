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

// [START iam_v3_generated_PrincipalAccessBoundaryPolicies_CreatePrincipalAccessBoundaryPolicy_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Iam\V3\Client\PrincipalAccessBoundaryPoliciesClient;
use Google\Cloud\Iam\V3\CreatePrincipalAccessBoundaryPolicyRequest;
use Google\Cloud\Iam\V3\PrincipalAccessBoundaryPolicy;
use Google\Rpc\Status;

/**
 * Creates a principal access boundary policy, and returns a long running
 * operation.
 *
 * @param string $formattedParent                 The parent resource where this principal access boundary policy
 *                                                will be created. Only organizations are supported.
 *
 *                                                Format:
 *                                                `organizations/{organization_id}/locations/{location}`
 *                                                Please see {@see PrincipalAccessBoundaryPoliciesClient::organizationLocationName()} for help formatting this field.
 * @param string $principalAccessBoundaryPolicyId The ID to use for the principal access boundary policy, which
 *                                                will become the final component of the principal access boundary policy's
 *                                                resource name.
 *
 *                                                This value must start with a lowercase letter followed by up to 62
 *                                                lowercase letters, numbers, hyphens, or dots. Pattern,
 *                                                /[a-z][a-z0-9-\.]{2,62}/.
 */
function create_principal_access_boundary_policy_sample(
    string $formattedParent,
    string $principalAccessBoundaryPolicyId
): void {
    // Create a client.
    $principalAccessBoundaryPoliciesClient = new PrincipalAccessBoundaryPoliciesClient();

    // Prepare the request message.
    $principalAccessBoundaryPolicy = new PrincipalAccessBoundaryPolicy();
    $request = (new CreatePrincipalAccessBoundaryPolicyRequest())
        ->setParent($formattedParent)
        ->setPrincipalAccessBoundaryPolicyId($principalAccessBoundaryPolicyId)
        ->setPrincipalAccessBoundaryPolicy($principalAccessBoundaryPolicy);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $principalAccessBoundaryPoliciesClient->createPrincipalAccessBoundaryPolicy($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var PrincipalAccessBoundaryPolicy $result */
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
    $formattedParent = PrincipalAccessBoundaryPoliciesClient::organizationLocationName(
        '[ORGANIZATION]',
        '[LOCATION]'
    );
    $principalAccessBoundaryPolicyId = '[PRINCIPAL_ACCESS_BOUNDARY_POLICY_ID]';

    create_principal_access_boundary_policy_sample($formattedParent, $principalAccessBoundaryPolicyId);
}
// [END iam_v3_generated_PrincipalAccessBoundaryPolicies_CreatePrincipalAccessBoundaryPolicy_sync]
