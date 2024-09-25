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

// [START merchantapi_v1beta_generated_DataSourcesService_CreateDataSource_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\DataSources\V1beta\Client\DataSourcesServiceClient;
use Google\Shopping\Merchant\DataSources\V1beta\CreateDataSourceRequest;
use Google\Shopping\Merchant\DataSources\V1beta\DataSource;
use Google\Shopping\Merchant\DataSources\V1beta\PrimaryProductDataSource;
use Google\Shopping\Merchant\DataSources\V1beta\PrimaryProductDataSource\Channel;

/**
 * Creates the new data source configuration for the given account.
 *
 * @param string $formattedParent                           The account where this data source will be created.
 *                                                          Format: `accounts/{account}`
 *                                                          Please see {@see DataSourcesServiceClient::accountName()} for help formatting this field.
 * @param int    $dataSourcePrimaryProductDataSourceChannel Immutable. Specifies the type of data source channel.
 * @param string $dataSourceDisplayName                     The displayed data source name in the Merchant Center UI.
 */
function create_data_source_sample(
    string $formattedParent,
    int $dataSourcePrimaryProductDataSourceChannel,
    string $dataSourceDisplayName
): void {
    // Create a client.
    $dataSourcesServiceClient = new DataSourcesServiceClient();

    // Prepare the request message.
    $dataSourcePrimaryProductDataSource = (new PrimaryProductDataSource())
        ->setChannel($dataSourcePrimaryProductDataSourceChannel);
    $dataSource = (new DataSource())
        ->setPrimaryProductDataSource($dataSourcePrimaryProductDataSource)
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
    $dataSourcePrimaryProductDataSourceChannel = Channel::CHANNEL_UNSPECIFIED;
    $dataSourceDisplayName = '[DISPLAY_NAME]';

    create_data_source_sample(
        $formattedParent,
        $dataSourcePrimaryProductDataSourceChannel,
        $dataSourceDisplayName
    );
}
// [END merchantapi_v1beta_generated_DataSourcesService_CreateDataSource_sync]
