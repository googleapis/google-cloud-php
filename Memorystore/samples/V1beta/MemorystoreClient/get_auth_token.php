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

// [START memorystore_v1beta_generated_Memorystore_GetAuthToken_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Memorystore\V1beta\AuthToken;
use Google\Cloud\Memorystore\V1beta\Client\MemorystoreClient;
use Google\Cloud\Memorystore\V1beta\GetAuthTokenRequest;

/**
 * Gets a token based auth enabled instance's auth token for a given user.
 *
 * @param string $formattedName The name of token auth user for a token auth enabled instance.
 *                              Format:
 *                              projects/{project}/locations/{location}/instances/{instance}/tokenAuthUsers/{token_auth_user}/authTokens/{auth_token}
 *                              Please see {@see MemorystoreClient::authTokenName()} for help formatting this field.
 */
function get_auth_token_sample(string $formattedName): void
{
    // Create a client.
    $memorystoreClient = new MemorystoreClient();

    // Prepare the request message.
    $request = (new GetAuthTokenRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var AuthToken $response */
        $response = $memorystoreClient->getAuthToken($request);
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
    $formattedName = MemorystoreClient::authTokenName(
        '[PROJECT]',
        '[LOCATION]',
        '[INSTANCE]',
        '[TOKEN_AUTH_USER]',
        '[AUTH_TOKEN]'
    );

    get_auth_token_sample($formattedName);
}
// [END memorystore_v1beta_generated_Memorystore_GetAuthToken_sync]
