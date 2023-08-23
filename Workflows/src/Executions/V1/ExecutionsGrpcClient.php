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
namespace Google\Cloud\Workflows\Executions\V1;

/**
 * Executions is used to start and manage running instances of
 * [Workflows][google.cloud.workflows.v1.Workflow] called executions.
 */
class ExecutionsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Returns a list of executions which belong to the workflow with
     * the given name. The method returns executions of all workflow
     * revisions. Returned executions are ordered by their start time (newest
     * first).
     * @param \Google\Cloud\Workflows\Executions\V1\ListExecutionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListExecutions(\Google\Cloud\Workflows\Executions\V1\ListExecutionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.workflows.executions.v1.Executions/ListExecutions',
        $argument,
        ['\Google\Cloud\Workflows\Executions\V1\ListExecutionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new execution using the latest revision of the given workflow.
     * @param \Google\Cloud\Workflows\Executions\V1\CreateExecutionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateExecution(\Google\Cloud\Workflows\Executions\V1\CreateExecutionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.workflows.executions.v1.Executions/CreateExecution',
        $argument,
        ['\Google\Cloud\Workflows\Executions\V1\Execution', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns an execution of the given name.
     * @param \Google\Cloud\Workflows\Executions\V1\GetExecutionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetExecution(\Google\Cloud\Workflows\Executions\V1\GetExecutionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.workflows.executions.v1.Executions/GetExecution',
        $argument,
        ['\Google\Cloud\Workflows\Executions\V1\Execution', 'decode'],
        $metadata, $options);
    }

    /**
     * Cancels an execution of the given name.
     * @param \Google\Cloud\Workflows\Executions\V1\CancelExecutionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CancelExecution(\Google\Cloud\Workflows\Executions\V1\CancelExecutionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.workflows.executions.v1.Executions/CancelExecution',
        $argument,
        ['\Google\Cloud\Workflows\Executions\V1\Execution', 'decode'],
        $metadata, $options);
    }

}
