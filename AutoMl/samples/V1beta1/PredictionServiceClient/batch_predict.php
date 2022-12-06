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

// [START automl_v1beta1_generated_PredictionService_BatchPredict_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AutoMl\V1beta1\BatchPredictInputConfig;
use Google\Cloud\AutoMl\V1beta1\BatchPredictOutputConfig;
use Google\Cloud\AutoMl\V1beta1\BatchPredictResult;
use Google\Cloud\AutoMl\V1beta1\PredictionServiceClient;
use Google\Rpc\Status;

/**
 * Perform a batch prediction. Unlike the online [Predict][google.cloud.automl.v1beta1.PredictionService.Predict], batch
 * prediction result won't be immediately available in the response. Instead,
 * a long running operation object is returned. User can poll the operation
 * result via [GetOperation][google.longrunning.Operations.GetOperation]
 * method. Once the operation is done, [BatchPredictResult][google.cloud.automl.v1beta1.BatchPredictResult] is returned in
 * the [response][google.longrunning.Operation.response] field.
 * Available for following ML problems:
 * * Image Classification
 * * Image Object Detection
 * * Video Classification
 * * Video Object Tracking * Text Extraction
 * * Tables
 *
 * @param string $formattedName Name of the model requested to serve the batch prediction. Please see
 *                              {@see PredictionServiceClient::modelName()} for help formatting this field.
 */
function batch_predict_sample(string $formattedName): void
{
    // Create a client.
    $predictionServiceClient = new PredictionServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $inputConfig = new BatchPredictInputConfig();
    $outputConfig = new BatchPredictOutputConfig();
    $params = [];

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $predictionServiceClient->batchPredict(
            $formattedName,
            $inputConfig,
            $outputConfig,
            $params
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var BatchPredictResult $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
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
    $formattedName = PredictionServiceClient::modelName('[PROJECT]', '[LOCATION]', '[MODEL]');

    batch_predict_sample($formattedName);
}
// [END automl_v1beta1_generated_PredictionService_BatchPredict_sync]
