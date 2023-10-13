<?php
/*
 * Copyright 2023 Google LLC
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

// [START merchantapi_v1beta_generated_ReportService_Search_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Shopping\Merchant\Reports\V1beta\Client\ReportServiceClient;
use Google\Shopping\Merchant\Reports\V1beta\ReportRow;
use Google\Shopping\Merchant\Reports\V1beta\SearchRequest;

/**
 * Retrieves a report defined by a search query. The response might contain
 * fewer rows than specified by `page_size`. Rely on `next_page_token` to
 * determine if there are more rows to be requested.
 *
 * @param string $parent Id of the account making the call. Must be a standalone account
 *                       or an MCA subaccount. Format: accounts/{account}
 * @param string $query  Query that defines a report to be retrieved.
 *
 *                       For details on how to construct your query, see the Query Language
 *                       guide. For the full list of available tables and fields, see the Available
 *                       fields.
 */
function search_sample(string $parent, string $query): void
{
    // Create a client.
    $reportServiceClient = new ReportServiceClient();

    // Prepare the request message.
    $request = (new SearchRequest())
        ->setParent($parent)
        ->setQuery($query);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $reportServiceClient->search($request);

        /** @var ReportRow $element */
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
    $parent = '[PARENT]';
    $query = '[QUERY]';

    search_sample($parent, $query);
}
// [END merchantapi_v1beta_generated_ReportService_Search_sync]
