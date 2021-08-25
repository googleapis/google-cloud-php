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
namespace Google\Cloud\Sql\V1beta4;

/**
 */
class SqlDatabasesServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Deletes a database from a Cloud SQL instance.
     * @param \Google\Cloud\Sql\V1beta4\SqlDatabasesDeleteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Delete(\Google\Cloud\Sql\V1beta4\SqlDatabasesDeleteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlDatabasesService/Delete',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a resource containing information about a database inside a Cloud
     * SQL instance.
     * @param \Google\Cloud\Sql\V1beta4\SqlDatabasesGetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Get(\Google\Cloud\Sql\V1beta4\SqlDatabasesGetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlDatabasesService/Get',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Database', 'decode'],
        $metadata, $options);
    }

    /**
     * Inserts a resource containing information about a database inside a Cloud
     * SQL instance.
     * @param \Google\Cloud\Sql\V1beta4\SqlDatabasesInsertRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Insert(\Google\Cloud\Sql\V1beta4\SqlDatabasesInsertRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlDatabasesService/Insert',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists databases in the specified Cloud SQL instance.
     * @param \Google\Cloud\Sql\V1beta4\SqlDatabasesListRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function List(\Google\Cloud\Sql\V1beta4\SqlDatabasesListRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlDatabasesService/List',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\DatabasesListResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Partially updates a resource containing information about a database inside
     * a Cloud SQL instance. This method supports patch semantics.
     * @param \Google\Cloud\Sql\V1beta4\SqlDatabasesUpdateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Patch(\Google\Cloud\Sql\V1beta4\SqlDatabasesUpdateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlDatabasesService/Patch',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a resource containing information about a database inside a Cloud
     * SQL instance.
     * @param \Google\Cloud\Sql\V1beta4\SqlDatabasesUpdateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Update(\Google\Cloud\Sql\V1beta4\SqlDatabasesUpdateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlDatabasesService/Update',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

}
