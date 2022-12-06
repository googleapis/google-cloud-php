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
 * A service for creating and managing Vertex AI's Index resources.
 */
class IndexServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates an Index.
     * @param \Google\Cloud\AIPlatform\V1\CreateIndexRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateIndex(\Google\Cloud\AIPlatform\V1\CreateIndexRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.IndexService/CreateIndex',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an Index.
     * @param \Google\Cloud\AIPlatform\V1\GetIndexRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIndex(\Google\Cloud\AIPlatform\V1\GetIndexRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.IndexService/GetIndex',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\Index', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Indexes in a Location.
     * @param \Google\Cloud\AIPlatform\V1\ListIndexesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListIndexes(\Google\Cloud\AIPlatform\V1\ListIndexesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.IndexService/ListIndexes',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ListIndexesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an Index.
     * @param \Google\Cloud\AIPlatform\V1\UpdateIndexRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateIndex(\Google\Cloud\AIPlatform\V1\UpdateIndexRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.IndexService/UpdateIndex',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an Index.
     * An Index can only be deleted when all its
     * [DeployedIndexes][google.cloud.aiplatform.v1.Index.deployed_indexes] had been undeployed.
     * @param \Google\Cloud\AIPlatform\V1\DeleteIndexRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteIndex(\Google\Cloud\AIPlatform\V1\DeleteIndexRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.IndexService/DeleteIndex',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Add/update Datapoints into an Index.
     * @param \Google\Cloud\AIPlatform\V1\UpsertDatapointsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpsertDatapoints(\Google\Cloud\AIPlatform\V1\UpsertDatapointsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.IndexService/UpsertDatapoints',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\UpsertDatapointsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Remove Datapoints from an Index.
     * @param \Google\Cloud\AIPlatform\V1\RemoveDatapointsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RemoveDatapoints(\Google\Cloud\AIPlatform\V1\RemoveDatapointsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.IndexService/RemoveDatapoints',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\RemoveDatapointsResponse', 'decode'],
        $metadata, $options);
    }

}
