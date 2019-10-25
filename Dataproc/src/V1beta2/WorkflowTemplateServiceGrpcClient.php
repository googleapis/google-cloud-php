<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2019 Google LLC.
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
//
namespace Google\Cloud\Dataproc\V1beta2;

/**
 * The API interface for managing Workflow Templates in the
 * Cloud Dataproc API.
 */
class WorkflowTemplateServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates new workflow template.
     * @param \Google\Cloud\Dataproc\V1beta2\CreateWorkflowTemplateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateWorkflowTemplate(\Google\Cloud\Dataproc\V1beta2\CreateWorkflowTemplateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1beta2.WorkflowTemplateService/CreateWorkflowTemplate',
        $argument,
        ['\Google\Cloud\Dataproc\V1beta2\WorkflowTemplate', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves the latest workflow template.
     *
     * Can retrieve previously instantiated template by specifying optional
     * version parameter.
     * @param \Google\Cloud\Dataproc\V1beta2\GetWorkflowTemplateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetWorkflowTemplate(\Google\Cloud\Dataproc\V1beta2\GetWorkflowTemplateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1beta2.WorkflowTemplateService/GetWorkflowTemplate',
        $argument,
        ['\Google\Cloud\Dataproc\V1beta2\WorkflowTemplate', 'decode'],
        $metadata, $options);
    }

    /**
     * Instantiates a template and begins execution.
     *
     * The returned Operation can be used to track execution of
     * workflow by polling
     * [operations.get][google.longrunning.Operations.GetOperation].
     * The Operation will complete when entire workflow is finished.
     *
     * The running workflow can be aborted via
     * [operations.cancel][google.longrunning.Operations.CancelOperation].
     * This will cause any inflight jobs to be cancelled and workflow-owned
     * clusters to be deleted.
     *
     * The [Operation.metadata][google.longrunning.Operation.metadata] will be
     * [WorkflowMetadata](/dataproc/docs/reference/rpc/google.cloud.dataproc.v1beta2#workflowmetadata).
     * Also see [Using
     * WorkflowMetadata](/dataproc/docs/concepts/workflows/debugging#using_workflowmetadata).
     *
     * On successful completion,
     * [Operation.response][google.longrunning.Operation.response] will be
     * [Empty][google.protobuf.Empty].
     * @param \Google\Cloud\Dataproc\V1beta2\InstantiateWorkflowTemplateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function InstantiateWorkflowTemplate(\Google\Cloud\Dataproc\V1beta2\InstantiateWorkflowTemplateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1beta2.WorkflowTemplateService/InstantiateWorkflowTemplate',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Instantiates a template and begins execution.
     *
     * This method is equivalent to executing the sequence
     * [CreateWorkflowTemplate][google.cloud.dataproc.v1beta2.WorkflowTemplateService.CreateWorkflowTemplate], [InstantiateWorkflowTemplate][google.cloud.dataproc.v1beta2.WorkflowTemplateService.InstantiateWorkflowTemplate],
     * [DeleteWorkflowTemplate][google.cloud.dataproc.v1beta2.WorkflowTemplateService.DeleteWorkflowTemplate].
     *
     * The returned Operation can be used to track execution of
     * workflow by polling
     * [operations.get][google.longrunning.Operations.GetOperation].
     * The Operation will complete when entire workflow is finished.
     *
     * The running workflow can be aborted via
     * [operations.cancel][google.longrunning.Operations.CancelOperation].
     * This will cause any inflight jobs to be cancelled and workflow-owned
     * clusters to be deleted.
     *
     * The [Operation.metadata][google.longrunning.Operation.metadata] will be
     * [WorkflowMetadata](/dataproc/docs/reference/rpc/google.cloud.dataproc.v1#workflowmetadata).
     * Also see [Using
     * WorkflowMetadata](/dataproc/docs/concepts/workflows/debugging#using_workflowmetadata).
     *
     * On successful completion,
     * [Operation.response][google.longrunning.Operation.response] will be
     * [Empty][google.protobuf.Empty].
     * @param \Google\Cloud\Dataproc\V1beta2\InstantiateInlineWorkflowTemplateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function InstantiateInlineWorkflowTemplate(\Google\Cloud\Dataproc\V1beta2\InstantiateInlineWorkflowTemplateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1beta2.WorkflowTemplateService/InstantiateInlineWorkflowTemplate',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates (replaces) workflow template. The updated template
     * must contain version that matches the current server version.
     * @param \Google\Cloud\Dataproc\V1beta2\UpdateWorkflowTemplateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateWorkflowTemplate(\Google\Cloud\Dataproc\V1beta2\UpdateWorkflowTemplateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1beta2.WorkflowTemplateService/UpdateWorkflowTemplate',
        $argument,
        ['\Google\Cloud\Dataproc\V1beta2\WorkflowTemplate', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists workflows that match the specified filter in the request.
     * @param \Google\Cloud\Dataproc\V1beta2\ListWorkflowTemplatesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListWorkflowTemplates(\Google\Cloud\Dataproc\V1beta2\ListWorkflowTemplatesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1beta2.WorkflowTemplateService/ListWorkflowTemplates',
        $argument,
        ['\Google\Cloud\Dataproc\V1beta2\ListWorkflowTemplatesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a workflow template. It does not cancel in-progress workflows.
     * @param \Google\Cloud\Dataproc\V1beta2\DeleteWorkflowTemplateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteWorkflowTemplate(\Google\Cloud\Dataproc\V1beta2\DeleteWorkflowTemplateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1beta2.WorkflowTemplateService/DeleteWorkflowTemplate',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
