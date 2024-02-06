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

// [START dataproc_v1_generated_JobController_UpdateJob_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataproc\V1\Client\JobControllerClient;
use Google\Cloud\Dataproc\V1\Job;
use Google\Cloud\Dataproc\V1\JobPlacement;
use Google\Cloud\Dataproc\V1\UpdateJobRequest;
use Google\Protobuf\FieldMask;

/**
 * Updates a job in a project.
 *
 * @param string $projectId               The ID of the Google Cloud Platform project that the job
 *                                        belongs to.
 * @param string $region                  The Dataproc region in which to handle the request.
 * @param string $jobId                   The job ID.
 * @param string $jobPlacementClusterName The name of the cluster where the job will be submitted.
 */
function update_job_sample(
    string $projectId,
    string $region,
    string $jobId,
    string $jobPlacementClusterName
): void {
    // Create a client.
    $jobControllerClient = new JobControllerClient();

    // Prepare the request message.
    $jobPlacement = (new JobPlacement())
        ->setClusterName($jobPlacementClusterName);
    $job = (new Job())
        ->setPlacement($jobPlacement);
    $updateMask = new FieldMask();
    $request = (new UpdateJobRequest())
        ->setProjectId($projectId)
        ->setRegion($region)
        ->setJobId($jobId)
        ->setJob($job)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var Job $response */
        $response = $jobControllerClient->updateJob($request);
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
    $jobPlacementClusterName = '[CLUSTER_NAME]';

    update_job_sample($projectId, $region, $jobId, $jobPlacementClusterName);
}
// [END dataproc_v1_generated_JobController_UpdateJob_sync]
