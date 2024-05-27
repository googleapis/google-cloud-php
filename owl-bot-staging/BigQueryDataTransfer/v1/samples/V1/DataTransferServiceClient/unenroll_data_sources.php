<?php
/*
 * Copyright 2024 Google LLC
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

// [START bigquerydatatransfer_v1_generated_DataTransferService_UnenrollDataSources_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BigQuery\DataTransfer\V1\Client\DataTransferServiceClient;
use Google\Cloud\BigQuery\DataTransfer\V1\UnenrollDataSourcesRequest;

/**
 * Unenroll data sources in a user project. This allows users to remove
 * transfer configurations for these data sources. They will no longer appear
 * in the ListDataSources RPC and will also no longer appear in the [BigQuery
 * UI](https://console.cloud.google.com/bigquery). Data transfers
 * configurations of unenrolled data sources will not be scheduled.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function unenroll_data_sources_sample(): void
{
    // Create a client.
    $dataTransferServiceClient = new DataTransferServiceClient();

    // Prepare the request message.
    $request = new UnenrollDataSourcesRequest();

    // Call the API and handle any network failures.
    try {
        $dataTransferServiceClient->unenrollDataSources($request);
        printf('Call completed successfully.' . PHP_EOL);
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END bigquerydatatransfer_v1_generated_DataTransferService_UnenrollDataSources_sync]
