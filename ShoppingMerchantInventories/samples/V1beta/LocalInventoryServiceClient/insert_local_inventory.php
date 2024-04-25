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

// [START merchantapi_v1beta_generated_LocalInventoryService_InsertLocalInventory_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Inventories\V1beta\Client\LocalInventoryServiceClient;
use Google\Shopping\Merchant\Inventories\V1beta\InsertLocalInventoryRequest;
use Google\Shopping\Merchant\Inventories\V1beta\LocalInventory;

/**
 * Inserts a `LocalInventory` resource to a product in your merchant
 * account.
 *
 * Replaces the full `LocalInventory` resource if an entry with the same
 * [`storeCode`][google.shopping.merchant.inventories.v1beta.LocalInventory.store_code]
 * already exists for the product.
 *
 * It might take up to 30 minutes for the new or updated `LocalInventory`
 * resource to appear in products.
 *
 * @param string $formattedParent         The account and product where this inventory will be inserted.
 *                                        Format: `accounts/{account}/products/{product}`
 *                                        Please see {@see LocalInventoryServiceClient::productName()} for help formatting this field.
 * @param string $localInventoryStoreCode Immutable. Store code (the store ID from your Business Profile)
 *                                        of the physical store the product is sold in. See the [Local product
 *                                        inventory feed
 *                                        specification](https://support.google.com/merchants/answer/3061342) for
 *                                        more information.
 */
function insert_local_inventory_sample(
    string $formattedParent,
    string $localInventoryStoreCode
): void {
    // Create a client.
    $localInventoryServiceClient = new LocalInventoryServiceClient();

    // Prepare the request message.
    $localInventory = (new LocalInventory())
        ->setStoreCode($localInventoryStoreCode);
    $request = (new InsertLocalInventoryRequest())
        ->setParent($formattedParent)
        ->setLocalInventory($localInventory);

    // Call the API and handle any network failures.
    try {
        /** @var LocalInventory $response */
        $response = $localInventoryServiceClient->insertLocalInventory($request);
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
    $formattedParent = LocalInventoryServiceClient::productName('[ACCOUNT]', '[PRODUCT]');
    $localInventoryStoreCode = '[STORE_CODE]';

    insert_local_inventory_sample($formattedParent, $localInventoryStoreCode);
}
// [END merchantapi_v1beta_generated_LocalInventoryService_InsertLocalInventory_sync]
