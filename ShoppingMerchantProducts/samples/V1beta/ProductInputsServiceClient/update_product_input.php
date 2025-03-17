<?php
/*
 * Copyright 2025 Google LLC
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

// [START merchantapi_v1beta_generated_ProductInputsService_UpdateProductInput_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Products\V1beta\Client\ProductInputsServiceClient;
use Google\Shopping\Merchant\Products\V1beta\ProductInput;
use Google\Shopping\Merchant\Products\V1beta\UpdateProductInputRequest;

/**
 * Updates the existing product input in your Merchant Center account.
 *
 * After inserting, updating, or deleting a product input, it may take several
 * minutes before the processed product can be retrieved.
 *
 * @param string $productInputOfferId         Immutable. Your unique identifier for the product. This is the
 *                                            same for the product input and processed product. Leading and trailing
 *                                            whitespaces are stripped and multiple whitespaces are replaced by a single
 *                                            whitespace upon submission. See the [products data
 *                                            specification](https://support.google.com/merchants/answer/188494#id) for
 *                                            details.
 * @param string $productInputContentLanguage Immutable. The two-letter [ISO
 *                                            639-1](http://en.wikipedia.org/wiki/ISO_639-1) language code for the
 *                                            product.
 * @param string $productInputFeedLabel       Immutable. The [feed
 *                                            label](https://developers.google.com/shopping-content/guides/products/feed-labels)
 *                                            for the product.
 * @param string $dataSource                  The primary or supplemental product data source where
 *                                            `data_source` name identifies the product input to be updated.
 *
 *                                            Only API data sources are supported.
 *
 *                                            Format: `accounts/{account}/dataSources/{datasource}`.
 */
function update_product_input_sample(
    string $productInputOfferId,
    string $productInputContentLanguage,
    string $productInputFeedLabel,
    string $dataSource
): void {
    // Create a client.
    $productInputsServiceClient = new ProductInputsServiceClient();

    // Prepare the request message.
    $productInput = (new ProductInput())
        ->setOfferId($productInputOfferId)
        ->setContentLanguage($productInputContentLanguage)
        ->setFeedLabel($productInputFeedLabel);
    $request = (new UpdateProductInputRequest())
        ->setProductInput($productInput)
        ->setDataSource($dataSource);

    // Call the API and handle any network failures.
    try {
        /** @var ProductInput $response */
        $response = $productInputsServiceClient->updateProductInput($request);
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
    $productInputOfferId = '[OFFER_ID]';
    $productInputContentLanguage = '[CONTENT_LANGUAGE]';
    $productInputFeedLabel = '[FEED_LABEL]';
    $dataSource = '[DATA_SOURCE]';

    update_product_input_sample(
        $productInputOfferId,
        $productInputContentLanguage,
        $productInputFeedLabel,
        $dataSource
    );
}
// [END merchantapi_v1beta_generated_ProductInputsService_UpdateProductInput_sync]
