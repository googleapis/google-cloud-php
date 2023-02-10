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
 * The AttachedClusters API provides a single centrally managed service
 * to register and manage Anthos attached clusters that run on customer's owned
 * infrastructure.
 */
class AttachedClustersGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new
     * [AttachedCluster][google.cloud.gkemulticloud.v1.AttachedCluster] resource
     * on a given Google Cloud Platform project and region.
     *
     * If successful, the response contains a newly created
     * [Operation][google.longrunning.Operation] resource that can be
     * described to track the status of the operation.
     * @param \Google\Cloud\GkeMultiCloud\V1\CreateAttachedClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateAttachedCluster(\Google\Cloud\GkeMultiCloud\V1\CreateAttachedClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AttachedClusters/CreateAttachedCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an
     * [AttachedCluster][google.cloud.gkemulticloud.v1.AttachedCluster].
     * @param \Google\Cloud\GkeMultiCloud\V1\UpdateAttachedClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAttachedCluster(\Google\Cloud\GkeMultiCloud\V1\UpdateAttachedClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AttachedClusters/UpdateAttachedCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Imports creates a new
     * [AttachedCluster][google.cloud.gkemulticloud.v1.AttachedCluster] resource
     * by importing an existing Fleet Membership resource.
     *
     * Attached Clusters created before the introduction of the Anthos Multi-Cloud
     * API can be imported through this method.
     *
     * If successful, the response contains a newly created
     * [Operation][google.longrunning.Operation] resource that can be
     * described to track the status of the operation.
     * @param \Google\Cloud\GkeMultiCloud\V1\ImportAttachedClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ImportAttachedCluster(\Google\Cloud\GkeMultiCloud\V1\ImportAttachedClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AttachedClusters/ImportAttachedCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Describes a specific
     * [AttachedCluster][google.cloud.gkemulticloud.v1.AttachedCluster] resource.
     * @param \Google\Cloud\GkeMultiCloud\V1\GetAttachedClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAttachedCluster(\Google\Cloud\GkeMultiCloud\V1\GetAttachedClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AttachedClusters/GetAttachedCluster',
        $argument,
        ['\Google\Cloud\GkeMultiCloud\V1\AttachedCluster', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all [AttachedCluster][google.cloud.gkemulticloud.v1.AttachedCluster]
     * resources on a given Google Cloud project and region.
     * @param \Google\Cloud\GkeMultiCloud\V1\ListAttachedClustersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAttachedClusters(\Google\Cloud\GkeMultiCloud\V1\ListAttachedClustersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AttachedClusters/ListAttachedClusters',
        $argument,
        ['\Google\Cloud\GkeMultiCloud\V1\ListAttachedClustersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a specific
     * [AttachedCluster][google.cloud.gkemulticloud.v1.AttachedCluster] resource.
     *
     * If successful, the response contains a newly created
     * [Operation][google.longrunning.Operation] resource that can be
     * described to track the status of the operation.
     * @param \Google\Cloud\GkeMultiCloud\V1\DeleteAttachedClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAttachedCluster(\Google\Cloud\GkeMultiCloud\V1\DeleteAttachedClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AttachedClusters/DeleteAttachedCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns information, such as supported Kubernetes versions, on a given
     * Google Cloud location.
     * @param \Google\Cloud\GkeMultiCloud\V1\GetAttachedServerConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAttachedServerConfig(\Google\Cloud\GkeMultiCloud\V1\GetAttachedServerConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AttachedClusters/GetAttachedServerConfig',
        $argument,
        ['\Google\Cloud\GkeMultiCloud\V1\AttachedServerConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Generates the install manifest to be installed on the target cluster.
     * @param \Google\Cloud\GkeMultiCloud\V1\GenerateAttachedClusterInstallManifestRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GenerateAttachedClusterInstallManifest(\Google\Cloud\GkeMultiCloud\V1\GenerateAttachedClusterInstallManifestRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkemulticloud.v1.AttachedClusters/GenerateAttachedClusterInstallManifest',
        $argument,
        ['\Google\Cloud\GkeMultiCloud\V1\GenerateAttachedClusterInstallManifestResponse', 'decode'],
        $metadata, $options);
    }

}
