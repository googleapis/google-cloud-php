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

// [START netapp_v1_generated_NetApp_CreateKmsConfig_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetApp\V1\Client\NetAppClient;
use Google\Cloud\NetApp\V1\CreateKmsConfigRequest;
use Google\Cloud\NetApp\V1\KmsConfig;
use Google\Rpc\Status;

/**
 * Creates a new KMS config.
 *
 * @param string $formattedParent        Value for parent. Please see
 *                                       {@see NetAppClient::locationName()} for help formatting this field.
 * @param string $kmsConfigId            Id of the requesting KmsConfig. Must be unique within the parent
 *                                       resource. Must contain only letters, numbers and hyphen, with the first
 *                                       character a letter, the last a letter or a
 *                                       number, and a 63 character maximum.
 * @param string $kmsConfigCryptoKeyName Customer-managed crypto key resource full name. Format:
 *                                       `projects/{project}/locations/{location}/keyRings/{key_ring}/cryptoKeys/{crypto_key}`
 */
function create_kms_config_sample(
    string $formattedParent,
    string $kmsConfigId,
    string $kmsConfigCryptoKeyName
): void {
    // Create a client.
    $netAppClient = new NetAppClient();

    // Prepare the request message.
    $kmsConfig = (new KmsConfig())
        ->setCryptoKeyName($kmsConfigCryptoKeyName);
    $request = (new CreateKmsConfigRequest())
        ->setParent($formattedParent)
        ->setKmsConfigId($kmsConfigId)
        ->setKmsConfig($kmsConfig);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $netAppClient->createKmsConfig($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var KmsConfig $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
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
    $formattedParent = NetAppClient::locationName('[PROJECT]', '[LOCATION]');
    $kmsConfigId = '[KMS_CONFIG_ID]';
    $kmsConfigCryptoKeyName = '[CRYPTO_KEY_NAME]';

    create_kms_config_sample($formattedParent, $kmsConfigId, $kmsConfigCryptoKeyName);
}
// [END netapp_v1_generated_NetApp_CreateKmsConfig_sync]
