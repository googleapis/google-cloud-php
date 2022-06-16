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
namespace Google\Cloud\Dataplex\V1;

/**
 * Metadata service manages metadata resources such as tables, filesets and
 * partitions.
 */
class MetadataServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Create a metadata entity.
     * @param \Google\Cloud\Dataplex\V1\CreateEntityRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateEntity(\Google\Cloud\Dataplex\V1\CreateEntityRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.MetadataService/CreateEntity',
        $argument,
        ['\Google\Cloud\Dataplex\V1\Entity', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a metadata entity. Only supports full resource update.
     * @param \Google\Cloud\Dataplex\V1\UpdateEntityRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateEntity(\Google\Cloud\Dataplex\V1\UpdateEntityRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.MetadataService/UpdateEntity',
        $argument,
        ['\Google\Cloud\Dataplex\V1\Entity', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete a metadata entity.
     * @param \Google\Cloud\Dataplex\V1\DeleteEntityRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteEntity(\Google\Cloud\Dataplex\V1\DeleteEntityRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.MetadataService/DeleteEntity',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Get a metadata entity.
     * @param \Google\Cloud\Dataplex\V1\GetEntityRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetEntity(\Google\Cloud\Dataplex\V1\GetEntityRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.MetadataService/GetEntity',
        $argument,
        ['\Google\Cloud\Dataplex\V1\Entity', 'decode'],
        $metadata, $options);
    }

    /**
     * List metadata entities in a zone.
     * @param \Google\Cloud\Dataplex\V1\ListEntitiesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListEntities(\Google\Cloud\Dataplex\V1\ListEntitiesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.MetadataService/ListEntities',
        $argument,
        ['\Google\Cloud\Dataplex\V1\ListEntitiesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a metadata partition.
     * @param \Google\Cloud\Dataplex\V1\CreatePartitionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreatePartition(\Google\Cloud\Dataplex\V1\CreatePartitionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.MetadataService/CreatePartition',
        $argument,
        ['\Google\Cloud\Dataplex\V1\Partition', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete a metadata partition.
     * @param \Google\Cloud\Dataplex\V1\DeletePartitionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeletePartition(\Google\Cloud\Dataplex\V1\DeletePartitionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.MetadataService/DeletePartition',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Get a metadata partition of an entity.
     * @param \Google\Cloud\Dataplex\V1\GetPartitionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetPartition(\Google\Cloud\Dataplex\V1\GetPartitionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.MetadataService/GetPartition',
        $argument,
        ['\Google\Cloud\Dataplex\V1\Partition', 'decode'],
        $metadata, $options);
    }

    /**
     * List metadata partitions of an entity.
     * @param \Google\Cloud\Dataplex\V1\ListPartitionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListPartitions(\Google\Cloud\Dataplex\V1\ListPartitionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.MetadataService/ListPartitions',
        $argument,
        ['\Google\Cloud\Dataplex\V1\ListPartitionsResponse', 'decode'],
        $metadata, $options);
    }

}
