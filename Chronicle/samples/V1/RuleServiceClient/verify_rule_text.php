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

// [START chronicle_v1_generated_RuleService_VerifyRuleText_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Chronicle\V1\Client\RuleServiceClient;
use Google\Cloud\Chronicle\V1\VerifyRuleTextRequest;
use Google\Cloud\Chronicle\V1\VerifyRuleTextResponse;

/**
 * Verifies the given rule text.
 *
 * @param string $formattedInstance The name of the parent resource, which is the SecOps instance
 *                                  associated with the request. Format:
 *                                  `projects/{project}/locations/{location}/instances/{instance}`
 *                                  Please see {@see RuleServiceClient::instanceName()} for help formatting this field.
 * @param string $ruleText          The rule text to verify as a UTF-8 string.
 */
function verify_rule_text_sample(string $formattedInstance, string $ruleText): void
{
    // Create a client.
    $ruleServiceClient = new RuleServiceClient();

    // Prepare the request message.
    $request = (new VerifyRuleTextRequest())
        ->setInstance($formattedInstance)
        ->setRuleText($ruleText);

    // Call the API and handle any network failures.
    try {
        /** @var VerifyRuleTextResponse $response */
        $response = $ruleServiceClient->verifyRuleText($request);
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
    $formattedInstance = RuleServiceClient::instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
    $ruleText = '[RULE_TEXT]';

    verify_rule_text_sample($formattedInstance, $ruleText);
}
// [END chronicle_v1_generated_RuleService_VerifyRuleText_sync]
