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

// [START cloudresourcemanager_v3_generated_Folders_DeleteFolder_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ResourceManager\V3\Client\FoldersClient;
use Google\Cloud\ResourceManager\V3\DeleteFolderRequest;
use Google\Cloud\ResourceManager\V3\Folder;
use Google\Rpc\Status;

/**
 * Requests deletion of a folder. The folder is moved into the
 * [DELETE_REQUESTED][google.cloud.resourcemanager.v3.Folder.State.DELETE_REQUESTED]
 * state immediately, and is deleted approximately 30 days later. This method
 * may only be called on an empty folder, where a folder is empty if it
 * doesn't contain any folders or projects in the
 * [ACTIVE][google.cloud.resourcemanager.v3.Folder.State.ACTIVE] state. If
 * called on a folder in
 * [DELETE_REQUESTED][google.cloud.resourcemanager.v3.Folder.State.DELETE_REQUESTED]
 * state the operation will result in a no-op success.
 * The caller must have `resourcemanager.folders.delete` permission on the
 * identified folder.
 *
 * @param string $formattedName The resource name of the folder to be deleted.
 *                              Must be of the form `folders/{folder_id}`. Please see
 *                              {@see FoldersClient::folderName()} for help formatting this field.
 */
function delete_folder_sample(string $formattedName): void
{
    // Create a client.
    $foldersClient = new FoldersClient();

    // Prepare the request message.
    $request = (new DeleteFolderRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $foldersClient->deleteFolder($request);
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
    $formattedName = FoldersClient::folderName('[FOLDER]');

    delete_folder_sample($formattedName);
}
// [END cloudresourcemanager_v3_generated_Folders_DeleteFolder_sync]
