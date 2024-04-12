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

// [START bigtableadmin_v2_generated_BigtableTableAdmin_RestoreTable_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Bigtable\Admin\V2\Client\BigtableTableAdminClient;
use Google\Cloud\Bigtable\Admin\V2\RestoreTableRequest;
use Google\Cloud\Bigtable\Admin\V2\Table;
use Google\Rpc\Status;

/**
 * Create a new table by restoring from a completed backup.  The
 * returned table [long-running operation][google.longrunning.Operation] can
 * be used to track the progress of the operation, and to cancel it.  The
 * [metadata][google.longrunning.Operation.metadata] field type is
 * [RestoreTableMetadata][google.bigtable.admin.RestoreTableMetadata].  The
 * [response][google.longrunning.Operation.response] type is
 * [Table][google.bigtable.admin.v2.Table], if successful.
 *
 * @param string $formattedParent The name of the instance in which to create the restored
 *                                table. Values are of the form `projects/<project>/instances/<instance>`. Please see
 *                                {@see BigtableTableAdminClient::instanceName()} for help formatting this field.
 * @param string $tableId         The id of the table to create and restore to. This
 *                                table must not already exist. The `table_id` appended to
 *                                `parent` forms the full table name of the form
 *                                `projects/<project>/instances/<instance>/tables/<table_id>`.
 */
function restore_table_sample(string $formattedParent, string $tableId): void
{
    // Create a client.
    $bigtableTableAdminClient = new BigtableTableAdminClient();

    // Prepare the request message.
    $request = (new RestoreTableRequest())
        ->setParent($formattedParent)
        ->setTableId($tableId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $bigtableTableAdminClient->restoreTable($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Table $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
        }
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

    restore_table_sample($formattedParent, $tableId);
}
// [END bigtableadmin_v2_generated_BigtableTableAdmin_RestoreTable_sync]
