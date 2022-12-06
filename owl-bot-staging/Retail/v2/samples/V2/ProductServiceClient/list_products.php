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

// [START retail_v2_generated_ProductService_ListProducts_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Retail\V2\Product;
use Google\Cloud\Retail\V2\ProductServiceClient;

/**
 * Gets a list of [Product][google.cloud.retail.v2.Product]s.
 *
 * @param string $formattedParent The parent branch resource name, such as
 *                                `projects/&#42;/locations/global/catalogs/default_catalog/branches/0`. Use
 *                                `default_branch` as the branch ID, to list products under the default
 *                                branch.
 *
 *                                If the caller does not have permission to list
 *                                [Product][google.cloud.retail.v2.Product]s under this branch, regardless of
 *                                whether or not this branch exists, a PERMISSION_DENIED error is returned. Please see
 *                                {@see ProductServiceClient::branchName()} for help formatting this field.
 */
function list_products_sample(string $formattedParent): void
{
    // Create a client.
    $productServiceClient = new ProductServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $productServiceClient->listProducts($formattedParent);

        /** @var Product $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedParent = ProductServiceClient::branchName(
        '[PROJECT]',
        '[LOCATION]',
        '[CATALOG]',
        '[BRANCH]'
    );

    list_products_sample($formattedParent);
}
// [END retail_v2_generated_ProductService_ListProducts_sync]
