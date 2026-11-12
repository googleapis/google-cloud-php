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

// [START sqladmin_v1_generated_SqlWorkloadCapturesService_StopReplay_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Sql\V1\Client\SqlWorkloadCapturesServiceClient;
use Google\Cloud\Sql\V1\Operation;
use Google\Cloud\Sql\V1\WorkloadCapturesStopReplayRequest;

/**
 * Stops an active workload replay on the target Cloud SQL replay instance.
 *
 * @param string $project  Project ID of the project that contains the target replay
 *                         instance.
 * @param string $instance Cloud SQL instance ID of the target replay instance. This does
 *                         not include the project ID.
 */
function stop_replay_sample(string $project, string $instance): void
{
    // Create a client.
    $sqlWorkloadCapturesServiceClient = new SqlWorkloadCapturesServiceClient();

    // Prepare the request message.
    $request = (new WorkloadCapturesStopReplayRequest())
        ->setProject($project)
        ->setInstance($instance);

    // Call the API and handle any network failures.
    try {
        /** @var Operation $response */
        $response = $sqlWorkloadCapturesServiceClient->stopReplay($request);
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

    stop_replay_sample($project, $instance);
}
// [END sqladmin_v1_generated_SqlWorkloadCapturesService_StopReplay_sync]
