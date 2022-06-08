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
 * Service for managing knowledge [Documents][google.cloud.dialogflow.v2.Document].
 */
class DocumentsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Returns the list of all documents of the knowledge base.
     * @param \Google\Cloud\Dialogflow\V2\ListDocumentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDocuments(\Google\Cloud\Dialogflow\V2\ListDocumentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Documents/ListDocuments',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\ListDocumentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves the specified document.
     * @param \Google\Cloud\Dialogflow\V2\GetDocumentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDocument(\Google\Cloud\Dialogflow\V2\GetDocumentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Documents/GetDocument',
        $argument,
        ['\Google\Cloud\Dialogflow\V2\Document', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new document.
     *
     * This method is a [long-running
     * operation](https://cloud.google.com/dialogflow/cx/docs/how/long-running-operation).
     * The returned `Operation` type has the following method-specific fields:
     *
     * - `metadata`: [KnowledgeOperationMetadata][google.cloud.dialogflow.v2.KnowledgeOperationMetadata]
     * - `response`: [Document][google.cloud.dialogflow.v2.Document]
     * @param \Google\Cloud\Dialogflow\V2\CreateDocumentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateDocument(\Google\Cloud\Dialogflow\V2\CreateDocumentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Documents/CreateDocument',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates documents by importing data from external sources.
     * Dialogflow supports up to 350 documents in each request. If you try to
     * import more, Dialogflow will return an error.
     *
     * This method is a [long-running
     * operation](https://cloud.google.com/dialogflow/cx/docs/how/long-running-operation).
     * The returned `Operation` type has the following method-specific fields:
     *
     * - `metadata`: [KnowledgeOperationMetadata][google.cloud.dialogflow.v2.KnowledgeOperationMetadata]
     * - `response`: [ImportDocumentsResponse][google.cloud.dialogflow.v2.ImportDocumentsResponse]
     * @param \Google\Cloud\Dialogflow\V2\ImportDocumentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ImportDocuments(\Google\Cloud\Dialogflow\V2\ImportDocumentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Documents/ImportDocuments',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified document.
     *
     * This method is a [long-running
     * operation](https://cloud.google.com/dialogflow/cx/docs/how/long-running-operation).
     * The returned `Operation` type has the following method-specific fields:
     *
     * - `metadata`: [KnowledgeOperationMetadata][google.cloud.dialogflow.v2.KnowledgeOperationMetadata]
     * - `response`: An [Empty
     *   message](https://developers.google.com/protocol-buffers/docs/reference/google.protobuf#empty)
     * @param \Google\Cloud\Dialogflow\V2\DeleteDocumentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteDocument(\Google\Cloud\Dialogflow\V2\DeleteDocumentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Documents/DeleteDocument',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified document.
     *
     * This method is a [long-running
     * operation](https://cloud.google.com/dialogflow/cx/docs/how/long-running-operation).
     * The returned `Operation` type has the following method-specific fields:
     *
     * - `metadata`: [KnowledgeOperationMetadata][google.cloud.dialogflow.v2.KnowledgeOperationMetadata]
     * - `response`: [Document][google.cloud.dialogflow.v2.Document]
     * @param \Google\Cloud\Dialogflow\V2\UpdateDocumentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateDocument(\Google\Cloud\Dialogflow\V2\UpdateDocumentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Documents/UpdateDocument',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Reloads the specified document from its specified source, content_uri or
     * content. The previously loaded content of the document will be deleted.
     * Note: Even when the content of the document has not changed, there still
     * may be side effects because of internal implementation changes.
     *
     * This method is a [long-running
     * operation](https://cloud.google.com/dialogflow/cx/docs/how/long-running-operation).
     * The returned `Operation` type has the following method-specific fields:
     *
     * - `metadata`: [KnowledgeOperationMetadata][google.cloud.dialogflow.v2.KnowledgeOperationMetadata]
     * - `response`: [Document][google.cloud.dialogflow.v2.Document]
     *
     * Note: The `projects.agent.knowledgeBases.documents` resource is deprecated;
     * only use `projects.knowledgeBases.documents`.
     * @param \Google\Cloud\Dialogflow\V2\ReloadDocumentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ReloadDocument(\Google\Cloud\Dialogflow\V2\ReloadDocumentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Documents/ReloadDocument',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Exports a smart messaging candidate document into the specified
     * destination.
     *
     * This method is a [long-running
     * operation](https://cloud.google.com/dialogflow/cx/docs/how/long-running-operation).
     * The returned `Operation` type has the following method-specific fields:
     *
     * - `metadata`: [KnowledgeOperationMetadata][google.cloud.dialogflow.v2.KnowledgeOperationMetadata]
     * - `response`: [Document][google.cloud.dialogflow.v2.Document]
     * @param \Google\Cloud\Dialogflow\V2\ExportDocumentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ExportDocument(\Google\Cloud\Dialogflow\V2\ExportDocumentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dialogflow.v2.Documents/ExportDocument',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
