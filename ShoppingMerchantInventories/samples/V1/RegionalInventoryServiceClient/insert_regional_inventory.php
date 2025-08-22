<?php
/*
 * Copyright 2025 Google LLC
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

// [START merchantapi_v1_generated_RegionalInventoryService_InsertRegionalInventory_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Inventories\V1\Client\RegionalInventoryServiceClient;
use Google\Shopping\Merchant\Inventories\V1\InsertRegionalInventoryRequest;
use Google\Shopping\Merchant\Inventories\V1\RegionalInventory;

/**
 * Inserts a `RegionalInventory` to a given product in your
 * merchant account.
 *
 * Replaces the full `RegionalInventory` resource if an entry with the same
 * [`region`][google.shopping.merchant.inventories.v1.RegionalInventory.region]
 * already exists for the product.
 *
 * It might take up to 30 minutes for the new or updated `RegionalInventory`
 * resource to appear in products.
 *
 * @param string $formattedParent         The account and product where this inventory will be inserted.
 *                                        Format: `accounts/{account}/products/{product}`
 *                                        Please see {@see RegionalInventoryServiceClient::productName()} for help formatting this field.
 * @param string $regionalInventoryRegion Immutable. ID of the region for this
 *                                        `RegionalInventory` resource. See the [Regional availability and
 *                                        pricing](https://support.google.com/merchants/answer/9698880) for more
 *                                        details.
 */
function insert_regional_inventory_sample(
    string $formattedParent,
    string $regionalInventoryRegion
): void {
    // Create a client.
    $regionalInventoryServiceClient = new RegionalInventoryServiceClient();

    // Prepare the request message.
    $regionalInventory = (new RegionalInventory())
        ->setRegion($regionalInventoryRegion);
    $request = (new InsertRegionalInventoryRequest())
        ->setParent($formattedParent)
        ->setRegionalInventory($regionalInventory);

    // Call the API and handle any network failures.
    try {
        /** @var RegionalInventory $response */
        $response = $regionalInventoryServiceClient->insertRegionalInventory($request);
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
    $formattedParent = RegionalInventoryServiceClient::productName('[ACCOUNT]', '[PRODUCT]');
    $regionalInventoryRegion = '[REGION]';

    insert_regional_inventory_sample($formattedParent, $regionalInventoryRegion);
}
// [END merchantapi_v1_generated_RegionalInventoryService_InsertRegionalInventory_sync]
