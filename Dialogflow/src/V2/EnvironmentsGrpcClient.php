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
 * Service for managing [Environments][google.cloud.dialogflow.v2.Environment].
 */
class EnvironmentsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Returns the list of all non-draft environments of the specified agent.
     * @param \Google\Cloud\Dialogflow\V2\ListEnvironmentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListEnvironments(\Google\Cloud\Dialogflow\V2\ListEnvironmentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Environments/ListEnvironments',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\ListEnvironmentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves the specified agent environment.
     * @param \Google\Cloud\Dialogflow\V2\GetEnvironmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetEnvironment(\Google\Cloud\Dialogflow\V2\GetEnvironmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Environments/GetEnvironment',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Environment', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an agent environment.
     * @param \Google\Cloud\Dialogflow\V2\CreateEnvironmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateEnvironment(\Google\Cloud\Dialogflow\V2\CreateEnvironmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Environments/CreateEnvironment',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Environment', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified agent environment.
     *
     * This method allows you to deploy new agent versions into the environment.
     * When an environment is pointed to a new agent version by setting
     * `environment.agent_version`, the environment is temporarily set to the
     * `LOADING` state. During that time, the environment keeps on serving the
     * previous version of the agent. After the new agent version is done loading,
     * the environment is set back to the `RUNNING` state.
     * You can use "-" as Environment ID in environment name to update version
     * in "draft" environment. WARNING: this will negate all recent changes to
     * draft and can't be undone. You may want to save the draft to a version
     * before calling this function.
     * @param \Google\Cloud\Dialogflow\V2\UpdateEnvironmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateEnvironment(\Google\Cloud\Dialogflow\V2\UpdateEnvironmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Environments/UpdateEnvironment',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Environment', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified agent environment.
     * @param \Google\Cloud\Dialogflow\V2\DeleteEnvironmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteEnvironment(\Google\Cloud\Dialogflow\V2\DeleteEnvironmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Environments/DeleteEnvironment',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the history of the specified environment.
     * @param \Google\Cloud\Dialogflow\V2\GetEnvironmentHistoryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetEnvironmentHistory(\Google\Cloud\Dialogflow\V2\GetEnvironmentHistoryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Environments/GetEnvironmentHistory',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\EnvironmentHistory', 'decode'],
        $metadata, $options);
    }

}
