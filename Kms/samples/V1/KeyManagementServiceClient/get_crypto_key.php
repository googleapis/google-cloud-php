<?php
/*
 * Copyright 2022 Google LLC
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

// [START cloudkms_v1_generated_KeyManagementService_GetCryptoKey_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Kms\V1\Client\KeyManagementServiceClient;
use Google\Cloud\Kms\V1\CryptoKey;
use Google\Cloud\Kms\V1\GetCryptoKeyRequest;

/**
 * Returns metadata for a given [CryptoKey][google.cloud.kms.v1.CryptoKey], as
 * well as its [primary][google.cloud.kms.v1.CryptoKey.primary]
 * [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion].
 *
 * @param string $formattedName The [name][google.cloud.kms.v1.CryptoKey.name] of the
 *                              [CryptoKey][google.cloud.kms.v1.CryptoKey] to get. Please see
 *                              {@see KeyManagementServiceClient::cryptoKeyName()} for help formatting this field.
 */
function get_crypto_key_sample(string $formattedName): void
{
    // Create a client.
    $keyManagementServiceClient = new KeyManagementServiceClient();

    // Prepare the request message.
    $request = (new GetCryptoKeyRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var CryptoKey $response */
        $response = $keyManagementServiceClient->getCryptoKey($request);
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
    $formattedName = KeyManagementServiceClient::cryptoKeyName(
        '[PROJECT]',
        '[LOCATION]',
        '[KEY_RING]',
        '[CRYPTO_KEY]'
    );

    get_crypto_key_sample($formattedName);
}
// [END cloudkms_v1_generated_KeyManagementService_GetCryptoKey_sync]
