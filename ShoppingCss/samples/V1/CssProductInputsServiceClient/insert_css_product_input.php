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
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function insert_css_product_input_sample(): void
{
    // Create a client.
    $cssProductInputsServiceClient = new CssProductInputsServiceClient();

    // Prepare the request message.
    $request = new InsertCssProductInputRequest();

    // Call the API and handle any network failures.
    try {
        /** @var CssProductInput $response */
        $response = $cssProductInputsServiceClient->insertCssProductInput($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END css_v1_generated_CssProductInputsService_InsertCssProductInput_sync]
