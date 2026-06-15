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

// [START networksecurity_v1_generated_NetworkSecurity_UpdateGatewaySecurityPolicyRule_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkSecurity\V1\Client\NetworkSecurityClient;
use Google\Cloud\NetworkSecurity\V1\GatewaySecurityPolicyRule;
use Google\Cloud\NetworkSecurity\V1\GatewaySecurityPolicyRule\BasicProfile;
use Google\Cloud\NetworkSecurity\V1\UpdateGatewaySecurityPolicyRuleRequest;
use Google\Rpc\Status;

/**
 * Updates the parameters of a single GatewaySecurityPolicyRule.
 *
 * @param int    $gatewaySecurityPolicyRuleBasicProfile   Profile which tells what the primitive action should be.
 * @param string $gatewaySecurityPolicyRuleName           Immutable. Name of the resource. ame is the full resource name so
 *                                                        projects/{project}/locations/{location}/gatewaySecurityPolicies/{gateway_security_policy}/rules/{rule}
 *                                                        rule should match the
 *                                                        pattern: (^[a-z]([a-z0-9-]{0,61}[a-z0-9])?$).
 * @param bool   $gatewaySecurityPolicyRuleEnabled        Whether the rule is enforced.
 * @param int    $gatewaySecurityPolicyRulePriority       Priority of the rule.
 *                                                        Lower number corresponds to higher precedence.
 * @param string $gatewaySecurityPolicyRuleSessionMatcher CEL expression for matching on session criteria.
 */
function update_gateway_security_policy_rule_sample(
    int $gatewaySecurityPolicyRuleBasicProfile,
    string $gatewaySecurityPolicyRuleName,
    bool $gatewaySecurityPolicyRuleEnabled,
    int $gatewaySecurityPolicyRulePriority,
    string $gatewaySecurityPolicyRuleSessionMatcher
): void {
    // Create a client.
    $networkSecurityClient = new NetworkSecurityClient();

    // Prepare the request message.
    $gatewaySecurityPolicyRule = (new GatewaySecurityPolicyRule())
        ->setBasicProfile($gatewaySecurityPolicyRuleBasicProfile)
        ->setName($gatewaySecurityPolicyRuleName)
        ->setEnabled($gatewaySecurityPolicyRuleEnabled)
        ->setPriority($gatewaySecurityPolicyRulePriority)
        ->setSessionMatcher($gatewaySecurityPolicyRuleSessionMatcher);
    $request = (new UpdateGatewaySecurityPolicyRuleRequest())
        ->setGatewaySecurityPolicyRule($gatewaySecurityPolicyRule);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $networkSecurityClient->updateGatewaySecurityPolicyRule($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var GatewaySecurityPolicyRule $result */
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
    $gatewaySecurityPolicyRuleBasicProfile = BasicProfile::BASIC_PROFILE_UNSPECIFIED;
    $gatewaySecurityPolicyRuleName = '[NAME]';
    $gatewaySecurityPolicyRuleEnabled = false;
    $gatewaySecurityPolicyRulePriority = 0;
    $gatewaySecurityPolicyRuleSessionMatcher = '[SESSION_MATCHER]';

    update_gateway_security_policy_rule_sample(
        $gatewaySecurityPolicyRuleBasicProfile,
        $gatewaySecurityPolicyRuleName,
        $gatewaySecurityPolicyRuleEnabled,
        $gatewaySecurityPolicyRulePriority,
        $gatewaySecurityPolicyRuleSessionMatcher
    );
}
// [END networksecurity_v1_generated_NetworkSecurity_UpdateGatewaySecurityPolicyRule_sync]
