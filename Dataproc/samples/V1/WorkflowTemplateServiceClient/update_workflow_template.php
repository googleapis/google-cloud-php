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

// [START dataproc_v1_generated_WorkflowTemplateService_UpdateWorkflowTemplate_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataproc\V1\OrderedJob;
use Google\Cloud\Dataproc\V1\WorkflowTemplate;
use Google\Cloud\Dataproc\V1\WorkflowTemplatePlacement;
use Google\Cloud\Dataproc\V1\WorkflowTemplateServiceClient;

/**
 * Updates (replaces) workflow template. The updated template
 * must contain version that matches the current server version.
 *
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
function update_workflow_template_sample(string $templateId, string $templateJobsStepId): void
{
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
        /** @var WorkflowTemplate $response */
        $response = $workflowTemplateServiceClient->updateWorkflowTemplate($template);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
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
    $templateId = '[ID]';
    $templateJobsStepId = '[STEP_ID]';

    update_workflow_template_sample($templateId, $templateJobsStepId);
}
// [END dataproc_v1_generated_WorkflowTemplateService_UpdateWorkflowTemplate_sync]
