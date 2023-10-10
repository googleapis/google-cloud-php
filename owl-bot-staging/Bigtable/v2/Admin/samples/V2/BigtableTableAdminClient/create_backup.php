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

// [START bigtableadmin_v2_generated_BigtableTableAdmin_CreateBackup_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Bigtable\Admin\V2\Backup;
use Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient;
use Google\Protobuf\Timestamp;
use Google\Rpc\Status;

/**
 * Starts creating a new Cloud Bigtable Backup.  The returned backup
 * [long-running operation][google.longrunning.Operation] can be used to
 * track creation of the backup. The
 * [metadata][google.longrunning.Operation.metadata] field type is
 * [CreateBackupMetadata][google.bigtable.admin.v2.CreateBackupMetadata]. The
 * [response][google.longrunning.Operation.response] field type is
 * [Backup][google.bigtable.admin.v2.Backup], if successful. Cancelling the
 * returned operation will stop the creation and delete the backup.
 *
 * @param string $formattedParent   This must be one of the clusters in the instance in which this
 *                                  table is located. The backup will be stored in this cluster. Values are
 *                                  of the form `projects/{project}/instances/{instance}/clusters/{cluster}`. Please see
 *                                  {@see BigtableTableAdminClient::clusterName()} for help formatting this field.
 * @param string $backupId          The id of the backup to be created. The `backup_id` along with
 *                                  the parent `parent` are combined as {parent}/backups/{backup_id} to create
 *                                  the full backup name, of the form:
 *                                  `projects/{project}/instances/{instance}/clusters/{cluster}/backups/{backup_id}`.
 *                                  This string must be between 1 and 50 characters in length and match the
 *                                  regex [_a-zA-Z0-9][-_.a-zA-Z0-9]*.
 * @param string $backupSourceTable Immutable. Name of the table from which this backup was created.
 *                                  This needs to be in the same instance as the backup. Values are of the form
 *                                  `projects/{project}/instances/{instance}/tables/{source_table}`.
 */
function create_backup_sample(
    string $formattedParent,
    string $backupId,
    string $backupSourceTable
): void {
    // Create a client.
    $bigtableTableAdminClient = new BigtableTableAdminClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $backupExpireTime = new Timestamp();
    $backup = (new Backup())
        ->setSourceTable($backupSourceTable)
        ->setExpireTime($backupExpireTime);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $bigtableTableAdminClient->createBackup($formattedParent, $backupId, $backup);
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
    $formattedParent = BigtableTableAdminClient::clusterName('[PROJECT]', '[INSTANCE]', '[CLUSTER]');
    $backupId = '[BACKUP_ID]';
    $backupSourceTable = '[SOURCE_TABLE]';

    create_backup_sample($formattedParent, $backupId, $backupSourceTable);
}
// [END bigtableadmin_v2_generated_BigtableTableAdmin_CreateBackup_sync]
