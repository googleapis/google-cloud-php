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
namespace Google\Cloud\BareMetalSolution\V2;

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
     * @param \Google\Cloud\BareMetalSolution\V2\ListInstancesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListInstances(\Google\Cloud\BareMetalSolution\V2\ListInstancesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/ListInstances',
        $argument,
        ['\Google\Cloud\BareMetalSolution\V2\ListInstancesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get details about a single server.
     * @param \Google\Cloud\BareMetalSolution\V2\GetInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetInstance(\Google\Cloud\BareMetalSolution\V2\GetInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/GetInstance',
        $argument,
        ['\Google\Cloud\BareMetalSolution\V2\Instance', 'decode'],
        $metadata, $options);
    }

    /**
     * Update details of a single server.
     * @param \Google\Cloud\BareMetalSolution\V2\UpdateInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateInstance(\Google\Cloud\BareMetalSolution\V2\UpdateInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/UpdateInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Perform an ungraceful, hard reset on a server. Equivalent to shutting the
     * power off and then turning it back on.
     * @param \Google\Cloud\BareMetalSolution\V2\ResetInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResetInstance(\Google\Cloud\BareMetalSolution\V2\ResetInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/ResetInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Starts a server that was shutdown.
     * @param \Google\Cloud\BareMetalSolution\V2\StartInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StartInstance(\Google\Cloud\BareMetalSolution\V2\StartInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/StartInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Stop a running server.
     * @param \Google\Cloud\BareMetalSolution\V2\StopInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StopInstance(\Google\Cloud\BareMetalSolution\V2\StopInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/StopInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Detach LUN from Instance.
     * @param \Google\Cloud\BareMetalSolution\V2\DetachLunRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DetachLun(\Google\Cloud\BareMetalSolution\V2\DetachLunRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/DetachLun',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * List storage volumes in a given project and location.
     * @param \Google\Cloud\BareMetalSolution\V2\ListVolumesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListVolumes(\Google\Cloud\BareMetalSolution\V2\ListVolumesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/ListVolumes',
        $argument,
        ['\Google\Cloud\BareMetalSolution\V2\ListVolumesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get details of a single storage volume.
     * @param \Google\Cloud\BareMetalSolution\V2\GetVolumeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetVolume(\Google\Cloud\BareMetalSolution\V2\GetVolumeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/GetVolume',
        $argument,
        ['\Google\Cloud\BareMetalSolution\V2\Volume', 'decode'],
        $metadata, $options);
    }

    /**
     * Update details of a single storage volume.
     * @param \Google\Cloud\BareMetalSolution\V2\UpdateVolumeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateVolume(\Google\Cloud\BareMetalSolution\V2\UpdateVolumeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/UpdateVolume',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Emergency Volume resize.
     * @param \Google\Cloud\BareMetalSolution\V2\ResizeVolumeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResizeVolume(\Google\Cloud\BareMetalSolution\V2\ResizeVolumeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/ResizeVolume',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * List network in a given project and location.
     * @param \Google\Cloud\BareMetalSolution\V2\ListNetworksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListNetworks(\Google\Cloud\BareMetalSolution\V2\ListNetworksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/ListNetworks',
        $argument,
        ['\Google\Cloud\BareMetalSolution\V2\ListNetworksResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * List all Networks (and used IPs for each Network) in the vendor account
     * associated with the specified project.
     * @param \Google\Cloud\BareMetalSolution\V2\ListNetworkUsageRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListNetworkUsage(\Google\Cloud\BareMetalSolution\V2\ListNetworkUsageRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/ListNetworkUsage',
        $argument,
        ['\Google\Cloud\BareMetalSolution\V2\ListNetworkUsageResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get details of a single network.
     * @param \Google\Cloud\BareMetalSolution\V2\GetNetworkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetNetwork(\Google\Cloud\BareMetalSolution\V2\GetNetworkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/GetNetwork',
        $argument,
        ['\Google\Cloud\BareMetalSolution\V2\Network', 'decode'],
        $metadata, $options);
    }

    /**
     * Update details of a single network.
     * @param \Google\Cloud\BareMetalSolution\V2\UpdateNetworkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateNetwork(\Google\Cloud\BareMetalSolution\V2\UpdateNetworkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/UpdateNetwork',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Get details of a single storage logical unit number(LUN).
     * @param \Google\Cloud\BareMetalSolution\V2\GetLunRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetLun(\Google\Cloud\BareMetalSolution\V2\GetLunRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/GetLun',
        $argument,
        ['\Google\Cloud\BareMetalSolution\V2\Lun', 'decode'],
        $metadata, $options);
    }

    /**
     * List storage volume luns for given storage volume.
     * @param \Google\Cloud\BareMetalSolution\V2\ListLunsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListLuns(\Google\Cloud\BareMetalSolution\V2\ListLunsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/ListLuns',
        $argument,
        ['\Google\Cloud\BareMetalSolution\V2\ListLunsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get details of a single NFS share.
     * @param \Google\Cloud\BareMetalSolution\V2\GetNfsShareRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetNfsShare(\Google\Cloud\BareMetalSolution\V2\GetNfsShareRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/GetNfsShare',
        $argument,
        ['\Google\Cloud\BareMetalSolution\V2\NfsShare', 'decode'],
        $metadata, $options);
    }

    /**
     * List NFS shares.
     * @param \Google\Cloud\BareMetalSolution\V2\ListNfsSharesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListNfsShares(\Google\Cloud\BareMetalSolution\V2\ListNfsSharesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/ListNfsShares',
        $argument,
        ['\Google\Cloud\BareMetalSolution\V2\ListNfsSharesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Update details of a single NFS share.
     * @param \Google\Cloud\BareMetalSolution\V2\UpdateNfsShareRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateNfsShare(\Google\Cloud\BareMetalSolution\V2\UpdateNfsShareRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.baremetalsolution.v2.BareMetalSolution/UpdateNfsShare',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
