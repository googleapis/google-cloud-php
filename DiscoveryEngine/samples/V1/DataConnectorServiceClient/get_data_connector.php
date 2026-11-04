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

// [START discoveryengine_v1_generated_DataConnectorService_GetDataConnector_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1\Client\DataConnectorServiceClient;
use Google\Cloud\DiscoveryEngine\V1\DataConnector;
use Google\Cloud\DiscoveryEngine\V1\GetDataConnectorRequest;

/**
 * Gets the [DataConnector][google.cloud.discoveryengine.v1.DataConnector].
 * [DataConnector][google.cloud.discoveryengine.v1.DataConnector] is a
 * singleton resource for each
 * [Collection][google.cloud.discoveryengine.v1.Collection].
 *
 * @param string $formattedName Full resource name of
 *                              [DataConnector][google.cloud.discoveryengine.v1.DataConnector], such as
 *                              `projects/{project}/locations/{location}/collections/{collection_id}/dataConnector`.
 *
 *                              If the caller does not have permission to access the
 *                              [DataConnector][google.cloud.discoveryengine.v1.DataConnector], regardless
 *                              of whether or not it exists, a `PERMISSION_DENIED` error is returned.
 *
 *                              If the requested
 *                              [DataConnector][google.cloud.discoveryengine.v1.DataConnector] does not
 *                              exist, a `NOT_FOUND` error is returned. Please see
 *                              {@see DataConnectorServiceClient::dataConnectorName()} for help formatting this field.
 */
function get_data_connector_sample(string $formattedName): void
{
    // Create a client.
    $dataConnectorServiceClient = new DataConnectorServiceClient();

    // Prepare the request message.
    $request = (new GetDataConnectorRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var DataConnector $response */
        $response = $dataConnectorServiceClient->getDataConnector($request);
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
    $formattedName = DataConnectorServiceClient::dataConnectorName(
        '[PROJECT]',
        '[LOCATION]',
        '[COLLECTION]'
    );

    get_data_connector_sample($formattedName);
}
// [END discoveryengine_v1_generated_DataConnectorService_GetDataConnector_sync]
