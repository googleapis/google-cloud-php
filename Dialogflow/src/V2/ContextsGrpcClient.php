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
 * A context represents additional information included with user input or with
 * an intent returned by the Dialogflow API. Contexts are helpful for
 * differentiating user input which may be vague or have a different meaning
 * depending on additional details from your application such as user setting
 * and preferences, previous user input, where the user is in your application,
 * geographic location, and so on.
 *
 * You can include contexts as input parameters of a
 * [DetectIntent][google.cloud.dialogflow.v2.Sessions.DetectIntent] (or
 * [StreamingDetectIntent][google.cloud.dialogflow.v2.Sessions.StreamingDetectIntent]) request,
 * or as output contexts included in the returned intent.
 * Contexts expire when an intent is matched, after the number of `DetectIntent`
 * requests specified by the `lifespan_count` parameter, or after 10 minutes
 * if no intents are matched for a `DetectIntent` request.
 *
 * For more information about contexts, see the
 * [Dialogflow documentation](https://dialogflow.com/docs/contexts).
 */
class ContextsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Returns the list of all contexts in the specified session.
     * @param \Google\Cloud\Dialogflow\V2\ListContextsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListContexts(\Google\Cloud\Dialogflow\V2\ListContextsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Contexts/ListContexts',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\ListContextsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves the specified context.
     * @param \Google\Cloud\Dialogflow\V2\GetContextRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetContext(\Google\Cloud\Dialogflow\V2\GetContextRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Contexts/GetContext',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Context', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a context.
     * @param \Google\Cloud\Dialogflow\V2\CreateContextRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateContext(\Google\Cloud\Dialogflow\V2\CreateContextRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Contexts/CreateContext',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Context', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified context.
     * @param \Google\Cloud\Dialogflow\V2\UpdateContextRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateContext(\Google\Cloud\Dialogflow\V2\UpdateContextRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Contexts/UpdateContext',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Context', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified context.
     * @param \Google\Cloud\Dialogflow\V2\DeleteContextRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteContext(\Google\Cloud\Dialogflow\V2\DeleteContextRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Contexts/DeleteContext',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes all active contexts in the specified session.
     * @param \Google\Cloud\Dialogflow\V2\DeleteAllContextsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteAllContexts(\Google\Cloud\Dialogflow\V2\DeleteAllContextsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Contexts/DeleteAllContexts',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
