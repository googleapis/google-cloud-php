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

// [START merchantapi_v1_generated_ProductInputsService_InsertProductInput_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Products\V1\Client\ProductInputsServiceClient;
use Google\Shopping\Merchant\Products\V1\InsertProductInputRequest;
use Google\Shopping\Merchant\Products\V1\ProductInput;

/**
 * [Uploads a product input to your Merchant Center
 * account](/merchant/api/guides/products/overview#upload-product-input). You
 * must have a products [data
 * source](/merchant/api/guides/data-sources/overview) to be able to insert a
 * product. The unique identifier of the data source is passed as a query
 * parameter in the request URL.
 *
 * If a product input with the same contentLanguage, offerId, and dataSource
 * already exists, then the product input inserted by this method replaces
 * that entry.
 *
 * After inserting, updating, or deleting a product input, it may take several
 * minutes before the processed product can be retrieved.
 *
 * @param string $formattedParent             The account where this product will be inserted.
 *                                            Format: `accounts/{account}`
 *                                            Please see {@see ProductInputsServiceClient::accountName()} for help formatting this field.
 * @param string $productInputOfferId         Immutable. Your unique identifier for the product. This is the
 *                                            same for the product input and processed product. Leading and trailing
 *                                            whitespaces are stripped and multiple whitespaces are replaced by a single
 *                                            whitespace upon submission. See the [products data
 *                                            specification](https://support.google.com/merchants/answer/188494#id) for
 *                                            details.
 * @param string $productInputContentLanguage Immutable. The two-letter [ISO
 *                                            639-1](http://en.wikipedia.org/wiki/ISO_639-1) language code for the
 *                                            product.
 * @param string $productInputFeedLabel       Immutable. The feed label that lets you categorize and identify
 *                                            your products. The maximum allowed characters are 20, and the supported
 *                                            characters are `A-Z`, `0-9`, hyphen, and underscore. The feed label must
 *                                            not include any spaces. For more information, see [Using feed
 *                                            labels](//support.google.com/merchants/answer/14994087).
 * @param string $dataSource                  The primary or supplemental product data source name. If the
 *                                            product already exists and data source provided is different, then the
 *                                            product will be moved to a new data source. For more information, see
 *                                            [Overview of Data sources
 *                                            sub-API](/merchant/api/guides/data-sources/overview).
 *
 *                                            Only API data sources are supported.
 *
 *                                            Format: `accounts/{account}/dataSources/{datasource}`. For example,
 *                                            `accounts/123456/dataSources/104628`.
 */
function insert_product_input_sample(
    string $formattedParent,
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
    $request = (new InsertProductInputRequest())
        ->setParent($formattedParent)
        ->setProductInput($productInput)
        ->setDataSource($dataSource);

    // Call the API and handle any network failures.
    try {
        /** @var ProductInput $response */
        $response = $productInputsServiceClient->insertProductInput($request);
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
    $formattedParent = ProductInputsServiceClient::accountName('[ACCOUNT]');
    $productInputOfferId = '[OFFER_ID]';
    $productInputContentLanguage = '[CONTENT_LANGUAGE]';
    $productInputFeedLabel = '[FEED_LABEL]';
    $dataSource = '[DATA_SOURCE]';

    insert_product_input_sample(
        $formattedParent,
        $productInputOfferId,
        $productInputContentLanguage,
        $productInputFeedLabel,
        $dataSource
    );
}
// [END merchantapi_v1_generated_ProductInputsService_InsertProductInput_sync]
