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

// [START recommendationengine_v1beta1_generated_CatalogService_ImportCatalogItems_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\RecommendationEngine\V1beta1\CatalogServiceClient;
use Google\Cloud\RecommendationEngine\V1beta1\ImportCatalogItemsResponse;
use Google\Cloud\RecommendationEngine\V1beta1\InputConfig;
use Google\Rpc\Status;

/**
 * Bulk import of multiple catalog items. Request processing may be
 * synchronous. No partial updating supported. Non-existing items will be
 * created.
 *
 * Operation.response is of type ImportResponse. Note that it is
 * possible for a subset of the items to be successfully updated.
 *
 * @param string $formattedParent `projects/1234/locations/global/catalogs/default_catalog`
 *                                Please see {@see CatalogServiceClient::catalogName()} for help formatting this field.
 */
function import_catalog_items_sample(string $formattedParent): void
{
    // Create a client.
    $catalogServiceClient = new CatalogServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $inputConfig = new InputConfig();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $catalogServiceClient->importCatalogItems($formattedParent, $inputConfig);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ImportCatalogItemsResponse $result */
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
    $formattedParent = CatalogServiceClient::catalogName('[PROJECT]', '[LOCATION]', '[CATALOG]');

    import_catalog_items_sample($formattedParent);
}
// [END recommendationengine_v1beta1_generated_CatalogService_ImportCatalogItems_sync]
