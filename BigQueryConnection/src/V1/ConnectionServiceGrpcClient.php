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
namespace Google\Cloud\BigQuery\Connection\V1;

/**
 * Manages external data source connections and credentials.
 */
class ConnectionServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new connection.
     * @param \Google\Cloud\BigQuery\Connection\V1\CreateConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateConnection(\Google\Cloud\BigQuery\Connection\V1\CreateConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.connection.v1.ConnectionService/CreateConnection',
        $argument,
        ['\Google\Cloud\BigQuery\Connection\V1\Connection', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns specified connection.
     * @param \Google\Cloud\BigQuery\Connection\V1\GetConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetConnection(\Google\Cloud\BigQuery\Connection\V1\GetConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.connection.v1.ConnectionService/GetConnection',
        $argument,
        ['\Google\Cloud\BigQuery\Connection\V1\Connection', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a list of connections in the given project.
     * @param \Google\Cloud\BigQuery\Connection\V1\ListConnectionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListConnections(\Google\Cloud\BigQuery\Connection\V1\ListConnectionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.connection.v1.ConnectionService/ListConnections',
        $argument,
        ['\Google\Cloud\BigQuery\Connection\V1\ListConnectionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified connection. For security reasons, also resets
     * credential if connection properties are in the update field mask.
     * @param \Google\Cloud\BigQuery\Connection\V1\UpdateConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateConnection(\Google\Cloud\BigQuery\Connection\V1\UpdateConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.connection.v1.ConnectionService/UpdateConnection',
        $argument,
        ['\Google\Cloud\BigQuery\Connection\V1\Connection', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes connection and associated credential.
     * @param \Google\Cloud\BigQuery\Connection\V1\DeleteConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteConnection(\Google\Cloud\BigQuery\Connection\V1\DeleteConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.connection.v1.ConnectionService/DeleteConnection',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the access control policy for a resource.
     * Returns an empty policy if the resource exists and does not have a policy
     * set.
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.connection.v1.ConnectionService/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the access control policy on the specified resource. Replaces any
     * existing policy.
     *
     * Can return `NOT_FOUND`, `INVALID_ARGUMENT`, and `PERMISSION_DENIED` errors.
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.connection.v1.ConnectionService/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns permissions that a caller has on the specified resource.
     * If the resource does not exist, this will return an empty set of
     * permissions, not a `NOT_FOUND` error.
     *
     * Note: This operation is designed to be used for building permission-aware
     * UIs and command-line tools, not for authorization checking. This operation
     * may "fail open" without warning.
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.connection.v1.ConnectionService/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

}
