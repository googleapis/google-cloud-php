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

// [START developerconnect_v1_generated_DeveloperConnect_GetAccountConnector_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DeveloperConnect\V1\AccountConnector;
use Google\Cloud\DeveloperConnect\V1\Client\DeveloperConnectClient;
use Google\Cloud\DeveloperConnect\V1\GetAccountConnectorRequest;

/**
 * Gets details of a single AccountConnector.
 *
 * @param string $formattedName Name of the resource
 *                              Please see {@see DeveloperConnectClient::accountConnectorName()} for help formatting this field.
 */
function get_account_connector_sample(string $formattedName): void
{
    // Create a client.
    $developerConnectClient = new DeveloperConnectClient();

    // Prepare the request message.
    $request = (new GetAccountConnectorRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var AccountConnector $response */
        $response = $developerConnectClient->getAccountConnector($request);
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
    $formattedName = DeveloperConnectClient::accountConnectorName(
        '[PROJECT]',
        '[LOCATION]',
        '[ACCOUNT_CONNECTOR]'
    );

    get_account_connector_sample($formattedName);
}
// [END developerconnect_v1_generated_DeveloperConnect_GetAccountConnector_sync]
