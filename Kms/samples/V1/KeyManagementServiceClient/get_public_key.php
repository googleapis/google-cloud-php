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

// [START cloudkms_v1_generated_KeyManagementService_GetPublicKey_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Kms\V1\Client\KeyManagementServiceClient;
use Google\Cloud\Kms\V1\GetPublicKeyRequest;
use Google\Cloud\Kms\V1\PublicKey;

/**
 * Returns the public key for the given
 * [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion]. The
 * [CryptoKey.purpose][google.cloud.kms.v1.CryptoKey.purpose] must be
 * [ASYMMETRIC_SIGN][google.cloud.kms.v1.CryptoKey.CryptoKeyPurpose.ASYMMETRIC_SIGN]
 * or
 * [ASYMMETRIC_DECRYPT][google.cloud.kms.v1.CryptoKey.CryptoKeyPurpose.ASYMMETRIC_DECRYPT].
 *
 * @param string $formattedName The [name][google.cloud.kms.v1.CryptoKeyVersion.name] of the
 *                              [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] public key to get. Please see
 *                              {@see KeyManagementServiceClient::cryptoKeyVersionName()} for help formatting this field.
 */
function get_public_key_sample(string $formattedName): void
{
    // Create a client.
    $keyManagementServiceClient = new KeyManagementServiceClient();

    // Prepare the request message.
    $request = (new GetPublicKeyRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var PublicKey $response */
        $response = $keyManagementServiceClient->getPublicKey($request);
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

    get_public_key_sample($formattedName);
}
// [END cloudkms_v1_generated_KeyManagementService_GetPublicKey_sync]
