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
 * Service for managing [Versions][google.cloud.dialogflow.v2.Version].
 */
class VersionsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Returns the list of all versions of the specified agent.
     * @param \Google\Cloud\Dialogflow\V2\ListVersionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListVersions(\Google\Cloud\Dialogflow\V2\ListVersionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Versions/ListVersions',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\ListVersionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves the specified agent version.
     * @param \Google\Cloud\Dialogflow\V2\GetVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetVersion(\Google\Cloud\Dialogflow\V2\GetVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Versions/GetVersion',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Version', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an agent version.
     *
     * The new version points to the agent instance in the "default" environment.
     * @param \Google\Cloud\Dialogflow\V2\CreateVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateVersion(\Google\Cloud\Dialogflow\V2\CreateVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Versions/CreateVersion',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Version', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified agent version.
     *
     * Note that this method does not allow you to update the state of the agent
     * the given version points to. It allows you to update only mutable
     * properties of the version resource.
     * @param \Google\Cloud\Dialogflow\V2\UpdateVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateVersion(\Google\Cloud\Dialogflow\V2\UpdateVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Versions/UpdateVersion',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Version', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete the specified agent version.
     * @param \Google\Cloud\Dialogflow\V2\DeleteVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteVersion(\Google\Cloud\Dialogflow\V2\DeleteVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Versions/DeleteVersion',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
