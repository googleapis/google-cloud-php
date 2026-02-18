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

// [START visionai_v1_generated_Warehouse_CreateSearchConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\VisionAI\V1\SearchConfig;
use Google\Cloud\VisionAI\V1\WarehouseClient;

/**
 * Creates a search configuration inside a corpus.
 *
 * Please follow the rules below to create a valid CreateSearchConfigRequest.
 * --- General Rules ---
 * 1. Request.search_config_id must not be associated with an existing
 * SearchConfig.
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
 * @param string $formattedParent The parent resource where this search configuration will be
 *                                created. Format:
 *                                `projects/{project_number}/locations/{location_id}/corpora/{corpus_id}`
 *                                Please see {@see WarehouseClient::corpusName()} for help formatting this field.
 * @param string $searchConfigId  ID to use for the new search config. Will become the final
 *                                component of the SearchConfig's resource name. This value should be up to
 *                                63 characters, and valid characters are /[a-z][0-9]-_/. The first character
 *                                must be a letter, the last could be a letter or a number.
 */
function create_search_config_sample(string $formattedParent, string $searchConfigId): void
{
    // Create a client.
    $warehouseClient = new WarehouseClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $searchConfig = new SearchConfig();

    // Call the API and handle any network failures.
    try {
        /** @var SearchConfig $response */
        $response = $warehouseClient->createSearchConfig($formattedParent, $searchConfig, $searchConfigId);
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
    $formattedParent = WarehouseClient::corpusName('[PROJECT_NUMBER]', '[LOCATION]', '[CORPUS]');
    $searchConfigId = '[SEARCH_CONFIG_ID]';

    create_search_config_sample($formattedParent, $searchConfigId);
}
// [END visionai_v1_generated_Warehouse_CreateSearchConfig_sync]
