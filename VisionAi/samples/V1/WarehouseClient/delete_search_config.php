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

// [START visionai_v1_generated_Warehouse_DeleteSearchConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\VisionAI\V1\WarehouseClient;

/**
 * Deletes a search configuration inside a corpus.
 *
 * For a DeleteSearchConfigRequest to be valid,
 * Request.search_configuration.name must already exist.
 *
 * @param string $formattedName The name of the search configuration to delete.
 *                              Format:
 *                              `projects/{project_number}/locations/{location}/corpora/{corpus}/searchConfigs/{search_config}`
 *                              Please see {@see WarehouseClient::searchConfigName()} for help formatting this field.
 */
function delete_search_config_sample(string $formattedName): void
{
    // Create a client.
    $warehouseClient = new WarehouseClient();

    // Call the API and handle any network failures.
    try {
        $warehouseClient->deleteSearchConfig($formattedName);
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
    $formattedName = WarehouseClient::searchConfigName(
        '[PROJECT_NUMBER]',
        '[LOCATION]',
        '[CORPUS]',
        '[SEARCH_CONFIG]'
    );

    delete_search_config_sample($formattedName);
}
// [END visionai_v1_generated_Warehouse_DeleteSearchConfig_sync]
