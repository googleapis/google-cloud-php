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

// [START managedkafka_v1_generated_ManagedKafkaConnect_CreateConnector_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ManagedKafka\V1\Client\ManagedKafkaConnectClient;
use Google\Cloud\ManagedKafka\V1\Connector;
use Google\Cloud\ManagedKafka\V1\CreateConnectorRequest;

/**
 * Creates a new connector in a given Connect cluster.
 *
 * @param string $formattedParent The parent Connect cluster in which to create the connector.
 *                                Structured like
 *                                `projects/{project}/locations/{location}/connectClusters/{connect_cluster_id}`. Please see
 *                                {@see ManagedKafkaConnectClient::connectClusterName()} for help formatting this field.
 * @param string $connectorId     The ID to use for the connector, which will become the final
 *                                component of the connector's name. The ID must be 1-63 characters long, and
 *                                match the regular expression `[a-z]([-a-z0-9]*[a-z0-9])?` to comply with
 *                                RFC 1035.
 *
 *                                This value is structured like: `my-connector-id`.
 */
function create_connector_sample(string $formattedParent, string $connectorId): void
{
    // Create a client.
    $managedKafkaConnectClient = new ManagedKafkaConnectClient();

    // Prepare the request message.
    $connector = new Connector();
    $request = (new CreateConnectorRequest())
        ->setParent($formattedParent)
        ->setConnectorId($connectorId)
        ->setConnector($connector);

    // Call the API and handle any network failures.
    try {
        /** @var Connector $response */
        $response = $managedKafkaConnectClient->createConnector($request);
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
    $formattedParent = ManagedKafkaConnectClient::connectClusterName(
        '[PROJECT]',
        '[LOCATION]',
        '[CONNECT_CLUSTER]'
    );
    $connectorId = '[CONNECTOR_ID]';

    create_connector_sample($formattedParent, $connectorId);
}
// [END managedkafka_v1_generated_ManagedKafkaConnect_CreateConnector_sync]
