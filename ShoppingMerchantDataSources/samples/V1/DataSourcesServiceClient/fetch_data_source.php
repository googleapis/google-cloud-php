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

// [START merchantapi_v1_generated_DataSourcesService_FetchDataSource_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\DataSources\V1\Client\DataSourcesServiceClient;
use Google\Shopping\Merchant\DataSources\V1\FetchDataSourceRequest;

/**
 * Performs the data fetch immediately (even outside fetch schedule) on a
 * data source from your Merchant Center Account. If you need to call
 * this method more than once per day, you should use the Products service to
 * update your product data instead.
 * This method only works on data sources with a file input set.
 *
 * @param string $formattedName The name of the data source resource to fetch.
 *                              Format: `accounts/{account}/dataSources/{datasource}`
 *                              Please see {@see DataSourcesServiceClient::dataSourceName()} for help formatting this field.
 */
function fetch_data_source_sample(string $formattedName): void
{
    // Create a client.
    $dataSourcesServiceClient = new DataSourcesServiceClient();

    // Prepare the request message.
    $request = (new FetchDataSourceRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $dataSourcesServiceClient->fetchDataSource($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = DataSourcesServiceClient::dataSourceName('[ACCOUNT]', '[DATASOURCE]');

    fetch_data_source_sample($formattedName);
}
// [END merchantapi_v1_generated_DataSourcesService_FetchDataSource_sync]
