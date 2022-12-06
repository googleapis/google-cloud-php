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

// [START aiplatform_v1_generated_IndexEndpointService_UpdateIndexEndpoint_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\IndexEndpoint;
use Google\Cloud\AIPlatform\V1\IndexEndpointServiceClient;
use Google\Protobuf\FieldMask;

/**
 * Updates an IndexEndpoint.
 *
 * @param string $indexEndpointDisplayName The display name of the IndexEndpoint.
 *                                         The name can be up to 128 characters long and can consist of any UTF-8
 *                                         characters.
 */
function update_index_endpoint_sample(string $indexEndpointDisplayName): void
{
    // Create a client.
    $indexEndpointServiceClient = new IndexEndpointServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $indexEndpoint = (new IndexEndpoint())
        ->setDisplayName($indexEndpointDisplayName);
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var IndexEndpoint $response */
        $response = $indexEndpointServiceClient->updateIndexEndpoint($indexEndpoint, $updateMask);
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
    $indexEndpointDisplayName = '[DISPLAY_NAME]';

    update_index_endpoint_sample($indexEndpointDisplayName);
}
// [END aiplatform_v1_generated_IndexEndpointService_UpdateIndexEndpoint_sync]
