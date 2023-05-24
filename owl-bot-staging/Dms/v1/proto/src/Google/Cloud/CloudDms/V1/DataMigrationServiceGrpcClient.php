<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2023 Google LLC
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
namespace Google\Cloud\CloudDms\V1;

/**
 * Database Migration service
 */
class DataMigrationServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists migration jobs in a given project and location.
     * @param \Google\Cloud\CloudDms\V1\ListMigrationJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListMigrationJobs(\Google\Cloud\CloudDms\V1\ListMigrationJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/ListMigrationJobs',
        $argument,
        ['\Google\Cloud\CloudDms\V1\ListMigrationJobsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single migration job.
     * @param \Google\Cloud\CloudDms\V1\GetMigrationJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetMigrationJob(\Google\Cloud\CloudDms\V1\GetMigrationJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/GetMigrationJob',
        $argument,
        ['\Google\Cloud\CloudDms\V1\MigrationJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new migration job in a given project and location.
     * @param \Google\Cloud\CloudDms\V1\CreateMigrationJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateMigrationJob(\Google\Cloud\CloudDms\V1\CreateMigrationJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/CreateMigrationJob',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single migration job.
     * @param \Google\Cloud\CloudDms\V1\UpdateMigrationJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateMigrationJob(\Google\Cloud\CloudDms\V1\UpdateMigrationJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/UpdateMigrationJob',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single migration job.
     * @param \Google\Cloud\CloudDms\V1\DeleteMigrationJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteMigrationJob(\Google\Cloud\CloudDms\V1\DeleteMigrationJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/DeleteMigrationJob',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Start an already created migration job.
     * @param \Google\Cloud\CloudDms\V1\StartMigrationJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StartMigrationJob(\Google\Cloud\CloudDms\V1\StartMigrationJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/StartMigrationJob',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Stops a running migration job.
     * @param \Google\Cloud\CloudDms\V1\StopMigrationJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StopMigrationJob(\Google\Cloud\CloudDms\V1\StopMigrationJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/StopMigrationJob',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Resume a migration job that is currently stopped and is resumable (was
     * stopped during CDC phase).
     * @param \Google\Cloud\CloudDms\V1\ResumeMigrationJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResumeMigrationJob(\Google\Cloud\CloudDms\V1\ResumeMigrationJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/ResumeMigrationJob',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Promote a migration job, stopping replication to the destination and
     * promoting the destination to be a standalone database.
     * @param \Google\Cloud\CloudDms\V1\PromoteMigrationJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PromoteMigrationJob(\Google\Cloud\CloudDms\V1\PromoteMigrationJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/PromoteMigrationJob',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Verify a migration job, making sure the destination can reach the source
     * and that all configuration and prerequisites are met.
     * @param \Google\Cloud\CloudDms\V1\VerifyMigrationJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function VerifyMigrationJob(\Google\Cloud\CloudDms\V1\VerifyMigrationJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/VerifyMigrationJob',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Restart a stopped or failed migration job, resetting the destination
     * instance to its original state and starting the migration process from
     * scratch.
     * @param \Google\Cloud\CloudDms\V1\RestartMigrationJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RestartMigrationJob(\Google\Cloud\CloudDms\V1\RestartMigrationJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/RestartMigrationJob',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Generate a SSH configuration script to configure the reverse SSH
     * connectivity.
     * @param \Google\Cloud\CloudDms\V1\GenerateSshScriptRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GenerateSshScript(\Google\Cloud\CloudDms\V1\GenerateSshScriptRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/GenerateSshScript',
        $argument,
        ['\Google\Cloud\CloudDms\V1\SshScript', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a list of all connection profiles in a given project and
     * location.
     * @param \Google\Cloud\CloudDms\V1\ListConnectionProfilesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListConnectionProfiles(\Google\Cloud\CloudDms\V1\ListConnectionProfilesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/ListConnectionProfiles',
        $argument,
        ['\Google\Cloud\CloudDms\V1\ListConnectionProfilesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single connection profile.
     * @param \Google\Cloud\CloudDms\V1\GetConnectionProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetConnectionProfile(\Google\Cloud\CloudDms\V1\GetConnectionProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/GetConnectionProfile',
        $argument,
        ['\Google\Cloud\CloudDms\V1\ConnectionProfile', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new connection profile in a given project and location.
     * @param \Google\Cloud\CloudDms\V1\CreateConnectionProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateConnectionProfile(\Google\Cloud\CloudDms\V1\CreateConnectionProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/CreateConnectionProfile',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Update the configuration of a single connection profile.
     * @param \Google\Cloud\CloudDms\V1\UpdateConnectionProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateConnectionProfile(\Google\Cloud\CloudDms\V1\UpdateConnectionProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/UpdateConnectionProfile',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single Database Migration Service connection profile.
     * A connection profile can only be deleted if it is not in use by any
     * active migration jobs.
     * @param \Google\Cloud\CloudDms\V1\DeleteConnectionProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteConnectionProfile(\Google\Cloud\CloudDms\V1\DeleteConnectionProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/DeleteConnectionProfile',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new private connection in a given project and location.
     * @param \Google\Cloud\CloudDms\V1\CreatePrivateConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreatePrivateConnection(\Google\Cloud\CloudDms\V1\CreatePrivateConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/CreatePrivateConnection',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single private connection.
     * @param \Google\Cloud\CloudDms\V1\GetPrivateConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetPrivateConnection(\Google\Cloud\CloudDms\V1\GetPrivateConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/GetPrivateConnection',
        $argument,
        ['\Google\Cloud\CloudDms\V1\PrivateConnection', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a list of private connections in a given project and location.
     * @param \Google\Cloud\CloudDms\V1\ListPrivateConnectionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListPrivateConnections(\Google\Cloud\CloudDms\V1\ListPrivateConnectionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/ListPrivateConnections',
        $argument,
        ['\Google\Cloud\CloudDms\V1\ListPrivateConnectionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single Database Migration Service private connection.
     * @param \Google\Cloud\CloudDms\V1\DeletePrivateConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeletePrivateConnection(\Google\Cloud\CloudDms\V1\DeletePrivateConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/DeletePrivateConnection',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single conversion workspace.
     * @param \Google\Cloud\CloudDms\V1\GetConversionWorkspaceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetConversionWorkspace(\Google\Cloud\CloudDms\V1\GetConversionWorkspaceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/GetConversionWorkspace',
        $argument,
        ['\Google\Cloud\CloudDms\V1\ConversionWorkspace', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists conversion workspaces in a given project and location.
     * @param \Google\Cloud\CloudDms\V1\ListConversionWorkspacesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListConversionWorkspaces(\Google\Cloud\CloudDms\V1\ListConversionWorkspacesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/ListConversionWorkspaces',
        $argument,
        ['\Google\Cloud\CloudDms\V1\ListConversionWorkspacesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new conversion workspace in a given project and location.
     * @param \Google\Cloud\CloudDms\V1\CreateConversionWorkspaceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateConversionWorkspace(\Google\Cloud\CloudDms\V1\CreateConversionWorkspaceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/CreateConversionWorkspace',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single conversion workspace.
     * @param \Google\Cloud\CloudDms\V1\UpdateConversionWorkspaceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateConversionWorkspace(\Google\Cloud\CloudDms\V1\UpdateConversionWorkspaceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/UpdateConversionWorkspace',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single conversion workspace.
     * @param \Google\Cloud\CloudDms\V1\DeleteConversionWorkspaceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteConversionWorkspace(\Google\Cloud\CloudDms\V1\DeleteConversionWorkspaceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/DeleteConversionWorkspace',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Imports a snapshot of the source database into the
     * conversion workspace.
     * @param \Google\Cloud\CloudDms\V1\SeedConversionWorkspaceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SeedConversionWorkspace(\Google\Cloud\CloudDms\V1\SeedConversionWorkspaceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/SeedConversionWorkspace',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Imports the mapping rules for a given conversion workspace.
     * Supports various formats of external rules files.
     * @param \Google\Cloud\CloudDms\V1\ImportMappingRulesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ImportMappingRules(\Google\Cloud\CloudDms\V1\ImportMappingRulesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/ImportMappingRules',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a draft tree schema for the destination database.
     * @param \Google\Cloud\CloudDms\V1\ConvertConversionWorkspaceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ConvertConversionWorkspace(\Google\Cloud\CloudDms\V1\ConvertConversionWorkspaceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/ConvertConversionWorkspace',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Marks all the data in the conversion workspace as committed.
     * @param \Google\Cloud\CloudDms\V1\CommitConversionWorkspaceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CommitConversionWorkspace(\Google\Cloud\CloudDms\V1\CommitConversionWorkspaceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/CommitConversionWorkspace',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Rolls back a conversion workspace to the last committed snapshot.
     * @param \Google\Cloud\CloudDms\V1\RollbackConversionWorkspaceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RollbackConversionWorkspace(\Google\Cloud\CloudDms\V1\RollbackConversionWorkspaceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/RollbackConversionWorkspace',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Applies draft tree onto a specific destination database.
     * @param \Google\Cloud\CloudDms\V1\ApplyConversionWorkspaceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ApplyConversionWorkspace(\Google\Cloud\CloudDms\V1\ApplyConversionWorkspaceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/ApplyConversionWorkspace',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Describes the database entities tree for a specific conversion workspace
     * and a specific tree type.
     *
     * Database entities are not resources like conversion workspaces or mapping
     * rules, and they can't be created, updated or deleted. Instead, they are
     * simple data objects describing the structure of the client database.
     * @param \Google\Cloud\CloudDms\V1\DescribeDatabaseEntitiesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DescribeDatabaseEntities(\Google\Cloud\CloudDms\V1\DescribeDatabaseEntitiesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/DescribeDatabaseEntities',
        $argument,
        ['\Google\Cloud\CloudDms\V1\DescribeDatabaseEntitiesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Searches/lists the background jobs for a specific
     * conversion workspace.
     *
     * The background jobs are not resources like conversion workspaces or
     * mapping rules, and they can't be created, updated or deleted.
     * Instead, they are a way to expose the data plane jobs log.
     * @param \Google\Cloud\CloudDms\V1\SearchBackgroundJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchBackgroundJobs(\Google\Cloud\CloudDms\V1\SearchBackgroundJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/SearchBackgroundJobs',
        $argument,
        ['\Google\Cloud\CloudDms\V1\SearchBackgroundJobsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a list of committed revisions of a specific conversion
     * workspace.
     * @param \Google\Cloud\CloudDms\V1\DescribeConversionWorkspaceRevisionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DescribeConversionWorkspaceRevisions(\Google\Cloud\CloudDms\V1\DescribeConversionWorkspaceRevisionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/DescribeConversionWorkspaceRevisions',
        $argument,
        ['\Google\Cloud\CloudDms\V1\DescribeConversionWorkspaceRevisionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Fetches a set of static IP addresses that need to be allowlisted by the
     * customer when using the static-IP connectivity method.
     * @param \Google\Cloud\CloudDms\V1\FetchStaticIpsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function FetchStaticIps(\Google\Cloud\CloudDms\V1\FetchStaticIpsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.clouddms.v1.DataMigrationService/FetchStaticIps',
        $argument,
        ['\Google\Cloud\CloudDms\V1\FetchStaticIpsResponse', 'decode'],
        $metadata, $options);
    }

}
