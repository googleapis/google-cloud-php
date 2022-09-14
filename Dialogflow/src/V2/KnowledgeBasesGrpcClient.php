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
 * Service for managing [KnowledgeBases][google.cloud.dialogflow.v2.KnowledgeBase].
 */
class KnowledgeBasesGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Returns the list of all knowledge bases of the specified agent.
     * @param \Google\Cloud\Dialogflow\V2\ListKnowledgeBasesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListKnowledgeBases(\Google\Cloud\Dialogflow\V2\ListKnowledgeBasesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.KnowledgeBases/ListKnowledgeBases',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\ListKnowledgeBasesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves the specified knowledge base.
     * @param \Google\Cloud\Dialogflow\V2\GetKnowledgeBaseRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetKnowledgeBase(\Google\Cloud\Dialogflow\V2\GetKnowledgeBaseRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.KnowledgeBases/GetKnowledgeBase',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\KnowledgeBase', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a knowledge base.
     * @param \Google\Cloud\Dialogflow\V2\CreateKnowledgeBaseRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateKnowledgeBase(\Google\Cloud\Dialogflow\V2\CreateKnowledgeBaseRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.KnowledgeBases/CreateKnowledgeBase',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\KnowledgeBase', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified knowledge base.
     * @param \Google\Cloud\Dialogflow\V2\DeleteKnowledgeBaseRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteKnowledgeBase(\Google\Cloud\Dialogflow\V2\DeleteKnowledgeBaseRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.KnowledgeBases/DeleteKnowledgeBase',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified knowledge base.
     * @param \Google\Cloud\Dialogflow\V2\UpdateKnowledgeBaseRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateKnowledgeBase(\Google\Cloud\Dialogflow\V2\UpdateKnowledgeBaseRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.KnowledgeBases/UpdateKnowledgeBase',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\KnowledgeBase', 'decode'],
        $metadata, $options);
    }

}
