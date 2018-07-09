<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2017 Google Inc.
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
namespace Google\Cloud\Speech\V1beta1;

/**
 * Service that implements Google Cloud Speech API.
 */
class SpeechGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Performs synchronous speech recognition: receive results after all audio
     * has been sent and processed.
     * @param \Google\Cloud\Speech\V1beta1\SyncRecognizeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SyncRecognize(\Google\Cloud\Speech\V1beta1\SyncRecognizeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v1beta1.Speech/SyncRecognize',
        $argument,
        ['\Google\Cloud\Speech\V1beta1\SyncRecognizeResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Performs asynchronous speech recognition: receive results via the
     * [google.longrunning.Operations]
     * (/speech/reference/rest/v1beta1/operations#Operation)
     * interface. Returns either an
     * `Operation.error` or an `Operation.response` which contains
     * an `AsyncRecognizeResponse` message.
     * @param \Google\Cloud\Speech\V1beta1\AsyncRecognizeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function AsyncRecognize(\Google\Cloud\Speech\V1beta1\AsyncRecognizeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v1beta1.Speech/AsyncRecognize',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Performs bidirectional streaming speech recognition: receive results while
     * sending audio. This method is only available via the gRPC API (not REST).
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function StreamingRecognize($metadata = [], $options = []) {
        return $this->_bidiRequest('/google.cloud.speech.v1beta1.Speech/StreamingRecognize',
        ['\Google\Cloud\Speech\V1beta1\StreamingRecognizeResponse','decode'],
        $metadata, $options);
    }

}
