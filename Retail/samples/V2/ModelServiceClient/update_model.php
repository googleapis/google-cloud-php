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

// [START retail_v2_generated_ModelService_UpdateModel_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Retail\V2\Client\ModelServiceClient;
use Google\Cloud\Retail\V2\Model;
use Google\Cloud\Retail\V2\UpdateModelRequest;

/**
 * Update of model metadata. Only fields that
 * currently can be updated are: `filtering_option` and
 * `periodic_tuning_state`.
 * If other values are provided, this API method ignores them.
 *
 * @param string $modelName        The fully qualified resource name of the model.
 *
 *                                 Format:
 *                                 `projects/{project_number}/locations/{location_id}/catalogs/{catalog_id}/models/{model_id}`
 *                                 catalog_id has char limit of 50.
 *                                 recommendation_model_id has char limit of 40.
 * @param string $modelDisplayName The display name of the model.
 *
 *                                 Should be human readable, used to display Recommendation Models in the
 *                                 Retail Cloud Console Dashboard. UTF-8 encoded string with limit of 1024
 *                                 characters.
 * @param string $modelType        The type of model e.g. `home-page`.
 *
 *                                 Currently supported values: `recommended-for-you`, `others-you-may-like`,
 *                                 `frequently-bought-together`, `page-optimization`, `similar-items`,
 *                                 `buy-it-again`, `on-sale-items`, and `recently-viewed`(readonly value).
 *
 *
 *                                 This field together with
 *                                 [optimization_objective][google.cloud.retail.v2.Model.optimization_objective]
 *                                 describe model metadata to use to control model training and serving.
 *                                 See https://cloud.google.com/retail/docs/models
 *                                 for more details on what the model metadata control and which combination
 *                                 of parameters are valid. For invalid combinations of parameters (e.g. type
 *                                 = `frequently-bought-together` and optimization_objective = `ctr`), you
 *                                 receive an error 400 if you try to create/update a recommendation with
 *                                 this set of knobs.
 */
function update_model_sample(string $modelName, string $modelDisplayName, string $modelType): void
{
    // Create a client.
    $modelServiceClient = new ModelServiceClient();

    // Prepare the request message.
    $model = (new Model())
        ->setName($modelName)
        ->setDisplayName($modelDisplayName)
        ->setType($modelType);
    $request = (new UpdateModelRequest())
        ->setModel($model);

    // Call the API and handle any network failures.
    try {
        /** @var Model $response */
        $response = $modelServiceClient->updateModel($request);
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
    $modelName = '[NAME]';
    $modelDisplayName = '[DISPLAY_NAME]';
    $modelType = '[TYPE]';

    update_model_sample($modelName, $modelDisplayName, $modelType);
}
// [END retail_v2_generated_ModelService_UpdateModel_sync]
