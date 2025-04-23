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

// [START gkebackup_v1_generated_BackupForGKE_UpdateRestoreChannel_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\GkeBackup\V1\Client\BackupForGKEClient;
use Google\Cloud\GkeBackup\V1\RestoreChannel;
use Google\Cloud\GkeBackup\V1\UpdateRestoreChannelRequest;
use Google\Rpc\Status;

/**
 * Update a RestoreChannel.
 *
 * @param string $restoreChannelDestinationProject Immutable. The project into which the backups will be restored.
 *                                                 The format is `projects/{project}`.
 *                                                 Currently, {project} can only be the project number. Support for project
 *                                                 IDs will be added in the future.
 */
function update_restore_channel_sample(string $restoreChannelDestinationProject): void
{
    // Create a client.
    $backupForGKEClient = new BackupForGKEClient();

    // Prepare the request message.
    $restoreChannel = (new RestoreChannel())
        ->setDestinationProject($restoreChannelDestinationProject);
    $request = (new UpdateRestoreChannelRequest())
        ->setRestoreChannel($restoreChannel);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $backupForGKEClient->updateRestoreChannel($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var RestoreChannel $result */
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
    $restoreChannelDestinationProject = '[DESTINATION_PROJECT]';

    update_restore_channel_sample($restoreChannelDestinationProject);
}
// [END gkebackup_v1_generated_BackupForGKE_UpdateRestoreChannel_sync]
