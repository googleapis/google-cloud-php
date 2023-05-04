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

// [START retail_v2_generated_ProductService_UpdateProduct_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Retail\V2\Product;
use Google\Cloud\Retail\V2\ProductServiceClient;

/**
 * Updates a [Product][google.cloud.retail.v2.Product].
 *
 * @param string $productTitle Product title.
 *
 *                             This field must be a UTF-8 encoded string with a length limit of 1,000
 *                             characters. Otherwise, an INVALID_ARGUMENT error is returned.
 *
 *                             Corresponding properties: Google Merchant Center property
 *                             [title](https://support.google.com/merchants/answer/6324415). Schema.org
 *                             property [Product.name](https://schema.org/name).
 */
function update_product_sample(string $productTitle): void
{
    // Create a client.
    $productServiceClient = new ProductServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $product = (new Product())
        ->setTitle($productTitle);

    // Call the API and handle any network failures.
    try {
        /** @var Product $response */
        $response = $productServiceClient->updateProduct($product);
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
    $productTitle = '[TITLE]';

    update_product_sample($productTitle);
}
// [END retail_v2_generated_ProductService_UpdateProduct_sync]
