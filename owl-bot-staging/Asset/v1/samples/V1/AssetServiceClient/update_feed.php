<?php
/*
 * Copyright 2023 Google LLC
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

// [START cloudasset_v1_generated_AssetService_UpdateFeed_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Asset\V1\AssetServiceClient;
use Google\Cloud\Asset\V1\Feed;
use Google\Cloud\Asset\V1\FeedOutputConfig;
use Google\Protobuf\FieldMask;

/**
 * Updates an asset feed configuration.
 *
 * @param string $feedName The format will be
 *                         projects/{project_number}/feeds/{client-assigned_feed_identifier} or
 *                         folders/{folder_number}/feeds/{client-assigned_feed_identifier} or
 *                         organizations/{organization_number}/feeds/{client-assigned_feed_identifier}
 *
 *                         The client-assigned feed identifier must be unique within the parent
 *                         project/folder/organization.
 */
function update_feed_sample(string $feedName): void
{
    // Create a client.
    $assetServiceClient = new AssetServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $feedFeedOutputConfig = new FeedOutputConfig();
    $feed = (new Feed())
        ->setName($feedName)
        ->setFeedOutputConfig($feedFeedOutputConfig);
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var Feed $response */
        $response = $assetServiceClient->updateFeed($feed, $updateMask);
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
    $feedName = '[NAME]';

    update_feed_sample($feedName);
}
// [END cloudasset_v1_generated_AssetService_UpdateFeed_sync]
