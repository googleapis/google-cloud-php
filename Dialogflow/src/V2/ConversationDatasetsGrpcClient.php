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
 * Conversation datasets.
 *
 * Conversation datasets contain raw conversation files and their
 * customizable metadata that can be used for model training.
 */
class ConversationDatasetsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new conversation dataset.
     *
     * This method is a [long-running
     * operation](https://cloud.google.com/dialogflow/es/docs/how/long-running-operations).
     * The returned `Operation` type has the following method-specific fields:
     *
     * - `metadata`: [CreateConversationDatasetOperationMetadata][google.cloud.dialogflow.v2.CreateConversationDatasetOperationMetadata]
     * - `response`: [ConversationDataset][google.cloud.dialogflow.v2.ConversationDataset]
     * @param \Google\Cloud\Dialogflow\V2\CreateConversationDatasetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateConversationDataset(\Google\Cloud\Dialogflow\V2\CreateConversationDatasetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.ConversationDatasets/CreateConversationDataset',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves the specified conversation dataset.
     * @param \Google\Cloud\Dialogflow\V2\GetConversationDatasetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetConversationDataset(\Google\Cloud\Dialogflow\V2\GetConversationDatasetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.ConversationDatasets/GetConversationDataset',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\ConversationDataset', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the list of all conversation datasets in the specified
     * project and location.
     * @param \Google\Cloud\Dialogflow\V2\ListConversationDatasetsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListConversationDatasets(\Google\Cloud\Dialogflow\V2\ListConversationDatasetsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.ConversationDatasets/ListConversationDatasets',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\ListConversationDatasetsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified conversation dataset.
     *
     * This method is a [long-running
     * operation](https://cloud.google.com/dialogflow/es/docs/how/long-running-operations).
     * The returned `Operation` type has the following method-specific fields:
     *
     * - `metadata`: [DeleteConversationDatasetOperationMetadata][google.cloud.dialogflow.v2.DeleteConversationDatasetOperationMetadata]
     * - `response`: An [Empty
     *   message](https://developers.google.com/protocol-buffers/docs/reference/google.protobuf#empty)
     * @param \Google\Cloud\Dialogflow\V2\DeleteConversationDatasetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteConversationDataset(\Google\Cloud\Dialogflow\V2\DeleteConversationDatasetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.ConversationDatasets/DeleteConversationDataset',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Import data into the specified conversation dataset. Note that it
     * is not allowed to import data to a conversation dataset that
     * already has data in it.
     *
     * This method is a [long-running
     * operation](https://cloud.google.com/dialogflow/es/docs/how/long-running-operations).
     * The returned `Operation` type has the following method-specific fields:
     *
     * - `metadata`: [ImportConversationDataOperationMetadata][google.cloud.dialogflow.v2.ImportConversationDataOperationMetadata]
     * - `response`: [ImportConversationDataOperationResponse][google.cloud.dialogflow.v2.ImportConversationDataOperationResponse]
     * @param \Google\Cloud\Dialogflow\V2\ImportConversationDataRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ImportConversationData(\Google\Cloud\Dialogflow\V2\ImportConversationDataRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.ConversationDatasets/ImportConversationData',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
