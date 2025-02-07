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

// [START merchantapi_v1beta_generated_MerchantReviewsService_DeleteMerchantReview_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Reviews\V1beta\Client\MerchantReviewsServiceClient;
use Google\Shopping\Merchant\Reviews\V1beta\DeleteMerchantReviewRequest;

/**
 * Deletes merchant review.
 *
 * @param string $formattedName The ID of the merchant review.
 *                              Format: accounts/{account}/merchantReviews/{merchantReview}
 *                              Please see {@see MerchantReviewsServiceClient::merchantReviewName()} for help formatting this field.
 */
function delete_merchant_review_sample(string $formattedName): void
{
    // Create a client.
    $merchantReviewsServiceClient = new MerchantReviewsServiceClient();

    // Prepare the request message.
    $request = (new DeleteMerchantReviewRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $merchantReviewsServiceClient->deleteMerchantReview($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = MerchantReviewsServiceClient::merchantReviewName('[ACCOUNT]', '[NAME]');

    delete_merchant_review_sample($formattedName);
}
// [END merchantapi_v1beta_generated_MerchantReviewsService_DeleteMerchantReview_sync]
