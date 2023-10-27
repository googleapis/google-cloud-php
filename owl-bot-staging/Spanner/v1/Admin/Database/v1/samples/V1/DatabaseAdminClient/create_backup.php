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

// [START spanner_v1_generated_DatabaseAdmin_CreateBackup_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Spanner\Admin\Database\V1\Backup;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Rpc\Status;

/**
 * Starts creating a new Cloud Spanner Backup.
 * The returned backup [long-running operation][google.longrunning.Operation]
 * will have a name of the format
 * `projects/<project>/instances/<instance>/backups/<backup>/operations/<operation_id>`
 * and can be used to track creation of the backup. The
 * [metadata][google.longrunning.Operation.metadata] field type is
 * [CreateBackupMetadata][google.spanner.admin.database.v1.CreateBackupMetadata]. The
 * [response][google.longrunning.Operation.response] field type is
 * [Backup][google.spanner.admin.database.v1.Backup], if successful. Cancelling the returned operation will stop the
 * creation and delete the backup.
 * There can be only one pending backup creation per database. Backup creation
 * of different databases can run concurrently.
 *
 * @param string $formattedParent The name of the instance in which the backup will be
 *                                created. This must be the same instance that contains the database the
 *                                backup will be created from. The backup will be stored in the
 *                                location(s) specified in the instance configuration of this
 *                                instance. Values are of the form
 *                                `projects/<project>/instances/<instance>`. Please see
 *                                {@see DatabaseAdminClient::instanceName()} for help formatting this field.
 * @param string $backupId        The id of the backup to be created. The `backup_id` appended to
 *                                `parent` forms the full backup name of the form
 *                                `projects/<project>/instances/<instance>/backups/<backup_id>`.
 */
function create_backup_sample(string $formattedParent, string $backupId): void
{
    // Create a client.
    $databaseAdminClient = new DatabaseAdminClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $backup = new Backup();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $databaseAdminClient->createBackup($formattedParent, $backupId, $backup);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Backup $result */
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
    $backupId = '[BACKUP_ID]';

    create_backup_sample($formattedParent, $backupId);
}
// [END spanner_v1_generated_DatabaseAdmin_CreateBackup_sync]
