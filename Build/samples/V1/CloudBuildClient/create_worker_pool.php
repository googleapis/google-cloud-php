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

// [START cloudbuild_v1_generated_CloudBuild_CreateWorkerPool_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Build\V1\CloudBuildClient;
use Google\Cloud\Build\V1\WorkerPool;
use Google\Rpc\Status;

/**
 * Creates a `WorkerPool`.
 *
 * @param string $formattedParent The parent resource where this worker pool will be created.
 *                                Format: `projects/{project}/locations/{location}`. Please see
 *                                {@see CloudBuildClient::locationName()} for help formatting this field.
 * @param string $workerPoolId    Immutable. The ID to use for the `WorkerPool`, which will become
 *                                the final component of the resource name.
 *
 *                                This value should be 1-63 characters, and valid characters
 *                                are /[a-z][0-9]-/.
 */
function create_worker_pool_sample(string $formattedParent, string $workerPoolId): void
{
    // Create a client.
    $cloudBuildClient = new CloudBuildClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $workerPool = new WorkerPool();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $cloudBuildClient->createWorkerPool($formattedParent, $workerPool, $workerPoolId);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var WorkerPool $result */
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
    $formattedParent = CloudBuildClient::locationName('[PROJECT]', '[LOCATION]');
    $workerPoolId = '[WORKER_POOL_ID]';

    create_worker_pool_sample($formattedParent, $workerPoolId);
}
// [END cloudbuild_v1_generated_CloudBuild_CreateWorkerPool_sync]
