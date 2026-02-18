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

// [START visionai_v1_generated_Warehouse_GenerateRetrievalUrl_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\VisionAI\V1\GenerateRetrievalUrlResponse;
use Google\Cloud\VisionAI\V1\WarehouseClient;

/**
 * Generates a signed url for downloading the asset.
 * For video warehouse, please see comment of UploadAsset about how to allow
 * retrieval of cloud storage files in a different project.
 *
 * @param string $formattedName The resource name of the asset to request signed url for.
 *                              Format:
 *                              `projects/{project_number}/locations/{location_id}/corpora/{corpus_id}/assets/{asset_id}`
 *                              Please see {@see WarehouseClient::assetName()} for help formatting this field.
 */
function generate_retrieval_url_sample(string $formattedName): void
{
    // Create a client.
    $warehouseClient = new WarehouseClient();

    // Call the API and handle any network failures.
    try {
        /** @var GenerateRetrievalUrlResponse $response */
        $response = $warehouseClient->generateRetrievalUrl($formattedName);
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
    $formattedName = WarehouseClient::assetName(
        '[PROJECT_NUMBER]',
        '[LOCATION]',
        '[CORPUS]',
        '[ASSET]'
    );

    generate_retrieval_url_sample($formattedName);
}
// [END visionai_v1_generated_Warehouse_GenerateRetrievalUrl_sync]
