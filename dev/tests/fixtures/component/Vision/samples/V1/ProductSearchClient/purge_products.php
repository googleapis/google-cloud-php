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

// [START vision_v1_generated_ProductSearch_PurgeProducts_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Vision\V1\ProductSearchClient;
use Google\Rpc\Status;

/**
 * Asynchronous API to delete all Products in a ProductSet or all Products
 * that are in no ProductSet.
 *
 * If a Product is a member of the specified ProductSet in addition to other
 * ProductSets, the Product will still be deleted.
 *
 * It is recommended to not delete the specified ProductSet until after this
 * operation has completed. It is also recommended to not add any of the
 * Products involved in the batch delete to a new ProductSet while this
 * operation is running because those Products may still end up deleted.
 *
 * It's not possible to undo the PurgeProducts operation. Therefore, it is
 * recommended to keep the csv files used in ImportProductSets (if that was
 * how you originally built the Product Set) before starting PurgeProducts, in
 * case you need to re-import the data after deletion.
 *
 * If the plan is to purge all of the Products from a ProductSet and then
 * re-use the empty ProductSet to re-import new Products into the empty
 * ProductSet, you must wait until the PurgeProducts operation has finished
 * for that ProductSet.
 *
 * The [google.longrunning.Operation][google.longrunning.Operation] API can be used to keep track of the
 * progress and results of the request.
 * `Operation.metadata` contains `BatchOperationMetadata`. (progress)
 *
 * @param string $formattedParent The project and location in which the Products should be deleted.
 *
 *                                Format is `projects/PROJECT_ID/locations/LOC_ID`. Please see
 *                                {@see ProductSearchClient::locationName()} for help formatting this field.
 */
function purge_products_sample(string $formattedParent): void
{
    // Create a client.
    $productSearchClient = new ProductSearchClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $productSearchClient->purgeProducts($formattedParent);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
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
    $formattedParent = ProductSearchClient::locationName('[PROJECT]', '[LOCATION]');

    purge_products_sample($formattedParent);
}
// [END vision_v1_generated_ProductSearch_PurgeProducts_sync]
