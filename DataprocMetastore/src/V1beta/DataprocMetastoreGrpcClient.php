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
namespace Google\Cloud\Metastore\V1beta;

/**
 * Configures and manages metastore services.
 * Metastore services are fully managed, highly available, autoscaled,
 * autohealing, OSS-native deployments of technical metadata management
 * software. Each metastore service exposes a network endpoint through which
 * metadata queries are served. Metadata queries can originate from a variety
 * of sources, including Apache Hive, Apache Presto, and Apache Spark.
 *
 * The Dataproc Metastore API defines the following resource model:
 *
 * * The service works with a collection of Google Cloud projects, named:
 * `/projects/*`
 * * Each project has a collection of available locations, named: `/locations/*`
 *   (a location must refer to a Google Cloud `region`)
 * * Each location has a collection of services, named: `/services/*`
 * * Dataproc Metastore services are resources with names of the form:
 *
 *   `/projects/{project_number}/locations/{location_id}/services/{service_id}`.
 */
class DataprocMetastoreGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists services in a project and location.
     * @param \Google\Cloud\Metastore\V1beta\ListServicesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListServices(\Google\Cloud\Metastore\V1beta\ListServicesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1beta.DataprocMetastore/ListServices',
        $argument,
        ['\Google\Cloud\Metastore\V1beta\ListServicesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the details of a single service.
     * @param \Google\Cloud\Metastore\V1beta\GetServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetService(\Google\Cloud\Metastore\V1beta\GetServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1beta.DataprocMetastore/GetService',
        $argument,
        ['\Google\Cloud\Metastore\V1beta\Service', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a metastore service in a project and location.
     * @param \Google\Cloud\Metastore\V1beta\CreateServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateService(\Google\Cloud\Metastore\V1beta\CreateServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1beta.DataprocMetastore/CreateService',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single service.
     * @param \Google\Cloud\Metastore\V1beta\UpdateServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateService(\Google\Cloud\Metastore\V1beta\UpdateServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1beta.DataprocMetastore/UpdateService',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single service.
     * @param \Google\Cloud\Metastore\V1beta\DeleteServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteService(\Google\Cloud\Metastore\V1beta\DeleteServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1beta.DataprocMetastore/DeleteService',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists imports in a service.
     * @param \Google\Cloud\Metastore\V1beta\ListMetadataImportsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListMetadataImports(\Google\Cloud\Metastore\V1beta\ListMetadataImportsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1beta.DataprocMetastore/ListMetadataImports',
        $argument,
        ['\Google\Cloud\Metastore\V1beta\ListMetadataImportsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single import.
     * @param \Google\Cloud\Metastore\V1beta\GetMetadataImportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetMetadataImport(\Google\Cloud\Metastore\V1beta\GetMetadataImportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1beta.DataprocMetastore/GetMetadataImport',
        $argument,
        ['\Google\Cloud\Metastore\V1beta\MetadataImport', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new MetadataImport in a given project and location.
     * @param \Google\Cloud\Metastore\V1beta\CreateMetadataImportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateMetadataImport(\Google\Cloud\Metastore\V1beta\CreateMetadataImportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1beta.DataprocMetastore/CreateMetadataImport',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a single import.
     * Only the description field of MetadataImport is supported to be updated.
     * @param \Google\Cloud\Metastore\V1beta\UpdateMetadataImportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateMetadataImport(\Google\Cloud\Metastore\V1beta\UpdateMetadataImportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1beta.DataprocMetastore/UpdateMetadataImport',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Exports metadata from a service.
     * @param \Google\Cloud\Metastore\V1beta\ExportMetadataRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ExportMetadata(\Google\Cloud\Metastore\V1beta\ExportMetadataRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1beta.DataprocMetastore/ExportMetadata',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Restores a service from a backup.
     * @param \Google\Cloud\Metastore\V1beta\RestoreServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RestoreService(\Google\Cloud\Metastore\V1beta\RestoreServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1beta.DataprocMetastore/RestoreService',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists backups in a service.
     * @param \Google\Cloud\Metastore\V1beta\ListBackupsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListBackups(\Google\Cloud\Metastore\V1beta\ListBackupsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1beta.DataprocMetastore/ListBackups',
        $argument,
        ['\Google\Cloud\Metastore\V1beta\ListBackupsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single backup.
     * @param \Google\Cloud\Metastore\V1beta\GetBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetBackup(\Google\Cloud\Metastore\V1beta\GetBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1beta.DataprocMetastore/GetBackup',
        $argument,
        ['\Google\Cloud\Metastore\V1beta\Backup', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new backup in a given project and location.
     * @param \Google\Cloud\Metastore\V1beta\CreateBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateBackup(\Google\Cloud\Metastore\V1beta\CreateBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1beta.DataprocMetastore/CreateBackup',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single backup.
     * @param \Google\Cloud\Metastore\V1beta\DeleteBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteBackup(\Google\Cloud\Metastore\V1beta\DeleteBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1beta.DataprocMetastore/DeleteBackup',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
