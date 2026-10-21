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

// [START memorystore_v1beta_generated_Memorystore_CreateAclPolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Memorystore\V1beta\AclPolicy;
use Google\Cloud\Memorystore\V1beta\AclRule;
use Google\Cloud\Memorystore\V1beta\Client\MemorystoreClient;
use Google\Cloud\Memorystore\V1beta\CreateAclPolicyRequest;

/**
 * Creates an ACL policy.
 * The creation is executed synchronously and the policy is available for use
 * immediately after the RPC returns.
 *
 * @param string $formattedParent        The resource name of the ACL policy location using the form:
 *                                       `projects/{project}/locations/{location}`
 *                                       where `location` refers to a Google Cloud region. Please see
 *                                       {@see MemorystoreClient::locationName()} for help formatting this field.
 * @param string $aclPolicyId            The logical name of the ACL policy in the customer project
 *                                       with the following restrictions:
 *
 *                                       * Must contain only lowercase letters, numbers, and hyphens.
 *                                       * Must start with a letter.
 *                                       * Must be between 1-63 characters.
 *                                       * Must end with a number or a letter.
 *                                       * Must be unique within the customer project / location
 * @param string $aclPolicyRulesUsername Specifies the IAM user or service account to be added to the ACL
 *                                       policy. This username will be directly set on the Valkey OSS.
 * @param string $aclPolicyRulesRule     The rule to be applied to the username. Ex: "on >password123 ~*
 *                                       +&#64;all" The format of the rule is defined by Valkey OSS:
 *                                       https://valkey.io/topics/acl/
 */
function create_acl_policy_sample(
    string $formattedParent,
    string $aclPolicyId,
    string $aclPolicyRulesUsername,
    string $aclPolicyRulesRule
): void {
    // Create a client.
    $memorystoreClient = new MemorystoreClient();

    // Prepare the request message.
    $aclRule = (new AclRule())
        ->setUsername($aclPolicyRulesUsername)
        ->setRule($aclPolicyRulesRule);
    $aclPolicyRules = [$aclRule];
    $aclPolicy = (new AclPolicy())
        ->setRules($aclPolicyRules);
    $request = (new CreateAclPolicyRequest())
        ->setParent($formattedParent)
        ->setAclPolicyId($aclPolicyId)
        ->setAclPolicy($aclPolicy);

    // Call the API and handle any network failures.
    try {
        /** @var AclPolicy $response */
        $response = $memorystoreClient->createAclPolicy($request);
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
    $formattedParent = MemorystoreClient::locationName('[PROJECT]', '[LOCATION]');
    $aclPolicyId = '[ACL_POLICY_ID]';
    $aclPolicyRulesUsername = '[USERNAME]';
    $aclPolicyRulesRule = '[RULE]';

    create_acl_policy_sample(
        $formattedParent,
        $aclPolicyId,
        $aclPolicyRulesUsername,
        $aclPolicyRulesRule
    );
}
// [END memorystore_v1beta_generated_Memorystore_CreateAclPolicy_sync]
