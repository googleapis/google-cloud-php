<?php
/*
 * Copyright 2024 Google LLC
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

// [START dataproc_v1_generated_WorkflowTemplateService_DeleteWorkflowTemplate_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataproc\V1\WorkflowTemplateServiceClient;

/**
 * Deletes a workflow template. It does not cancel in-progress workflows.
 *
 * @param string $formattedName The resource name of the workflow template, as described
 *                              in https://cloud.google.com/apis/design/resource_names.
 *
 *                              * For `projects.regions.workflowTemplates.delete`, the resource name
 *                              of the template has the following format:
 *                              `projects/{project_id}/regions/{region}/workflowTemplates/{template_id}`
 *
 *                              * For `projects.locations.workflowTemplates.instantiate`, the resource name
 *                              of the template has the following format:
 *                              `projects/{project_id}/locations/{location}/workflowTemplates/{template_id}`
 *                              Please see {@see WorkflowTemplateServiceClient::workflowTemplateName()} for help formatting this field.
 */
function delete_workflow_template_sample(string $formattedName): void
{
    // Create a client.
    $workflowTemplateServiceClient = new WorkflowTemplateServiceClient();

    // Call the API and handle any network failures.
    try {
        $workflowTemplateServiceClient->deleteWorkflowTemplate($formattedName);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = WorkflowTemplateServiceClient::workflowTemplateName(
        '[PROJECT]',
        '[REGION]',
        '[WORKFLOW_TEMPLATE]'
    );

    delete_workflow_template_sample($formattedName);
}
// [END dataproc_v1_generated_WorkflowTemplateService_DeleteWorkflowTemplate_sync]
