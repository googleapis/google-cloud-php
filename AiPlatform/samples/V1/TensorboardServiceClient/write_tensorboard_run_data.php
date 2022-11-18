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

// [START aiplatform_v1_generated_TensorboardService_WriteTensorboardRunData_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\TensorboardServiceClient;
use Google\Cloud\AIPlatform\V1\TensorboardTimeSeries\ValueType;
use Google\Cloud\AIPlatform\V1\TimeSeriesData;
use Google\Cloud\AIPlatform\V1\TimeSeriesDataPoint;
use Google\Cloud\AIPlatform\V1\WriteTensorboardRunDataResponse;

/**
 * Write time series data points into multiple TensorboardTimeSeries under
 * a TensorboardRun. If any data fail to be ingested, an error will be
 * returned.
 *
 * @param string $formattedTensorboardRun               The resource name of the TensorboardRun to write data to.
 *                                                      Format:
 *                                                      `projects/{project}/locations/{location}/tensorboards/{tensorboard}/experiments/{experiment}/runs/{run}`
 *                                                      Please see {@see TensorboardServiceClient::tensorboardRunName()} for help formatting this field.
 * @param string $timeSeriesDataTensorboardTimeSeriesId The ID of the TensorboardTimeSeries, which will become the final component
 *                                                      of the TensorboardTimeSeries' resource name
 * @param int    $timeSeriesDataValueType               Immutable. The value type of this time series. All the values in this time series data
 *                                                      must match this value type.
 */
function write_tensorboard_run_data_sample(
    string $formattedTensorboardRun,
    string $timeSeriesDataTensorboardTimeSeriesId,
    int $timeSeriesDataValueType
): void {
    // Create a client.
    $tensorboardServiceClient = new TensorboardServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $timeSeriesDataValues = [new TimeSeriesDataPoint()];
    $timeSeriesData = (new TimeSeriesData())
        ->setTensorboardTimeSeriesId($timeSeriesDataTensorboardTimeSeriesId)
        ->setValueType($timeSeriesDataValueType)
        ->setValues($timeSeriesDataValues);
    $timeSeriesData = [$timeSeriesData,];

    // Call the API and handle any network failures.
    try {
        /** @var WriteTensorboardRunDataResponse $response */
        $response = $tensorboardServiceClient->writeTensorboardRunData(
            $formattedTensorboardRun,
            $timeSeriesData
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
    $formattedTensorboardRun = TensorboardServiceClient::tensorboardRunName(
        '[PROJECT]',
        '[LOCATION]',
        '[TENSORBOARD]',
        '[EXPERIMENT]',
        '[RUN]'
    );
    $timeSeriesDataTensorboardTimeSeriesId = '[TENSORBOARD_TIME_SERIES_ID]';
    $timeSeriesDataValueType = ValueType::VALUE_TYPE_UNSPECIFIED;

    write_tensorboard_run_data_sample(
        $formattedTensorboardRun,
        $timeSeriesDataTensorboardTimeSeriesId,
        $timeSeriesDataValueType
    );
}
// [END aiplatform_v1_generated_TensorboardService_WriteTensorboardRunData_sync]
