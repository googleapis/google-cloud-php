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

// [START merchantapi_v1_generated_ProductInputsService_DeleteProductInput_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\Products\V1\Client\ProductInputsServiceClient;
use Google\Shopping\Merchant\Products\V1\DeleteProductInputRequest;

/**
 * Deletes a product input from your Merchant Center account.
 *
 * After inserting, updating, or deleting a product input, it may take several
 * minutes before the processed product can be retrieved.
 *
 * @param string $formattedName The name of the product input resource to delete.
 *                              Format: `accounts/{account}/productInputs/{product}`
 *                              where the last section `product` consists of:
 *                              `content_language~feed_label~offer_id`
 *                              example for product name is
 *                              `accounts/123/productInputs/en~US~sku123`. Please see
 *                              {@see ProductInputsServiceClient::productInputName()} for help formatting this field.
 * @param string $dataSource    The primary or supplemental data source from which the product
 *                              input should be deleted. Format:
 *                              `accounts/{account}/dataSources/{datasource}`. For example,
 *                              `accounts/123456/dataSources/104628`.
 */
function delete_product_input_sample(string $formattedName, string $dataSource): void
{
    // Create a client.
    $productInputsServiceClient = new ProductInputsServiceClient();

    // Prepare the request message.
    $request = (new DeleteProductInputRequest())
        ->setName($formattedName)
        ->setDataSource($dataSource);

    // Call the API and handle any network failures.
    try {
        $productInputsServiceClient->deleteProductInput($request);
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
    $formattedName = ProductInputsServiceClient::productInputName('[ACCOUNT]', '[PRODUCTINPUT]');
    $dataSource = '[DATA_SOURCE]';

    delete_product_input_sample($formattedName, $dataSource);
}
// [END merchantapi_v1_generated_ProductInputsService_DeleteProductInput_sync]
