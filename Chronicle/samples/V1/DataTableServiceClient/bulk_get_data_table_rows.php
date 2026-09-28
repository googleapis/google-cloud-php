<?php
/*
 * Copyright 2026 Google LLC
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

// [START chronicle_v1_generated_DataTableService_BulkGetDataTableRows_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Chronicle\V1\BulkGetDataTableRowsRequest;
use Google\Cloud\Chronicle\V1\BulkGetDataTableRowsResponse;
use Google\Cloud\Chronicle\V1\Client\DataTableServiceClient;
use Google\Cloud\Chronicle\V1\GetDataTableRowRequest;

/**
 * Get data table rows in bulk.
 *
 * @param string $formattedParent       The resource id of the data table.
 *                                      Format:
 *                                      /projects/{project}/locations/{location}/instances/{instance}/dataTables/{data_table}
 *                                      Please see {@see DataTableServiceClient::dataTableName()} for help formatting this field.
 * @param string $formattedRequestsName The resource name of the data table row i,e row_id.
 *                                      Format:
 *                                      projects/{project}/locations/{location}/instances/{instance}/dataTables/{data_table}/dataTableRows/{data_table_row}
 *                                      Please see {@see DataTableServiceClient::dataTableRowName()} for help formatting this field.
 */
function bulk_get_data_table_rows_sample(
    string $formattedParent,
    string $formattedRequestsName
): void {
    // Create a client.
    $dataTableServiceClient = new DataTableServiceClient();

    // Prepare the request message.
    $getDataTableRowRequest = (new GetDataTableRowRequest())
        ->setName($formattedRequestsName);
    $requests = [$getDataTableRowRequest,];
    $request = (new BulkGetDataTableRowsRequest())
        ->setParent($formattedParent)
        ->setRequests($requests);

    // Call the API and handle any network failures.
    try {
        /** @var BulkGetDataTableRowsResponse $response */
        $response = $dataTableServiceClient->bulkGetDataTableRows($request);
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
    $formattedParent = DataTableServiceClient::dataTableName(
        '[PROJECT]',
        '[LOCATION]',
        '[INSTANCE]',
        '[DATA_TABLE]'
    );
    $formattedRequestsName = DataTableServiceClient::dataTableRowName(
        '[PROJECT]',
        '[LOCATION]',
        '[INSTANCE]',
        '[DATA_TABLE]',
        '[DATA_TABLE_ROW]'
    );

    bulk_get_data_table_rows_sample($formattedParent, $formattedRequestsName);
}
// [END chronicle_v1_generated_DataTableService_BulkGetDataTableRows_sync]
