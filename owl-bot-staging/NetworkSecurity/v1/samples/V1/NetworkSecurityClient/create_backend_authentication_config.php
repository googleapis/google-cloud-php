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

// [START networksecurity_v1_generated_NetworkSecurity_CreateBackendAuthenticationConfig_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkSecurity\V1\BackendAuthenticationConfig;
use Google\Cloud\NetworkSecurity\V1\Client\NetworkSecurityClient;
use Google\Cloud\NetworkSecurity\V1\CreateBackendAuthenticationConfigRequest;
use Google\Rpc\Status;

/**
 * Creates a new BackendAuthenticationConfig in a given project and location.
 *
 * @param string $formattedParent                 The parent resource of the BackendAuthenticationConfig. Must be
 *                                                in the format `projects/&#42;/locations/{location}`. Please see
 *                                                {@see NetworkSecurityClient::locationName()} for help formatting this field.
 * @param string $backendAuthenticationConfigId   Short name of the BackendAuthenticationConfig resource to be
 *                                                created. This value should be 1-63 characters long, containing only
 *                                                letters, numbers, hyphens, and underscores, and should not start with a
 *                                                number. E.g. "backend-auth-config".
 * @param string $backendAuthenticationConfigName Name of the BackendAuthenticationConfig resource. It matches the
 *                                                pattern
 *                                                `projects/&#42;/locations/{location}/backendAuthenticationConfigs/{backend_authentication_config}`
 */
function create_backend_authentication_config_sample(
    string $formattedParent,
    string $backendAuthenticationConfigId,
    string $backendAuthenticationConfigName
): void {
    // Create a client.
    $networkSecurityClient = new NetworkSecurityClient();

    // Prepare the request message.
    $backendAuthenticationConfig = (new BackendAuthenticationConfig())
        ->setName($backendAuthenticationConfigName);
    $request = (new CreateBackendAuthenticationConfigRequest())
        ->setParent($formattedParent)
        ->setBackendAuthenticationConfigId($backendAuthenticationConfigId)
        ->setBackendAuthenticationConfig($backendAuthenticationConfig);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $networkSecurityClient->createBackendAuthenticationConfig($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var BackendAuthenticationConfig $result */
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
    $backendAuthenticationConfigId = '[BACKEND_AUTHENTICATION_CONFIG_ID]';
    $backendAuthenticationConfigName = '[NAME]';

    create_backend_authentication_config_sample(
        $formattedParent,
        $backendAuthenticationConfigId,
        $backendAuthenticationConfigName
    );
}
// [END networksecurity_v1_generated_NetworkSecurity_CreateBackendAuthenticationConfig_sync]
