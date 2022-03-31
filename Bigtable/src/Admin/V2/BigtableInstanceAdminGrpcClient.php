<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2020 Google LLC
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
namespace Google\Cloud\Bigtable\Admin\V2;

/**
 * Service for creating, configuring, and deleting Cloud Bigtable Instances and
 * Clusters. Provides access to the Instance and Cluster schemas only, not the
 * tables' metadata or data stored in those tables.
 */
class BigtableInstanceAdminGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Create an instance within a project.
     *
     * Note that exactly one of Cluster.serve_nodes and
     * Cluster.cluster_config.cluster_autoscaling_config can be set. If
     * serve_nodes is set to non-zero, then the cluster is manually scaled. If
     * cluster_config.cluster_autoscaling_config is non-empty, then autoscaling is
     * enabled.
     * @param \Google\Cloud\Bigtable\Admin\V2\CreateInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateInstance(\Google\Cloud\Bigtable\Admin\V2\CreateInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableInstanceAdmin/CreateInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets information about an instance.
     * @param \Google\Cloud\Bigtable\Admin\V2\GetInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetInstance(\Google\Cloud\Bigtable\Admin\V2\GetInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableInstanceAdmin/GetInstance',
        $argument,
        ['\Google\Cloud\Bigtable\Admin\V2\Instance', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists information about instances in a project.
     * @param \Google\Cloud\Bigtable\Admin\V2\ListInstancesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListInstances(\Google\Cloud\Bigtable\Admin\V2\ListInstancesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableInstanceAdmin/ListInstances',
        $argument,
        ['\Google\Cloud\Bigtable\Admin\V2\ListInstancesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an instance within a project. This method updates only the display
     * name and type for an Instance. To update other Instance properties, such as
     * labels, use PartialUpdateInstance.
     * @param \Google\Cloud\Bigtable\Admin\V2\Instance $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateInstance(\Google\Cloud\Bigtable\Admin\V2\Instance $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableInstanceAdmin/UpdateInstance',
        $argument,
        ['\Google\Cloud\Bigtable\Admin\V2\Instance', 'decode'],
        $metadata, $options);
    }

    /**
     * Partially updates an instance within a project. This method can modify all
     * fields of an Instance and is the preferred way to update an Instance.
     * @param \Google\Cloud\Bigtable\Admin\V2\PartialUpdateInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PartialUpdateInstance(\Google\Cloud\Bigtable\Admin\V2\PartialUpdateInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableInstanceAdmin/PartialUpdateInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete an instance from a project.
     * @param \Google\Cloud\Bigtable\Admin\V2\DeleteInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteInstance(\Google\Cloud\Bigtable\Admin\V2\DeleteInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableInstanceAdmin/DeleteInstance',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a cluster within an instance.
     *
     * Note that exactly one of Cluster.serve_nodes and
     * Cluster.cluster_config.cluster_autoscaling_config can be set. If
     * serve_nodes is set to non-zero, then the cluster is manually scaled. If
     * cluster_config.cluster_autoscaling_config is non-empty, then autoscaling is
     * enabled.
     * @param \Google\Cloud\Bigtable\Admin\V2\CreateClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCluster(\Google\Cloud\Bigtable\Admin\V2\CreateClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableInstanceAdmin/CreateCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets information about a cluster.
     * @param \Google\Cloud\Bigtable\Admin\V2\GetClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCluster(\Google\Cloud\Bigtable\Admin\V2\GetClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableInstanceAdmin/GetCluster',
        $argument,
        ['\Google\Cloud\Bigtable\Admin\V2\Cluster', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists information about clusters in an instance.
     * @param \Google\Cloud\Bigtable\Admin\V2\ListClustersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListClusters(\Google\Cloud\Bigtable\Admin\V2\ListClustersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableInstanceAdmin/ListClusters',
        $argument,
        ['\Google\Cloud\Bigtable\Admin\V2\ListClustersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a cluster within an instance.
     *
     * Note that UpdateCluster does not support updating
     * cluster_config.cluster_autoscaling_config. In order to update it, you
     * must use PartialUpdateCluster.
     * @param \Google\Cloud\Bigtable\Admin\V2\Cluster $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCluster(\Google\Cloud\Bigtable\Admin\V2\Cluster $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableInstanceAdmin/UpdateCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Partially updates a cluster within a project. This method is the preferred
     * way to update a Cluster.
     *
     * To enable and update autoscaling, set
     * cluster_config.cluster_autoscaling_config. When autoscaling is enabled,
     * serve_nodes is treated as an OUTPUT_ONLY field, meaning that updates to it
     * are ignored. Note that an update cannot simultaneously set serve_nodes to
     * non-zero and cluster_config.cluster_autoscaling_config to non-empty, and
     * also specify both in the update_mask.
     *
     * To disable autoscaling, clear cluster_config.cluster_autoscaling_config,
     * and explicitly set a serve_node count via the update_mask.
     * @param \Google\Cloud\Bigtable\Admin\V2\PartialUpdateClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PartialUpdateCluster(\Google\Cloud\Bigtable\Admin\V2\PartialUpdateClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableInstanceAdmin/PartialUpdateCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a cluster from an instance.
     * @param \Google\Cloud\Bigtable\Admin\V2\DeleteClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteCluster(\Google\Cloud\Bigtable\Admin\V2\DeleteClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableInstanceAdmin/DeleteCluster',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an app profile within an instance.
     * @param \Google\Cloud\Bigtable\Admin\V2\CreateAppProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateAppProfile(\Google\Cloud\Bigtable\Admin\V2\CreateAppProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableInstanceAdmin/CreateAppProfile',
        $argument,
        ['\Google\Cloud\Bigtable\Admin\V2\AppProfile', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets information about an app profile.
     * @param \Google\Cloud\Bigtable\Admin\V2\GetAppProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAppProfile(\Google\Cloud\Bigtable\Admin\V2\GetAppProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableInstanceAdmin/GetAppProfile',
        $argument,
        ['\Google\Cloud\Bigtable\Admin\V2\AppProfile', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists information about app profiles in an instance.
     * @param \Google\Cloud\Bigtable\Admin\V2\ListAppProfilesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAppProfiles(\Google\Cloud\Bigtable\Admin\V2\ListAppProfilesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableInstanceAdmin/ListAppProfiles',
        $argument,
        ['\Google\Cloud\Bigtable\Admin\V2\ListAppProfilesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an app profile within an instance.
     * @param \Google\Cloud\Bigtable\Admin\V2\UpdateAppProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAppProfile(\Google\Cloud\Bigtable\Admin\V2\UpdateAppProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableInstanceAdmin/UpdateAppProfile',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an app profile from an instance.
     * @param \Google\Cloud\Bigtable\Admin\V2\DeleteAppProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAppProfile(\Google\Cloud\Bigtable\Admin\V2\DeleteAppProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableInstanceAdmin/DeleteAppProfile',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the access control policy for an instance resource. Returns an empty
     * policy if an instance exists but does not have a policy set.
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableInstanceAdmin/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the access control policy on an instance resource. Replaces any
     * existing policy.
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableInstanceAdmin/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns permissions that the caller has on the specified instance resource.
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableInstanceAdmin/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists hot tablets in a cluster, within the time range provided. Hot
     * tablets are ordered based on CPU usage.
     * @param \Google\Cloud\Bigtable\Admin\V2\ListHotTabletsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListHotTablets(\Google\Cloud\Bigtable\Admin\V2\ListHotTabletsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableInstanceAdmin/ListHotTablets',
        $argument,
        ['\Google\Cloud\Bigtable\Admin\V2\ListHotTabletsResponse', 'decode'],
        $metadata, $options);
    }

}
