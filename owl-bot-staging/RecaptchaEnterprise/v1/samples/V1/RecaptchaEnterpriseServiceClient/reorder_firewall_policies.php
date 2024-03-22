<?php
/*
 * Copyright 2024 Google LLC
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

// [START recaptchaenterprise_v1_generated_RecaptchaEnterpriseService_ReorderFirewallPolicies_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\RecaptchaEnterprise\V1\Client\RecaptchaEnterpriseServiceClient;
use Google\Cloud\RecaptchaEnterprise\V1\ReorderFirewallPoliciesRequest;
use Google\Cloud\RecaptchaEnterprise\V1\ReorderFirewallPoliciesResponse;

/**
 * Reorders all firewall policies.
 *
 * @param string $formattedParent       The name of the project to list the policies for, in the format
 *                                      `projects/{project}`. Please see
 *                                      {@see RecaptchaEnterpriseServiceClient::projectName()} for help formatting this field.
 * @param string $formattedNamesElement A list containing all policy names, in the new order. Each name
 *                                      is in the format `projects/{project}/firewallpolicies/{firewallpolicy}`. Please see
 *                                      {@see RecaptchaEnterpriseServiceClient::firewallPolicyName()} for help formatting this field.
 */
function reorder_firewall_policies_sample(
    string $formattedParent,
    string $formattedNamesElement
): void {
    // Create a client.
    $recaptchaEnterpriseServiceClient = new RecaptchaEnterpriseServiceClient();

    // Prepare the request message.
    $formattedNames = [$formattedNamesElement,];
    $request = (new ReorderFirewallPoliciesRequest())
        ->setParent($formattedParent)
        ->setNames($formattedNames);

    // Call the API and handle any network failures.
    try {
        /** @var ReorderFirewallPoliciesResponse $response */
        $response = $recaptchaEnterpriseServiceClient->reorderFirewallPolicies($request);
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
    $formattedParent = RecaptchaEnterpriseServiceClient::projectName('[PROJECT]');
    $formattedNamesElement = RecaptchaEnterpriseServiceClient::firewallPolicyName(
        '[PROJECT]',
        '[FIREWALLPOLICY]'
    );

    reorder_firewall_policies_sample($formattedParent, $formattedNamesElement);
}
// [END recaptchaenterprise_v1_generated_RecaptchaEnterpriseService_ReorderFirewallPolicies_sync]
