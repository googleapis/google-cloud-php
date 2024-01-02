<?php
/*
 * Copyright 2024 Google LLC
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

// [START dataproc_v1_generated_JobController_DeleteJob_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataproc\V1\JobControllerClient;

/**
 * Deletes the job from the project. If the job is active, the delete fails,
 * and the response returns `FAILED_PRECONDITION`.
 *
 * @param string $projectId The ID of the Google Cloud Platform project that the job
 *                          belongs to.
 * @param string $region    The Dataproc region in which to handle the request.
 * @param string $jobId     The job ID.
 */
function delete_job_sample(string $projectId, string $region, string $jobId): void
{
    // Create a client.
    $jobControllerClient = new JobControllerClient();

    // Call the API and handle any network failures.
    try {
        $jobControllerClient->deleteJob($projectId, $region, $jobId);
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
    $projectId = '[PROJECT_ID]';
    $region = '[REGION]';
    $jobId = '[JOB_ID]';

    delete_job_sample($projectId, $region, $jobId);
}
// [END dataproc_v1_generated_JobController_DeleteJob_sync]
