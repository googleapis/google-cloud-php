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

// [START dlp_v2_generated_DlpService_UpdateConnection_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dlp\V2\Client\DlpServiceClient;
use Google\Cloud\Dlp\V2\Connection;
use Google\Cloud\Dlp\V2\ConnectionState;
use Google\Cloud\Dlp\V2\UpdateConnectionRequest;

/**
 * Update a Connection.
 *
 * @param string $formattedName   Resource name in the format:
 *                                `projects/{project}/locations/{location}/connections/{connection}`. Please see
 *                                {@see DlpServiceClient::connectionName()} for help formatting this field.
 * @param int    $connectionState The connection's state in its lifecycle.
 */
function update_connection_sample(string $formattedName, int $connectionState): void
{
    // Create a client.
    $dlpServiceClient = new DlpServiceClient();

    // Prepare the request message.
    $connection = (new Connection())
        ->setState($connectionState);
    $request = (new UpdateConnectionRequest())
        ->setName($formattedName)
        ->setConnection($connection);

    // Call the API and handle any network failures.
    try {
        /** @var Connection $response */
        $response = $dlpServiceClient->updateConnection($request);
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
    $formattedName = DlpServiceClient::connectionName('[PROJECT]', '[LOCATION]', '[CONNECTION]');
    $connectionState = ConnectionState::CONNECTION_STATE_UNSPECIFIED;

    update_connection_sample($formattedName, $connectionState);
}
// [END dlp_v2_generated_DlpService_UpdateConnection_sync]
