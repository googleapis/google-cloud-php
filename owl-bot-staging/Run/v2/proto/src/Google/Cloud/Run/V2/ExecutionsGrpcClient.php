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
namespace Google\Cloud\Run\V2;

/**
 * Cloud Run Execution Control Plane API.
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
     * Gets information about an Execution.
     * @param \Google\Cloud\Run\V2\GetExecutionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetExecution(\Google\Cloud\Run\V2\GetExecutionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.run.v2.Executions/GetExecution',
        $argument,
        ['\Google\Cloud\Run\V2\Execution', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Executions from a Job.
     * @param \Google\Cloud\Run\V2\ListExecutionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListExecutions(\Google\Cloud\Run\V2\ListExecutionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.run.v2.Executions/ListExecutions',
        $argument,
        ['\Google\Cloud\Run\V2\ListExecutionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an Execution.
     * @param \Google\Cloud\Run\V2\DeleteExecutionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteExecution(\Google\Cloud\Run\V2\DeleteExecutionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.run.v2.Executions/DeleteExecution',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
