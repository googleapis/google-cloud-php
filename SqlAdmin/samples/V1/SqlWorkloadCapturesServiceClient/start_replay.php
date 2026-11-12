<?php
/*
 * Copyright 2026 Google LLC
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

// [START sqladmin_v1_generated_SqlWorkloadCapturesService_StartReplay_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Sql\V1\Client\SqlWorkloadCapturesServiceClient;
use Google\Cloud\Sql\V1\Operation;
use Google\Cloud\Sql\V1\StartWorkloadReplayContext;
use Google\Cloud\Sql\V1\WorkloadCapturesStartReplayRequest;

/**
 * Starts executing a captured workload on a separate Cloud SQL instance
 * provisioned for workload replay. This target instance simulates the
 * production environment without affecting the primary instance.
 *
 * @param string $project                                  Project ID of the project that contains the instance.
 * @param string $instance                                 Cloud SQL instance ID. This does not include the project ID.
 * @param string $startWorkloadReplayContextReplayInstance The name of the Cloud SQL instance where the captured workload
 *                                                         (SQL queries) is being executed, excluding the project ID (for example,
 *                                                         `my-replay-instance`). The instance name must start with a lowercase letter
 *                                                         and contain only lowercase letters, numbers, and hyphens. The combined
 *                                                         length of `project-ID:instance-name` must be 98 characters or less.
 * @param string $workloadId                               The ID of the workload to replay.
 */
function start_replay_sample(
    string $project,
    string $instance,
    string $startWorkloadReplayContextReplayInstance,
    string $workloadId
): void {
    // Create a client.
    $sqlWorkloadCapturesServiceClient = new SqlWorkloadCapturesServiceClient();

    // Prepare the request message.
    $startWorkloadReplayContext = (new StartWorkloadReplayContext())
        ->setReplayInstance($startWorkloadReplayContextReplayInstance);
    $request = (new WorkloadCapturesStartReplayRequest())
        ->setProject($project)
        ->setInstance($instance)
        ->setStartWorkloadReplayContext($startWorkloadReplayContext)
        ->setWorkloadId($workloadId);

    // Call the API and handle any network failures.
    try {
        /** @var Operation $response */
        $response = $sqlWorkloadCapturesServiceClient->startReplay($request);
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
    $project = '[PROJECT]';
    $instance = '[INSTANCE]';
    $startWorkloadReplayContextReplayInstance = '[REPLAY_INSTANCE]';
    $workloadId = '[WORKLOAD_ID]';

    start_replay_sample($project, $instance, $startWorkloadReplayContextReplayInstance, $workloadId);
}
// [END sqladmin_v1_generated_SqlWorkloadCapturesService_StartReplay_sync]
