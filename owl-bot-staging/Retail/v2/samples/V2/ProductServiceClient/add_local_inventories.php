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

// [START retail_v2_generated_ProductService_AddLocalInventories_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Retail\V2\AddLocalInventoriesResponse;
use Google\Cloud\Retail\V2\LocalInventory;
use Google\Cloud\Retail\V2\ProductServiceClient;
use Google\Rpc\Status;

/**
 * Updates local inventory information for a
 * [Product][google.cloud.retail.v2.Product] at a list of places, while
 * respecting the last update timestamps of each inventory field.
 *
 * This process is asynchronous and does not require the
 * [Product][google.cloud.retail.v2.Product] to exist before updating
 * inventory information. If the request is valid, the update will be enqueued
 * and processed downstream. As a consequence, when a response is returned,
 * updates are not immediately manifested in the
 * [Product][google.cloud.retail.v2.Product] queried by
 * [ProductService.GetProduct][google.cloud.retail.v2.ProductService.GetProduct]
 * or
 * [ProductService.ListProducts][google.cloud.retail.v2.ProductService.ListProducts].
 *
 * Local inventory information can only be modified using this method.
 * [ProductService.CreateProduct][google.cloud.retail.v2.ProductService.CreateProduct]
 * and
 * [ProductService.UpdateProduct][google.cloud.retail.v2.ProductService.UpdateProduct]
 * has no effect on local inventories.
 *
 * The returned [Operation][]s will be obsolete after 1 day, and
 * [GetOperation][] API will return NOT_FOUND afterwards.
 *
 * If conflicting updates are issued, the [Operation][]s associated with the
 * stale updates will not be marked as [done][Operation.done] until being
 * obsolete.
 *
 * This feature is only available for users who have Retail Search enabled.
 * Please enable Retail Search on Cloud Console before using this feature.
 *
 * @param string $formattedProduct Full resource name of [Product][google.cloud.retail.v2.Product],
 *                                 such as
 *                                 `projects/&#42;/locations/global/catalogs/default_catalog/branches/default_branch/products/some_product_id`.
 *
 *                                 If the caller does not have permission to access the
 *                                 [Product][google.cloud.retail.v2.Product], regardless of whether or not it
 *                                 exists, a PERMISSION_DENIED error is returned. Please see
 *                                 {@see ProductServiceClient::productName()} for help formatting this field.
 */
function add_local_inventories_sample(string $formattedProduct): void
{
    // Create a client.
    $productServiceClient = new ProductServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $localInventories = [new LocalInventory()];

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $productServiceClient->addLocalInventories($formattedProduct, $localInventories);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AddLocalInventoriesResponse $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
        }
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
    $formattedProduct = ProductServiceClient::productName(
        '[PROJECT]',
        '[LOCATION]',
        '[CATALOG]',
        '[BRANCH]',
        '[PRODUCT]'
    );

    add_local_inventories_sample($formattedProduct);
}
// [END retail_v2_generated_ProductService_AddLocalInventories_sync]
