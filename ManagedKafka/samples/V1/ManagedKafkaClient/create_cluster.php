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

// [START managedkafka_v1_generated_ManagedKafka_CreateCluster_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ManagedKafka\V1\AccessConfig;
use Google\Cloud\ManagedKafka\V1\CapacityConfig;
use Google\Cloud\ManagedKafka\V1\Client\ManagedKafkaClient;
use Google\Cloud\ManagedKafka\V1\Cluster;
use Google\Cloud\ManagedKafka\V1\CreateClusterRequest;
use Google\Cloud\ManagedKafka\V1\GcpConfig;
use Google\Cloud\ManagedKafka\V1\NetworkConfig;
use Google\Rpc\Status;

/**
 * Creates a new cluster in a given project and location.
 *
 * @param string $formattedParent                                  The parent region in which to create the cluster. Structured like
 *                                                                 `projects/{project}/locations/{location}`. Please see
 *                                                                 {@see ManagedKafkaClient::locationName()} for help formatting this field.
 * @param string $clusterId                                        The ID to use for the cluster, which will become the final
 *                                                                 component of the cluster's name. The ID must be 1-63 characters long, and
 *                                                                 match the regular expression `[a-z]([-a-z0-9]*[a-z0-9])?` to comply with
 *                                                                 RFC 1035.
 *
 *                                                                 This value is structured like: `my-cluster-id`.
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
function create_cluster_sample(
    string $formattedParent,
    string $clusterId,
    string $clusterGcpConfigAccessConfigNetworkConfigsSubnet,
    int $clusterCapacityConfigVcpuCount,
    int $clusterCapacityConfigMemoryBytes
): void {
    // Create a client.
    $managedKafkaClient = new ManagedKafkaClient();

    // Prepare the request message.
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
    $request = (new CreateClusterRequest())
        ->setParent($formattedParent)
        ->setClusterId($clusterId)
        ->setCluster($cluster);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $managedKafkaClient->createCluster($request);
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
    $formattedParent = ManagedKafkaClient::locationName('[PROJECT]', '[LOCATION]');
    $clusterId = '[CLUSTER_ID]';
    $clusterGcpConfigAccessConfigNetworkConfigsSubnet = '[SUBNET]';
    $clusterCapacityConfigVcpuCount = 0;
    $clusterCapacityConfigMemoryBytes = 0;

    create_cluster_sample(
        $formattedParent,
        $clusterId,
        $clusterGcpConfigAccessConfigNetworkConfigsSubnet,
        $clusterCapacityConfigVcpuCount,
        $clusterCapacityConfigMemoryBytes
    );
}
// [END managedkafka_v1_generated_ManagedKafka_CreateCluster_sync]
