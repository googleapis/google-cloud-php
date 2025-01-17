<?php
/*
 * Copyright 2025 Google LLC
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

// [START redis_v1_generated_CloudRedisCluster_GetBackup_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Redis\Cluster\V1\Backup;
use Google\Cloud\Redis\Cluster\V1\Client\CloudRedisClusterClient;
use Google\Cloud\Redis\Cluster\V1\GetBackupRequest;

/**
 * Gets the details of a specific backup.
 *
 * @param string $formattedName Redis backup resource name using the form:
 *                              `projects/{project_id}/locations/{location_id}/backupCollections/{backup_collection_id}/backups/{backup_id}`
 *                              Please see {@see CloudRedisClusterClient::backupName()} for help formatting this field.
 */
function get_backup_sample(string $formattedName): void
{
    // Create a client.
    $cloudRedisClusterClient = new CloudRedisClusterClient();

    // Prepare the request message.
    $request = (new GetBackupRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Backup $response */
        $response = $cloudRedisClusterClient->getBackup($request);
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
    $formattedName = CloudRedisClusterClient::backupName(
        '[PROJECT]',
        '[LOCATION]',
        '[BACKUP_COLLECTION]',
        '[BACKUP]'
    );

    get_backup_sample($formattedName);
}
// [END redis_v1_generated_CloudRedisCluster_GetBackup_sync]
