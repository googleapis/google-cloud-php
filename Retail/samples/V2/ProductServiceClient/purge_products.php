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

// [START retail_v2_generated_ProductService_PurgeProducts_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Retail\V2\Client\ProductServiceClient;
use Google\Cloud\Retail\V2\PurgeProductsRequest;
use Google\Cloud\Retail\V2\PurgeProductsResponse;
use Google\Rpc\Status;

/**
 * Permanently deletes all selected [Product][google.cloud.retail.v2.Product]s
 * under a branch.
 *
 * This process is asynchronous. If the request is valid, the removal will be
 * enqueued and processed offline. Depending on the number of
 * [Product][google.cloud.retail.v2.Product]s, this operation could take hours
 * to complete. Before the operation completes, some
 * [Product][google.cloud.retail.v2.Product]s may still be returned by
 * [ProductService.GetProduct][google.cloud.retail.v2.ProductService.GetProduct]
 * or
 * [ProductService.ListProducts][google.cloud.retail.v2.ProductService.ListProducts].
 *
 * Depending on the number of [Product][google.cloud.retail.v2.Product]s, this
 * operation could take hours to complete. To get a sample of
 * [Product][google.cloud.retail.v2.Product]s that would be deleted, set
 * [PurgeProductsRequest.force][google.cloud.retail.v2.PurgeProductsRequest.force]
 * to false.
 *
 * @param string $formattedParent The resource name of the branch under which the products are
 *                                created. The format is
 *                                `projects/${projectId}/locations/global/catalogs/${catalogId}/branches/${branchId}`
 *                                Please see {@see ProductServiceClient::branchName()} for help formatting this field.
 * @param string $filter          The filter string to specify the products to be deleted with a
 *                                length limit of 5,000 characters.
 *
 *                                Empty string filter is not allowed. "*" implies delete all items in a
 *                                branch.
 *
 *                                The eligible fields for filtering are:
 *
 *                                * `availability`: Double quoted
 *                                [Product.availability][google.cloud.retail.v2.Product.availability] string.
 *                                * `create_time` : in ISO 8601 "zulu" format.
 *
 *                                Supported syntax:
 *
 *                                * Comparators (">", "<", ">=", "<=", "=").
 *                                Examples:
 *                                * create_time <= "2015-02-13T17:05:46Z"
 *                                * availability = "IN_STOCK"
 *
 *                                * Conjunctions ("AND")
 *                                Examples:
 *                                * create_time <= "2015-02-13T17:05:46Z" AND availability = "PREORDER"
 *
 *                                * Disjunctions ("OR")
 *                                Examples:
 *                                * create_time <= "2015-02-13T17:05:46Z" OR availability = "IN_STOCK"
 *
 *                                * Can support nested queries.
 *                                Examples:
 *                                * (create_time <= "2015-02-13T17:05:46Z" AND availability = "PREORDER")
 *                                OR (create_time >= "2015-02-14T13:03:32Z" AND availability = "IN_STOCK")
 *
 *                                * Filter Limits:
 *                                * Filter should not contain more than 6 conditions.
 *                                * Max nesting depth should not exceed 2 levels.
 *
 *                                Examples queries:
 *                                * Delete back order products created before a timestamp.
 *                                create_time <= "2015-02-13T17:05:46Z" OR availability = "BACKORDER"
 */
function purge_products_sample(string $formattedParent, string $filter): void
{
    // Create a client.
    $productServiceClient = new ProductServiceClient();

    // Prepare the request message.
    $request = (new PurgeProductsRequest())
        ->setParent($formattedParent)
        ->setFilter($filter);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $productServiceClient->purgeProducts($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var PurgeProductsResponse $result */
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
    $formattedParent = ProductServiceClient::branchName(
        '[PROJECT]',
        '[LOCATION]',
        '[CATALOG]',
        '[BRANCH]'
    );
    $filter = '[FILTER]';

    purge_products_sample($formattedParent, $filter);
}
// [END retail_v2_generated_ProductService_PurgeProducts_sync]
