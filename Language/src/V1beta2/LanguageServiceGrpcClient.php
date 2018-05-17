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
namespace Google\Cloud\Language\V1beta2;

/**
 * Provides text analysis operations such as sentiment analysis and entity
 * recognition.
 */
class LanguageServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Analyzes the sentiment of the provided text.
     * @param \Google\Cloud\Language\V1beta2\AnalyzeSentimentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function AnalyzeSentiment(\Google\Cloud\Language\V1beta2\AnalyzeSentimentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.language.v1beta2.LanguageService/AnalyzeSentiment',
        $argument,
        ['\Google\Cloud\Language\V1beta2\AnalyzeSentimentResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Finds named entities (currently proper names and common nouns) in the text
     * along with entity types, salience, mentions for each entity, and
     * other properties.
     * @param \Google\Cloud\Language\V1beta2\AnalyzeEntitiesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function AnalyzeEntities(\Google\Cloud\Language\V1beta2\AnalyzeEntitiesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.language.v1beta2.LanguageService/AnalyzeEntities',
        $argument,
        ['\Google\Cloud\Language\V1beta2\AnalyzeEntitiesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Finds entities, similar to [AnalyzeEntities][google.cloud.language.v1beta2.LanguageService.AnalyzeEntities] in the text and analyzes
     * sentiment associated with each entity and its mentions.
     * @param \Google\Cloud\Language\V1beta2\AnalyzeEntitySentimentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function AnalyzeEntitySentiment(\Google\Cloud\Language\V1beta2\AnalyzeEntitySentimentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.language.v1beta2.LanguageService/AnalyzeEntitySentiment',
        $argument,
        ['\Google\Cloud\Language\V1beta2\AnalyzeEntitySentimentResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Analyzes the syntax of the text and provides sentence boundaries and
     * tokenization along with part of speech tags, dependency trees, and other
     * properties.
     * @param \Google\Cloud\Language\V1beta2\AnalyzeSyntaxRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function AnalyzeSyntax(\Google\Cloud\Language\V1beta2\AnalyzeSyntaxRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.language.v1beta2.LanguageService/AnalyzeSyntax',
        $argument,
        ['\Google\Cloud\Language\V1beta2\AnalyzeSyntaxResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Classifies a document into categories.
     * @param \Google\Cloud\Language\V1beta2\ClassifyTextRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ClassifyText(\Google\Cloud\Language\V1beta2\ClassifyTextRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.language.v1beta2.LanguageService/ClassifyText',
        $argument,
        ['\Google\Cloud\Language\V1beta2\ClassifyTextResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * A convenience method that provides all syntax, sentiment, entity, and
     * classification features in one call.
     * @param \Google\Cloud\Language\V1beta2\AnnotateTextRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function AnnotateText(\Google\Cloud\Language\V1beta2\AnnotateTextRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.language.v1beta2.LanguageService/AnnotateText',
        $argument,
        ['\Google\Cloud\Language\V1beta2\AnnotateTextResponse', 'decode'],
        $metadata, $options);
    }

}
