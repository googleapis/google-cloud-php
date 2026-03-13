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

// [START visionai_v1_generated_Warehouse_ClipAsset_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\VisionAI\V1\ClipAssetResponse;
use Google\Cloud\VisionAI\V1\Partition\TemporalPartition;
use Google\Cloud\VisionAI\V1\WarehouseClient;

/**
 * Supported by STREAM_VIDEO corpus type.
 * Generates clips for downloading. The api takes in a time range, and
 * generates a clip of the first content available after start_time and
 * before end_time, which may overflow beyond these bounds.
 * Returned clips are truncated if the total size of the clips are larger
 * than 100MB.
 *
 * @param string $formattedName The resource name of the asset to request clips for.
 *                              Format:
 *                              `projects/{project_number}/locations/{location_id}/corpora/{corpus_id}/assets/{asset_id}`
 *                              Please see {@see WarehouseClient::assetName()} for help formatting this field.
 */
function clip_asset_sample(string $formattedName): void
{
    // Create a client.
    $warehouseClient = new WarehouseClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $temporalPartition = new TemporalPartition();

    // Call the API and handle any network failures.
    try {
        /** @var ClipAssetResponse $response */
        $response = $warehouseClient->clipAsset($formattedName, $temporalPartition);
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

    clip_asset_sample($formattedName);
}
// [END visionai_v1_generated_Warehouse_ClipAsset_sync]
