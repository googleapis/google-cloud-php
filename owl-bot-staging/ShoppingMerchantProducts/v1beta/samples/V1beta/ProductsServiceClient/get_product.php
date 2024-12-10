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

// [START merchantapi_v1beta_generated_ProductsService_GetProduct_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Products\V1beta\Client\ProductsServiceClient;
use Google\Shopping\Merchant\Products\V1beta\GetProductRequest;
use Google\Shopping\Merchant\Products\V1beta\Product;

/**
 * Retrieves the processed product from your Merchant Center account.
 *
 * After inserting, updating, or deleting a product input, it may take several
 * minutes before the updated final product can be retrieved.
 *
 * @param string $formattedName The name of the product to retrieve.
 *                              Format: `accounts/{account}/products/{product}`
 *                              where the last section `product` consists of 4 parts:
 *                              channel~content_language~feed_label~offer_id
 *                              example for product name is
 *                              "accounts/123/products/online~en~US~sku123"
 *                              Please see {@see ProductsServiceClient::productName()} for help formatting this field.
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
// [END merchantapi_v1beta_generated_ProductsService_GetProduct_sync]
