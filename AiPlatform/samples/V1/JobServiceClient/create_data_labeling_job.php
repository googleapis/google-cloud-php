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

// [START aiplatform_v1_generated_JobService_CreateDataLabelingJob_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\DataLabelingJob;
use Google\Cloud\AIPlatform\V1\JobServiceClient;
use Google\Protobuf\Value;

/**
 * Creates a DataLabelingJob.
 *
 * @param string $formattedParent                         The parent of the DataLabelingJob.
 *                                                        Format: `projects/{project}/locations/{location}`
 *                                                        Please see {@see JobServiceClient::locationName()} for help formatting this field.
 * @param string $dataLabelingJobDisplayName              The user-defined name of the DataLabelingJob.
 *                                                        The name can be up to 128 characters long and can consist of any UTF-8
 *                                                        characters.
 *                                                        Display name of a DataLabelingJob.
 * @param string $formattedDataLabelingJobDatasetsElement Dataset resource names. Right now we only support labeling from a single
 *                                                        Dataset.
 *                                                        Format:
 *                                                        `projects/{project}/locations/{location}/datasets/{dataset}`
 *                                                        Please see {@see JobServiceClient::datasetName()} for help formatting this field.
 * @param int    $dataLabelingJobLabelerCount             Number of labelers to work on each DataItem.
 * @param string $dataLabelingJobInstructionUri           The Google Cloud Storage location of the instruction pdf. This pdf is
 *                                                        shared with labelers, and provides detailed description on how to label
 *                                                        DataItems in Datasets.
 * @param string $dataLabelingJobInputsSchemaUri          Points to a YAML file stored on Google Cloud Storage describing the
 *                                                        config for a specific type of DataLabelingJob.
 *                                                        The schema files that can be used here are found in the
 *                                                        https://storage.googleapis.com/google-cloud-aiplatform bucket in the
 *                                                        /schema/datalabelingjob/inputs/ folder.
 */
function create_data_labeling_job_sample(
    string $formattedParent,
    string $dataLabelingJobDisplayName,
    string $formattedDataLabelingJobDatasetsElement,
    int $dataLabelingJobLabelerCount,
    string $dataLabelingJobInstructionUri,
    string $dataLabelingJobInputsSchemaUri
): void {
    // Create a client.
    $jobServiceClient = new JobServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $formattedDataLabelingJobDatasets = [$formattedDataLabelingJobDatasetsElement,];
    $dataLabelingJobInputs = new Value();
    $dataLabelingJob = (new DataLabelingJob())
        ->setDisplayName($dataLabelingJobDisplayName)
        ->setDatasets($formattedDataLabelingJobDatasets)
        ->setLabelerCount($dataLabelingJobLabelerCount)
        ->setInstructionUri($dataLabelingJobInstructionUri)
        ->setInputsSchemaUri($dataLabelingJobInputsSchemaUri)
        ->setInputs($dataLabelingJobInputs);

    // Call the API and handle any network failures.
    try {
        /** @var DataLabelingJob $response */
        $response = $jobServiceClient->createDataLabelingJob($formattedParent, $dataLabelingJob);
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
    $dataLabelingJobDisplayName = '[DISPLAY_NAME]';
    $formattedDataLabelingJobDatasetsElement = JobServiceClient::datasetName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATASET]'
    );
    $dataLabelingJobLabelerCount = 0;
    $dataLabelingJobInstructionUri = '[INSTRUCTION_URI]';
    $dataLabelingJobInputsSchemaUri = '[INPUTS_SCHEMA_URI]';

    create_data_labeling_job_sample(
        $formattedParent,
        $dataLabelingJobDisplayName,
        $formattedDataLabelingJobDatasetsElement,
        $dataLabelingJobLabelerCount,
        $dataLabelingJobInstructionUri,
        $dataLabelingJobInputsSchemaUri
    );
}
// [END aiplatform_v1_generated_JobService_CreateDataLabelingJob_sync]
