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

// [START geminidataanalytics_v1_generated_DataAgentService_SetAgentOpsObservability_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GeminiDataAnalytics\V1\Client\DataAgentServiceClient;
use Google\Cloud\GeminiDataAnalytics\V1\SetAgentOpsObservabilityRequest;
use Google\Cloud\GeminiDataAnalytics\V1\SetAgentOpsObservabilityResponse;
use Google\Rpc\Status;

/**
 * Enables/Disables required GCP services and configures AgentOps
 * observability settings calling the Admin Settings executable node to
 * update the AgentOps Observability feature.
 *
 * @param string $formattedParent Parent value for SetAgentOpsObservabilityRequest.
 *                                Format: projects/{project}/locations/{location}
 *                                Please see {@see DataAgentServiceClient::locationName()} for help formatting this field.
 * @param string $dataSourceType  The data source type for which to set observability settings.
 *                                Examples: "bigquery", "looker"
 */
function set_agent_ops_observability_sample(string $formattedParent, string $dataSourceType): void
{
    // Create a client.
    $dataAgentServiceClient = new DataAgentServiceClient();

    // Prepare the request message.
    $request = (new SetAgentOpsObservabilityRequest())
        ->setParent($formattedParent)
        ->setDataSourceType($dataSourceType);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $dataAgentServiceClient->setAgentOpsObservability($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var SetAgentOpsObservabilityResponse $result */
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
    $formattedParent = DataAgentServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $dataSourceType = '[DATA_SOURCE_TYPE]';

    set_agent_ops_observability_sample($formattedParent, $dataSourceType);
}
// [END geminidataanalytics_v1_generated_DataAgentService_SetAgentOpsObservability_sync]
