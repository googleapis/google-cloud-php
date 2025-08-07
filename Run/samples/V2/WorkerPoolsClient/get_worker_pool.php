<?php
/*
 * Copyright 2025 Google LLC
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

// [START run_v2_generated_WorkerPools_GetWorkerPool_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Run\V2\Client\WorkerPoolsClient;
use Google\Cloud\Run\V2\GetWorkerPoolRequest;
use Google\Cloud\Run\V2\WorkerPool;

/**
 * Gets information about a WorkerPool.
 *
 * @param string $formattedName The full name of the WorkerPool.
 *                              Format:
 *                              `projects/{project}/locations/{location}/workerPools/{worker_pool}`, where
 *                              `{project}` can be project id or number. Please see
 *                              {@see WorkerPoolsClient::workerPoolName()} for help formatting this field.
 */
function get_worker_pool_sample(string $formattedName): void
{
    // Create a client.
    $workerPoolsClient = new WorkerPoolsClient();

    // Prepare the request message.
    $request = (new GetWorkerPoolRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var WorkerPool $response */
        $response = $workerPoolsClient->getWorkerPool($request);
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
    $formattedName = WorkerPoolsClient::workerPoolName('[PROJECT]', '[LOCATION]', '[WORKER_POOL]');

    get_worker_pool_sample($formattedName);
}
// [END run_v2_generated_WorkerPools_GetWorkerPool_sync]
