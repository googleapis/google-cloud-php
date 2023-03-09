<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2018 Google LLC
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
namespace Google\Cloud\TextToSpeech\V1;

/**
 * Service that implements Google Cloud Text-to-Speech API.
 */
class TextToSpeechGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Returns a list of Voice supported for synthesis.
     * @param \Google\Cloud\TextToSpeech\V1\ListVoicesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListVoices(\Google\Cloud\TextToSpeech\V1\ListVoicesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.texttospeech.v1.TextToSpeech/ListVoices',
        $argument,
        ['\Google\Cloud\TextToSpeech\V1\ListVoicesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Synthesizes speech synchronously: receive results after all text input
     * has been processed.
     * @param \Google\Cloud\TextToSpeech\V1\SynthesizeSpeechRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SynthesizeSpeech(\Google\Cloud\TextToSpeech\V1\SynthesizeSpeechRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.texttospeech.v1.TextToSpeech/SynthesizeSpeech',
        $argument,
        ['\Google\Cloud\TextToSpeech\V1\SynthesizeSpeechResponse', 'decode'],
        $metadata, $options);
    }

}
