<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2019 Google LLC.
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
//
namespace Google\Cloud\Dialogflow\V2;

/**
 * An intent represents a mapping between input from a user and an action to
 * be taken by your application. When you pass user input to the
 * [DetectIntent][google.cloud.dialogflow.v2.Sessions.DetectIntent] (or
 * [StreamingDetectIntent][google.cloud.dialogflow.v2.Sessions.StreamingDetectIntent]) method, the
 * Dialogflow API analyzes the input and searches
 * for a matching intent. If no match is found, the Dialogflow API returns a
 * fallback intent (`is_fallback` = true).
 *
 * You can provide additional information for the Dialogflow API to use to
 * match user input to an intent by adding the following to your intent.
 *
 * *   **Contexts** - provide additional context for intent analysis. For
 *     example, if an intent is related to an object in your application that
 *     plays music, you can provide a context to determine when to match the
 *     intent if the user input is "turn it off". You can include a context
 *     that matches the intent when there is previous user input of
 *     "play music", and not when there is previous user input of
 *     "turn on the light".
 *
 * *   **Events** - allow for matching an intent by using an event name
 *     instead of user input. Your application can provide an event name and
 *     related parameters to the Dialogflow API to match an intent. For
 *     example, when your application starts, you can send a welcome event
 *     with a user name parameter to the Dialogflow API to match an intent with
 *     a personalized welcome message for the user.
 *
 * *   **Training phrases** - provide examples of user input to train the
 *     Dialogflow API agent to better match intents.
 *
 * For more information about intents, see the
 * [Dialogflow
 * documentation](https://cloud.google.com/dialogflow/docs/intents-overview).
 */
class IntentsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Returns the list of all intents in the specified agent.
     * @param \Google\Cloud\Dialogflow\V2\ListIntentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListIntents(\Google\Cloud\Dialogflow\V2\ListIntentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Intents/ListIntents',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\ListIntentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves the specified intent.
     * @param \Google\Cloud\Dialogflow\V2\GetIntentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetIntent(\Google\Cloud\Dialogflow\V2\GetIntentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Intents/GetIntent',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Intent', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an intent in the specified agent.
     * @param \Google\Cloud\Dialogflow\V2\CreateIntentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateIntent(\Google\Cloud\Dialogflow\V2\CreateIntentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Intents/CreateIntent',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Intent', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified intent.
     * @param \Google\Cloud\Dialogflow\V2\UpdateIntentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateIntent(\Google\Cloud\Dialogflow\V2\UpdateIntentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Intents/UpdateIntent',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Intent', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified intent and its direct or indirect followup intents.
     * @param \Google\Cloud\Dialogflow\V2\DeleteIntentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteIntent(\Google\Cloud\Dialogflow\V2\DeleteIntentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Intents/DeleteIntent',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates/Creates multiple intents in the specified agent.
     *
     * Operation <response: [BatchUpdateIntentsResponse][google.cloud.dialogflow.v2.BatchUpdateIntentsResponse]>
     * @param \Google\Cloud\Dialogflow\V2\BatchUpdateIntentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function BatchUpdateIntents(\Google\Cloud\Dialogflow\V2\BatchUpdateIntentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Intents/BatchUpdateIntents',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes intents in the specified agent.
     *
     * Operation <response: [google.protobuf.Empty][google.protobuf.Empty]>
     * @param \Google\Cloud\Dialogflow\V2\BatchDeleteIntentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function BatchDeleteIntents(\Google\Cloud\Dialogflow\V2\BatchDeleteIntentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Intents/BatchDeleteIntents',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
