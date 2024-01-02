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

// [START bigtableadmin_v2_generated_BigtableTableAdmin_CreateTable_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient;
use Google\Cloud\Bigtable\Admin\V2\Table;

/**
 * Creates a new table in the specified instance.
 * The table can be created with a full set of initial column families,
 * specified in the request.
 *
 * @param string $formattedParent The unique name of the instance in which to create the table.
 *                                Values are of the form `projects/{project}/instances/{instance}`. Please see
 *                                {@see BigtableTableAdminClient::instanceName()} for help formatting this field.
 * @param string $tableId         The name by which the new table should be referred to within the
 *                                parent instance, e.g., `foobar` rather than `{parent}/tables/foobar`.
 *                                Maximum 50 characters.
 */
function create_table_sample(string $formattedParent, string $tableId): void
{
    // Create a client.
    $bigtableTableAdminClient = new BigtableTableAdminClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $table = new Table();

    // Call the API and handle any network failures.
    try {
        /** @var Table $response */
        $response = $bigtableTableAdminClient->createTable($formattedParent, $tableId, $table);
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
    $formattedParent = BigtableTableAdminClient::instanceName('[PROJECT]', '[INSTANCE]');
    $tableId = '[TABLE_ID]';

    create_table_sample($formattedParent, $tableId);
}
// [END bigtableadmin_v2_generated_BigtableTableAdmin_CreateTable_sync]
