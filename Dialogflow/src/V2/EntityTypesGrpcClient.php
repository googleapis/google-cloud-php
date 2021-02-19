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
namespace Google\Cloud\Dialogflow\V2;

/**
 * Service for managing [EntityTypes][google.cloud.dialogflow.v2.EntityType].
 */
class EntityTypesGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Returns the list of all entity types in the specified agent.
     * @param \Google\Cloud\Dialogflow\V2\ListEntityTypesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListEntityTypes(\Google\Cloud\Dialogflow\V2\ListEntityTypesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.EntityTypes/ListEntityTypes',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\ListEntityTypesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves the specified entity type.
     * @param \Google\Cloud\Dialogflow\V2\GetEntityTypeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetEntityType(\Google\Cloud\Dialogflow\V2\GetEntityTypeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.EntityTypes/GetEntityType',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\EntityType', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an entity type in the specified agent.
     * @param \Google\Cloud\Dialogflow\V2\CreateEntityTypeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateEntityType(\Google\Cloud\Dialogflow\V2\CreateEntityTypeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.EntityTypes/CreateEntityType',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\EntityType', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified entity type.
     * @param \Google\Cloud\Dialogflow\V2\UpdateEntityTypeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateEntityType(\Google\Cloud\Dialogflow\V2\UpdateEntityTypeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.EntityTypes/UpdateEntityType',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\EntityType', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified entity type.
     * @param \Google\Cloud\Dialogflow\V2\DeleteEntityTypeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteEntityType(\Google\Cloud\Dialogflow\V2\DeleteEntityTypeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.EntityTypes/DeleteEntityType',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates/Creates multiple entity types in the specified agent.
     *
     * Operation <response: [BatchUpdateEntityTypesResponse][google.cloud.dialogflow.v2.BatchUpdateEntityTypesResponse]>
     * @param \Google\Cloud\Dialogflow\V2\BatchUpdateEntityTypesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchUpdateEntityTypes(\Google\Cloud\Dialogflow\V2\BatchUpdateEntityTypesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.EntityTypes/BatchUpdateEntityTypes',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes entity types in the specified agent.
     *
     * Operation <response: [google.protobuf.Empty][google.protobuf.Empty]>
     * @param \Google\Cloud\Dialogflow\V2\BatchDeleteEntityTypesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchDeleteEntityTypes(\Google\Cloud\Dialogflow\V2\BatchDeleteEntityTypesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.EntityTypes/BatchDeleteEntityTypes',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates multiple new entities in the specified entity type.
     *
     * Operation <response: [google.protobuf.Empty][google.protobuf.Empty]>
     * @param \Google\Cloud\Dialogflow\V2\BatchCreateEntitiesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchCreateEntities(\Google\Cloud\Dialogflow\V2\BatchCreateEntitiesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.EntityTypes/BatchCreateEntities',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates or creates multiple entities in the specified entity type. This
     * method does not affect entities in the entity type that aren't explicitly
     * specified in the request.
     *
     *
     * Operation <response: [google.protobuf.Empty][google.protobuf.Empty]>
     * @param \Google\Cloud\Dialogflow\V2\BatchUpdateEntitiesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchUpdateEntities(\Google\Cloud\Dialogflow\V2\BatchUpdateEntitiesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.EntityTypes/BatchUpdateEntities',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes entities in the specified entity type.
     *
     *
     * Operation <response: [google.protobuf.Empty][google.protobuf.Empty]>
     * @param \Google\Cloud\Dialogflow\V2\BatchDeleteEntitiesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchDeleteEntities(\Google\Cloud\Dialogflow\V2\BatchDeleteEntitiesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.EntityTypes/BatchDeleteEntities',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
