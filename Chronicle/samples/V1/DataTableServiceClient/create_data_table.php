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

// [START chronicle_v1_generated_DataTableService_CreateDataTable_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Chronicle\V1\Client\DataTableServiceClient;
use Google\Cloud\Chronicle\V1\CreateDataTableRequest;
use Google\Cloud\Chronicle\V1\DataTable;

/**
 * Create a new data table.
 *
 * @param string $formattedParent      The parent resource where this data table will be created.
 *                                     Format: projects/{project}/locations/{location}/instances/{instance}
 *                                     Please see {@see DataTableServiceClient::instanceName()} for help formatting this field.
 * @param string $dataTableDescription A user-provided description of the data table.
 * @param string $dataTableId          The ID to use for the data table. This is also the display name
 *                                     for the data table. It must satisfy the following requirements:
 *                                     - Starts with letter.
 *                                     - Contains only letters, numbers and underscore.
 *                                     - Must be unique and has length < 256.
 */
function create_data_table_sample(
    string $formattedParent,
    string $dataTableDescription,
    string $dataTableId
): void {
    // Create a client.
    $dataTableServiceClient = new DataTableServiceClient();

    // Prepare the request message.
    $dataTable = (new DataTable())
        ->setDescription($dataTableDescription);
    $request = (new CreateDataTableRequest())
        ->setParent($formattedParent)
        ->setDataTable($dataTable)
        ->setDataTableId($dataTableId);

    // Call the API and handle any network failures.
    try {
        /** @var DataTable $response */
        $response = $dataTableServiceClient->createDataTable($request);
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
    $formattedParent = DataTableServiceClient::instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
    $dataTableDescription = '[DESCRIPTION]';
    $dataTableId = '[DATA_TABLE_ID]';

    create_data_table_sample($formattedParent, $dataTableDescription, $dataTableId);
}
// [END chronicle_v1_generated_DataTableService_CreateDataTable_sync]
