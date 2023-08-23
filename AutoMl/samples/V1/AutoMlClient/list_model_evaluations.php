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

// [START automl_v1_generated_AutoMl_ListModelEvaluations_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\AutoMl\V1\AutoMlClient;
use Google\Cloud\AutoMl\V1\ModelEvaluation;

/**
 * Lists model evaluations.
 *
 * @param string $formattedParent Resource name of the model to list the model evaluations for.
 *                                If modelId is set as "-", this will list model evaluations from across all
 *                                models of the parent location. Please see
 *                                {@see AutoMlClient::modelName()} for help formatting this field.
 * @param string $filter          An expression for filtering the results of the request.
 *
 *                                * `annotation_spec_id` - for =, !=  or existence. See example below for
 *                                the last.
 *
 *                                Some examples of using the filter are:
 *
 *                                * `annotation_spec_id!=4` --> The model evaluation was done for
 *                                annotation spec with ID different than 4.
 *                                * `NOT annotation_spec_id:*` --> The model evaluation was done for
 *                                aggregate of all annotation specs.
 */
function list_model_evaluations_sample(string $formattedParent, string $filter): void
{
    // Create a client.
    $autoMlClient = new AutoMlClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $autoMlClient->listModelEvaluations($formattedParent, $filter);

        /** @var ModelEvaluation $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedParent = AutoMlClient::modelName('[PROJECT]', '[LOCATION]', '[MODEL]');
    $filter = '[FILTER]';

    list_model_evaluations_sample($formattedParent, $filter);
}
// [END automl_v1_generated_AutoMl_ListModelEvaluations_sync]
