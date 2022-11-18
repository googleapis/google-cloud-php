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

// [START cloudkms_v1_generated_KeyManagementService_Encrypt_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Kms\V1\EncryptResponse;
use Google\Cloud\Kms\V1\KeyManagementServiceClient;

/**
 * Encrypts data, so that it can only be recovered by a call to
 * [Decrypt][google.cloud.kms.v1.KeyManagementService.Decrypt]. The
 * [CryptoKey.purpose][google.cloud.kms.v1.CryptoKey.purpose] must be
 * [ENCRYPT_DECRYPT][google.cloud.kms.v1.CryptoKey.CryptoKeyPurpose.ENCRYPT_DECRYPT].
 *
 * @param string $name      The resource name of the
 *                          [CryptoKey][google.cloud.kms.v1.CryptoKey] or
 *                          [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] to use for
 *                          encryption.
 *
 *                          If a [CryptoKey][google.cloud.kms.v1.CryptoKey] is specified, the server
 *                          will use its [primary version][google.cloud.kms.v1.CryptoKey.primary].
 * @param string $plaintext The data to encrypt. Must be no larger than 64KiB.
 *
 *                          The maximum size depends on the key version's
 *                          [protection_level][google.cloud.kms.v1.CryptoKeyVersionTemplate.protection_level].
 *                          For [SOFTWARE][google.cloud.kms.v1.ProtectionLevel.SOFTWARE] keys, the
 *                          plaintext must be no larger than 64KiB. For
 *                          [HSM][google.cloud.kms.v1.ProtectionLevel.HSM] keys, the combined length of
 *                          the plaintext and additional_authenticated_data fields must be no larger
 *                          than 8KiB.
 */
function encrypt_sample(string $name, string $plaintext): void
{
    // Create a client.
    $keyManagementServiceClient = new KeyManagementServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var EncryptResponse $response */
        $response = $keyManagementServiceClient->encrypt($name, $plaintext);
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
    $plaintext = '...';

    encrypt_sample($name, $plaintext);
}
// [END cloudkms_v1_generated_KeyManagementService_Encrypt_sync]
