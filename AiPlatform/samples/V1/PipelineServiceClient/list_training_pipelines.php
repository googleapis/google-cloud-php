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

// [START aiplatform_v1_generated_PipelineService_ListTrainingPipelines_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\AIPlatform\V1\Client\PipelineServiceClient;
use Google\Cloud\AIPlatform\V1\ListTrainingPipelinesRequest;
use Google\Cloud\AIPlatform\V1\TrainingPipeline;

/**
 * Lists TrainingPipelines in a Location.
 *
 * @param string $formattedParent The resource name of the Location to list the TrainingPipelines
 *                                from. Format: `projects/{project}/locations/{location}`
 *                                Please see {@see PipelineServiceClient::locationName()} for help formatting this field.
 */
function list_training_pipelines_sample(string $formattedParent): void
{
    // Create a client.
    $pipelineServiceClient = new PipelineServiceClient();

    // Prepare the request message.
    $request = (new ListTrainingPipelinesRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $pipelineServiceClient->listTrainingPipelines($request);

        /** @var TrainingPipeline $element */
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
    $formattedParent = PipelineServiceClient::locationName('[PROJECT]', '[LOCATION]');

    list_training_pipelines_sample($formattedParent);
}
// [END aiplatform_v1_generated_PipelineService_ListTrainingPipelines_sync]
