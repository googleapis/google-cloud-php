<?php
/*
 * Copyright 2022 Google LLC
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

// [START bigtableadmin_v2_generated_BigtableTableAdmin_ModifyColumnFamilies_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient;
use Google\Cloud\Bigtable\Admin\V2\ModifyColumnFamiliesRequest\Modification;
use Google\Cloud\Bigtable\Admin\V2\Table;

/**
 * Performs a series of column family modifications on the specified table.
 * Either all or none of the modifications will occur before this method
 * returns, but data requests received prior to that point may see a table
 * where only some modifications have taken effect.
 *
 * @param string $formattedName The unique name of the table whose families should be modified.
 *                              Values are of the form
 *                              `projects/{project}/instances/{instance}/tables/{table}`. Please see
 *                              {@see BigtableTableAdminClient::tableName()} for help formatting this field.
 */
function modify_column_families_sample(string $formattedName): void
{
    // Create a client.
    $bigtableTableAdminClient = new BigtableTableAdminClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $modifications = [new Modification()];

    // Call the API and handle any network failures.
    try {
        /** @var Table $response */
        $response = $bigtableTableAdminClient->modifyColumnFamilies($formattedName, $modifications);
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
    $formattedName = BigtableTableAdminClient::tableName('[PROJECT]', '[INSTANCE]', '[TABLE]');

    modify_column_families_sample($formattedName);
}
// [END bigtableadmin_v2_generated_BigtableTableAdmin_ModifyColumnFamilies_sync]
