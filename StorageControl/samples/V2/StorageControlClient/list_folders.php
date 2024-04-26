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

// [START storage_v2_generated_StorageControl_ListFolders_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Storage\Control\V2\Client\StorageControlClient;
use Google\Cloud\Storage\Control\V2\Folder;
use Google\Cloud\Storage\Control\V2\ListFoldersRequest;

/**
 * Retrieves a list of folders. This operation is only applicable to a
 * hierarchical namespace enabled bucket.
 * Hierarchical namespace buckets are in allowlist preview.
 *
 * @param string $formattedParent Name of the bucket in which to look for folders. The bucket must
 *                                be a hierarchical namespace enabled bucket. Please see
 *                                {@see StorageControlClient::bucketName()} for help formatting this field.
 */
function list_folders_sample(string $formattedParent): void
{
    // Create a client.
    $storageControlClient = new StorageControlClient();

    // Prepare the request message.
    $request = (new ListFoldersRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $storageControlClient->listFolders($request);

        /** @var Folder $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedParent = StorageControlClient::bucketName('[PROJECT]', '[BUCKET]');

    list_folders_sample($formattedParent);
}
// [END storage_v2_generated_StorageControl_ListFolders_sync]
