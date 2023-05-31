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

// [START networksecurity_v1_generated_NetworkSecurity_CreateServerTlsPolicy_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkSecurity\V1\Client\NetworkSecurityClient;
use Google\Cloud\NetworkSecurity\V1\CreateServerTlsPolicyRequest;
use Google\Cloud\NetworkSecurity\V1\ServerTlsPolicy;
use Google\Rpc\Status;

/**
 * Creates a new ServerTlsPolicy in a given project and location.
 *
 * @param string $formattedParent     The parent resource of the ServerTlsPolicy. Must be in
 *                                    the format `projects/&#42;/locations/{location}`. Please see
 *                                    {@see NetworkSecurityClient::locationName()} for help formatting this field.
 * @param string $serverTlsPolicyId   Short name of the ServerTlsPolicy resource to be created. This value should
 *                                    be 1-63 characters long, containing only letters, numbers, hyphens, and
 *                                    underscores, and should not start with a number. E.g. "server_mtls_policy".
 * @param string $serverTlsPolicyName Name of the ServerTlsPolicy resource. It matches the pattern
 *                                    `projects/&#42;/locations/{location}/serverTlsPolicies/{server_tls_policy}`
 */
function create_server_tls_policy_sample(
    string $formattedParent,
    string $serverTlsPolicyId,
    string $serverTlsPolicyName
): void {
    // Create a client.
    $networkSecurityClient = new NetworkSecurityClient();

    // Prepare the request message.
    $serverTlsPolicy = (new ServerTlsPolicy())
        ->setName($serverTlsPolicyName);
    $request = (new CreateServerTlsPolicyRequest())
        ->setParent($formattedParent)
        ->setServerTlsPolicyId($serverTlsPolicyId)
        ->setServerTlsPolicy($serverTlsPolicy);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $networkSecurityClient->createServerTlsPolicy($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ServerTlsPolicy $result */
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
    $serverTlsPolicyId = '[SERVER_TLS_POLICY_ID]';
    $serverTlsPolicyName = '[NAME]';

    create_server_tls_policy_sample($formattedParent, $serverTlsPolicyId, $serverTlsPolicyName);
}
// [END networksecurity_v1_generated_NetworkSecurity_CreateServerTlsPolicy_sync]
