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

// [START managedkafka_v1_generated_ManagedKafkaConnect_CreateConnectCluster_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ManagedKafka\V1\CapacityConfig;
use Google\Cloud\ManagedKafka\V1\Client\ManagedKafkaConnectClient;
use Google\Cloud\ManagedKafka\V1\ConnectAccessConfig;
use Google\Cloud\ManagedKafka\V1\ConnectCluster;
use Google\Cloud\ManagedKafka\V1\ConnectGcpConfig;
use Google\Cloud\ManagedKafka\V1\ConnectNetworkConfig;
use Google\Cloud\ManagedKafka\V1\CreateConnectClusterRequest;
use Google\Rpc\Status;

/**
 * Creates a new Kafka Connect cluster in a given project and location.
 *
 * @param string $formattedParent                                                The parent project/location in which to create the Kafka Connect
 *                                                                               cluster. Structured like
 *                                                                               `projects/{project}/locations/{location}/`. Please see
 *                                                                               {@see ManagedKafkaConnectClient::locationName()} for help formatting this field.
 * @param string $connectClusterId                                               The ID to use for the Connect cluster, which will become the
 *                                                                               final component of the cluster's name. The ID must be 1-63 characters long,
 *                                                                               and match the regular expression `[a-z]([-a-z0-9]*[a-z0-9])?` to comply
 *                                                                               with RFC 1035.
 *
 *                                                                               This value is structured like: `my-cluster-id`.
 * @param string $connectClusterGcpConfigAccessConfigNetworkConfigsPrimarySubnet VPC subnet to make available to the Kafka Connect cluster.
 *                                                                               Structured like:
 *                                                                               projects/{project}/regions/{region}/subnetworks/{subnet_id}
 *
 *                                                                               It is used to create a Private Service Connect (PSC) interface for the
 *                                                                               Kafka Connect workers. It must be located in the same region as the
 *                                                                               Kafka Connect cluster.
 *
 *                                                                               The CIDR range of the subnet must be within the IPv4 address ranges for
 *                                                                               private networks, as specified in RFC 1918. The primary subnet CIDR range
 *                                                                               must have a minimum size of /22 (1024 addresses).
 * @param string $connectClusterKafkaCluster                                     Immutable. The name of the Kafka cluster this Kafka Connect
 *                                                                               cluster is attached to. Structured like:
 *                                                                               projects/{project}/locations/{location}/clusters/{cluster}
 * @param int    $connectClusterCapacityConfigVcpuCount                          The number of vCPUs to provision for the cluster. Minimum: 3.
 * @param int    $connectClusterCapacityConfigMemoryBytes                        The memory to provision for the cluster in bytes.
 *                                                                               The CPU:memory ratio (vCPU:GiB) must be between 1:1 and 1:8.
 *                                                                               Minimum: 3221225472 (3 GiB).
 */
function create_connect_cluster_sample(
    string $formattedParent,
    string $connectClusterId,
    string $connectClusterGcpConfigAccessConfigNetworkConfigsPrimarySubnet,
    string $connectClusterKafkaCluster,
    int $connectClusterCapacityConfigVcpuCount,
    int $connectClusterCapacityConfigMemoryBytes
): void {
    // Create a client.
    $managedKafkaConnectClient = new ManagedKafkaConnectClient();

    // Prepare the request message.
    $connectNetworkConfig = (new ConnectNetworkConfig())
        ->setPrimarySubnet($connectClusterGcpConfigAccessConfigNetworkConfigsPrimarySubnet);
    $connectClusterGcpConfigAccessConfigNetworkConfigs = [$connectNetworkConfig,];
    $connectClusterGcpConfigAccessConfig = (new ConnectAccessConfig())
        ->setNetworkConfigs($connectClusterGcpConfigAccessConfigNetworkConfigs);
    $connectClusterGcpConfig = (new ConnectGcpConfig())
        ->setAccessConfig($connectClusterGcpConfigAccessConfig);
    $connectClusterCapacityConfig = (new CapacityConfig())
        ->setVcpuCount($connectClusterCapacityConfigVcpuCount)
        ->setMemoryBytes($connectClusterCapacityConfigMemoryBytes);
    $connectCluster = (new ConnectCluster())
        ->setGcpConfig($connectClusterGcpConfig)
        ->setKafkaCluster($connectClusterKafkaCluster)
        ->setCapacityConfig($connectClusterCapacityConfig);
    $request = (new CreateConnectClusterRequest())
        ->setParent($formattedParent)
        ->setConnectClusterId($connectClusterId)
        ->setConnectCluster($connectCluster);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $managedKafkaConnectClient->createConnectCluster($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ConnectCluster $result */
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
    $formattedParent = ManagedKafkaConnectClient::locationName('[PROJECT]', '[LOCATION]');
    $connectClusterId = '[CONNECT_CLUSTER_ID]';
    $connectClusterGcpConfigAccessConfigNetworkConfigsPrimarySubnet = '[PRIMARY_SUBNET]';
    $connectClusterKafkaCluster = '[KAFKA_CLUSTER]';
    $connectClusterCapacityConfigVcpuCount = 0;
    $connectClusterCapacityConfigMemoryBytes = 0;

    create_connect_cluster_sample(
        $formattedParent,
        $connectClusterId,
        $connectClusterGcpConfigAccessConfigNetworkConfigsPrimarySubnet,
        $connectClusterKafkaCluster,
        $connectClusterCapacityConfigVcpuCount,
        $connectClusterCapacityConfigMemoryBytes
    );
}
// [END managedkafka_v1_generated_ManagedKafkaConnect_CreateConnectCluster_sync]
