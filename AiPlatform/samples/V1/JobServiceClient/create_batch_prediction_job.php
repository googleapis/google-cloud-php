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

// [START aiplatform_v1_generated_JobService_CreateBatchPredictionJob_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\BatchPredictionJob;
use Google\Cloud\AIPlatform\V1\BatchPredictionJob\InputConfig;
use Google\Cloud\AIPlatform\V1\BatchPredictionJob\OutputConfig;
use Google\Cloud\AIPlatform\V1\JobServiceClient;

/**
 * Creates a BatchPredictionJob. A BatchPredictionJob once created will
 * right away be attempted to start.
 *
 * @param string $formattedParent                                 The resource name of the Location to create the BatchPredictionJob in.
 *                                                                Format: `projects/{project}/locations/{location}`
 *                                                                Please see {@see JobServiceClient::locationName()} for help formatting this field.
 * @param string $batchPredictionJobDisplayName                   The user-defined name of this BatchPredictionJob.
 * @param string $batchPredictionJobInputConfigInstancesFormat    The format in which instances are given, must be one of the
 *                                                                [Model's][google.cloud.aiplatform.v1.BatchPredictionJob.model]
 *                                                                [supported_input_storage_formats][google.cloud.aiplatform.v1.Model.supported_input_storage_formats].
 * @param string $batchPredictionJobOutputConfigPredictionsFormat The format in which Vertex AI gives the predictions, must be one of the
 *                                                                [Model's][google.cloud.aiplatform.v1.BatchPredictionJob.model]
 *                                                                [supported_output_storage_formats][google.cloud.aiplatform.v1.Model.supported_output_storage_formats].
 */
function create_batch_prediction_job_sample(
    string $formattedParent,
    string $batchPredictionJobDisplayName,
    string $batchPredictionJobInputConfigInstancesFormat,
    string $batchPredictionJobOutputConfigPredictionsFormat
): void {
    // Create a client.
    $jobServiceClient = new JobServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $batchPredictionJobInputConfig = (new InputConfig())
        ->setInstancesFormat($batchPredictionJobInputConfigInstancesFormat);
    $batchPredictionJobOutputConfig = (new OutputConfig())
        ->setPredictionsFormat($batchPredictionJobOutputConfigPredictionsFormat);
    $batchPredictionJob = (new BatchPredictionJob())
        ->setDisplayName($batchPredictionJobDisplayName)
        ->setInputConfig($batchPredictionJobInputConfig)
        ->setOutputConfig($batchPredictionJobOutputConfig);

    // Call the API and handle any network failures.
    try {
        /** @var BatchPredictionJob $response */
        $response = $jobServiceClient->createBatchPredictionJob($formattedParent, $batchPredictionJob);
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
    $formattedParent = JobServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $batchPredictionJobDisplayName = '[DISPLAY_NAME]';
    $batchPredictionJobInputConfigInstancesFormat = '[INSTANCES_FORMAT]';
    $batchPredictionJobOutputConfigPredictionsFormat = '[PREDICTIONS_FORMAT]';

    create_batch_prediction_job_sample(
        $formattedParent,
        $batchPredictionJobDisplayName,
        $batchPredictionJobInputConfigInstancesFormat,
        $batchPredictionJobOutputConfigPredictionsFormat
    );
}
// [END aiplatform_v1_generated_JobService_CreateBatchPredictionJob_sync]
