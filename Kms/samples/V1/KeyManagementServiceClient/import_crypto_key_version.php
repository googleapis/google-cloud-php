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

// [START cloudkms_v1_generated_KeyManagementService_ImportCryptoKeyVersion_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Kms\V1\Client\KeyManagementServiceClient;
use Google\Cloud\Kms\V1\CryptoKeyVersion;
use Google\Cloud\Kms\V1\CryptoKeyVersion\CryptoKeyVersionAlgorithm;
use Google\Cloud\Kms\V1\ImportCryptoKeyVersionRequest;

/**
 * Import wrapped key material into a
 * [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion].
 *
 * All requests must specify a [CryptoKey][google.cloud.kms.v1.CryptoKey]. If
 * a [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] is additionally
 * specified in the request, key material will be reimported into that
 * version. Otherwise, a new version will be created, and will be assigned the
 * next sequential id within the [CryptoKey][google.cloud.kms.v1.CryptoKey].
 *
 * @param string $formattedParent The [name][google.cloud.kms.v1.CryptoKey.name] of the
 *                                [CryptoKey][google.cloud.kms.v1.CryptoKey] to be imported into.
 *
 *                                The create permission is only required on this key when creating a new
 *                                [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion]. Please see
 *                                {@see KeyManagementServiceClient::cryptoKeyName()} for help formatting this field.
 * @param int    $algorithm       The
 *                                [algorithm][google.cloud.kms.v1.CryptoKeyVersion.CryptoKeyVersionAlgorithm]
 *                                of the key being imported. This does not need to match the
 *                                [version_template][google.cloud.kms.v1.CryptoKey.version_template] of the
 *                                [CryptoKey][google.cloud.kms.v1.CryptoKey] this version imports into.
 * @param string $importJob       The [name][google.cloud.kms.v1.ImportJob.name] of the
 *                                [ImportJob][google.cloud.kms.v1.ImportJob] that was used to wrap this key
 *                                material.
 */
function import_crypto_key_version_sample(
    string $formattedParent,
    int $algorithm,
    string $importJob
): void {
    // Create a client.
    $keyManagementServiceClient = new KeyManagementServiceClient();

    // Prepare the request message.
    $request = (new ImportCryptoKeyVersionRequest())
        ->setParent($formattedParent)
        ->setAlgorithm($algorithm)
        ->setImportJob($importJob);

    // Call the API and handle any network failures.
    try {
        /** @var CryptoKeyVersion $response */
        $response = $keyManagementServiceClient->importCryptoKeyVersion($request);
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
    $formattedParent = KeyManagementServiceClient::cryptoKeyName(
        '[PROJECT]',
        '[LOCATION]',
        '[KEY_RING]',
        '[CRYPTO_KEY]'
    );
    $algorithm = CryptoKeyVersionAlgorithm::CRYPTO_KEY_VERSION_ALGORITHM_UNSPECIFIED;
    $importJob = '[IMPORT_JOB]';

    import_crypto_key_version_sample($formattedParent, $algorithm, $importJob);
}
// [END cloudkms_v1_generated_KeyManagementService_ImportCryptoKeyVersion_sync]
