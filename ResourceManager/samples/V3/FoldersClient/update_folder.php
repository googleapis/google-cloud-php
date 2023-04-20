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

// [START cloudresourcemanager_v3_generated_Folders_UpdateFolder_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ResourceManager\V3\Folder;
use Google\Cloud\ResourceManager\V3\FoldersClient;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates a folder, changing its `display_name`.
 * Changes to the folder `display_name` will be rejected if they violate
 * either the `display_name` formatting rules or the naming constraints
 * described in the
 * [CreateFolder][google.cloud.resourcemanager.v3.Folders.CreateFolder]
 * documentation.
 *
 * The folder's `display_name` must start and end with a letter or digit,
 * may contain letters, digits, spaces, hyphens and underscores and can be
 * between 3 and 30 characters. This is captured by the regular expression:
 * `[\p{L}\p{N}][\p{L}\p{N}_- ]{1,28}[\p{L}\p{N}]`.
 * The caller must have `resourcemanager.folders.update` permission on the
 * identified folder.
 *
 * If the update fails due to the unique name constraint then a
 * `PreconditionFailure` explaining this violation will be returned
 * in the Status.details field.
 *
 * @param string $folderParent The folder's parent's resource name.
 *                             Updates to the folder's parent must be performed using
 *                             [MoveFolder][google.cloud.resourcemanager.v3.Folders.MoveFolder].
 */
function update_folder_sample(string $folderParent): void
{
    // Create a client.
    $foldersClient = new FoldersClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $folder = (new Folder())
        ->setParent($folderParent);
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $foldersClient->updateFolder($folder, $updateMask);
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

    update_folder_sample($folderParent);
}
// [END cloudresourcemanager_v3_generated_Folders_UpdateFolder_sync]
