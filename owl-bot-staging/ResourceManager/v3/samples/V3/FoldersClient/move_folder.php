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

// [START cloudresourcemanager_v3_generated_Folders_MoveFolder_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ResourceManager\V3\Client\FoldersClient;
use Google\Cloud\ResourceManager\V3\Folder;
use Google\Cloud\ResourceManager\V3\MoveFolderRequest;
use Google\Rpc\Status;

/**
 * Moves a folder under a new resource parent.
 * Returns an `Operation` which can be used to track the progress of the
 * folder move workflow.
 * Upon success, the `Operation.response` field will be populated with the
 * moved folder.
 * Upon failure, a `FolderOperationError` categorizing the failure cause will
 * be returned - if the failure occurs synchronously then the
 * `FolderOperationError` will be returned in the `Status.details` field.
 * If it occurs asynchronously, then the FolderOperation will be returned
 * in the `Operation.error` field.
 * In addition, the `Operation.metadata` field will be populated with a
 * `FolderOperation` message as an aid to stateless clients.
 * Folder moves will be rejected if they violate either the naming, height,
 * or fanout constraints described in the
 * [CreateFolder][google.cloud.resourcemanager.v3.Folders.CreateFolder]
 * documentation. The caller must have `resourcemanager.folders.move`
 * permission on the folder's current and proposed new parent.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function move_folder_sample(): void
{
    // Create a client.
    $foldersClient = new FoldersClient();

    // Prepare the request message.
    $request = new MoveFolderRequest();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $foldersClient->moveFolder($request);
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
// [END cloudresourcemanager_v3_generated_Folders_MoveFolder_sync]
