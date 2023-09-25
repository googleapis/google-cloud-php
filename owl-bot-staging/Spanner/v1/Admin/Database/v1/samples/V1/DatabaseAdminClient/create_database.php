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

// [START spanner_v1_generated_DatabaseAdmin_CreateDatabase_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Spanner\Admin\Database\V1\Database;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Rpc\Status;

/**
 * Creates a new Cloud Spanner database and starts to prepare it for serving.
 * The returned [long-running operation][google.longrunning.Operation] will
 * have a name of the format `<database_name>/operations/<operation_id>` and
 * can be used to track preparation of the database. The
 * [metadata][google.longrunning.Operation.metadata] field type is
 * [CreateDatabaseMetadata][google.spanner.admin.database.v1.CreateDatabaseMetadata]. The
 * [response][google.longrunning.Operation.response] field type is
 * [Database][google.spanner.admin.database.v1.Database], if successful.
 *
 * @param string $formattedParent The name of the instance that will serve the new database.
 *                                Values are of the form `projects/<project>/instances/<instance>`. Please see
 *                                {@see DatabaseAdminClient::instanceName()} for help formatting this field.
 * @param string $createStatement A `CREATE DATABASE` statement, which specifies the ID of the
 *                                new database.  The database ID must conform to the regular expression
 *                                `[a-z][a-z0-9_\-]*[a-z0-9]` and be between 2 and 30 characters in length.
 *                                If the database ID is a reserved word or if it contains a hyphen, the
 *                                database ID must be enclosed in backticks (`` ` ``).
 */
function create_database_sample(string $formattedParent, string $createStatement): void
{
    // Create a client.
    $databaseAdminClient = new DatabaseAdminClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $databaseAdminClient->createDatabase($formattedParent, $createStatement);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Database $result */
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
    $formattedParent = DatabaseAdminClient::instanceName('[PROJECT]', '[INSTANCE]');
    $createStatement = '[CREATE_STATEMENT]';

    create_database_sample($formattedParent, $createStatement);
}
// [END spanner_v1_generated_DatabaseAdmin_CreateDatabase_sync]
