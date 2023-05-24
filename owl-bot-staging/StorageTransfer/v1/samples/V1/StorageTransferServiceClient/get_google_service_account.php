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

// [START storagetransfer_v1_generated_StorageTransferService_GetGoogleServiceAccount_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\StorageTransfer\V1\GoogleServiceAccount;
use Google\Cloud\StorageTransfer\V1\StorageTransferServiceClient;

/**
 * Returns the Google service account that is used by Storage Transfer
 * Service to access buckets in the project where transfers
 * run or in other projects. Each Google service account is associated
 * with one Google Cloud project. Users
 * should add this service account to the Google Cloud Storage bucket
 * ACLs to grant access to Storage Transfer Service. This service
 * account is created and owned by Storage Transfer Service and can
 * only be used by Storage Transfer Service.
 *
 * @param string $projectId The ID of the Google Cloud project that the Google service
 *                          account is associated with.
 */
function get_google_service_account_sample(string $projectId): void
{
    // Create a client.
    $storageTransferServiceClient = new StorageTransferServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var GoogleServiceAccount $response */
        $response = $storageTransferServiceClient->getGoogleServiceAccount($projectId);
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
    $projectId = '[PROJECT_ID]';

    get_google_service_account_sample($projectId);
}
// [END storagetransfer_v1_generated_StorageTransferService_GetGoogleServiceAccount_sync]
