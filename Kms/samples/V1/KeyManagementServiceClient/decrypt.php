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

// [START cloudkms_v1_generated_KeyManagementService_Decrypt_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Kms\V1\Client\KeyManagementServiceClient;
use Google\Cloud\Kms\V1\DecryptRequest;
use Google\Cloud\Kms\V1\DecryptResponse;

/**
 * Decrypts data that was protected by
 * [Encrypt][google.cloud.kms.v1.KeyManagementService.Encrypt]. The
 * [CryptoKey.purpose][google.cloud.kms.v1.CryptoKey.purpose] must be
 * [ENCRYPT_DECRYPT][google.cloud.kms.v1.CryptoKey.CryptoKeyPurpose.ENCRYPT_DECRYPT].
 *
 * @param string $formattedName The resource name of the
 *                              [CryptoKey][google.cloud.kms.v1.CryptoKey] to use for decryption. The
 *                              server will choose the appropriate version. Please see
 *                              {@see KeyManagementServiceClient::cryptoKeyName()} for help formatting this field.
 * @param string $ciphertext    The encrypted data originally returned in
 *                              [EncryptResponse.ciphertext][google.cloud.kms.v1.EncryptResponse.ciphertext].
 */
function decrypt_sample(string $formattedName, string $ciphertext): void
{
    // Create a client.
    $keyManagementServiceClient = new KeyManagementServiceClient();

    // Prepare the request message.
    $request = (new DecryptRequest())
        ->setName($formattedName)
        ->setCiphertext($ciphertext);

    // Call the API and handle any network failures.
    try {
        /** @var DecryptResponse $response */
        $response = $keyManagementServiceClient->decrypt($request);
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
    $ciphertext = '...';

    decrypt_sample($formattedName, $ciphertext);
}
// [END cloudkms_v1_generated_KeyManagementService_Decrypt_sync]
