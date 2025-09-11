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

// [START apihub_v1_generated_ApiHubPlugin_UpdatePluginInstance_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApiHub\V1\Client\ApiHubPluginClient;
use Google\Cloud\ApiHub\V1\PluginInstance;
use Google\Cloud\ApiHub\V1\PluginInstanceAction;
use Google\Cloud\ApiHub\V1\UpdatePluginInstanceRequest;

/**
 * Updates a plugin instance in the API hub.
 * The following fields in the
 * [plugin_instance][google.cloud.apihub.v1.PluginInstance] can be updated
 * currently:
 *
 * * [display_name][google.cloud.apihub.v1.PluginInstance.display_name]
 * * [schedule_cron_expression][PluginInstance.actions.schedule_cron_expression]
 *
 * The
 * [update_mask][google.cloud.apihub.v1.UpdatePluginInstanceRequest.update_mask]
 * should be used to specify the fields being updated.
 *
 * To update the
 * [auth_config][google.cloud.apihub.v1.PluginInstance.auth_config] and
 * [additional_config][google.cloud.apihub.v1.PluginInstance.additional_config]
 * of the plugin instance, use the
 * [ApplyPluginInstanceConfig][google.cloud.apihub.v1.ApiHubPlugin.ApplyPluginInstanceConfig]
 * method.
 *
 * @param string $pluginInstanceDisplayName     The display name for this plugin instance. Max length is 255
 *                                              characters.
 * @param string $pluginInstanceActionsActionId This should map to one of the [action
 *                                              id][google.cloud.apihub.v1.PluginActionConfig.id] specified in
 *                                              [actions_config][google.cloud.apihub.v1.Plugin.actions_config] in the
 *                                              plugin.
 */
function update_plugin_instance_sample(
    string $pluginInstanceDisplayName,
    string $pluginInstanceActionsActionId
): void {
    // Create a client.
    $apiHubPluginClient = new ApiHubPluginClient();

    // Prepare the request message.
    $pluginInstanceAction = (new PluginInstanceAction())
        ->setActionId($pluginInstanceActionsActionId);
    $pluginInstanceActions = [$pluginInstanceAction,];
    $pluginInstance = (new PluginInstance())
        ->setDisplayName($pluginInstanceDisplayName)
        ->setActions($pluginInstanceActions);
    $request = (new UpdatePluginInstanceRequest())
        ->setPluginInstance($pluginInstance);

    // Call the API and handle any network failures.
    try {
        /** @var PluginInstance $response */
        $response = $apiHubPluginClient->updatePluginInstance($request);
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
    $pluginInstanceDisplayName = '[DISPLAY_NAME]';
    $pluginInstanceActionsActionId = '[ACTION_ID]';

    update_plugin_instance_sample($pluginInstanceDisplayName, $pluginInstanceActionsActionId);
}
// [END apihub_v1_generated_ApiHubPlugin_UpdatePluginInstance_sync]
