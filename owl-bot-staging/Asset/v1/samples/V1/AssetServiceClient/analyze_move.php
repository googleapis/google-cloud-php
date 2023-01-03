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

// [START cloudasset_v1_generated_AssetService_AnalyzeMove_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Asset\V1\AnalyzeMoveResponse;
use Google\Cloud\Asset\V1\AssetServiceClient;

/**
 * Analyze moving a resource to a specified destination without kicking off
 * the actual move. The analysis is best effort depending on the user's
 * permissions of viewing different hierarchical policies and configurations.
 * The policies and configuration are subject to change before the actual
 * resource migration takes place.
 *
 * @param string $resource          Name of the resource to perform the analysis against.
 *                                  Only GCP Project are supported as of today. Hence, this can only be Project
 *                                  ID (such as "projects/my-project-id") or a Project Number (such as
 *                                  "projects/12345").
 * @param string $destinationParent Name of the GCP Folder or Organization to reparent the target
 *                                  resource. The analysis will be performed against hypothetically moving the
 *                                  resource to this specified desitination parent. This can only be a Folder
 *                                  number (such as "folders/123") or an Organization number (such as
 *                                  "organizations/123").
 */
function analyze_move_sample(string $resource, string $destinationParent): void
{
    // Create a client.
    $assetServiceClient = new AssetServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var AnalyzeMoveResponse $response */
        $response = $assetServiceClient->analyzeMove($resource, $destinationParent);
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
    $resource = '[RESOURCE]';
    $destinationParent = '[DESTINATION_PARENT]';

    analyze_move_sample($resource, $destinationParent);
}
// [END cloudasset_v1_generated_AssetService_AnalyzeMove_sync]
