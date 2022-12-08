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

// [START cloudresourcemanager_v3_generated_Folders_GetFolder_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ResourceManager\V3\Folder;
use Google\Cloud\ResourceManager\V3\FoldersClient;

/**
 * Retrieves a folder identified by the supplied resource name.
 * Valid folder resource names have the format `folders/{folder_id}`
 * (for example, `folders/1234`).
 * The caller must have `resourcemanager.folders.get` permission on the
 * identified folder.
 *
 * @param string $formattedName The resource name of the folder to retrieve.
 *                              Must be of the form `folders/{folder_id}`. Please see
 *                              {@see FoldersClient::folderName()} for help formatting this field.
 */
function get_folder_sample(string $formattedName): void
{
    // Create a client.
    $foldersClient = new FoldersClient();

    // Call the API and handle any network failures.
    try {
        /** @var Folder $response */
        $response = $foldersClient->getFolder($formattedName);
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
    $formattedName = FoldersClient::folderName('[FOLDER]');

    get_folder_sample($formattedName);
}
// [END cloudresourcemanager_v3_generated_Folders_GetFolder_sync]
