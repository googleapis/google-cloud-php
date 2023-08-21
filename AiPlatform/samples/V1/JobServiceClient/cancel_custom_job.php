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

// [START aiplatform_v1_generated_JobService_CancelCustomJob_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\CancelCustomJobRequest;
use Google\Cloud\AIPlatform\V1\Client\JobServiceClient;

/**
 * Cancels a CustomJob.
 * Starts asynchronous cancellation on the CustomJob. The server
 * makes a best effort to cancel the job, but success is not
 * guaranteed. Clients can use
 * [JobService.GetCustomJob][google.cloud.aiplatform.v1.JobService.GetCustomJob]
 * or other methods to check whether the cancellation succeeded or whether the
 * job completed despite cancellation. On successful cancellation,
 * the CustomJob is not deleted; instead it becomes a job with
 * a [CustomJob.error][google.cloud.aiplatform.v1.CustomJob.error] value with
 * a [google.rpc.Status.code][google.rpc.Status.code] of 1, corresponding to
 * `Code.CANCELLED`, and
 * [CustomJob.state][google.cloud.aiplatform.v1.CustomJob.state] is set to
 * `CANCELLED`.
 *
 * @param string $formattedName The name of the CustomJob to cancel.
 *                              Format:
 *                              `projects/{project}/locations/{location}/customJobs/{custom_job}`
 *                              Please see {@see JobServiceClient::customJobName()} for help formatting this field.
 */
function cancel_custom_job_sample(string $formattedName): void
{
    // Create a client.
    $jobServiceClient = new JobServiceClient();

    // Prepare the request message.
    $request = (new CancelCustomJobRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $jobServiceClient->cancelCustomJob($request);
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
    $formattedName = JobServiceClient::customJobName('[PROJECT]', '[LOCATION]', '[CUSTOM_JOB]');

    cancel_custom_job_sample($formattedName);
}
// [END aiplatform_v1_generated_JobService_CancelCustomJob_sync]
