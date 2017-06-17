<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2017 Google Inc.
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
 * The Cloud Spanner Database Admin API can be used to create, drop, and
 * list databases. It also enables updating the schema of pre-existing
 * databases.
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
     * @param \Google\Cloud\Spanner\Admin\Database\V1\DropDatabaseRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
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
     */
    public function GetDatabaseDdl(\Google\Cloud\Spanner\Admin\Database\V1\GetDatabaseDdlRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.admin.database.v1.DatabaseAdmin/GetDatabaseDdl',
        $argument,
        ['\Google\Cloud\Spanner\Admin\Database\V1\GetDatabaseDdlResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the access control policy on a database resource. Replaces any
     * existing policy.
     *
     * Authorization requires `spanner.databases.setIamPolicy` permission on
     * [resource][google.iam.v1.SetIamPolicyRequest.resource].
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.admin.database.v1.DatabaseAdmin/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the access control policy for a database resource. Returns an empty
     * policy if a database exists but does not have a policy set.
     *
     * Authorization requires `spanner.databases.getIamPolicy` permission on
     * [resource][google.iam.v1.GetIamPolicyRequest.resource].
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.admin.database.v1.DatabaseAdmin/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns permissions that the caller has on the specified database resource.
     *
     * Attempting this RPC on a non-existent Cloud Spanner database will result in
     * a NOT_FOUND error if the user has `spanner.databases.list` permission on
     * the containing Cloud Spanner instance. Otherwise returns an empty set of
     * permissions.
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.admin.database.v1.DatabaseAdmin/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

}
