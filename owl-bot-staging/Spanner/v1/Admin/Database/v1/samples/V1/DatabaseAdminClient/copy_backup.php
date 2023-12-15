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

// [START spanner_v1_generated_DatabaseAdmin_CopyBackup_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Spanner\Admin\Database\V1\Backup;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Protobuf\Timestamp;
use Google\Rpc\Status;

/**
 * Starts copying a Cloud Spanner Backup.
 * The returned backup [long-running operation][google.longrunning.Operation]
 * will have a name of the format
 * `projects/<project>/instances/<instance>/backups/<backup>/operations/<operation_id>`
 * and can be used to track copying of the backup. The operation is associated
 * with the destination backup.
 * The [metadata][google.longrunning.Operation.metadata] field type is
 * [CopyBackupMetadata][google.spanner.admin.database.v1.CopyBackupMetadata].
 * The [response][google.longrunning.Operation.response] field type is
 * [Backup][google.spanner.admin.database.v1.Backup], if successful. Cancelling the returned operation will stop the
 * copying and delete the backup.
 * Concurrent CopyBackup requests can run on the same source backup.
 *
 * @param string $formattedParent       The name of the destination instance that will contain the backup copy.
 *                                      Values are of the form: `projects/<project>/instances/<instance>`. Please see
 *                                      {@see DatabaseAdminClient::instanceName()} for help formatting this field.
 * @param string $backupId              The id of the backup copy.
 *                                      The `backup_id` appended to `parent` forms the full backup_uri of the form
 *                                      `projects/<project>/instances/<instance>/backups/<backup>`.
 * @param string $formattedSourceBackup The source backup to be copied.
 *                                      The source backup needs to be in READY state for it to be copied.
 *                                      Once CopyBackup is in progress, the source backup cannot be deleted or
 *                                      cleaned up on expiration until CopyBackup is finished.
 *                                      Values are of the form:
 *                                      `projects/<project>/instances/<instance>/backups/<backup>`. Please see
 *                                      {@see DatabaseAdminClient::backupName()} for help formatting this field.
 */
function copy_backup_sample(
    string $formattedParent,
    string $backupId,
    string $formattedSourceBackup
): void {
    // Create a client.
    $databaseAdminClient = new DatabaseAdminClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $expireTime = new Timestamp();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $databaseAdminClient->copyBackup(
            $formattedParent,
            $backupId,
            $formattedSourceBackup,
            $expireTime
        );
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
    $formattedSourceBackup = DatabaseAdminClient::backupName('[PROJECT]', '[INSTANCE]', '[BACKUP]');

    copy_backup_sample($formattedParent, $backupId, $formattedSourceBackup);
}
// [END spanner_v1_generated_DatabaseAdmin_CopyBackup_sync]
