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

// [START gkerecommender_v1_generated_GkeInferenceQuickstart_FetchModelServers_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\GkeRecommender\V1\Client\GkeInferenceQuickstartClient;
use Google\Cloud\GkeRecommender\V1\FetchModelServersRequest;

/**
 * Fetches available model servers. Open-source model servers use simplified,
 * lowercase names (e.g., `vllm`).
 *
 * @param string $model The model for which to list model servers. Open-source models
 *                      follow the Huggingface Hub `owner/model_name` format. Use
 *                      [GkeInferenceQuickstart.FetchModels][google.cloud.gkerecommender.v1.GkeInferenceQuickstart.FetchModels]
 *                      to find available models.
 */
function fetch_model_servers_sample(string $model): void
{
    // Create a client.
    $gkeInferenceQuickstartClient = new GkeInferenceQuickstartClient();

    // Prepare the request message.
    $request = (new FetchModelServersRequest())
        ->setModel($model);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $gkeInferenceQuickstartClient->fetchModelServers($request);

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

    fetch_model_servers_sample($model);
}
// [END gkerecommender_v1_generated_GkeInferenceQuickstart_FetchModelServers_sync]
