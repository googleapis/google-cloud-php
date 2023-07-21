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

// [START aiplatform_v1_generated_MetadataService_QueryExecutionInputsAndOutputs_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Client\MetadataServiceClient;
use Google\Cloud\AIPlatform\V1\LineageSubgraph;
use Google\Cloud\AIPlatform\V1\QueryExecutionInputsAndOutputsRequest;

/**
 * Obtains the set of input and output Artifacts for this Execution, in the
 * form of LineageSubgraph that also contains the Execution and connecting
 * Events.
 *
 * @param string $formattedExecution The resource name of the Execution whose input and output
 *                                   Artifacts should be retrieved as a LineageSubgraph. Format:
 *                                   `projects/{project}/locations/{location}/metadataStores/{metadatastore}/executions/{execution}`
 *                                   Please see {@see MetadataServiceClient::executionName()} for help formatting this field.
 */
function query_execution_inputs_and_outputs_sample(string $formattedExecution): void
{
    // Create a client.
    $metadataServiceClient = new MetadataServiceClient();

    // Prepare the request message.
    $request = (new QueryExecutionInputsAndOutputsRequest())
        ->setExecution($formattedExecution);

    // Call the API and handle any network failures.
    try {
        /** @var LineageSubgraph $response */
        $response = $metadataServiceClient->queryExecutionInputsAndOutputs($request);
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
    $formattedExecution = MetadataServiceClient::executionName(
        '[PROJECT]',
        '[LOCATION]',
        '[METADATA_STORE]',
        '[EXECUTION]'
    );

    query_execution_inputs_and_outputs_sample($formattedExecution);
}
// [END aiplatform_v1_generated_MetadataService_QueryExecutionInputsAndOutputs_sync]
