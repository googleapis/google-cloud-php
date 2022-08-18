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
namespace Google\Cloud\DocumentAI\V1;

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
     * @param \Google\Cloud\DocumentAI\V1\ProcessRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ProcessDocument(\Google\Cloud\DocumentAI\V1\ProcessRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1.DocumentProcessorService/ProcessDocument',
        $argument,
        ['\Google\Cloud\DocumentAI\V1\ProcessResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * LRO endpoint to batch process many documents. The output is written
     * to Cloud Storage as JSON in the [Document] format.
     * @param \Google\Cloud\DocumentAI\V1\BatchProcessRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchProcessDocuments(\Google\Cloud\DocumentAI\V1\BatchProcessRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1.DocumentProcessorService/BatchProcessDocuments',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Fetches processor types. Note that we do not use ListProcessorTypes here
     * because it is not paginated.
     * @param \Google\Cloud\DocumentAI\V1\FetchProcessorTypesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function FetchProcessorTypes(\Google\Cloud\DocumentAI\V1\FetchProcessorTypesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1.DocumentProcessorService/FetchProcessorTypes',
        $argument,
        ['\Google\Cloud\DocumentAI\V1\FetchProcessorTypesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the processor types that exist.
     * @param \Google\Cloud\DocumentAI\V1\ListProcessorTypesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListProcessorTypes(\Google\Cloud\DocumentAI\V1\ListProcessorTypesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1.DocumentProcessorService/ListProcessorTypes',
        $argument,
        ['\Google\Cloud\DocumentAI\V1\ListProcessorTypesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all processors which belong to this project.
     * @param \Google\Cloud\DocumentAI\V1\ListProcessorsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListProcessors(\Google\Cloud\DocumentAI\V1\ListProcessorsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1.DocumentProcessorService/ListProcessors',
        $argument,
        ['\Google\Cloud\DocumentAI\V1\ListProcessorsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a processor detail.
     * @param \Google\Cloud\DocumentAI\V1\GetProcessorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetProcessor(\Google\Cloud\DocumentAI\V1\GetProcessorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1.DocumentProcessorService/GetProcessor',
        $argument,
        ['\Google\Cloud\DocumentAI\V1\Processor', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a processor version detail.
     * @param \Google\Cloud\DocumentAI\V1\GetProcessorVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetProcessorVersion(\Google\Cloud\DocumentAI\V1\GetProcessorVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1.DocumentProcessorService/GetProcessorVersion',
        $argument,
        ['\Google\Cloud\DocumentAI\V1\ProcessorVersion', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all versions of a processor.
     * @param \Google\Cloud\DocumentAI\V1\ListProcessorVersionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListProcessorVersions(\Google\Cloud\DocumentAI\V1\ListProcessorVersionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1.DocumentProcessorService/ListProcessorVersions',
        $argument,
        ['\Google\Cloud\DocumentAI\V1\ListProcessorVersionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the processor version, all artifacts under the processor version
     * will be deleted.
     * @param \Google\Cloud\DocumentAI\V1\DeleteProcessorVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteProcessorVersion(\Google\Cloud\DocumentAI\V1\DeleteProcessorVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1.DocumentProcessorService/DeleteProcessorVersion',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deploys the processor version.
     * @param \Google\Cloud\DocumentAI\V1\DeployProcessorVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeployProcessorVersion(\Google\Cloud\DocumentAI\V1\DeployProcessorVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1.DocumentProcessorService/DeployProcessorVersion',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Undeploys the processor version.
     * @param \Google\Cloud\DocumentAI\V1\UndeployProcessorVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UndeployProcessorVersion(\Google\Cloud\DocumentAI\V1\UndeployProcessorVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1.DocumentProcessorService/UndeployProcessorVersion',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a processor from the type processor that the user chose.
     * The processor will be at "ENABLED" state by default after its creation.
     * @param \Google\Cloud\DocumentAI\V1\CreateProcessorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateProcessor(\Google\Cloud\DocumentAI\V1\CreateProcessorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1.DocumentProcessorService/CreateProcessor',
        $argument,
        ['\Google\Cloud\DocumentAI\V1\Processor', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the processor, unloads all deployed model artifacts if it was
     * enabled and then deletes all artifacts associated with this processor.
     * @param \Google\Cloud\DocumentAI\V1\DeleteProcessorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteProcessor(\Google\Cloud\DocumentAI\V1\DeleteProcessorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1.DocumentProcessorService/DeleteProcessor',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Enables a processor
     * @param \Google\Cloud\DocumentAI\V1\EnableProcessorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function EnableProcessor(\Google\Cloud\DocumentAI\V1\EnableProcessorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1.DocumentProcessorService/EnableProcessor',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Disables a processor
     * @param \Google\Cloud\DocumentAI\V1\DisableProcessorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DisableProcessor(\Google\Cloud\DocumentAI\V1\DisableProcessorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1.DocumentProcessorService/DisableProcessor',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Set the default (active) version of a [Processor][google.cloud.documentai.v1.Processor] that will be used in
     * [ProcessDocument][google.cloud.documentai.v1.DocumentProcessorService.ProcessDocument] and
     * [BatchProcessDocuments][google.cloud.documentai.v1.DocumentProcessorService.BatchProcessDocuments].
     * @param \Google\Cloud\DocumentAI\V1\SetDefaultProcessorVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetDefaultProcessorVersion(\Google\Cloud\DocumentAI\V1\SetDefaultProcessorVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1.DocumentProcessorService/SetDefaultProcessorVersion',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Send a document for Human Review. The input document should be processed by
     * the specified processor.
     * @param \Google\Cloud\DocumentAI\V1\ReviewDocumentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ReviewDocument(\Google\Cloud\DocumentAI\V1\ReviewDocumentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.documentai.v1.DocumentProcessorService/ReviewDocument',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
