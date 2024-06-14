<?php
/*
 * Copyright 2024 Google LLC
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

// [START developerconnect_v1_generated_DeveloperConnect_FetchGitHubInstallations_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DeveloperConnect\V1\Client\DeveloperConnectClient;
use Google\Cloud\DeveloperConnect\V1\FetchGitHubInstallationsRequest;
use Google\Cloud\DeveloperConnect\V1\FetchGitHubInstallationsResponse;

/**
 * FetchGitHubInstallations returns the list of GitHub Installations that
 * are available to be added to a Connection.
 * For github.com, only installations accessible to the authorizer token
 * are returned. For GitHub Enterprise, all installations are returned.
 *
 * @param string $formattedConnection The resource name of the connection in the format
 *                                    `projects/&#42;/locations/&#42;/connections/*`. Please see
 *                                    {@see DeveloperConnectClient::connectionName()} for help formatting this field.
 */
function fetch_git_hub_installations_sample(string $formattedConnection): void
{
    // Create a client.
    $developerConnectClient = new DeveloperConnectClient();

    // Prepare the request message.
    $request = (new FetchGitHubInstallationsRequest())
        ->setConnection($formattedConnection);

    // Call the API and handle any network failures.
    try {
        /** @var FetchGitHubInstallationsResponse $response */
        $response = $developerConnectClient->fetchGitHubInstallations($request);
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
    $formattedConnection = DeveloperConnectClient::connectionName(
        '[PROJECT]',
        '[LOCATION]',
        '[CONNECTION]'
    );

    fetch_git_hub_installations_sample($formattedConnection);
}
// [END developerconnect_v1_generated_DeveloperConnect_FetchGitHubInstallations_sync]
