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

// [START cloudkms_v1_generated_KeyManagementService_ExportTrustedKeyWrappedCryptoKeyVersion_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Kms\V1\Client\KeyManagementServiceClient;
use Google\Cloud\Kms\V1\ExportTrustedKeyWrappedCryptoKeyVersionRequest;
use Google\Cloud\Kms\V1\ExportTrustedKeyWrappedCryptoKeyVersionResponse;

/**
 * Exports a [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] with a
 * trusted key.
 *
 * The [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] must have
 * trusted_wrapping_enabled set to true. The
 * [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] of the
 * [wrapping_key] must have the
 * [AES_WRAPPING][google.cloud.kms.v1.CryptoKey.CryptoKeyPurpose.AES_WRAPPING]
 * purpose. The [wrapping_key] must have the
 * [AES_256_KWP][google.cloud.kms.v1.CryptoKeyVersion.CryptoKeyVersionAlgorithm.AES_256_KWP]
 * algorithm.
 *
 * @param string $formattedName        The [name][google.cloud.kms.v1.CryptoKeyVersion.name] of the
 *                                     [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] to export. The
 *                                     [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] must have
 *                                     [trusted_wrapping_enabled][google.cloud.kms.v1.CryptoKeyVersion.trusted_wrapping_enabled]
 *                                     set to true. Please see
 *                                     {@see KeyManagementServiceClient::cryptoKeyVersionName()} for help formatting this field.
 * @param string $formattedWrappingKey The [name][google.cloud.kms.v1.CryptoKeyVersion.name] of the
 *                                     [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] to use as a
 *                                     wrapping key. The [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion]
 *                                     must have [hsm_trusted][google.cloud.kms.v1.CryptoKeyVersion.hsm_trusted]
 *                                     set to true. Please see
 *                                     {@see KeyManagementServiceClient::cryptoKeyVersionName()} for help formatting this field.
 */
function export_trusted_key_wrapped_crypto_key_version_sample(
    string $formattedName,
    string $formattedWrappingKey
): void {
    // Create a client.
    $keyManagementServiceClient = new KeyManagementServiceClient();

    // Prepare the request message.
    $request = (new ExportTrustedKeyWrappedCryptoKeyVersionRequest())
        ->setName($formattedName)
        ->setWrappingKey($formattedWrappingKey);

    // Call the API and handle any network failures.
    try {
        /** @var ExportTrustedKeyWrappedCryptoKeyVersionResponse $response */
        $response = $keyManagementServiceClient->exportTrustedKeyWrappedCryptoKeyVersion($request);
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
    $formattedName = KeyManagementServiceClient::cryptoKeyVersionName(
        '[PROJECT]',
        '[LOCATION]',
        '[KEY_RING]',
        '[CRYPTO_KEY]',
        '[CRYPTO_KEY_VERSION]'
    );
    $formattedWrappingKey = KeyManagementServiceClient::cryptoKeyVersionName(
        '[PROJECT]',
        '[LOCATION]',
        '[KEY_RING]',
        '[CRYPTO_KEY]',
        '[CRYPTO_KEY_VERSION]'
    );

    export_trusted_key_wrapped_crypto_key_version_sample($formattedName, $formattedWrappingKey);
}
// [END cloudkms_v1_generated_KeyManagementService_ExportTrustedKeyWrappedCryptoKeyVersion_sync]
