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
namespace Google\Cloud\Dataproc\V1;

/**
 * The `NodeGroupControllerService` provides methods to manage node groups
 * of Compute Engine managed instances.
 */
class NodeGroupControllerGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a node group in a cluster. The returned
     * [Operation.metadata][google.longrunning.Operation.metadata] is
     * [NodeGroupOperationMetadata](https://cloud.google.com/dataproc/docs/reference/rpc/google.cloud.dataproc.v1#nodegroupoperationmetadata).
     * @param \Google\Cloud\Dataproc\V1\CreateNodeGroupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateNodeGroup(\Google\Cloud\Dataproc\V1\CreateNodeGroupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1.NodeGroupController/CreateNodeGroup',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Resizes a node group in a cluster. The returned
     * [Operation.metadata][google.longrunning.Operation.metadata] is
     * [NodeGroupOperationMetadata](https://cloud.google.com/dataproc/docs/reference/rpc/google.cloud.dataproc.v1#nodegroupoperationmetadata).
     * @param \Google\Cloud\Dataproc\V1\ResizeNodeGroupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResizeNodeGroup(\Google\Cloud\Dataproc\V1\ResizeNodeGroupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1.NodeGroupController/ResizeNodeGroup',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the resource representation for a node group in a
     * cluster.
     * @param \Google\Cloud\Dataproc\V1\GetNodeGroupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetNodeGroup(\Google\Cloud\Dataproc\V1\GetNodeGroupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1.NodeGroupController/GetNodeGroup',
        $argument,
        ['\Google\Cloud\Dataproc\V1\NodeGroup', 'decode'],
        $metadata, $options);
    }

}
