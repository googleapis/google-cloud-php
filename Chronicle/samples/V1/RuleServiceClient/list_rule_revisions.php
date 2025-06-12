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

// [START chronicle_v1_generated_RuleService_ListRuleRevisions_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Chronicle\V1\Client\RuleServiceClient;
use Google\Cloud\Chronicle\V1\ListRuleRevisionsRequest;
use Google\Cloud\Chronicle\V1\Rule;

/**
 * Lists all revisions of the rule.
 *
 * @param string $formattedName The name of the rule to list revisions for.
 *                              Format:
 *                              `projects/{project}/locations/{location}/instances/{instance}/rules/{rule}`
 *                              Please see {@see RuleServiceClient::ruleName()} for help formatting this field.
 */
function list_rule_revisions_sample(string $formattedName): void
{
    // Create a client.
    $ruleServiceClient = new RuleServiceClient();

    // Prepare the request message.
    $request = (new ListRuleRevisionsRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $ruleServiceClient->listRuleRevisions($request);

        /** @var Rule $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedName = RuleServiceClient::ruleName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[RULE]');

    list_rule_revisions_sample($formattedName);
}
// [END chronicle_v1_generated_RuleService_ListRuleRevisions_sync]
