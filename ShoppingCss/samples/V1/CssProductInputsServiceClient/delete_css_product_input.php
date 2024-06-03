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

// [START css_v1_generated_CssProductInputsService_DeleteCssProductInput_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Css\V1\Client\CssProductInputsServiceClient;
use Google\Shopping\Css\V1\DeleteCssProductInputRequest;

/**
 * Deletes a CSS Product input from your CSS Center account.
 *
 * After a delete it may take several minutes until the input is no longer
 * available.
 *
 * @param string $formattedName The name of the CSS product input resource to delete.
 *                              Format: accounts/{account}/cssProductInputs/{css_product_input}
 *                              Please see {@see CssProductInputsServiceClient::cssProductInputName()} for help formatting this field.
 */
function delete_css_product_input_sample(string $formattedName): void
{
    // Create a client.
    $cssProductInputsServiceClient = new CssProductInputsServiceClient();

    // Prepare the request message.
    $request = (new DeleteCssProductInputRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $cssProductInputsServiceClient->deleteCssProductInput($request);
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
    $formattedName = CssProductInputsServiceClient::cssProductInputName(
        '[ACCOUNT]',
        '[CSS_PRODUCT_INPUT]'
    );

    delete_css_product_input_sample($formattedName);
}
// [END css_v1_generated_CssProductInputsService_DeleteCssProductInput_sync]
