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

// [START aiplatform_v1_generated_TensorboardService_ReadTensorboardBlobData_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\ServerStream;
use Google\Cloud\AIPlatform\V1\Client\TensorboardServiceClient;
use Google\Cloud\AIPlatform\V1\ReadTensorboardBlobDataRequest;
use Google\Cloud\AIPlatform\V1\ReadTensorboardBlobDataResponse;

/**
 * Gets bytes of TensorboardBlobs.
 * This is to allow reading blob data stored in consumer project's Cloud
 * Storage bucket without users having to obtain Cloud Storage access
 * permission.
 *
 * @param string $formattedTimeSeries The resource name of the TensorboardTimeSeries to list Blobs.
 *                                    Format:
 *                                    `projects/{project}/locations/{location}/tensorboards/{tensorboard}/experiments/{experiment}/runs/{run}/timeSeries/{time_series}`
 *                                    Please see {@see TensorboardServiceClient::tensorboardTimeSeriesName()} for help formatting this field.
 */
function read_tensorboard_blob_data_sample(string $formattedTimeSeries): void
{
    // Create a client.
    $tensorboardServiceClient = new TensorboardServiceClient();

    // Prepare the request message.
    $request = (new ReadTensorboardBlobDataRequest())
        ->setTimeSeries($formattedTimeSeries);

    // Call the API and handle any network failures.
    try {
        /** @var ServerStream $stream */
        $stream = $tensorboardServiceClient->readTensorboardBlobData($request);

        /** @var ReadTensorboardBlobDataResponse $element */
        foreach ($stream->readAll() as $element) {
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
    $formattedTimeSeries = TensorboardServiceClient::tensorboardTimeSeriesName(
        '[PROJECT]',
        '[LOCATION]',
        '[TENSORBOARD]',
        '[EXPERIMENT]',
        '[RUN]',
        '[TIME_SERIES]'
    );

    read_tensorboard_blob_data_sample($formattedTimeSeries);
}
// [END aiplatform_v1_generated_TensorboardService_ReadTensorboardBlobData_sync]
