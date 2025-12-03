<?php
/*
 * Copyright 2025 Google LLC
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

// [START compute_v1_generated_TargetPools_TestIamPermissions_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Compute\V1\Client\TargetPoolsClient;
use Google\Cloud\Compute\V1\TestIamPermissionsTargetPoolRequest;
use Google\Cloud\Compute\V1\TestPermissionsRequest;
use Google\Cloud\Compute\V1\TestPermissionsResponse;

/**
 * Returns permissions that a caller has on the specified resource.
 *
 * @param string $project  Project ID for this request.
 * @param string $region   The name of the region for this request.
 * @param string $resource Name or id of the resource for this request.
 */
function test_iam_permissions_sample(string $project, string $region, string $resource): void
{
    // Create a client.
    $targetPoolsClient = new TargetPoolsClient();

    // Prepare the request message.
    $testPermissionsRequestResource = new TestPermissionsRequest();
    $request = (new TestIamPermissionsTargetPoolRequest())
        ->setProject($project)
        ->setRegion($region)
        ->setResource($resource)
        ->setTestPermissionsRequestResource($testPermissionsRequestResource);

    // Call the API and handle any network failures.
    try {
        /** @var TestPermissionsResponse $response */
        $response = $targetPoolsClient->testIamPermissions($request);
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
    $project = '[PROJECT]';
    $region = '[REGION]';
    $resource = '[RESOURCE]';

    test_iam_permissions_sample($project, $region, $resource);
}
// [END compute_v1_generated_TargetPools_TestIamPermissions_sync]
