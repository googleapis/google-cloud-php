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
namespace Google\Cloud\VmwareEngine\V1;

/**
 * VMwareEngine manages VMware's private clusters in the Cloud.
 */
class VmwareEngineGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists `PrivateCloud` resources in a given project and location.
     * @param \Google\Cloud\VmwareEngine\V1\ListPrivateCloudsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListPrivateClouds(\Google\Cloud\VmwareEngine\V1\ListPrivateCloudsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/ListPrivateClouds',
        $argument,
        ['\Google\Cloud\VmwareEngine\V1\ListPrivateCloudsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a `PrivateCloud` resource by its resource name.
     * @param \Google\Cloud\VmwareEngine\V1\GetPrivateCloudRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetPrivateCloud(\Google\Cloud\VmwareEngine\V1\GetPrivateCloudRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/GetPrivateCloud',
        $argument,
        ['\Google\Cloud\VmwareEngine\V1\PrivateCloud', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new `PrivateCloud` resource in a given project and location.
     * Private clouds can only be created in zones, regional private clouds are
     * not supported.
     *
     * Creating a private cloud also creates a [management
     * cluster](https://cloud.google.com/vmware-engine/docs/concepts-vmware-components)
     * for that private cloud.
     * @param \Google\Cloud\VmwareEngine\V1\CreatePrivateCloudRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreatePrivateCloud(\Google\Cloud\VmwareEngine\V1\CreatePrivateCloudRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/CreatePrivateCloud',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Modifies a `PrivateCloud` resource. Only the following fields can be
     * updated: `description`.
     * Only fields specified in `updateMask` are applied.
     *
     * During operation processing, the resource is temporarily in the `ACTIVE`
     * state before the operation fully completes. For that period of time, you
     * can't update the resource. Use the operation status to determine when the
     * processing fully completes.
     * @param \Google\Cloud\VmwareEngine\V1\UpdatePrivateCloudRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdatePrivateCloud(\Google\Cloud\VmwareEngine\V1\UpdatePrivateCloudRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/UpdatePrivateCloud',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Schedules a `PrivateCloud` resource for deletion.
     *
     * A `PrivateCloud` resource scheduled for deletion has `PrivateCloud.state`
     * set to `DELETED` and `expireTime` set to the time when deletion is final
     * and can no longer be reversed. The delete operation is marked as done
     * as soon as the `PrivateCloud` is successfully scheduled for deletion
     * (this also applies when `delayHours` is set to zero), and the operation is
     * not kept in pending state until `PrivateCloud` is purged.
     * `PrivateCloud` can be restored using `UndeletePrivateCloud` method before
     * the `expireTime` elapses. When `expireTime` is reached, deletion is final
     * and all private cloud resources are irreversibly removed and billing stops.
     * During the final removal process, `PrivateCloud.state` is set to `PURGING`.
     * `PrivateCloud` can be polled using standard `GET` method for the whole
     * period of deletion and purging. It will not be returned only
     * when it is completely purged.
     * @param \Google\Cloud\VmwareEngine\V1\DeletePrivateCloudRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeletePrivateCloud(\Google\Cloud\VmwareEngine\V1\DeletePrivateCloudRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/DeletePrivateCloud',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Restores a private cloud that was previously scheduled for deletion by
     * `DeletePrivateCloud`. A `PrivateCloud` resource scheduled for deletion has
     * `PrivateCloud.state` set to `DELETED` and `PrivateCloud.expireTime` set to
     * the time when deletion can no longer be reversed.
     * @param \Google\Cloud\VmwareEngine\V1\UndeletePrivateCloudRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UndeletePrivateCloud(\Google\Cloud\VmwareEngine\V1\UndeletePrivateCloudRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/UndeletePrivateCloud',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists `Cluster` resources in a given private cloud.
     * @param \Google\Cloud\VmwareEngine\V1\ListClustersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListClusters(\Google\Cloud\VmwareEngine\V1\ListClustersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/ListClusters',
        $argument,
        ['\Google\Cloud\VmwareEngine\V1\ListClustersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a `Cluster` resource by its resource name.
     * @param \Google\Cloud\VmwareEngine\V1\GetClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCluster(\Google\Cloud\VmwareEngine\V1\GetClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/GetCluster',
        $argument,
        ['\Google\Cloud\VmwareEngine\V1\Cluster', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new cluster in a given private cloud.
     * Creating a new cluster provides additional nodes for
     * use in the parent private cloud and requires sufficient [node
     * quota](https://cloud.google.com/vmware-engine/quotas).
     * @param \Google\Cloud\VmwareEngine\V1\CreateClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCluster(\Google\Cloud\VmwareEngine\V1\CreateClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/CreateCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Modifies a `Cluster` resource. Only the following fields can be updated:
     * `node_type_configs.*.node_count`. Only fields specified in `updateMask` are
     * applied.
     *
     * During operation processing, the resource is temporarily in the `ACTIVE`
     * state before the operation fully completes. For that period of time, you
     * can't update the resource. Use the operation status to determine when the
     * processing fully completes.
     * @param \Google\Cloud\VmwareEngine\V1\UpdateClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCluster(\Google\Cloud\VmwareEngine\V1\UpdateClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/UpdateCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a `Cluster` resource. To avoid unintended data loss, migrate or
     * gracefully shut down any workloads running on the cluster before deletion.
     * You cannot delete the management cluster of a private cloud using this
     * method.
     * @param \Google\Cloud\VmwareEngine\V1\DeleteClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteCluster(\Google\Cloud\VmwareEngine\V1\DeleteClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/DeleteCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists subnets in a given private cloud.
     * @param \Google\Cloud\VmwareEngine\V1\ListSubnetsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListSubnets(\Google\Cloud\VmwareEngine\V1\ListSubnetsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/ListSubnets',
        $argument,
        ['\Google\Cloud\VmwareEngine\V1\ListSubnetsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists node types
     * @param \Google\Cloud\VmwareEngine\V1\ListNodeTypesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListNodeTypes(\Google\Cloud\VmwareEngine\V1\ListNodeTypesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/ListNodeTypes',
        $argument,
        ['\Google\Cloud\VmwareEngine\V1\ListNodeTypesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single `NodeType`.
     * @param \Google\Cloud\VmwareEngine\V1\GetNodeTypeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetNodeType(\Google\Cloud\VmwareEngine\V1\GetNodeTypeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/GetNodeType',
        $argument,
        ['\Google\Cloud\VmwareEngine\V1\NodeType', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of credentials for NSX appliance.
     * @param \Google\Cloud\VmwareEngine\V1\ShowNsxCredentialsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ShowNsxCredentials(\Google\Cloud\VmwareEngine\V1\ShowNsxCredentialsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/ShowNsxCredentials',
        $argument,
        ['\Google\Cloud\VmwareEngine\V1\Credentials', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of credentials for Vcenter appliance.
     * @param \Google\Cloud\VmwareEngine\V1\ShowVcenterCredentialsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ShowVcenterCredentials(\Google\Cloud\VmwareEngine\V1\ShowVcenterCredentialsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/ShowVcenterCredentials',
        $argument,
        ['\Google\Cloud\VmwareEngine\V1\Credentials', 'decode'],
        $metadata, $options);
    }

    /**
     * Resets credentials of the NSX appliance.
     * @param \Google\Cloud\VmwareEngine\V1\ResetNsxCredentialsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResetNsxCredentials(\Google\Cloud\VmwareEngine\V1\ResetNsxCredentialsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/ResetNsxCredentials',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Resets credentials of the Vcenter appliance.
     * @param \Google\Cloud\VmwareEngine\V1\ResetVcenterCredentialsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResetVcenterCredentials(\Google\Cloud\VmwareEngine\V1\ResetVcenterCredentialsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/ResetVcenterCredentials',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new HCX activation key in a given private cloud.
     * @param \Google\Cloud\VmwareEngine\V1\CreateHcxActivationKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateHcxActivationKey(\Google\Cloud\VmwareEngine\V1\CreateHcxActivationKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/CreateHcxActivationKey',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists `HcxActivationKey` resources in a given private cloud.
     * @param \Google\Cloud\VmwareEngine\V1\ListHcxActivationKeysRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListHcxActivationKeys(\Google\Cloud\VmwareEngine\V1\ListHcxActivationKeysRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/ListHcxActivationKeys',
        $argument,
        ['\Google\Cloud\VmwareEngine\V1\ListHcxActivationKeysResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a `HcxActivationKey` resource by its resource name.
     * @param \Google\Cloud\VmwareEngine\V1\GetHcxActivationKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetHcxActivationKey(\Google\Cloud\VmwareEngine\V1\GetHcxActivationKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/GetHcxActivationKey',
        $argument,
        ['\Google\Cloud\VmwareEngine\V1\HcxActivationKey', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a `NetworkPolicy` resource by its resource name.
     * @param \Google\Cloud\VmwareEngine\V1\GetNetworkPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetNetworkPolicy(\Google\Cloud\VmwareEngine\V1\GetNetworkPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/GetNetworkPolicy',
        $argument,
        ['\Google\Cloud\VmwareEngine\V1\NetworkPolicy', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists `NetworkPolicy` resources in a specified project and location.
     * @param \Google\Cloud\VmwareEngine\V1\ListNetworkPoliciesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListNetworkPolicies(\Google\Cloud\VmwareEngine\V1\ListNetworkPoliciesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/ListNetworkPolicies',
        $argument,
        ['\Google\Cloud\VmwareEngine\V1\ListNetworkPoliciesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new network policy in a given VMware Engine network of a
     * project and location (region). A new network policy cannot be created if
     * another network policy already exists in the same scope.
     * @param \Google\Cloud\VmwareEngine\V1\CreateNetworkPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateNetworkPolicy(\Google\Cloud\VmwareEngine\V1\CreateNetworkPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/CreateNetworkPolicy',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Modifies a `NetworkPolicy` resource. Only the following fields can be
     * updated: `internet_access`, `external_ip`, `edge_services_cidr`.
     * Only fields specified in `updateMask` are applied. When updating a network
     * policy, the external IP network service can only be disabled if there are
     * no external IP addresses present in the scope of the policy. Also, a
     * `NetworkService` cannot be updated when `NetworkService.state` is set
     * to `RECONCILING`.
     *
     * During operation processing, the resource is temporarily in the `ACTIVE`
     * state before the operation fully completes. For that period of time, you
     * can't update the resource. Use the operation status to determine when the
     * processing fully completes.
     * @param \Google\Cloud\VmwareEngine\V1\UpdateNetworkPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateNetworkPolicy(\Google\Cloud\VmwareEngine\V1\UpdateNetworkPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/UpdateNetworkPolicy',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a `NetworkPolicy` resource. A network policy cannot be deleted
     * when `NetworkService.state` is set to `RECONCILING` for either its external
     * IP or internet access service.
     * @param \Google\Cloud\VmwareEngine\V1\DeleteNetworkPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteNetworkPolicy(\Google\Cloud\VmwareEngine\V1\DeleteNetworkPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/DeleteNetworkPolicy',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new VMware Engine network that can be used by a private cloud.
     * @param \Google\Cloud\VmwareEngine\V1\CreateVmwareEngineNetworkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateVmwareEngineNetwork(\Google\Cloud\VmwareEngine\V1\CreateVmwareEngineNetworkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/CreateVmwareEngineNetwork',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Modifies a VMware Engine network resource. Only the following fields can be
     * updated: `description`. Only fields specified in `updateMask` are
     * applied.
     * @param \Google\Cloud\VmwareEngine\V1\UpdateVmwareEngineNetworkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateVmwareEngineNetwork(\Google\Cloud\VmwareEngine\V1\UpdateVmwareEngineNetworkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/UpdateVmwareEngineNetwork',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a `VmwareEngineNetwork` resource. You can only delete a VMware
     * Engine network after all resources that refer to it are deleted. For
     * example, a private cloud, a network peering, and a network policy can all
     * refer to the same VMware Engine network.
     * @param \Google\Cloud\VmwareEngine\V1\DeleteVmwareEngineNetworkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteVmwareEngineNetwork(\Google\Cloud\VmwareEngine\V1\DeleteVmwareEngineNetworkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/DeleteVmwareEngineNetwork',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a `VmwareEngineNetwork` resource by its resource name. The
     * resource contains details of the VMware Engine network, such as its VMware
     * Engine network type, peered networks in a service project, and state
     * (for example, `CREATING`, `ACTIVE`, `DELETING`).
     * @param \Google\Cloud\VmwareEngine\V1\GetVmwareEngineNetworkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetVmwareEngineNetwork(\Google\Cloud\VmwareEngine\V1\GetVmwareEngineNetworkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/GetVmwareEngineNetwork',
        $argument,
        ['\Google\Cloud\VmwareEngine\V1\VmwareEngineNetwork', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists `VmwareEngineNetwork` resources in a given project and location.
     * @param \Google\Cloud\VmwareEngine\V1\ListVmwareEngineNetworksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListVmwareEngineNetworks(\Google\Cloud\VmwareEngine\V1\ListVmwareEngineNetworksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmwareengine.v1.VmwareEngine/ListVmwareEngineNetworks',
        $argument,
        ['\Google\Cloud\VmwareEngine\V1\ListVmwareEngineNetworksResponse', 'decode'],
        $metadata, $options);
    }

}
