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

// [START orgpolicy_v2_generated_OrgPolicy_CreatePolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\OrgPolicy\V2\Client\OrgPolicyClient;
use Google\Cloud\OrgPolicy\V2\CreatePolicyRequest;
use Google\Cloud\OrgPolicy\V2\Policy;

/**
 * Creates a policy.
 *
 * Returns a `google.rpc.Status` with `google.rpc.Code.NOT_FOUND` if the
 * constraint does not exist.
 * Returns a `google.rpc.Status` with `google.rpc.Code.ALREADY_EXISTS` if the
 * policy already exists on the given Google Cloud resource.
 *
 * @param string $formattedParent The Google Cloud resource that will parent the new policy. Must
 *                                be in one of the following forms:
 *
 *                                * `projects/{project_number}`
 *                                * `projects/{project_id}`
 *                                * `folders/{folder_id}`
 *                                * `organizations/{organization_id}`
 *                                Please see {@see OrgPolicyClient::projectName()} for help formatting this field.
 */
function create_policy_sample(string $formattedParent): void
{
    // Create a client.
    $orgPolicyClient = new OrgPolicyClient();

    // Prepare the request message.
    $policy = new Policy();
    $request = (new CreatePolicyRequest())
        ->setParent($formattedParent)
        ->setPolicy($policy);

    // Call the API and handle any network failures.
    try {
        /** @var Policy $response */
        $response = $orgPolicyClient->createPolicy($request);
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
    $formattedParent = OrgPolicyClient::projectName('[PROJECT]');

    create_policy_sample($formattedParent);
}
// [END orgpolicy_v2_generated_OrgPolicy_CreatePolicy_sync]
