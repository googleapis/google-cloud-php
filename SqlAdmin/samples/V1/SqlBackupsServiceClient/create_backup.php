<?php
/*
 * Copyright 2026 Google LLC
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

// [START sqladmin_v1_generated_SqlBackupsService_CreateBackup_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Sql\V1\Backup;
use Google\Cloud\Sql\V1\Client\SqlBackupsServiceClient;
use Google\Cloud\Sql\V1\CreateBackupRequest;
use Google\Cloud\Sql\V1\Operation;

/**
 * Creates a backup for a Cloud SQL instance. This API can be used only to
 * create on-demand backups.
 *
 * @param string $formattedParent The parent resource where this backup is created.
 *                                Format: projects/{project}
 *                                Please see {@see SqlBackupsServiceClient::projectName()} for help formatting this field.
 */
function create_backup_sample(string $formattedParent): void
{
    // Create a client.
    $sqlBackupsServiceClient = new SqlBackupsServiceClient();

    // Prepare the request message.
    $backup = new Backup();
    $request = (new CreateBackupRequest())
        ->setParent($formattedParent)
        ->setBackup($backup);

    // Call the API and handle any network failures.
    try {
        /** @var Operation $response */
        $response = $sqlBackupsServiceClient->createBackup($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
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
    $formattedParent = SqlBackupsServiceClient::projectName('[PROJECT]');

    create_backup_sample($formattedParent);
}
// [END sqladmin_v1_generated_SqlBackupsService_CreateBackup_sync]
