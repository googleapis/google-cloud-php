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

// [START dataproc_v1_generated_JobController_CancelJob_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataproc\V1\Job;
use Google\Cloud\Dataproc\V1\JobControllerClient;

/**
 * Starts a job cancellation request. To access the job resource
 * after cancellation, call
 * [regions/{region}/jobs.list](https://cloud.google.com/dataproc/docs/reference/rest/v1/projects.regions.jobs/list)
 * or
 * [regions/{region}/jobs.get](https://cloud.google.com/dataproc/docs/reference/rest/v1/projects.regions.jobs/get).
 *
 * @param string $projectId The ID of the Google Cloud Platform project that the job
 *                          belongs to.
 * @param string $region    The Dataproc region in which to handle the request.
 * @param string $jobId     The job ID.
 */
function cancel_job_sample(string $projectId, string $region, string $jobId): void
{
    // Create a client.
    $jobControllerClient = new JobControllerClient();

    // Call the API and handle any network failures.
    try {
        /** @var Job $response */
        $response = $jobControllerClient->cancelJob($projectId, $region, $jobId);
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
    $projectId = '[PROJECT_ID]';
    $region = '[REGION]';
    $jobId = '[JOB_ID]';

    cancel_job_sample($projectId, $region, $jobId);
}
// [END dataproc_v1_generated_JobController_CancelJob_sync]
