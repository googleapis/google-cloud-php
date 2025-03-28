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

// [START dataplex_v1_generated_CatalogService_CreateEntry_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataplex\V1\Client\CatalogServiceClient;
use Google\Cloud\Dataplex\V1\CreateEntryRequest;
use Google\Cloud\Dataplex\V1\Entry;

/**
 * Creates an Entry.
 *
 * @param string $formattedParent The resource name of the parent Entry Group:
 *                                `projects/{project}/locations/{location}/entryGroups/{entry_group}`. Please see
 *                                {@see CatalogServiceClient::entryGroupName()} for help formatting this field.
 * @param string $entryId         Entry identifier. It has to be unique within an Entry Group.
 *
 *                                Entries corresponding to Google Cloud resources use an Entry ID format
 *                                based on [full resource
 *                                names](https://cloud.google.com/apis/design/resource_names#full_resource_name).
 *                                The format is a full resource name of the resource without the
 *                                prefix double slashes in the API service name part of the full resource
 *                                name. This allows retrieval of entries using their associated resource
 *                                name.
 *
 *                                For example, if the full resource name of a resource is
 *                                `//library.googleapis.com/shelves/shelf1/books/book2`,
 *                                then the suggested entry_id is
 *                                `library.googleapis.com/shelves/shelf1/books/book2`.
 *
 *                                It is also suggested to follow the same convention for entries
 *                                corresponding to resources from providers or systems other than Google
 *                                Cloud.
 *
 *                                The maximum size of the field is 4000 characters.
 * @param string $entryEntryType  Immutable. The relative resource name of the entry type that was
 *                                used to create this entry, in the format
 *                                `projects/{project_id_or_number}/locations/{location_id}/entryTypes/{entry_type_id}`.
 */
function create_entry_sample(
    string $formattedParent,
    string $entryId,
    string $entryEntryType
): void {
    // Create a client.
    $catalogServiceClient = new CatalogServiceClient();

    // Prepare the request message.
    $entry = (new Entry())
        ->setEntryType($entryEntryType);
    $request = (new CreateEntryRequest())
        ->setParent($formattedParent)
        ->setEntryId($entryId)
        ->setEntry($entry);

    // Call the API and handle any network failures.
    try {
        /** @var Entry $response */
        $response = $catalogServiceClient->createEntry($request);
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
    $formattedParent = CatalogServiceClient::entryGroupName('[PROJECT]', '[LOCATION]', '[ENTRY_GROUP]');
    $entryId = '[ENTRY_ID]';
    $entryEntryType = '[ENTRY_TYPE]';

    create_entry_sample($formattedParent, $entryId, $entryEntryType);
}
// [END dataplex_v1_generated_CatalogService_CreateEntry_sync]
