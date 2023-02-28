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

// [START retail_v2_generated_SearchService_Search_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Retail\V2\SearchResponse\SearchResult;
use Google\Cloud\Retail\V2\SearchServiceClient;

/**
 * Performs a search.
 *
 * This feature is only available for users who have Retail Search enabled.
 * Please enable Retail Search on Cloud Console before using this feature.
 *
 * @param string $placement The resource name of the Retail Search serving config, such as
 *                          `projects/&#42;/locations/global/catalogs/default_catalog/servingConfigs/default_serving_config`
 *                          or the name of the legacy placement resource, such as
 *                          `projects/&#42;/locations/global/catalogs/default_catalog/placements/default_search`.
 *                          This field is used to identify the serving configuration name and the set
 *                          of models that will be used to make the search.
 * @param string $visitorId A unique identifier for tracking visitors. For example, this
 *                          could be implemented with an HTTP cookie, which should be able to uniquely
 *                          identify a visitor on a single device. This unique identifier should not
 *                          change if the visitor logs in or out of the website.
 *
 *                          This should be the same identifier as
 *                          [UserEvent.visitor_id][google.cloud.retail.v2.UserEvent.visitor_id].
 *
 *                          The field must be a UTF-8 encoded string with a length limit of 128
 *                          characters. Otherwise, an INVALID_ARGUMENT error is returned.
 */
function search_sample(string $placement, string $visitorId): void
{
    // Create a client.
    $searchServiceClient = new SearchServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $searchServiceClient->search($placement, $visitorId);

        /** @var SearchResult $element */
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
    $placement = '[PLACEMENT]';
    $visitorId = '[VISITOR_ID]';

    search_sample($placement, $visitorId);
}
// [END retail_v2_generated_SearchService_Search_sync]
