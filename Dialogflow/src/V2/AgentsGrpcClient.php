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
 * Service for managing [Agents][google.cloud.dialogflow.v2.Agent].
 */
class AgentsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Retrieves the specified agent.
     * @param \Google\Cloud\Dialogflow\V2\GetAgentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAgent(\Google\Cloud\Dialogflow\V2\GetAgentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Agents/GetAgent',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Agent', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates/updates the specified agent.
     * @param \Google\Cloud\Dialogflow\V2\SetAgentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetAgent(\Google\Cloud\Dialogflow\V2\SetAgentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Agents/SetAgent',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Agent', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified agent.
     * @param \Google\Cloud\Dialogflow\V2\DeleteAgentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAgent(\Google\Cloud\Dialogflow\V2\DeleteAgentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Agents/DeleteAgent',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the list of agents.
     *
     * Since there is at most one conversational agent per project, this method is
     * useful primarily for listing all agents across projects the caller has
     * access to. One can achieve that with a wildcard project collection id "-".
     * Refer to [List
     * Sub-Collections](https://cloud.google.com/apis/design/design_patterns#list_sub-collections).
     * @param \Google\Cloud\Dialogflow\V2\SearchAgentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchAgents(\Google\Cloud\Dialogflow\V2\SearchAgentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Agents/SearchAgents',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\SearchAgentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Trains the specified agent.
     *
     * Operation <response: [google.protobuf.Empty][google.protobuf.Empty]>
     * @param \Google\Cloud\Dialogflow\V2\TrainAgentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TrainAgent(\Google\Cloud\Dialogflow\V2\TrainAgentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Agents/TrainAgent',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Exports the specified agent to a ZIP file.
     *
     * Operation <response: [ExportAgentResponse][google.cloud.dialogflow.v2.ExportAgentResponse]>
     * @param \Google\Cloud\Dialogflow\V2\ExportAgentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ExportAgent(\Google\Cloud\Dialogflow\V2\ExportAgentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Agents/ExportAgent',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Imports the specified agent from a ZIP file.
     *
     * Uploads new intents and entity types without deleting the existing ones.
     * Intents and entity types with the same name are replaced with the new
     * versions from [ImportAgentRequest][google.cloud.dialogflow.v2.ImportAgentRequest]. After the import, the imported draft
     * agent will be trained automatically (unless disabled in agent settings).
     * However, once the import is done, training may not be completed yet. Please
     * call [TrainAgent][google.cloud.dialogflow.v2.Agents.TrainAgent] and wait for the operation it returns in order to train
     * explicitly.
     *
     * Operation <response: [google.protobuf.Empty][google.protobuf.Empty]>
     * An operation which tracks when importing is complete. It only tracks
     * when the draft agent is updated not when it is done training.
     * @param \Google\Cloud\Dialogflow\V2\ImportAgentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ImportAgent(\Google\Cloud\Dialogflow\V2\ImportAgentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Agents/ImportAgent',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Restores the specified agent from a ZIP file.
     *
     * Replaces the current agent version with a new one. All the intents and
     * entity types in the older version are deleted. After the restore, the
     * restored draft agent will be trained automatically (unless disabled in
     * agent settings). However, once the restore is done, training may not be
     * completed yet. Please call [TrainAgent][google.cloud.dialogflow.v2.Agents.TrainAgent] and wait for the operation it
     * returns in order to train explicitly.
     *
     * Operation <response: [google.protobuf.Empty][google.protobuf.Empty]>
     * An operation which tracks when restoring is complete. It only tracks
     * when the draft agent is updated not when it is done training.
     * @param \Google\Cloud\Dialogflow\V2\RestoreAgentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RestoreAgent(\Google\Cloud\Dialogflow\V2\RestoreAgentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Agents/RestoreAgent',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets agent validation result. Agent validation is performed during
     * training time and is updated automatically when training is completed.
     * @param \Google\Cloud\Dialogflow\V2\GetValidationResultRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetValidationResult(\Google\Cloud\Dialogflow\V2\GetValidationResultRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Agents/GetValidationResult',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\ValidationResult', 'decode'],
        $metadata, $options);
    }

}
