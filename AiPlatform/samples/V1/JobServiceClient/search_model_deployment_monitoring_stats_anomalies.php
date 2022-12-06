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

// [START aiplatform_v1_generated_JobService_SearchModelDeploymentMonitoringStatsAnomalies_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\AIPlatform\V1\JobServiceClient;
use Google\Cloud\AIPlatform\V1\ModelMonitoringStatsAnomalies;
use Google\Cloud\AIPlatform\V1\SearchModelDeploymentMonitoringStatsAnomaliesRequest\StatsAnomaliesObjective;

/**
 * Searches Model Monitoring Statistics generated within a given time window.
 *
 * @param string $formattedModelDeploymentMonitoringJob ModelDeploymentMonitoring Job resource name.
 *                                                      Format:
 *                                                      `projects/{project}/locations/{location}/modelDeploymentMonitoringJobs/{model_deployment_monitoring_job}`
 *                                                      Please see {@see JobServiceClient::modelDeploymentMonitoringJobName()} for help formatting this field.
 * @param string $deployedModelId                       The DeployedModel ID of the
 *                                                      [ModelDeploymentMonitoringObjectiveConfig.deployed_model_id].
 */
function search_model_deployment_monitoring_stats_anomalies_sample(
    string $formattedModelDeploymentMonitoringJob,
    string $deployedModelId
): void {
    // Create a client.
    $jobServiceClient = new JobServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $objectives = [new StatsAnomaliesObjective()];

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $jobServiceClient->searchModelDeploymentMonitoringStatsAnomalies(
            $formattedModelDeploymentMonitoringJob,
            $deployedModelId,
            $objectives
        );

        /** @var ModelMonitoringStatsAnomalies $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedModelDeploymentMonitoringJob = JobServiceClient::modelDeploymentMonitoringJobName(
        '[PROJECT]',
        '[LOCATION]',
        '[MODEL_DEPLOYMENT_MONITORING_JOB]'
    );
    $deployedModelId = '[DEPLOYED_MODEL_ID]';

    search_model_deployment_monitoring_stats_anomalies_sample(
        $formattedModelDeploymentMonitoringJob,
        $deployedModelId
    );
}
// [END aiplatform_v1_generated_JobService_SearchModelDeploymentMonitoringStatsAnomalies_sync]
