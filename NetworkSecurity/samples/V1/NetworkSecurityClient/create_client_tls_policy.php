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

// [START networksecurity_v1_generated_NetworkSecurity_CreateClientTlsPolicy_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkSecurity\V1\ClientTlsPolicy;
use Google\Cloud\NetworkSecurity\V1\Client\NetworkSecurityClient;
use Google\Cloud\NetworkSecurity\V1\CreateClientTlsPolicyRequest;
use Google\Rpc\Status;

/**
 * Creates a new ClientTlsPolicy in a given project and location.
 *
 * @param string $formattedParent     The parent resource of the ClientTlsPolicy. Must be in
 *                                    the format `projects/&#42;/locations/{location}`. Please see
 *                                    {@see NetworkSecurityClient::locationName()} for help formatting this field.
 * @param string $clientTlsPolicyId   Short name of the ClientTlsPolicy resource to be created. This value should
 *                                    be 1-63 characters long, containing only letters, numbers, hyphens, and
 *                                    underscores, and should not start with a number. E.g. "client_mtls_policy".
 * @param string $clientTlsPolicyName Name of the ClientTlsPolicy resource. It matches the pattern
 *                                    `projects/&#42;/locations/{location}/clientTlsPolicies/{client_tls_policy}`
 */
function create_client_tls_policy_sample(
    string $formattedParent,
    string $clientTlsPolicyId,
    string $clientTlsPolicyName
): void {
    // Create a client.
    $networkSecurityClient = new NetworkSecurityClient();

    // Prepare the request message.
    $clientTlsPolicy = (new ClientTlsPolicy())
        ->setName($clientTlsPolicyName);
    $request = (new CreateClientTlsPolicyRequest())
        ->setParent($formattedParent)
        ->setClientTlsPolicyId($clientTlsPolicyId)
        ->setClientTlsPolicy($clientTlsPolicy);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $networkSecurityClient->createClientTlsPolicy($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ClientTlsPolicy $result */
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
    $formattedParent = NetworkSecurityClient::locationName('[PROJECT]', '[LOCATION]');
    $clientTlsPolicyId = '[CLIENT_TLS_POLICY_ID]';
    $clientTlsPolicyName = '[NAME]';

    create_client_tls_policy_sample($formattedParent, $clientTlsPolicyId, $clientTlsPolicyName);
}
// [END networksecurity_v1_generated_NetworkSecurity_CreateClientTlsPolicy_sync]
