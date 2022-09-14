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
 * Service for managing [Conversations][google.cloud.dialogflow.v2.Conversation].
 */
class ConversationsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new conversation. Conversations are auto-completed after 24
     * hours.
     *
     * Conversation Lifecycle:
     * There are two stages during a conversation: Automated Agent Stage and
     * Assist Stage.
     *
     * For Automated Agent Stage, there will be a dialogflow agent responding to
     * user queries.
     *
     * For Assist Stage, there's no dialogflow agent responding to user queries.
     * But we will provide suggestions which are generated from conversation.
     *
     * If [Conversation.conversation_profile][google.cloud.dialogflow.v2.Conversation.conversation_profile] is configured for a dialogflow
     * agent, conversation will start from `Automated Agent Stage`, otherwise, it
     * will start from `Assist Stage`. And during `Automated Agent Stage`, once an
     * [Intent][google.cloud.dialogflow.v2.Intent] with [Intent.live_agent_handoff][google.cloud.dialogflow.v2.Intent.live_agent_handoff] is triggered, conversation
     * will transfer to Assist Stage.
     * @param \Google\Cloud\Dialogflow\V2\CreateConversationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateConversation(\Google\Cloud\Dialogflow\V2\CreateConversationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Conversations/CreateConversation',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Conversation', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the list of all conversations in the specified project.
     * @param \Google\Cloud\Dialogflow\V2\ListConversationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListConversations(\Google\Cloud\Dialogflow\V2\ListConversationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Conversations/ListConversations',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\ListConversationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves the specific conversation.
     * @param \Google\Cloud\Dialogflow\V2\GetConversationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetConversation(\Google\Cloud\Dialogflow\V2\GetConversationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Conversations/GetConversation',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Conversation', 'decode'],
        $metadata, $options);
    }

    /**
     * Completes the specified conversation. Finished conversations are purged
     * from the database after 30 days.
     * @param \Google\Cloud\Dialogflow\V2\CompleteConversationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CompleteConversation(\Google\Cloud\Dialogflow\V2\CompleteConversationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Conversations/CompleteConversation',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Conversation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists messages that belong to a given conversation.
     * `messages` are ordered by `create_time` in descending order. To fetch
     * updates without duplication, send request with filter
     * `create_time_epoch_microseconds >
     * [first item's create_time of previous request]` and empty page_token.
     * @param \Google\Cloud\Dialogflow\V2\ListMessagesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListMessages(\Google\Cloud\Dialogflow\V2\ListMessagesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Conversations/ListMessages',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\ListMessagesResponse', 'decode'],
        $metadata, $options);
    }

}
