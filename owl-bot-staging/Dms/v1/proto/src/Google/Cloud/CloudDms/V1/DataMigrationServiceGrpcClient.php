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
     * Retrieve a list of all connection profiles in a given project and location.
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

}
