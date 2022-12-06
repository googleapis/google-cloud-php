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

// [START aiplatform_v1_generated_ModelService_GetModel_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Model;
use Google\Cloud\AIPlatform\V1\ModelServiceClient;

/**
 * Gets a Model.
 *
 * @param string $formattedName The name of the Model resource.
 *                              Format: `projects/{project}/locations/{location}/models/{model}`
 *
 *                              In order to retrieve a specific version of the model, also provide
 *                              the version ID or version alias.
 *                              Example: `projects/{project}/locations/{location}/models/{model}&#64;2`
 *                              or
 *                              `projects/{project}/locations/{location}/models/{model}&#64;golden`
 *                              If no version ID or alias is specified, the "default" version will be
 *                              returned. The "default" version alias is created for the first version of
 *                              the model, and can be moved to other versions later on. There will be
 *                              exactly one default version. Please see
 *                              {@see ModelServiceClient::modelName()} for help formatting this field.
 */
function get_model_sample(string $formattedName): void
{
    // Create a client.
    $modelServiceClient = new ModelServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var Model $response */
        $response = $modelServiceClient->getModel($formattedName);
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
    $formattedName = ModelServiceClient::modelName('[PROJECT]', '[LOCATION]', '[MODEL]');

    get_model_sample($formattedName);
}
// [END aiplatform_v1_generated_ModelService_GetModel_sync]
