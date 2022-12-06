<?php
/*
 * Copyright 2022 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

require_once __DIR__ . '/../../../vendor/autoload.php';

// [START dataproc_v1_generated_WorkflowTemplateService_InstantiateInlineWorkflowTemplate_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dataproc\V1\OrderedJob;
use Google\Cloud\Dataproc\V1\WorkflowTemplate;
use Google\Cloud\Dataproc\V1\WorkflowTemplatePlacement;
use Google\Cloud\Dataproc\V1\WorkflowTemplateServiceClient;
use Google\Rpc\Status;

/**
 * Instantiates a template and begins execution.
 *
 * This method is equivalent to executing the sequence
 * [CreateWorkflowTemplate][google.cloud.dataproc.v1.WorkflowTemplateService.CreateWorkflowTemplate], [InstantiateWorkflowTemplate][google.cloud.dataproc.v1.WorkflowTemplateService.InstantiateWorkflowTemplate],
 * [DeleteWorkflowTemplate][google.cloud.dataproc.v1.WorkflowTemplateService.DeleteWorkflowTemplate].
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
 * [WorkflowMetadata](https://cloud.google.com/dataproc/docs/reference/rpc/google.cloud.dataproc.v1#workflowmetadata).
 * Also see [Using
 * WorkflowMetadata](https://cloud.google.com/dataproc/docs/concepts/workflows/debugging#using_workflowmetadata).
 *
 * On successful completion,
 * [Operation.response][google.longrunning.Operation.response] will be
 * [Empty][google.protobuf.Empty].
 *
 * @param string $formattedParent    The resource name of the region or location, as described
 *                                   in https://cloud.google.com/apis/design/resource_names.
 *
 *                                   * For `projects.regions.workflowTemplates,instantiateinline`, the resource
 *                                   name of the region has the following format:
 *                                   `projects/{project_id}/regions/{region}`
 *
 *                                   * For `projects.locations.workflowTemplates.instantiateinline`, the
 *                                   resource name of the location has the following format:
 *                                   `projects/{project_id}/locations/{location}`
 *                                   Please see {@see WorkflowTemplateServiceClient::regionName()} for help formatting this field.
 * @param string $templateId
 * @param string $templateJobsStepId The step id. The id must be unique among all jobs
 *                                   within the template.
 *
 *                                   The step id is used as prefix for job id, as job
 *                                   `goog-dataproc-workflow-step-id` label, and in
 *                                   [prerequisiteStepIds][google.cloud.dataproc.v1.OrderedJob.prerequisite_step_ids] field from other
 *                                   steps.
 *
 *                                   The id must contain only letters (a-z, A-Z), numbers (0-9),
 *                                   underscores (_), and hyphens (-). Cannot begin or end with underscore
 *                                   or hyphen. Must consist of between 3 and 50 characters.
 */
function instantiate_inline_workflow_template_sample(
    string $formattedParent,
    string $templateId,
    string $templateJobsStepId
): void {
    // Create a client.
    $workflowTemplateServiceClient = new WorkflowTemplateServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $templatePlacement = new WorkflowTemplatePlacement();
    $orderedJob = (new OrderedJob())
        ->setStepId($templateJobsStepId);
    $templateJobs = [$orderedJob,];
    $template = (new WorkflowTemplate())
        ->setId($templateId)
        ->setPlacement($templatePlacement)
        ->setJobs($templateJobs);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $workflowTemplateServiceClient->instantiateInlineWorkflowTemplate(
            $formattedParent,
            $template
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}

/**
 * Helper to execute the sample.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function callSample(): void
{
    $formattedParent = WorkflowTemplateServiceClient::regionName('[PROJECT]', '[REGION]');
    $templateId = '[ID]';
    $templateJobsStepId = '[STEP_ID]';

    instantiate_inline_workflow_template_sample($formattedParent, $templateId, $templateJobsStepId);
}
// [END dataproc_v1_generated_WorkflowTemplateService_InstantiateInlineWorkflowTemplate_sync]
