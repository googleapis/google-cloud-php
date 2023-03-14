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

// [START cloudbuild_v1_generated_CloudBuild_RetryBuild_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Build\V1\Build;
use Google\Cloud\Build\V1\CloudBuildClient;
use Google\Rpc\Status;

/**
 * Creates a new build based on the specified build.
 *
 * This method creates a new build using the original build request, which may
 * or may not result in an identical build.
 *
 * For triggered builds:
 *
 * * Triggered builds resolve to a precise revision; therefore a retry of a
 * triggered build will result in a build that uses the same revision.
 *
 * For non-triggered builds that specify `RepoSource`:
 *
 * * If the original build built from the tip of a branch, the retried build
 * will build from the tip of that branch, which may not be the same revision
 * as the original build.
 * * If the original build specified a commit sha or revision ID, the retried
 * build will use the identical source.
 *
 * For builds that specify `StorageSource`:
 *
 * * If the original build pulled source from Google Cloud Storage without
 * specifying the generation of the object, the new build will use the current
 * object, which may be different from the original build source.
 * * If the original build pulled source from Cloud Storage and specified the
 * generation of the object, the new build will attempt to use the same
 * object, which may or may not be available depending on the bucket's
 * lifecycle management settings.
 *
 * @param string $projectId ID of the project.
 * @param string $id        Build ID of the original build.
 */
function retry_build_sample(string $projectId, string $id): void
{
    // Create a client.
    $cloudBuildClient = new CloudBuildClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudBuildClient->retryBuild($projectId, $id);
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
    $id = '[ID]';

    retry_build_sample($projectId, $id);
}
// [END cloudbuild_v1_generated_CloudBuild_RetryBuild_sync]
