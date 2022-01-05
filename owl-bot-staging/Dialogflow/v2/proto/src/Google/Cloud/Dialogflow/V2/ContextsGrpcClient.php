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
 * Service for managing [Contexts][google.cloud.dialogflow.v2.Context].
 */
class ContextsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Returns the list of all contexts in the specified session.
     * @param \Google\Cloud\Dialogflow\V2\ListContextsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListContexts(\Google\Cloud\Dialogflow\V2\ListContextsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Contexts/ListContexts',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\ListContextsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves the specified context.
     * @param \Google\Cloud\Dialogflow\V2\GetContextRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetContext(\Google\Cloud\Dialogflow\V2\GetContextRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Contexts/GetContext',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Context', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a context.
     *
     * If the specified context already exists, overrides the context.
     * @param \Google\Cloud\Dialogflow\V2\CreateContextRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateContext(\Google\Cloud\Dialogflow\V2\CreateContextRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Contexts/CreateContext',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Context', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified context.
     * @param \Google\Cloud\Dialogflow\V2\UpdateContextRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateContext(\Google\Cloud\Dialogflow\V2\UpdateContextRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Contexts/UpdateContext',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Context', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified context.
     * @param \Google\Cloud\Dialogflow\V2\DeleteContextRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteContext(\Google\Cloud\Dialogflow\V2\DeleteContextRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Contexts/DeleteContext',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes all active contexts in the specified session.
     * @param \Google\Cloud\Dialogflow\V2\DeleteAllContextsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAllContexts(\Google\Cloud\Dialogflow\V2\DeleteAllContextsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Contexts/DeleteAllContexts',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
