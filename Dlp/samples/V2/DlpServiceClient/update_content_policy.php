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

// [START dlp_v2_generated_DlpService_UpdateContentPolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dlp\V2\Client\DlpServiceClient;
use Google\Cloud\Dlp\V2\ContentPolicy;
use Google\Cloud\Dlp\V2\ContentPolicy\PolicyAction;
use Google\Cloud\Dlp\V2\ContentPolicy\PolicyRule;
use Google\Cloud\Dlp\V2\UpdateContentPolicyRequest;

/**
 * Update a ContentPolicy.
 *
 * @param string $formattedName Resource name in the format:
 *                              `projects/{project}/locations/{location}/contentPolicies/{content_policy}`. Please see
 *                              {@see DlpServiceClient::contentPolicyName()} for help formatting this field.
 */
function update_content_policy_sample(string $formattedName): void
{
    // Create a client.
    $dlpServiceClient = new DlpServiceClient();

    // Prepare the request message.
    $contentPolicyRulesAction = new PolicyAction();
    $policyRule = (new PolicyRule())
        ->setAction($contentPolicyRulesAction);
    $contentPolicyRules = [$policyRule,];
    $contentPolicy = (new ContentPolicy())
        ->setRules($contentPolicyRules);
    $request = (new UpdateContentPolicyRequest())
        ->setName($formattedName)
        ->setContentPolicy($contentPolicy);

    // Call the API and handle any network failures.
    try {
        /** @var ContentPolicy $response */
        $response = $dlpServiceClient->updateContentPolicy($request);
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
    $formattedName = DlpServiceClient::contentPolicyName('[PROJECT]', '[LOCATION]', '[CONTENT_POLICY]');

    update_content_policy_sample($formattedName);
}
// [END dlp_v2_generated_DlpService_UpdateContentPolicy_sync]
