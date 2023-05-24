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

// [START storagetransfer_v1_generated_StorageTransferService_UpdateTransferJob_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\StorageTransfer\V1\StorageTransferServiceClient;
use Google\Cloud\StorageTransfer\V1\TransferJob;

/**
 * Updates a transfer job. Updating a job's transfer spec does not affect
 * transfer operations that are running already.
 *
 * **Note:** The job's [status][google.storagetransfer.v1.TransferJob.status] field can be modified
 * using this RPC (for example, to set a job's status to
 * [DELETED][google.storagetransfer.v1.TransferJob.Status.DELETED],
 * [DISABLED][google.storagetransfer.v1.TransferJob.Status.DISABLED], or
 * [ENABLED][google.storagetransfer.v1.TransferJob.Status.ENABLED]).
 *
 * @param string $jobName   The name of job to update.
 * @param string $projectId The ID of the Google Cloud project that owns the
 *                          job.
 */
function update_transfer_job_sample(string $jobName, string $projectId): void
{
    // Create a client.
    $storageTransferServiceClient = new StorageTransferServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $transferJob = new TransferJob();

    // Call the API and handle any network failures.
    try {
        /** @var TransferJob $response */
        $response = $storageTransferServiceClient->updateTransferJob($jobName, $projectId, $transferJob);
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
    $jobName = '[JOB_NAME]';
    $projectId = '[PROJECT_ID]';

    update_transfer_job_sample($jobName, $projectId);
}
// [END storagetransfer_v1_generated_StorageTransferService_UpdateTransferJob_sync]
