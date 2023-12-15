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

// [START gkemulticloud_v1_generated_AzureClusters_CreateAzureCluster_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GkeMultiCloud\V1\AzureAuthorization;
use Google\Cloud\GkeMultiCloud\V1\AzureCluster;
use Google\Cloud\GkeMultiCloud\V1\AzureClusterNetworking;
use Google\Cloud\GkeMultiCloud\V1\AzureControlPlane;
use Google\Cloud\GkeMultiCloud\V1\AzureSshConfig;
use Google\Cloud\GkeMultiCloud\V1\Client\AzureClustersClient;
use Google\Cloud\GkeMultiCloud\V1\CreateAzureClusterRequest;
use Google\Cloud\GkeMultiCloud\V1\Fleet;
use Google\Rpc\Status;

/**
 * Creates a new [AzureCluster][google.cloud.gkemulticloud.v1.AzureCluster]
 * resource on a given Google Cloud Platform project and region.
 *
 * If successful, the response contains a newly created
 * [Operation][google.longrunning.Operation] resource that can be
 * described to track the status of the operation.
 *
 * @param string $formattedParent                                       The parent location where this
 *                                                                      [AzureCluster][google.cloud.gkemulticloud.v1.AzureCluster] resource will be
 *                                                                      created.
 *
 *                                                                      Location names are formatted as `projects/<project-id>/locations/<region>`.
 *
 *                                                                      See [Resource Names](https://cloud.google.com/apis/design/resource_names)
 *                                                                      for more details on Google Cloud resource names. Please see
 *                                                                      {@see AzureClustersClient::locationName()} for help formatting this field.
 * @param string $azureClusterAzureRegion                               The Azure region where the cluster runs.
 *
 *                                                                      Each Google Cloud region supports a subset of nearby Azure regions.
 *                                                                      You can call
 *                                                                      [GetAzureServerConfig][google.cloud.gkemulticloud.v1.AzureClusters.GetAzureServerConfig]
 *                                                                      to list all supported Azure regions within a given Google Cloud region.
 * @param string $azureClusterResourceGroupId                           The ARM ID of the resource group where the cluster resources are
 *                                                                      deployed. For example:
 *                                                                      `/subscriptions/<subscription-id>/resourceGroups/<resource-group-name>`
 * @param string $azureClusterNetworkingVirtualNetworkId                The Azure Resource Manager (ARM) ID of the VNet associated with
 *                                                                      your cluster.
 *
 *                                                                      All components in the cluster (i.e. control plane and node pools) run on a
 *                                                                      single VNet.
 *
 *                                                                      Example:
 *                                                                      `/subscriptions/<subscription-id>/resourceGroups/<resource-group-id>/providers/Microsoft.Network/virtualNetworks/<vnet-id>`
 *
 *                                                                      This field cannot be changed after creation.
 * @param string $azureClusterNetworkingPodAddressCidrBlocksElement     The IP address range of the pods in this cluster, in CIDR
 *                                                                      notation (e.g. `10.96.0.0/14`).
 *
 *                                                                      All pods in the cluster get assigned a unique IPv4 address from these
 *                                                                      ranges. Only a single range is supported.
 *
 *                                                                      This field cannot be changed after creation.
 * @param string $azureClusterNetworkingServiceAddressCidrBlocksElement The IP address range for services in this cluster, in CIDR
 *                                                                      notation (e.g. `10.96.0.0/14`).
 *
 *                                                                      All services in the cluster get assigned a unique IPv4 address from these
 *                                                                      ranges. Only a single range is supported.
 *
 *                                                                      This field cannot be changed after creating a cluster.
 * @param string $azureClusterControlPlaneVersion                       The Kubernetes version to run on control plane replicas
 *                                                                      (e.g. `1.19.10-gke.1000`).
 *
 *                                                                      You can list all supported versions on a given Google Cloud region by
 *                                                                      calling
 *                                                                      [GetAzureServerConfig][google.cloud.gkemulticloud.v1.AzureClusters.GetAzureServerConfig].
 * @param string $azureClusterControlPlaneSshConfigAuthorizedKey        The SSH public key data for VMs managed by Anthos. This accepts
 *                                                                      the authorized_keys file format used in OpenSSH according to the sshd(8)
 *                                                                      manual page.
 * @param string $azureClusterFleetProject                              The name of the Fleet host project where this cluster will be
 *                                                                      registered.
 *
 *                                                                      Project names are formatted as
 *                                                                      `projects/<project-number>`.
 * @param string $azureClusterId                                        A client provided ID the resource. Must be unique within the
 *                                                                      parent resource.
 *
 *                                                                      The provided ID will be part of the
 *                                                                      [AzureCluster][google.cloud.gkemulticloud.v1.AzureCluster] resource name
 *                                                                      formatted as
 *                                                                      `projects/<project-id>/locations/<region>/azureClusters/<cluster-id>`.
 *
 *                                                                      Valid characters are `/[a-z][0-9]-/`. Cannot be longer than 63 characters.
 */
function create_azure_cluster_sample(
    string $formattedParent,
    string $azureClusterAzureRegion,
    string $azureClusterResourceGroupId,
    string $azureClusterNetworkingVirtualNetworkId,
    string $azureClusterNetworkingPodAddressCidrBlocksElement,
    string $azureClusterNetworkingServiceAddressCidrBlocksElement,
    string $azureClusterControlPlaneVersion,
    string $azureClusterControlPlaneSshConfigAuthorizedKey,
    string $azureClusterFleetProject,
    string $azureClusterId
): void {
    // Create a client.
    $azureClustersClient = new AzureClustersClient();

    // Prepare the request message.
    $azureClusterNetworkingPodAddressCidrBlocks = [
        $azureClusterNetworkingPodAddressCidrBlocksElement,
    ];
    $azureClusterNetworkingServiceAddressCidrBlocks = [
        $azureClusterNetworkingServiceAddressCidrBlocksElement,
    ];
    $azureClusterNetworking = (new AzureClusterNetworking())
        ->setVirtualNetworkId($azureClusterNetworkingVirtualNetworkId)
        ->setPodAddressCidrBlocks($azureClusterNetworkingPodAddressCidrBlocks)
        ->setServiceAddressCidrBlocks($azureClusterNetworkingServiceAddressCidrBlocks);
    $azureClusterControlPlaneSshConfig = (new AzureSshConfig())
        ->setAuthorizedKey($azureClusterControlPlaneSshConfigAuthorizedKey);
    $azureClusterControlPlane = (new AzureControlPlane())
        ->setVersion($azureClusterControlPlaneVersion)
        ->setSshConfig($azureClusterControlPlaneSshConfig);
    $azureClusterAuthorization = new AzureAuthorization();
    $azureClusterFleet = (new Fleet())
        ->setProject($azureClusterFleetProject);
    $azureCluster = (new AzureCluster())
        ->setAzureRegion($azureClusterAzureRegion)
        ->setResourceGroupId($azureClusterResourceGroupId)
        ->setNetworking($azureClusterNetworking)
        ->setControlPlane($azureClusterControlPlane)
        ->setAuthorization($azureClusterAuthorization)
        ->setFleet($azureClusterFleet);
    $request = (new CreateAzureClusterRequest())
        ->setParent($formattedParent)
        ->setAzureCluster($azureCluster)
        ->setAzureClusterId($azureClusterId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $azureClustersClient->createAzureCluster($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AzureCluster $result */
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
    $formattedParent = AzureClustersClient::locationName('[PROJECT]', '[LOCATION]');
    $azureClusterAzureRegion = '[AZURE_REGION]';
    $azureClusterResourceGroupId = '[RESOURCE_GROUP_ID]';
    $azureClusterNetworkingVirtualNetworkId = '[VIRTUAL_NETWORK_ID]';
    $azureClusterNetworkingPodAddressCidrBlocksElement = '[POD_ADDRESS_CIDR_BLOCKS]';
    $azureClusterNetworkingServiceAddressCidrBlocksElement = '[SERVICE_ADDRESS_CIDR_BLOCKS]';
    $azureClusterControlPlaneVersion = '[VERSION]';
    $azureClusterControlPlaneSshConfigAuthorizedKey = '[AUTHORIZED_KEY]';
    $azureClusterFleetProject = '[PROJECT]';
    $azureClusterId = '[AZURE_CLUSTER_ID]';

    create_azure_cluster_sample(
        $formattedParent,
        $azureClusterAzureRegion,
        $azureClusterResourceGroupId,
        $azureClusterNetworkingVirtualNetworkId,
        $azureClusterNetworkingPodAddressCidrBlocksElement,
        $azureClusterNetworkingServiceAddressCidrBlocksElement,
        $azureClusterControlPlaneVersion,
        $azureClusterControlPlaneSshConfigAuthorizedKey,
        $azureClusterFleetProject,
        $azureClusterId
    );
}
// [END gkemulticloud_v1_generated_AzureClusters_CreateAzureCluster_sync]
