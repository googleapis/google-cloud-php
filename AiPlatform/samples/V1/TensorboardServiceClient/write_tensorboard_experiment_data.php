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

// [START aiplatform_v1_generated_TensorboardService_WriteTensorboardExperimentData_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\TensorboardServiceClient;
use Google\Cloud\AIPlatform\V1\TensorboardTimeSeries\ValueType;
use Google\Cloud\AIPlatform\V1\TimeSeriesData;
use Google\Cloud\AIPlatform\V1\TimeSeriesDataPoint;
use Google\Cloud\AIPlatform\V1\WriteTensorboardExperimentDataResponse;
use Google\Cloud\AIPlatform\V1\WriteTensorboardRunDataRequest;

/**
 * Write time series data points of multiple TensorboardTimeSeries in multiple
 * TensorboardRun's. If any data fail to be ingested, an error will be
 * returned.
 *
 * @param string $formattedTensorboardExperiment                            The resource name of the TensorboardExperiment to write data to.
 *                                                                          Format:
 *                                                                          `projects/{project}/locations/{location}/tensorboards/{tensorboard}/experiments/{experiment}`
 *                                                                          Please see {@see TensorboardServiceClient::tensorboardExperimentName()} for help formatting this field.
 * @param string $formattedWriteRunDataRequestsTensorboardRun               The resource name of the TensorboardRun to write data to.
 *                                                                          Format:
 *                                                                          `projects/{project}/locations/{location}/tensorboards/{tensorboard}/experiments/{experiment}/runs/{run}`
 *                                                                          Please see {@see TensorboardServiceClient::tensorboardRunName()} for help formatting this field.
 * @param string $writeRunDataRequestsTimeSeriesDataTensorboardTimeSeriesId The ID of the TensorboardTimeSeries, which will become the final component
 *                                                                          of the TensorboardTimeSeries' resource name
 * @param int    $writeRunDataRequestsTimeSeriesDataValueType               Immutable. The value type of this time series. All the values in this time series data
 *                                                                          must match this value type.
 */
function write_tensorboard_experiment_data_sample(
    string $formattedTensorboardExperiment,
    string $formattedWriteRunDataRequestsTensorboardRun,
    string $writeRunDataRequestsTimeSeriesDataTensorboardTimeSeriesId,
    int $writeRunDataRequestsTimeSeriesDataValueType
): void {
    // Create a client.
    $tensorboardServiceClient = new TensorboardServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $writeRunDataRequestsTimeSeriesDataValues = [new TimeSeriesDataPoint()];
    $timeSeriesData = (new TimeSeriesData())
        ->setTensorboardTimeSeriesId($writeRunDataRequestsTimeSeriesDataTensorboardTimeSeriesId)
        ->setValueType($writeRunDataRequestsTimeSeriesDataValueType)
        ->setValues($writeRunDataRequestsTimeSeriesDataValues);
    $writeRunDataRequestsTimeSeriesData = [$timeSeriesData,];
    $writeTensorboardRunDataRequest = (new WriteTensorboardRunDataRequest())
        ->setTensorboardRun($formattedWriteRunDataRequestsTensorboardRun)
        ->setTimeSeriesData($writeRunDataRequestsTimeSeriesData);
    $writeRunDataRequests = [$writeTensorboardRunDataRequest,];

    // Call the API and handle any network failures.
    try {
        /** @var WriteTensorboardExperimentDataResponse $response */
        $response = $tensorboardServiceClient->writeTensorboardExperimentData(
            $formattedTensorboardExperiment,
            $writeRunDataRequests
        );
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
    $formattedTensorboardExperiment = TensorboardServiceClient::tensorboardExperimentName(
        '[PROJECT]',
        '[LOCATION]',
        '[TENSORBOARD]',
        '[EXPERIMENT]'
    );
    $formattedWriteRunDataRequestsTensorboardRun = TensorboardServiceClient::tensorboardRunName(
        '[PROJECT]',
        '[LOCATION]',
        '[TENSORBOARD]',
        '[EXPERIMENT]',
        '[RUN]'
    );
    $writeRunDataRequestsTimeSeriesDataTensorboardTimeSeriesId = '[TENSORBOARD_TIME_SERIES_ID]';
    $writeRunDataRequestsTimeSeriesDataValueType = ValueType::VALUE_TYPE_UNSPECIFIED;

    write_tensorboard_experiment_data_sample(
        $formattedTensorboardExperiment,
        $formattedWriteRunDataRequestsTensorboardRun,
        $writeRunDataRequestsTimeSeriesDataTensorboardTimeSeriesId,
        $writeRunDataRequestsTimeSeriesDataValueType
    );
}
// [END aiplatform_v1_generated_TensorboardService_WriteTensorboardExperimentData_sync]
