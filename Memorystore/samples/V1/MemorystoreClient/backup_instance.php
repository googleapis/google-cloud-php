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

// [START memorystore_v1_generated_Memorystore_BackupInstance_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Memorystore\V1\BackupInstanceRequest;
use Google\Cloud\Memorystore\V1\Client\MemorystoreClient;
use Google\Cloud\Memorystore\V1\Instance;
use Google\Rpc\Status;

/**
 * Backup Instance.
 * If this is the first time a backup is being created, a backup collection
 * will be created at the backend, and this backup belongs to this collection.
 * Both collection and backup will have a resource name. Backup will be
 * executed for each shard. A replica (primary if nonHA) will be selected to
 * perform the execution. Backup call will be rejected if there is an ongoing
 * backup or update operation. Be aware that during preview, if the instance's
 * internal software version is too old, critical update will be performed
 * before actual backup. Once the internal software version is updated to the
 * minimum version required by the backup feature, subsequent backups will not
 * require critical update. After preview, there will be no critical update
 * needed for backup.
 *
 * @param string $formattedName Instance resource name using the form:
 *                              `projects/{project_id}/locations/{location_id}/instances/{instance_id}`
 *                              where `location_id` refers to a Google Cloud region. Please see
 *                              {@see MemorystoreClient::instanceName()} for help formatting this field.
 */
function backup_instance_sample(string $formattedName): void
{
    // Create a client.
    $memorystoreClient = new MemorystoreClient();

    // Prepare the request message.
    $request = (new BackupInstanceRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $memorystoreClient->backupInstance($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Instance $result */
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
    $formattedName = MemorystoreClient::instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');

    backup_instance_sample($formattedName);
}
// [END memorystore_v1_generated_Memorystore_BackupInstance_sync]
