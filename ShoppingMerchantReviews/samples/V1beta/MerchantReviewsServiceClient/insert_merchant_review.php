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

// [START merchantapi_v1beta_generated_MerchantReviewsService_InsertMerchantReview_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Reviews\V1beta\Client\MerchantReviewsServiceClient;
use Google\Shopping\Merchant\Reviews\V1beta\InsertMerchantReviewRequest;
use Google\Shopping\Merchant\Reviews\V1beta\MerchantReview;
use Google\Shopping\Type\CustomAttribute;

/**
 * Inserts a review for your Merchant Center account. If the review
 * already exists, then the review is replaced with the new instance.
 *
 * @param string $parent                         The account where the merchant review will be inserted.
 *                                               Format: accounts/{account}
 * @param string $merchantReviewMerchantReviewId The user provided merchant review ID to uniquely identify the
 *                                               merchant review.
 * @param string $dataSource                     The data source of the
 *                                               [merchantreview](https://support.google.com/merchants/answer/7045996?sjid=5253581244217581976-EU)
 *                                               Format:
 *                                               `accounts/{account}/dataSources/{datasource}`.
 */
function insert_merchant_review_sample(
    string $parent,
    string $merchantReviewMerchantReviewId,
    string $dataSource
): void {
    // Create a client.
    $merchantReviewsServiceClient = new MerchantReviewsServiceClient();

    // Prepare the request message.
    $merchantReviewCustomAttributes = [new CustomAttribute()];
    $merchantReview = (new MerchantReview())
        ->setMerchantReviewId($merchantReviewMerchantReviewId)
        ->setCustomAttributes($merchantReviewCustomAttributes);
    $request = (new InsertMerchantReviewRequest())
        ->setParent($parent)
        ->setMerchantReview($merchantReview)
        ->setDataSource($dataSource);

    // Call the API and handle any network failures.
    try {
        /** @var MerchantReview $response */
        $response = $merchantReviewsServiceClient->insertMerchantReview($request);
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
    $merchantReviewMerchantReviewId = '[MERCHANT_REVIEW_ID]';
    $dataSource = '[DATA_SOURCE]';

    insert_merchant_review_sample($parent, $merchantReviewMerchantReviewId, $dataSource);
}
// [END merchantapi_v1beta_generated_MerchantReviewsService_InsertMerchantReview_sync]
