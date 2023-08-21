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

// [START run_v2_generated_Executions_DeleteExecution_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Run\V2\Client\ExecutionsClient;
use Google\Cloud\Run\V2\DeleteExecutionRequest;
use Google\Cloud\Run\V2\Execution;
use Google\Rpc\Status;

/**
 * Deletes an Execution.
 *
 * @param string $formattedName The name of the Execution to delete.
 *                              Format:
 *                              projects/{project}/locations/{location}/jobs/{job}/executions/{execution},
 *                              where {project} can be project id or number. Please see
 *                              {@see ExecutionsClient::executionName()} for help formatting this field.
 */
function delete_execution_sample(string $formattedName): void
{
    // Create a client.
    $executionsClient = new ExecutionsClient();

    // Prepare the request message.
    $request = (new DeleteExecutionRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $executionsClient->deleteExecution($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Execution $result */
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
    $formattedName = ExecutionsClient::executionName('[PROJECT]', '[LOCATION]', '[JOB]', '[EXECUTION]');

    delete_execution_sample($formattedName);
}
// [END run_v2_generated_Executions_DeleteExecution_sync]
