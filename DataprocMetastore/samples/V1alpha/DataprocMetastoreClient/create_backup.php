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

// [START metastore_v1alpha_generated_DataprocMetastore_CreateBackup_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Metastore\V1alpha\Backup;
use Google\Cloud\Metastore\V1alpha\DataprocMetastoreClient;
use Google\Rpc\Status;

/**
 * Creates a new backup in a given project and location.
 *
 * @param string $formattedParent The relative resource name of the service in which to create a
 *                                backup of the following form:
 *
 *                                `projects/{project_number}/locations/{location_id}/services/{service_id}`. Please see
 *                                {@see DataprocMetastoreClient::serviceName()} for help formatting this field.
 * @param string $backupId        The ID of the backup, which is used as the final component of the
 *                                backup's name.
 *
 *                                This value must be between 1 and 64 characters long, begin with a letter,
 *                                end with a letter or number, and consist of alpha-numeric ASCII characters
 *                                or hyphens.
 */
function create_backup_sample(string $formattedParent, string $backupId): void
{
    // Create a client.
    $dataprocMetastoreClient = new DataprocMetastoreClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $backup = new Backup();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $dataprocMetastoreClient->createBackup($formattedParent, $backupId, $backup);
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
    $formattedParent = DataprocMetastoreClient::serviceName('[PROJECT]', '[LOCATION]', '[SERVICE]');
    $backupId = '[BACKUP_ID]';

    create_backup_sample($formattedParent, $backupId);
}
// [END metastore_v1alpha_generated_DataprocMetastore_CreateBackup_sync]
