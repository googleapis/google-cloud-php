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
 * A service for managing Vertex AI's Endpoints.
 */
class EndpointServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates an Endpoint.
     * @param \Google\Cloud\AIPlatform\V1\CreateEndpointRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateEndpoint(\Google\Cloud\AIPlatform\V1\CreateEndpointRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.EndpointService/CreateEndpoint',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an Endpoint.
     * @param \Google\Cloud\AIPlatform\V1\GetEndpointRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetEndpoint(\Google\Cloud\AIPlatform\V1\GetEndpointRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.EndpointService/GetEndpoint',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\Endpoint', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Endpoints in a Location.
     * @param \Google\Cloud\AIPlatform\V1\ListEndpointsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListEndpoints(\Google\Cloud\AIPlatform\V1\ListEndpointsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.EndpointService/ListEndpoints',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ListEndpointsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an Endpoint.
     * @param \Google\Cloud\AIPlatform\V1\UpdateEndpointRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateEndpoint(\Google\Cloud\AIPlatform\V1\UpdateEndpointRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.EndpointService/UpdateEndpoint',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\Endpoint', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an Endpoint.
     * @param \Google\Cloud\AIPlatform\V1\DeleteEndpointRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteEndpoint(\Google\Cloud\AIPlatform\V1\DeleteEndpointRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.EndpointService/DeleteEndpoint',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deploys a Model into this Endpoint, creating a DeployedModel within it.
     * @param \Google\Cloud\AIPlatform\V1\DeployModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeployModel(\Google\Cloud\AIPlatform\V1\DeployModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.EndpointService/DeployModel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Undeploys a Model from an Endpoint, removing a DeployedModel from it, and
     * freeing all resources it's using.
     * @param \Google\Cloud\AIPlatform\V1\UndeployModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UndeployModel(\Google\Cloud\AIPlatform\V1\UndeployModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.EndpointService/UndeployModel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
