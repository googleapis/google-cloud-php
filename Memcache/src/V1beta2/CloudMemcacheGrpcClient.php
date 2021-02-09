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
namespace Google\Cloud\Memcache\V1beta2;

/**
 * Configures and manages Cloud Memorystore for Memcached instances.
 *
 *
 * The `memcache.googleapis.com` service implements the Google Cloud Memorystore
 * for Memcached API and defines the following resource model for managing
 * Memorystore Memcached (also called Memcached below) instances:
 * * The service works with a collection of cloud projects, named: `/projects/*`
 * * Each project has a collection of available locations, named: `/locations/*`
 * * Each location has a collection of Memcached instances, named:
 * `/instances/*`
 * * As such, Memcached instances are resources of the form:
 *   `/projects/{project_id}/locations/{location_id}/instances/{instance_id}`
 *
 * Note that location_id must be a GCP `region`; for example:
 * * `projects/my-memcached-project/locations/us-central1/instances/my-memcached`
 */
class CloudMemcacheGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists Instances in a given location.
     * @param \Google\Cloud\Memcache\V1beta2\ListInstancesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListInstances(\Google\Cloud\Memcache\V1beta2\ListInstancesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.memcache.v1beta2.CloudMemcache/ListInstances',
        $argument,
        ['\Google\Cloud\Memcache\V1beta2\ListInstancesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single Instance.
     * @param \Google\Cloud\Memcache\V1beta2\GetInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetInstance(\Google\Cloud\Memcache\V1beta2\GetInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.memcache.v1beta2.CloudMemcache/GetInstance',
        $argument,
        ['\Google\Cloud\Memcache\V1beta2\Instance', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Instance in a given location.
     * @param \Google\Cloud\Memcache\V1beta2\CreateInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateInstance(\Google\Cloud\Memcache\V1beta2\CreateInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.memcache.v1beta2.CloudMemcache/CreateInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an existing Instance in a given project and location.
     * @param \Google\Cloud\Memcache\V1beta2\UpdateInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateInstance(\Google\Cloud\Memcache\V1beta2\UpdateInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.memcache.v1beta2.CloudMemcache/UpdateInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the defined Memcached parameters for an existing instance.
     * This method only stages the parameters, it must be followed by
     * `ApplyParameters` to apply the parameters to nodes of the Memcached
     * instance.
     * @param \Google\Cloud\Memcache\V1beta2\UpdateParametersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateParameters(\Google\Cloud\Memcache\V1beta2\UpdateParametersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.memcache.v1beta2.CloudMemcache/UpdateParameters',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single Instance.
     * @param \Google\Cloud\Memcache\V1beta2\DeleteInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteInstance(\Google\Cloud\Memcache\V1beta2\DeleteInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.memcache.v1beta2.CloudMemcache/DeleteInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * `ApplyParameters` restarts the set of specified nodes in order to update
     * them to the current set of parameters for the Memcached Instance.
     * @param \Google\Cloud\Memcache\V1beta2\ApplyParametersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ApplyParameters(\Google\Cloud\Memcache\V1beta2\ApplyParametersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.memcache.v1beta2.CloudMemcache/ApplyParameters',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates software on the selected nodes of the Instance.
     * @param \Google\Cloud\Memcache\V1beta2\ApplySoftwareUpdateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ApplySoftwareUpdate(\Google\Cloud\Memcache\V1beta2\ApplySoftwareUpdateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.memcache.v1beta2.CloudMemcache/ApplySoftwareUpdate',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
