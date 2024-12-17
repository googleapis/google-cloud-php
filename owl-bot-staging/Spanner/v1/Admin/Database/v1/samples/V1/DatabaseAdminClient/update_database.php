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

// [START spanner_v1_generated_DatabaseAdmin_UpdateDatabase_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Database\V1\Database;
use Google\Cloud\Spanner\Admin\Database\V1\UpdateDatabaseRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates a Cloud Spanner database. The returned
 * [long-running operation][google.longrunning.Operation] can be used to track
 * the progress of updating the database. If the named database does not
 * exist, returns `NOT_FOUND`.
 *
 * While the operation is pending:
 *
 * * The database's
 * [reconciling][google.spanner.admin.database.v1.Database.reconciling]
 * field is set to true.
 * * Cancelling the operation is best-effort. If the cancellation succeeds,
 * the operation metadata's
 * [cancel_time][google.spanner.admin.database.v1.UpdateDatabaseMetadata.cancel_time]
 * is set, the updates are reverted, and the operation terminates with a
 * `CANCELLED` status.
 * * New UpdateDatabase requests will return a `FAILED_PRECONDITION` error
 * until the pending operation is done (returns successfully or with
 * error).
 * * Reading the database via the API continues to give the pre-request
 * values.
 *
 * Upon completion of the returned operation:
 *
 * * The new values are in effect and readable via the API.
 * * The database's
 * [reconciling][google.spanner.admin.database.v1.Database.reconciling]
 * field becomes false.
 *
 * The returned [long-running operation][google.longrunning.Operation] will
 * have a name of the format
 * `projects/<project>/instances/<instance>/databases/<database>/operations/<operation_id>`
 * and can be used to track the database modification. The
 * [metadata][google.longrunning.Operation.metadata] field type is
 * [UpdateDatabaseMetadata][google.spanner.admin.database.v1.UpdateDatabaseMetadata].
 * The [response][google.longrunning.Operation.response] field type is
 * [Database][google.spanner.admin.database.v1.Database], if successful.
 *
 * @param string $databaseName The name of the database. Values are of the form
 *                             `projects/<project>/instances/<instance>/databases/<database>`,
 *                             where `<database>` is as specified in the `CREATE DATABASE`
 *                             statement. This name can be passed to other API methods to
 *                             identify the database.
 */
function update_database_sample(string $databaseName): void
{
    // Create a client.
    $databaseAdminClient = new DatabaseAdminClient();

    // Prepare the request message.
    $database = (new Database())
        ->setName($databaseName);
    $updateMask = new FieldMask();
    $request = (new UpdateDatabaseRequest())
        ->setDatabase($database)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $databaseAdminClient->updateDatabase($request);
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
    $databaseName = '[NAME]';

    update_database_sample($databaseName);
}
// [END spanner_v1_generated_DatabaseAdmin_UpdateDatabase_sync]
