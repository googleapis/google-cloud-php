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
 * A service used for session interactions.
 *
 * For more information, see the [API interactions
 * guide](https://cloud.google.com/dialogflow/docs/api-overview).
 */
class SessionsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Processes a natural language query and returns structured, actionable data
     * as a result. This method is not idempotent, because it may cause contexts
     * and session entity types to be updated, which in turn might affect
     * results of future queries.
     *
     * Note: Always use agent versions for production traffic.
     * See [Versions and
     * environments](https://cloud.google.com/dialogflow/es/docs/agents-versions).
     * @param \Google\Cloud\Dialogflow\V2\DetectIntentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DetectIntent(\Google\Cloud\Dialogflow\V2\DetectIntentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Sessions/DetectIntent',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\DetectIntentResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Processes a natural language query in audio format in a streaming fashion
     * and returns structured, actionable data as a result. This method is only
     * available via the gRPC API (not REST).
     *
     * Note: Always use agent versions for production traffic.
     * See [Versions and
     * environments](https://cloud.google.com/dialogflow/es/docs/agents-versions).
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\BidiStreamingCall
     */
    public function StreamingDetectIntent($metadata = [], $options = []) {
        return $this->_bidiRequest('/google.cloud.dialogflow.v2.Sessions/StreamingDetectIntent',
        ['\Google\Cloud\Dialogflow\V2\StreamingDetectIntentResponse','decode'],
        $metadata, $options);
    }

}
