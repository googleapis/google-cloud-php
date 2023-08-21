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

// [START retail_v2_generated_CatalogService_UpdateCatalog_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Retail\V2\Catalog;
use Google\Cloud\Retail\V2\CatalogServiceClient;
use Google\Cloud\Retail\V2\ProductLevelConfig;

/**
 * Updates the [Catalog][google.cloud.retail.v2.Catalog]s.
 *
 * @param string $catalogName        Immutable. The fully qualified resource name of the catalog.
 * @param string $catalogDisplayName Immutable. The catalog display name.
 *
 *                                   This field must be a UTF-8 encoded string with a length limit of 128
 *                                   characters. Otherwise, an INVALID_ARGUMENT error is returned.
 */
function update_catalog_sample(string $catalogName, string $catalogDisplayName): void
{
    // Create a client.
    $catalogServiceClient = new CatalogServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $catalogProductLevelConfig = new ProductLevelConfig();
    $catalog = (new Catalog())
        ->setName($catalogName)
        ->setDisplayName($catalogDisplayName)
        ->setProductLevelConfig($catalogProductLevelConfig);

    // Call the API and handle any network failures.
    try {
        /** @var Catalog $response */
        $response = $catalogServiceClient->updateCatalog($catalog);
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
    $catalogName = '[NAME]';
    $catalogDisplayName = '[DISPLAY_NAME]';

    update_catalog_sample($catalogName, $catalogDisplayName);
}
// [END retail_v2_generated_CatalogService_UpdateCatalog_sync]
