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

// [START merchantapi_v1beta_generated_ProductReviewsService_InsertProductReview_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Reviews\V1beta\Client\ProductReviewsServiceClient;
use Google\Shopping\Merchant\Reviews\V1beta\InsertProductReviewRequest;
use Google\Shopping\Merchant\Reviews\V1beta\ProductReview;

/**
 * Inserts a product review.
 *
 * @param string $parent                       The account where the product review will be inserted.
 *                                             Format: accounts/{account}
 * @param string $productReviewProductReviewId The permanent, unique identifier for the product review in the
 *                                             publisher’s system.
 * @param string $dataSource                   Format:
 *                                             `accounts/{account}/dataSources/{datasource}`.
 */
function insert_product_review_sample(
    string $parent,
    string $productReviewProductReviewId,
    string $dataSource
): void {
    // Create a client.
    $productReviewsServiceClient = new ProductReviewsServiceClient();

    // Prepare the request message.
    $productReview = (new ProductReview())
        ->setProductReviewId($productReviewProductReviewId);
    $request = (new InsertProductReviewRequest())
        ->setParent($parent)
        ->setProductReview($productReview)
        ->setDataSource($dataSource);

    // Call the API and handle any network failures.
    try {
        /** @var ProductReview $response */
        $response = $productReviewsServiceClient->insertProductReview($request);
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
    $parent = '[PARENT]';
    $productReviewProductReviewId = '[PRODUCT_REVIEW_ID]';
    $dataSource = '[DATA_SOURCE]';

    insert_product_review_sample($parent, $productReviewProductReviewId, $dataSource);
}
// [END merchantapi_v1beta_generated_ProductReviewsService_InsertProductReview_sync]
