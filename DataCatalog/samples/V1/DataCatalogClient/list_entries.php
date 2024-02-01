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

// [START datacatalog_v1_generated_DataCatalog_ListEntries_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\DataCatalog\V1\Client\DataCatalogClient;
use Google\Cloud\DataCatalog\V1\Entry;
use Google\Cloud\DataCatalog\V1\ListEntriesRequest;

/**
 * Lists entries.
 *
 * Note: Currently, this method can list only custom entries.
 * To get a list of both custom and automatically created entries, use
 * [SearchCatalog][google.cloud.datacatalog.v1.DataCatalog.SearchCatalog].
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function list_entries_sample(): void
{
    // Create a client.
    $dataCatalogClient = new DataCatalogClient();

    // Prepare the request message.
    $request = new ListEntriesRequest();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $dataCatalogClient->listEntries($request);

        /** @var Entry $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END datacatalog_v1_generated_DataCatalog_ListEntries_sync]
