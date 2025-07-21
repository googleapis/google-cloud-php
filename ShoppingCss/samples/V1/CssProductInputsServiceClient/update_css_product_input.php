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

// [START css_v1_generated_CssProductInputsService_UpdateCssProductInput_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Css\V1\Client\CssProductInputsServiceClient;
use Google\Shopping\Css\V1\CssProductInput;
use Google\Shopping\Css\V1\UpdateCssProductInputRequest;

/**
 * Updates the existing Css Product input in your CSS Center account.
 *
 * After inserting, updating, or deleting a CSS Product input, it may take
 * several minutes before the processed Css Product can be retrieved.
 *
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
 */
function update_css_product_input_sample(
    string $cssProductInputRawProvidedId,
    string $cssProductInputContentLanguage,
    string $cssProductInputFeedLabel
): void {
    // Create a client.
    $cssProductInputsServiceClient = new CssProductInputsServiceClient();

    // Prepare the request message.
    $cssProductInput = (new CssProductInput())
        ->setRawProvidedId($cssProductInputRawProvidedId)
        ->setContentLanguage($cssProductInputContentLanguage)
        ->setFeedLabel($cssProductInputFeedLabel);
    $request = (new UpdateCssProductInputRequest())
        ->setCssProductInput($cssProductInput);

    // Call the API and handle any network failures.
    try {
        /** @var CssProductInput $response */
        $response = $cssProductInputsServiceClient->updateCssProductInput($request);
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
    $cssProductInputRawProvidedId = '[RAW_PROVIDED_ID]';
    $cssProductInputContentLanguage = '[CONTENT_LANGUAGE]';
    $cssProductInputFeedLabel = '[FEED_LABEL]';

    update_css_product_input_sample(
        $cssProductInputRawProvidedId,
        $cssProductInputContentLanguage,
        $cssProductInputFeedLabel
    );
}
// [END css_v1_generated_CssProductInputsService_UpdateCssProductInput_sync]
