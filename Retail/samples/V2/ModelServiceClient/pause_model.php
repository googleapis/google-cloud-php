<?php
/*
 * Copyright 2023 Google LLC
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

// [START retail_v2_generated_ModelService_PauseModel_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Retail\V2\Model;
use Google\Cloud\Retail\V2\ModelServiceClient;

/**
 * Pauses the training of an existing model.
 *
 * @param string $formattedName The name of the model to pause.
 *                              Format:
 *                              `projects/{project_number}/locations/{location_id}/catalogs/{catalog_id}/models/{model_id}`
 *                              Please see {@see ModelServiceClient::modelName()} for help formatting this field.
 */
function pause_model_sample(string $formattedName): void
{
    // Create a client.
    $modelServiceClient = new ModelServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var Model $response */
        $response = $modelServiceClient->pauseModel($formattedName);
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
    $formattedName = ModelServiceClient::modelName('[PROJECT]', '[LOCATION]', '[CATALOG]', '[MODEL]');

    pause_model_sample($formattedName);
}
// [END retail_v2_generated_ModelService_PauseModel_sync]
