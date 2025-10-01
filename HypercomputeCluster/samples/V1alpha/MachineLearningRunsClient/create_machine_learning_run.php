<?php
/*
 * Copyright 2025 Google LLC
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

// [START hypercomputecluster_v1alpha_generated_MachineLearningRuns_CreateMachineLearningRun_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\HypercomputeCluster\V1alpha\Client\MachineLearningRunsClient;
use Google\Cloud\HypercomputeCluster\V1alpha\CreateMachineLearningRunRequest;
use Google\Cloud\HypercomputeCluster\V1alpha\MachineLearningRun;
use Google\Cloud\HypercomputeCluster\V1alpha\MachineLearningRun\Orchestrator;
use Google\Cloud\HypercomputeCluster\V1alpha\Tool;
use Google\Cloud\HypercomputeCluster\V1alpha\Xprof;
use Google\Rpc\Status;

/**
 * Creates a Machine Learning Run.
 *
 * @param string $formattedParent                       Parent format: projects/{project}/locations/{location}
 *                                                      Please see {@see MachineLearningRunsClient::locationName()} for help formatting this field.
 * @param string $machineLearningRunRunSet              Allows grouping of similar runs.
 *                                                      * Helps improving UI rendering performance.
 *                                                      * Allows comparing similar runs via fast filters.
 * @param string $machineLearningRunToolsXprofSessionId XProf session id
 * @param int    $machineLearningRunOrchestrator        The orchestrator used for the run.
 */
function create_machine_learning_run_sample(
    string $formattedParent,
    string $machineLearningRunRunSet,
    string $machineLearningRunToolsXprofSessionId,
    int $machineLearningRunOrchestrator
): void {
    // Create a client.
    $machineLearningRunsClient = new MachineLearningRunsClient();

    // Prepare the request message.
    $machineLearningRunToolsXprof = (new Xprof())
        ->setSessionId($machineLearningRunToolsXprofSessionId);
    $tool = (new Tool())
        ->setXprof($machineLearningRunToolsXprof);
    $machineLearningRunTools = [$tool,];
    $machineLearningRun = (new MachineLearningRun())
        ->setRunSet($machineLearningRunRunSet)
        ->setTools($machineLearningRunTools)
        ->setOrchestrator($machineLearningRunOrchestrator);
    $request = (new CreateMachineLearningRunRequest())
        ->setParent($formattedParent)
        ->setMachineLearningRun($machineLearningRun);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $machineLearningRunsClient->createMachineLearningRun($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var MachineLearningRun $result */
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
    $formattedParent = MachineLearningRunsClient::locationName('[PROJECT]', '[LOCATION]');
    $machineLearningRunRunSet = '[RUN_SET]';
    $machineLearningRunToolsXprofSessionId = '[SESSION_ID]';
    $machineLearningRunOrchestrator = Orchestrator::ORCHESTRATOR_UNSPECIFIED;

    create_machine_learning_run_sample(
        $formattedParent,
        $machineLearningRunRunSet,
        $machineLearningRunToolsXprofSessionId,
        $machineLearningRunOrchestrator
    );
}
// [END hypercomputecluster_v1alpha_generated_MachineLearningRuns_CreateMachineLearningRun_sync]
