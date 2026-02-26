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

// [START gkerecommender_v1_generated_GkeInferenceQuickstart_FetchBenchmarkingData_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\GkeRecommender\V1\Client\GkeInferenceQuickstartClient;
use Google\Cloud\GkeRecommender\V1\FetchBenchmarkingDataRequest;
use Google\Cloud\GkeRecommender\V1\FetchBenchmarkingDataResponse;
use Google\Cloud\GkeRecommender\V1\ModelServerInfo;

/**
 * Fetches all of the benchmarking data available for a profile. Benchmarking
 * data returns all of the performance metrics available for a given model
 * server setup on a given instance type.
 *
 * @param string $modelServerInfoModel       The model. Open-source models follow the Huggingface Hub
 *                                           `owner/model_name` format. Use
 *                                           [GkeInferenceQuickstart.FetchModels][google.cloud.gkerecommender.v1.GkeInferenceQuickstart.FetchModels]
 *                                           to find available models.
 * @param string $modelServerInfoModelServer The model server. Open-source model servers use simplified,
 *                                           lowercase names (e.g., `vllm`). Use
 *                                           [GkeInferenceQuickstart.FetchModelServers][google.cloud.gkerecommender.v1.GkeInferenceQuickstart.FetchModelServers]
 *                                           to find available servers.
 */
function fetch_benchmarking_data_sample(
    string $modelServerInfoModel,
    string $modelServerInfoModelServer
): void {
    // Create a client.
    $gkeInferenceQuickstartClient = new GkeInferenceQuickstartClient();

    // Prepare the request message.
    $modelServerInfo = (new ModelServerInfo())
        ->setModel($modelServerInfoModel)
        ->setModelServer($modelServerInfoModelServer);
    $request = (new FetchBenchmarkingDataRequest())
        ->setModelServerInfo($modelServerInfo);

    // Call the API and handle any network failures.
    try {
        /** @var FetchBenchmarkingDataResponse $response */
        $response = $gkeInferenceQuickstartClient->fetchBenchmarkingData($request);
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
    $modelServerInfoModel = '[MODEL]';
    $modelServerInfoModelServer = '[MODEL_SERVER]';

    fetch_benchmarking_data_sample($modelServerInfoModel, $modelServerInfoModelServer);
}
// [END gkerecommender_v1_generated_GkeInferenceQuickstart_FetchBenchmarkingData_sync]
