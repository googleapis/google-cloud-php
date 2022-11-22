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

// [START cloudasset_v1_generated_AssetService_BatchGetEffectiveIamPolicies_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Asset\V1\AssetServiceClient;
use Google\Cloud\Asset\V1\BatchGetEffectiveIamPoliciesResponse;

/**
 * Gets effective IAM policies for a batch of resources.
 *
 * @param string $scope        Only IAM policies on or below the scope will be returned.
 *
 *                             This can only be an organization number (such as "organizations/123"), a
 *                             folder number (such as "folders/123"), a project ID (such as
 *                             "projects/my-project-id"), or a project number (such as "projects/12345").
 *
 *                             To know how to get organization id, visit [here
 *                             ](https://cloud.google.com/resource-manager/docs/creating-managing-organization#retrieving_your_organization_id).
 *
 *                             To know how to get folder or project id, visit [here
 *                             ](https://cloud.google.com/resource-manager/docs/creating-managing-folders#viewing_or_listing_folders_and_projects).
 * @param string $namesElement The names refer to the [full_resource_names]
 *                             (https://cloud.google.com/asset-inventory/docs/resource-name-format)
 *                             of [searchable asset
 *                             types](https://cloud.google.com/asset-inventory/docs/supported-asset-types#searchable_asset_types).
 *                             A maximum of 20 resources' effective policies can be retrieved in a batch.
 */
function batch_get_effective_iam_policies_sample(string $scope, string $namesElement): void
{
    // Create a client.
    $assetServiceClient = new AssetServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $names = [$namesElement,];

    // Call the API and handle any network failures.
    try {
        /** @var BatchGetEffectiveIamPoliciesResponse $response */
        $response = $assetServiceClient->batchGetEffectiveIamPolicies($scope, $names);
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
    $scope = '[SCOPE]';
    $namesElement = '[NAMES]';

    batch_get_effective_iam_policies_sample($scope, $namesElement);
}
// [END cloudasset_v1_generated_AssetService_BatchGetEffectiveIamPolicies_sync]
