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

// [START admanager_v1_generated_CustomTargetingKeyService_BatchDeactivateCustomTargetingKeys_sync]
use Google\Ads\AdManager\V1\BatchDeactivateCustomTargetingKeysRequest;
use Google\Ads\AdManager\V1\BatchDeactivateCustomTargetingKeysResponse;
use Google\Ads\AdManager\V1\Client\CustomTargetingKeyServiceClient;
use Google\ApiCore\ApiException;

/**
 * Deactivates a list of `CustomTargetingKey` objects.
 *
 * @param string $formattedParent       Format: `networks/{network_code}`
 *                                      Please see {@see CustomTargetingKeyServiceClient::networkName()} for help formatting this field.
 * @param string $formattedNamesElement The resource names of the `CustomTargetingKey`s to deactivate.
 *                                      Format:
 *                                      `networks/{network_code}/customTargetingKeys/{custom_targeting_key_id}`
 *                                      Please see {@see CustomTargetingKeyServiceClient::customTargetingKeyName()} for help formatting this field.
 */
function batch_deactivate_custom_targeting_keys_sample(
    string $formattedParent,
    string $formattedNamesElement
): void {
    // Create a client.
    $customTargetingKeyServiceClient = new CustomTargetingKeyServiceClient();

    // Prepare the request message.
    $formattedNames = [$formattedNamesElement,];
    $request = (new BatchDeactivateCustomTargetingKeysRequest())
        ->setParent($formattedParent)
        ->setNames($formattedNames);

    // Call the API and handle any network failures.
    try {
        /** @var BatchDeactivateCustomTargetingKeysResponse $response */
        $response = $customTargetingKeyServiceClient->batchDeactivateCustomTargetingKeys($request);
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
    $formattedParent = CustomTargetingKeyServiceClient::networkName('[NETWORK_CODE]');
    $formattedNamesElement = CustomTargetingKeyServiceClient::customTargetingKeyName(
        '[NETWORK_CODE]',
        '[CUSTOM_TARGETING_KEY]'
    );

    batch_deactivate_custom_targeting_keys_sample($formattedParent, $formattedNamesElement);
}
// [END admanager_v1_generated_CustomTargetingKeyService_BatchDeactivateCustomTargetingKeys_sync]
