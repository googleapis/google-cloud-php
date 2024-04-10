<?php
/*
 * Copyright 2023 Google LLC
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

// [START recaptchaenterprise_v1_generated_RecaptchaEnterpriseService_GetFirewallPolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\RecaptchaEnterprise\V1\Client\RecaptchaEnterpriseServiceClient;
use Google\Cloud\RecaptchaEnterprise\V1\FirewallPolicy;
use Google\Cloud\RecaptchaEnterprise\V1\GetFirewallPolicyRequest;

/**
 * Returns the specified firewall policy.
 *
 * @param string $formattedName The name of the requested policy, in the format
 *                              `projects/{project}/firewallpolicies/{firewallpolicy}`. Please see
 *                              {@see RecaptchaEnterpriseServiceClient::firewallPolicyName()} for help formatting this field.
 */
function get_firewall_policy_sample(string $formattedName): void
{
    // Create a client.
    $recaptchaEnterpriseServiceClient = new RecaptchaEnterpriseServiceClient();

    // Prepare the request message.
    $request = (new GetFirewallPolicyRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var FirewallPolicy $response */
        $response = $recaptchaEnterpriseServiceClient->getFirewallPolicy($request);
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
    $formattedName = RecaptchaEnterpriseServiceClient::firewallPolicyName(
        '[PROJECT]',
        '[FIREWALLPOLICY]'
    );

    get_firewall_policy_sample($formattedName);
}
// [END recaptchaenterprise_v1_generated_RecaptchaEnterpriseService_GetFirewallPolicy_sync]
