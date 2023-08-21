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

// [START recommendationengine_v1beta1_generated_CatalogService_GetCatalogItem_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\RecommendationEngine\V1beta1\CatalogItem;
use Google\Cloud\RecommendationEngine\V1beta1\Client\CatalogServiceClient;
use Google\Cloud\RecommendationEngine\V1beta1\GetCatalogItemRequest;

/**
 * Gets a specific catalog item.
 *
 * @param string $formattedName Full resource name of catalog item, such as
 *                              `projects/&#42;/locations/global/catalogs/default_catalog/catalogitems/some_catalog_item_id`. Please see
 *                              {@see CatalogServiceClient::catalogItemPathName()} for help formatting this field.
 */
function get_catalog_item_sample(string $formattedName): void
{
    // Create a client.
    $catalogServiceClient = new CatalogServiceClient();

    // Prepare the request message.
    $request = (new GetCatalogItemRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var CatalogItem $response */
        $response = $catalogServiceClient->getCatalogItem($request);
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
    $formattedName = CatalogServiceClient::catalogItemPathName(
        '[PROJECT]',
        '[LOCATION]',
        '[CATALOG]',
        '[CATALOG_ITEM_PATH]'
    );

    get_catalog_item_sample($formattedName);
}
// [END recommendationengine_v1beta1_generated_CatalogService_GetCatalogItem_sync]
