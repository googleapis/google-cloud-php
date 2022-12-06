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

// [START aiplatform_v1_generated_TensorboardService_ReadTensorboardTimeSeriesData_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\ReadTensorboardTimeSeriesDataResponse;
use Google\Cloud\AIPlatform\V1\TensorboardServiceClient;

/**
 * Reads a TensorboardTimeSeries' data. By default, if the number of data
 * points stored is less than 1000, all data will be returned. Otherwise, 1000
 * data points will be randomly selected from this time series and returned.
 * This value can be changed by changing max_data_points, which can't be
 * greater than 10k.
 *
 * @param string $formattedTensorboardTimeSeries The resource name of the TensorboardTimeSeries to read data from.
 *                                               Format:
 *                                               `projects/{project}/locations/{location}/tensorboards/{tensorboard}/experiments/{experiment}/runs/{run}/timeSeries/{time_series}`
 *                                               Please see {@see TensorboardServiceClient::tensorboardTimeSeriesName()} for help formatting this field.
 */
function read_tensorboard_time_series_data_sample(string $formattedTensorboardTimeSeries): void
{
    // Create a client.
    $tensorboardServiceClient = new TensorboardServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var ReadTensorboardTimeSeriesDataResponse $response */
        $response = $tensorboardServiceClient->readTensorboardTimeSeriesData(
            $formattedTensorboardTimeSeries
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
    $formattedTensorboardTimeSeries = TensorboardServiceClient::tensorboardTimeSeriesName(
        '[PROJECT]',
        '[LOCATION]',
        '[TENSORBOARD]',
        '[EXPERIMENT]',
        '[RUN]',
        '[TIME_SERIES]'
    );

    read_tensorboard_time_series_data_sample($formattedTensorboardTimeSeries);
}
// [END aiplatform_v1_generated_TensorboardService_ReadTensorboardTimeSeriesData_sync]
