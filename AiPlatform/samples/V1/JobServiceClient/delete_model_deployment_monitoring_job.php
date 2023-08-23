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

// [START aiplatform_v1_generated_JobService_DeleteModelDeploymentMonitoringJob_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\Client\JobServiceClient;
use Google\Cloud\AIPlatform\V1\DeleteModelDeploymentMonitoringJobRequest;
use Google\Rpc\Status;

/**
 * Deletes a ModelDeploymentMonitoringJob.
 *
 * @param string $formattedName The resource name of the model monitoring job to delete.
 *                              Format:
 *                              `projects/{project}/locations/{location}/modelDeploymentMonitoringJobs/{model_deployment_monitoring_job}`
 *                              Please see {@see JobServiceClient::modelDeploymentMonitoringJobName()} for help formatting this field.
 */
function delete_model_deployment_monitoring_job_sample(string $formattedName): void
{
    // Create a client.
    $jobServiceClient = new JobServiceClient();

    // Prepare the request message.
    $request = (new DeleteModelDeploymentMonitoringJobRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $jobServiceClient->deleteModelDeploymentMonitoringJob($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
        }
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

    delete_model_deployment_monitoring_job_sample($formattedName);
}
// [END aiplatform_v1_generated_JobService_DeleteModelDeploymentMonitoringJob_sync]
