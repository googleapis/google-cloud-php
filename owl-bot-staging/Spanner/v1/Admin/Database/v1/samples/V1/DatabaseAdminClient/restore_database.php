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

// [START spanner_v1_generated_DatabaseAdmin_RestoreDatabase_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Spanner\Admin\Database\V1\Database;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Rpc\Status;

/**
 * Create a new database by restoring from a completed backup. The new
 * database must be in the same project and in an instance with the same
 * instance configuration as the instance containing
 * the backup. The returned database [long-running
 * operation][google.longrunning.Operation] has a name of the format
 * `projects/<project>/instances/<instance>/databases/<database>/operations/<operation_id>`,
 * and can be used to track the progress of the operation, and to cancel it.
 * The [metadata][google.longrunning.Operation.metadata] field type is
 * [RestoreDatabaseMetadata][google.spanner.admin.database.v1.RestoreDatabaseMetadata].
 * The [response][google.longrunning.Operation.response] type
 * is [Database][google.spanner.admin.database.v1.Database], if
 * successful. Cancelling the returned operation will stop the restore and
 * delete the database.
 * There can be only one database being restored into an instance at a time.
 * Once the restore operation completes, a new restore operation can be
 * initiated, without waiting for the optimize operation associated with the
 * first restore to complete.
 *
 * @param string $formattedParent The name of the instance in which to create the
 *                                restored database. This instance must be in the same project and
 *                                have the same instance configuration as the instance containing
 *                                the source backup. Values are of the form
 *                                `projects/<project>/instances/<instance>`. Please see
 *                                {@see DatabaseAdminClient::instanceName()} for help formatting this field.
 * @param string $databaseId      The id of the database to create and restore to. This
 *                                database must not already exist. The `database_id` appended to
 *                                `parent` forms the full database name of the form
 *                                `projects/<project>/instances/<instance>/databases/<database_id>`.
 */
function restore_database_sample(string $formattedParent, string $databaseId): void
{
    // Create a client.
    $databaseAdminClient = new DatabaseAdminClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $databaseAdminClient->restoreDatabase($formattedParent, $databaseId);
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
    $databaseId = '[DATABASE_ID]';

    restore_database_sample($formattedParent, $databaseId);
}
// [END spanner_v1_generated_DatabaseAdmin_RestoreDatabase_sync]
