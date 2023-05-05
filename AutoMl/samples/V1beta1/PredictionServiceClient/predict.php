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

// [START automl_v1beta1_generated_PredictionService_Predict_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AutoMl\V1beta1\ExamplePayload;
use Google\Cloud\AutoMl\V1beta1\PredictResponse;
use Google\Cloud\AutoMl\V1beta1\PredictionServiceClient;

/**
 * Perform an online prediction. The prediction result will be directly
 * returned in the response.
 * Available for following ML problems, and their expected request payloads:
 * * Image Classification - Image in .JPEG, .GIF or .PNG format, image_bytes
 * up to 30MB.
 * * Image Object Detection - Image in .JPEG, .GIF or .PNG format, image_bytes
 * up to 30MB.
 * * Text Classification - TextSnippet, content up to 60,000 characters,
 * UTF-8 encoded.
 * * Text Extraction - TextSnippet, content up to 30,000 characters,
 * UTF-8 NFC encoded.
 * * Translation - TextSnippet, content up to 25,000 characters, UTF-8
 * encoded.
 * * Tables - Row, with column values matching the columns of the model,
 * up to 5MB. Not available for FORECASTING
 *
 * [prediction_type][google.cloud.automl.v1beta1.TablesModelMetadata.prediction_type].
 * * Text Sentiment - TextSnippet, content up 500 characters, UTF-8
 * encoded.
 *
 * @param string $formattedName Name of the model requested to serve the prediction. Please see
 *                              {@see PredictionServiceClient::modelName()} for help formatting this field.
 */
function predict_sample(string $formattedName): void
{
    // Create a client.
    $predictionServiceClient = new PredictionServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $payload = new ExamplePayload();

    // Call the API and handle any network failures.
    try {
        /** @var PredictResponse $response */
        $response = $predictionServiceClient->predict($formattedName, $payload);
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
    $formattedName = PredictionServiceClient::modelName('[PROJECT]', '[LOCATION]', '[MODEL]');

    predict_sample($formattedName);
}
// [END automl_v1beta1_generated_PredictionService_Predict_sync]
