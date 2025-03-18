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

// [START managedkafka_v1_generated_ManagedKafkaConnect_GetConnectCluster_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ManagedKafka\V1\Client\ManagedKafkaConnectClient;
use Google\Cloud\ManagedKafka\V1\ConnectCluster;
use Google\Cloud\ManagedKafka\V1\GetConnectClusterRequest;

/**
 * Returns the properties of a single Kafka Connect cluster.
 *
 * @param string $formattedName The name of the Kafka Connect cluster whose configuration to
 *                              return. Structured like
 *                              `projects/{project}/locations/{location}/connectClusters/{connect_cluster_id}`. Please see
 *                              {@see ManagedKafkaConnectClient::connectClusterName()} for help formatting this field.
 */
function get_connect_cluster_sample(string $formattedName): void
{
    // Create a client.
    $managedKafkaConnectClient = new ManagedKafkaConnectClient();

    // Prepare the request message.
    $request = (new GetConnectClusterRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var ConnectCluster $response */
        $response = $managedKafkaConnectClient->getConnectCluster($request);
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
    $formattedName = ManagedKafkaConnectClient::connectClusterName(
        '[PROJECT]',
        '[LOCATION]',
        '[CONNECT_CLUSTER]'
    );

    get_connect_cluster_sample($formattedName);
}
// [END managedkafka_v1_generated_ManagedKafkaConnect_GetConnectCluster_sync]
