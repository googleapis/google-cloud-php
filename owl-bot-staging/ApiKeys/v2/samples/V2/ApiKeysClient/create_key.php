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

// [START apikeys_v2_generated_ApiKeys_CreateKey_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ApiKeys\V2\ApiKeysClient;
use Google\Cloud\ApiKeys\V2\Key;
use Google\Rpc\Status;

/**
 * Creates a new API key.
 *
 * NOTE: Key is a global resource; hence the only supported value for
 * location is `global`.
 *
 * @param string $formattedParent The project in which the API key is created. Please see
 *                                {@see ApiKeysClient::locationName()} for help formatting this field.
 */
function create_key_sample(string $formattedParent): void
{
    // Create a client.
    $apiKeysClient = new ApiKeysClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $key = new Key();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $apiKeysClient->createKey($formattedParent, $key);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Key $result */
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
    $formattedParent = ApiKeysClient::locationName('[PROJECT]', '[LOCATION]');

    create_key_sample($formattedParent);
}
// [END apikeys_v2_generated_ApiKeys_CreateKey_sync]
