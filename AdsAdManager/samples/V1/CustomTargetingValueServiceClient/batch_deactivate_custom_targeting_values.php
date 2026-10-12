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

// [START admanager_v1_generated_CustomTargetingValueService_BatchDeactivateCustomTargetingValues_sync]
use Google\Ads\AdManager\V1\BatchDeactivateCustomTargetingValuesRequest;
use Google\Ads\AdManager\V1\BatchDeactivateCustomTargetingValuesResponse;
use Google\Ads\AdManager\V1\Client\CustomTargetingValueServiceClient;
use Google\Ads\AdManager\V1\DeactivateCustomTargetingValueRequest;
use Google\ApiCore\ApiException;

/**
 * Deactivates a list of `CustomTargetingValue` objects.
 *
 * @param string $formattedParent       The parent, which owns this collection of CustomTargetingValues.
 *                                      Format:
 *                                      `networks/{network_code}/`
 *                                      Please see {@see CustomTargetingValueServiceClient::networkName()} for help formatting this field.
 * @param string $formattedRequestsName The resource name of the CustomTargetingValue.
 *                                      Format:
 *                                      `networks/{network_code}/customTargetingValues/{custom_targeting_value_id}`
 *                                      Please see {@see CustomTargetingValueServiceClient::customTargetingValueName()} for help formatting this field.
 */
function batch_deactivate_custom_targeting_values_sample(
    string $formattedParent,
    string $formattedRequestsName
): void {
    // Create a client.
    $customTargetingValueServiceClient = new CustomTargetingValueServiceClient();

    // Prepare the request message.
    $deactivateCustomTargetingValueRequest = (new DeactivateCustomTargetingValueRequest())
        ->setName($formattedRequestsName);
    $requests = [$deactivateCustomTargetingValueRequest,];
    $request = (new BatchDeactivateCustomTargetingValuesRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BatchDeactivateCustomTargetingValuesResponse $response */
        $response = $customTargetingValueServiceClient->batchDeactivateCustomTargetingValues($request);
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
    $formattedRequestsName = CustomTargetingValueServiceClient::customTargetingValueName(
        '[NETWORK_CODE]',
        '[CUSTOM_TARGETING_VALUE]'
    );

    batch_deactivate_custom_targeting_values_sample($formattedParent, $formattedRequestsName);
}
// [END admanager_v1_generated_CustomTargetingValueService_BatchDeactivateCustomTargetingValues_sync]
