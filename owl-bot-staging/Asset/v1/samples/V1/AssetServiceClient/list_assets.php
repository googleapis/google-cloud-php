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

// [START cloudasset_v1_generated_AssetService_ListAssets_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Asset\V1\Asset;
use Google\Cloud\Asset\V1\AssetServiceClient;

/**
 * Lists assets with time and resource types and returns paged results in
 * response.
 *
 * @param string $parent Name of the organization, folder, or project the assets belong
 *                       to. Format: "organizations/[organization-number]" (such as
 *                       "organizations/123"), "projects/[project-id]" (such as
 *                       "projects/my-project-id"), "projects/[project-number]" (such as
 *                       "projects/12345"), or "folders/[folder-number]" (such as "folders/12345").
 */
function list_assets_sample(string $parent): void
{
    // Create a client.
    $assetServiceClient = new AssetServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $assetServiceClient->listAssets($parent);

        /** @var Asset $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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

    list_assets_sample($parent);
}
// [END cloudasset_v1_generated_AssetService_ListAssets_sync]
