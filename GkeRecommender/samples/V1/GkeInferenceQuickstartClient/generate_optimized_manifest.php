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

// [START gkerecommender_v1_generated_GkeInferenceQuickstart_GenerateOptimizedManifest_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\GkeRecommender\V1\Client\GkeInferenceQuickstartClient;
use Google\Cloud\GkeRecommender\V1\GenerateOptimizedManifestRequest;
use Google\Cloud\GkeRecommender\V1\GenerateOptimizedManifestResponse;
use Google\Cloud\GkeRecommender\V1\ModelServerInfo;

/**
 * Generates an optimized deployment manifest for a given model and model
 * server, based on the specified accelerator, performance targets, and
 * configurations. See [Run best practice inference with GKE Inference
 * Quickstart
 * recipes](https://cloud.google.com/kubernetes-engine/docs/how-to/machine-learning/inference/inference-quickstart)
 * for deployment details.
 *
 * @param string $modelServerInfoModel       The model. Open-source models follow the Huggingface Hub
 *                                           `owner/model_name` format. Use
 *                                           [GkeInferenceQuickstart.FetchModels][google.cloud.gkerecommender.v1.GkeInferenceQuickstart.FetchModels]
 *                                           to find available models.
 * @param string $modelServerInfoModelServer The model server. Open-source model servers use simplified,
 *                                           lowercase names (e.g., `vllm`). Use
 *                                           [GkeInferenceQuickstart.FetchModelServers][google.cloud.gkerecommender.v1.GkeInferenceQuickstart.FetchModelServers]
 *                                           to find available servers.
 * @param string $acceleratorType            The accelerator type. Use
 *                                           [GkeInferenceQuickstart.FetchProfiles][google.cloud.gkerecommender.v1.GkeInferenceQuickstart.FetchProfiles]
 *                                           to find valid accelerators for a given `model_server_info`.
 */
function generate_optimized_manifest_sample(
    string $modelServerInfoModel,
    string $modelServerInfoModelServer,
    string $acceleratorType
): void {
    // Create a client.
    $gkeInferenceQuickstartClient = new GkeInferenceQuickstartClient();

    // Prepare the request message.
    $modelServerInfo = (new ModelServerInfo())
        ->setModel($modelServerInfoModel)
        ->setModelServer($modelServerInfoModelServer);
    $request = (new GenerateOptimizedManifestRequest())
        ->setModelServerInfo($modelServerInfo)
        ->setAcceleratorType($acceleratorType);

    // Call the API and handle any network failures.
    try {
        /** @var GenerateOptimizedManifestResponse $response */
        $response = $gkeInferenceQuickstartClient->generateOptimizedManifest($request);
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
    $acceleratorType = '[ACCELERATOR_TYPE]';

    generate_optimized_manifest_sample(
        $modelServerInfoModel,
        $modelServerInfoModelServer,
        $acceleratorType
    );
}
// [END gkerecommender_v1_generated_GkeInferenceQuickstart_GenerateOptimizedManifest_sync]
