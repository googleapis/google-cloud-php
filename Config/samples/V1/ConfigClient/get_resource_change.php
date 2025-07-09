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

// [START config_v1_generated_Config_GetResourceChange_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Config\V1\Client\ConfigClient;
use Google\Cloud\Config\V1\GetResourceChangeRequest;
use Google\Cloud\Config\V1\ResourceChange;

/**
 * Get a ResourceChange for a given preview.
 *
 * @param string $formattedName The name of the resource change to retrieve.
 *                              Format:
 *                              'projects/{project_id}/locations/{location}/previews/{preview}/resourceChanges/{resource_change}'. Please see
 *                              {@see ConfigClient::resourceChangeName()} for help formatting this field.
 */
function get_resource_change_sample(string $formattedName): void
{
    // Create a client.
    $configClient = new ConfigClient();

    // Prepare the request message.
    $request = (new GetResourceChangeRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var ResourceChange $response */
        $response = $configClient->getResourceChange($request);
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
    $formattedName = ConfigClient::resourceChangeName(
        '[PROJECT]',
        '[LOCATION]',
        '[PREVIEW]',
        '[RESOURCE_CHANGE]'
    );

    get_resource_change_sample($formattedName);
}
// [END config_v1_generated_Config_GetResourceChange_sync]
