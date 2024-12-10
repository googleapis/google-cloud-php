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

// [START merchantapi_v1beta_generated_ProductInputsService_InsertProductInput_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Products\V1beta\Client\ProductInputsServiceClient;
use Google\Shopping\Merchant\Products\V1beta\InsertProductInputRequest;
use Google\Shopping\Merchant\Products\V1beta\ProductInput;
use Google\Shopping\Type\Channel\ChannelEnum;

/**
 * Uploads a product input to your Merchant Center account. If an input
 * with the same contentLanguage, offerId, and dataSource already exists,
 * this method replaces that entry.
 *
 * After inserting, updating, or deleting a product input, it may take several
 * minutes before the processed product can be retrieved.
 *
 * @param string $formattedParent             The account where this product will be inserted.
 *                                            Format: accounts/{account}
 *                                            Please see {@see ProductInputsServiceClient::accountName()} for help formatting this field.
 * @param int    $productInputChannel         Immutable. The
 *                                            [channel](https://support.google.com/merchants/answer/7361332) of the
 *                                            product.
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
 * @param string $dataSource                  The primary or supplemental product data source name. If the
 *                                            product already exists and data source provided is different, then the
 *                                            product will be moved to a new data source. Format:
 *                                            `accounts/{account}/dataSources/{datasource}`.
 */
function insert_product_input_sample(
    string $formattedParent,
    int $productInputChannel,
    string $productInputOfferId,
    string $productInputContentLanguage,
    string $productInputFeedLabel,
    string $dataSource
): void {
    // Create a client.
    $productInputsServiceClient = new ProductInputsServiceClient();

    // Prepare the request message.
    $productInput = (new ProductInput())
        ->setChannel($productInputChannel)
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
    $productInputChannel = ChannelEnum::CHANNEL_ENUM_UNSPECIFIED;
    $productInputOfferId = '[OFFER_ID]';
    $productInputContentLanguage = '[CONTENT_LANGUAGE]';
    $productInputFeedLabel = '[FEED_LABEL]';
    $dataSource = '[DATA_SOURCE]';

    insert_product_input_sample(
        $formattedParent,
        $productInputChannel,
        $productInputOfferId,
        $productInputContentLanguage,
        $productInputFeedLabel,
        $dataSource
    );
}
// [END merchantapi_v1beta_generated_ProductInputsService_InsertProductInput_sync]
