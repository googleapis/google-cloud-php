<?php
/*
 * Copyright 2025 Google LLC
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

// [START dataplex_v1_generated_CmekService_CreateEncryptionConfig_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dataplex\V1\Client\CmekServiceClient;
use Google\Cloud\Dataplex\V1\CreateEncryptionConfigRequest;
use Google\Cloud\Dataplex\V1\EncryptionConfig;
use Google\Rpc\Status;

/**
 * Create an EncryptionConfig.
 *
 * @param string $formattedParent    The location at which the EncryptionConfig is to be created. Please see
 *                                   {@see CmekServiceClient::organizationLocationName()} for help formatting this field.
 * @param string $encryptionConfigId The ID of the EncryptionConfig to create.
 *                                   The ID must contain only letters (a-z, A-Z), numbers (0-9),
 *                                   and hyphens (-).
 *                                   The maximum size is 63 characters.
 *                                   The first character must be a letter.
 *                                   The last character must be a letter or a number.
 */
function create_encryption_config_sample(
    string $formattedParent,
    string $encryptionConfigId
): void {
    // Create a client.
    $cmekServiceClient = new CmekServiceClient();

    // Prepare the request message.
    $encryptionConfig = new EncryptionConfig();
    $request = (new CreateEncryptionConfigRequest())
        ->setParent($formattedParent)
        ->setEncryptionConfigId($encryptionConfigId)
        ->setEncryptionConfig($encryptionConfig);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cmekServiceClient->createEncryptionConfig($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var EncryptionConfig $result */
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
    $formattedParent = CmekServiceClient::organizationLocationName('[ORGANIZATION]', '[LOCATION]');
    $encryptionConfigId = '[ENCRYPTION_CONFIG_ID]';

    create_encryption_config_sample($formattedParent, $encryptionConfigId);
}
// [END dataplex_v1_generated_CmekService_CreateEncryptionConfig_sync]
