<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2020 Google LLC
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
namespace Google\Cloud\Bigtable\Admin\V2;

/**
 * Service for creating, configuring, and deleting Cloud Bigtable tables.
 *
 *
 * Provides access to the table schemas only, not the data stored within
 * the tables.
 */
class BigtableTableAdminGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new table in the specified instance.
     * The table can be created with a full set of initial column families,
     * specified in the request.
     * @param \Google\Cloud\Bigtable\Admin\V2\CreateTableRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTable(\Google\Cloud\Bigtable\Admin\V2\CreateTableRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/CreateTable',
        $argument,
        ['\Google\Cloud\Bigtable\Admin\V2\Table', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new table from the specified snapshot. The target table must
     * not exist. The snapshot and the table must be in the same instance.
     *
     * Note: This is a private alpha release of Cloud Bigtable snapshots. This
     * feature is not currently available to most Cloud Bigtable customers. This
     * feature might be changed in backward-incompatible ways and is not
     * recommended for production use. It is not subject to any SLA or deprecation
     * policy.
     * @param \Google\Cloud\Bigtable\Admin\V2\CreateTableFromSnapshotRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTableFromSnapshot(\Google\Cloud\Bigtable\Admin\V2\CreateTableFromSnapshotRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/CreateTableFromSnapshot',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all tables served from a specified instance.
     * @param \Google\Cloud\Bigtable\Admin\V2\ListTablesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTables(\Google\Cloud\Bigtable\Admin\V2\ListTablesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/ListTables',
        $argument,
        ['\Google\Cloud\Bigtable\Admin\V2\ListTablesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets metadata information about the specified table.
     * @param \Google\Cloud\Bigtable\Admin\V2\GetTableRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTable(\Google\Cloud\Bigtable\Admin\V2\GetTableRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/GetTable',
        $argument,
        ['\Google\Cloud\Bigtable\Admin\V2\Table', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a specified table.
     * @param \Google\Cloud\Bigtable\Admin\V2\UpdateTableRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateTable(\Google\Cloud\Bigtable\Admin\V2\UpdateTableRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/UpdateTable',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Permanently deletes a specified table and all of its data.
     * @param \Google\Cloud\Bigtable\Admin\V2\DeleteTableRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTable(\Google\Cloud\Bigtable\Admin\V2\DeleteTableRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/DeleteTable',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Restores a specified table which was accidentally deleted.
     * @param \Google\Cloud\Bigtable\Admin\V2\UndeleteTableRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UndeleteTable(\Google\Cloud\Bigtable\Admin\V2\UndeleteTableRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/UndeleteTable',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Performs a series of column family modifications on the specified table.
     * Either all or none of the modifications will occur before this method
     * returns, but data requests received prior to that point may see a table
     * where only some modifications have taken effect.
     * @param \Google\Cloud\Bigtable\Admin\V2\ModifyColumnFamiliesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ModifyColumnFamilies(\Google\Cloud\Bigtable\Admin\V2\ModifyColumnFamiliesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/ModifyColumnFamilies',
        $argument,
        ['\Google\Cloud\Bigtable\Admin\V2\Table', 'decode'],
        $metadata, $options);
    }

    /**
     * Permanently drop/delete a row range from a specified table. The request can
     * specify whether to delete all rows in a table, or only those that match a
     * particular prefix.
     * @param \Google\Cloud\Bigtable\Admin\V2\DropRowRangeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DropRowRange(\Google\Cloud\Bigtable\Admin\V2\DropRowRangeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/DropRowRange',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Generates a consistency token for a Table, which can be used in
     * CheckConsistency to check whether mutations to the table that finished
     * before this call started have been replicated. The tokens will be available
     * for 90 days.
     * @param \Google\Cloud\Bigtable\Admin\V2\GenerateConsistencyTokenRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GenerateConsistencyToken(\Google\Cloud\Bigtable\Admin\V2\GenerateConsistencyTokenRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/GenerateConsistencyToken',
        $argument,
        ['\Google\Cloud\Bigtable\Admin\V2\GenerateConsistencyTokenResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Checks replication consistency based on a consistency token, that is, if
     * replication has caught up based on the conditions specified in the token
     * and the check request.
     * @param \Google\Cloud\Bigtable\Admin\V2\CheckConsistencyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CheckConsistency(\Google\Cloud\Bigtable\Admin\V2\CheckConsistencyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/CheckConsistency',
        $argument,
        ['\Google\Cloud\Bigtable\Admin\V2\CheckConsistencyResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new snapshot in the specified cluster from the specified
     * source table. The cluster and the table must be in the same instance.
     *
     * Note: This is a private alpha release of Cloud Bigtable snapshots. This
     * feature is not currently available to most Cloud Bigtable customers. This
     * feature might be changed in backward-incompatible ways and is not
     * recommended for production use. It is not subject to any SLA or deprecation
     * policy.
     * @param \Google\Cloud\Bigtable\Admin\V2\SnapshotTableRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SnapshotTable(\Google\Cloud\Bigtable\Admin\V2\SnapshotTableRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/SnapshotTable',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets metadata information about the specified snapshot.
     *
     * Note: This is a private alpha release of Cloud Bigtable snapshots. This
     * feature is not currently available to most Cloud Bigtable customers. This
     * feature might be changed in backward-incompatible ways and is not
     * recommended for production use. It is not subject to any SLA or deprecation
     * policy.
     * @param \Google\Cloud\Bigtable\Admin\V2\GetSnapshotRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSnapshot(\Google\Cloud\Bigtable\Admin\V2\GetSnapshotRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/GetSnapshot',
        $argument,
        ['\Google\Cloud\Bigtable\Admin\V2\Snapshot', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all snapshots associated with the specified cluster.
     *
     * Note: This is a private alpha release of Cloud Bigtable snapshots. This
     * feature is not currently available to most Cloud Bigtable customers. This
     * feature might be changed in backward-incompatible ways and is not
     * recommended for production use. It is not subject to any SLA or deprecation
     * policy.
     * @param \Google\Cloud\Bigtable\Admin\V2\ListSnapshotsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListSnapshots(\Google\Cloud\Bigtable\Admin\V2\ListSnapshotsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/ListSnapshots',
        $argument,
        ['\Google\Cloud\Bigtable\Admin\V2\ListSnapshotsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Permanently deletes the specified snapshot.
     *
     * Note: This is a private alpha release of Cloud Bigtable snapshots. This
     * feature is not currently available to most Cloud Bigtable customers. This
     * feature might be changed in backward-incompatible ways and is not
     * recommended for production use. It is not subject to any SLA or deprecation
     * policy.
     * @param \Google\Cloud\Bigtable\Admin\V2\DeleteSnapshotRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteSnapshot(\Google\Cloud\Bigtable\Admin\V2\DeleteSnapshotRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/DeleteSnapshot',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Starts creating a new Cloud Bigtable Backup.  The returned backup
     * [long-running operation][google.longrunning.Operation] can be used to
     * track creation of the backup. The
     * [metadata][google.longrunning.Operation.metadata] field type is
     * [CreateBackupMetadata][google.bigtable.admin.v2.CreateBackupMetadata]. The
     * [response][google.longrunning.Operation.response] field type is
     * [Backup][google.bigtable.admin.v2.Backup], if successful. Cancelling the returned operation will stop the
     * creation and delete the backup.
     * @param \Google\Cloud\Bigtable\Admin\V2\CreateBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateBackup(\Google\Cloud\Bigtable\Admin\V2\CreateBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/CreateBackup',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets metadata on a pending or completed Cloud Bigtable Backup.
     * @param \Google\Cloud\Bigtable\Admin\V2\GetBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetBackup(\Google\Cloud\Bigtable\Admin\V2\GetBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/GetBackup',
        $argument,
        ['\Google\Cloud\Bigtable\Admin\V2\Backup', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a pending or completed Cloud Bigtable Backup.
     * @param \Google\Cloud\Bigtable\Admin\V2\UpdateBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateBackup(\Google\Cloud\Bigtable\Admin\V2\UpdateBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/UpdateBackup',
        $argument,
        ['\Google\Cloud\Bigtable\Admin\V2\Backup', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a pending or completed Cloud Bigtable backup.
     * @param \Google\Cloud\Bigtable\Admin\V2\DeleteBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteBackup(\Google\Cloud\Bigtable\Admin\V2\DeleteBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/DeleteBackup',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Cloud Bigtable backups. Returns both completed and pending
     * backups.
     * @param \Google\Cloud\Bigtable\Admin\V2\ListBackupsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListBackups(\Google\Cloud\Bigtable\Admin\V2\ListBackupsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/ListBackups',
        $argument,
        ['\Google\Cloud\Bigtable\Admin\V2\ListBackupsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a new table by restoring from a completed backup. The new table
     * must be in the same project as the instance containing the backup.  The
     * returned table [long-running operation][google.longrunning.Operation] can
     * be used to track the progress of the operation, and to cancel it.  The
     * [metadata][google.longrunning.Operation.metadata] field type is
     * [RestoreTableMetadata][google.bigtable.admin.RestoreTableMetadata].  The
     * [response][google.longrunning.Operation.response] type is
     * [Table][google.bigtable.admin.v2.Table], if successful.
     * @param \Google\Cloud\Bigtable\Admin\V2\RestoreTableRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RestoreTable(\Google\Cloud\Bigtable\Admin\V2\RestoreTableRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/RestoreTable',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the access control policy for a Table or Backup resource.
     * Returns an empty policy if the resource exists but does not have a policy
     * set.
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the access control policy on a Table or Backup resource.
     * Replaces any existing policy.
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns permissions that the caller has on the specified Table or Backup resource.
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.bigtable.admin.v2.BigtableTableAdmin/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

}
