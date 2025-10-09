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

// [START workflows_v1_generated_Workflows_GetWorkflow_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Workflows\V1\Client\WorkflowsClient;
use Google\Cloud\Workflows\V1\GetWorkflowRequest;
use Google\Cloud\Workflows\V1\Workflow;

/**
 * Gets details of a single workflow.
 *
 * @param string $formattedName Name of the workflow for which information should be retrieved.
 *                              Format: projects/{project}/locations/{location}/workflows/{workflow}
 *                              Please see {@see WorkflowsClient::workflowName()} for help formatting this field.
 */
function get_workflow_sample(string $formattedName): void
{
    // Create a client.
    $workflowsClient = new WorkflowsClient();

    // Prepare the request message.
    $request = (new GetWorkflowRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Workflow $response */
        $response = $workflowsClient->getWorkflow($request);
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
    $formattedName = WorkflowsClient::workflowName('[PROJECT]', '[LOCATION]', '[WORKFLOW]');

    get_workflow_sample($formattedName);
}
// [END workflows_v1_generated_Workflows_GetWorkflow_sync]
