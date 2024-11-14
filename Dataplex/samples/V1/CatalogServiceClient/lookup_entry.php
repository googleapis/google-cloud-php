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

// [START dataplex_v1_generated_CatalogService_LookupEntry_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataplex\V1\Client\CatalogServiceClient;
use Google\Cloud\Dataplex\V1\Entry;
use Google\Cloud\Dataplex\V1\LookupEntryRequest;

/**
 * Looks up a single Entry by name using the permission on the source system.
 *
 * **Caution**: The BigQuery metadata that is stored in Dataplex Catalog is
 * changing. For more information, see [Changes to BigQuery metadata stored in
 * Dataplex
 * Catalog](https://cloud.google.com/dataplex/docs/biqquery-metadata-changes).
 *
 * @param string $name           The project to which the request should be attributed in the
 *                               following form: `projects/{project}/locations/{location}`.
 * @param string $formattedEntry The resource name of the Entry:
 *                               `projects/{project}/locations/{location}/entryGroups/{entry_group}/entries/{entry}`. Please see
 *                               {@see CatalogServiceClient::entryName()} for help formatting this field.
 */
function lookup_entry_sample(string $name, string $formattedEntry): void
{
    // Create a client.
    $catalogServiceClient = new CatalogServiceClient();

    // Prepare the request message.
    $request = (new LookupEntryRequest())
        ->setName($name)
        ->setEntry($formattedEntry);

    // Call the API and handle any network failures.
    try {
        /** @var Entry $response */
        $response = $catalogServiceClient->lookupEntry($request);
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
    $name = '[NAME]';
    $formattedEntry = CatalogServiceClient::entryName(
        '[PROJECT]',
        '[LOCATION]',
        '[ENTRY_GROUP]',
        '[ENTRY]'
    );

    lookup_entry_sample($name, $formattedEntry);
}
// [END dataplex_v1_generated_CatalogService_LookupEntry_sync]
