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

// [START cloudasset_v1_generated_AssetService_DeleteFeed_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Asset\V1\AssetServiceClient;

/**
 * Deletes an asset feed.
 *
 * @param string $formattedName The name of the feed and it must be in the format of:
 *                              projects/project_number/feeds/feed_id
 *                              folders/folder_number/feeds/feed_id
 *                              organizations/organization_number/feeds/feed_id
 *                              Please see {@see AssetServiceClient::feedName()} for help formatting this field.
 */
function delete_feed_sample(string $formattedName): void
{
    // Create a client.
    $assetServiceClient = new AssetServiceClient();

    // Call the API and handle any network failures.
    try {
        $assetServiceClient->deleteFeed($formattedName);
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
    $formattedName = AssetServiceClient::feedName('[PROJECT]', '[FEED]');

    delete_feed_sample($formattedName);
}
// [END cloudasset_v1_generated_AssetService_DeleteFeed_sync]
