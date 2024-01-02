<?php
/*
 * Copyright 2024 Google LLC
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

// [START cloudasset_v1_generated_AssetService_ExportAssets_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Asset\V1\AssetServiceClient;
use Google\Cloud\Asset\V1\ExportAssetsResponse;
use Google\Cloud\Asset\V1\OutputConfig;
use Google\Rpc\Status;

/**
 * Exports assets with time and resource types to a given Cloud Storage
 * location/BigQuery table. For Cloud Storage location destinations, the
 * output format is newline-delimited JSON. Each line represents a
 * [google.cloud.asset.v1.Asset][google.cloud.asset.v1.Asset] in the JSON
 * format; for BigQuery table destinations, the output table stores the fields
 * in asset Protobuf as columns. This API implements the
 * [google.longrunning.Operation][google.longrunning.Operation] API, which
 * allows you to keep track of the export. We recommend intervals of at least
 * 2 seconds with exponential retry to poll the export operation result. For
 * regular-size resource parent, the export operation usually finishes within
 * 5 minutes.
 *
 * @param string $parent The relative name of the root asset. This can only be an
 *                       organization number (such as "organizations/123"), a project ID (such as
 *                       "projects/my-project-id"), or a project number (such as "projects/12345"),
 *                       or a folder number (such as "folders/123").
 */
function export_assets_sample(string $parent): void
{
    // Create a client.
    $assetServiceClient = new AssetServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $outputConfig = new OutputConfig();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $assetServiceClient->exportAssets($parent, $outputConfig);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ExportAssetsResponse $result */
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
    $parent = '[PARENT]';

    export_assets_sample($parent);
}
// [END cloudasset_v1_generated_AssetService_ExportAssets_sync]
