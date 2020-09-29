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
namespace Google\Cloud\Datastore\Admin\V1;

/**
 * Google Cloud Datastore Admin API
 *
 *
 * The Datastore Admin API provides several admin services for Cloud Datastore.
 *
 * -----------------------------------------------------------------------------
 * ## Concepts
 *
 * Project, namespace, kind, and entity as defined in the Google Cloud Datastore
 * API.
 *
 * Operation: An Operation represents work being performed in the background.
 *
 * EntityFilter: Allows specifying a subset of entities in a project. This is
 * specified as a combination of kinds and namespaces (either or both of which
 * may be all).
 *
 * -----------------------------------------------------------------------------
 * ## Services
 *
 * # Export/Import
 *
 * The Export/Import service provides the ability to copy all or a subset of
 * entities to/from Google Cloud Storage.
 *
 * Exported data may be imported into Cloud Datastore for any Google Cloud
 * Platform project. It is not restricted to the export source project. It is
 * possible to export from one project and then import into another.
 *
 * Exported data can also be loaded into Google BigQuery for analysis.
 *
 * Exports and imports are performed asynchronously. An Operation resource is
 * created for each export/import. The state (including any errors encountered)
 * of the export/import may be queried via the Operation resource.
 *
 * # Index
 *
 * The index service manages Cloud Datastore composite indexes.
 *
 * Index creation and deletion are performed asynchronously.
 * An Operation resource is created for each such asynchronous operation.
 * The state of the operation (including any errors encountered)
 * may be queried via the Operation resource.
 *
 * # Operation
 *
 * The Operations collection provides a record of actions performed for the
 * specified project (including any operations in progress). Operations are not
 * created directly but through calls on other collections or resources.
 *
 * An operation that is not yet done may be cancelled. The request to cancel is
 * asynchronous and the operation may continue to run for some time after the
 * request to cancel is made.
 *
 * An operation that is done may be deleted so that it is no longer listed as
 * part of the Operation collection.
 *
 * ListOperations returns all pending operations, but not completed operations.
 *
 * Operations are created by service DatastoreAdmin,
 * but are accessed via service google.longrunning.Operations.
 */
class DatastoreAdminGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Exports a copy of all or a subset of entities from Google Cloud Datastore
     * to another storage system, such as Google Cloud Storage. Recent updates to
     * entities may not be reflected in the export. The export occurs in the
     * background and its progress can be monitored and managed via the
     * Operation resource that is created. The output of an export may only be
     * used once the associated operation is done. If an export operation is
     * cancelled before completion it may leave partial data behind in Google
     * Cloud Storage.
     * @param \Google\Cloud\Datastore\Admin\V1\ExportEntitiesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Google\LongRunning\Operation
     */
    public function ExportEntities(\Google\Cloud\Datastore\Admin\V1\ExportEntitiesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.datastore.admin.v1.DatastoreAdmin/ExportEntities',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Imports entities into Google Cloud Datastore. Existing entities with the
     * same key are overwritten. The import occurs in the background and its
     * progress can be monitored and managed via the Operation resource that is
     * created. If an ImportEntities operation is cancelled, it is possible
     * that a subset of the data has already been imported to Cloud Datastore.
     * @param \Google\Cloud\Datastore\Admin\V1\ImportEntitiesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Google\LongRunning\Operation
     */
    public function ImportEntities(\Google\Cloud\Datastore\Admin\V1\ImportEntitiesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.datastore.admin.v1.DatastoreAdmin/ImportEntities',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an index.
     * @param \Google\Cloud\Datastore\Admin\V1\GetIndexRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Google\Cloud\Datastore\Admin\V1\Index
     */
    public function GetIndex(\Google\Cloud\Datastore\Admin\V1\GetIndexRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.datastore.admin.v1.DatastoreAdmin/GetIndex',
        $argument,
        ['\Google\Cloud\Datastore\Admin\V1\Index', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the indexes that match the specified filters.  Datastore uses an
     * eventually consistent query to fetch the list of indexes and may
     * occasionally return stale results.
     * @param \Google\Cloud\Datastore\Admin\V1\ListIndexesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Google\Cloud\Datastore\Admin\V1\ListIndexesResponse
     */
    public function ListIndexes(\Google\Cloud\Datastore\Admin\V1\ListIndexesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.datastore.admin.v1.DatastoreAdmin/ListIndexes',
        $argument,
        ['\Google\Cloud\Datastore\Admin\V1\ListIndexesResponse', 'decode'],
        $metadata, $options);
    }

}
