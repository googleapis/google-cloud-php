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

// [START cloudkms_v1_generated_KeyManagementService_RawEncrypt_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Kms\V1\Client\KeyManagementServiceClient;
use Google\Cloud\Kms\V1\RawEncryptRequest;
use Google\Cloud\Kms\V1\RawEncryptResponse;

/**
 * Encrypts data using portable cryptographic primitives. Most users should
 * choose [Encrypt][google.cloud.kms.v1.KeyManagementService.Encrypt] and
 * [Decrypt][google.cloud.kms.v1.KeyManagementService.Decrypt] rather than
 * their raw counterparts. The
 * [CryptoKey.purpose][google.cloud.kms.v1.CryptoKey.purpose] must be
 * [RAW_ENCRYPT_DECRYPT][google.cloud.kms.v1.CryptoKey.CryptoKeyPurpose.RAW_ENCRYPT_DECRYPT].
 *
 * @param string $name      The resource name of the
 *                          [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] to use for
 *                          encryption.
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
function raw_encrypt_sample(string $name, string $plaintext): void
{
    // Create a client.
    $keyManagementServiceClient = new KeyManagementServiceClient();

    // Prepare the request message.
    $request = (new RawEncryptRequest())
        ->setName($name)
        ->setPlaintext($plaintext);

    // Call the API and handle any network failures.
    try {
        /** @var RawEncryptResponse $response */
        $response = $keyManagementServiceClient->rawEncrypt($request);
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

    raw_encrypt_sample($name, $plaintext);
}
// [END cloudkms_v1_generated_KeyManagementService_RawEncrypt_sync]
