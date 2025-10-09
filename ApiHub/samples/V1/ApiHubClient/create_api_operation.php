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

// [START apihub_v1_generated_ApiHub_CreateApiOperation_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApiHub\V1\ApiOperation;
use Google\Cloud\ApiHub\V1\Client\ApiHubClient;
use Google\Cloud\ApiHub\V1\CreateApiOperationRequest;

/**
 * Create an apiOperation in an API version.
 * An apiOperation can be created only if the version has no apiOperations
 * which were created by parsing a spec.
 *
 * @param string $formattedParent The parent resource for the operation resource.
 *                                Format:
 *                                `projects/{project}/locations/{location}/apis/{api}/versions/{version}`
 *                                Please see {@see ApiHubClient::versionName()} for help formatting this field.
 */
function create_api_operation_sample(string $formattedParent): void
{
    // Create a client.
    $apiHubClient = new ApiHubClient();

    // Prepare the request message.
    $apiOperation = new ApiOperation();
    $request = (new CreateApiOperationRequest())
        ->setParent($formattedParent)
        ->setApiOperation($apiOperation);

    // Call the API and handle any network failures.
    try {
        /** @var ApiOperation $response */
        $response = $apiHubClient->createApiOperation($request);
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
    $formattedParent = ApiHubClient::versionName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]');

    create_api_operation_sample($formattedParent);
}
// [END apihub_v1_generated_ApiHub_CreateApiOperation_sync]
