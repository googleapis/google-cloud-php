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
namespace Google\Cloud\Ids\V1;

/**
 * The IDS Service
 */
class IDSGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists Endpoints in a given project and location.
     * @param \Google\Cloud\Ids\V1\ListEndpointsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListEndpoints(\Google\Cloud\Ids\V1\ListEndpointsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.ids.v1.IDS/ListEndpoints',
        $argument,
        ['\Google\Cloud\Ids\V1\ListEndpointsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single Endpoint.
     * @param \Google\Cloud\Ids\V1\GetEndpointRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetEndpoint(\Google\Cloud\Ids\V1\GetEndpointRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.ids.v1.IDS/GetEndpoint',
        $argument,
        ['\Google\Cloud\Ids\V1\Endpoint', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Endpoint in a given project and location.
     * @param \Google\Cloud\Ids\V1\CreateEndpointRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateEndpoint(\Google\Cloud\Ids\V1\CreateEndpointRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.ids.v1.IDS/CreateEndpoint',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single Endpoint.
     * @param \Google\Cloud\Ids\V1\DeleteEndpointRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteEndpoint(\Google\Cloud\Ids\V1\DeleteEndpointRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.ids.v1.IDS/DeleteEndpoint',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
