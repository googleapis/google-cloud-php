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

// [START gkerecommender_v1_generated_GkeInferenceQuickstart_FetchModelServerVersions_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\GkeRecommender\V1\Client\GkeInferenceQuickstartClient;
use Google\Cloud\GkeRecommender\V1\FetchModelServerVersionsRequest;

/**
 * Fetches available model server versions. Open-source servers use their own
 * versioning schemas (e.g., `vllm` uses semver like `v1.0.0`).
 *
 * Some model servers have different versioning schemas depending on the
 * accelerator. For example, `vllm` uses semver on GPUs, but returns nightly
 * build tags on TPUs. All available versions will be returned when different
 * schemas are present.
 *
 * @param string $model       The model for which to list model server versions. Open-source
 *                            models follow the Huggingface Hub `owner/model_name` format. Use
 *                            [GkeInferenceQuickstart.FetchModels][google.cloud.gkerecommender.v1.GkeInferenceQuickstart.FetchModels]
 *                            to find available models.
 * @param string $modelServer The model server for which to list versions. Open-source model
 *                            servers use simplified, lowercase names (e.g., `vllm`). Use
 *                            [GkeInferenceQuickstart.FetchModelServers][google.cloud.gkerecommender.v1.GkeInferenceQuickstart.FetchModelServers]
 *                            to find available model servers.
 */
function fetch_model_server_versions_sample(string $model, string $modelServer): void
{
    // Create a client.
    $gkeInferenceQuickstartClient = new GkeInferenceQuickstartClient();

    // Prepare the request message.
    $request = (new FetchModelServerVersionsRequest())
        ->setModel($model)
        ->setModelServer($modelServer);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $gkeInferenceQuickstartClient->fetchModelServerVersions($request);

        /** @var string $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element);
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
    $model = '[MODEL]';
    $modelServer = '[MODEL_SERVER]';

    fetch_model_server_versions_sample($model, $modelServer);
}
// [END gkerecommender_v1_generated_GkeInferenceQuickstart_FetchModelServerVersions_sync]
