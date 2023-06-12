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

// [START iamcredentials_v1_generated_IAMCredentials_GenerateIdToken_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Iam\Credentials\V1\GenerateIdTokenResponse;
use Google\Cloud\Iam\Credentials\V1\IAMCredentialsClient;

/**
 * Generates an OpenID Connect ID token for a service account.
 *
 * @param string $formattedName The resource name of the service account for which the credentials
 *                              are requested, in the following format:
 *                              `projects/-/serviceAccounts/{ACCOUNT_EMAIL_OR_UNIQUEID}`. The `-` wildcard
 *                              character is required; replacing it with a project ID is invalid. Please see
 *                              {@see IAMCredentialsClient::serviceAccountName()} for help formatting this field.
 * @param string $audience      The audience for the token, such as the API or account that this token
 *                              grants access to.
 */
function generate_id_token_sample(string $formattedName, string $audience): void
{
    // Create a client.
    $iAMCredentialsClient = new IAMCredentialsClient();

    // Call the API and handle any network failures.
    try {
        /** @var GenerateIdTokenResponse $response */
        $response = $iAMCredentialsClient->generateIdToken($formattedName, $audience);
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
    $formattedName = IAMCredentialsClient::serviceAccountName('[PROJECT]', '[SERVICE_ACCOUNT]');
    $audience = '[AUDIENCE]';

    generate_id_token_sample($formattedName, $audience);
}
// [END iamcredentials_v1_generated_IAMCredentials_GenerateIdToken_sync]
