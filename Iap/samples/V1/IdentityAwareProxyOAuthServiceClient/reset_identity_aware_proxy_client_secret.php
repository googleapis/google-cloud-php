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

// [START iap_v1_generated_IdentityAwareProxyOAuthService_ResetIdentityAwareProxyClientSecret_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Iap\V1\IdentityAwareProxyClient;
use Google\Cloud\Iap\V1\IdentityAwareProxyOAuthServiceClient;

/**
 * Resets an Identity Aware Proxy (IAP) OAuth client secret. Useful if the
 * secret was compromised. Requires that the client is owned by IAP.
 *
 * @param string $name Name of the Identity Aware Proxy client to that will have its
 *                     secret reset. In the following format:
 *                     projects/{project_number/id}/brands/{brand}/identityAwareProxyClients/{client_id}.
 */
function reset_identity_aware_proxy_client_secret_sample(string $name): void
{
    // Create a client.
    $identityAwareProxyOAuthServiceClient = new IdentityAwareProxyOAuthServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var IdentityAwareProxyClient $response */
        $response = $identityAwareProxyOAuthServiceClient->resetIdentityAwareProxyClientSecret($name);
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
    $name = '[NAME]';

    reset_identity_aware_proxy_client_secret_sample($name);
}
// [END iap_v1_generated_IdentityAwareProxyOAuthService_ResetIdentityAwareProxyClientSecret_sync]
