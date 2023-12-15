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

// [START css_v1_generated_CssProductsService_GetCssProduct_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Css\V1\Client\CssProductsServiceClient;
use Google\Shopping\Css\V1\CssProduct;
use Google\Shopping\Css\V1\GetCssProductRequest;

/**
 * Retrieves the processed CSS Product from your CSS Center account. After
 * inserting, updating, or deleting a product input, it may take several
 * minutes before the updated final product can be retrieved.
 *
 * @param string $formattedName The name of the CSS product to retrieve. Please see
 *                              {@see CssProductsServiceClient::cssProductName()} for help formatting this field.
 */
function get_css_product_sample(string $formattedName): void
{
    // Create a client.
    $cssProductsServiceClient = new CssProductsServiceClient();

    // Prepare the request message.
    $request = (new GetCssProductRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var CssProduct $response */
        $response = $cssProductsServiceClient->getCssProduct($request);
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
    $formattedName = CssProductsServiceClient::cssProductName('[ACCOUNT]', '[CSS_PRODUCT]');

    get_css_product_sample($formattedName);
}
// [END css_v1_generated_CssProductsService_GetCssProduct_sync]
