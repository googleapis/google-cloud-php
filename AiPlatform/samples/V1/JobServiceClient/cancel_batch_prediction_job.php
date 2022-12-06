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

// [START aiplatform_v1_generated_JobService_CancelBatchPredictionJob_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\JobServiceClient;

/**
 * Cancels a BatchPredictionJob.
 *
 * Starts asynchronous cancellation on the BatchPredictionJob. The server
 * makes the best effort to cancel the job, but success is not
 * guaranteed. Clients can use [JobService.GetBatchPredictionJob][google.cloud.aiplatform.v1.JobService.GetBatchPredictionJob] or
 * other methods to check whether the cancellation succeeded or whether the
 * job completed despite cancellation. On a successful cancellation,
 * the BatchPredictionJob is not deleted;instead its
 * [BatchPredictionJob.state][google.cloud.aiplatform.v1.BatchPredictionJob.state] is set to `CANCELLED`. Any files already
 * outputted by the job are not deleted.
 *
 * @param string $formattedName The name of the BatchPredictionJob to cancel.
 *                              Format:
 *                              `projects/{project}/locations/{location}/batchPredictionJobs/{batch_prediction_job}`
 *                              Please see {@see JobServiceClient::batchPredictionJobName()} for help formatting this field.
 */
function cancel_batch_prediction_job_sample(string $formattedName): void
{
    // Create a client.
    $jobServiceClient = new JobServiceClient();

    // Call the API and handle any network failures.
    try {
        $jobServiceClient->cancelBatchPredictionJob($formattedName);
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
    $formattedName = JobServiceClient::batchPredictionJobName(
        '[PROJECT]',
        '[LOCATION]',
        '[BATCH_PREDICTION_JOB]'
    );

    cancel_batch_prediction_job_sample($formattedName);
}
// [END aiplatform_v1_generated_JobService_CancelBatchPredictionJob_sync]
