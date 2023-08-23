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

// [START beyondcorp_v1_generated_AppConnectorsService_GetAppConnector_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BeyondCorp\AppConnectors\V1\AppConnector;
use Google\Cloud\BeyondCorp\AppConnectors\V1\Client\AppConnectorsServiceClient;
use Google\Cloud\BeyondCorp\AppConnectors\V1\GetAppConnectorRequest;

/**
 * Gets details of a single AppConnector.
 *
 * @param string $formattedName BeyondCorp AppConnector name using the form:
 *                              `projects/{project_id}/locations/{location_id}/appConnectors/{app_connector_id}`
 *                              Please see {@see AppConnectorsServiceClient::appConnectorName()} for help formatting this field.
 */
function get_app_connector_sample(string $formattedName): void
{
    // Create a client.
    $appConnectorsServiceClient = new AppConnectorsServiceClient();

    // Prepare the request message.
    $request = (new GetAppConnectorRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var AppConnector $response */
        $response = $appConnectorsServiceClient->getAppConnector($request);
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
    $formattedName = AppConnectorsServiceClient::appConnectorName(
        '[PROJECT]',
        '[LOCATION]',
        '[APP_CONNECTOR]'
    );

    get_app_connector_sample($formattedName);
}
// [END beyondcorp_v1_generated_AppConnectorsService_GetAppConnector_sync]
