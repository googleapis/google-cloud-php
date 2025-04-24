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

// [START storagebatchoperations_v1_generated_StorageBatchOperations_CreateJob_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\StorageBatchOperations\V1\Client\StorageBatchOperationsClient;
use Google\Cloud\StorageBatchOperations\V1\CreateJobRequest;
use Google\Cloud\StorageBatchOperations\V1\Job;
use Google\Rpc\Status;

/**
 * Creates a batch job.
 *
 * @param string $formattedParent Value for parent. Please see
 *                                {@see StorageBatchOperationsClient::locationName()} for help formatting this field.
 * @param string $jobId           The optional `job_id` for this Job . If not
 *                                specified, an id is generated. `job_id` should be no more than 128
 *                                characters and must include only characters available in DNS names, as
 *                                defined by RFC-1123.
 */
function create_job_sample(string $formattedParent, string $jobId): void
{
    // Create a client.
    $storageBatchOperationsClient = new StorageBatchOperationsClient();

    // Prepare the request message.
    $job = new Job();
    $request = (new CreateJobRequest())
        ->setParent($formattedParent)
        ->setJobId($jobId)
        ->setJob($job);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $storageBatchOperationsClient->createJob($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Job $result */
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
    $formattedParent = StorageBatchOperationsClient::locationName('[PROJECT]', '[LOCATION]');
    $jobId = '[JOB_ID]';

    create_job_sample($formattedParent, $jobId);
}
// [END storagebatchoperations_v1_generated_StorageBatchOperations_CreateJob_sync]
