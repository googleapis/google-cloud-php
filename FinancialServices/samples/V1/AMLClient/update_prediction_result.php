<?php
/*
 * Copyright 2025 Google LLC
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

// [START financialservices_v1_generated_AML_UpdatePredictionResult_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Financialservices\V1\BigQueryDestination;
use Google\Cloud\Financialservices\V1\BigQueryDestination\WriteDisposition;
use Google\Cloud\Financialservices\V1\Client\AMLClient;
use Google\Cloud\Financialservices\V1\PredictionResult;
use Google\Cloud\Financialservices\V1\PredictionResult\Outputs;
use Google\Cloud\Financialservices\V1\UpdatePredictionResultRequest;
use Google\Protobuf\Timestamp;
use Google\Rpc\Status;

/**
 * Updates the parameters of a single PredictionResult.
 *
 * @param string $formattedPredictionResultDataset                             The resource name of the Dataset to do predictions on
 *                                                                             Format:
 *                                                                             "/projects/{project_num}/locations/{location}/instances/{instance}/dataset/{dataset_id}"
 *                                                                             Please see {@see AMLClient::datasetName()} for help formatting this field.
 * @param string $formattedPredictionResultModel                               The resource name of the Model to use to use to make predictions
 *                                                                             Format:
 *                                                                             "/projects/{project_num}/locations/{location}/instances/{instance}/models/{model}"
 *                                                                             Please see {@see AMLClient::modelName()} for help formatting this field.
 * @param int    $predictionResultOutputsPredictionDestinationWriteDisposition Whether or not to overwrite destination table. By default the
 *                                                                             table won't be overwritten and an error will be returned if the table
 *                                                                             exists and contains data.
 */
function update_prediction_result_sample(
    string $formattedPredictionResultDataset,
    string $formattedPredictionResultModel,
    int $predictionResultOutputsPredictionDestinationWriteDisposition
): void {
    // Create a client.
    $aMLClient = new AMLClient();

    // Prepare the request message.
    $predictionResultEndTime = new Timestamp();
    $predictionResultOutputsPredictionDestination = (new BigQueryDestination())
        ->setWriteDisposition($predictionResultOutputsPredictionDestinationWriteDisposition);
    $predictionResultOutputs = (new Outputs())
        ->setPredictionDestination($predictionResultOutputsPredictionDestination);
    $predictionResult = (new PredictionResult())
        ->setDataset($formattedPredictionResultDataset)
        ->setModel($formattedPredictionResultModel)
        ->setEndTime($predictionResultEndTime)
        ->setOutputs($predictionResultOutputs);
    $request = (new UpdatePredictionResultRequest())
        ->setPredictionResult($predictionResult);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $aMLClient->updatePredictionResult($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var PredictionResult $result */
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
    $formattedPredictionResultDataset = AMLClient::datasetName(
        '[PROJECT_NUM]',
        '[LOCATION]',
        '[INSTANCE]',
        '[DATASET]'
    );
    $formattedPredictionResultModel = AMLClient::modelName(
        '[PROJECT_NUM]',
        '[LOCATION]',
        '[INSTANCE]',
        '[MODEL]'
    );
    $predictionResultOutputsPredictionDestinationWriteDisposition = WriteDisposition::WRITE_DISPOSITION_UNSPECIFIED;

    update_prediction_result_sample(
        $formattedPredictionResultDataset,
        $formattedPredictionResultModel,
        $predictionResultOutputsPredictionDestinationWriteDisposition
    );
}
// [END financialservices_v1_generated_AML_UpdatePredictionResult_sync]
