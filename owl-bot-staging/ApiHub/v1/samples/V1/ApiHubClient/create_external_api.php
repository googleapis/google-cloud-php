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

// [START apihub_v1_generated_ApiHub_CreateExternalApi_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApiHub\V1\Client\ApiHubClient;
use Google\Cloud\ApiHub\V1\CreateExternalApiRequest;
use Google\Cloud\ApiHub\V1\ExternalApi;

/**
 * Create an External API resource in the API hub.
 *
 * @param string $formattedParent        The parent resource for the External API resource.
 *                                       Format: `projects/{project}/locations/{location}`
 *                                       Please see {@see ApiHubClient::locationName()} for help formatting this field.
 * @param string $externalApiDisplayName Display name of the external API. Max length is 63 characters
 *                                       (Unicode Code Points).
 */
function create_external_api_sample(string $formattedParent, string $externalApiDisplayName): void
{
    // Create a client.
    $apiHubClient = new ApiHubClient();

    // Prepare the request message.
    $externalApi = (new ExternalApi())
        ->setDisplayName($externalApiDisplayName);
    $request = (new CreateExternalApiRequest())
        ->setParent($formattedParent)
        ->setExternalApi($externalApi);

    // Call the API and handle any network failures.
    try {
        /** @var ExternalApi $response */
        $response = $apiHubClient->createExternalApi($request);
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
    $formattedParent = ApiHubClient::locationName('[PROJECT]', '[LOCATION]');
    $externalApiDisplayName = '[DISPLAY_NAME]';

    create_external_api_sample($formattedParent, $externalApiDisplayName);
}
// [END apihub_v1_generated_ApiHub_CreateExternalApi_sync]
