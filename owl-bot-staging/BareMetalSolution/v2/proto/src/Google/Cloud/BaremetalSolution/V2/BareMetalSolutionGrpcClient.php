<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2021 Google LLC
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
namespace Google\Cloud\BaremetalSolution\V2;

/**
 * Performs management operations on Bare Metal Solution servers.
 *
 * The `baremetalsolution.googleapis.com` service provides management
 * capabilities for Bare Metal Solution servers. To access the API methods, you
 * must assign Bare Metal Solution IAM roles containing the desired permissions
 * to your staff in your Google Cloud project. You must also enable the Bare
 * Metal Solution API. Once enabled, the methods act
 * upon specific servers in your Bare Metal Solution environment.
 */
class BareMetalSolutionGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * List servers in a given project and location.
     * @param \Google\Cloud\BaremetalSolution\V2\ListInstancesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListInstances(\Google\Cloud\BaremetalSolution\V2\ListInstancesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/ListInstances',
        $argument,
        ['\Google\Cloud\BaremetalSolution\V2\ListInstancesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get details about a single server.
     * @param \Google\Cloud\BaremetalSolution\V2\GetInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetInstance(\Google\Cloud\BaremetalSolution\V2\GetInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/GetInstance',
        $argument,
        ['\Google\Cloud\BaremetalSolution\V2\Instance', 'decode'],
        $metadata, $options);
    }

    /**
     * Perform an ungraceful, hard reset on a server. Equivalent to shutting the
     * power off and then turning it back on.
     * @param \Google\Cloud\BaremetalSolution\V2\ResetInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResetInstance(\Google\Cloud\BaremetalSolution\V2\ResetInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/ResetInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * List storage volumes in a given project and location.
     * @param \Google\Cloud\BaremetalSolution\V2\ListVolumesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListVolumes(\Google\Cloud\BaremetalSolution\V2\ListVolumesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/ListVolumes',
        $argument,
        ['\Google\Cloud\BaremetalSolution\V2\ListVolumesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get details of a single storage volume.
     * @param \Google\Cloud\BaremetalSolution\V2\GetVolumeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetVolume(\Google\Cloud\BaremetalSolution\V2\GetVolumeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/GetVolume',
        $argument,
        ['\Google\Cloud\BaremetalSolution\V2\Volume', 'decode'],
        $metadata, $options);
    }

    /**
     * Update details of a single storage volume.
     * @param \Google\Cloud\BaremetalSolution\V2\UpdateVolumeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateVolume(\Google\Cloud\BaremetalSolution\V2\UpdateVolumeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/UpdateVolume',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * List network in a given project and location.
     * @param \Google\Cloud\BaremetalSolution\V2\ListNetworksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListNetworks(\Google\Cloud\BaremetalSolution\V2\ListNetworksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/ListNetworks',
        $argument,
        ['\Google\Cloud\BaremetalSolution\V2\ListNetworksResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get details of a single network.
     * @param \Google\Cloud\BaremetalSolution\V2\GetNetworkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetNetwork(\Google\Cloud\BaremetalSolution\V2\GetNetworkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/GetNetwork',
        $argument,
        ['\Google\Cloud\BaremetalSolution\V2\Network', 'decode'],
        $metadata, $options);
    }

    /**
     * List snapshot schedule policies in a given project and location.
     * @param \Google\Cloud\BaremetalSolution\V2\ListSnapshotSchedulePoliciesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListSnapshotSchedulePolicies(\Google\Cloud\BaremetalSolution\V2\ListSnapshotSchedulePoliciesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/ListSnapshotSchedulePolicies',
        $argument,
        ['\Google\Cloud\BaremetalSolution\V2\ListSnapshotSchedulePoliciesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get details of a single snapshot schedule policy.
     * @param \Google\Cloud\BaremetalSolution\V2\GetSnapshotSchedulePolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSnapshotSchedulePolicy(\Google\Cloud\BaremetalSolution\V2\GetSnapshotSchedulePolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/GetSnapshotSchedulePolicy',
        $argument,
        ['\Google\Cloud\BaremetalSolution\V2\SnapshotSchedulePolicy', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a snapshot schedule policy in the specified project.
     * @param \Google\Cloud\BaremetalSolution\V2\CreateSnapshotSchedulePolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateSnapshotSchedulePolicy(\Google\Cloud\BaremetalSolution\V2\CreateSnapshotSchedulePolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/CreateSnapshotSchedulePolicy',
        $argument,
        ['\Google\Cloud\BaremetalSolution\V2\SnapshotSchedulePolicy', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a snapshot schedule policy in the specified project.
     * @param \Google\Cloud\BaremetalSolution\V2\UpdateSnapshotSchedulePolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateSnapshotSchedulePolicy(\Google\Cloud\BaremetalSolution\V2\UpdateSnapshotSchedulePolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/UpdateSnapshotSchedulePolicy',
        $argument,
        ['\Google\Cloud\BaremetalSolution\V2\SnapshotSchedulePolicy', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete a named snapshot schedule policy.
     * @param \Google\Cloud\BaremetalSolution\V2\DeleteSnapshotSchedulePolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteSnapshotSchedulePolicy(\Google\Cloud\BaremetalSolution\V2\DeleteSnapshotSchedulePolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/DeleteSnapshotSchedulePolicy',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a storage volume snapshot in a containing volume.
     * @param \Google\Cloud\BaremetalSolution\V2\CreateVolumeSnapshotRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateVolumeSnapshot(\Google\Cloud\BaremetalSolution\V2\CreateVolumeSnapshotRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/CreateVolumeSnapshot',
        $argument,
        ['\Google\Cloud\BaremetalSolution\V2\VolumeSnapshot', 'decode'],
        $metadata, $options);
    }

    /**
     * Restore a storage volume snapshot to its containing volume.
     * @param \Google\Cloud\BaremetalSolution\V2\RestoreVolumeSnapshotRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RestoreVolumeSnapshot(\Google\Cloud\BaremetalSolution\V2\RestoreVolumeSnapshotRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/RestoreVolumeSnapshot',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a storage volume snapshot for a given volume.
     * @param \Google\Cloud\BaremetalSolution\V2\DeleteVolumeSnapshotRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteVolumeSnapshot(\Google\Cloud\BaremetalSolution\V2\DeleteVolumeSnapshotRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/DeleteVolumeSnapshot',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Get details of a single storage volume snapshot.
     * @param \Google\Cloud\BaremetalSolution\V2\GetVolumeSnapshotRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetVolumeSnapshot(\Google\Cloud\BaremetalSolution\V2\GetVolumeSnapshotRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/GetVolumeSnapshot',
        $argument,
        ['\Google\Cloud\BaremetalSolution\V2\VolumeSnapshot', 'decode'],
        $metadata, $options);
    }

    /**
     * List storage volume snapshots for given storage volume.
     * @param \Google\Cloud\BaremetalSolution\V2\ListVolumeSnapshotsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListVolumeSnapshots(\Google\Cloud\BaremetalSolution\V2\ListVolumeSnapshotsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/ListVolumeSnapshots',
        $argument,
        ['\Google\Cloud\BaremetalSolution\V2\ListVolumeSnapshotsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get details of a single storage logical unit number(LUN).
     * @param \Google\Cloud\BaremetalSolution\V2\GetLunRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetLun(\Google\Cloud\BaremetalSolution\V2\GetLunRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/GetLun',
        $argument,
        ['\Google\Cloud\BaremetalSolution\V2\Lun', 'decode'],
        $metadata, $options);
    }

    /**
     * List storage volume luns for given storage volume.
     * @param \Google\Cloud\BaremetalSolution\V2\ListLunsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListLuns(\Google\Cloud\BaremetalSolution\V2\ListLunsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/ListLuns',
        $argument,
        ['\Google\Cloud\BaremetalSolution\V2\ListLunsResponse', 'decode'],
        $metadata, $options);
    }

}
