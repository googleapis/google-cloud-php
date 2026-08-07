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

// [START chronicle_v1_generated_DataTableService_UpdateDataTableRow_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Chronicle\V1\Client\DataTableServiceClient;
use Google\Cloud\Chronicle\V1\DataTableRow;
use Google\Cloud\Chronicle\V1\UpdateDataTableRowRequest;

/**
 * Update data table row
 *
 * @param string $dataTableRowValuesElement All column values for a single row. The values should be in the
 *                                          same order as the columns of the data tables.
 */
function update_data_table_row_sample(string $dataTableRowValuesElement): void
{
    // Create a client.
    $dataTableServiceClient = new DataTableServiceClient();

    // Prepare the request message.
    $dataTableRowValues = [$dataTableRowValuesElement,];
    $dataTableRow = (new DataTableRow())
        ->setValues($dataTableRowValues);
    $request = (new UpdateDataTableRowRequest())
        ->setDataTableRow($dataTableRow);

    // Call the API and handle any network failures.
    try {
        /** @var DataTableRow $response */
        $response = $dataTableServiceClient->updateDataTableRow($request);
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
    $dataTableRowValuesElement = '[VALUES]';

    update_data_table_row_sample($dataTableRowValuesElement);
}
// [END chronicle_v1_generated_DataTableService_UpdateDataTableRow_sync]
