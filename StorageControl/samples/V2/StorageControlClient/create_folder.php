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

// [START storage_v2_generated_StorageControl_CreateFolder_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Storage\Control\V2\Client\StorageControlClient;
use Google\Cloud\Storage\Control\V2\CreateFolderRequest;
use Google\Cloud\Storage\Control\V2\Folder;

/**
 * Creates a new folder. This operation is only applicable to a hierarchical
 * namespace enabled bucket.
 *
 * @param string $formattedParent Name of the bucket in which the folder will reside. The bucket
 *                                must be a hierarchical namespace enabled bucket. Please see
 *                                {@see StorageControlClient::bucketName()} for help formatting this field.
 * @param string $folderId        The full name of a folder, including all its parent folders.
 *                                Folders use single '/' characters as a delimiter.
 *                                The folder_id must end with a slash.
 *                                For example, the folder_id of "books/biographies/" would create a new
 *                                "biographies/" folder under the "books/" folder.
 */
function create_folder_sample(string $formattedParent, string $folderId): void
{
    // Create a client.
    $storageControlClient = new StorageControlClient();

    // Prepare the request message.
    $folder = new Folder();
    $request = (new CreateFolderRequest())
        ->setParent($formattedParent)
        ->setFolder($folder)
        ->setFolderId($folderId);

    // Call the API and handle any network failures.
    try {
        /** @var Folder $response */
        $response = $storageControlClient->createFolder($request);
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
    $formattedParent = StorageControlClient::bucketName('[PROJECT]', '[BUCKET]');
    $folderId = '[FOLDER_ID]';

    create_folder_sample($formattedParent, $folderId);
}
// [END storage_v2_generated_StorageControl_CreateFolder_sync]
