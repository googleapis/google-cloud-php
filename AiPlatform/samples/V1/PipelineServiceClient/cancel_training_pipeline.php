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

// [START aiplatform_v1_generated_PipelineService_CancelTrainingPipeline_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\CancelTrainingPipelineRequest;
use Google\Cloud\AIPlatform\V1\Client\PipelineServiceClient;

/**
 * Cancels a TrainingPipeline.
 * Starts asynchronous cancellation on the TrainingPipeline. The server
 * makes a best effort to cancel the pipeline, but success is not
 * guaranteed. Clients can use
 * [PipelineService.GetTrainingPipeline][google.cloud.aiplatform.v1.PipelineService.GetTrainingPipeline]
 * or other methods to check whether the cancellation succeeded or whether the
 * pipeline completed despite cancellation. On successful cancellation,
 * the TrainingPipeline is not deleted; instead it becomes a pipeline with
 * a
 * [TrainingPipeline.error][google.cloud.aiplatform.v1.TrainingPipeline.error]
 * value with a [google.rpc.Status.code][google.rpc.Status.code] of 1,
 * corresponding to `Code.CANCELLED`, and
 * [TrainingPipeline.state][google.cloud.aiplatform.v1.TrainingPipeline.state]
 * is set to `CANCELLED`.
 *
 * @param string $formattedName The name of the TrainingPipeline to cancel.
 *                              Format:
 *                              `projects/{project}/locations/{location}/trainingPipelines/{training_pipeline}`
 *                              Please see {@see PipelineServiceClient::trainingPipelineName()} for help formatting this field.
 */
function cancel_training_pipeline_sample(string $formattedName): void
{
    // Create a client.
    $pipelineServiceClient = new PipelineServiceClient();

    // Prepare the request message.
    $request = (new CancelTrainingPipelineRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $pipelineServiceClient->cancelTrainingPipeline($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = PipelineServiceClient::trainingPipelineName(
        '[PROJECT]',
        '[LOCATION]',
        '[TRAINING_PIPELINE]'
    );

    cancel_training_pipeline_sample($formattedName);
}
// [END aiplatform_v1_generated_PipelineService_CancelTrainingPipeline_sync]
