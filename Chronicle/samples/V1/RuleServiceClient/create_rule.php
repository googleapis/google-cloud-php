<?php
/*
 * Copyright 2025 Google LLC
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

// [START chronicle_v1_generated_RuleService_CreateRule_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Chronicle\V1\Client\RuleServiceClient;
use Google\Cloud\Chronicle\V1\CreateRuleRequest;
use Google\Cloud\Chronicle\V1\Rule;

/**
 * Creates a new Rule.
 *
 * @param string $formattedParent The parent resource where this rule will be created.
 *                                Format: `projects/{project}/locations/{location}/instances/{instance}`
 *                                Please see {@see RuleServiceClient::instanceName()} for help formatting this field.
 */
function create_rule_sample(string $formattedParent): void
{
    // Create a client.
    $ruleServiceClient = new RuleServiceClient();

    // Prepare the request message.
    $rule = new Rule();
    $request = (new CreateRuleRequest())
        ->setParent($formattedParent)
        ->setRule($rule);

    // Call the API and handle any network failures.
    try {
        /** @var Rule $response */
        $response = $ruleServiceClient->createRule($request);
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
    $formattedParent = RuleServiceClient::instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');

    create_rule_sample($formattedParent);
}
// [END chronicle_v1_generated_RuleService_CreateRule_sync]
