<?php
/*
 * Copyright 2026 Google LLC
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

// [START workloadmanager_v1_generated_WorkloadManager_RunEvaluation_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\WorkloadManager\V1\Client\WorkloadManagerClient;
use Google\Cloud\WorkloadManager\V1\Execution;
use Google\Cloud\WorkloadManager\V1\RunEvaluationRequest;
use Google\Rpc\Status;

/**
 * Creates a new Execution in a given project and location.
 *
 * @param string $formattedName The resource name of the Evaluation using the form:
 *                              `projects/{project}/locations/{location}/evaluations/{evaluation}`. Please see
 *                              {@see WorkloadManagerClient::evaluationName()} for help formatting this field.
 * @param string $executionId   ID of the execution which will be created.
 */
function run_evaluation_sample(string $formattedName, string $executionId): void
{
    // Create a client.
    $workloadManagerClient = new WorkloadManagerClient();

    // Prepare the request message.
    $execution = new Execution();
    $request = (new RunEvaluationRequest())
        ->setName($formattedName)
        ->setExecutionId($executionId)
        ->setExecution($execution);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $workloadManagerClient->runEvaluation($request);
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
    $formattedName = WorkloadManagerClient::evaluationName('[PROJECT]', '[LOCATION]', '[EVALUATION]');
    $executionId = '[EXECUTION_ID]';

    run_evaluation_sample($formattedName, $executionId);
}
// [END workloadmanager_v1_generated_WorkloadManager_RunEvaluation_sync]
