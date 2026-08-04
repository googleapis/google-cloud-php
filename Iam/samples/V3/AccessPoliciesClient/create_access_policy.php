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

// [START iam_v3_generated_AccessPolicies_CreateAccessPolicy_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Iam\V3\AccessPolicy;
use Google\Cloud\Iam\V3\Client\AccessPoliciesClient;
use Google\Cloud\Iam\V3\CreateAccessPolicyRequest;
use Google\Rpc\Status;

/**
 * Creates an access policy, and returns a long running operation.
 *
 * @param string $formattedParent The parent resource where this access policy will be created.
 *
 *                                Format:
 *                                `projects/{project_id}/locations/{location}`
 *                                `projects/{project_number}/locations/{location}`
 *                                `folders/{folder_id}/locations/{location}`
 *                                `organizations/{organization_id}/locations/{location}`
 *                                Please see {@see AccessPoliciesClient::organizationLocationName()} for help formatting this field.
 * @param string $accessPolicyId  The ID to use for the access policy, which
 *                                will become the final component of the access policy's
 *                                resource name.
 *
 *                                This value must start with a lowercase letter followed by up to 62
 *                                lowercase letters, numbers, hyphens, or dots. Pattern,
 *                                /[a-z][a-z0-9-\.]{2,62}/.
 *
 *                                This value must be unique among all access policies with the same parent.
 */
function create_access_policy_sample(string $formattedParent, string $accessPolicyId): void
{
    // Create a client.
    $accessPoliciesClient = new AccessPoliciesClient();

    // Prepare the request message.
    $accessPolicy = new AccessPolicy();
    $request = (new CreateAccessPolicyRequest())
        ->setParent($formattedParent)
        ->setAccessPolicyId($accessPolicyId)
        ->setAccessPolicy($accessPolicy);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $accessPoliciesClient->createAccessPolicy($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AccessPolicy $result */
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
    $formattedParent = AccessPoliciesClient::organizationLocationName('[ORGANIZATION]', '[LOCATION]');
    $accessPolicyId = '[ACCESS_POLICY_ID]';

    create_access_policy_sample($formattedParent, $accessPolicyId);
}
// [END iam_v3_generated_AccessPolicies_CreateAccessPolicy_sync]
