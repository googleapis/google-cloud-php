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

// [START datalabeling_v1beta1_generated_DataLabelingService_UpdateEvaluationJob_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DataLabeling\V1beta1\Client\DataLabelingServiceClient;
use Google\Cloud\DataLabeling\V1beta1\EvaluationJob;
use Google\Cloud\DataLabeling\V1beta1\UpdateEvaluationJobRequest;

/**
 * Updates an evaluation job. You can only update certain fields of the job's
 * [EvaluationJobConfig][google.cloud.datalabeling.v1beta1.EvaluationJobConfig]: `humanAnnotationConfig.instruction`,
 * `exampleCount`, and `exampleSamplePercentage`.
 *
 * If you want to change any other aspect of the evaluation job, you must
 * delete the job and create a new one.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_evaluation_job_sample(): void
{
    // Create a client.
    $dataLabelingServiceClient = new DataLabelingServiceClient();

    // Prepare the request message.
    $evaluationJob = new EvaluationJob();
    $request = (new UpdateEvaluationJobRequest())
        ->setEvaluationJob($evaluationJob);

    // Call the API and handle any network failures.
    try {
        /** @var EvaluationJob $response */
        $response = $dataLabelingServiceClient->updateEvaluationJob($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END datalabeling_v1beta1_generated_DataLabelingService_UpdateEvaluationJob_sync]
