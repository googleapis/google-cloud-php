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

// [START cloudasset_v1_generated_AssetService_BatchGetAssetsHistory_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Asset\V1\BatchGetAssetsHistoryRequest;
use Google\Cloud\Asset\V1\BatchGetAssetsHistoryResponse;
use Google\Cloud\Asset\V1\Client\AssetServiceClient;
use Google\Cloud\Asset\V1\ContentType;
use Google\Cloud\Asset\V1\TimeWindow;

/**
 * Batch gets the update history of assets that overlap a time window.
 * For IAM_POLICY content, this API outputs history when the asset and its
 * attached IAM POLICY both exist. This can create gaps in the output history.
 * Otherwise, this API outputs history with asset in both non-delete or
 * deleted status.
 * If a specified asset does not exist, this API returns an INVALID_ARGUMENT
 * error.
 *
 * @param string $parent      The relative name of the root asset. It can only be an
 *                            organization number (such as "organizations/123"), a project ID (such as
 *                            "projects/my-project-id")", or a project number (such as "projects/12345").
 * @param int    $contentType Optional. The content type.
 */
function batch_get_assets_history_sample(string $parent, int $contentType): void
{
    // Create a client.
    $assetServiceClient = new AssetServiceClient();

    // Prepare the request message.
    $readTimeWindow = new TimeWindow();
    $request = (new BatchGetAssetsHistoryRequest())
        ->setParent($parent)
        ->setContentType($contentType)
        ->setReadTimeWindow($readTimeWindow);

    // Call the API and handle any network failures.
    try {
        /** @var BatchGetAssetsHistoryResponse $response */
        $response = $assetServiceClient->batchGetAssetsHistory($request);
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
    $parent = '[PARENT]';
    $contentType = ContentType::CONTENT_TYPE_UNSPECIFIED;

    batch_get_assets_history_sample($parent, $contentType);
}
// [END cloudasset_v1_generated_AssetService_BatchGetAssetsHistory_sync]
