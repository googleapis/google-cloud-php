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

// [START cloudkms_v1_generated_KeyManagementService_ImportTrustedKeyWrappedCryptoKeyVersion_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Kms\V1\Client\KeyManagementServiceClient;
use Google\Cloud\Kms\V1\CryptoKeyVersion;
use Google\Cloud\Kms\V1\CryptoKeyVersion\CryptoKeyVersionAlgorithm;
use Google\Cloud\Kms\V1\ImportTrustedKeyWrappedCryptoKeyVersionRequest;

/**
 * Import wrapped key material into a
 * [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] with a trusted
 * key.
 *
 * All requests must specify a [CryptoKey][google.cloud.kms.v1.CryptoKey]. If
 * a [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] is additionally
 * specified in the request, key material will be reimported into that
 * version. Otherwise, a new version will be created, and will be assigned the
 * next sequential id within the [CryptoKey][google.cloud.kms.v1.CryptoKey].
 *
 * The [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] will have
 * trusted_wrapping_enabled set to true.
 *
 * @param string $parent       The [name][google.cloud.kms.v1.CryptoKey.name] of the
 *                             [CryptoKey][google.cloud.kms.v1.CryptoKey] to be imported into.
 * @param string $importingKey Required - the CKV of the trusted key used to import.
 *                             This can be the name of a CryptoKeyVersion or a CryptoKey.
 * @param string $wrappedKey   The target key pre-wrapped on premises.
 * @param int    $algorithm    Required - The
 *                             [algorithm][google.cloud.kms.v1.CryptoKeyVersion.CryptoKeyVersionAlgorithm]
 *                             of the key being imported. This does not need to match the
 *                             [version_template][google.cloud.kms.v1.CryptoKey.version_template] of the
 *                             [CryptoKey][google.cloud.kms.v1.CryptoKey] this version imports into.
 */
function import_trusted_key_wrapped_crypto_key_version_sample(
    string $parent,
    string $importingKey,
    string $wrappedKey,
    int $algorithm
): void {
    // Create a client.
    $keyManagementServiceClient = new KeyManagementServiceClient();

    // Prepare the request message.
    $request = (new ImportTrustedKeyWrappedCryptoKeyVersionRequest())
        ->setParent($parent)
        ->setImportingKey($importingKey)
        ->setWrappedKey($wrappedKey)
        ->setAlgorithm($algorithm);

    // Call the API and handle any network failures.
    try {
        /** @var CryptoKeyVersion $response */
        $response = $keyManagementServiceClient->importTrustedKeyWrappedCryptoKeyVersion($request);
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
    $parent = '[PARENT]';
    $importingKey = '[IMPORTING_KEY]';
    $wrappedKey = '...';
    $algorithm = CryptoKeyVersionAlgorithm::CRYPTO_KEY_VERSION_ALGORITHM_UNSPECIFIED;

    import_trusted_key_wrapped_crypto_key_version_sample(
        $parent,
        $importingKey,
        $wrappedKey,
        $algorithm
    );
}
// [END cloudkms_v1_generated_KeyManagementService_ImportTrustedKeyWrappedCryptoKeyVersion_sync]
