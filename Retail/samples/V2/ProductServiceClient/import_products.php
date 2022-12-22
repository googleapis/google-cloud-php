<?php
/*
 * Copyright 2022 Google LLC
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

// [START retail_v2_generated_ProductService_ImportProducts_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Retail\V2\ImportProductsResponse;
use Google\Cloud\Retail\V2\ProductInputConfig;
use Google\Cloud\Retail\V2\ProductServiceClient;
use Google\Rpc\Status;

/**
 * Bulk import of multiple [Product][google.cloud.retail.v2.Product]s.
 *
 * Request processing may be synchronous.
 * Non-existing items are created.
 *
 * Note that it is possible for a subset of the
 * [Product][google.cloud.retail.v2.Product]s to be successfully updated.
 *
 * @param string $formattedParent Required.
 *                                `projects/1234/locations/global/catalogs/default_catalog/branches/default_branch`
 *
 *                                If no updateMask is specified, requires products.create permission.
 *                                If updateMask is specified, requires products.update permission. Please see
 *                                {@see ProductServiceClient::branchName()} for help formatting this field.
 */
function import_products_sample(string $formattedParent): void
{
    // Create a client.
    $productServiceClient = new ProductServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $inputConfig = new ProductInputConfig();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $productServiceClient->importProducts($formattedParent, $inputConfig);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ImportProductsResponse $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
        }
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
    $formattedParent = ProductServiceClient::branchName(
        '[PROJECT]',
        '[LOCATION]',
        '[CATALOG]',
        '[BRANCH]'
    );

    import_products_sample($formattedParent);
}
// [END retail_v2_generated_ProductService_ImportProducts_sync]
