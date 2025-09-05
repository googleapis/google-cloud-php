<?php
/*
 * Copyright 2025 Google LLC
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

// [START vmmigration_v1_generated_VmMigration_FetchStorageInventory_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\VMMigration\V1\Client\VmMigrationClient;
use Google\Cloud\VMMigration\V1\FetchStorageInventoryRequest;
use Google\Cloud\VMMigration\V1\FetchStorageInventoryRequest\StorageType;
use Google\Cloud\VMMigration\V1\SourceStorageResource;

/**
 * List remote source's inventory of storage resources.
 * The remote source is another cloud vendor (e.g. AWS, Azure).
 * The inventory describes the list of existing storage resources in that
 * source. Note that this operation lists the resources on the remote source,
 * as opposed to listing the MigratingVms resources in the vmmigration
 * service.
 *
 * @param string $formattedSource The name of the Source. Please see
 *                                {@see VmMigrationClient::sourceName()} for help formatting this field.
 * @param int    $type            The type of the storage inventory to fetch.
 */
function fetch_storage_inventory_sample(string $formattedSource, int $type): void
{
    // Create a client.
    $vmMigrationClient = new VmMigrationClient();

    // Prepare the request message.
    $request = (new FetchStorageInventoryRequest())
        ->setSource($formattedSource)
        ->setType($type);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $vmMigrationClient->fetchStorageInventory($request);

        /** @var SourceStorageResource $element */
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
    $formattedSource = VmMigrationClient::sourceName('[PROJECT]', '[LOCATION]', '[SOURCE]');
    $type = StorageType::STORAGE_TYPE_UNSPECIFIED;

    fetch_storage_inventory_sample($formattedSource, $type);
}
// [END vmmigration_v1_generated_VmMigration_FetchStorageInventory_sync]
