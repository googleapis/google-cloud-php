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

// [START retail_v2_generated_CatalogService_SetDefaultBranch_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Retail\V2\CatalogServiceClient;

/**
 * Set a specified branch id as default branch. API methods such as
 * [SearchService.Search][google.cloud.retail.v2.SearchService.Search],
 * [ProductService.GetProduct][google.cloud.retail.v2.ProductService.GetProduct],
 * [ProductService.ListProducts][google.cloud.retail.v2.ProductService.ListProducts]
 * will treat requests using "default_branch" to the actual branch id set as
 * default.
 *
 * For example, if `projects/&#42;/locations/&#42;/catalogs/&#42;/branches/1` is set as
 * default, setting
 * [SearchRequest.branch][google.cloud.retail.v2.SearchRequest.branch] to
 * `projects/&#42;/locations/&#42;/catalogs/&#42;/branches/default_branch` is equivalent
 * to setting
 * [SearchRequest.branch][google.cloud.retail.v2.SearchRequest.branch] to
 * `projects/&#42;/locations/&#42;/catalogs/&#42;/branches/1`.
 *
 * Using multiple branches can be useful when developers would like
 * to have a staging branch to test and verify for future usage. When it
 * becomes ready, developers switch on the staging branch using this API while
 * keeping using `projects/&#42;/locations/&#42;/catalogs/&#42;/branches/default_branch`
 * as [SearchRequest.branch][google.cloud.retail.v2.SearchRequest.branch] to
 * route the traffic to this staging branch.
 *
 * CAUTION: If you have live predict/search traffic, switching the default
 * branch could potentially cause outages if the ID space of the new branch is
 * very different from the old one.
 *
 * More specifically:
 *
 * * PredictionService will only return product IDs from branch {newBranch}.
 * * SearchService will only return product IDs from branch {newBranch}
 * (if branch is not explicitly set).
 * * UserEventService will only join events with products from branch
 * {newBranch}.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function set_default_branch_sample(): void
{
    // Create a client.
    $catalogServiceClient = new CatalogServiceClient();

    // Call the API and handle any network failures.
    try {
        $catalogServiceClient->setDefaultBranch();
        printf('Call completed successfully.' . PHP_EOL);
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END retail_v2_generated_CatalogService_SetDefaultBranch_sync]
