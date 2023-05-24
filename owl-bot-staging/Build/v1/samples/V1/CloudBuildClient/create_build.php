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

// [START cloudbuild_v1_generated_CloudBuild_CreateBuild_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Build\V1\Build;
use Google\Cloud\Build\V1\CloudBuildClient;
use Google\Rpc\Status;

/**
 * Starts a build with the specified configuration.
 *
 * This method returns a long-running `Operation`, which includes the build
 * ID. Pass the build ID to `GetBuild` to determine the build status (such as
 * `SUCCESS` or `FAILURE`).
 *
 * @param string $projectId ID of the project.
 */
function create_build_sample(string $projectId): void
{
    // Create a client.
    $cloudBuildClient = new CloudBuildClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $build = new Build();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudBuildClient->createBuild($projectId, $build);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Build $result */
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
    $projectId = '[PROJECT_ID]';

    create_build_sample($projectId);
}
// [END cloudbuild_v1_generated_CloudBuild_CreateBuild_sync]
