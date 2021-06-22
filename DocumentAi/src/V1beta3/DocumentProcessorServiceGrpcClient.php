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
namespace Google\Cloud\DocumentAI\V1beta3;

/**
 * Service to call Cloud DocumentAI to process documents according to the
 * processor's definition. Processors are built using state-of-the-art Google
 * AI such as natural language, computer vision, and translation to extract
 * structured information from unstructured or semi-structured documents.
 */
class DocumentProcessorServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Processes a single document.
     * @param \Google\Cloud\DocumentAI\V1beta3\ProcessRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ProcessDocument(\Google\Cloud\DocumentAI\V1beta3\ProcessRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1beta3.DocumentProcessorService/ProcessDocument',
        $argument,
        ['\Google\Cloud\DocumentAI\V1beta3\ProcessResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * LRO endpoint to batch process many documents. The output is written
     * to Cloud Storage as JSON in the [Document] format.
     * @param \Google\Cloud\DocumentAI\V1beta3\BatchProcessRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchProcessDocuments(\Google\Cloud\DocumentAI\V1beta3\BatchProcessRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1beta3.DocumentProcessorService/BatchProcessDocuments',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Fetches processor types.
     * @param \Google\Cloud\DocumentAI\V1beta3\FetchProcessorTypesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function FetchProcessorTypes(\Google\Cloud\DocumentAI\V1beta3\FetchProcessorTypesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1beta3.DocumentProcessorService/FetchProcessorTypes',
        $argument,
        ['\Google\Cloud\DocumentAI\V1beta3\FetchProcessorTypesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all processors which belong to this project.
     * @param \Google\Cloud\DocumentAI\V1beta3\ListProcessorsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListProcessors(\Google\Cloud\DocumentAI\V1beta3\ListProcessorsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1beta3.DocumentProcessorService/ListProcessors',
        $argument,
        ['\Google\Cloud\DocumentAI\V1beta3\ListProcessorsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a processor from the type processor that the user chose.
     * The processor will be at "ENABLED" state by default after its creation.
     * @param \Google\Cloud\DocumentAI\V1beta3\CreateProcessorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateProcessor(\Google\Cloud\DocumentAI\V1beta3\CreateProcessorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1beta3.DocumentProcessorService/CreateProcessor',
        $argument,
        ['\Google\Cloud\DocumentAI\V1beta3\Processor', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the processor, unloads all deployed model artifacts if it was
     * enabled and then deletes all artifacts associated with this processor.
     * @param \Google\Cloud\DocumentAI\V1beta3\DeleteProcessorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteProcessor(\Google\Cloud\DocumentAI\V1beta3\DeleteProcessorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1beta3.DocumentProcessorService/DeleteProcessor',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Enables a processor
     * @param \Google\Cloud\DocumentAI\V1beta3\EnableProcessorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function EnableProcessor(\Google\Cloud\DocumentAI\V1beta3\EnableProcessorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1beta3.DocumentProcessorService/EnableProcessor',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Disables a processor
     * @param \Google\Cloud\DocumentAI\V1beta3\DisableProcessorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DisableProcessor(\Google\Cloud\DocumentAI\V1beta3\DisableProcessorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1beta3.DocumentProcessorService/DisableProcessor',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Send a document for Human Review. The input document should be processed by
     * the specified processor.
     * @param \Google\Cloud\DocumentAI\V1beta3\ReviewDocumentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ReviewDocument(\Google\Cloud\DocumentAI\V1beta3\ReviewDocumentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1beta3.DocumentProcessorService/ReviewDocument',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
