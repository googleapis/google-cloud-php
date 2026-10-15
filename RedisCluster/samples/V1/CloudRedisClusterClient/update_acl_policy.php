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

// [START redis_v1_generated_CloudRedisCluster_UpdateAclPolicy_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Redis\Cluster\V1\AclPolicy;
use Google\Cloud\Redis\Cluster\V1\AclRule;
use Google\Cloud\Redis\Cluster\V1\Client\CloudRedisClusterClient;
use Google\Cloud\Redis\Cluster\V1\UpdateAclPolicyRequest;
use Google\Rpc\Status;

/**
 * Updates the ACL policy.
 *
 * The operation applies the updated ACL policy to all of the linked clusters.
 * If Memorystore can apply the policy to all clusters, then the operation
 * returns a SUCCESS status. If Memorystore can't apply the policy to all
 * clusters, then to ensure eventual consistency, Memorystore uses
 * reconciliation to apply the policy to the failed clusters.
 *
 * Completed longrunning.Operation will contain the new ACL policy object in
 * the response field.
 *
 * @param string $aclPolicyRulesUsername Specifies the IAM user or service account to be added to the ACL
 *                                       policy. This username will be directly set on the Redis OSS.
 * @param string $aclPolicyRulesRule     The rule to be applied to the username. Ex: "on >password123 ~*
 *                                       +&#64;all" The format of the rule is defined by Redis OSS:
 *                                       https://redis.io/docs/latest/operate/oss_and_stack/management/security/acl/
 */
function update_acl_policy_sample(
    string $aclPolicyRulesUsername,
    string $aclPolicyRulesRule
): void {
    // Create a client.
    $cloudRedisClusterClient = new CloudRedisClusterClient();

    // Prepare the request message.
    $aclRule = (new AclRule())
        ->setUsername($aclPolicyRulesUsername)
        ->setRule($aclPolicyRulesRule);
    $aclPolicyRules = [$aclRule,];
    $aclPolicy = (new AclPolicy())
        ->setRules($aclPolicyRules);
    $request = (new UpdateAclPolicyRequest())
        ->setAclPolicy($aclPolicy);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudRedisClusterClient->updateAclPolicy($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AclPolicy $result */
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
    $aclPolicyRulesUsername = '[USERNAME]';
    $aclPolicyRulesRule = '[RULE]';

    update_acl_policy_sample($aclPolicyRulesUsername, $aclPolicyRulesRule);
}
// [END redis_v1_generated_CloudRedisCluster_UpdateAclPolicy_sync]
