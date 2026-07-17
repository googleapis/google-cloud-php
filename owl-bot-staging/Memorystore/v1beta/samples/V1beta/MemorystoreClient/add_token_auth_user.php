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

// [START memorystore_v1beta_generated_Memorystore_AddTokenAuthUser_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Memorystore\V1beta\AddTokenAuthUserRequest;
use Google\Cloud\Memorystore\V1beta\Client\MemorystoreClient;
use Google\Cloud\Memorystore\V1beta\Instance;
use Google\Rpc\Status;

/**
 * Adds a token auth user for a token based auth enabled instance.
 *
 * @param string $formattedInstance The instance resource that this token auth user will be added
 *                                  for. Format: projects/{project}/locations/{location}/instances/{instance}
 *                                  Please see {@see MemorystoreClient::instanceName()} for help formatting this field.
 * @param string $tokenAuthUser     The name of the token auth user to add.
 */
function add_token_auth_user_sample(string $formattedInstance, string $tokenAuthUser): void
{
    // Create a client.
    $memorystoreClient = new MemorystoreClient();

    // Prepare the request message.
    $request = (new AddTokenAuthUserRequest())
        ->setInstance($formattedInstance)
        ->setTokenAuthUser($tokenAuthUser);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $memorystoreClient->addTokenAuthUser($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Instance $result */
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
    $formattedInstance = MemorystoreClient::instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
    $tokenAuthUser = '[TOKEN_AUTH_USER]';

    add_token_auth_user_sample($formattedInstance, $tokenAuthUser);
}
// [END memorystore_v1beta_generated_Memorystore_AddTokenAuthUser_sync]
