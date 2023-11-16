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

// [START cloudresourcemanager_v3_generated_Folders_CreateFolder_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ResourceManager\V3\Client\FoldersClient;
use Google\Cloud\ResourceManager\V3\CreateFolderRequest;
use Google\Cloud\ResourceManager\V3\Folder;
use Google\Rpc\Status;

/**
 * Creates a folder in the resource hierarchy.
 * Returns an `Operation` which can be used to track the progress of the
 * folder creation workflow.
 * Upon success, the `Operation.response` field will be populated with the
 * created Folder.
 *
 * In order to succeed, the addition of this new folder must not violate
 * the folder naming, height, or fanout constraints.
 *
 * + The folder's `display_name` must be distinct from all other folders that
 * share its parent.
 * + The addition of the folder must not cause the active folder hierarchy
 * to exceed a height of 10. Note, the full active + deleted folder hierarchy
 * is allowed to reach a height of 20; this provides additional headroom when
 * moving folders that contain deleted folders.
 * + The addition of the folder must not cause the total number of folders
 * under its parent to exceed 300.
 *
 * If the operation fails due to a folder constraint violation, some errors
 * may be returned by the `CreateFolder` request, with status code
 * `FAILED_PRECONDITION` and an error description. Other folder constraint
 * violations will be communicated in the `Operation`, with the specific
 * `PreconditionFailure` returned in the details list in the `Operation.error`
 * field.
 *
 * The caller must have `resourcemanager.folders.create` permission on the
 * identified parent.
 *
 * @param string $folderParent The folder's parent's resource name.
 *                             Updates to the folder's parent must be performed using
 *                             [MoveFolder][google.cloud.resourcemanager.v3.Folders.MoveFolder].
 */
function create_folder_sample(string $folderParent): void
{
    // Create a client.
    $foldersClient = new FoldersClient();

    // Prepare the request message.
    $folder = (new Folder())
        ->setParent($folderParent);
    $request = (new CreateFolderRequest())
        ->setFolder($folder);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $foldersClient->createFolder($request);
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
    $folderParent = '[PARENT]';

    create_folder_sample($folderParent);
}
// [END cloudresourcemanager_v3_generated_Folders_CreateFolder_sync]
