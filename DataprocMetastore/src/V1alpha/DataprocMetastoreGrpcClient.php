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
namespace Google\Cloud\Metastore\V1alpha;

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
     * @param \Google\Cloud\Metastore\V1alpha\ListServicesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListServices(\Google\Cloud\Metastore\V1alpha\ListServicesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1alpha.DataprocMetastore/ListServices',
        $argument,
        ['\Google\Cloud\Metastore\V1alpha\ListServicesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the details of a single service.
     * @param \Google\Cloud\Metastore\V1alpha\GetServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetService(\Google\Cloud\Metastore\V1alpha\GetServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1alpha.DataprocMetastore/GetService',
        $argument,
        ['\Google\Cloud\Metastore\V1alpha\Service', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a metastore service in a project and location.
     * @param \Google\Cloud\Metastore\V1alpha\CreateServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateService(\Google\Cloud\Metastore\V1alpha\CreateServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1alpha.DataprocMetastore/CreateService',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single service.
     * @param \Google\Cloud\Metastore\V1alpha\UpdateServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateService(\Google\Cloud\Metastore\V1alpha\UpdateServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1alpha.DataprocMetastore/UpdateService',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single service.
     * @param \Google\Cloud\Metastore\V1alpha\DeleteServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteService(\Google\Cloud\Metastore\V1alpha\DeleteServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1alpha.DataprocMetastore/DeleteService',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists imports in a service.
     * @param \Google\Cloud\Metastore\V1alpha\ListMetadataImportsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListMetadataImports(\Google\Cloud\Metastore\V1alpha\ListMetadataImportsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1alpha.DataprocMetastore/ListMetadataImports',
        $argument,
        ['\Google\Cloud\Metastore\V1alpha\ListMetadataImportsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single import.
     * @param \Google\Cloud\Metastore\V1alpha\GetMetadataImportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetMetadataImport(\Google\Cloud\Metastore\V1alpha\GetMetadataImportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1alpha.DataprocMetastore/GetMetadataImport',
        $argument,
        ['\Google\Cloud\Metastore\V1alpha\MetadataImport', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new MetadataImport in a given project and location.
     * @param \Google\Cloud\Metastore\V1alpha\CreateMetadataImportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateMetadataImport(\Google\Cloud\Metastore\V1alpha\CreateMetadataImportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1alpha.DataprocMetastore/CreateMetadataImport',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a single import.
     * Only the description field of MetadataImport is supported to be updated.
     * @param \Google\Cloud\Metastore\V1alpha\UpdateMetadataImportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateMetadataImport(\Google\Cloud\Metastore\V1alpha\UpdateMetadataImportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1alpha.DataprocMetastore/UpdateMetadataImport',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Exports metadata from a service.
     * @param \Google\Cloud\Metastore\V1alpha\ExportMetadataRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ExportMetadata(\Google\Cloud\Metastore\V1alpha\ExportMetadataRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1alpha.DataprocMetastore/ExportMetadata',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Restores a service from a backup.
     * @param \Google\Cloud\Metastore\V1alpha\RestoreServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RestoreService(\Google\Cloud\Metastore\V1alpha\RestoreServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1alpha.DataprocMetastore/RestoreService',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists backups in a service.
     * @param \Google\Cloud\Metastore\V1alpha\ListBackupsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListBackups(\Google\Cloud\Metastore\V1alpha\ListBackupsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1alpha.DataprocMetastore/ListBackups',
        $argument,
        ['\Google\Cloud\Metastore\V1alpha\ListBackupsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single backup.
     * @param \Google\Cloud\Metastore\V1alpha\GetBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetBackup(\Google\Cloud\Metastore\V1alpha\GetBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1alpha.DataprocMetastore/GetBackup',
        $argument,
        ['\Google\Cloud\Metastore\V1alpha\Backup', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new backup in a given project and location.
     * @param \Google\Cloud\Metastore\V1alpha\CreateBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateBackup(\Google\Cloud\Metastore\V1alpha\CreateBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1alpha.DataprocMetastore/CreateBackup',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single backup.
     * @param \Google\Cloud\Metastore\V1alpha\DeleteBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteBackup(\Google\Cloud\Metastore\V1alpha\DeleteBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1alpha.DataprocMetastore/DeleteBackup',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
