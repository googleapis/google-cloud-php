<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2022 Google LLC
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
namespace Google\Cloud\GkeMultiCloud\V1;

/**
 * The AzureClusters API provides a single centrally managed service
 * to create and manage Anthos clusters that run on Azure infrastructure.
 */
class AzureClustersGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new [AzureClient][google.cloud.gkemulticloud.v1.AzureClient] resource on a given Google Cloud project
     * and region.
     *
     * `AzureClient` resources hold client authentication
     * information needed by the Anthos Multicloud API to manage Azure resources
     * on your Azure subscription on your behalf.
     *
     * If successful, the response contains a newly created
     * [Operation][google.longrunning.Operation] resource that can be
     * described to track the status of the operation.
     * @param \Google\Cloud\GkeMultiCloud\V1\CreateAzureClientRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateAzureClient(\Google\Cloud\GkeMultiCloud\V1\CreateAzureClientRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AzureClusters/CreateAzureClient',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Describes a specific [AzureClient][google.cloud.gkemulticloud.v1.AzureClient] resource.
     * @param \Google\Cloud\GkeMultiCloud\V1\GetAzureClientRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAzureClient(\Google\Cloud\GkeMultiCloud\V1\GetAzureClientRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AzureClusters/GetAzureClient',
        $argument,
        ['\Google\Cloud\GkeMultiCloud\V1\AzureClient', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all [AzureClient][google.cloud.gkemulticloud.v1.AzureClient] resources on a given Google Cloud project and
     * region.
     * @param \Google\Cloud\GkeMultiCloud\V1\ListAzureClientsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAzureClients(\Google\Cloud\GkeMultiCloud\V1\ListAzureClientsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AzureClusters/ListAzureClients',
        $argument,
        ['\Google\Cloud\GkeMultiCloud\V1\ListAzureClientsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a specific [AzureClient][google.cloud.gkemulticloud.v1.AzureClient] resource.
     *
     * If the client is used by one or more clusters, deletion will
     * fail and a `FAILED_PRECONDITION` error will be returned.
     *
     * If successful, the response contains a newly created
     * [Operation][google.longrunning.Operation] resource that can be
     * described to track the status of the operation.
     * @param \Google\Cloud\GkeMultiCloud\V1\DeleteAzureClientRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAzureClient(\Google\Cloud\GkeMultiCloud\V1\DeleteAzureClientRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AzureClusters/DeleteAzureClient',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new [AzureCluster][google.cloud.gkemulticloud.v1.AzureCluster] resource on a given GCP project and region.
     *
     * If successful, the response contains a newly created
     * [Operation][google.longrunning.Operation] resource that can be
     * described to track the status of the operation.
     * @param \Google\Cloud\GkeMultiCloud\V1\CreateAzureClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateAzureCluster(\Google\Cloud\GkeMultiCloud\V1\CreateAzureClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AzureClusters/CreateAzureCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an [AzureCluster][google.cloud.gkemulticloud.v1.AzureCluster].
     * @param \Google\Cloud\GkeMultiCloud\V1\UpdateAzureClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAzureCluster(\Google\Cloud\GkeMultiCloud\V1\UpdateAzureClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AzureClusters/UpdateAzureCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Describes a specific [AzureCluster][google.cloud.gkemulticloud.v1.AzureCluster] resource.
     * @param \Google\Cloud\GkeMultiCloud\V1\GetAzureClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAzureCluster(\Google\Cloud\GkeMultiCloud\V1\GetAzureClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AzureClusters/GetAzureCluster',
        $argument,
        ['\Google\Cloud\GkeMultiCloud\V1\AzureCluster', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all [AzureCluster][google.cloud.gkemulticloud.v1.AzureCluster] resources on a given Google Cloud project and
     * region.
     * @param \Google\Cloud\GkeMultiCloud\V1\ListAzureClustersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAzureClusters(\Google\Cloud\GkeMultiCloud\V1\ListAzureClustersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AzureClusters/ListAzureClusters',
        $argument,
        ['\Google\Cloud\GkeMultiCloud\V1\ListAzureClustersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a specific [AzureCluster][google.cloud.gkemulticloud.v1.AzureCluster] resource.
     *
     * Fails if the cluster has one or more associated [AzureNodePool][google.cloud.gkemulticloud.v1.AzureNodePool]
     * resources.
     *
     * If successful, the response contains a newly created
     * [Operation][google.longrunning.Operation] resource that can be
     * described to track the status of the operation.
     * @param \Google\Cloud\GkeMultiCloud\V1\DeleteAzureClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAzureCluster(\Google\Cloud\GkeMultiCloud\V1\DeleteAzureClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AzureClusters/DeleteAzureCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Generates a short-lived access token to authenticate to a given
     * [AzureCluster][google.cloud.gkemulticloud.v1.AzureCluster] resource.
     * @param \Google\Cloud\GkeMultiCloud\V1\GenerateAzureAccessTokenRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GenerateAzureAccessToken(\Google\Cloud\GkeMultiCloud\V1\GenerateAzureAccessTokenRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AzureClusters/GenerateAzureAccessToken',
        $argument,
        ['\Google\Cloud\GkeMultiCloud\V1\GenerateAzureAccessTokenResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new [AzureNodePool][google.cloud.gkemulticloud.v1.AzureNodePool], attached to a given [AzureCluster][google.cloud.gkemulticloud.v1.AzureCluster].
     *
     * If successful, the response contains a newly created
     * [Operation][google.longrunning.Operation] resource that can be
     * described to track the status of the operation.
     * @param \Google\Cloud\GkeMultiCloud\V1\CreateAzureNodePoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateAzureNodePool(\Google\Cloud\GkeMultiCloud\V1\CreateAzureNodePoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AzureClusters/CreateAzureNodePool',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an [AzureNodePool][google.cloud.gkemulticloud.v1.AzureNodePool].
     * @param \Google\Cloud\GkeMultiCloud\V1\UpdateAzureNodePoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAzureNodePool(\Google\Cloud\GkeMultiCloud\V1\UpdateAzureNodePoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AzureClusters/UpdateAzureNodePool',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Describes a specific [AzureNodePool][google.cloud.gkemulticloud.v1.AzureNodePool] resource.
     * @param \Google\Cloud\GkeMultiCloud\V1\GetAzureNodePoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAzureNodePool(\Google\Cloud\GkeMultiCloud\V1\GetAzureNodePoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AzureClusters/GetAzureNodePool',
        $argument,
        ['\Google\Cloud\GkeMultiCloud\V1\AzureNodePool', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all [AzureNodePool][google.cloud.gkemulticloud.v1.AzureNodePool] resources on a given [AzureCluster][google.cloud.gkemulticloud.v1.AzureCluster].
     * @param \Google\Cloud\GkeMultiCloud\V1\ListAzureNodePoolsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAzureNodePools(\Google\Cloud\GkeMultiCloud\V1\ListAzureNodePoolsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AzureClusters/ListAzureNodePools',
        $argument,
        ['\Google\Cloud\GkeMultiCloud\V1\ListAzureNodePoolsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a specific [AzureNodePool][google.cloud.gkemulticloud.v1.AzureNodePool] resource.
     *
     * If successful, the response contains a newly created
     * [Operation][google.longrunning.Operation] resource that can be
     * described to track the status of the operation.
     * @param \Google\Cloud\GkeMultiCloud\V1\DeleteAzureNodePoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAzureNodePool(\Google\Cloud\GkeMultiCloud\V1\DeleteAzureNodePoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AzureClusters/DeleteAzureNodePool',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns information, such as supported Azure regions and Kubernetes
     * versions, on a given Google Cloud location.
     * @param \Google\Cloud\GkeMultiCloud\V1\GetAzureServerConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAzureServerConfig(\Google\Cloud\GkeMultiCloud\V1\GetAzureServerConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AzureClusters/GetAzureServerConfig',
        $argument,
        ['\Google\Cloud\GkeMultiCloud\V1\AzureServerConfig', 'decode'],
        $metadata, $options);
    }

}
