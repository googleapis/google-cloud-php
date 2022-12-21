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

// [START vision_v1_generated_ProductSearch_ImportProductSets_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Vision\V1\ImportProductSetsInputConfig;
use Google\Cloud\Vision\V1\ImportProductSetsResponse;
use Google\Cloud\Vision\V1\ProductSearchClient;
use Google\Rpc\Status;

/**
 * Asynchronous API that imports a list of reference images to specified
 * product sets based on a list of image information.
 *
 * The [google.longrunning.Operation][google.longrunning.Operation] API can be used to keep track of the
 * progress and results of the request.
 * `Operation.metadata` contains `BatchOperationMetadata`. (progress)
 * `Operation.response` contains `ImportProductSetsResponse`. (results)
 *
 * The input source of this method is a csv file on Google Cloud Storage.
 * For the format of the csv file please see
 * [ImportProductSetsGcsSource.csv_file_uri][google.cloud.vision.v1.ImportProductSetsGcsSource.csv_file_uri].
 *
 * @param string $formattedParent The project in which the ProductSets should be imported.
 *
 *                                Format is `projects/PROJECT_ID/locations/LOC_ID`. Please see
 *                                {@see ProductSearchClient::locationName()} for help formatting this field.
 */
function import_product_sets_sample(string $formattedParent): void
{
    // Create a client.
    $productSearchClient = new ProductSearchClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $inputConfig = new ImportProductSetsInputConfig();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $productSearchClient->importProductSets($formattedParent, $inputConfig);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ImportProductSetsResponse $result */
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
    $formattedParent = ProductSearchClient::locationName('[PROJECT]', '[LOCATION]');

    import_product_sets_sample($formattedParent);
}
// [END vision_v1_generated_ProductSearch_ImportProductSets_sync]
