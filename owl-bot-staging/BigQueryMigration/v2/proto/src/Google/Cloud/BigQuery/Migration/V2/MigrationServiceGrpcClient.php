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
namespace Google\Cloud\BigQuery\Migration\V2;

/**
 * Service to handle EDW migrations.
 */
class MigrationServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a migration workflow.
     * @param \Google\Cloud\BigQuery\Migration\V2\CreateMigrationWorkflowRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateMigrationWorkflow(\Google\Cloud\BigQuery\Migration\V2\CreateMigrationWorkflowRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.migration.v2.MigrationService/CreateMigrationWorkflow',
        $argument,
        ['\Google\Cloud\BigQuery\Migration\V2\MigrationWorkflow', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a previously created migration workflow.
     * @param \Google\Cloud\BigQuery\Migration\V2\GetMigrationWorkflowRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetMigrationWorkflow(\Google\Cloud\BigQuery\Migration\V2\GetMigrationWorkflowRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.migration.v2.MigrationService/GetMigrationWorkflow',
        $argument,
        ['\Google\Cloud\BigQuery\Migration\V2\MigrationWorkflow', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists previously created migration workflow.
     * @param \Google\Cloud\BigQuery\Migration\V2\ListMigrationWorkflowsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListMigrationWorkflows(\Google\Cloud\BigQuery\Migration\V2\ListMigrationWorkflowsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.migration.v2.MigrationService/ListMigrationWorkflows',
        $argument,
        ['\Google\Cloud\BigQuery\Migration\V2\ListMigrationWorkflowsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a migration workflow by name.
     * @param \Google\Cloud\BigQuery\Migration\V2\DeleteMigrationWorkflowRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteMigrationWorkflow(\Google\Cloud\BigQuery\Migration\V2\DeleteMigrationWorkflowRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.migration.v2.MigrationService/DeleteMigrationWorkflow',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Starts a previously created migration workflow. I.e., the state transitions
     * from DRAFT to RUNNING. This is a no-op if the state is already RUNNING.
     * An error will be signaled if the state is anything other than DRAFT or
     * RUNNING.
     * @param \Google\Cloud\BigQuery\Migration\V2\StartMigrationWorkflowRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StartMigrationWorkflow(\Google\Cloud\BigQuery\Migration\V2\StartMigrationWorkflowRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.migration.v2.MigrationService/StartMigrationWorkflow',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a previously created migration subtask.
     * @param \Google\Cloud\BigQuery\Migration\V2\GetMigrationSubtaskRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetMigrationSubtask(\Google\Cloud\BigQuery\Migration\V2\GetMigrationSubtaskRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.migration.v2.MigrationService/GetMigrationSubtask',
        $argument,
        ['\Google\Cloud\BigQuery\Migration\V2\MigrationSubtask', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists previously created migration subtasks.
     * @param \Google\Cloud\BigQuery\Migration\V2\ListMigrationSubtasksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListMigrationSubtasks(\Google\Cloud\BigQuery\Migration\V2\ListMigrationSubtasksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.migration.v2.MigrationService/ListMigrationSubtasks',
        $argument,
        ['\Google\Cloud\BigQuery\Migration\V2\ListMigrationSubtasksResponse', 'decode'],
        $metadata, $options);
    }

}
