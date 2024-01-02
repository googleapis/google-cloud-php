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

// [START dataproc_v1_generated_JobController_SubmitJob_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataproc\V1\Job;
use Google\Cloud\Dataproc\V1\JobControllerClient;
use Google\Cloud\Dataproc\V1\JobPlacement;

/**
 * Submits a job to a cluster.
 *
 * @param string $projectId               The ID of the Google Cloud Platform project that the job
 *                                        belongs to.
 * @param string $region                  The Dataproc region in which to handle the request.
 * @param string $jobPlacementClusterName The name of the cluster where the job will be submitted.
 */
function submit_job_sample(
    string $projectId,
    string $region,
    string $jobPlacementClusterName
): void {
    // Create a client.
    $jobControllerClient = new JobControllerClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $jobPlacement = (new JobPlacement())
        ->setClusterName($jobPlacementClusterName);
    $job = (new Job())
        ->setPlacement($jobPlacement);

    // Call the API and handle any network failures.
    try {
        /** @var Job $response */
        $response = $jobControllerClient->submitJob($projectId, $region, $job);
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
    $jobPlacementClusterName = '[CLUSTER_NAME]';

    submit_job_sample($projectId, $region, $jobPlacementClusterName);
}
// [END dataproc_v1_generated_JobController_SubmitJob_sync]
