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

// [START merchantapi_v1_generated_DataSourcesService_CreateDataSource_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\DataSources\V1\Client\DataSourcesServiceClient;
use Google\Shopping\Merchant\DataSources\V1\CreateDataSourceRequest;
use Google\Shopping\Merchant\DataSources\V1\DataSource;

/**
 * Creates the new data source configuration for the given account.
 * This method always creates a new data source.
 *
 * @param string $formattedParent       The account where this data source will be created.
 *                                      Format: `accounts/{account}`
 *                                      Please see {@see DataSourcesServiceClient::accountName()} for help formatting this field.
 * @param string $dataSourceName        Identifier. The name of the data source.
 *                                      Format:
 *                                      `accounts/{account}/dataSources/{datasource}`
 * @param string $dataSourceDisplayName The displayed data source name in the Merchant Center UI.
 */
function create_data_source_sample(
    string $formattedParent,
    string $dataSourceName,
    string $dataSourceDisplayName
): void {
    // Create a client.
    $dataSourcesServiceClient = new DataSourcesServiceClient();

    // Prepare the request message.
    $dataSource = (new DataSource())
        ->setName($dataSourceName)
        ->setDisplayName($dataSourceDisplayName);
    $request = (new CreateDataSourceRequest())
        ->setParent($formattedParent)
        ->setDataSource($dataSource);

    // Call the API and handle any network failures.
    try {
        /** @var DataSource $response */
        $response = $dataSourcesServiceClient->createDataSource($request);
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
    $formattedParent = DataSourcesServiceClient::accountName('[ACCOUNT]');
    $dataSourceName = '[NAME]';
    $dataSourceDisplayName = '[DISPLAY_NAME]';

    create_data_source_sample($formattedParent, $dataSourceName, $dataSourceDisplayName);
}
// [END merchantapi_v1_generated_DataSourcesService_CreateDataSource_sync]
