<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2018 Google Inc.
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
 * Agents are best described as Natural Language Understanding (NLU) modules
 * that transform user requests into actionable data. You can include agents
 * in your app, product, or service to determine user intent and respond to the
 * user in a natural way.
 *
 * After you create an agent, you can add [Intents][google.cloud.dialogflow.v2.Intents], [Contexts][google.cloud.dialogflow.v2.Contexts],
 * [Entity Types][google.cloud.dialogflow.v2.EntityTypes], [Webhooks][google.cloud.dialogflow.v2.WebhookRequest], and so on to
 * manage the flow of a conversation and match user input to predefined intents
 * and actions.
 *
 * You can create an agent using both Dialogflow Standard Edition and
 * Dialogflow Enterprise Edition. For details, see
 * [Dialogflow Editions](/dialogflow-enterprise/docs/editions).
 *
 * You can save your agent for backup or versioning by exporting the agent by
 * using the [ExportAgent][google.cloud.dialogflow.v2.Agents.ExportAgent] method. You can import a saved
 * agent by using the [ImportAgent][google.cloud.dialogflow.v2.Agents.ImportAgent] method.
 *
 * Dialogflow provides several
 * [prebuilt agents](https://dialogflow.com/docs/prebuilt-agents) for common
 * conversation scenarios such as determining a date and time, converting
 * currency, and so on.
 *
 * For more information about agents, see the
 * [Dialogflow documentation](https://dialogflow.com/docs/agents).
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
     */
    public function GetAgent(\Google\Cloud\Dialogflow\V2\GetAgentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Agents/GetAgent',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Agent', 'decode'],
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
     * Operation <response: [google.protobuf.Empty][google.protobuf.Empty],
     *            metadata: [google.protobuf.Struct][google.protobuf.Struct]>
     * @param \Google\Cloud\Dialogflow\V2\TrainAgentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
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
     * Operation <response: [ExportAgentResponse][google.cloud.dialogflow.v2.ExportAgentResponse],
     *            metadata: [google.protobuf.Struct][google.protobuf.Struct]>
     * @param \Google\Cloud\Dialogflow\V2\ExportAgentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
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
     * versions from ImportAgentRequest.
     *
     * Operation <response: [google.protobuf.Empty][google.protobuf.Empty],
     *            metadata: [google.protobuf.Struct][google.protobuf.Struct]>
     * @param \Google\Cloud\Dialogflow\V2\ImportAgentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
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
     * entity types in the older version are deleted.
     *
     * Operation <response: [google.protobuf.Empty][google.protobuf.Empty],
     *            metadata: [google.protobuf.Struct][google.protobuf.Struct]>
     * @param \Google\Cloud\Dialogflow\V2\RestoreAgentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function RestoreAgent(\Google\Cloud\Dialogflow\V2\RestoreAgentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Agents/RestoreAgent',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
