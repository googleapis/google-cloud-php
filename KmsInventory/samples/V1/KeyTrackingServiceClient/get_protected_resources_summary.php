<?php
/*
 * Copyright 2023 Google LLC
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

// [START kmsinventory_v1_generated_KeyTrackingService_GetProtectedResourcesSummary_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Kms\Inventory\V1\KeyTrackingServiceClient;
use Google\Cloud\Kms\Inventory\V1\ProtectedResourcesSummary;

/**
 * Returns aggregate information about the resources protected by the given
 * Cloud KMS [CryptoKey][google.cloud.kms.v1.CryptoKey]. Only resources within
 * the same Cloud organization as the key will be returned. The project that
 * holds the key must be part of an organization in order for this call to
 * succeed.
 *
 * @param string $formattedName The resource name of the
 *                              [CryptoKey][google.cloud.kms.v1.CryptoKey]. Please see
 *                              {@see KeyTrackingServiceClient::protectedResourcesSummaryName()} for help formatting this field.
 */
function get_protected_resources_summary_sample(string $formattedName): void
{
    // Create a client.
    $keyTrackingServiceClient = new KeyTrackingServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var ProtectedResourcesSummary $response */
        $response = $keyTrackingServiceClient->getProtectedResourcesSummary($formattedName);
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
    $formattedName = KeyTrackingServiceClient::protectedResourcesSummaryName(
        '[PROJECT]',
        '[LOCATION]',
        '[KEY_RING]',
        '[CRYPTO_KEY]'
    );

    get_protected_resources_summary_sample($formattedName);
}
// [END kmsinventory_v1_generated_KeyTrackingService_GetProtectedResourcesSummary_sync]
