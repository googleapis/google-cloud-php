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

// [START aiplatform_v1_generated_TensorboardService_BatchCreateTensorboardTimeSeries_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\BatchCreateTensorboardTimeSeriesResponse;
use Google\Cloud\AIPlatform\V1\CreateTensorboardTimeSeriesRequest;
use Google\Cloud\AIPlatform\V1\TensorboardServiceClient;
use Google\Cloud\AIPlatform\V1\TensorboardTimeSeries;
use Google\Cloud\AIPlatform\V1\TensorboardTimeSeries\ValueType;

/**
 * Batch create TensorboardTimeSeries that belong to a TensorboardExperiment.
 *
 * @param string $formattedParent                          The resource name of the TensorboardExperiment to create the
 *                                                         TensorboardTimeSeries in.
 *                                                         Format:
 *                                                         `projects/{project}/locations/{location}/tensorboards/{tensorboard}/experiments/{experiment}`
 *                                                         The TensorboardRuns referenced by the parent fields in the
 *                                                         CreateTensorboardTimeSeriesRequest messages must be sub resources of this
 *                                                         TensorboardExperiment. Please see
 *                                                         {@see TensorboardServiceClient::tensorboardExperimentName()} for help formatting this field.
 * @param string $formattedRequestsParent                  The resource name of the TensorboardRun to create the
 *                                                         TensorboardTimeSeries in.
 *                                                         Format:
 *                                                         `projects/{project}/locations/{location}/tensorboards/{tensorboard}/experiments/{experiment}/runs/{run}`
 *                                                         Please see {@see TensorboardServiceClient::tensorboardTimeSeriesName()} for help formatting this field.
 * @param string $requestsTensorboardTimeSeriesDisplayName User provided name of this TensorboardTimeSeries.
 *                                                         This value should be unique among all TensorboardTimeSeries resources
 *                                                         belonging to the same TensorboardRun resource (parent resource).
 * @param int    $requestsTensorboardTimeSeriesValueType   Immutable. Type of TensorboardTimeSeries value.
 */
function batch_create_tensorboard_time_series_sample(
    string $formattedParent,
    string $formattedRequestsParent,
    string $requestsTensorboardTimeSeriesDisplayName,
    int $requestsTensorboardTimeSeriesValueType
): void {
    // Create a client.
    $tensorboardServiceClient = new TensorboardServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $requestsTensorboardTimeSeries = (new TensorboardTimeSeries())
        ->setDisplayName($requestsTensorboardTimeSeriesDisplayName)
        ->setValueType($requestsTensorboardTimeSeriesValueType);
    $createTensorboardTimeSeriesRequest = (new CreateTensorboardTimeSeriesRequest())
        ->setParent($formattedRequestsParent)
        ->setTensorboardTimeSeries($requestsTensorboardTimeSeries);
    $requests = [$createTensorboardTimeSeriesRequest,];

    // Call the API and handle any network failures.
    try {
        /** @var BatchCreateTensorboardTimeSeriesResponse $response */
        $response = $tensorboardServiceClient->batchCreateTensorboardTimeSeries(
            $formattedParent,
            $requests
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
    $formattedParent = TensorboardServiceClient::tensorboardExperimentName(
        '[PROJECT]',
        '[LOCATION]',
        '[TENSORBOARD]',
        '[EXPERIMENT]'
    );
    $formattedRequestsParent = TensorboardServiceClient::tensorboardTimeSeriesName(
        '[PROJECT]',
        '[LOCATION]',
        '[TENSORBOARD]',
        '[EXPERIMENT]',
        '[RUN]',
        '[TIME_SERIES]'
    );
    $requestsTensorboardTimeSeriesDisplayName = '[DISPLAY_NAME]';
    $requestsTensorboardTimeSeriesValueType = ValueType::VALUE_TYPE_UNSPECIFIED;

    batch_create_tensorboard_time_series_sample(
        $formattedParent,
        $formattedRequestsParent,
        $requestsTensorboardTimeSeriesDisplayName,
        $requestsTensorboardTimeSeriesValueType
    );
}
// [END aiplatform_v1_generated_TensorboardService_BatchCreateTensorboardTimeSeries_sync]
