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

// [START retail_v2_generated_ProductService_CreateProduct_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Retail\V2\Product;
use Google\Cloud\Retail\V2\ProductServiceClient;

/**
 * Creates a [Product][google.cloud.retail.v2.Product].
 *
 * @param string $formattedParent The parent catalog resource name, such as
 *                                `projects/&#42;/locations/global/catalogs/default_catalog/branches/default_branch`. Please see
 *                                {@see ProductServiceClient::branchName()} for help formatting this field.
 * @param string $productTitle    Product title.
 *
 *                                This field must be a UTF-8 encoded string with a length limit of 1,000
 *                                characters. Otherwise, an INVALID_ARGUMENT error is returned.
 *
 *                                Corresponding properties: Google Merchant Center property
 *                                [title](https://support.google.com/merchants/answer/6324415). Schema.org
 *                                property [Product.name](https://schema.org/name).
 * @param string $productId       The ID to use for the [Product][google.cloud.retail.v2.Product],
 *                                which will become the final component of the
 *                                [Product.name][google.cloud.retail.v2.Product.name].
 *
 *                                If the caller does not have permission to create the
 *                                [Product][google.cloud.retail.v2.Product], regardless of whether or not it
 *                                exists, a PERMISSION_DENIED error is returned.
 *
 *                                This field must be unique among all
 *                                [Product][google.cloud.retail.v2.Product]s with the same
 *                                [parent][google.cloud.retail.v2.CreateProductRequest.parent]. Otherwise, an
 *                                ALREADY_EXISTS error is returned.
 *
 *                                This field must be a UTF-8 encoded string with a length limit of 128
 *                                characters. Otherwise, an INVALID_ARGUMENT error is returned.
 */
function create_product_sample(
    string $formattedParent,
    string $productTitle,
    string $productId
): void {
    // Create a client.
    $productServiceClient = new ProductServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $product = (new Product())
        ->setTitle($productTitle);

    // Call the API and handle any network failures.
    try {
        /** @var Product $response */
        $response = $productServiceClient->createProduct($formattedParent, $product, $productId);
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
    $formattedParent = ProductServiceClient::branchName(
        '[PROJECT]',
        '[LOCATION]',
        '[CATALOG]',
        '[BRANCH]'
    );
    $productTitle = '[TITLE]';
    $productId = '[PRODUCT_ID]';

    create_product_sample($formattedParent, $productTitle, $productId);
}
// [END retail_v2_generated_ProductService_CreateProduct_sync]
