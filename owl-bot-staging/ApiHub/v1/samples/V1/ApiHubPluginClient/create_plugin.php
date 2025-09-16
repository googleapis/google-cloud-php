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

// [START apihub_v1_generated_ApiHubPlugin_CreatePlugin_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApiHub\V1\Client\ApiHubPluginClient;
use Google\Cloud\ApiHub\V1\CreatePluginRequest;
use Google\Cloud\ApiHub\V1\Plugin;

/**
 * Create an API Hub plugin resource in the API hub.
 * Once a plugin is created, it can be used to create plugin instances.
 *
 * @param string $formattedParent   The parent resource where this plugin will be created.
 *                                  Format: `projects/{project}/locations/{location}`. Please see
 *                                  {@see ApiHubPluginClient::locationName()} for help formatting this field.
 * @param string $pluginDisplayName The display name of the plugin. Max length is 50 characters
 *                                  (Unicode code points).
 */
function create_plugin_sample(string $formattedParent, string $pluginDisplayName): void
{
    // Create a client.
    $apiHubPluginClient = new ApiHubPluginClient();

    // Prepare the request message.
    $plugin = (new Plugin())
        ->setDisplayName($pluginDisplayName);
    $request = (new CreatePluginRequest())
        ->setParent($formattedParent)
        ->setPlugin($plugin);

    // Call the API and handle any network failures.
    try {
        /** @var Plugin $response */
        $response = $apiHubPluginClient->createPlugin($request);
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
    $formattedParent = ApiHubPluginClient::locationName('[PROJECT]', '[LOCATION]');
    $pluginDisplayName = '[DISPLAY_NAME]';

    create_plugin_sample($formattedParent, $pluginDisplayName);
}
// [END apihub_v1_generated_ApiHubPlugin_CreatePlugin_sync]
