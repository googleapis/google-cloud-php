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
 * Service for managing [Participants][google.cloud.dialogflow.v2.Participant].
 */
class ParticipantsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new participant in a conversation.
     * @param \Google\Cloud\Dialogflow\V2\CreateParticipantRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateParticipant(\Google\Cloud\Dialogflow\V2\CreateParticipantRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Participants/CreateParticipant',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Participant', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a conversation participant.
     * @param \Google\Cloud\Dialogflow\V2\GetParticipantRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetParticipant(\Google\Cloud\Dialogflow\V2\GetParticipantRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Participants/GetParticipant',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Participant', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the list of all participants in the specified conversation.
     * @param \Google\Cloud\Dialogflow\V2\ListParticipantsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListParticipants(\Google\Cloud\Dialogflow\V2\ListParticipantsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Participants/ListParticipants',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\ListParticipantsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified participant.
     * @param \Google\Cloud\Dialogflow\V2\UpdateParticipantRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateParticipant(\Google\Cloud\Dialogflow\V2\UpdateParticipantRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Participants/UpdateParticipant',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Participant', 'decode'],
        $metadata, $options);
    }

    /**
     * Adds a text (chat, for example), or audio (phone recording, for example)
     * message from a participant into the conversation.
     *
     * Note: Always use agent versions for production traffic
     * sent to virtual agents. See [Versions and
     * environments](https://cloud.google.com/dialogflow/es/docs/agents-versions).
     * @param \Google\Cloud\Dialogflow\V2\AnalyzeContentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AnalyzeContent(\Google\Cloud\Dialogflow\V2\AnalyzeContentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Participants/AnalyzeContent',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\AnalyzeContentResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets suggested articles for a participant based on specific historical
     * messages.
     * @param \Google\Cloud\Dialogflow\V2\SuggestArticlesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SuggestArticles(\Google\Cloud\Dialogflow\V2\SuggestArticlesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Participants/SuggestArticles',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\SuggestArticlesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets suggested faq answers for a participant based on specific historical
     * messages.
     * @param \Google\Cloud\Dialogflow\V2\SuggestFaqAnswersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SuggestFaqAnswers(\Google\Cloud\Dialogflow\V2\SuggestFaqAnswersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Participants/SuggestFaqAnswers',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\SuggestFaqAnswersResponse', 'decode'],
        $metadata, $options);
    }

}
