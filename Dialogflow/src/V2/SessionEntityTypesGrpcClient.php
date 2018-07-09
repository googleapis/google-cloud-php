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
 * Entities are extracted from user input and represent parameters that are
 * meaningful to your application. For example, a date range, a proper name
 * such as a geographic location or landmark, and so on. Entities represent
 * actionable data for your application.
 *
 * Session entity types are referred to as **User** entity types and are
 * entities that are built for an individual user such as
 * favorites, preferences, playlists, and so on. You can redefine a session
 * entity type at the session level.
 *
 * For more information about entity types, see the
 * [Dialogflow documentation](https://dialogflow.com/docs/entities).
 */
class SessionEntityTypesGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Returns the list of all session entity types in the specified session.
     * @param \Google\Cloud\Dialogflow\V2\ListSessionEntityTypesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListSessionEntityTypes(\Google\Cloud\Dialogflow\V2\ListSessionEntityTypesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.SessionEntityTypes/ListSessionEntityTypes',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\ListSessionEntityTypesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves the specified session entity type.
     * @param \Google\Cloud\Dialogflow\V2\GetSessionEntityTypeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetSessionEntityType(\Google\Cloud\Dialogflow\V2\GetSessionEntityTypeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.SessionEntityTypes/GetSessionEntityType',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\SessionEntityType', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a session entity type.
     * @param \Google\Cloud\Dialogflow\V2\CreateSessionEntityTypeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateSessionEntityType(\Google\Cloud\Dialogflow\V2\CreateSessionEntityTypeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.SessionEntityTypes/CreateSessionEntityType',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\SessionEntityType', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified session entity type.
     * @param \Google\Cloud\Dialogflow\V2\UpdateSessionEntityTypeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateSessionEntityType(\Google\Cloud\Dialogflow\V2\UpdateSessionEntityTypeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.SessionEntityTypes/UpdateSessionEntityType',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\SessionEntityType', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified session entity type.
     * @param \Google\Cloud\Dialogflow\V2\DeleteSessionEntityTypeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteSessionEntityType(\Google\Cloud\Dialogflow\V2\DeleteSessionEntityTypeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.SessionEntityTypes/DeleteSessionEntityType',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
