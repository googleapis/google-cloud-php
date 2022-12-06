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

// [START aiplatform_v1_generated_PipelineService_CreateTrainingPipeline_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\PipelineServiceClient;
use Google\Cloud\AIPlatform\V1\TrainingPipeline;
use Google\Protobuf\Value;

/**
 * Creates a TrainingPipeline. A created TrainingPipeline right away will be
 * attempted to be run.
 *
 * @param string $formattedParent                        The resource name of the Location to create the TrainingPipeline in.
 *                                                       Format: `projects/{project}/locations/{location}`
 *                                                       Please see {@see PipelineServiceClient::locationName()} for help formatting this field.
 * @param string $trainingPipelineDisplayName            The user-defined name of this TrainingPipeline.
 * @param string $trainingPipelineTrainingTaskDefinition A Google Cloud Storage path to the YAML file that defines the training task
 *                                                       which is responsible for producing the model artifact, and may also include
 *                                                       additional auxiliary work.
 *                                                       The definition files that can be used here are found in
 *                                                       gs://google-cloud-aiplatform/schema/trainingjob/definition/.
 *                                                       Note: The URI given on output will be immutable and probably different,
 *                                                       including the URI scheme, than the one given on input. The output URI will
 *                                                       point to a location where the user only has a read access.
 */
function create_training_pipeline_sample(
    string $formattedParent,
    string $trainingPipelineDisplayName,
    string $trainingPipelineTrainingTaskDefinition
): void {
    // Create a client.
    $pipelineServiceClient = new PipelineServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $trainingPipelineTrainingTaskInputs = new Value();
    $trainingPipeline = (new TrainingPipeline())
        ->setDisplayName($trainingPipelineDisplayName)
        ->setTrainingTaskDefinition($trainingPipelineTrainingTaskDefinition)
        ->setTrainingTaskInputs($trainingPipelineTrainingTaskInputs);

    // Call the API and handle any network failures.
    try {
        /** @var TrainingPipeline $response */
        $response = $pipelineServiceClient->createTrainingPipeline($formattedParent, $trainingPipeline);
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
    $formattedParent = PipelineServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $trainingPipelineDisplayName = '[DISPLAY_NAME]';
    $trainingPipelineTrainingTaskDefinition = '[TRAINING_TASK_DEFINITION]';

    create_training_pipeline_sample(
        $formattedParent,
        $trainingPipelineDisplayName,
        $trainingPipelineTrainingTaskDefinition
    );
}
// [END aiplatform_v1_generated_PipelineService_CreateTrainingPipeline_sync]
