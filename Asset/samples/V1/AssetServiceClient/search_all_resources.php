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

// [START cloudasset_v1_generated_AssetService_SearchAllResources_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Asset\V1\AssetServiceClient;
use Google\Cloud\Asset\V1\ResourceSearchResult;

/**
 * Searches all Cloud resources within the specified scope, such as a project,
 * folder, or organization. The caller must be granted the
 * `cloudasset.assets.searchAllResources` permission on the desired scope,
 * otherwise the request will be rejected.
 *
 * @param string $scope A scope can be a project, a folder, or an organization. The search is
 *                      limited to the resources within the `scope`. The caller must be granted the
 *                      [`cloudasset.assets.searchAllResources`](https://cloud.google.com/asset-inventory/docs/access-control#required_permissions)
 *                      permission on the desired scope.
 *
 *                      The allowed values are:
 *
 *                      * projects/{PROJECT_ID} (e.g., "projects/foo-bar")
 *                      * projects/{PROJECT_NUMBER} (e.g., "projects/12345678")
 *                      * folders/{FOLDER_NUMBER} (e.g., "folders/1234567")
 *                      * organizations/{ORGANIZATION_NUMBER} (e.g., "organizations/123456")
 */
function search_all_resources_sample(string $scope): void
{
    // Create a client.
    $assetServiceClient = new AssetServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $assetServiceClient->searchAllResources($scope);

        /** @var ResourceSearchResult $element */
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
    $scope = '[SCOPE]';

    search_all_resources_sample($scope);
}
// [END cloudasset_v1_generated_AssetService_SearchAllResources_sync]
