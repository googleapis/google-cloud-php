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

// [START vision_v1_generated_ProductSearch_UpdateProductSet_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Vision\V1\ProductSearchClient;
use Google\Cloud\Vision\V1\ProductSet;

/**
 * Makes changes to a ProductSet resource.
 * Only display_name can be updated currently.
 *
 * Possible errors:
 *
 * * Returns NOT_FOUND if the ProductSet does not exist.
 * * Returns INVALID_ARGUMENT if display_name is present in update_mask but
 * missing from the request or longer than 4096 characters.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_product_set_sample(): void
{
    // Create a client.
    $productSearchClient = new ProductSearchClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $productSet = new ProductSet();

    // Call the API and handle any network failures.
    try {
        /** @var ProductSet $response */
        $response = $productSearchClient->updateProductSet($productSet);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END vision_v1_generated_ProductSearch_UpdateProductSet_sync]
