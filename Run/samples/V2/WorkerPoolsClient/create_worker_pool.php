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

// [START run_v2_generated_WorkerPools_CreateWorkerPool_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Run\V2\Client\WorkerPoolsClient;
use Google\Cloud\Run\V2\CreateWorkerPoolRequest;
use Google\Cloud\Run\V2\WorkerPool;
use Google\Cloud\Run\V2\WorkerPoolRevisionTemplate;
use Google\Rpc\Status;

/**
 * Creates a new WorkerPool in a given project and location.
 *
 * @param string $formattedParent The location and project in which this worker pool should be
 *                                created. Format: `projects/{project}/locations/{location}`, where
 *                                `{project}` can be project id or number. Only lowercase characters, digits,
 *                                and hyphens. Please see
 *                                {@see WorkerPoolsClient::locationName()} for help formatting this field.
 * @param string $workerPoolId    The unique identifier for the WorkerPool. It must begin with
 *                                letter, and cannot end with hyphen; must contain fewer than 50 characters.
 *                                The name of the worker pool becomes
 *                                `{parent}/workerPools/{worker_pool_id}`.
 */
function create_worker_pool_sample(string $formattedParent, string $workerPoolId): void
{
    // Create a client.
    $workerPoolsClient = new WorkerPoolsClient();

    // Prepare the request message.
    $workerPoolTemplate = new WorkerPoolRevisionTemplate();
    $workerPool = (new WorkerPool())
        ->setTemplate($workerPoolTemplate);
    $request = (new CreateWorkerPoolRequest())
        ->setParent($formattedParent)
        ->setWorkerPool($workerPool)
        ->setWorkerPoolId($workerPoolId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $workerPoolsClient->createWorkerPool($request);
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
    $formattedParent = WorkerPoolsClient::locationName('[PROJECT]', '[LOCATION]');
    $workerPoolId = '[WORKER_POOL_ID]';

    create_worker_pool_sample($formattedParent, $workerPoolId);
}
// [END run_v2_generated_WorkerPools_CreateWorkerPool_sync]
