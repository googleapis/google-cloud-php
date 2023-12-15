<?php
/*
 * Copyright 2023 Google LLC
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

// [START css_v1_generated_CssProductInputsService_InsertCssProductInput_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Css\V1\Client\CssProductInputsServiceClient;
use Google\Shopping\Css\V1\CssProductInput;
use Google\Shopping\Css\V1\InsertCssProductInputRequest;

/**
 * Uploads a CssProductInput to your CSS Center account. If an
 * input with the same contentLanguage, identity, feedLabel and feedId already
 * exists, this method replaces that entry.
 *
 * After inserting, updating, or deleting a CSS Product input, it may
 * take several minutes before the processed CSS Product can be retrieved.
 *
 * @param string $formattedParent                The account where this CSS Product will be inserted.
 *                                               Format: accounts/{account}
 *                                               Please see {@see CssProductInputsServiceClient::accountName()} for help formatting this field.
 * @param string $cssProductInputRawProvidedId   Your unique identifier for the CSS Product. This is the same for
 *                                               the CSS Product input and processed CSS Product. We only allow ids with
 *                                               alphanumerics, underscores and dashes. See the [products feed
 *                                               specification](https://support.google.com/merchants/answer/188494#id) for
 *                                               details.
 * @param string $cssProductInputContentLanguage The two-letter [ISO
 *                                               639-1](http://en.wikipedia.org/wiki/ISO_639-1) language code for the CSS
 *                                               Product.
 * @param string $cssProductInputFeedLabel       The [feed
 *                                               label](https://developers.google.com/shopping-content/guides/products/feed-labels)
 *                                               for the CSS Product.
 *                                               Feed Label is synonymous to "target country" and hence should always be a
 *                                               valid region code. For example: 'DE' for Germany, 'FR' for France.
 * @param int    $feedId                         The primary or supplemental feed id. If CSS Product already
 *                                               exists and feed id provided is different, then the CSS Product will be
 *                                               moved to a new feed. Note: For now, CSSs do not need to provide feed ids as
 *                                               we create feeds on the fly. We do not have supplemental feed support for
 *                                               CSS Products yet.
 */
function insert_css_product_input_sample(
    string $formattedParent,
    string $cssProductInputRawProvidedId,
    string $cssProductInputContentLanguage,
    string $cssProductInputFeedLabel,
    int $feedId
): void {
    // Create a client.
    $cssProductInputsServiceClient = new CssProductInputsServiceClient();

    // Prepare the request message.
    $cssProductInput = (new CssProductInput())
        ->setRawProvidedId($cssProductInputRawProvidedId)
        ->setContentLanguage($cssProductInputContentLanguage)
        ->setFeedLabel($cssProductInputFeedLabel);
    $request = (new InsertCssProductInputRequest())
        ->setParent($formattedParent)
        ->setCssProductInput($cssProductInput)
        ->setFeedId($feedId);

    // Call the API and handle any network failures.
    try {
        /** @var CssProductInput $response */
        $response = $cssProductInputsServiceClient->insertCssProductInput($request);
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
    $formattedParent = CssProductInputsServiceClient::accountName('[ACCOUNT]');
    $cssProductInputRawProvidedId = '[RAW_PROVIDED_ID]';
    $cssProductInputContentLanguage = '[CONTENT_LANGUAGE]';
    $cssProductInputFeedLabel = '[FEED_LABEL]';
    $feedId = 0;

    insert_css_product_input_sample(
        $formattedParent,
        $cssProductInputRawProvidedId,
        $cssProductInputContentLanguage,
        $cssProductInputFeedLabel,
        $feedId
    );
}
// [END css_v1_generated_CssProductInputsService_InsertCssProductInput_sync]
