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

// [START cloudshell_v1_generated_CloudShellService_AddPublicKey_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Shell\V1\AddPublicKeyRequest;
use Google\Cloud\Shell\V1\AddPublicKeyResponse;
use Google\Cloud\Shell\V1\Client\CloudShellServiceClient;
use Google\Rpc\Status;

/**
 * Adds a public SSH key to an environment, allowing clients with the
 * corresponding private key to connect to that environment via SSH. If a key
 * with the same content already exists, this will error with ALREADY_EXISTS.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function add_public_key_sample(): void
{
    // Create a client.
    $cloudShellServiceClient = new CloudShellServiceClient();

    // Prepare the request message.
    $request = new AddPublicKeyRequest();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudShellServiceClient->addPublicKey($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AddPublicKeyResponse $result */
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
// [END cloudshell_v1_generated_CloudShellService_AddPublicKey_sync]
