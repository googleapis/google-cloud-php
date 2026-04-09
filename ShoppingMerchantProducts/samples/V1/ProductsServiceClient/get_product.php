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

// [START merchantapi_v1_generated_ProductsService_GetProduct_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Products\V1\Client\ProductsServiceClient;
use Google\Shopping\Merchant\Products\V1\GetProductRequest;
use Google\Shopping\Merchant\Products\V1\Product;

/**
 * Retrieves the processed product from your Merchant Center account.
 *
 * After inserting, updating, or deleting a product input, it may take several
 * minutes before the updated final product can be retrieved.
 *
 * @param string $formattedName The name of the product.
 *                              Format: `accounts/{account}/products/{product}`
 *
 *                              The `{product}` segment is a unique identifier for the product.
 *                              This identifier must be unique within a merchant account and generally
 *                              follows the structure: `content_language~feed_label~offer_id`. Example:
 *                              `en~US~sku123` For legacy local products, the structure is:
 *                              `local~content_language~feed_label~offer_id`. Example: `local~en~US~sku123`
 *
 *                              The format of the `{product}` segment in the URL is automatically detected
 *                              by the server, supporting two options:
 *
 *                              1.  **Encoded Format**: The `{product}` segment is an unpadded base64url
 *                              encoded string (RFC 4648 Section 5). The decoded string must result
 *                              in the `content_language~feed_label~offer_id` structure. This encoding
 *                              MUST be used if any part of the product identifier (like `offer_id`)
 *                              contains characters such as `/`, `%`, or `~`.
 *                              *   Example: To represent the product ID `en~US~sku/123`, the
 *                              `{product}` segment must be the unpadded base64url encoding of this
 *                              string, which is `ZW5-VVN-c2t1LzEyMw`. The full resource name
 *                              for the product would be
 *                              `accounts/123/products/ZW5-VVN-c2t1LzEyMw`.
 *
 *                              2.  **Plain Format**: The `{product}` segment is the tilde-separated string
 *                              `content_language~feed_label~offer_id`. This format is suitable only
 *                              when `content_language`, `feed_label`, and `offer_id` do not contain
 *                              URL-problematic characters like `/`, `%`, or `~`.
 *
 *                              We recommend using the **Encoded Format** for all product IDs to ensure
 *                              correct parsing, especially those containing special characters. The
 *                              presence of tilde (`~`) characters in the `{product}` segment is used to
 *                              differentiate between the two formats.
 *
 *                              Note: For calls to the v1beta version, the plain format is
 *                              `channel~content_language~feed_label~offer_id`, for example:
 *                              `accounts/123/products/online~en~US~sku123`. Please see
 *                              {@see ProductsServiceClient::productName()} for help formatting this field.
 */
function get_product_sample(string $formattedName): void
{
    // Create a client.
    $productsServiceClient = new ProductsServiceClient();

    // Prepare the request message.
    $request = (new GetProductRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Product $response */
        $response = $productsServiceClient->getProduct($request);
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
    $formattedName = ProductsServiceClient::productName('[ACCOUNT]', '[PRODUCT]');

    get_product_sample($formattedName);
}
// [END merchantapi_v1_generated_ProductsService_GetProduct_sync]
