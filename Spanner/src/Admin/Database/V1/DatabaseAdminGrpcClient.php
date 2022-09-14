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
namespace Google\Cloud\Spanner\Admin\Database\V1;

/**
 * Cloud Spanner Database Admin API
 *
 * The Cloud Spanner Database Admin API can be used to:
 *   * create, drop, and list databases
 *   * update the schema of pre-existing databases
 *   * create, delete and list backups for a database
 *   * restore a database from an existing backup
 */
class DatabaseAdminGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists Cloud Spanner databases.
     * @param \Google\Cloud\Spanner\Admin\Database\V1\ListDatabasesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDatabases(\Google\Cloud\Spanner\Admin\Database\V1\ListDatabasesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.admin.database.v1.DatabaseAdmin/ListDatabases',
        $argument,
        ['\Google\Cloud\Spanner\Admin\Database\V1\ListDatabasesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Cloud Spanner database and starts to prepare it for serving.
     * The returned [long-running operation][google.longrunning.Operation] will
     * have a name of the format `<database_name>/operations/<operation_id>` and
     * can be used to track preparation of the database. The
     * [metadata][google.longrunning.Operation.metadata] field type is
     * [CreateDatabaseMetadata][google.spanner.admin.database.v1.CreateDatabaseMetadata]. The
     * [response][google.longrunning.Operation.response] field type is
     * [Database][google.spanner.admin.database.v1.Database], if successful.
     * @param \Google\Cloud\Spanner\Admin\Database\V1\CreateDatabaseRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateDatabase(\Google\Cloud\Spanner\Admin\Database\V1\CreateDatabaseRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.admin.database.v1.DatabaseAdmin/CreateDatabase',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the state of a Cloud Spanner database.
     * @param \Google\Cloud\Spanner\Admin\Database\V1\GetDatabaseRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDatabase(\Google\Cloud\Spanner\Admin\Database\V1\GetDatabaseRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.admin.database.v1.DatabaseAdmin/GetDatabase',
        $argument,
        ['\Google\Cloud\Spanner\Admin\Database\V1\Database', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the schema of a Cloud Spanner database by
     * creating/altering/dropping tables, columns, indexes, etc. The returned
     * [long-running operation][google.longrunning.Operation] will have a name of
     * the format `<database_name>/operations/<operation_id>` and can be used to
     * track execution of the schema change(s). The
     * [metadata][google.longrunning.Operation.metadata] field type is
     * [UpdateDatabaseDdlMetadata][google.spanner.admin.database.v1.UpdateDatabaseDdlMetadata].  The operation has no response.
     * @param \Google\Cloud\Spanner\Admin\Database\V1\UpdateDatabaseDdlRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateDatabaseDdl(\Google\Cloud\Spanner\Admin\Database\V1\UpdateDatabaseDdlRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.admin.database.v1.DatabaseAdmin/UpdateDatabaseDdl',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Drops (aka deletes) a Cloud Spanner database.
     * Completed backups for the database will be retained according to their
     * `expire_time`.
     * Note: Cloud Spanner might continue to accept requests for a few seconds
     * after the database has been deleted.
     * @param \Google\Cloud\Spanner\Admin\Database\V1\DropDatabaseRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DropDatabase(\Google\Cloud\Spanner\Admin\Database\V1\DropDatabaseRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.admin.database.v1.DatabaseAdmin/DropDatabase',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the schema of a Cloud Spanner database as a list of formatted
     * DDL statements. This method does not show pending schema updates, those may
     * be queried using the [Operations][google.longrunning.Operations] API.
     * @param \Google\Cloud\Spanner\Admin\Database\V1\GetDatabaseDdlRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDatabaseDdl(\Google\Cloud\Spanner\Admin\Database\V1\GetDatabaseDdlRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.admin.database.v1.DatabaseAdmin/GetDatabaseDdl',
        $argument,
        ['\Google\Cloud\Spanner\Admin\Database\V1\GetDatabaseDdlResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the access control policy on a database or backup resource.
     * Replaces any existing policy.
     *
     * Authorization requires `spanner.databases.setIamPolicy`
     * permission on [resource][google.iam.v1.SetIamPolicyRequest.resource].
     * For backups, authorization requires `spanner.backups.setIamPolicy`
     * permission on [resource][google.iam.v1.SetIamPolicyRequest.resource].
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.admin.database.v1.DatabaseAdmin/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the access control policy for a database or backup resource.
     * Returns an empty policy if a database or backup exists but does not have a
     * policy set.
     *
     * Authorization requires `spanner.databases.getIamPolicy` permission on
     * [resource][google.iam.v1.GetIamPolicyRequest.resource].
     * For backups, authorization requires `spanner.backups.getIamPolicy`
     * permission on [resource][google.iam.v1.GetIamPolicyRequest.resource].
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.admin.database.v1.DatabaseAdmin/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns permissions that the caller has on the specified database or backup
     * resource.
     *
     * Attempting this RPC on a non-existent Cloud Spanner database will
     * result in a NOT_FOUND error if the user has
     * `spanner.databases.list` permission on the containing Cloud
     * Spanner instance. Otherwise returns an empty set of permissions.
     * Calling this method on a backup that does not exist will
     * result in a NOT_FOUND error if the user has
     * `spanner.backups.list` permission on the containing instance.
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.admin.database.v1.DatabaseAdmin/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Starts creating a new Cloud Spanner Backup.
     * The returned backup [long-running operation][google.longrunning.Operation]
     * will have a name of the format
     * `projects/<project>/instances/<instance>/backups/<backup>/operations/<operation_id>`
     * and can be used to track creation of the backup. The
     * [metadata][google.longrunning.Operation.metadata] field type is
     * [CreateBackupMetadata][google.spanner.admin.database.v1.CreateBackupMetadata]. The
     * [response][google.longrunning.Operation.response] field type is
     * [Backup][google.spanner.admin.database.v1.Backup], if successful. Cancelling the returned operation will stop the
     * creation and delete the backup.
     * There can be only one pending backup creation per database. Backup creation
     * of different databases can run concurrently.
     * @param \Google\Cloud\Spanner\Admin\Database\V1\CreateBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateBackup(\Google\Cloud\Spanner\Admin\Database\V1\CreateBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.admin.database.v1.DatabaseAdmin/CreateBackup',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Starts copying a Cloud Spanner Backup.
     * The returned backup [long-running operation][google.longrunning.Operation]
     * will have a name of the format
     * `projects/<project>/instances/<instance>/backups/<backup>/operations/<operation_id>`
     * and can be used to track copying of the backup. The operation is associated
     * with the destination backup.
     * The [metadata][google.longrunning.Operation.metadata] field type is
     * [CopyBackupMetadata][google.spanner.admin.database.v1.CopyBackupMetadata].
     * The [response][google.longrunning.Operation.response] field type is
     * [Backup][google.spanner.admin.database.v1.Backup], if successful. Cancelling the returned operation will stop the
     * copying and delete the backup.
     * Concurrent CopyBackup requests can run on the same source backup.
     * @param \Google\Cloud\Spanner\Admin\Database\V1\CopyBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CopyBackup(\Google\Cloud\Spanner\Admin\Database\V1\CopyBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.admin.database.v1.DatabaseAdmin/CopyBackup',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets metadata on a pending or completed [Backup][google.spanner.admin.database.v1.Backup].
     * @param \Google\Cloud\Spanner\Admin\Database\V1\GetBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetBackup(\Google\Cloud\Spanner\Admin\Database\V1\GetBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.admin.database.v1.DatabaseAdmin/GetBackup',
        $argument,
        ['\Google\Cloud\Spanner\Admin\Database\V1\Backup', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a pending or completed [Backup][google.spanner.admin.database.v1.Backup].
     * @param \Google\Cloud\Spanner\Admin\Database\V1\UpdateBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateBackup(\Google\Cloud\Spanner\Admin\Database\V1\UpdateBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.admin.database.v1.DatabaseAdmin/UpdateBackup',
        $argument,
        ['\Google\Cloud\Spanner\Admin\Database\V1\Backup', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a pending or completed [Backup][google.spanner.admin.database.v1.Backup].
     * @param \Google\Cloud\Spanner\Admin\Database\V1\DeleteBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteBackup(\Google\Cloud\Spanner\Admin\Database\V1\DeleteBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.admin.database.v1.DatabaseAdmin/DeleteBackup',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists completed and pending backups.
     * Backups returned are ordered by `create_time` in descending order,
     * starting from the most recent `create_time`.
     * @param \Google\Cloud\Spanner\Admin\Database\V1\ListBackupsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListBackups(\Google\Cloud\Spanner\Admin\Database\V1\ListBackupsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.admin.database.v1.DatabaseAdmin/ListBackups',
        $argument,
        ['\Google\Cloud\Spanner\Admin\Database\V1\ListBackupsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a new database by restoring from a completed backup. The new
     * database must be in the same project and in an instance with the same
     * instance configuration as the instance containing
     * the backup. The returned database [long-running
     * operation][google.longrunning.Operation] has a name of the format
     * `projects/<project>/instances/<instance>/databases/<database>/operations/<operation_id>`,
     * and can be used to track the progress of the operation, and to cancel it.
     * The [metadata][google.longrunning.Operation.metadata] field type is
     * [RestoreDatabaseMetadata][google.spanner.admin.database.v1.RestoreDatabaseMetadata].
     * The [response][google.longrunning.Operation.response] type
     * is [Database][google.spanner.admin.database.v1.Database], if
     * successful. Cancelling the returned operation will stop the restore and
     * delete the database.
     * There can be only one database being restored into an instance at a time.
     * Once the restore operation completes, a new restore operation can be
     * initiated, without waiting for the optimize operation associated with the
     * first restore to complete.
     * @param \Google\Cloud\Spanner\Admin\Database\V1\RestoreDatabaseRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RestoreDatabase(\Google\Cloud\Spanner\Admin\Database\V1\RestoreDatabaseRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.admin.database.v1.DatabaseAdmin/RestoreDatabase',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists database [longrunning-operations][google.longrunning.Operation].
     * A database operation has a name of the form
     * `projects/<project>/instances/<instance>/databases/<database>/operations/<operation>`.
     * The long-running operation
     * [metadata][google.longrunning.Operation.metadata] field type
     * `metadata.type_url` describes the type of the metadata. Operations returned
     * include those that have completed/failed/canceled within the last 7 days,
     * and pending operations.
     * @param \Google\Cloud\Spanner\Admin\Database\V1\ListDatabaseOperationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDatabaseOperations(\Google\Cloud\Spanner\Admin\Database\V1\ListDatabaseOperationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.admin.database.v1.DatabaseAdmin/ListDatabaseOperations',
        $argument,
        ['\Google\Cloud\Spanner\Admin\Database\V1\ListDatabaseOperationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the backup [long-running operations][google.longrunning.Operation] in
     * the given instance. A backup operation has a name of the form
     * `projects/<project>/instances/<instance>/backups/<backup>/operations/<operation>`.
     * The long-running operation
     * [metadata][google.longrunning.Operation.metadata] field type
     * `metadata.type_url` describes the type of the metadata. Operations returned
     * include those that have completed/failed/canceled within the last 7 days,
     * and pending operations. Operations returned are ordered by
     * `operation.metadata.value.progress.start_time` in descending order starting
     * from the most recently started operation.
     * @param \Google\Cloud\Spanner\Admin\Database\V1\ListBackupOperationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListBackupOperations(\Google\Cloud\Spanner\Admin\Database\V1\ListBackupOperationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.admin.database.v1.DatabaseAdmin/ListBackupOperations',
        $argument,
        ['\Google\Cloud\Spanner\Admin\Database\V1\ListBackupOperationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Cloud Spanner database roles.
     * @param \Google\Cloud\Spanner\Admin\Database\V1\ListDatabaseRolesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDatabaseRoles(\Google\Cloud\Spanner\Admin\Database\V1\ListDatabaseRolesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.admin.database.v1.DatabaseAdmin/ListDatabaseRoles',
        $argument,
        ['\Google\Cloud\Spanner\Admin\Database\V1\ListDatabaseRolesResponse', 'decode'],
        $metadata, $options);
    }

}
