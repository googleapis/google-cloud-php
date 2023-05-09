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

// [START merchantapi_v1beta_generated_RegionalInventoryService_InsertRegionalInventory_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Inventories\V1beta\RegionalInventory;
use Google\Shopping\Merchant\Inventories\V1beta\RegionalInventoryServiceClient;

/**
 * Inserts a `RegionalInventory` to a given product in your
 * merchant account.
 *
 * Replaces the full `RegionalInventory` resource if an entry with the same
 * [`region`][google.shopping.merchant.inventories.v1beta.RegionalInventory.region]
 * already exists for the product.
 *
 * It might take up to 30 minutes for the new or updated `RegionalInventory`
 * resource to appear in products.
 *
 * @param string $parent                  The account and product where this inventory will be inserted.
 *                                        Format: `accounts/{account}/products/{product}`
 * @param string $regionalInventoryRegion ID of the region for this
 *                                        `RegionalInventory` resource. See the [Regional availability and
 *                                        pricing](https://support.google.com/merchants/answer/9698880) for more
 *                                        details.
 */
function insert_regional_inventory_sample(string $parent, string $regionalInventoryRegion): void
{
    // Create a client.
    $regionalInventoryServiceClient = new RegionalInventoryServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $regionalInventory = (new RegionalInventory())
        ->setRegion($regionalInventoryRegion);

    // Call the API and handle any network failures.
    try {
        /** @var RegionalInventory $response */
        $response = $regionalInventoryServiceClient->insertRegionalInventory($parent, $regionalInventory);
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
    $parent = '[PARENT]';
    $regionalInventoryRegion = '[REGION]';

    insert_regional_inventory_sample($parent, $regionalInventoryRegion);
}
// [END merchantapi_v1beta_generated_RegionalInventoryService_InsertRegionalInventory_sync]
