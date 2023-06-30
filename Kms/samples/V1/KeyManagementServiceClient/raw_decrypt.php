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

// [START cloudkms_v1_generated_KeyManagementService_RawDecrypt_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Kms\V1\KeyManagementServiceClient;
use Google\Cloud\Kms\V1\RawDecryptResponse;

/**
 * Decrypts data that was originally encrypted using a raw cryptographic
 * mechanism. The [CryptoKey.purpose][google.cloud.kms.v1.CryptoKey.purpose]
 * must be
 * [RAW_ENCRYPT_DECRYPT][google.cloud.kms.v1.CryptoKey.CryptoKeyPurpose.RAW_ENCRYPT_DECRYPT].
 *
 * @param string $name                 The resource name of the
 *                                     [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] to use for
 *                                     decryption.
 * @param string $ciphertext           The encrypted data originally returned in
 *                                     [RawEncryptResponse.ciphertext][google.cloud.kms.v1.RawEncryptResponse.ciphertext].
 * @param string $initializationVector The initialization vector (IV) used during encryption, which must
 *                                     match the data originally provided in
 *                                     [RawEncryptResponse.initialization_vector][google.cloud.kms.v1.RawEncryptResponse.initialization_vector].
 */
function raw_decrypt_sample(string $name, string $ciphertext, string $initializationVector): void
{
    // Create a client.
    $keyManagementServiceClient = new KeyManagementServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var RawDecryptResponse $response */
        $response = $keyManagementServiceClient->rawDecrypt($name, $ciphertext, $initializationVector);
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
    $name = '[NAME]';
    $ciphertext = '...';
    $initializationVector = '...';

    raw_decrypt_sample($name, $ciphertext, $initializationVector);
}
// [END cloudkms_v1_generated_KeyManagementService_RawDecrypt_sync]
