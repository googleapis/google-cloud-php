<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2017 Google Inc.
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
namespace Google\Cloud\Dataproc\V1;

/**
 * The ClusterControllerService provides methods to manage clusters
 * of Google Compute Engine instances.
 */
class ClusterControllerGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a cluster in a project.
     * @param \Google\Cloud\Dataproc\V1\CreateClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateCluster(\Google\Cloud\Dataproc\V1\CreateClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1.ClusterController/CreateCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a cluster in a project.
     * @param \Google\Cloud\Dataproc\V1\UpdateClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateCluster(\Google\Cloud\Dataproc\V1\UpdateClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1.ClusterController/UpdateCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a cluster in a project.
     * @param \Google\Cloud\Dataproc\V1\DeleteClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteCluster(\Google\Cloud\Dataproc\V1\DeleteClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1.ClusterController/DeleteCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the resource representation for a cluster in a project.
     * @param \Google\Cloud\Dataproc\V1\GetClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetCluster(\Google\Cloud\Dataproc\V1\GetClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1.ClusterController/GetCluster',
        $argument,
        ['\Google\Cloud\Dataproc\V1\Cluster', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all regions/{region}/clusters in a project.
     * @param \Google\Cloud\Dataproc\V1\ListClustersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListClusters(\Google\Cloud\Dataproc\V1\ListClustersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1.ClusterController/ListClusters',
        $argument,
        ['\Google\Cloud\Dataproc\V1\ListClustersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets cluster diagnostic information.
     * After the operation completes, the Operation.response field
     * contains `DiagnoseClusterOutputLocation`.
     * @param \Google\Cloud\Dataproc\V1\DiagnoseClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DiagnoseCluster(\Google\Cloud\Dataproc\V1\DiagnoseClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1.ClusterController/DiagnoseCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
