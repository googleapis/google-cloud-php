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

// [START visionai_v1_generated_Warehouse_UploadAsset_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VisionAI\V1\UploadAssetResponse;
use Google\Cloud\VisionAI\V1\WarehouseClient;
use Google\Rpc\Status;

/**
 * Upload asset by specifing the asset Cloud Storage uri.
 * For video warehouse, it requires users who call this API have read access
 * to the cloud storage file. Once it is uploaded, it can be retrieved by
 * GenerateRetrievalUrl API which by default, only can retrieve cloud storage
 * files from the same project of the warehouse. To allow retrieval cloud
 * storage files that are in a separate project, it requires to find the
 * vision ai service account (Go to IAM, check checkbox to show "Include
 * Google-provided role grants", search for "Cloud Vision AI Service Agent")
 * and grant the read access of the cloud storage files to that service
 * account.
 *
 * @param string $formattedName The resource name of the asset to upload.
 *                              Format:
 *                              `projects/{project_number}/locations/{location_id}/corpora/{corpus_id}/assets/{asset_id}`
 *                              Please see {@see WarehouseClient::assetName()} for help formatting this field.
 */
function upload_asset_sample(string $formattedName): void
{
    // Create a client.
    $warehouseClient = new WarehouseClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $warehouseClient->uploadAsset($formattedName);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var UploadAssetResponse $result */
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
    $formattedName = WarehouseClient::assetName(
        '[PROJECT_NUMBER]',
        '[LOCATION]',
        '[CORPUS]',
        '[ASSET]'
    );

    upload_asset_sample($formattedName);
}
// [END visionai_v1_generated_Warehouse_UploadAsset_sync]
