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

// [START recommendationengine_v1beta1_generated_CatalogService_CreateCatalogItem_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\RecommendationEngine\V1beta1\CatalogItem;
use Google\Cloud\RecommendationEngine\V1beta1\CatalogItem\CategoryHierarchy;
use Google\Cloud\RecommendationEngine\V1beta1\CatalogServiceClient;

/**
 * Creates a catalog item.
 *
 * @param string $formattedParent                                 The parent catalog resource name, such as
 *                                                                `projects/&#42;/locations/global/catalogs/default_catalog`. Please see
 *                                                                {@see CatalogServiceClient::catalogName()} for help formatting this field.
 * @param string $catalogItemId                                   Catalog item identifier. UTF-8 encoded string with a length limit
 *                                                                of 128 bytes.
 *
 *                                                                This id must be unique among all catalog items within the same catalog. It
 *                                                                should also be used when logging user events in order for the user events
 *                                                                to be joined with the Catalog.
 * @param string $catalogItemCategoryHierarchiesCategoriesElement Catalog item categories. Each category should be a UTF-8
 *                                                                encoded string with a length limit of 2 KiB.
 *
 *                                                                Note that the order in the list denotes the specificity (from least to
 *                                                                most specific).
 * @param string $catalogItemTitle                                Catalog item title. UTF-8 encoded string with a length limit of 1
 *                                                                KiB.
 */
function create_catalog_item_sample(
    string $formattedParent,
    string $catalogItemId,
    string $catalogItemCategoryHierarchiesCategoriesElement,
    string $catalogItemTitle
): void {
    // Create a client.
    $catalogServiceClient = new CatalogServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $catalogItemCategoryHierarchiesCategories = [$catalogItemCategoryHierarchiesCategoriesElement,];
    $categoryHierarchy = (new CategoryHierarchy())
        ->setCategories($catalogItemCategoryHierarchiesCategories);
    $catalogItemCategoryHierarchies = [$categoryHierarchy,];
    $catalogItem = (new CatalogItem())
        ->setId($catalogItemId)
        ->setCategoryHierarchies($catalogItemCategoryHierarchies)
        ->setTitle($catalogItemTitle);

    // Call the API and handle any network failures.
    try {
        /** @var CatalogItem $response */
        $response = $catalogServiceClient->createCatalogItem($formattedParent, $catalogItem);
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
    $formattedParent = CatalogServiceClient::catalogName('[PROJECT]', '[LOCATION]', '[CATALOG]');
    $catalogItemId = '[ID]';
    $catalogItemCategoryHierarchiesCategoriesElement = '[CATEGORIES]';
    $catalogItemTitle = '[TITLE]';

    create_catalog_item_sample(
        $formattedParent,
        $catalogItemId,
        $catalogItemCategoryHierarchiesCategoriesElement,
        $catalogItemTitle
    );
}
// [END recommendationengine_v1beta1_generated_CatalogService_CreateCatalogItem_sync]
