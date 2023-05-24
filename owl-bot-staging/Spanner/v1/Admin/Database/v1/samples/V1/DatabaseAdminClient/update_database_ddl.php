<?php
/*
 * Copyright 2023 Google LLC
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

// [START spanner_v1_generated_DatabaseAdmin_UpdateDatabaseDdl_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Rpc\Status;

/**
 * Updates the schema of a Cloud Spanner database by
 * creating/altering/dropping tables, columns, indexes, etc. The returned
 * [long-running operation][google.longrunning.Operation] will have a name of
 * the format `<database_name>/operations/<operation_id>` and can be used to
 * track execution of the schema change(s). The
 * [metadata][google.longrunning.Operation.metadata] field type is
 * [UpdateDatabaseDdlMetadata][google.spanner.admin.database.v1.UpdateDatabaseDdlMetadata].  The operation has no response.
 *
 * @param string $formattedDatabase The database to update. Please see
 *                                  {@see DatabaseAdminClient::databaseName()} for help formatting this field.
 * @param string $statementsElement DDL statements to be applied to the database.
 */
function update_database_ddl_sample(string $formattedDatabase, string $statementsElement): void
{
    // Create a client.
    $databaseAdminClient = new DatabaseAdminClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $statements = [$statementsElement,];

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $databaseAdminClient->updateDatabaseDdl($formattedDatabase, $statements);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
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
    $formattedDatabase = DatabaseAdminClient::databaseName('[PROJECT]', '[INSTANCE]', '[DATABASE]');
    $statementsElement = '[STATEMENTS]';

    update_database_ddl_sample($formattedDatabase, $statementsElement);
}
// [END spanner_v1_generated_DatabaseAdmin_UpdateDatabaseDdl_sync]
