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

// [START admanager_v1_generated_CustomTargetingValueService_BatchCreateCustomTargetingValues_sync]
use Google\Ads\AdManager\V1\BatchCreateCustomTargetingValuesRequest;
use Google\Ads\AdManager\V1\BatchCreateCustomTargetingValuesResponse;
use Google\Ads\AdManager\V1\Client\CustomTargetingValueServiceClient;
use Google\Ads\AdManager\V1\CreateCustomTargetingValueRequest;
use Google\Ads\AdManager\V1\CustomTargetingValue;
use Google\Ads\AdManager\V1\CustomTargetingValueMatchTypeEnum\CustomTargetingValueMatchType;
use Google\ApiCore\ApiException;

/**
 * Creates `CustomTargetingValue` objects.
 *
 * @param string $formattedParent                                         The parent, which owns this collection of CustomTargetingValues.
 *                                                                        Format:
 *                                                                        `networks/{network_code}`
 *                                                                        Please see {@see CustomTargetingValueServiceClient::networkName()} for help formatting this field.
 * @param string $formattedRequestsParent                                 The parent, which owns this collection of CustomTargetingValues.
 *                                                                        Format:
 *                                                                        `networks/{network_code}`
 *                                                                        Please see {@see CustomTargetingValueServiceClient::networkName()} for help formatting this field.
 * @param string $formattedRequestsCustomTargetingValueCustomTargetingKey Immutable. The resource name of the `CustomTargetingKey`.
 *                                                                        Format:
 *                                                                        `networks/{network_code}/customTargetingKeys/{custom_targeting_key_id}`
 *                                                                        Please see {@see CustomTargetingValueServiceClient::customTargetingKeyName()} for help formatting this field.
 * @param int    $requestsCustomTargetingValueMatchType                   Immutable. The way in which the CustomTargetingValue.name strings
 *                                                                        will be matched.
 */
function batch_create_custom_targeting_values_sample(
    string $formattedParent,
    string $formattedRequestsParent,
    string $formattedRequestsCustomTargetingValueCustomTargetingKey,
    int $requestsCustomTargetingValueMatchType
): void {
    // Create a client.
    $customTargetingValueServiceClient = new CustomTargetingValueServiceClient();

    // Prepare the request message.
    $requestsCustomTargetingValue = (new CustomTargetingValue())
        ->setCustomTargetingKey($formattedRequestsCustomTargetingValueCustomTargetingKey)
        ->setMatchType($requestsCustomTargetingValueMatchType);
    $createCustomTargetingValueRequest = (new CreateCustomTargetingValueRequest())
        ->setParent($formattedRequestsParent)
        ->setCustomTargetingValue($requestsCustomTargetingValue);
    $requests = [$createCustomTargetingValueRequest,];
    $request = (new BatchCreateCustomTargetingValuesRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchCreateCustomTargetingValuesResponse $response */
        $response = $customTargetingValueServiceClient->batchCreateCustomTargetingValues($request);
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
    $formattedParent = CustomTargetingValueServiceClient::networkName('[NETWORK_CODE]');
    $formattedRequestsParent = CustomTargetingValueServiceClient::networkName('[NETWORK_CODE]');
    $formattedRequestsCustomTargetingValueCustomTargetingKey = CustomTargetingValueServiceClient::customTargetingKeyName(
        '[NETWORK_CODE]',
        '[CUSTOM_TARGETING_KEY]'
    );
    $requestsCustomTargetingValueMatchType = CustomTargetingValueMatchType::CUSTOM_TARGETING_VALUE_MATCH_TYPE_UNSPECIFIED;

    batch_create_custom_targeting_values_sample(
        $formattedParent,
        $formattedRequestsParent,
        $formattedRequestsCustomTargetingValueCustomTargetingKey,
        $requestsCustomTargetingValueMatchType
    );
}
// [END admanager_v1_generated_CustomTargetingValueService_BatchCreateCustomTargetingValues_sync]
