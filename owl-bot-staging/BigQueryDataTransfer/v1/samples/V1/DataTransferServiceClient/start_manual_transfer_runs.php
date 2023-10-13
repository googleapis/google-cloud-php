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

// [START bigquerydatatransfer_v1_generated_DataTransferService_StartManualTransferRuns_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BigQuery\DataTransfer\V1\DataTransferServiceClient;
use Google\Cloud\BigQuery\DataTransfer\V1\StartManualTransferRunsResponse;

/**
 * Start manual transfer runs to be executed now with schedule_time equal to
 * current time. The transfer runs can be created for a time range where the
 * run_time is between start_time (inclusive) and end_time (exclusive), or for
 * a specific run_time.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function start_manual_transfer_runs_sample(): void
{
    // Create a client.
    $dataTransferServiceClient = new DataTransferServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var StartManualTransferRunsResponse $response */
        $response = $dataTransferServiceClient->startManualTransferRuns();
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END bigquerydatatransfer_v1_generated_DataTransferService_StartManualTransferRuns_sync]
