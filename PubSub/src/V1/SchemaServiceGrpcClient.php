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
namespace Google\Cloud\PubSub\V1;

/**
 * Service for doing schema-related operations.
 */
class SchemaServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a schema.
     * @param \Google\Cloud\PubSub\V1\CreateSchemaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateSchema(\Google\Cloud\PubSub\V1\CreateSchemaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.SchemaService/CreateSchema',
        $argument,
        ['\Google\Cloud\PubSub\V1\Schema', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a schema.
     * @param \Google\Cloud\PubSub\V1\GetSchemaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSchema(\Google\Cloud\PubSub\V1\GetSchemaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.SchemaService/GetSchema',
        $argument,
        ['\Google\Cloud\PubSub\V1\Schema', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists schemas in a project.
     * @param \Google\Cloud\PubSub\V1\ListSchemasRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListSchemas(\Google\Cloud\PubSub\V1\ListSchemasRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.SchemaService/ListSchemas',
        $argument,
        ['\Google\Cloud\PubSub\V1\ListSchemasResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a schema.
     * @param \Google\Cloud\PubSub\V1\DeleteSchemaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteSchema(\Google\Cloud\PubSub\V1\DeleteSchemaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.SchemaService/DeleteSchema',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Validates a schema.
     * @param \Google\Cloud\PubSub\V1\ValidateSchemaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ValidateSchema(\Google\Cloud\PubSub\V1\ValidateSchemaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.SchemaService/ValidateSchema',
        $argument,
        ['\Google\Cloud\PubSub\V1\ValidateSchemaResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Validates a message against a schema.
     * @param \Google\Cloud\PubSub\V1\ValidateMessageRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ValidateMessage(\Google\Cloud\PubSub\V1\ValidateMessageRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.pubsub.v1.SchemaService/ValidateMessage',
        $argument,
        ['\Google\Cloud\PubSub\V1\ValidateMessageResponse', 'decode'],
        $metadata, $options);
    }

}
