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

// [START workflows_v1_generated_Workflows_CreateWorkflow_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Workflows\V1\Client\WorkflowsClient;
use Google\Cloud\Workflows\V1\CreateWorkflowRequest;
use Google\Cloud\Workflows\V1\Workflow;
use Google\Rpc\Status;

/**
 * Creates a new workflow. If a workflow with the specified name already
 * exists in the specified project and location, the long running operation
 * returns a [ALREADY_EXISTS][google.rpc.Code.ALREADY_EXISTS] error.
 *
 * @param string $formattedParent Project and location in which the workflow should be created.
 *                                Format:  projects/{project}/locations/{location}
 *                                Please see {@see WorkflowsClient::locationName()} for help formatting this field.
 * @param string $workflowId      The ID of the workflow to be created. It has to fulfill the
 *                                following requirements:
 *
 *                                * Must contain only letters, numbers, underscores and hyphens.
 *                                * Must start with a letter.
 *                                * Must be between 1-64 characters.
 *                                * Must end with a number or a letter.
 *                                * Must be unique within the customer project and location.
 */
function create_workflow_sample(string $formattedParent, string $workflowId): void
{
    // Create a client.
    $workflowsClient = new WorkflowsClient();

    // Prepare the request message.
    $workflow = new Workflow();
    $request = (new CreateWorkflowRequest())
        ->setParent($formattedParent)
        ->setWorkflow($workflow)
        ->setWorkflowId($workflowId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $workflowsClient->createWorkflow($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Workflow $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
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
    $formattedParent = WorkflowsClient::locationName('[PROJECT]', '[LOCATION]');
    $workflowId = '[WORKFLOW_ID]';

    create_workflow_sample($formattedParent, $workflowId);
}
// [END workflows_v1_generated_Workflows_CreateWorkflow_sync]
