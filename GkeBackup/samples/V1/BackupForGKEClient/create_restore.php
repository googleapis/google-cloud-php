<?php
/*
 * Copyright 2022 Google LLC
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

// [START gkebackup_v1_generated_BackupForGKE_CreateRestore_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GkeBackup\V1\Client\BackupForGKEClient;
use Google\Cloud\GkeBackup\V1\CreateRestoreRequest;
use Google\Cloud\GkeBackup\V1\Restore;
use Google\Rpc\Status;

/**
 * Creates a new Restore for the given RestorePlan.
 *
 * @param string $formattedParent        The RestorePlan within which to create the Restore.
 *                                       Format: `projects/&#42;/locations/&#42;/restorePlans/*`
 *                                       Please see {@see BackupForGKEClient::restorePlanName()} for help formatting this field.
 * @param string $formattedRestoreBackup Immutable. A reference to the
 *                                       [Backup][google.cloud.gkebackup.v1.Backup] used as the source from which
 *                                       this Restore will restore. Note that this Backup must be a sub-resource of
 *                                       the RestorePlan's
 *                                       [backup_plan][google.cloud.gkebackup.v1.RestorePlan.backup_plan]. Format:
 *                                       `projects/&#42;/locations/&#42;/backupPlans/&#42;/backups/*`. Please see
 *                                       {@see BackupForGKEClient::backupName()} for help formatting this field.
 * @param string $restoreId              The client-provided short name for the Restore resource.
 *                                       This name must:
 *
 *                                       - be between 1 and 63 characters long (inclusive)
 *                                       - consist of only lower-case ASCII letters, numbers, and dashes
 *                                       - start with a lower-case letter
 *                                       - end with a lower-case letter or number
 *                                       - be unique within the set of Restores in this RestorePlan.
 */
function create_restore_sample(
    string $formattedParent,
    string $formattedRestoreBackup,
    string $restoreId
): void {
    // Create a client.
    $backupForGKEClient = new BackupForGKEClient();

    // Prepare the request message.
    $restore = (new Restore())
        ->setBackup($formattedRestoreBackup);
    $request = (new CreateRestoreRequest())
        ->setParent($formattedParent)
        ->setRestore($restore)
        ->setRestoreId($restoreId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $backupForGKEClient->createRestore($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Restore $result */
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
    $formattedParent = BackupForGKEClient::restorePlanName('[PROJECT]', '[LOCATION]', '[RESTORE_PLAN]');
    $formattedRestoreBackup = BackupForGKEClient::backupName(
        '[PROJECT]',
        '[LOCATION]',
        '[BACKUP_PLAN]',
        '[BACKUP]'
    );
    $restoreId = '[RESTORE_ID]';

    create_restore_sample($formattedParent, $formattedRestoreBackup, $restoreId);
}
// [END gkebackup_v1_generated_BackupForGKE_CreateRestore_sync]
