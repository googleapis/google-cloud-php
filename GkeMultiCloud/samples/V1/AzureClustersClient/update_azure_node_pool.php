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

// [START gkemulticloud_v1_generated_AzureClusters_UpdateAzureNodePool_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GkeMultiCloud\V1\AzureClustersClient;
use Google\Cloud\GkeMultiCloud\V1\AzureNodeConfig;
use Google\Cloud\GkeMultiCloud\V1\AzureNodePool;
use Google\Cloud\GkeMultiCloud\V1\AzureNodePoolAutoscaling;
use Google\Cloud\GkeMultiCloud\V1\AzureSshConfig;
use Google\Cloud\GkeMultiCloud\V1\MaxPodsConstraint;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates an [AzureNodePool][google.cloud.gkemulticloud.v1.AzureNodePool].
 *
 * @param string $azureNodePoolVersion                         The Kubernetes version (e.g. `1.19.10-gke.1000`) running on this node pool.
 * @param string $azureNodePoolConfigSshConfigAuthorizedKey    The SSH public key data for VMs managed by Anthos. This accepts the
 *                                                             authorized_keys file format used in OpenSSH according to the sshd(8) manual
 *                                                             page.
 * @param string $azureNodePoolSubnetId                        The ARM ID of the subnet where the node pool VMs run. Make sure it's a
 *                                                             subnet under the virtual network in the cluster configuration.
 * @param int    $azureNodePoolAutoscalingMinNodeCount         Minimum number of nodes in the node pool. Must be greater than or equal to
 *                                                             1 and less than or equal to max_node_count.
 * @param int    $azureNodePoolAutoscalingMaxNodeCount         Maximum number of nodes in the node pool. Must be greater than or equal to
 *                                                             min_node_count and less than or equal to 50.
 * @param int    $azureNodePoolMaxPodsConstraintMaxPodsPerNode The maximum number of pods to schedule on a single node.
 */
function update_azure_node_pool_sample(
    string $azureNodePoolVersion,
    string $azureNodePoolConfigSshConfigAuthorizedKey,
    string $azureNodePoolSubnetId,
    int $azureNodePoolAutoscalingMinNodeCount,
    int $azureNodePoolAutoscalingMaxNodeCount,
    int $azureNodePoolMaxPodsConstraintMaxPodsPerNode
): void {
    // Create a client.
    $azureClustersClient = new AzureClustersClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $azureNodePoolConfigSshConfig = (new AzureSshConfig())
        ->setAuthorizedKey($azureNodePoolConfigSshConfigAuthorizedKey);
    $azureNodePoolConfig = (new AzureNodeConfig())
        ->setSshConfig($azureNodePoolConfigSshConfig);
    $azureNodePoolAutoscaling = (new AzureNodePoolAutoscaling())
        ->setMinNodeCount($azureNodePoolAutoscalingMinNodeCount)
        ->setMaxNodeCount($azureNodePoolAutoscalingMaxNodeCount);
    $azureNodePoolMaxPodsConstraint = (new MaxPodsConstraint())
        ->setMaxPodsPerNode($azureNodePoolMaxPodsConstraintMaxPodsPerNode);
    $azureNodePool = (new AzureNodePool())
        ->setVersion($azureNodePoolVersion)
        ->setConfig($azureNodePoolConfig)
        ->setSubnetId($azureNodePoolSubnetId)
        ->setAutoscaling($azureNodePoolAutoscaling)
        ->setMaxPodsConstraint($azureNodePoolMaxPodsConstraint);
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $azureClustersClient->updateAzureNodePool($azureNodePool, $updateMask);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AzureNodePool $result */
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
    $azureNodePoolVersion = '[VERSION]';
    $azureNodePoolConfigSshConfigAuthorizedKey = '[AUTHORIZED_KEY]';
    $azureNodePoolSubnetId = '[SUBNET_ID]';
    $azureNodePoolAutoscalingMinNodeCount = 0;
    $azureNodePoolAutoscalingMaxNodeCount = 0;
    $azureNodePoolMaxPodsConstraintMaxPodsPerNode = 0;

    update_azure_node_pool_sample(
        $azureNodePoolVersion,
        $azureNodePoolConfigSshConfigAuthorizedKey,
        $azureNodePoolSubnetId,
        $azureNodePoolAutoscalingMinNodeCount,
        $azureNodePoolAutoscalingMaxNodeCount,
        $azureNodePoolMaxPodsConstraintMaxPodsPerNode
    );
}
// [END gkemulticloud_v1_generated_AzureClusters_UpdateAzureNodePool_sync]
