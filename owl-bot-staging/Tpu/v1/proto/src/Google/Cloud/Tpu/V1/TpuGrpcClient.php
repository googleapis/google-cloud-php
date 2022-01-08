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
namespace Google\Cloud\Tpu\V1;

/**
 * Manages TPU nodes and other resources
 *
 * TPU API v1
 */
class TpuGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists nodes.
     * @param \Google\Cloud\Tpu\V1\ListNodesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListNodes(\Google\Cloud\Tpu\V1\ListNodesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tpu.v1.Tpu/ListNodes',
        $argument,
        ['\Google\Cloud\Tpu\V1\ListNodesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the details of a node.
     * @param \Google\Cloud\Tpu\V1\GetNodeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetNode(\Google\Cloud\Tpu\V1\GetNodeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tpu.v1.Tpu/GetNode',
        $argument,
        ['\Google\Cloud\Tpu\V1\Node', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a node.
     * @param \Google\Cloud\Tpu\V1\CreateNodeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateNode(\Google\Cloud\Tpu\V1\CreateNodeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tpu.v1.Tpu/CreateNode',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a node.
     * @param \Google\Cloud\Tpu\V1\DeleteNodeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteNode(\Google\Cloud\Tpu\V1\DeleteNodeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tpu.v1.Tpu/DeleteNode',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Reimages a node's OS.
     * @param \Google\Cloud\Tpu\V1\ReimageNodeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ReimageNode(\Google\Cloud\Tpu\V1\ReimageNodeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tpu.v1.Tpu/ReimageNode',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Stops a node.
     * @param \Google\Cloud\Tpu\V1\StopNodeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StopNode(\Google\Cloud\Tpu\V1\StopNodeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tpu.v1.Tpu/StopNode',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Starts a node.
     * @param \Google\Cloud\Tpu\V1\StartNodeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StartNode(\Google\Cloud\Tpu\V1\StartNodeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tpu.v1.Tpu/StartNode',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * List TensorFlow versions supported by this API.
     * @param \Google\Cloud\Tpu\V1\ListTensorFlowVersionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTensorFlowVersions(\Google\Cloud\Tpu\V1\ListTensorFlowVersionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tpu.v1.Tpu/ListTensorFlowVersions',
        $argument,
        ['\Google\Cloud\Tpu\V1\ListTensorFlowVersionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets TensorFlow Version.
     * @param \Google\Cloud\Tpu\V1\GetTensorFlowVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTensorFlowVersion(\Google\Cloud\Tpu\V1\GetTensorFlowVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tpu.v1.Tpu/GetTensorFlowVersion',
        $argument,
        ['\Google\Cloud\Tpu\V1\TensorFlowVersion', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists accelerator types supported by this API.
     * @param \Google\Cloud\Tpu\V1\ListAcceleratorTypesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAcceleratorTypes(\Google\Cloud\Tpu\V1\ListAcceleratorTypesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tpu.v1.Tpu/ListAcceleratorTypes',
        $argument,
        ['\Google\Cloud\Tpu\V1\ListAcceleratorTypesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets AcceleratorType.
     * @param \Google\Cloud\Tpu\V1\GetAcceleratorTypeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAcceleratorType(\Google\Cloud\Tpu\V1\GetAcceleratorTypeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.tpu.v1.Tpu/GetAcceleratorType',
        $argument,
        ['\Google\Cloud\Tpu\V1\AcceleratorType', 'decode'],
        $metadata, $options);
    }

}
