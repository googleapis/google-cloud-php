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

// [START admanager_v1_generated_AdRuleService_BatchUpdateAdRules_sync]
use Google\Ads\AdManager\V1\AdRule;
use Google\Ads\AdManager\V1\AdRuleSlot;
use Google\Ads\AdManager\V1\BatchUpdateAdRulesRequest;
use Google\Ads\AdManager\V1\BatchUpdateAdRulesResponse;
use Google\Ads\AdManager\V1\Client\AdRuleServiceClient;
use Google\Ads\AdManager\V1\Targeting;
use Google\Ads\AdManager\V1\UpdateAdRuleRequest;
use Google\ApiCore\ApiException;
use Google\Protobuf\Timestamp;

/**
 * Batch updates `AdRule` objects.
 *
 * @param string $formattedParent           The parent resource where `AdRules` will be updated.
 *                                          Format: `networks/{network_code}`
 *                                          The parent field in the UpdateAdRuleRequest must match this
 *                                          field. Please see
 *                                          {@see AdRuleServiceClient::networkName()} for help formatting this field.
 * @param string $requestsAdRuleDisplayName The unique name of the AdRule. This attribute is required to
 *                                          create an ad rule and has a maximum length of 255 characters.
 */
function batch_update_ad_rules_sample(
    string $formattedParent,
    string $requestsAdRuleDisplayName
): void {
    // Create a client.
    $adRuleServiceClient = new AdRuleServiceClient();

    // Prepare the request message.
    $requestsAdRuleStartTime = new Timestamp();
    $requestsAdRulePreroll = new AdRuleSlot();
    $requestsAdRuleMidrolls = [new AdRuleSlot()];
    $requestsAdRulePostroll = new AdRuleSlot();
    $requestsAdRuleTargeting = new Targeting();
    $requestsAdRule = (new AdRule())
        ->setDisplayName($requestsAdRuleDisplayName)
        ->setStartTime($requestsAdRuleStartTime)
        ->setPreroll($requestsAdRulePreroll)
        ->setMidrolls($requestsAdRuleMidrolls)
        ->setPostroll($requestsAdRulePostroll)
        ->setTargeting($requestsAdRuleTargeting);
    $updateAdRuleRequest = (new UpdateAdRuleRequest())
        ->setAdRule($requestsAdRule);
    $requests = [$updateAdRuleRequest,];
    $request = (new BatchUpdateAdRulesRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchUpdateAdRulesResponse $response */
        $response = $adRuleServiceClient->batchUpdateAdRules($request);
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
    $formattedParent = AdRuleServiceClient::networkName('[NETWORK_CODE]');
    $requestsAdRuleDisplayName = '[DISPLAY_NAME]';

    batch_update_ad_rules_sample($formattedParent, $requestsAdRuleDisplayName);
}
// [END admanager_v1_generated_AdRuleService_BatchUpdateAdRules_sync]
