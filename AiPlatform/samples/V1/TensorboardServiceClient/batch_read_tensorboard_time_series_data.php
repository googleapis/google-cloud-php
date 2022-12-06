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

// [START aiplatform_v1_generated_TensorboardService_BatchReadTensorboardTimeSeriesData_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\BatchReadTensorboardTimeSeriesDataResponse;
use Google\Cloud\AIPlatform\V1\TensorboardServiceClient;

/**
 * Reads multiple TensorboardTimeSeries' data. The data point number limit is
 * 1000 for scalars, 100 for tensors and blob references. If the number of
 * data points stored is less than the limit, all data will be returned.
 * Otherwise, that limit number of data points will be randomly selected from
 * this time series and returned.
 *
 * @param string $formattedTensorboard       The resource name of the Tensorboard containing TensorboardTimeSeries to
 *                                           read data from. Format:
 *                                           `projects/{project}/locations/{location}/tensorboards/{tensorboard}`.
 *                                           The TensorboardTimeSeries referenced by [time_series][google.cloud.aiplatform.v1.BatchReadTensorboardTimeSeriesDataRequest.time_series] must be sub
 *                                           resources of this Tensorboard. Please see
 *                                           {@see TensorboardServiceClient::tensorboardName()} for help formatting this field.
 * @param string $formattedTimeSeriesElement The resource names of the TensorboardTimeSeries to read data from. Format:
 *                                           `projects/{project}/locations/{location}/tensorboards/{tensorboard}/experiments/{experiment}/runs/{run}/timeSeries/{time_series}`
 *                                           Please see {@see TensorboardServiceClient::tensorboardTimeSeriesName()} for help formatting this field.
 */
function batch_read_tensorboard_time_series_data_sample(
    string $formattedTensorboard,
    string $formattedTimeSeriesElement
): void {
    // Create a client.
    $tensorboardServiceClient = new TensorboardServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $formattedTimeSeries = [$formattedTimeSeriesElement,];

    // Call the API and handle any network failures.
    try {
        /** @var BatchReadTensorboardTimeSeriesDataResponse $response */
        $response = $tensorboardServiceClient->batchReadTensorboardTimeSeriesData(
            $formattedTensorboard,
            $formattedTimeSeries
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
    $formattedTensorboard = TensorboardServiceClient::tensorboardName(
        '[PROJECT]',
        '[LOCATION]',
        '[TENSORBOARD]'
    );
    $formattedTimeSeriesElement = TensorboardServiceClient::tensorboardTimeSeriesName(
        '[PROJECT]',
        '[LOCATION]',
        '[TENSORBOARD]',
        '[EXPERIMENT]',
        '[RUN]',
        '[TIME_SERIES]'
    );

    batch_read_tensorboard_time_series_data_sample($formattedTensorboard, $formattedTimeSeriesElement);
}
// [END aiplatform_v1_generated_TensorboardService_BatchReadTensorboardTimeSeriesData_sync]
