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

// [START storage_v2_generated_StorageControl_CreateManagedFolder_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Storage\Control\V2\Client\StorageControlClient;
use Google\Cloud\Storage\Control\V2\CreateManagedFolderRequest;
use Google\Cloud\Storage\Control\V2\ManagedFolder;

/**
 * Creates a new managed folder.
 *
 * @param string $formattedParent Name of the bucket this managed folder belongs to. Please see
 *                                {@see StorageControlClient::bucketName()} for help formatting this field.
 * @param string $managedFolderId The name of the managed folder. It uses a single `/` as delimiter
 *                                and leading and trailing `/` are allowed.
 */
function create_managed_folder_sample(string $formattedParent, string $managedFolderId): void
{
    // Create a client.
    $storageControlClient = new StorageControlClient();

    // Prepare the request message.
    $managedFolder = new ManagedFolder();
    $request = (new CreateManagedFolderRequest())
        ->setParent($formattedParent)
        ->setManagedFolder($managedFolder)
        ->setManagedFolderId($managedFolderId);

    // Call the API and handle any network failures.
    try {
        /** @var ManagedFolder $response */
        $response = $storageControlClient->createManagedFolder($request);
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
    $managedFolderId = '[MANAGED_FOLDER_ID]';

    create_managed_folder_sample($formattedParent, $managedFolderId);
}
// [END storage_v2_generated_StorageControl_CreateManagedFolder_sync]
