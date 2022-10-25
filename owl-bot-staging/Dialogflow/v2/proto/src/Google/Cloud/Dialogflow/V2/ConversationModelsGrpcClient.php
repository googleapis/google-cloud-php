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
namespace Google\Cloud\Dialogflow\V2;

/**
 * Manages a collection of models for human agent assistant.
 */
class ConversationModelsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a model.
     *
     * This method is a [long-running
     * operation](https://cloud.google.com/dialogflow/es/docs/how/long-running-operations).
     * The returned `Operation` type has the following method-specific fields:
     *
     * - `metadata`: [CreateConversationModelOperationMetadata][google.cloud.dialogflow.v2.CreateConversationModelOperationMetadata]
     * - `response`: [ConversationModel][google.cloud.dialogflow.v2.ConversationModel]
     * @param \Google\Cloud\Dialogflow\V2\CreateConversationModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateConversationModel(\Google\Cloud\Dialogflow\V2\CreateConversationModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.ConversationModels/CreateConversationModel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets conversation model.
     * @param \Google\Cloud\Dialogflow\V2\GetConversationModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetConversationModel(\Google\Cloud\Dialogflow\V2\GetConversationModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.ConversationModels/GetConversationModel',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\ConversationModel', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists conversation models.
     * @param \Google\Cloud\Dialogflow\V2\ListConversationModelsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListConversationModels(\Google\Cloud\Dialogflow\V2\ListConversationModelsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.ConversationModels/ListConversationModels',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\ListConversationModelsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a model.
     *
     * This method is a [long-running
     * operation](https://cloud.google.com/dialogflow/es/docs/how/long-running-operations).
     * The returned `Operation` type has the following method-specific fields:
     *
     * - `metadata`: [DeleteConversationModelOperationMetadata][google.cloud.dialogflow.v2.DeleteConversationModelOperationMetadata]
     * - `response`: An [Empty
     *   message](https://developers.google.com/protocol-buffers/docs/reference/google.protobuf#empty)
     * @param \Google\Cloud\Dialogflow\V2\DeleteConversationModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteConversationModel(\Google\Cloud\Dialogflow\V2\DeleteConversationModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.ConversationModels/DeleteConversationModel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deploys a model. If a model is already deployed, deploying it
     * has no effect. A model can only serve prediction requests after it gets
     * deployed. For article suggestion, custom model will not be used unless
     * it is deployed.
     *
     * This method is a [long-running
     * operation](https://cloud.google.com/dialogflow/es/docs/how/long-running-operations).
     * The returned `Operation` type has the following method-specific fields:
     *
     * - `metadata`: [DeployConversationModelOperationMetadata][google.cloud.dialogflow.v2.DeployConversationModelOperationMetadata]
     * - `response`: An [Empty
     *   message](https://developers.google.com/protocol-buffers/docs/reference/google.protobuf#empty)
     * @param \Google\Cloud\Dialogflow\V2\DeployConversationModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeployConversationModel(\Google\Cloud\Dialogflow\V2\DeployConversationModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.ConversationModels/DeployConversationModel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Undeploys a model. If the model is not deployed this method has no effect.
     * If the model is currently being used:
     *   - For article suggestion, article suggestion will fallback to the default
     *     model if model is undeployed.
     *
     * This method is a [long-running
     * operation](https://cloud.google.com/dialogflow/es/docs/how/long-running-operations).
     * The returned `Operation` type has the following method-specific fields:
     *
     * - `metadata`: [UndeployConversationModelOperationMetadata][google.cloud.dialogflow.v2.UndeployConversationModelOperationMetadata]
     * - `response`: An [Empty
     *   message](https://developers.google.com/protocol-buffers/docs/reference/google.protobuf#empty)
     * @param \Google\Cloud\Dialogflow\V2\UndeployConversationModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UndeployConversationModel(\Google\Cloud\Dialogflow\V2\UndeployConversationModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.ConversationModels/UndeployConversationModel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an evaluation of conversation model.
     * @param \Google\Cloud\Dialogflow\V2\GetConversationModelEvaluationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetConversationModelEvaluation(\Google\Cloud\Dialogflow\V2\GetConversationModelEvaluationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.ConversationModels/GetConversationModelEvaluation',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\ConversationModelEvaluation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists evaluations of a conversation model.
     * @param \Google\Cloud\Dialogflow\V2\ListConversationModelEvaluationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListConversationModelEvaluations(\Google\Cloud\Dialogflow\V2\ListConversationModelEvaluationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.ConversationModels/ListConversationModelEvaluations',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\ListConversationModelEvaluationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates evaluation of a conversation model.
     * @param \Google\Cloud\Dialogflow\V2\CreateConversationModelEvaluationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateConversationModelEvaluation(\Google\Cloud\Dialogflow\V2\CreateConversationModelEvaluationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.ConversationModels/CreateConversationModelEvaluation',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
