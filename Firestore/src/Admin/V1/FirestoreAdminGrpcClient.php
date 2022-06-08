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
namespace Google\Cloud\Firestore\Admin\V1;

/**
 * The Cloud Firestore Admin API.
 *
 * This API provides several administrative services for Cloud Firestore.
 *
 * Project, Database, Namespace, Collection, Collection Group, and Document are
 * used as defined in the Google Cloud Firestore API.
 *
 * Operation: An Operation represents work being performed in the background.
 *
 * The index service manages Cloud Firestore indexes.
 *
 * Index creation is performed asynchronously.
 * An Operation resource is created for each such asynchronous operation.
 * The state of the operation (including any errors encountered)
 * may be queried via the Operation resource.
 *
 * The Operations collection provides a record of actions performed for the
 * specified Project (including any Operations in progress). Operations are not
 * created directly but through calls on other collections or resources.
 *
 * An Operation that is done may be deleted so that it is no longer listed as
 * part of the Operation collection. Operations are garbage collected after
 * 30 days. By default, ListOperations will only return in progress and failed
 * operations. To list completed operation, issue a ListOperations request with
 * the filter `done: true`.
 *
 * Operations are created by service `FirestoreAdmin`, but are accessed via
 * service `google.longrunning.Operations`.
 */
class FirestoreAdminGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a composite index. This returns a [google.longrunning.Operation][google.longrunning.Operation]
     * which may be used to track the status of the creation. The metadata for
     * the operation will be the type [IndexOperationMetadata][google.firestore.admin.v1.IndexOperationMetadata].
     * @param \Google\Cloud\Firestore\Admin\V1\CreateIndexRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateIndex(\Google\Cloud\Firestore\Admin\V1\CreateIndexRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.firestore.admin.v1.FirestoreAdmin/CreateIndex',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists composite indexes.
     * @param \Google\Cloud\Firestore\Admin\V1\ListIndexesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListIndexes(\Google\Cloud\Firestore\Admin\V1\ListIndexesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.firestore.admin.v1.FirestoreAdmin/ListIndexes',
        $argument,
        ['\Google\Cloud\Firestore\Admin\V1\ListIndexesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a composite index.
     * @param \Google\Cloud\Firestore\Admin\V1\GetIndexRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIndex(\Google\Cloud\Firestore\Admin\V1\GetIndexRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.firestore.admin.v1.FirestoreAdmin/GetIndex',
        $argument,
        ['\Google\Cloud\Firestore\Admin\V1\Index', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a composite index.
     * @param \Google\Cloud\Firestore\Admin\V1\DeleteIndexRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteIndex(\Google\Cloud\Firestore\Admin\V1\DeleteIndexRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.firestore.admin.v1.FirestoreAdmin/DeleteIndex',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the metadata and configuration for a Field.
     * @param \Google\Cloud\Firestore\Admin\V1\GetFieldRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetField(\Google\Cloud\Firestore\Admin\V1\GetFieldRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.firestore.admin.v1.FirestoreAdmin/GetField',
        $argument,
        ['\Google\Cloud\Firestore\Admin\V1\Field', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a field configuration. Currently, field updates apply only to
     * single field index configuration. However, calls to
     * [FirestoreAdmin.UpdateField][google.firestore.admin.v1.FirestoreAdmin.UpdateField] should provide a field mask to avoid
     * changing any configuration that the caller isn't aware of. The field mask
     * should be specified as: `{ paths: "index_config" }`.
     *
     * This call returns a [google.longrunning.Operation][google.longrunning.Operation] which may be used to
     * track the status of the field update. The metadata for
     * the operation will be the type [FieldOperationMetadata][google.firestore.admin.v1.FieldOperationMetadata].
     *
     * To configure the default field settings for the database, use
     * the special `Field` with resource name:
     * `projects/{project_id}/databases/{database_id}/collectionGroups/__default__/fields/*`.
     * @param \Google\Cloud\Firestore\Admin\V1\UpdateFieldRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateField(\Google\Cloud\Firestore\Admin\V1\UpdateFieldRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.firestore.admin.v1.FirestoreAdmin/UpdateField',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the field configuration and metadata for this database.
     *
     * Currently, [FirestoreAdmin.ListFields][google.firestore.admin.v1.FirestoreAdmin.ListFields] only supports listing fields
     * that have been explicitly overridden. To issue this query, call
     * [FirestoreAdmin.ListFields][google.firestore.admin.v1.FirestoreAdmin.ListFields] with the filter set to
     * `indexConfig.usesAncestorConfig:false` .
     * @param \Google\Cloud\Firestore\Admin\V1\ListFieldsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListFields(\Google\Cloud\Firestore\Admin\V1\ListFieldsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.firestore.admin.v1.FirestoreAdmin/ListFields',
        $argument,
        ['\Google\Cloud\Firestore\Admin\V1\ListFieldsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Exports a copy of all or a subset of documents from Google Cloud Firestore
     * to another storage system, such as Google Cloud Storage. Recent updates to
     * documents may not be reflected in the export. The export occurs in the
     * background and its progress can be monitored and managed via the
     * Operation resource that is created. The output of an export may only be
     * used once the associated operation is done. If an export operation is
     * cancelled before completion it may leave partial data behind in Google
     * Cloud Storage.
     *
     * For more details on export behavior and output format, refer to:
     * https://cloud.google.com/firestore/docs/manage-data/export-import
     * @param \Google\Cloud\Firestore\Admin\V1\ExportDocumentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ExportDocuments(\Google\Cloud\Firestore\Admin\V1\ExportDocumentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.firestore.admin.v1.FirestoreAdmin/ExportDocuments',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Imports documents into Google Cloud Firestore. Existing documents with the
     * same name are overwritten. The import occurs in the background and its
     * progress can be monitored and managed via the Operation resource that is
     * created. If an ImportDocuments operation is cancelled, it is possible
     * that a subset of the data has already been imported to Cloud Firestore.
     * @param \Google\Cloud\Firestore\Admin\V1\ImportDocumentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ImportDocuments(\Google\Cloud\Firestore\Admin\V1\ImportDocumentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.firestore.admin.v1.FirestoreAdmin/ImportDocuments',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets information about a database.
     * @param \Google\Cloud\Firestore\Admin\V1\GetDatabaseRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDatabase(\Google\Cloud\Firestore\Admin\V1\GetDatabaseRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.firestore.admin.v1.FirestoreAdmin/GetDatabase',
        $argument,
        ['\Google\Cloud\Firestore\Admin\V1\Database', 'decode'],
        $metadata, $options);
    }

    /**
     * List all the databases in the project.
     * @param \Google\Cloud\Firestore\Admin\V1\ListDatabasesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDatabases(\Google\Cloud\Firestore\Admin\V1\ListDatabasesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.firestore.admin.v1.FirestoreAdmin/ListDatabases',
        $argument,
        ['\Google\Cloud\Firestore\Admin\V1\ListDatabasesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a database.
     * @param \Google\Cloud\Firestore\Admin\V1\UpdateDatabaseRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateDatabase(\Google\Cloud\Firestore\Admin\V1\UpdateDatabaseRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.firestore.admin.v1.FirestoreAdmin/UpdateDatabase',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
