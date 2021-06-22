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
namespace Google\Cloud\MediaTranslation\V1beta1;

/**
 * Provides translation from/to media types.
 */
class SpeechTranslationServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Performs bidirectional streaming speech translation: receive results while
     * sending audio. This method is only available via the gRPC API (not REST).
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\BidiStreamingCall
     */
    public function StreamingTranslateSpeech($metadata = [], $options = []) {
        return $this->_bidiRequest('/google.cloud.mediatranslation.v1beta1.SpeechTranslationService/StreamingTranslateSpeech',
        ['\Google\Cloud\MediaTranslation\V1beta1\StreamingTranslateSpeechResponse','decode'],
        $metadata, $options);
    }

}
