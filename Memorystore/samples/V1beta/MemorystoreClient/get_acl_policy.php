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

// [START memorystore_v1beta_generated_Memorystore_GetAclPolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Memorystore\V1beta\AclPolicy;
use Google\Cloud\Memorystore\V1beta\Client\MemorystoreClient;
use Google\Cloud\Memorystore\V1beta\GetAclPolicyRequest;

/**
 * Gets the details of a specific Memorystore ACL policy.
 *
 * @param string $formattedName Memorystore ACL policy resource name using the form:
 *                              `projects/{project}/locations/{location}/aclPolicies/{acl_policy}`
 *                              where `location` refers to a Google Cloud region. Please see
 *                              {@see MemorystoreClient::aclPolicyName()} for help formatting this field.
 */
function get_acl_policy_sample(string $formattedName): void
{
    // Create a client.
    $memorystoreClient = new MemorystoreClient();

    // Prepare the request message.
    $request = (new GetAclPolicyRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var AclPolicy $response */
        $response = $memorystoreClient->getAclPolicy($request);
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
    $formattedName = MemorystoreClient::aclPolicyName('[PROJECT]', '[LOCATION]', '[ACL_POLICY]');

    get_acl_policy_sample($formattedName);
}
// [END memorystore_v1beta_generated_Memorystore_GetAclPolicy_sync]
