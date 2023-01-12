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
 * The AwsClusters API provides a single centrally managed service
 * to create and manage Anthos clusters that run on AWS infrastructure.
 */
class AwsClustersGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new [AwsCluster][google.cloud.gkemulticloud.v1.AwsCluster] resource on a given GCP project and region.
     *
     * If successful, the response contains a newly created
     * [Operation][google.longrunning.Operation] resource that can be
     * described to track the status of the operation.
     * @param \Google\Cloud\GkeMultiCloud\V1\CreateAwsClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateAwsCluster(\Google\Cloud\GkeMultiCloud\V1\CreateAwsClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AwsClusters/CreateAwsCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an [AwsCluster][google.cloud.gkemulticloud.v1.AwsCluster].
     * @param \Google\Cloud\GkeMultiCloud\V1\UpdateAwsClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAwsCluster(\Google\Cloud\GkeMultiCloud\V1\UpdateAwsClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AwsClusters/UpdateAwsCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Describes a specific [AwsCluster][google.cloud.gkemulticloud.v1.AwsCluster] resource.
     * @param \Google\Cloud\GkeMultiCloud\V1\GetAwsClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAwsCluster(\Google\Cloud\GkeMultiCloud\V1\GetAwsClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AwsClusters/GetAwsCluster',
        $argument,
        ['\Google\Cloud\GkeMultiCloud\V1\AwsCluster', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all [AwsCluster][google.cloud.gkemulticloud.v1.AwsCluster] resources on a given Google Cloud project and
     * region.
     * @param \Google\Cloud\GkeMultiCloud\V1\ListAwsClustersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAwsClusters(\Google\Cloud\GkeMultiCloud\V1\ListAwsClustersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AwsClusters/ListAwsClusters',
        $argument,
        ['\Google\Cloud\GkeMultiCloud\V1\ListAwsClustersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a specific [AwsCluster][google.cloud.gkemulticloud.v1.AwsCluster] resource.
     *
     * Fails if the cluster has one or more associated [AwsNodePool][google.cloud.gkemulticloud.v1.AwsNodePool]
     * resources.
     *
     * If successful, the response contains a newly created
     * [Operation][google.longrunning.Operation] resource that can be
     * described to track the status of the operation.
     * @param \Google\Cloud\GkeMultiCloud\V1\DeleteAwsClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAwsCluster(\Google\Cloud\GkeMultiCloud\V1\DeleteAwsClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AwsClusters/DeleteAwsCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Generates a short-lived access token to authenticate to a given
     * [AwsCluster][google.cloud.gkemulticloud.v1.AwsCluster] resource.
     * @param \Google\Cloud\GkeMultiCloud\V1\GenerateAwsAccessTokenRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GenerateAwsAccessToken(\Google\Cloud\GkeMultiCloud\V1\GenerateAwsAccessTokenRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AwsClusters/GenerateAwsAccessToken',
        $argument,
        ['\Google\Cloud\GkeMultiCloud\V1\GenerateAwsAccessTokenResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new [AwsNodePool][google.cloud.gkemulticloud.v1.AwsNodePool], attached to a given [AwsCluster][google.cloud.gkemulticloud.v1.AwsCluster].
     *
     * If successful, the response contains a newly created
     * [Operation][google.longrunning.Operation] resource that can be
     * described to track the status of the operation.
     * @param \Google\Cloud\GkeMultiCloud\V1\CreateAwsNodePoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateAwsNodePool(\Google\Cloud\GkeMultiCloud\V1\CreateAwsNodePoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AwsClusters/CreateAwsNodePool',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an [AwsNodePool][google.cloud.gkemulticloud.v1.AwsNodePool].
     * @param \Google\Cloud\GkeMultiCloud\V1\UpdateAwsNodePoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAwsNodePool(\Google\Cloud\GkeMultiCloud\V1\UpdateAwsNodePoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AwsClusters/UpdateAwsNodePool',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Describes a specific [AwsNodePool][google.cloud.gkemulticloud.v1.AwsNodePool] resource.
     * @param \Google\Cloud\GkeMultiCloud\V1\GetAwsNodePoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAwsNodePool(\Google\Cloud\GkeMultiCloud\V1\GetAwsNodePoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AwsClusters/GetAwsNodePool',
        $argument,
        ['\Google\Cloud\GkeMultiCloud\V1\AwsNodePool', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all [AwsNodePool][google.cloud.gkemulticloud.v1.AwsNodePool] resources on a given [AwsCluster][google.cloud.gkemulticloud.v1.AwsCluster].
     * @param \Google\Cloud\GkeMultiCloud\V1\ListAwsNodePoolsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAwsNodePools(\Google\Cloud\GkeMultiCloud\V1\ListAwsNodePoolsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AwsClusters/ListAwsNodePools',
        $argument,
        ['\Google\Cloud\GkeMultiCloud\V1\ListAwsNodePoolsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a specific [AwsNodePool][google.cloud.gkemulticloud.v1.AwsNodePool] resource.
     *
     * If successful, the response contains a newly created
     * [Operation][google.longrunning.Operation] resource that can be
     * described to track the status of the operation.
     * @param \Google\Cloud\GkeMultiCloud\V1\DeleteAwsNodePoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAwsNodePool(\Google\Cloud\GkeMultiCloud\V1\DeleteAwsNodePoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AwsClusters/DeleteAwsNodePool',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns information, such as supported AWS regions and Kubernetes
     * versions, on a given Google Cloud location.
     * @param \Google\Cloud\GkeMultiCloud\V1\GetAwsServerConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAwsServerConfig(\Google\Cloud\GkeMultiCloud\V1\GetAwsServerConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AwsClusters/GetAwsServerConfig',
        $argument,
        ['\Google\Cloud\GkeMultiCloud\V1\AwsServerConfig', 'decode'],
        $metadata, $options);
    }

}
