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

// [START managedkafka_v1_generated_ManagedKafkaConnect_UpdateConnectCluster_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ManagedKafka\V1\CapacityConfig;
use Google\Cloud\ManagedKafka\V1\Client\ManagedKafkaConnectClient;
use Google\Cloud\ManagedKafka\V1\ConnectAccessConfig;
use Google\Cloud\ManagedKafka\V1\ConnectCluster;
use Google\Cloud\ManagedKafka\V1\ConnectGcpConfig;
use Google\Cloud\ManagedKafka\V1\ConnectNetworkConfig;
use Google\Cloud\ManagedKafka\V1\UpdateConnectClusterRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates the properties of a single Kafka Connect cluster.
 *
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
function update_connect_cluster_sample(
    string $connectClusterGcpConfigAccessConfigNetworkConfigsPrimarySubnet,
    string $connectClusterKafkaCluster,
    int $connectClusterCapacityConfigVcpuCount,
    int $connectClusterCapacityConfigMemoryBytes
): void {
    // Create a client.
    $managedKafkaConnectClient = new ManagedKafkaConnectClient();

    // Prepare the request message.
    $updateMask = new FieldMask();
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
    $request = (new UpdateConnectClusterRequest())
        ->setUpdateMask($updateMask)
        ->setConnectCluster($connectCluster);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $managedKafkaConnectClient->updateConnectCluster($request);
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
    $connectClusterGcpConfigAccessConfigNetworkConfigsPrimarySubnet = '[PRIMARY_SUBNET]';
    $connectClusterKafkaCluster = '[KAFKA_CLUSTER]';
    $connectClusterCapacityConfigVcpuCount = 0;
    $connectClusterCapacityConfigMemoryBytes = 0;

    update_connect_cluster_sample(
        $connectClusterGcpConfigAccessConfigNetworkConfigsPrimarySubnet,
        $connectClusterKafkaCluster,
        $connectClusterCapacityConfigVcpuCount,
        $connectClusterCapacityConfigMemoryBytes
    );
}
// [END managedkafka_v1_generated_ManagedKafkaConnect_UpdateConnectCluster_sync]
