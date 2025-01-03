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

// [START dataplex_v1_generated_CatalogService_SearchEntries_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Dataplex\V1\Client\CatalogServiceClient;
use Google\Cloud\Dataplex\V1\SearchEntriesRequest;
use Google\Cloud\Dataplex\V1\SearchEntriesResult;

/**
 * Searches for Entries matching the given query and scope.
 *
 * @param string $formattedName The project to which the request should be attributed in the
 *                              following form: `projects/{project}/locations/{location}`. Please see
 *                              {@see CatalogServiceClient::locationName()} for help formatting this field.
 * @param string $query         The query against which entries in scope should be matched.
 *                              The query syntax is defined in [Search syntax for Dataplex
 *                              Catalog](https://cloud.google.com/dataplex/docs/search-syntax).
 */
function search_entries_sample(string $formattedName, string $query): void
{
    // Create a client.
    $catalogServiceClient = new CatalogServiceClient();

    // Prepare the request message.
    $request = (new SearchEntriesRequest())
        ->setName($formattedName)
        ->setQuery($query);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $catalogServiceClient->searchEntries($request);

        /** @var SearchEntriesResult $element */
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
    $formattedName = CatalogServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $query = '[QUERY]';

    search_entries_sample($formattedName, $query);
}
// [END dataplex_v1_generated_CatalogService_SearchEntries_sync]
