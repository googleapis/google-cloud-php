<?php
/*
 * Copyright 2023 Google LLC
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

// [START clouddeploy_v1_generated_CloudDeploy_GetJobRun_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Deploy\V1\Client\CloudDeployClient;
use Google\Cloud\Deploy\V1\GetJobRunRequest;
use Google\Cloud\Deploy\V1\JobRun;

/**
 * Gets details of a single JobRun.
 *
 * @param string $formattedName Name of the `JobRun`. Format must be
 *                              `projects/{project_id}/locations/{location_name}/deliveryPipelines/{pipeline_name}/releases/{release_name}/rollouts/{rollout_name}/jobRuns/{job_run_name}`. Please see
 *                              {@see CloudDeployClient::jobRunName()} for help formatting this field.
 */
function get_job_run_sample(string $formattedName): void
{
    // Create a client.
    $cloudDeployClient = new CloudDeployClient();

    // Prepare the request message.
    $request = (new GetJobRunRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var JobRun $response */
        $response = $cloudDeployClient->getJobRun($request);
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
    $formattedName = CloudDeployClient::jobRunName(
        '[PROJECT]',
        '[LOCATION]',
        '[DELIVERY_PIPELINE]',
        '[RELEASE]',
        '[ROLLOUT]',
        '[JOB_RUN]'
    );

    get_job_run_sample($formattedName);
}
// [END clouddeploy_v1_generated_CloudDeploy_GetJobRun_sync]