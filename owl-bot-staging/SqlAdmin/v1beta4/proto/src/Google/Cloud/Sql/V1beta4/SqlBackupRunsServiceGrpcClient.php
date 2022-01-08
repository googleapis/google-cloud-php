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
class SqlBackupRunsServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Deletes the backup taken by a backup run.
     * @param \Google\Cloud\Sql\V1beta4\SqlBackupRunsDeleteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Delete(\Google\Cloud\Sql\V1beta4\SqlBackupRunsDeleteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlBackupRunsService/Delete',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a resource containing information about a backup run.
     * @param \Google\Cloud\Sql\V1beta4\SqlBackupRunsGetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Get(\Google\Cloud\Sql\V1beta4\SqlBackupRunsGetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlBackupRunsService/Get',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\BackupRun', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new backup run on demand.
     * @param \Google\Cloud\Sql\V1beta4\SqlBackupRunsInsertRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Insert(\Google\Cloud\Sql\V1beta4\SqlBackupRunsInsertRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlBackupRunsService/Insert',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all backup runs associated with the project or a given instance and
     * configuration in the reverse chronological order of the backup initiation
     * time.
     * @param \Google\Cloud\Sql\V1beta4\SqlBackupRunsListRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function List(\Google\Cloud\Sql\V1beta4\SqlBackupRunsListRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlBackupRunsService/List',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\BackupRunsListResponse', 'decode'],
        $metadata, $options);
    }

}
