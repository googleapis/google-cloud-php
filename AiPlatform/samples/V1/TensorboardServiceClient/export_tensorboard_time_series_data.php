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

// [START aiplatform_v1_generated_TensorboardService_ExportTensorboardTimeSeriesData_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\AIPlatform\V1\TensorboardServiceClient;
use Google\Cloud\AIPlatform\V1\TimeSeriesDataPoint;

/**
 * Exports a TensorboardTimeSeries' data. Data is returned in paginated
 * responses.
 *
 * @param string $formattedTensorboardTimeSeries The resource name of the TensorboardTimeSeries to export data from.
 *                                               Format:
 *                                               `projects/{project}/locations/{location}/tensorboards/{tensorboard}/experiments/{experiment}/runs/{run}/timeSeries/{time_series}`
 *                                               Please see {@see TensorboardServiceClient::tensorboardTimeSeriesName()} for help formatting this field.
 */
function export_tensorboard_time_series_data_sample(string $formattedTensorboardTimeSeries): void
{
    // Create a client.
    $tensorboardServiceClient = new TensorboardServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $tensorboardServiceClient->exportTensorboardTimeSeriesData(
            $formattedTensorboardTimeSeries
        );

        /** @var TimeSeriesDataPoint $element */
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
    $formattedTensorboardTimeSeries = TensorboardServiceClient::tensorboardTimeSeriesName(
        '[PROJECT]',
        '[LOCATION]',
        '[TENSORBOARD]',
        '[EXPERIMENT]',
        '[RUN]',
        '[TIME_SERIES]'
    );

    export_tensorboard_time_series_data_sample($formattedTensorboardTimeSeries);
}
// [END aiplatform_v1_generated_TensorboardService_ExportTensorboardTimeSeriesData_sync]
