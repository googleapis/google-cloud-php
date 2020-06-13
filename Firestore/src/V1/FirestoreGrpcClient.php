<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2019 Google LLC
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
namespace Google\Cloud\Firestore\V1;

/**
 * Specification of the Firestore API.
 *
 * The Cloud Firestore service.
 *
 * Cloud Firestore is a fast, fully managed, serverless, cloud-native NoSQL
 * document database that simplifies storing, syncing, and querying data for
 * your mobile, web, and IoT apps at global scale. Its client libraries provide
 * live synchronization and offline support, while its security features and
 * integrations with Firebase and Google Cloud Platform (GCP) accelerate
 * building truly serverless apps.
 */
class FirestoreGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Gets a single document.
     * @param \Google\Cloud\Firestore\V1\GetDocumentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetDocument(\Google\Cloud\Firestore\V1\GetDocumentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.firestore.v1.Firestore/GetDocument',
        $argument,
        ['\Google\Cloud\Firestore\V1\Document', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists documents.
     * @param \Google\Cloud\Firestore\V1\ListDocumentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListDocuments(\Google\Cloud\Firestore\V1\ListDocumentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.firestore.v1.Firestore/ListDocuments',
        $argument,
        ['\Google\Cloud\Firestore\V1\ListDocumentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates or inserts a document.
     * @param \Google\Cloud\Firestore\V1\UpdateDocumentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateDocument(\Google\Cloud\Firestore\V1\UpdateDocumentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.firestore.v1.Firestore/UpdateDocument',
        $argument,
        ['\Google\Cloud\Firestore\V1\Document', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a document.
     * @param \Google\Cloud\Firestore\V1\DeleteDocumentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteDocument(\Google\Cloud\Firestore\V1\DeleteDocumentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.firestore.v1.Firestore/DeleteDocument',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets multiple documents.
     *
     * Documents returned by this method are not guaranteed to be returned in the
     * same order that they were requested.
     * @param \Google\Cloud\Firestore\V1\BatchGetDocumentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function BatchGetDocuments(\Google\Cloud\Firestore\V1\BatchGetDocumentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/google.firestore.v1.Firestore/BatchGetDocuments',
        $argument,
        ['\Google\Cloud\Firestore\V1\BatchGetDocumentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Starts a new transaction.
     * @param \Google\Cloud\Firestore\V1\BeginTransactionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function BeginTransaction(\Google\Cloud\Firestore\V1\BeginTransactionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.firestore.v1.Firestore/BeginTransaction',
        $argument,
        ['\Google\Cloud\Firestore\V1\BeginTransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Commits a transaction, while optionally updating documents.
     * @param \Google\Cloud\Firestore\V1\CommitRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Commit(\Google\Cloud\Firestore\V1\CommitRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.firestore.v1.Firestore/Commit',
        $argument,
        ['\Google\Cloud\Firestore\V1\CommitResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Rolls back a transaction.
     * @param \Google\Cloud\Firestore\V1\RollbackRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Rollback(\Google\Cloud\Firestore\V1\RollbackRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.firestore.v1.Firestore/Rollback',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Runs a query.
     * @param \Google\Cloud\Firestore\V1\RunQueryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function RunQuery(\Google\Cloud\Firestore\V1\RunQueryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/google.firestore.v1.Firestore/RunQuery',
        $argument,
        ['\Google\Cloud\Firestore\V1\RunQueryResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Partitions a query by returning partition cursors that can be used to run
     * the query in parallel. The returned partition cursors are split points that
     * can be used by RunQuery as starting/end points for the query results.
     * @param \Google\Cloud\Firestore\V1\PartitionQueryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PartitionQuery(\Google\Cloud\Firestore\V1\PartitionQueryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.firestore.v1.Firestore/PartitionQuery',
        $argument,
        ['\Google\Cloud\Firestore\V1\PartitionQueryResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Streams batches of document updates and deletes, in order.
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Write($metadata = [], $options = []) {
        return $this->_bidiRequest('/google.firestore.v1.Firestore/Write',
        ['\Google\Cloud\Firestore\V1\WriteResponse','decode'],
        $metadata, $options);
    }

    /**
     * Listens to changes.
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Listen($metadata = [], $options = []) {
        return $this->_bidiRequest('/google.firestore.v1.Firestore/Listen',
        ['\Google\Cloud\Firestore\V1\ListenResponse','decode'],
        $metadata, $options);
    }

    /**
     * Lists all the collection IDs underneath a document.
     * @param \Google\Cloud\Firestore\V1\ListCollectionIdsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListCollectionIds(\Google\Cloud\Firestore\V1\ListCollectionIdsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.firestore.v1.Firestore/ListCollectionIds',
        $argument,
        ['\Google\Cloud\Firestore\V1\ListCollectionIdsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Applies a batch of write operations.
     *
     * The BatchWrite method does not apply the write operations atomically
     * and can apply them out of order. Method does not allow more than one write
     * per document. Each write succeeds or fails independently. See the
     * [BatchWriteResponse][google.firestore.v1.BatchWriteResponse] for the success status of each write.
     *
     * If you require an atomically applied set of writes, use
     * [Commit][google.firestore.v1.Firestore.Commit] instead.
     * @param \Google\Cloud\Firestore\V1\BatchWriteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function BatchWrite(\Google\Cloud\Firestore\V1\BatchWriteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.firestore.v1.Firestore/BatchWrite',
        $argument,
        ['\Google\Cloud\Firestore\V1\BatchWriteResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new document.
     * @param \Google\Cloud\Firestore\V1\CreateDocumentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateDocument(\Google\Cloud\Firestore\V1\CreateDocumentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.firestore.v1.Firestore/CreateDocument',
        $argument,
        ['\Google\Cloud\Firestore\V1\Document', 'decode'],
        $metadata, $options);
    }

}
