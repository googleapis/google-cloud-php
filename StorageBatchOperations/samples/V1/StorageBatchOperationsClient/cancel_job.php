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

// [START storagebatchoperations_v1_generated_StorageBatchOperations_CancelJob_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\StorageBatchOperations\V1\CancelJobRequest;
use Google\Cloud\StorageBatchOperations\V1\CancelJobResponse;
use Google\Cloud\StorageBatchOperations\V1\Client\StorageBatchOperationsClient;

/**
 * Cancels a batch job.
 *
 * @param string $formattedName The `name` of the job to cancel.
 *                              Format: projects/{project_id}/locations/global/jobs/{job_id}. Please see
 *                              {@see StorageBatchOperationsClient::jobName()} for help formatting this field.
 */
function cancel_job_sample(string $formattedName): void
{
    // Create a client.
    $storageBatchOperationsClient = new StorageBatchOperationsClient();

    // Prepare the request message.
    $request = (new CancelJobRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var CancelJobResponse $response */
        $response = $storageBatchOperationsClient->cancelJob($request);
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
    $formattedName = StorageBatchOperationsClient::jobName('[PROJECT]', '[LOCATION]', '[JOB]');

    cancel_job_sample($formattedName);
}
// [END storagebatchoperations_v1_generated_StorageBatchOperations_CancelJob_sync]
