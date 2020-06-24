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
namespace Google\Cloud\Translate\V3;

/**
 * Proto file for the Cloud Translation API (v3 GA).
 *
 * Provides natural language translation operations.
 */
class TranslationServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Translates input text and returns translated text.
     * @param \Google\Cloud\Translate\V3\TranslateTextRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Google\Cloud\Translate\V3\TranslateTextResponse
     */
    public function TranslateText(\Google\Cloud\Translate\V3\TranslateTextRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.translation.v3.TranslationService/TranslateText',
        $argument,
        ['\Google\Cloud\Translate\V3\TranslateTextResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Detects the language of text within a request.
     * @param \Google\Cloud\Translate\V3\DetectLanguageRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Google\Cloud\Translate\V3\DetectLanguageResponse
     */
    public function DetectLanguage(\Google\Cloud\Translate\V3\DetectLanguageRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.translation.v3.TranslationService/DetectLanguage',
        $argument,
        ['\Google\Cloud\Translate\V3\DetectLanguageResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a list of supported languages for translation.
     * @param \Google\Cloud\Translate\V3\GetSupportedLanguagesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Google\Cloud\Translate\V3\SupportedLanguages
     */
    public function GetSupportedLanguages(\Google\Cloud\Translate\V3\GetSupportedLanguagesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.translation.v3.TranslationService/GetSupportedLanguages',
        $argument,
        ['\Google\Cloud\Translate\V3\SupportedLanguages', 'decode'],
        $metadata, $options);
    }

    /**
     * Translates a large volume of text in asynchronous batch mode.
     * This function provides real-time output as the inputs are being processed.
     * If caller cancels a request, the partial results (for an input file, it's
     * all or nothing) may still be available on the specified output location.
     *
     * This call returns immediately and you can
     * use google.longrunning.Operation.name to poll the status of the call.
     * @param \Google\Cloud\Translate\V3\BatchTranslateTextRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Google\LongRunning\Operation
     */
    public function BatchTranslateText(\Google\Cloud\Translate\V3\BatchTranslateTextRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.translation.v3.TranslationService/BatchTranslateText',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a glossary and returns the long-running operation. Returns
     * NOT_FOUND, if the project doesn't exist.
     * @param \Google\Cloud\Translate\V3\CreateGlossaryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Google\LongRunning\Operation
     */
    public function CreateGlossary(\Google\Cloud\Translate\V3\CreateGlossaryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.translation.v3.TranslationService/CreateGlossary',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists glossaries in a project. Returns NOT_FOUND, if the project doesn't
     * exist.
     * @param \Google\Cloud\Translate\V3\ListGlossariesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Google\Cloud\Translate\V3\ListGlossariesResponse
     */
    public function ListGlossaries(\Google\Cloud\Translate\V3\ListGlossariesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.translation.v3.TranslationService/ListGlossaries',
        $argument,
        ['\Google\Cloud\Translate\V3\ListGlossariesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a glossary. Returns NOT_FOUND, if the glossary doesn't
     * exist.
     * @param \Google\Cloud\Translate\V3\GetGlossaryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Google\Cloud\Translate\V3\Glossary
     */
    public function GetGlossary(\Google\Cloud\Translate\V3\GetGlossaryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.translation.v3.TranslationService/GetGlossary',
        $argument,
        ['\Google\Cloud\Translate\V3\Glossary', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a glossary, or cancels glossary construction
     * if the glossary isn't created yet.
     * Returns NOT_FOUND, if the glossary doesn't exist.
     * @param \Google\Cloud\Translate\V3\DeleteGlossaryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Google\LongRunning\Operation
     */
    public function DeleteGlossary(\Google\Cloud\Translate\V3\DeleteGlossaryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.translation.v3.TranslationService/DeleteGlossary',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
