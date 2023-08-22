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

// [START config_v1_generated_Config_GetResource_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Config\V1\Client\ConfigClient;
use Google\Cloud\Config\V1\GetResourceRequest;
use Google\Cloud\Config\V1\Resource;

/**
 * Gets details about a [Resource][google.cloud.config.v1.Resource] deployed
 * by Infra Manager.
 *
 * @param string $formattedName The name of the Resource in the format:
 *                              'projects/{project_id}/locations/{location}/deployments/{deployment}/revisions/{revision}/resource/{resource}'. Please see
 *                              {@see ConfigClient::resourceName()} for help formatting this field.
 */
function get_resource_sample(string $formattedName): void
{
    // Create a client.
    $configClient = new ConfigClient();

    // Prepare the request message.
    $request = (new GetResourceRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Resource $response */
        $response = $configClient->getResource($request);
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
    $formattedName = ConfigClient::resourceName(
        '[PROJECT]',
        '[LOCATION]',
        '[DEPLOYMENT]',
        '[REVISION]',
        '[RESOURCE]'
    );

    get_resource_sample($formattedName);
}
// [END config_v1_generated_Config_GetResource_sync]
