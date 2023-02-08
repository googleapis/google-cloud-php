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

// [START cloudkms_v1_generated_KeyManagementService_CreateKeyRing_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Kms\V1\KeyManagementServiceClient;
use Google\Cloud\Kms\V1\KeyRing;

/**
 * Create a new [KeyRing][google.cloud.kms.v1.KeyRing] in a given Project and
 * Location.
 *
 * @param string $formattedParent The resource name of the location associated with the
 *                                [KeyRings][google.cloud.kms.v1.KeyRing], in the format
 *                                `projects/&#42;/locations/*`. Please see
 *                                {@see KeyManagementServiceClient::locationName()} for help formatting this field.
 * @param string $keyRingId       It must be unique within a location and match the regular
 *                                expression `[a-zA-Z0-9_-]{1,63}`
 */
function create_key_ring_sample(string $formattedParent, string $keyRingId): void
{
    // Create a client.
    $keyManagementServiceClient = new KeyManagementServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $keyRing = new KeyRing();

    // Call the API and handle any network failures.
    try {
        /** @var KeyRing $response */
        $response = $keyManagementServiceClient->createKeyRing($formattedParent, $keyRingId, $keyRing);
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
    $formattedParent = KeyManagementServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $keyRingId = '[KEY_RING_ID]';

    create_key_ring_sample($formattedParent, $keyRingId);
}
// [END cloudkms_v1_generated_KeyManagementService_CreateKeyRing_sync]
