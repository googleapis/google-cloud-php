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

// [START cloudapiregistry_v1beta_generated_CloudApiRegistry_GetMcpServer_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApiRegistry\V1beta\Client\CloudApiRegistryClient;
use Google\Cloud\ApiRegistry\V1beta\GetMcpServerRequest;
use Google\Cloud\ApiRegistry\V1beta\McpServer;

/**
 * Gets a single McpServer.
 *
 * @param string $formattedName Name of the resource
 *                              Please see {@see CloudApiRegistryClient::mcpServerName()} for help formatting this field.
 */
function get_mcp_server_sample(string $formattedName): void
{
    // Create a client.
    $cloudApiRegistryClient = new CloudApiRegistryClient();

    // Prepare the request message.
    $request = (new GetMcpServerRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var McpServer $response */
        $response = $cloudApiRegistryClient->getMcpServer($request);
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
    $formattedName = CloudApiRegistryClient::mcpServerName(
        '[PROJECT]',
        '[LOCATION]',
        '[API_NAMESPACE]',
        '[MCP_SERVER]'
    );

    get_mcp_server_sample($formattedName);
}
// [END cloudapiregistry_v1beta_generated_CloudApiRegistry_GetMcpServer_sync]
