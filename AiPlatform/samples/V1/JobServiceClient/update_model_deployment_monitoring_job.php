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

// [START aiplatform_v1_generated_JobService_UpdateModelDeploymentMonitoringJob_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\JobServiceClient;
use Google\Cloud\AIPlatform\V1\ModelDeploymentMonitoringJob;
use Google\Cloud\AIPlatform\V1\ModelDeploymentMonitoringObjectiveConfig;
use Google\Cloud\AIPlatform\V1\ModelDeploymentMonitoringScheduleConfig;
use Google\Cloud\AIPlatform\V1\SamplingStrategy;
use Google\Protobuf\Duration;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates a ModelDeploymentMonitoringJob.
 *
 * @param string $modelDeploymentMonitoringJobDisplayName       The user-defined name of the ModelDeploymentMonitoringJob.
 *                                                              The name can be up to 128 characters long and can consist of any UTF-8
 *                                                              characters.
 *                                                              Display name of a ModelDeploymentMonitoringJob.
 * @param string $formattedModelDeploymentMonitoringJobEndpoint Endpoint resource name.
 *                                                              Format: `projects/{project}/locations/{location}/endpoints/{endpoint}`
 *                                                              Please see {@see JobServiceClient::endpointName()} for help formatting this field.
 */
function update_model_deployment_monitoring_job_sample(
    string $modelDeploymentMonitoringJobDisplayName,
    string $formattedModelDeploymentMonitoringJobEndpoint
): void {
    // Create a client.
    $jobServiceClient = new JobServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $modelDeploymentMonitoringJobModelDeploymentMonitoringObjectiveConfigs = [
        new ModelDeploymentMonitoringObjectiveConfig()
    ];
    $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfigMonitorInterval = new Duration();
    $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig = (new ModelDeploymentMonitoringScheduleConfig())
        ->setMonitorInterval(
            $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfigMonitorInterval
        );
    $modelDeploymentMonitoringJobLoggingSamplingStrategy = new SamplingStrategy();
    $modelDeploymentMonitoringJob = (new ModelDeploymentMonitoringJob())
        ->setDisplayName($modelDeploymentMonitoringJobDisplayName)
        ->setEndpoint($formattedModelDeploymentMonitoringJobEndpoint)
        ->setModelDeploymentMonitoringObjectiveConfigs(
            $modelDeploymentMonitoringJobModelDeploymentMonitoringObjectiveConfigs
        )
        ->setModelDeploymentMonitoringScheduleConfig(
            $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig
        )
        ->setLoggingSamplingStrategy($modelDeploymentMonitoringJobLoggingSamplingStrategy);
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $jobServiceClient->updateModelDeploymentMonitoringJob(
            $modelDeploymentMonitoringJob,
            $updateMask
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ModelDeploymentMonitoringJob $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
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
    $modelDeploymentMonitoringJobDisplayName = '[DISPLAY_NAME]';
    $formattedModelDeploymentMonitoringJobEndpoint = JobServiceClient::endpointName(
        '[PROJECT]',
        '[LOCATION]',
        '[ENDPOINT]'
    );

    update_model_deployment_monitoring_job_sample(
        $modelDeploymentMonitoringJobDisplayName,
        $formattedModelDeploymentMonitoringJobEndpoint
    );
}
// [END aiplatform_v1_generated_JobService_UpdateModelDeploymentMonitoringJob_sync]
