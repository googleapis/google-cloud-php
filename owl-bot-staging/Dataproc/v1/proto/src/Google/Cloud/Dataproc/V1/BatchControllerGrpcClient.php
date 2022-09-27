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
namespace Google\Cloud\Dataproc\V1;

/**
 * The BatchController provides methods to manage batch workloads.
 */
class BatchControllerGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a batch workload that executes asynchronously.
     * @param \Google\Cloud\Dataproc\V1\CreateBatchRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateBatch(\Google\Cloud\Dataproc\V1\CreateBatchRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1.BatchController/CreateBatch',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the batch workload resource representation.
     * @param \Google\Cloud\Dataproc\V1\GetBatchRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetBatch(\Google\Cloud\Dataproc\V1\GetBatchRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1.BatchController/GetBatch',
        $argument,
        ['\Google\Cloud\Dataproc\V1\Batch', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists batch workloads.
     * @param \Google\Cloud\Dataproc\V1\ListBatchesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListBatches(\Google\Cloud\Dataproc\V1\ListBatchesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1.BatchController/ListBatches',
        $argument,
        ['\Google\Cloud\Dataproc\V1\ListBatchesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the batch workload resource. If the batch is not in terminal state,
     * the delete fails and the response returns `FAILED_PRECONDITION`.
     * @param \Google\Cloud\Dataproc\V1\DeleteBatchRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteBatch(\Google\Cloud\Dataproc\V1\DeleteBatchRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1.BatchController/DeleteBatch',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
