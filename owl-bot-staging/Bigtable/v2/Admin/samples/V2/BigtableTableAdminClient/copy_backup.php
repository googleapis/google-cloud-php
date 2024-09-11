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

// [START bigtableadmin_v2_generated_BigtableTableAdmin_CopyBackup_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Bigtable\Admin\V2\Backup;
use Google\Cloud\Bigtable\Admin\V2\Client\BigtableTableAdminClient;
use Google\Cloud\Bigtable\Admin\V2\CopyBackupRequest;
use Google\Protobuf\Timestamp;
use Google\Rpc\Status;

/**
 * Copy a Cloud Bigtable backup to a new backup in the destination cluster
 * located in the destination instance and project.
 *
 * @param string $formattedParent       The name of the destination cluster that will contain the backup
 *                                      copy. The cluster must already exist. Values are of the form:
 *                                      `projects/{project}/instances/{instance}/clusters/{cluster}`. Please see
 *                                      {@see BigtableTableAdminClient::clusterName()} for help formatting this field.
 * @param string $backupId              The id of the new backup. The `backup_id` along with `parent`
 *                                      are combined as {parent}/backups/{backup_id} to create the full backup
 *                                      name, of the form:
 *                                      `projects/{project}/instances/{instance}/clusters/{cluster}/backups/{backup_id}`.
 *                                      This string must be between 1 and 50 characters in length and match the
 *                                      regex [_a-zA-Z0-9][-_.a-zA-Z0-9]*.
 * @param string $formattedSourceBackup The source backup to be copied from.
 *                                      The source backup needs to be in READY state for it to be copied.
 *                                      Copying a copied backup is not allowed.
 *                                      Once CopyBackup is in progress, the source backup cannot be deleted or
 *                                      cleaned up on expiration until CopyBackup is finished.
 *                                      Values are of the form:
 *                                      `projects/<project>/instances/<instance>/clusters/<cluster>/backups/<backup>`. Please see
 *                                      {@see BigtableTableAdminClient::backupName()} for help formatting this field.
 */
function copy_backup_sample(
    string $formattedParent,
    string $backupId,
    string $formattedSourceBackup
): void {
    // Create a client.
    $bigtableTableAdminClient = new BigtableTableAdminClient();

    // Prepare the request message.
    $expireTime = new Timestamp();
    $request = (new CopyBackupRequest())
        ->setParent($formattedParent)
        ->setBackupId($backupId)
        ->setSourceBackup($formattedSourceBackup)
        ->setExpireTime($expireTime);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $bigtableTableAdminClient->copyBackup($request);
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
    $formattedSourceBackup = BigtableTableAdminClient::backupName(
        '[PROJECT]',
        '[INSTANCE]',
        '[CLUSTER]',
        '[BACKUP]'
    );

    copy_backup_sample($formattedParent, $backupId, $formattedSourceBackup);
}
// [END bigtableadmin_v2_generated_BigtableTableAdmin_CopyBackup_sync]
