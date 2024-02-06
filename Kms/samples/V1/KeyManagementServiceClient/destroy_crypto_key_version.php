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

// [START cloudkms_v1_generated_KeyManagementService_DestroyCryptoKeyVersion_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Kms\V1\Client\KeyManagementServiceClient;
use Google\Cloud\Kms\V1\CryptoKeyVersion;
use Google\Cloud\Kms\V1\DestroyCryptoKeyVersionRequest;

/**
 * Schedule a [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] for
 * destruction.
 *
 * Upon calling this method,
 * [CryptoKeyVersion.state][google.cloud.kms.v1.CryptoKeyVersion.state] will
 * be set to
 * [DESTROY_SCHEDULED][google.cloud.kms.v1.CryptoKeyVersion.CryptoKeyVersionState.DESTROY_SCHEDULED],
 * and [destroy_time][google.cloud.kms.v1.CryptoKeyVersion.destroy_time] will
 * be set to the time
 * [destroy_scheduled_duration][google.cloud.kms.v1.CryptoKey.destroy_scheduled_duration]
 * in the future. At that time, the
 * [state][google.cloud.kms.v1.CryptoKeyVersion.state] will automatically
 * change to
 * [DESTROYED][google.cloud.kms.v1.CryptoKeyVersion.CryptoKeyVersionState.DESTROYED],
 * and the key material will be irrevocably destroyed.
 *
 * Before the
 * [destroy_time][google.cloud.kms.v1.CryptoKeyVersion.destroy_time] is
 * reached,
 * [RestoreCryptoKeyVersion][google.cloud.kms.v1.KeyManagementService.RestoreCryptoKeyVersion]
 * may be called to reverse the process.
 *
 * @param string $formattedName The resource name of the
 *                              [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] to destroy. Please see
 *                              {@see KeyManagementServiceClient::cryptoKeyVersionName()} for help formatting this field.
 */
function destroy_crypto_key_version_sample(string $formattedName): void
{
    // Create a client.
    $keyManagementServiceClient = new KeyManagementServiceClient();

    // Prepare the request message.
    $request = (new DestroyCryptoKeyVersionRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var CryptoKeyVersion $response */
        $response = $keyManagementServiceClient->destroyCryptoKeyVersion($request);
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

    destroy_crypto_key_version_sample($formattedName);
}
// [END cloudkms_v1_generated_KeyManagementService_DestroyCryptoKeyVersion_sync]
