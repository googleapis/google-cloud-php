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

// [START assuredworkloads_v1beta1_generated_AssuredWorkloadsService_AnalyzeWorkloadMove_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AssuredWorkloads\V1beta1\AnalyzeWorkloadMoveResponse;
use Google\Cloud\AssuredWorkloads\V1beta1\AssuredWorkloadsServiceClient;

/**
 * Analyze if the source Assured Workloads can be moved to the target Assured
 * Workload
 *
 * @param string $target The resource ID of the folder-based destination workload. This workload is
 *                       where the source project will hypothetically be moved to. Specify the
 *                       workload's relative resource name, formatted as:
 *                       "organizations/{ORGANIZATION_ID}/locations/{LOCATION_ID}/workloads/{WORKLOAD_ID}"
 *                       For example:
 *                       "organizations/123/locations/us-east1/workloads/assured-workload-2"
 */
function analyze_workload_move_sample(string $target): void
{
    // Create a client.
    $assuredWorkloadsServiceClient = new AssuredWorkloadsServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var AnalyzeWorkloadMoveResponse $response */
        $response = $assuredWorkloadsServiceClient->analyzeWorkloadMove($target);
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
    $target = '[TARGET]';

    analyze_workload_move_sample($target);
}
// [END assuredworkloads_v1beta1_generated_AssuredWorkloadsService_AnalyzeWorkloadMove_sync]
