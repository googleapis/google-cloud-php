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

// [START monitoring_v3_generated_AlertPolicyService_GetAlertPolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Monitoring\V3\AlertPolicy;
use Google\Cloud\Monitoring\V3\Client\AlertPolicyServiceClient;
use Google\Cloud\Monitoring\V3\GetAlertPolicyRequest;

/**
 * Gets a single alerting policy.
 *
 * @param string $formattedName The alerting policy to retrieve. The format is:
 *
 *                              projects/[PROJECT_ID_OR_NUMBER]/alertPolicies/[ALERT_POLICY_ID]
 *                              Please see {@see AlertPolicyServiceClient::alertPolicyName()} for help formatting this field.
 */
function get_alert_policy_sample(string $formattedName): void
{
    // Create a client.
    $alertPolicyServiceClient = new AlertPolicyServiceClient();

    // Prepare the request message.
    $request = (new GetAlertPolicyRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var AlertPolicy $response */
        $response = $alertPolicyServiceClient->getAlertPolicy($request);
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
    $formattedName = AlertPolicyServiceClient::alertPolicyName('[PROJECT]', '[ALERT_POLICY]');

    get_alert_policy_sample($formattedName);
}
// [END monitoring_v3_generated_AlertPolicyService_GetAlertPolicy_sync]
