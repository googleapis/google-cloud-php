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
namespace Google\Cloud\Container\V1;

/**
 * Google Container Engine Cluster Manager v1
 */
class ClusterManagerGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists all clusters owned by a project in either the specified zone or all
     * zones.
     * @param \Google\Cloud\Container\V1\ListClustersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListClusters(\Google\Cloud\Container\V1\ListClustersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/ListClusters',
        $argument,
        ['\Google\Cloud\Container\V1\ListClustersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the details of a specific cluster.
     * @param \Google\Cloud\Container\V1\GetClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetCluster(\Google\Cloud\Container\V1\GetClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/GetCluster',
        $argument,
        ['\Google\Cloud\Container\V1\Cluster', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a cluster, consisting of the specified number and type of Google
     * Compute Engine instances.
     *
     * By default, the cluster is created in the project's
     * [default network](/compute/docs/networks-and-firewalls#networks).
     *
     * One firewall is added for the cluster. After cluster creation,
     * the cluster creates routes for each node to allow the containers
     * on that node to communicate with all other instances in the
     * cluster.
     *
     * Finally, an entry is added to the project's global metadata indicating
     * which CIDR range is being used by the cluster.
     * @param \Google\Cloud\Container\V1\CreateClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateCluster(\Google\Cloud\Container\V1\CreateClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/CreateCluster',
        $argument,
        ['\Google\Cloud\Container\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the settings of a specific cluster.
     * @param \Google\Cloud\Container\V1\UpdateClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateCluster(\Google\Cloud\Container\V1\UpdateClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/UpdateCluster',
        $argument,
        ['\Google\Cloud\Container\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the version and/or image type of a specific node pool.
     * @param \Google\Cloud\Container\V1\UpdateNodePoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateNodePool(\Google\Cloud\Container\V1\UpdateNodePoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/UpdateNodePool',
        $argument,
        ['\Google\Cloud\Container\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the autoscaling settings of a specific node pool.
     * @param \Google\Cloud\Container\V1\SetNodePoolAutoscalingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SetNodePoolAutoscaling(\Google\Cloud\Container\V1\SetNodePoolAutoscalingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/SetNodePoolAutoscaling',
        $argument,
        ['\Google\Cloud\Container\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the logging service of a specific cluster.
     * @param \Google\Cloud\Container\V1\SetLoggingServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SetLoggingService(\Google\Cloud\Container\V1\SetLoggingServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/SetLoggingService',
        $argument,
        ['\Google\Cloud\Container\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the monitoring service of a specific cluster.
     * @param \Google\Cloud\Container\V1\SetMonitoringServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SetMonitoringService(\Google\Cloud\Container\V1\SetMonitoringServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/SetMonitoringService',
        $argument,
        ['\Google\Cloud\Container\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the addons of a specific cluster.
     * @param \Google\Cloud\Container\V1\SetAddonsConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SetAddonsConfig(\Google\Cloud\Container\V1\SetAddonsConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/SetAddonsConfig',
        $argument,
        ['\Google\Cloud\Container\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the locations of a specific cluster.
     * @param \Google\Cloud\Container\V1\SetLocationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SetLocations(\Google\Cloud\Container\V1\SetLocationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/SetLocations',
        $argument,
        ['\Google\Cloud\Container\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the master of a specific cluster.
     * @param \Google\Cloud\Container\V1\UpdateMasterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateMaster(\Google\Cloud\Container\V1\UpdateMasterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/UpdateMaster',
        $argument,
        ['\Google\Cloud\Container\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Used to set master auth materials. Currently supports :-
     * Changing the admin password of a specific cluster.
     * This can be either via password generation or explicitly set the password.
     * @param \Google\Cloud\Container\V1\SetMasterAuthRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SetMasterAuth(\Google\Cloud\Container\V1\SetMasterAuthRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/SetMasterAuth',
        $argument,
        ['\Google\Cloud\Container\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the cluster, including the Kubernetes endpoint and all worker
     * nodes.
     *
     * Firewalls and routes that were configured during cluster creation
     * are also deleted.
     *
     * Other Google Compute Engine resources that might be in use by the cluster
     * (e.g. load balancer resources) will not be deleted if they weren't present
     * at the initial create time.
     * @param \Google\Cloud\Container\V1\DeleteClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteCluster(\Google\Cloud\Container\V1\DeleteClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/DeleteCluster',
        $argument,
        ['\Google\Cloud\Container\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all operations in a project in a specific zone or all zones.
     * @param \Google\Cloud\Container\V1\ListOperationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListOperations(\Google\Cloud\Container\V1\ListOperationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/ListOperations',
        $argument,
        ['\Google\Cloud\Container\V1\ListOperationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the specified operation.
     * @param \Google\Cloud\Container\V1\GetOperationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetOperation(\Google\Cloud\Container\V1\GetOperationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/GetOperation',
        $argument,
        ['\Google\Cloud\Container\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Cancels the specified operation.
     * @param \Google\Cloud\Container\V1\CancelOperationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CancelOperation(\Google\Cloud\Container\V1\CancelOperationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/CancelOperation',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns configuration info about the Container Engine service.
     * @param \Google\Cloud\Container\V1\GetServerConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetServerConfig(\Google\Cloud\Container\V1\GetServerConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/GetServerConfig',
        $argument,
        ['\Google\Cloud\Container\V1\ServerConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the node pools for a cluster.
     * @param \Google\Cloud\Container\V1\ListNodePoolsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListNodePools(\Google\Cloud\Container\V1\ListNodePoolsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/ListNodePools',
        $argument,
        ['\Google\Cloud\Container\V1\ListNodePoolsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves the node pool requested.
     * @param \Google\Cloud\Container\V1\GetNodePoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetNodePool(\Google\Cloud\Container\V1\GetNodePoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/GetNodePool',
        $argument,
        ['\Google\Cloud\Container\V1\NodePool', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a node pool for a cluster.
     * @param \Google\Cloud\Container\V1\CreateNodePoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateNodePool(\Google\Cloud\Container\V1\CreateNodePoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/CreateNodePool',
        $argument,
        ['\Google\Cloud\Container\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a node pool from a cluster.
     * @param \Google\Cloud\Container\V1\DeleteNodePoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteNodePool(\Google\Cloud\Container\V1\DeleteNodePoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/DeleteNodePool',
        $argument,
        ['\Google\Cloud\Container\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Roll back the previously Aborted or Failed NodePool upgrade.
     * This will be an no-op if the last upgrade successfully completed.
     * @param \Google\Cloud\Container\V1\RollbackNodePoolUpgradeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function RollbackNodePoolUpgrade(\Google\Cloud\Container\V1\RollbackNodePoolUpgradeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/RollbackNodePoolUpgrade',
        $argument,
        ['\Google\Cloud\Container\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the NodeManagement options for a node pool.
     * @param \Google\Cloud\Container\V1\SetNodePoolManagementRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SetNodePoolManagement(\Google\Cloud\Container\V1\SetNodePoolManagementRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/SetNodePoolManagement',
        $argument,
        ['\Google\Cloud\Container\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets labels on a cluster.
     * @param \Google\Cloud\Container\V1\SetLabelsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SetLabels(\Google\Cloud\Container\V1\SetLabelsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/SetLabels',
        $argument,
        ['\Google\Cloud\Container\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Enables or disables the ABAC authorization mechanism on a cluster.
     * @param \Google\Cloud\Container\V1\SetLegacyAbacRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SetLegacyAbac(\Google\Cloud\Container\V1\SetLegacyAbacRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/SetLegacyAbac',
        $argument,
        ['\Google\Cloud\Container\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Start master IP rotation.
     * @param \Google\Cloud\Container\V1\StartIPRotationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function StartIPRotation(\Google\Cloud\Container\V1\StartIPRotationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/StartIPRotation',
        $argument,
        ['\Google\Cloud\Container\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Completes master IP rotation.
     * @param \Google\Cloud\Container\V1\CompleteIPRotationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CompleteIPRotation(\Google\Cloud\Container\V1\CompleteIPRotationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/CompleteIPRotation',
        $argument,
        ['\Google\Cloud\Container\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the size of a specific node pool.
     * @param \Google\Cloud\Container\V1\SetNodePoolSizeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SetNodePoolSize(\Google\Cloud\Container\V1\SetNodePoolSizeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/SetNodePoolSize',
        $argument,
        ['\Google\Cloud\Container\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Enables/Disables Network Policy for a cluster.
     * @param \Google\Cloud\Container\V1\SetNetworkPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SetNetworkPolicy(\Google\Cloud\Container\V1\SetNetworkPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/SetNetworkPolicy',
        $argument,
        ['\Google\Cloud\Container\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the maintenance policy for a cluster.
     * @param \Google\Cloud\Container\V1\SetMaintenancePolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SetMaintenancePolicy(\Google\Cloud\Container\V1\SetMaintenancePolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.container.v1.ClusterManager/SetMaintenancePolicy',
        $argument,
        ['\Google\Cloud\Container\V1\Operation', 'decode'],
        $metadata, $options);
    }

}
