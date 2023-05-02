<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2022 Google LLC
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
namespace Google\Cloud\GkeBackup\V1;

/**
 * BackupForGKE allows Kubernetes administrators to configure, execute, and
 * manage backup and restore operations for their GKE clusters.
 */
class BackupForGKEGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new BackupPlan in a given location.
     * @param \Google\Cloud\GkeBackup\V1\CreateBackupPlanRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateBackupPlan(\Google\Cloud\GkeBackup\V1\CreateBackupPlanRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/CreateBackupPlan',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists BackupPlans in a given location.
     * @param \Google\Cloud\GkeBackup\V1\ListBackupPlansRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListBackupPlans(\Google\Cloud\GkeBackup\V1\ListBackupPlansRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/ListBackupPlans',
        $argument,
        ['\Google\Cloud\GkeBackup\V1\ListBackupPlansResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieve the details of a single BackupPlan.
     * @param \Google\Cloud\GkeBackup\V1\GetBackupPlanRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetBackupPlan(\Google\Cloud\GkeBackup\V1\GetBackupPlanRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/GetBackupPlan',
        $argument,
        ['\Google\Cloud\GkeBackup\V1\BackupPlan', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a BackupPlan.
     * @param \Google\Cloud\GkeBackup\V1\UpdateBackupPlanRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateBackupPlan(\Google\Cloud\GkeBackup\V1\UpdateBackupPlanRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/UpdateBackupPlan',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an existing BackupPlan.
     * @param \Google\Cloud\GkeBackup\V1\DeleteBackupPlanRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteBackupPlan(\Google\Cloud\GkeBackup\V1\DeleteBackupPlanRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/DeleteBackupPlan',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a Backup for the given BackupPlan.
     * @param \Google\Cloud\GkeBackup\V1\CreateBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateBackup(\Google\Cloud\GkeBackup\V1\CreateBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/CreateBackup',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the Backups for a given BackupPlan.
     * @param \Google\Cloud\GkeBackup\V1\ListBackupsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListBackups(\Google\Cloud\GkeBackup\V1\ListBackupsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/ListBackups',
        $argument,
        ['\Google\Cloud\GkeBackup\V1\ListBackupsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieve the details of a single Backup.
     * @param \Google\Cloud\GkeBackup\V1\GetBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetBackup(\Google\Cloud\GkeBackup\V1\GetBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/GetBackup',
        $argument,
        ['\Google\Cloud\GkeBackup\V1\Backup', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a Backup.
     * @param \Google\Cloud\GkeBackup\V1\UpdateBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateBackup(\Google\Cloud\GkeBackup\V1\UpdateBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/UpdateBackup',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an existing Backup.
     * @param \Google\Cloud\GkeBackup\V1\DeleteBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteBackup(\Google\Cloud\GkeBackup\V1\DeleteBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/DeleteBackup',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the VolumeBackups for a given Backup.
     * @param \Google\Cloud\GkeBackup\V1\ListVolumeBackupsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListVolumeBackups(\Google\Cloud\GkeBackup\V1\ListVolumeBackupsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/ListVolumeBackups',
        $argument,
        ['\Google\Cloud\GkeBackup\V1\ListVolumeBackupsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieve the details of a single VolumeBackup.
     * @param \Google\Cloud\GkeBackup\V1\GetVolumeBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetVolumeBackup(\Google\Cloud\GkeBackup\V1\GetVolumeBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/GetVolumeBackup',
        $argument,
        ['\Google\Cloud\GkeBackup\V1\VolumeBackup', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new RestorePlan in a given location.
     * @param \Google\Cloud\GkeBackup\V1\CreateRestorePlanRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateRestorePlan(\Google\Cloud\GkeBackup\V1\CreateRestorePlanRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/CreateRestorePlan',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists RestorePlans in a given location.
     * @param \Google\Cloud\GkeBackup\V1\ListRestorePlansRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListRestorePlans(\Google\Cloud\GkeBackup\V1\ListRestorePlansRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/ListRestorePlans',
        $argument,
        ['\Google\Cloud\GkeBackup\V1\ListRestorePlansResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieve the details of a single RestorePlan.
     * @param \Google\Cloud\GkeBackup\V1\GetRestorePlanRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetRestorePlan(\Google\Cloud\GkeBackup\V1\GetRestorePlanRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/GetRestorePlan',
        $argument,
        ['\Google\Cloud\GkeBackup\V1\RestorePlan', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a RestorePlan.
     * @param \Google\Cloud\GkeBackup\V1\UpdateRestorePlanRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateRestorePlan(\Google\Cloud\GkeBackup\V1\UpdateRestorePlanRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/UpdateRestorePlan',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an existing RestorePlan.
     * @param \Google\Cloud\GkeBackup\V1\DeleteRestorePlanRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteRestorePlan(\Google\Cloud\GkeBackup\V1\DeleteRestorePlanRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/DeleteRestorePlan',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Restore for the given RestorePlan.
     * @param \Google\Cloud\GkeBackup\V1\CreateRestoreRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateRestore(\Google\Cloud\GkeBackup\V1\CreateRestoreRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/CreateRestore',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the Restores for a given RestorePlan.
     * @param \Google\Cloud\GkeBackup\V1\ListRestoresRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListRestores(\Google\Cloud\GkeBackup\V1\ListRestoresRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/ListRestores',
        $argument,
        ['\Google\Cloud\GkeBackup\V1\ListRestoresResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves the details of a single Restore.
     * @param \Google\Cloud\GkeBackup\V1\GetRestoreRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetRestore(\Google\Cloud\GkeBackup\V1\GetRestoreRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/GetRestore',
        $argument,
        ['\Google\Cloud\GkeBackup\V1\Restore', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a Restore.
     * @param \Google\Cloud\GkeBackup\V1\UpdateRestoreRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateRestore(\Google\Cloud\GkeBackup\V1\UpdateRestoreRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/UpdateRestore',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an existing Restore.
     * @param \Google\Cloud\GkeBackup\V1\DeleteRestoreRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteRestore(\Google\Cloud\GkeBackup\V1\DeleteRestoreRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/DeleteRestore',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the VolumeRestores for a given Restore.
     * @param \Google\Cloud\GkeBackup\V1\ListVolumeRestoresRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListVolumeRestores(\Google\Cloud\GkeBackup\V1\ListVolumeRestoresRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/ListVolumeRestores',
        $argument,
        ['\Google\Cloud\GkeBackup\V1\ListVolumeRestoresResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieve the details of a single VolumeRestore.
     * @param \Google\Cloud\GkeBackup\V1\GetVolumeRestoreRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetVolumeRestore(\Google\Cloud\GkeBackup\V1\GetVolumeRestoreRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkebackup.v1.BackupForGKE/GetVolumeRestore',
        $argument,
        ['\Google\Cloud\GkeBackup\V1\VolumeRestore', 'decode'],
        $metadata, $options);
    }

}
