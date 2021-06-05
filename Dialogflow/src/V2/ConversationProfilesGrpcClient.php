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
 * Service for managing [ConversationProfiles][google.cloud.dialogflow.v2.ConversationProfile].
 */
class ConversationProfilesGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Returns the list of all conversation profiles in the specified project.
     * @param \Google\Cloud\Dialogflow\V2\ListConversationProfilesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListConversationProfiles(\Google\Cloud\Dialogflow\V2\ListConversationProfilesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.ConversationProfiles/ListConversationProfiles',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\ListConversationProfilesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves the specified conversation profile.
     * @param \Google\Cloud\Dialogflow\V2\GetConversationProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetConversationProfile(\Google\Cloud\Dialogflow\V2\GetConversationProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.ConversationProfiles/GetConversationProfile',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\ConversationProfile', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a conversation profile in the specified project.
     *
     * [ConversationProfile.CreateTime][] and [ConversationProfile.UpdateTime][]
     * aren't populated in the response. You can retrieve them via
     * [GetConversationProfile][google.cloud.dialogflow.v2.ConversationProfiles.GetConversationProfile] API.
     * @param \Google\Cloud\Dialogflow\V2\CreateConversationProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateConversationProfile(\Google\Cloud\Dialogflow\V2\CreateConversationProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.ConversationProfiles/CreateConversationProfile',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\ConversationProfile', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified conversation profile.
     *
     * [ConversationProfile.CreateTime][] and [ConversationProfile.UpdateTime][]
     * aren't populated in the response. You can retrieve them via
     * [GetConversationProfile][google.cloud.dialogflow.v2.ConversationProfiles.GetConversationProfile] API.
     * @param \Google\Cloud\Dialogflow\V2\UpdateConversationProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateConversationProfile(\Google\Cloud\Dialogflow\V2\UpdateConversationProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.ConversationProfiles/UpdateConversationProfile',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\ConversationProfile', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified conversation profile.
     * @param \Google\Cloud\Dialogflow\V2\DeleteConversationProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteConversationProfile(\Google\Cloud\Dialogflow\V2\DeleteConversationProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.ConversationProfiles/DeleteConversationProfile',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
