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

// [START discoveryengine_v1_generated_DataConnectorService_UpdateDataConnector_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DiscoveryEngine\V1\Client\DataConnectorServiceClient;
use Google\Cloud\DiscoveryEngine\V1\DataConnector;
use Google\Cloud\DiscoveryEngine\V1\UpdateDataConnectorRequest;
use Google\Protobuf\Duration;

/**
 * Updates a [DataConnector][google.cloud.discoveryengine.v1.DataConnector].
 *
 * @param string $dataConnectorDataSource The identifier for the data source.
 *                                        For the full, up-to-date list of supported connectors and their values,
 *                                        see
 *                                        [Connect a third-party data
 *                                        source](https://docs.cloud.google.com/gemini/enterprise/docs/connectors/connect-third-party-data-source#sources-by-launch-stage).
 */
function update_data_connector_sample(string $dataConnectorDataSource): void
{
    // Create a client.
    $dataConnectorServiceClient = new DataConnectorServiceClient();

    // Prepare the request message.
    $dataConnectorRefreshInterval = new Duration();
    $dataConnector = (new DataConnector())
        ->setDataSource($dataConnectorDataSource)
        ->setRefreshInterval($dataConnectorRefreshInterval);
    $request = (new UpdateDataConnectorRequest())
        ->setDataConnector($dataConnector);

    // Call the API and handle any network failures.
    try {
        /** @var DataConnector $response */
        $response = $dataConnectorServiceClient->updateDataConnector($request);
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
    $dataConnectorDataSource = '[DATA_SOURCE]';

    update_data_connector_sample($dataConnectorDataSource);
}
// [END discoveryengine_v1_generated_DataConnectorService_UpdateDataConnector_sync]
