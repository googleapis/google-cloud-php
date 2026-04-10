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

// [START merchantapi_v1_generated_LocalInventoryService_InsertLocalInventory_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Inventories\V1\Client\LocalInventoryServiceClient;
use Google\Shopping\Merchant\Inventories\V1\InsertLocalInventoryRequest;
use Google\Shopping\Merchant\Inventories\V1\LocalInventory;

/**
 * Inserts a `LocalInventory` resource to a product in your merchant
 * account.
 *
 * Replaces the full `LocalInventory` resource if an entry with the same
 * [`storeCode`][google.shopping.merchant.inventories.v1.LocalInventory.store_code]
 * already exists for the product.
 *
 * It might take up to 30 minutes for the new or updated `LocalInventory`
 * resource to appear in products.
 *
 * @param string $formattedParent         The account and product where this inventory will be inserted.
 *                                        Format: `accounts/{account}/products/{product}`
 *
 *                                        The `{product}` segment is a unique identifier for the product.
 *                                        This identifier must be unique within a merchant account and generally
 *                                        follows the structure: `content_language~feed_label~offer_id`. Example:
 *                                        `en~US~sku123` For legacy local products, the structure is:
 *                                        `local~content_language~feed_label~offer_id`. Example: `local~en~US~sku123`
 *
 *                                        The format of the `{product}` segment in the URL is automatically detected
 *                                        by the server, supporting two options:
 *
 *                                        1.  **Encoded Format**: The `{product}` segment is an unpadded base64url
 *                                        encoded string (RFC 4648 Section 5). The decoded string must result
 *                                        in the `content_language~feed_label~offer_id` structure. This encoding
 *                                        MUST be used if any part of the product identifier (like `offer_id`)
 *                                        contains characters such as `/`, `%`, or `~`.
 *                                        *   Example: To represent the product ID `en~US~sku/123`, the
 *                                        `{product}` segment must be the unpadded base64url encoding of this
 *                                        string, which is `ZW5-VVN-c2t1LzEyMw`. The full resource name
 *                                        for the product would be
 *                                        `accounts/123/products/ZW5-VVN-c2t1LzEyMw`.
 *
 *                                        2.  **Plain Format**: The `{product}` segment is the tilde-separated string
 *                                        `content_language~feed_label~offer_id`. This format is suitable only
 *                                        when `content_language`, `feed_label`, and `offer_id` do not contain
 *                                        URL-problematic characters like `/`, `%`, or `~`.
 *
 *                                        We recommend using the **Encoded Format** for all product IDs to ensure
 *                                        correct parsing, especially those containing special characters. The
 *                                        presence of tilde (`~`) characters in the `{product}` segment is used to
 *                                        differentiate between the two formats. Please see
 *                                        {@see LocalInventoryServiceClient::productName()} for help formatting this field.
 * @param string $localInventoryStoreCode Immutable. Store code (the store ID from your Business Profile)
 *                                        of the physical store the product is sold in. See the [Local product
 *                                        inventory data
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
// [END merchantapi_v1_generated_LocalInventoryService_InsertLocalInventory_sync]
