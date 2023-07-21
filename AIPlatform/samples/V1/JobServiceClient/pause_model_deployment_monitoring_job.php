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

// [START aiplatform_v1_generated_JobService_PauseModelDeploymentMonitoringJob_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Client\JobServiceClient;
use Google\Cloud\AIPlatform\V1\PauseModelDeploymentMonitoringJobRequest;

/**
 * Pauses a ModelDeploymentMonitoringJob. If the job is running, the server
 * makes a best effort to cancel the job. Will mark
 * [ModelDeploymentMonitoringJob.state][google.cloud.aiplatform.v1.ModelDeploymentMonitoringJob.state]
 * to 'PAUSED'.
 *
 * @param string $formattedName The resource name of the ModelDeploymentMonitoringJob to pause.
 *                              Format:
 *                              `projects/{project}/locations/{location}/modelDeploymentMonitoringJobs/{model_deployment_monitoring_job}`
 *                              Please see {@see JobServiceClient::modelDeploymentMonitoringJobName()} for help formatting this field.
 */
function pause_model_deployment_monitoring_job_sample(string $formattedName): void
{
    // Create a client.
    $jobServiceClient = new JobServiceClient();

    // Prepare the request message.
    $request = (new PauseModelDeploymentMonitoringJobRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $jobServiceClient->pauseModelDeploymentMonitoringJob($request);
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
    $formattedName = JobServiceClient::modelDeploymentMonitoringJobName(
        '[PROJECT]',
        '[LOCATION]',
        '[MODEL_DEPLOYMENT_MONITORING_JOB]'
    );

    pause_model_deployment_monitoring_job_sample($formattedName);
}
// [END aiplatform_v1_generated_JobService_PauseModelDeploymentMonitoringJob_sync]
