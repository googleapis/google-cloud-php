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

// [START aiplatform_v1_generated_PredictionService_Explain_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\ExplainResponse;
use Google\Cloud\AIPlatform\V1\PredictionServiceClient;
use Google\Protobuf\Value;

/**
 * Perform an online explanation.
 *
 * If [deployed_model_id][google.cloud.aiplatform.v1.ExplainRequest.deployed_model_id] is specified,
 * the corresponding DeployModel must have
 * [explanation_spec][google.cloud.aiplatform.v1.DeployedModel.explanation_spec]
 * populated. If [deployed_model_id][google.cloud.aiplatform.v1.ExplainRequest.deployed_model_id]
 * is not specified, all DeployedModels must have
 * [explanation_spec][google.cloud.aiplatform.v1.DeployedModel.explanation_spec]
 * populated. Only deployed AutoML tabular Models have
 * explanation_spec.
 *
 * @param string $formattedEndpoint The name of the Endpoint requested to serve the explanation.
 *                                  Format:
 *                                  `projects/{project}/locations/{location}/endpoints/{endpoint}`
 *                                  Please see {@see PredictionServiceClient::endpointName()} for help formatting this field.
 */
function explain_sample(string $formattedEndpoint): void
{
    // Create a client.
    $predictionServiceClient = new PredictionServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $instances = [new Value()];

    // Call the API and handle any network failures.
    try {
        /** @var ExplainResponse $response */
        $response = $predictionServiceClient->explain($formattedEndpoint, $instances);
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
    $formattedEndpoint = PredictionServiceClient::endpointName('[PROJECT]', '[LOCATION]', '[ENDPOINT]');

    explain_sample($formattedEndpoint);
}
// [END aiplatform_v1_generated_PredictionService_Explain_sync]
