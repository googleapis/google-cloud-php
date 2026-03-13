<?php
/*
 * Copyright 2026 Google LLC
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

// [START visionai_v1_generated_Warehouse_UpdateSearchConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\VisionAI\V1\SearchConfig;
use Google\Cloud\VisionAI\V1\WarehouseClient;

/**
 * Updates a search configuration inside a corpus.
 *
 * Please follow the rules below to create a valid UpdateSearchConfigRequest.
 * --- General Rules ---
 * 1. Request.search_configuration.name must already exist.
 * 2. Request must contain at least one non-empty search_criteria_property or
 * facet_property.
 * 3. mapped_fields must not be empty, and must map to existing UGA keys.
 * 4. All mapped_fields must be of the same type.
 * 5. All mapped_fields must share the same granularity.
 * 6. All mapped_fields must share the same semantic SearchConfig match
 * options.
 * For property-specific rules, please reference the comments for
 * FacetProperty and SearchCriteriaProperty.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_search_config_sample(): void
{
    // Create a client.
    $warehouseClient = new WarehouseClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $searchConfig = new SearchConfig();

    // Call the API and handle any network failures.
    try {
        /** @var SearchConfig $response */
        $response = $warehouseClient->updateSearchConfig($searchConfig);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END visionai_v1_generated_Warehouse_UpdateSearchConfig_sync]
