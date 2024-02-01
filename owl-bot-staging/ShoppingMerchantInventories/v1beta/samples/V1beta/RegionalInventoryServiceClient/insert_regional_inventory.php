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

// [START merchantapi_v1beta_generated_RegionalInventoryService_InsertRegionalInventory_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Inventories\V1beta\Client\RegionalInventoryServiceClient;
use Google\Shopping\Merchant\Inventories\V1beta\InsertRegionalInventoryRequest;
use Google\Shopping\Merchant\Inventories\V1beta\RegionalInventory;

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
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function insert_regional_inventory_sample(): void
{
    // Create a client.
    $regionalInventoryServiceClient = new RegionalInventoryServiceClient();

    // Prepare the request message.
    $request = new InsertRegionalInventoryRequest();

    // Call the API and handle any network failures.
    try {
        /** @var RegionalInventory $response */
        $response = $regionalInventoryServiceClient->insertRegionalInventory($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END merchantapi_v1beta_generated_RegionalInventoryService_InsertRegionalInventory_sync]
