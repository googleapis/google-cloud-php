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

// [START vision_v1_generated_ProductSearch_UpdateProduct_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Vision\V1\Product;
use Google\Cloud\Vision\V1\ProductSearchClient;

/**
 * Makes changes to a Product resource.
 * Only the `display_name`, `description`, and `labels` fields can be updated
 * right now.
 *
 * If labels are updated, the change will not be reflected in queries until
 * the next index time.
 *
 * Possible errors:
 *
 * * Returns NOT_FOUND if the Product does not exist.
 * * Returns INVALID_ARGUMENT if display_name is present in update_mask but is
 * missing from the request or longer than 4096 characters.
 * * Returns INVALID_ARGUMENT if description is present in update_mask but is
 * longer than 4096 characters.
 * * Returns INVALID_ARGUMENT if product_category is present in update_mask.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_product_sample(): void
{
    // Create a client.
    $productSearchClient = new ProductSearchClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $product = new Product();

    // Call the API and handle any network failures.
    try {
        /** @var Product $response */
        $response = $productSearchClient->updateProduct($product);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END vision_v1_generated_ProductSearch_UpdateProduct_sync]
