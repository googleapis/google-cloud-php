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

// [START aiplatform_v1_generated_ModelService_BatchImportModelEvaluationSlices_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\BatchImportModelEvaluationSlicesRequest;
use Google\Cloud\AIPlatform\V1\BatchImportModelEvaluationSlicesResponse;
use Google\Cloud\AIPlatform\V1\Client\ModelServiceClient;
use Google\Cloud\AIPlatform\V1\ModelEvaluationSlice;

/**
 * Imports a list of externally generated ModelEvaluationSlice.
 *
 * @param string $formattedParent The name of the parent ModelEvaluation resource.
 *                                Format:
 *                                `projects/{project}/locations/{location}/models/{model}/evaluations/{evaluation}`
 *                                Please see {@see ModelServiceClient::modelEvaluationName()} for help formatting this field.
 */
function batch_import_model_evaluation_slices_sample(string $formattedParent): void
{
    // Create a client.
    $modelServiceClient = new ModelServiceClient();

    // Prepare the request message.
    $modelEvaluationSlices = [new ModelEvaluationSlice()];
    $request = (new BatchImportModelEvaluationSlicesRequest())
        ->setParent($formattedParent)
        ->setModelEvaluationSlices($modelEvaluationSlices);

    // Call the API and handle any network failures.
    try {
        /** @var BatchImportModelEvaluationSlicesResponse $response */
        $response = $modelServiceClient->batchImportModelEvaluationSlices($request);
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
    $formattedParent = ModelServiceClient::modelEvaluationName(
        '[PROJECT]',
        '[LOCATION]',
        '[MODEL]',
        '[EVALUATION]'
    );

    batch_import_model_evaluation_slices_sample($formattedParent);
}
// [END aiplatform_v1_generated_ModelService_BatchImportModelEvaluationSlices_sync]
