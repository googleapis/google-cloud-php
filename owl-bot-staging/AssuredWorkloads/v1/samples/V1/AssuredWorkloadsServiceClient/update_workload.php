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

// [START assuredworkloads_v1_generated_AssuredWorkloadsService_UpdateWorkload_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AssuredWorkloads\V1\Client\AssuredWorkloadsServiceClient;
use Google\Cloud\AssuredWorkloads\V1\UpdateWorkloadRequest;
use Google\Cloud\AssuredWorkloads\V1\Workload;

/**
 * Updates an existing workload.
 * Currently allows updating of workload display_name and labels.
 * For force updates don't set etag field in the Workload.
 * Only one update operation per workload can be in progress.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_workload_sample(): void
{
    // Create a client.
    $assuredWorkloadsServiceClient = new AssuredWorkloadsServiceClient();

    // Prepare the request message.
    $request = new UpdateWorkloadRequest();

    // Call the API and handle any network failures.
    try {
        /** @var Workload $response */
        $response = $assuredWorkloadsServiceClient->updateWorkload($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END assuredworkloads_v1_generated_AssuredWorkloadsService_UpdateWorkload_sync]
