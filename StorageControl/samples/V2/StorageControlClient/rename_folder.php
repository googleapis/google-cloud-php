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

// [START storage_v2_generated_StorageControl_RenameFolder_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Storage\Control\V2\Client\StorageControlClient;
use Google\Cloud\Storage\Control\V2\Folder;
use Google\Cloud\Storage\Control\V2\RenameFolderRequest;
use Google\Rpc\Status;

/**
 * Renames a source folder to a destination folder. This operation is only
 * applicable to a hierarchical namespace enabled bucket. During a rename, the
 * source and destination folders are locked until the long running operation
 * completes.
 *
 * @param string $formattedName       Name of the source folder being renamed.
 *                                    Format: `projects/{project}/buckets/{bucket}/folders/{folder}`
 *                                    Please see {@see StorageControlClient::folderName()} for help formatting this field.
 * @param string $destinationFolderId The destination folder ID, e.g. `foo/bar/`.
 */
function rename_folder_sample(string $formattedName, string $destinationFolderId): void
{
    // Create a client.
    $storageControlClient = new StorageControlClient();

    // Prepare the request message.
    $request = (new RenameFolderRequest())
        ->setName($formattedName)
        ->setDestinationFolderId($destinationFolderId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $storageControlClient->renameFolder($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Folder $result */
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
    $formattedName = StorageControlClient::folderName('[PROJECT]', '[BUCKET]', '[FOLDER]');
    $destinationFolderId = '[DESTINATION_FOLDER_ID]';

    rename_folder_sample($formattedName, $destinationFolderId);
}
// [END storage_v2_generated_StorageControl_RenameFolder_sync]
