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

// [START datacatalog_v1_generated_DataCatalog_SearchCatalog_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\DataCatalog\V1\DataCatalogClient;
use Google\Cloud\DataCatalog\V1\SearchCatalogRequest\Scope;
use Google\Cloud\DataCatalog\V1\SearchCatalogResult;

/**
 * Searches Data Catalog for multiple resources like entries and tags that
 * match a query.
 *
 * This is a [Custom Method]
 * (https://cloud.google.com/apis/design/custom_methods) that doesn't return
 * all information on a resource, only its ID and high level fields. To get
 * more information, you can subsequently call specific get methods.
 *
 * Note: Data Catalog search queries don't guarantee full recall. Results
 * that match your query might not be returned, even in subsequent
 * result pages. Additionally, returned (and not returned) results can vary
 * if you repeat search queries.
 *
 * For more information, see [Data Catalog search syntax]
 * (https://cloud.google.com/data-catalog/docs/how-to/search-reference).
 *
 * @param string $query Optional. The query string with a minimum of 3 characters and specific syntax.
 *                      For more information, see
 *                      [Data Catalog search
 *                      syntax](https://cloud.google.com/data-catalog/docs/how-to/search-reference).
 *
 *                      An empty query string returns all data assets (in the specified scope)
 *                      that you have access to.
 *
 *                      A query string can be a simple `xyz` or qualified by predicates:
 *
 *                      * `name:x`
 *                      * `column:y`
 *                      * `description:z`
 */
function search_catalog_sample(string $query): void
{
    // Create a client.
    $dataCatalogClient = new DataCatalogClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $scope = new Scope();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $dataCatalogClient->searchCatalog($scope, $query);

        /** @var SearchCatalogResult $element */
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
    $query = '[QUERY]';

    search_catalog_sample($query);
}
// [END datacatalog_v1_generated_DataCatalog_SearchCatalog_sync]
