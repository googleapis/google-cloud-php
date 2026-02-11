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

// [START cloudkms_v1_generated_KeyManagementService_DeleteCryptoKey_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Kms\V1\Client\KeyManagementServiceClient;
use Google\Cloud\Kms\V1\DeleteCryptoKeyRequest;
use Google\Rpc\Status;

/**
 * Permanently deletes the given [CryptoKey][google.cloud.kms.v1.CryptoKey].
 * All child [CryptoKeyVersions][google.cloud.kms.v1.CryptoKeyVersion] must
 * have been previously deleted using
 * [KeyManagementService.DeleteCryptoKeyVersion][google.cloud.kms.v1.KeyManagementService.DeleteCryptoKeyVersion].
 * The specified crypto key will be immediately and permanently deleted upon
 * calling this method. This action cannot be undone.
 *
 * @param string $formattedName The [name][google.cloud.kms.v1.CryptoKey.name] of the
 *                              [CryptoKey][google.cloud.kms.v1.CryptoKey] to delete. Please see
 *                              {@see KeyManagementServiceClient::cryptoKeyName()} for help formatting this field.
 */
function delete_crypto_key_sample(string $formattedName): void
{
    // Create a client.
    $keyManagementServiceClient = new KeyManagementServiceClient();

    // Prepare the request message.
    $request = (new DeleteCryptoKeyRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $keyManagementServiceClient->deleteCryptoKey($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
        }
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

    delete_crypto_key_sample($formattedName);
}
// [END cloudkms_v1_generated_KeyManagementService_DeleteCryptoKey_sync]
