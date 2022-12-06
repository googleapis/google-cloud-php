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

// [START datacatalog_v1_generated_DataCatalog_CreateEntry_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DataCatalog\V1\DataCatalogClient;
use Google\Cloud\DataCatalog\V1\Entry;

/**
 * Creates an entry.
 *
 * You can create entries only with 'FILESET', 'CLUSTER', 'DATA_STREAM',
 * or custom types. Data Catalog automatically creates entries with other
 * types during metadata ingestion from integrated systems.
 *
 * You must enable the Data Catalog API in the project identified by
 * the `parent` parameter. For more information, see [Data Catalog resource
 * project](https://cloud.google.com/data-catalog/docs/concepts/resource-project).
 *
 * An entry group can have a maximum of 100,000 entries.
 *
 * @param string $formattedParent The name of the entry group this entry belongs to.
 *
 *                                Note: The entry itself and its child resources might not be stored in
 *                                the location specified in its name. Please see
 *                                {@see DataCatalogClient::entryGroupName()} for help formatting this field.
 * @param string $entryId         The ID of the entry to create.
 *
 *                                The ID must contain only letters (a-z, A-Z), numbers (0-9),
 *                                and underscores (_).
 *                                The maximum size is 64 bytes when encoded in UTF-8.
 */
function create_entry_sample(string $formattedParent, string $entryId): void
{
    // Create a client.
    $dataCatalogClient = new DataCatalogClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $entry = new Entry();

    // Call the API and handle any network failures.
    try {
        /** @var Entry $response */
        $response = $dataCatalogClient->createEntry($formattedParent, $entryId, $entry);
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
    $formattedParent = DataCatalogClient::entryGroupName('[PROJECT]', '[LOCATION]', '[ENTRY_GROUP]');
    $entryId = '[ENTRY_ID]';

    create_entry_sample($formattedParent, $entryId);
}
// [END datacatalog_v1_generated_DataCatalog_CreateEntry_sync]
