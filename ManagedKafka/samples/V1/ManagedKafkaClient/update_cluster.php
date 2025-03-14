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

// [START managedkafka_v1_generated_ManagedKafka_UpdateCluster_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ManagedKafka\V1\AccessConfig;
use Google\Cloud\ManagedKafka\V1\CapacityConfig;
use Google\Cloud\ManagedKafka\V1\Client\ManagedKafkaClient;
use Google\Cloud\ManagedKafka\V1\Cluster;
use Google\Cloud\ManagedKafka\V1\GcpConfig;
use Google\Cloud\ManagedKafka\V1\NetworkConfig;
use Google\Cloud\ManagedKafka\V1\UpdateClusterRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates the properties of a single cluster.
 *
 * @param string $clusterGcpConfigAccessConfigNetworkConfigsSubnet Name of the VPC subnet in which to create Private Service Connect
 *                                                                 (PSC) endpoints for the Kafka brokers and bootstrap address. Structured
 *                                                                 like: projects/{project}/regions/{region}/subnetworks/{subnet_id}
 *
 *                                                                 The subnet must be located in the same region as the Kafka cluster. The
 *                                                                 project may differ. Multiple subnets from the same parent network must not
 *                                                                 be specified.
 * @param int    $clusterCapacityConfigVcpuCount                   The number of vCPUs to provision for the cluster. Minimum: 3.
 * @param int    $clusterCapacityConfigMemoryBytes                 The memory to provision for the cluster in bytes.
 *                                                                 The CPU:memory ratio (vCPU:GiB) must be between 1:1 and 1:8.
 *                                                                 Minimum: 3221225472 (3 GiB).
 */
function update_cluster_sample(
    string $clusterGcpConfigAccessConfigNetworkConfigsSubnet,
    int $clusterCapacityConfigVcpuCount,
    int $clusterCapacityConfigMemoryBytes
): void {
    // Create a client.
    $managedKafkaClient = new ManagedKafkaClient();

    // Prepare the request message.
    $updateMask = new FieldMask();
    $networkConfig = (new NetworkConfig())
        ->setSubnet($clusterGcpConfigAccessConfigNetworkConfigsSubnet);
    $clusterGcpConfigAccessConfigNetworkConfigs = [$networkConfig,];
    $clusterGcpConfigAccessConfig = (new AccessConfig())
        ->setNetworkConfigs($clusterGcpConfigAccessConfigNetworkConfigs);
    $clusterGcpConfig = (new GcpConfig())
        ->setAccessConfig($clusterGcpConfigAccessConfig);
    $clusterCapacityConfig = (new CapacityConfig())
        ->setVcpuCount($clusterCapacityConfigVcpuCount)
        ->setMemoryBytes($clusterCapacityConfigMemoryBytes);
    $cluster = (new Cluster())
        ->setGcpConfig($clusterGcpConfig)
        ->setCapacityConfig($clusterCapacityConfig);
    $request = (new UpdateClusterRequest())
        ->setUpdateMask($updateMask)
        ->setCluster($cluster);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $managedKafkaClient->updateCluster($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Cluster $result */
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
    $clusterGcpConfigAccessConfigNetworkConfigsSubnet = '[SUBNET]';
    $clusterCapacityConfigVcpuCount = 0;
    $clusterCapacityConfigMemoryBytes = 0;

    update_cluster_sample(
        $clusterGcpConfigAccessConfigNetworkConfigsSubnet,
        $clusterCapacityConfigVcpuCount,
        $clusterCapacityConfigMemoryBytes
    );
}
// [END managedkafka_v1_generated_ManagedKafka_UpdateCluster_sync]
