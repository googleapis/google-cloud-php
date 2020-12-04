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
namespace Google\Cloud\Workflows\V1beta;

/**
 * Workflows is used to deploy and execute workflow programs.
 * Workflows makes sure the program executes reliably, despite hardware and
 * networking interruptions.
 */
class WorkflowsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists Workflows in a given project and location.
     * The default order is not specified.
     * @param \Google\Cloud\Workflows\V1beta\ListWorkflowsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListWorkflows(\Google\Cloud\Workflows\V1beta\ListWorkflowsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.workflows.v1beta.Workflows/ListWorkflows',
        $argument,
        ['\Google\Cloud\Workflows\V1beta\ListWorkflowsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single Workflow.
     * @param \Google\Cloud\Workflows\V1beta\GetWorkflowRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetWorkflow(\Google\Cloud\Workflows\V1beta\GetWorkflowRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.workflows.v1beta.Workflows/GetWorkflow',
        $argument,
        ['\Google\Cloud\Workflows\V1beta\Workflow', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new workflow. If a workflow with the specified name already
     * exists in the specified project and location, the long running operation
     * will return [ALREADY_EXISTS][google.rpc.Code.ALREADY_EXISTS] error.
     * @param \Google\Cloud\Workflows\V1beta\CreateWorkflowRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateWorkflow(\Google\Cloud\Workflows\V1beta\CreateWorkflowRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.workflows.v1beta.Workflows/CreateWorkflow',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a workflow with the specified name.
     * This method also cancels and deletes all running executions of the
     * workflow.
     * @param \Google\Cloud\Workflows\V1beta\DeleteWorkflowRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteWorkflow(\Google\Cloud\Workflows\V1beta\DeleteWorkflowRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.workflows.v1beta.Workflows/DeleteWorkflow',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an existing workflow.
     * Running this method has no impact on already running executions of the
     * workflow. A new revision of the workflow may be created as a result of a
     * successful update operation. In that case, such revision will be used
     * in new workflow executions.
     * @param \Google\Cloud\Workflows\V1beta\UpdateWorkflowRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateWorkflow(\Google\Cloud\Workflows\V1beta\UpdateWorkflowRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.workflows.v1beta.Workflows/UpdateWorkflow',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
