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

// [START storage_v2_generated_StorageControl_DeleteManagedFolder_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Storage\Control\V2\Client\StorageControlClient;
use Google\Cloud\Storage\Control\V2\DeleteManagedFolderRequest;

/**
 * Permanently deletes an empty managed folder.
 *
 * @param string $formattedName Name of the managed folder.
 *                              Format:
 *                              `projects/{project}/buckets/{bucket}/managedFolders/{managedFolder}`
 *                              Please see {@see StorageControlClient::managedFolderName()} for help formatting this field.
 */
function delete_managed_folder_sample(string $formattedName): void
{
    // Create a client.
    $storageControlClient = new StorageControlClient();

    // Prepare the request message.
    $request = (new DeleteManagedFolderRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $storageControlClient->deleteManagedFolder($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = StorageControlClient::managedFolderName(
        '[PROJECT]',
        '[BUCKET]',
        '[MANAGEDFOLDER]'
    );

    delete_managed_folder_sample($formattedName);
}
// [END storage_v2_generated_StorageControl_DeleteManagedFolder_sync]
