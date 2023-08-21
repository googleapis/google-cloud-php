<?php
/*
 * Copyright 2022 Google LLC
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

// [START storagetransfer_v1_generated_StorageTransferService_RunTransferJob_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\StorageTransfer\V1\StorageTransferServiceClient;
use Google\Rpc\Status;

/**
 * Starts a new operation for the specified transfer job.
 * A `TransferJob` has a maximum of one active `TransferOperation`. If this
 * method is called while a `TransferOperation` is active, an error is
 * returned.
 *
 * @param string $jobName   The name of the transfer job.
 * @param string $projectId The ID of the Google Cloud project that owns the transfer
 *                          job.
 */
function run_transfer_job_sample(string $jobName, string $projectId): void
{
    // Create a client.
    $storageTransferServiceClient = new StorageTransferServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $storageTransferServiceClient->runTransferJob($jobName, $projectId);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
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
    $jobName = '[JOB_NAME]';
    $projectId = '[PROJECT_ID]';

    run_transfer_job_sample($jobName, $projectId);
}
// [END storagetransfer_v1_generated_StorageTransferService_RunTransferJob_sync]
