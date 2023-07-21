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
namespace Google\Cloud\AIPlatform\V1;

/**
 * A service for managing Vertex AI's IndexEndpoints.
 */
class IndexEndpointServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates an IndexEndpoint.
     * @param \Google\Cloud\AIPlatform\V1\CreateIndexEndpointRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateIndexEndpoint(\Google\Cloud\AIPlatform\V1\CreateIndexEndpointRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.IndexEndpointService/CreateIndexEndpoint',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an IndexEndpoint.
     * @param \Google\Cloud\AIPlatform\V1\GetIndexEndpointRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIndexEndpoint(\Google\Cloud\AIPlatform\V1\GetIndexEndpointRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.IndexEndpointService/GetIndexEndpoint',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\IndexEndpoint', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists IndexEndpoints in a Location.
     * @param \Google\Cloud\AIPlatform\V1\ListIndexEndpointsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListIndexEndpoints(\Google\Cloud\AIPlatform\V1\ListIndexEndpointsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.IndexEndpointService/ListIndexEndpoints',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ListIndexEndpointsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an IndexEndpoint.
     * @param \Google\Cloud\AIPlatform\V1\UpdateIndexEndpointRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateIndexEndpoint(\Google\Cloud\AIPlatform\V1\UpdateIndexEndpointRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.IndexEndpointService/UpdateIndexEndpoint',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\IndexEndpoint', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an IndexEndpoint.
     * @param \Google\Cloud\AIPlatform\V1\DeleteIndexEndpointRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteIndexEndpoint(\Google\Cloud\AIPlatform\V1\DeleteIndexEndpointRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.IndexEndpointService/DeleteIndexEndpoint',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deploys an Index into this IndexEndpoint, creating a DeployedIndex within
     * it.
     * Only non-empty Indexes can be deployed.
     * @param \Google\Cloud\AIPlatform\V1\DeployIndexRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeployIndex(\Google\Cloud\AIPlatform\V1\DeployIndexRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.IndexEndpointService/DeployIndex',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Undeploys an Index from an IndexEndpoint, removing a DeployedIndex from it,
     * and freeing all resources it's using.
     * @param \Google\Cloud\AIPlatform\V1\UndeployIndexRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UndeployIndex(\Google\Cloud\AIPlatform\V1\UndeployIndexRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.IndexEndpointService/UndeployIndex',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Update an existing DeployedIndex under an IndexEndpoint.
     * @param \Google\Cloud\AIPlatform\V1\MutateDeployedIndexRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function MutateDeployedIndex(\Google\Cloud\AIPlatform\V1\MutateDeployedIndexRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.IndexEndpointService/MutateDeployedIndex',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
