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
namespace Google\Cloud\DocumentAI\V1beta2;

/**
 * Service to parse structured information from unstructured or semi-structured
 * documents using state-of-the-art Google AI such as natural language,
 * computer vision, and translation.
 */
class DocumentUnderstandingServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * LRO endpoint to batch process many documents. The output is written
     * to Cloud Storage as JSON in the [Document] format.
     * @param \Google\Cloud\DocumentAI\V1beta2\BatchProcessDocumentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchProcessDocuments(\Google\Cloud\DocumentAI\V1beta2\BatchProcessDocumentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1beta2.DocumentUnderstandingService/BatchProcessDocuments',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Processes a single document.
     * @param \Google\Cloud\DocumentAI\V1beta2\ProcessDocumentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ProcessDocument(\Google\Cloud\DocumentAI\V1beta2\ProcessDocumentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1beta2.DocumentUnderstandingService/ProcessDocument',
        $argument,
        ['\Google\Cloud\DocumentAI\V1beta2\Document', 'decode'],
        $metadata, $options);
    }

}
