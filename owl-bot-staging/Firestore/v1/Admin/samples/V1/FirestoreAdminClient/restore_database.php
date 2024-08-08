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

// [START firestore_v1_generated_FirestoreAdmin_RestoreDatabase_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Firestore\Admin\V1\Client\FirestoreAdminClient;
use Google\Cloud\Firestore\Admin\V1\Database;
use Google\Cloud\Firestore\Admin\V1\RestoreDatabaseRequest;
use Google\Rpc\Status;

/**
 * Creates a new database by restoring from an existing backup.
 *
 * The new database must be in the same cloud region or multi-region location
 * as the existing backup. This behaves similar to
 * [FirestoreAdmin.CreateDatabase][google.firestore.admin.v1.FirestoreAdmin.CreateDatabase]
 * except instead of creating a new empty database, a new database is created
 * with the database type, index configuration, and documents from an existing
 * backup.
 *
 * The [long-running operation][google.longrunning.Operation] can be used to
 * track the progress of the restore, with the Operation's
 * [metadata][google.longrunning.Operation.metadata] field type being the
 * [RestoreDatabaseMetadata][google.firestore.admin.v1.RestoreDatabaseMetadata].
 * The [response][google.longrunning.Operation.response] type is the
 * [Database][google.firestore.admin.v1.Database] if the restore was
 * successful. The new database is not readable or writeable until the LRO has
 * completed.
 *
 * @param string $formattedParent The project to restore the database in. Format is
 *                                `projects/{project_id}`. Please see
 *                                {@see FirestoreAdminClient::projectName()} for help formatting this field.
 * @param string $databaseId      The ID to use for the database, which will become the final
 *                                component of the database's resource name. This database id must not be
 *                                associated with an existing database.
 *
 *                                This value should be 4-63 characters. Valid characters are /[a-z][0-9]-/
 *                                with first character a letter and the last a letter or a number. Must not
 *                                be UUID-like /[0-9a-f]{8}(-[0-9a-f]{4}){3}-[0-9a-f]{12}/.
 *
 *                                "(default)" database id is also valid.
 * @param string $formattedBackup Backup to restore from. Must be from the same project as the
 *                                parent.
 *
 *                                Format is: `projects/{project_id}/locations/{location}/backups/{backup}`
 *                                Please see {@see FirestoreAdminClient::backupName()} for help formatting this field.
 */
function restore_database_sample(
    string $formattedParent,
    string $databaseId,
    string $formattedBackup
): void {
    // Create a client.
    $firestoreAdminClient = new FirestoreAdminClient();

    // Prepare the request message.
    $request = (new RestoreDatabaseRequest())
        ->setParent($formattedParent)
        ->setDatabaseId($databaseId)
        ->setBackup($formattedBackup);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $firestoreAdminClient->restoreDatabase($request);
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
    $formattedParent = FirestoreAdminClient::projectName('[PROJECT]');
    $databaseId = '[DATABASE_ID]';
    $formattedBackup = FirestoreAdminClient::backupName('[PROJECT]', '[LOCATION]', '[BACKUP]');

    restore_database_sample($formattedParent, $databaseId, $formattedBackup);
}
// [END firestore_v1_generated_FirestoreAdmin_RestoreDatabase_sync]
