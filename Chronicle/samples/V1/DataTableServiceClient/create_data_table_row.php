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

// [START chronicle_v1_generated_DataTableService_CreateDataTableRow_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Chronicle\V1\Client\DataTableServiceClient;
use Google\Cloud\Chronicle\V1\CreateDataTableRowRequest;
use Google\Cloud\Chronicle\V1\DataTableRow;

/**
 * Create a new data table row.
 *
 * @param string $formattedParent           The resource id of the data table.
 *                                          Format:
 *                                          /projects/{project}/locations/{location}/instances/{instance}/dataTables/{data_table}
 *                                          Please see {@see DataTableServiceClient::dataTableName()} for help formatting this field.
 * @param string $dataTableRowValuesElement All column values for a single row. The values should be in the
 *                                          same order as the columns of the data tables.
 */
function create_data_table_row_sample(
    string $formattedParent,
    string $dataTableRowValuesElement
): void {
    // Create a client.
    $dataTableServiceClient = new DataTableServiceClient();

    // Prepare the request message.
    $dataTableRowValues = [$dataTableRowValuesElement,];
    $dataTableRow = (new DataTableRow())
        ->setValues($dataTableRowValues);
    $request = (new CreateDataTableRowRequest())
        ->setParent($formattedParent)
        ->setDataTableRow($dataTableRow);

    // Call the API and handle any network failures.
    try {
        /** @var DataTableRow $response */
        $response = $dataTableServiceClient->createDataTableRow($request);
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
    $dataTableRowValuesElement = '[VALUES]';

    create_data_table_row_sample($formattedParent, $dataTableRowValuesElement);
}
// [END chronicle_v1_generated_DataTableService_CreateDataTableRow_sync]
