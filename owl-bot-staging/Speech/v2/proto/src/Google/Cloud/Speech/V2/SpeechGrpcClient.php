<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2023 Google LLC
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
namespace Google\Cloud\Speech\V2;

/**
 * Enables speech transcription and resource management.
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
     * Creates a [Recognizer][google.cloud.speech.v2.Recognizer].
     * @param \Google\Cloud\Speech\V2\CreateRecognizerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateRecognizer(\Google\Cloud\Speech\V2\CreateRecognizerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v2.Speech/CreateRecognizer',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Recognizers.
     * @param \Google\Cloud\Speech\V2\ListRecognizersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListRecognizers(\Google\Cloud\Speech\V2\ListRecognizersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v2.Speech/ListRecognizers',
        $argument,
        ['\Google\Cloud\Speech\V2\ListRecognizersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the requested
     * [Recognizer][google.cloud.speech.v2.Recognizer]. Fails with
     * [NOT_FOUND][google.rpc.Code.NOT_FOUND] if the requested Recognizer doesn't
     * exist.
     * @param \Google\Cloud\Speech\V2\GetRecognizerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetRecognizer(\Google\Cloud\Speech\V2\GetRecognizerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v2.Speech/GetRecognizer',
        $argument,
        ['\Google\Cloud\Speech\V2\Recognizer', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the [Recognizer][google.cloud.speech.v2.Recognizer].
     * @param \Google\Cloud\Speech\V2\UpdateRecognizerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateRecognizer(\Google\Cloud\Speech\V2\UpdateRecognizerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v2.Speech/UpdateRecognizer',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the [Recognizer][google.cloud.speech.v2.Recognizer].
     * @param \Google\Cloud\Speech\V2\DeleteRecognizerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteRecognizer(\Google\Cloud\Speech\V2\DeleteRecognizerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v2.Speech/DeleteRecognizer',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Undeletes the [Recognizer][google.cloud.speech.v2.Recognizer].
     * @param \Google\Cloud\Speech\V2\UndeleteRecognizerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UndeleteRecognizer(\Google\Cloud\Speech\V2\UndeleteRecognizerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v2.Speech/UndeleteRecognizer',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Performs synchronous Speech recognition: receive results after all audio
     * has been sent and processed.
     * @param \Google\Cloud\Speech\V2\RecognizeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Recognize(\Google\Cloud\Speech\V2\RecognizeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v2.Speech/Recognize',
        $argument,
        ['\Google\Cloud\Speech\V2\RecognizeResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Performs bidirectional streaming speech recognition: receive results while
     * sending audio. This method is only available via the gRPC API (not REST).
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\BidiStreamingCall
     */
    public function StreamingRecognize($metadata = [], $options = []) {
        return $this->_bidiRequest('/google.cloud.speech.v2.Speech/StreamingRecognize',
        ['\Google\Cloud\Speech\V2\StreamingRecognizeResponse','decode'],
        $metadata, $options);
    }

    /**
     * Performs batch asynchronous speech recognition: send a request with N
     * audio files and receive a long running operation that can be polled to see
     * when the transcriptions are finished.
     * @param \Google\Cloud\Speech\V2\BatchRecognizeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchRecognize(\Google\Cloud\Speech\V2\BatchRecognizeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v2.Speech/BatchRecognize',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the requested [Config][google.cloud.speech.v2.Config].
     * @param \Google\Cloud\Speech\V2\GetConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetConfig(\Google\Cloud\Speech\V2\GetConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v2.Speech/GetConfig',
        $argument,
        ['\Google\Cloud\Speech\V2\Config', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the [Config][google.cloud.speech.v2.Config].
     * @param \Google\Cloud\Speech\V2\UpdateConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateConfig(\Google\Cloud\Speech\V2\UpdateConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v2.Speech/UpdateConfig',
        $argument,
        ['\Google\Cloud\Speech\V2\Config', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a [CustomClass][google.cloud.speech.v2.CustomClass].
     * @param \Google\Cloud\Speech\V2\CreateCustomClassRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCustomClass(\Google\Cloud\Speech\V2\CreateCustomClassRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v2.Speech/CreateCustomClass',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists CustomClasses.
     * @param \Google\Cloud\Speech\V2\ListCustomClassesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCustomClasses(\Google\Cloud\Speech\V2\ListCustomClassesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v2.Speech/ListCustomClasses',
        $argument,
        ['\Google\Cloud\Speech\V2\ListCustomClassesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the requested
     * [CustomClass][google.cloud.speech.v2.CustomClass].
     * @param \Google\Cloud\Speech\V2\GetCustomClassRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCustomClass(\Google\Cloud\Speech\V2\GetCustomClassRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v2.Speech/GetCustomClass',
        $argument,
        ['\Google\Cloud\Speech\V2\CustomClass', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the [CustomClass][google.cloud.speech.v2.CustomClass].
     * @param \Google\Cloud\Speech\V2\UpdateCustomClassRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCustomClass(\Google\Cloud\Speech\V2\UpdateCustomClassRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v2.Speech/UpdateCustomClass',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the [CustomClass][google.cloud.speech.v2.CustomClass].
     * @param \Google\Cloud\Speech\V2\DeleteCustomClassRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteCustomClass(\Google\Cloud\Speech\V2\DeleteCustomClassRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v2.Speech/DeleteCustomClass',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Undeletes the [CustomClass][google.cloud.speech.v2.CustomClass].
     * @param \Google\Cloud\Speech\V2\UndeleteCustomClassRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UndeleteCustomClass(\Google\Cloud\Speech\V2\UndeleteCustomClassRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v2.Speech/UndeleteCustomClass',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a [PhraseSet][google.cloud.speech.v2.PhraseSet].
     * @param \Google\Cloud\Speech\V2\CreatePhraseSetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreatePhraseSet(\Google\Cloud\Speech\V2\CreatePhraseSetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v2.Speech/CreatePhraseSet',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists PhraseSets.
     * @param \Google\Cloud\Speech\V2\ListPhraseSetsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListPhraseSets(\Google\Cloud\Speech\V2\ListPhraseSetsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v2.Speech/ListPhraseSets',
        $argument,
        ['\Google\Cloud\Speech\V2\ListPhraseSetsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the requested
     * [PhraseSet][google.cloud.speech.v2.PhraseSet].
     * @param \Google\Cloud\Speech\V2\GetPhraseSetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetPhraseSet(\Google\Cloud\Speech\V2\GetPhraseSetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v2.Speech/GetPhraseSet',
        $argument,
        ['\Google\Cloud\Speech\V2\PhraseSet', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the [PhraseSet][google.cloud.speech.v2.PhraseSet].
     * @param \Google\Cloud\Speech\V2\UpdatePhraseSetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdatePhraseSet(\Google\Cloud\Speech\V2\UpdatePhraseSetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v2.Speech/UpdatePhraseSet',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the [PhraseSet][google.cloud.speech.v2.PhraseSet].
     * @param \Google\Cloud\Speech\V2\DeletePhraseSetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeletePhraseSet(\Google\Cloud\Speech\V2\DeletePhraseSetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v2.Speech/DeletePhraseSet',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Undeletes the [PhraseSet][google.cloud.speech.v2.PhraseSet].
     * @param \Google\Cloud\Speech\V2\UndeletePhraseSetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UndeletePhraseSet(\Google\Cloud\Speech\V2\UndeletePhraseSetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.speech.v2.Speech/UndeletePhraseSet',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
