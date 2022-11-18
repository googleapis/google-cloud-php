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

// [START metastore_v1_generated_DataprocMetastore_DeleteBackup_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Metastore\V1\DataprocMetastoreClient;
use Google\Rpc\Status;

/**
 * Deletes a single backup.
 *
 * @param string $formattedName The relative resource name of the backup to delete, in the
 *                              following form:
 *
 *                              `projects/{project_number}/locations/{location_id}/services/{service_id}/backups/{backup_id}`. Please see
 *                              {@see DataprocMetastoreClient::backupName()} for help formatting this field.
 */
function delete_backup_sample(string $formattedName): void
{
    // Create a client.
    $dataprocMetastoreClient = new DataprocMetastoreClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $dataprocMetastoreClient->deleteBackup($formattedName);
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
    $formattedName = DataprocMetastoreClient::backupName(
        '[PROJECT]',
        '[LOCATION]',
        '[SERVICE]',
        '[BACKUP]'
    );

    delete_backup_sample($formattedName);
}
// [END metastore_v1_generated_DataprocMetastore_DeleteBackup_sync]
