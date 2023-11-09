<?php
/*
 * Copyright 2023 Google LLC
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

// [START notebooks_v1_generated_NotebookService_GetExecution_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Notebooks\V1\Client\NotebookServiceClient;
use Google\Cloud\Notebooks\V1\Execution;
use Google\Cloud\Notebooks\V1\GetExecutionRequest;

/**
 * Gets details of executions
 *
 * @param string $formattedName Format:
 *                              `projects/{project_id}/locations/{location}/executions/{execution_id}`
 *                              Please see {@see NotebookServiceClient::executionName()} for help formatting this field.
 */
function get_execution_sample(string $formattedName): void
{
    // Create a client.
    $notebookServiceClient = new NotebookServiceClient();

    // Prepare the request message.
    $request = (new GetExecutionRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Execution $response */
        $response = $notebookServiceClient->getExecution($request);
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
    $formattedName = NotebookServiceClient::executionName('[PROJECT]', '[LOCATION]', '[EXECUTION]');

    get_execution_sample($formattedName);
}
// [END notebooks_v1_generated_NotebookService_GetExecution_sync]
